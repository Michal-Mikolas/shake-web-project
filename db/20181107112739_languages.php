<?php

use Phinx\Migration\AbstractMigration;

class Languages extends AbstractMigration
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
        $this->table('language')
            ->addColumn('key', 'string')->addIndex(['key'], ['unique' => TRUE])
            ->addColumn('name', 'string')
            ->addColumn('is_default', 'integer', [
                'length' => 1,
                'default' => 0,
            ])
            ->create();
    }
}
