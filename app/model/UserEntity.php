<?php
declare(strict_types=1);

namespace App\Model;

use Shake;
use Shake\Database\Orm\Entity;
use Nette;


/**
 */
class UserEntity extends Entity
{

    public function getRoles()
    {
        $roles = [];
        foreach ($this->related('user_2_role') as $join) {
            $roles[] = $join->role->key;
        }

        return $roles;
    }

}
