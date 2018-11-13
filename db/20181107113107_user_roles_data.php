<?php

use Phinx\Migration\AbstractMigration;

class UserRolesData extends AbstractMigration
{

    public function up()
    {
        $this->execute('INSERT INTO user_role(`key`, `name`) VALUES
            ("admin", "Admin"),
            ("user", "User")
        ');
    }


    public function down()
    {
        $this->execute("DELETE FROM user_role");
    }

}
