<?php
require_once 'route.php';
require_once 'routeController.php';
require_once 'sessionController.php';
require_once 'user.php';
require_once 'view.php';
require_once 'viewController.php';

class App
{
    private Route $route;
    private RouteController $routeController;
    private SessionController $sessionController;
    private ViewController $viewController;

    public function __construct()
    {
        $this->route = new Route();
        $this->routeController = new RouteController();
        $this->initializeRoutes();
        $this->sessionController = new SessionController();
    }

    private function initializeRoutes()
    {
        $this->routeController->addRoute(new Route('', '', ''));
        $this->routeController->addRoute(new Route('error', 'accessDenied', ''));
        $this->routeController->addRoute(new Route('error', 'invalidRoute', ''));
        $this->routeController->addRoute(new Route('view', 'homeAdministrator', 'Administrator'));
        $this->routeController->addRoute(new Route('view', 'homeExecutive', 'Executive'));
        $this->routeController->addRoute(new Route('view', 'signIn', ''));
    }

    private function identifyRoute()
    {
        $this->route->identifyObject();
        $this->route->identifyProcess();
    }

    private function validateRoute()
    {
        return $this->routeController->checkRoute($this->route->getName());
    }

    private function redirectRoute(string $routeName)
    {
        if ($this->validateRoute($routeName) === false) {
            $routeName = 'error-invalidRoute';
        }
        header('Location: ' . $this->routeController->getRoute($routeName)->getUrl());
        die();
    }

    private function checkRouteAccessKey()
    {
        if (empty($this->route->getAccessKey()) === true) {
            return false;
        } else {
            return true;
        }
    }

    private function checkUserSession()
    {
        if ($this->sessionController->getData('user') === null) {
            return false;
        } else {
            return true;
        }
    }

    private function checkUserAccessKeyRouteAccessKey()
    {
        return password_verify($this->route->getaccessKey(), $this->sessionController->getData('user')->getAccessKey());
    }

    private function errorInvalidRoute()
    {
        echo "RUTA NO VALIDA";
    }

    private function nonExistentRoute()
    {
        echo "RUTA INEXISTENTE";
    }
    
    private function viewHome()
    {
        echo "RUTA HOME SIN SESION";
    }

    private function viewSignIn()
    {
        $this->viewController = new ViewController();
        $this->viewController->showView('signIn');
    }
    private function executeFunction(string $routeName)
    {
        switch ($routeName) {
            case 'error-invalidRoute':
                $this->errorInvalidRoute();
                die();

            case '-':
                $this->viewHome();
                die;

            case 'view-signIn':
                $this->viewSignIn();
                die();

            default:
                $this->nonExistentRoute();
                die();
        }
    }

    private function loadRoute()
    {
        $this->route = $this->routeController->getRoute($this->route->getName());
    }

    public function processRequest()
    {
        $this->identifyRoute();
        if ($this->validateRoute() === false) {
            $this->redirectRoute('error-invalidRoute');
        } else {
            $this->loadRoute();
            if ($this->checkRouteAccessKey() === true) {
                if ($this->checkUserSession() === true) {
                    if ($this->checkUserAccessKeyRouteAccessKey() === false) {
                        $this->redirectRoute('error-accessDenied');
                    } else {
                        echo "1";
                        $this->executeFunction($this->route->getFunction());
                    }
                } else {
                    $this->redirectRoute('view-signIn');
                }
            } else {
                $this->executeFunction($this->route->getFunction());
            }
        }
    }
}
