<?php
require_once 'route.php';

class RouteController
{
    private $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function addRoute(Route $r)
    {
        //Agrega una ruta a la lista de rutas de RouteController con su nombre de ruta.
        $this->routes[$r->getName()] = $r;
    }

    public function checkRoute(string $routeName)
    {
        //Devuelve TRUE si la ruta es válida y FALSE si no lo es.
        return isset($this->routes[$routeName]);
    }

    public function removeRoute(string $routeName)
    {
        //Remueve una ruta específica de la lista de rutas de RouteController.
        if ($this->checkRoute($routeName) === true)
            unset($this->routes[$routeName]);
    }

    public function getRoute(string $routeName): Route|NULL
    {
        /*
        Devuelve una ruta específica de la lista de rutas de RouteController;
        siempre que la ruta exista en la lista de rutas. De lo contrario, devuelve null.
        */
        if ($this->checkRoute($routeName) === true) {
            return $this->routes[$routeName];
        } else {
            return null;
        }
    }
}
