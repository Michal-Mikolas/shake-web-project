<?php
namespace App\AdminModule\Presenters; 

use Shake;


/**
 * Base presenter for all AdminModule presenters.
 */
abstract class BasePresenter extends \App\Presenters\BasePresenter
{

	public function startup()
	{
		parent::startup();

		// Security
		if (!$this->user->isInRole('admin') && $this->name != 'Admin:Sign') {
			$this->redirect('Sign:in');
		}
	}

}
