<?php


namespace gradebook;


class Router
{
	protected static $routes = [];
	protected static $route = [];

	public static function add($regexp, $route = [])
	{
		self::$routes[$regexp] = $route;
	}

	public static function getRoutes()
	{
		return self::$routes;
	}

	public static function getRoute()
	{
		return self::$route;
	}

	public static function dispatch($url)
	{
		if ( self::matchRoute($url) ){
			$controllerName = self::$route["controller"]."Controller";
			$action = self::$route["action"]."Action";
			$prefix = self::$route["prefix"];
			$controller = "app\controllers\\{$prefix}{$controllerName}";
			if ( class_exists($controller) ){
				$controllerObject = new $controller(self::$route);
				if ( method_exists($controllerObject, $action) ){
					$controllerObject->$action();
					$controllerObject->getView();
				} else {
					throw new \Exception("Экшен $controllerName::$action не найден", 404);
				}
			} else {
				throw new \Exception("Контроллер $controllerName не найден", 404);
			}
		} else {
			throw new \Exception("Страница {$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']} не найдена", 404);
		}
	}

	protected static function matchRoute($url)
	{
		$url = self::removeGetString($url);
		foreach (self::$routes as $pattern => $route) {
			if ( preg_match("#{$pattern}#", $url, $matches) ){
				foreach ($matches as $key => $value) {
					if ( is_string($key) ){
						$route[$key] = $value;
					}
				}
				if ( !isset($route["action"]) ){
					$route["action"] = "index";
				}
				if ( !isset($route["prefix"]) ){
					$route["prefix"] = "";
				}
				else {
					$route["prefix"] .= "\\";
				}
				$route["controller"] = self::camelCase($route["controller"], true);
				$route["action"] = self::camelCase($route["action"]);
				self::$route = $route;
				return true;
			}
		}
		return false;
	}

	protected static function camelCase($string, $upperfirst = false)
	{
		$words = explode("-", $string);
		$out = "";
		foreach ($words as $key => $word) {
			if ($key != 0 or ($key == 0 and $upperfirst)) {
				$out .= ucfirst($word);
			}
			else {
				$out .= $word;
			}
		}
		return $out;
	}

	protected static function removeGetString($url)
	{
		$url = explode('&', $url, 2);
		if ( strpos($url[0], "=") === false ){
			return $url[0];
		} else return '';
	}
}