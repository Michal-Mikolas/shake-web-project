<?php
namespace App;

use Nette,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\SimpleRouter;


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
		$router = new RouteList();
		
		// Admin
		$router[] = $adminRouter = new RouteList('Admin');
		$adminRouter[] = new Route('admin/<presenter>/<action>[/<id>]', 'Homepage:default'); 
		
		// Front
		$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		
		return $router;
	}

}