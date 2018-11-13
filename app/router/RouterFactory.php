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
	public static function createRouter()
	{
		$router = new RouteList;

		// AdminModule
		$router[] = $adminRouter = new RouteList('Admin');
		$adminRouter[] = new Route('[<locale=en en|cs|sk|pl>/]admin/<presenter>/<action>[/<id>]', 'Article:default');

		// Root
		$router[] = new Route('[<locale=en en|cs|sk|pl>/]<id>', 'Article:detail');
		$router[] = new Route('[<locale=en en|cs|sk|pl>/]<presenter>/<action>[/<id>]', 'Homepage:default');

		return $router;
	}

}
