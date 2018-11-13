<?php

namespace App\AdminModule\Controls\ArticleForm;

use App\Services\FormFactory;
use Nette\DI;

/**
 */
class ControlFactory
{
    private $context;


    public function __construct(DI\Container $context)
    {
        $this->context = $context;
    }


    public function create($parent = NULL, $name = NULL)
    {
        $formControl = new Control(
            $parent,
            $name,
            $this->context->getByType('App\\Services\\FormFactory'),
            $this->context->getByType('App\\Model\\LanguageManager')
        );

        return $formControl;
    }

}
