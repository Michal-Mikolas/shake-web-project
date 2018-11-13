<?php
namespace App\Services;

use Nette;
use Nette\SmartObject;
use Nette\Application\UI\Form;
use Kdyby;
use Kdyby\Translation\Translator;


/**
 *
 */
class FormFactory
{
    use SmartObject;

    /** @var Translator */
    protected $translator;


    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }


    public function create($parent = NULL, $name = NULL)
    {
        $form = new Form($parent, $name);
        $form->setTranslator($this->translator);

        return $form;
    }
}
