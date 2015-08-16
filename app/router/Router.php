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
		$router[] = new Route('homepage', 'Homepage:default');
		//$router[] = new Route('editovanie', 'Editovanie:default');
		//$router[] = new Route('<presenter>/<action>[/<id>]', 'Post:show');
		$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}

}
