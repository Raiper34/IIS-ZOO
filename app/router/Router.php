<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class Router
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function vytvoritRouter()
	{
		$router = new RouteList;
		$router[] = new Route('Homepage', 'Homepage:default');
		$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}

}
