<?php
declare(strict_types=1);

namespace App\Router;

use Nette,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\RouteList;


/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList;
		$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}

}
