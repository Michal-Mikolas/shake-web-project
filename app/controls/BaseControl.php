<?php
namespace App\Controls;

use Nette\Application\UI;

/**
 */
class BaseControl extends UI\Control
{

    public function __construct(
        $parent = NULL,
        $name = NULL
    ){
        parent::__construct($parent, $name);
    }

}
