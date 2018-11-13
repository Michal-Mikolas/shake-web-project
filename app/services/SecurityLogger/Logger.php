<?php
namespace App\Services\SecurityLogger;

use Nette\Application,
	Nette\Http,
	Nette\Utils\DateTime,
	Nette\Security\User;


/**
 * Application Security Logger
 * Log all possibly dangerous actions.
 *
 * @author  Michal Mikoláš <nanuqcz@gmail.com>
 */
class Logger
{
	/** @var IStorage */
	protected $storage;

	/** @var Application\Application */
	protected $application;

	/** @var Http\Request */
	protected $httpRequest;


	public function __construct(IStorage $storage, Application\Application $application, Http\Request $httpRequest)
	{
		$this->storage = $storage;
		$this->application = $application;
		$this->httpRequest = $httpRequest;
	}


	public function run()
	{
		if ($this->shouldLog($this->getAppRequest())) {
			$this->log();
		}
	}


	public function log($description = NULL)
	{
		$values = $this->getValues($this->getAppRequest());
		$values = $this->restrictValues($values);

		$log = array(
			'user_id' => ($this->getUser() && $this->getUser()->isLoggedIn())
				? $this->getUser()->id
				: NULL,
			'path' => $this->getPath($this->getAppRequest()),
			'signal' => $this->getSignal($this->getAppRequest()),
			'description' => $description,
			'values' => $this->encodeValues($values),
			'url' => (string) $this->httpRequest->url,
			'created' => new DateTime,
			'ip' => $this->httpRequest->remoteAddress,
			'identity' => ($this->getUser() && $this->getUser()->isLoggedIn())
				? $this->encodeValues( $this->getUser()->getIdentity()->getData() )
				: NULL,
		);

		$this->storage->create($log);
	}


	/********************* INTERNAL *********************/


	public function getAppRequest()
	{
		$requests = $this->application->getRequests();

		return $requests[0];
	}


	public function getHttpRequest()
	{
		return $this->httpRequest;
	}


	public function getUser()
	{
		return $this->application->getPresenter()->getUser();
	}


	/**
	 * Check if is it usefull to log this request
	 * @param Request
	 * @param bool
	 */
	protected function shouldLog(Application\Request $appRequest)
	{
		/**/
		$path = $this->getPath($this->getAppRequest());
		if (strpos($path, ':unreadMessageCount')) {
			return FALSE;
		} else {
			return TRUE;
		}
		/**/

		$signal = $this->getSignal($appRequest);
		$formValues = $this->getValues($appRequest);

		return ($signal || $formValues || $_POST);
	}


	/**
	 * Clean values from sensitive informations (passwords etc.)
	 * @param array
	 * @return array
	 */
	protected function restrictValues($values = NULL)
	{
		// Prepare
		$values = $values?: array();
		if (!is_array($values))
			$values = iterator_to_array($values);

		// Restrict
		foreach ($values as $key => $value) {
			if (is_scalar($value)) {
				// end value
				if (strpos($key, 'pass') !== FALSE) {
					$values[$key] = str_repeat('*', strlen($value));
				}
			} else {
				// recursion
				$values[$key] = $this->restrictValues($value);
			}
		}

		return $values;
	}


	/**
	 * @param Application\Request
	 * @return void
	 */
	protected function getPath(Application\Request $appRequest)
	{
		return $appRequest->presenterName . ':' . $appRequest->parameters['action'];
	}


	/**
	 * @param Application\Request
	 * @return string|NULL
	 */
	protected function getSignal(Application\Request $appRequest)
	{
		$values = $this->getValues($appRequest);

		return @$appRequest->parameters['do']?: @$values['do']?: NULL;
	}


	/**
	 * @param Application\Request
	 * @return array|NULL
	 */
	protected function getValues(Application\Request $appRequest)
	{
		return $appRequest->post;
	}


	/**
	 * @param array
	 * @return string
	 */
	protected function encodeValues($values)
	{
		if (!$values) return NULL;

		return json_encode($values, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
	}

}
