<?php
class App
{
    private $route;
    private $routes;

    public function __construct()
    {
        $this->route = new Route();
        $this->routes = [];
        $this->initializeRoutes();
    }

    private function setRoute($route)
    {
        $this->route = $route;
    }

    private function getRoute(): Route
    {
        return $this->route;
    }

    private function setRoutes($routes)
    {
        $this->routes = $routes;
    }

    private function getRoutes($option = '*')
    {
        if ($option === '*') {
            return $this->routes;
        } else if ($option !== '*' && $option !== '' && $this->validateRoute($option) === true) {
            return $this->routes[$option];
        } else {
            return new Route('error', 'invalidRoute');
        }
    }

    private function loadRoute()
    {
        $this->setRoute($this->getRoutes($this->getRoute()->getName()));
    }

    public function execute(): void
    {
        $this->identifyRoute();
        if ($this->validateRoute($this->getRoute()->getName()) === false) {
            $this->redirectRoute('error-invalidRoute');
        } else {
            $this->loadRoute();
        }
        $this->checkUserSession();
        if ($this->checkRouteAccessControl() === true) {
            if ($this->checkUserAccessControlWithRouteAccessControl() === false) {
                $this->redirectRoute('error-accessDenied');
            }
        } else {
            if ($this->checkUserLogin() === true) {
                $this->redirectHomeRoute();
            }
        }
        $this->executeRouteFunction();
    }

    private function identifyRoute(): void
    {
        $this->getRoute()->identify();
    }

    private function validateRoute($routeName)
    {
        return isset($this->routes[$routeName]);
    }

    private function redirectRoute($routeName)
    {
        $url = '';
        if ($this->validateRoute($routeName) === true) {
            $url = $this->routes[$routeName]->getUrl();
        } else {
            $url = $this->getRoutes('error-invalidRoute')->getUrl();
        }
        header('Location: ' . $url);
        die();
    }

    private function addRoute($object, $process, $function)
    {
        $route = new Route($object, $process, $function);
        $this->routes[$route->getName()] = $route;
    }

    private function initializeRoutes()
    {
        $this->addRoute('error', 'invalidRoute', function () {
            echo "RUTA INVALIDA";
        });
    }
}
