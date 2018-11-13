<?php

use Phinx\Migration\AbstractMigration;

class Articles extends AbstractMigration
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
        $this->table('article')
            ->addColumn('admin_name', 'string', ['null' => TRUE])
            ->create();

        $this->table('article_translation')
            ->addColumn('article_id', 'integer')->addForeignKey('article_id', 'article', 'id')
            ->addColumn('language_id', 'integer')->addForeignKey('language_id', 'language', 'id')
            ->addColumn('title', 'string')
            ->addColumn('title_slug', 'string')->addIndex(['title_slug'], ['unique' => TRUE])
            ->addColumn('content_html', 'text')
            ->create();
    }
}
