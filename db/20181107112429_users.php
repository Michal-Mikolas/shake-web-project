<?php

use Phinx\Migration\AbstractMigration;

class Users extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('user_role')
            ->addColumn('key', 'string')->addIndex(['key'], ['unique' => TRUE])
            ->addColumn('name', 'string')
            ->create();

        $this->table('user')
            ->addColumn('email', 'string')->addIndex(['email'], ['unique' => TRUE])
            ->addColumn('password_hash', 'string')
            ->addColumn('name', 'string')
            ->addColumn('surname', 'string')
            ->addColumn('created', 'datetime')
            ->addColumn('active', 'integer', ['length' => 1])
            ->create();

        $this->table('user_2_role')
            ->addColumn('user_id', 'integer')->addForeignKey('user_id', 'user', 'id')
            ->addColumn('user_role_id', 'integer')->addForeignKey('user_role_id', 'user_role', 'id')
            ->create();
    }

}
