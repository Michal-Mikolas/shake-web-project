<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use Shake;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends \App\Presenters\BasePresenter
{

    public function checkRequirements($element)
    {
        if (!$this->user->isInRole('admin')
            && !$this->user->isInRole('superadmin')
        ) {
            $this->backlink = $this->storeRequest();

            $this->flashMessage('app.base.missingPermissionError', 'warning');
            $this->redirect(':User:login');
        }
    }

}
