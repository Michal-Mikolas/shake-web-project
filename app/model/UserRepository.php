<?php
declare(strict_types=1);

namespace App\Model;

use Shake\Scaffolding\Repository;

/**
 */
class UserRepository extends Repository
{

    public function select()
    {
        return parent::select()
            ->select('CONCAT(name, " ", surname) AS fullname');
    }

}
