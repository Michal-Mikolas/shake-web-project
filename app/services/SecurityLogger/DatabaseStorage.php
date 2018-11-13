<?php
namespace App\Services\SecurityLogger;

use Nette\Database;


/**
 * DatabaseStorage
 *
 * @author  Michal Mikoláš <nanuqcz@gmail.com>
 */
class DatabaseStorage implements IStorage
{
	/** @var Database\Context */
	private $database;


	/**
	 * @param Database\Context
	 */
	function __construct(Database\Context $database)
	{
		$this->database = $database;
	}



	/**
	 * @param array
	 * @return void
	 */
	public function create($values)
	{
		$this->database->table('security_log')->insert($values);
	}

}
