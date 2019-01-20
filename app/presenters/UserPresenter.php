<?php
declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Security\Identity;
use Nette\Application\UI\Form;
use Nette\Application\Responses\RedirectResponse;
use Nette\Forms\Controls\Button;
use Nette\Mail\Message;
use Nette\Security\AuthenticationException;
use Nette\Security\Passwords;
use Nette\Utils\ArrayHash;
use Nette\Utils\DateTime;
use Nette\Utils\FileSystem;
use Nette\Utils\Strings;

/**
 * User presenter.
 */
class UserPresenter extends BasePresenter
{

	protected function createComponentLoginForm($name)
	{
		$form = $this->formFactory->create($this, $name);
		$form->addText('email', 'app.user.email')
			->setRequired('app.base.mandatoryFieldError')
			->addRule(Form::PATTERN, 'app.user.emailFormatError.', '[a-zA-Z0-9_\-.]+@[a-zA-Z0-9_\-.]+');
		$form->addPassword('password', 'app.user.password')
			->setRequired('app.base.mandatoryFieldError')
			->addRule(Form::PATTERN, 'app.user.passwordFormatError', '.{6,}');
		$form->addCheckbox('remember', 'app.user.rememberLogin');
		$form->addSubmit('send', 'app.user.loginBtn');

		$form->onSuccess[] = array($this, 'sendLoginForm');
		return $form;
	}


	public function sendLoginForm(Form $form)
	{
		$values = $form->getValues();

		try {
			if ($values->remember) {
				$maxSeconds = ini_get('session.gc_maxlifetime');
				$maxDays = floor($maxSeconds / 60 / 60 / 24);
				$this->user->setExpiration("$maxDays days");
			}
			$this->user->login($values->email, $values->password);

			$this->restoreRequest($this->backlink);
			$this->redirect(':User:');

		} catch (Nette\Security\AuthenticationException $e) {
			$this->flashMessage('app.user.loginError', 'warning');
		}
	}

}
