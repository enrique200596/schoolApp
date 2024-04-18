<?php
class App
{
    private $route;
    private $routes;
    private $sessionController;

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

    private function getSessionController(): SessionController
    {
        return $this->sessionController;
    }

    private function setSessionController($sessionController)
    {
        $this->sessionController = $sessionController;
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

    private function checkSessionController()
    {
        return $this->getSessionController() !== null;
    }

    private function checkUserSession()
    {
        if ($this->checkSessionController() === false) {
            $this->loadSessionController();
        }
    }

    private function checkRouteAccessControl(): bool
    {
        return $this->getRoute()->checkAcessControl();
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

            if ($this->checkUserAccessWithRouteAccessControl() === false) {
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

    private function checkUserAccessWithRouteAccessControl()
    {
        return password_verify($this->getUserAccessKey(),$this->getRoute()->getAccessKey());
    }

    private function getUserAccessKey()
    {
        if($this->checkSessionController()===false){
            $this->setSessionController(new SessionController());
        }
        $this->getSessionController()->getPasswordOfLoggedInUser();
    }
}
