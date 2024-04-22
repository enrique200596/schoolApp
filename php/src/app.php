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
        $this->sessionController = new SessionController();
        $this->initializeRoutes();
        $this->sessionController->setData('routeController', $this->routeController);
    }

    private function initializeRoutes(): void
    {
        $this->routeController->addRoute(new Route('error', 'accessDenied', ''));
        $this->routeController->addRoute(new Route('error', 'invalidRoute', ''));
        $this->routeController->addRoute(new Route('error', 'signInEmailNotFound', ''));
        $this->routeController->addRoute(new Route('error', 'signInPasswordIncorrect', ''));
        $this->routeController->addRoute(new Route('error', 'signUp', ''));
        $this->routeController->addRoute(new Route('error', 'signUpPasswordVerify', ''));
        $this->routeController->addRoute(new Route('successful', 'signUp', ''));
        $this->routeController->addRoute(new Route('user', 'signIn', ''));
        $this->routeController->addRoute(new Route('user', 'signUp', ''));
        $this->routeController->addRoute(new Route('view', 'home', ''));
        $this->routeController->addRoute(new Route('view', 'homeAdministrator', 'Administrator'));
        $this->routeController->addRoute(new Route('view', 'homeExecutive', 'Executive'));
        $this->routeController->addRoute(new Route('view', 'signIn', ''));
        $this->routeController->addRoute(new Route('view', 'signUp', ''));
    }

    private function identifyRoute(): void
    {
        $this->route->identifyObject();
        $this->route->identifyProcess();
    }

    private function validateRoute(): bool
    {
        if ($this->route->getName() === '-') {
            $this->route->setObject('view');
            $this->route->setProcess('home');
        }
        return $this->routeController->checkRoute($this->route->getName());
    }

    private function redirectRoute(string $routeName): void
    {
        if ($this->validateRoute($routeName) === false) {
            $routeName = 'error-invalidRoute';
        }
        header('Location: ' . $this->routeController->getRoute($routeName)->getUrl());
        die();
    }

    private function checkRouteAccessKey(): bool
    {
        if (empty($this->route->getAccessKey()) === true) {
            return false;
        } else {
            return true;
        }
    }

    private function checkUserSession(): bool
    {
        if ($this->sessionController->getData('user') === null) {
            return false;
        } else {
            return true;
        }
    }

    private function checkUserAccessKeyRouteAccessKey(): bool
    {
        return password_verify($this->route->getaccessKey(), $this->sessionController->getData('user')->getAccessKey());
    }

    private function errorInvalidRoute(): void
    {
        echo "RUTA NO VALIDA";
    }

    private function userSignUp(): void
    {
        if ($_POST['password'] === $_POST['passwordVerify']) {
            $user = new User();
            $user->setName($_POST['name']);
            $user->setEmail($_POST['email']);
            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
            if ($user->store() === true) {
                $this->redirectRoute('successful-signUp');
            } else {
                $this->redirectRoute('error-signUp');
            }
        } else {
            $this->redirectRoute('error-signUpPasswordVerify');
        }
    }

    private function viewNonExistentRouteFunction(): void
    {
        $nc = new NotificationController();
        $nc->addNotification(
            'notificationView',
            'error',
            'Funcion de ruta inexistente',
            'No existe o no está declarado el método o la función de la ruta solicitada.');
        $this->viewController = new ViewController($this->routeController, $nc);
        $this->viewController->showView('notificationView');
    }

    private function viewHome()
    {
        $this->viewController = new ViewController($this->routeController, new NotificationController());
        $this->viewController->showView('homeWithoutSession');
    }

    private function viewSignIn()
    {
        $this->viewController = new ViewController($this->routeController, new NotificationController());
        $this->viewController->showView('signIn');
    }

    private function viewSignUp()
    {
        $this->viewController = new ViewController($this->routeController, new NotificationController());
        $this->viewController->showView('signUp');
    }

    private function executeFunction(string $routeName)
    {
        switch ($routeName) {
            case 'error-invalidRoute':
                $this->errorInvalidRoute();
                die();

            case 'error-signInEmailNotFound':
                $this->errorSignInEmailNotFound();
                die();

            case 'error-signInPasswordIncorrect':
                $this->errorSignInPasswordIncorrect();
                die();

            case 'error-signUp':
                $this->errorSignUp();
                die();

            case 'error-signUpPasswordVerify':
                $this->errorSignUpPasswordVerify();
                die();

            case 'successful-signUp':
                $this->viewSuccessfulSignUp();
                die();

            case 'user-signIn':
                $this->userSignIn();
                die();

            case 'user-signUp':
                $this->userSignUp();
                die();

            case 'view-home':
                $this->viewHome();
                die;

            case 'view-signIn':
                $this->viewSignIn();
                die();

            case 'view-signUp':
                $this->viewSignUp();
                die();

            default:
                $this->viewNonExistentRouteFunction();
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

    private function errorSignUpPasswordVerify()
    {
        $nc = new NotificationController();
        $nc->addNotification('spanSignUpPasswordVerify', 'error', '', 'Las contraseñas no coinciden.');
        $this->viewController = new ViewController($this->routeController, $nc);
        $this->viewController->showView('signUp');
    }

    private function viewSuccessfulSignUp(): void
    {
        $nc = new NotificationController();
        $nc->addNotification(
            'notificationView',
            'successfull',
            'Registro de usuario exitoso',
            'El usuario ha sido registrado con éxito, debes aguardar hasta que los administradores habiliten tu usuario.');
        $this->viewController = new ViewController($this->routeController, $nc);
        $this->viewController->showView('notificationView');
    }

    private function userSignIn()
    {
        $user = new User();
        $user->setEmail($_POST['email']);
        $result = $user->checkEmail();
        if ($result->num_rows > 0) {
            $result = $result->fetch_array();
            if (password_verify($_POST['password'], $result['password']) === true) {
                echo "ESTAS LOGUEADO";
            } else {
                $this->redirectRoute('error-signInPasswordIncorrect');
            }
        } else {
            $this->redirectRoute('error-signInEmailNotFound');
        }
    }

    private function errorSignUp()
    {
        $nc = new NotificationController();
        $nc->addNotification(
            'notificationView',
            'error',
            'Error en el registro de usuario',
            'El usuario no ha podido ser registrado con éxito porque hubo un error en el almacenamiento de los datos, intente en un para de horas o consulte con los administradores.');
        $this->viewController = new ViewController($this->routeController, $nc);
        $this->viewController->showView('notificationView');
    }

    private function errorSignInEmailNotFound()
    {
        $nc = new NotificationController();
        $nc->addNotification('spanSignInEmail', 'error', '', 'El correo electrónico no está registrado.');
        $this->viewController = new ViewController($this->routeController, $nc);
        $this->viewController->showView('signIn');
    }

    private function errorSignInPasswordIncorrect()
    {
        $nc = new NotificationController();
        $nc->addNotification('spanSignInPassword', 'error', '', 'La constraseña es incorrecta.');
        $this->viewController = new ViewController($this->routeController, $nc);
        $this->viewController->showView('signIn');
    }
}
