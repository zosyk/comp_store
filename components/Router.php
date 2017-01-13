<?php


class Router
{

    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * returns request string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $uri = trim($_SERVER['REQUEST_URI'], '/');

            return $uri;
        }
    }

    public function run()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path) {

            if (preg_match("~$uriPattern~", $uri)) {

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);


                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);


                $actionName = 'action' . ucfirst(array_shift($segments));

                $controllerFilePath = ROOT . '/controllers/' . $controllerName . '.php';


                if (file_exists($controllerFilePath)) {
                    include_once($controllerFilePath);
                }

                $controllerObj = new $controllerName;

                $parameters = $segments;


                $resultMethod = call_user_func_array(array($controllerObj, $actionName), $parameters);

                if ($resultMethod != null) {
                    break;
                }
            }
        }
    }
}