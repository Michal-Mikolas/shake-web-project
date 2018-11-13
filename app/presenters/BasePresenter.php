<?php
declare(strict_types=1);

namespace App\Presenters;

use Shake;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Shake\Scaffolding\ScaffoldingPresenter
{
	/** @persistent */
	public $locale = 'cs';

    /** @persistent @var string */
    public $backlink;

	/** @inject @var Kdyby\Translation\Translator */
	public $translator;


    public function startup()
    {
        parent::startup();

        // FlashCodes => JS & CSS version of FlashMessages (for JS events tracking etc.)
		$flashCodes = $this->getSession('flashCodes');
		$flashCodes->setExpiration('5 seconds');
		$flashCodes->codes = $flashCodes->codes?: [];
    }


    public function handleLogout()
    {
        $this->user->logout();

        $this->flashMessage('app.user.loggedOutMessage', 'success');
        $this->redirect(':Homepage:');
    }


    public function flashMessage($message, $type = 'default')
	{
		$message = $this->translator->translate($message);

		parent::flashMessage($message, $type);
	}


    public function flashCode($code)
    {
        $flashCodes = $this->getSession('flashCodes');
		$flashCodes->codes[] = $code;
    }

}
