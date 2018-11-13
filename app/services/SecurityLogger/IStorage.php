<?php
namespace App\Services\SecurityLogger;


/**
 * IStorage
 *
 * @author  Michal Mikoláš <nanuqcz@gmail.com>
 */
interface IStorage
{

	/**
	 * @param array
	 * @return void
	 */
	function create($values);

}
