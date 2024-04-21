<?php
require_once 'view.php';
require_once 'component.php';
require_once 'sessionController.php';
require_once 'routeController.php';

class ViewController
{
    private array $views;

    public function __construct()
    {
        $this->views = [];
        $sc = new SessionController();
        $rc = $sc->getData('routeController');
        $sc->removeData('routeController');
        unset($sc);

        //CREACION DE VISTA NO DEFINIDA
        $c = new Component('main');
        $c->addSubComponent(
            'p',
            new Component(
                'p',
                [],
                'La vista que solicita no está definida.'
            )
        ); //p
        $c->addSubComponent(
            'h3',
            new Component(
                'h3',
                [],
                'Opciones'
            )
        ); //h3
        $c->addSubComponent(
            'ul',
            new Component(
                'ul'
            )
        ); //ul
        $c->getSubComponents(
            'ul'
        )->addSubComponent(
            'li1',
            new Component(
                'li'
            )
        ); //li1
        $c->getSubComponents(
            'ul'
        )->getSubComponents(
            'li1'
        )->addSubComponent(
            'aHome',
            new Component(
                'a',
                [
                    'href' => $rc->getRoute('view-home')->getUrl()
                ],
                'Volver a inicio'
            )
        ); //aHome
        $this->addView('notFoundView', 'Vista no encontrada', $c);

        //CREACION DE VISTA DE INICIO SIN INICIAR SESION
        $c = new Component('main');
        $c->addSubComponent(
            'h3',
            new Component(
                'h3',
                [],
                'Opciones:'
            )
        ); //h3
        $c->addSubComponent(
            'ul',
            new Component(
                'ul'
            )
        ); //ul
        $c->getSubComponents(
            'ul'
        )->addSubComponent(
            'li1',
            new Component(
                'li'
            )
        ); //li1
        $c->getSubComponents(
            'ul'
        )->getSubComponents(
            'li1'
        )->addSubComponent(
            'aHome',
            new Component(
                'a',
                [
                    'href' => $rc->getRoute('view-home')->getUrl()
                ],
                'Inicio'
            )
        ); //aHome
        $c->getSubComponents(
            'ul'
        )->addSubComponent(
            'li2',
            new Component(
                'li'
            )
        ); //li2
        $c->getSubComponents(
            'ul'
        )->getSubComponents(
            'li2'
        )->addSubComponent(
            'aSignIn',
            new Component(
                'a',
                [
                    'href' => $rc->getRoute('view-signIn')->getUrl()
                ],
                'Iniciar sesión'
            )
        ); //aSignIn
        $c->getSubComponents(
            'ul'
        )->addSubComponent(
            'li3',
            new Component(
                'li'
            )
        ); //li3
        $c->getSubComponents(
            'ul'
        )->getSubComponents(
            'li3'
        )->addSubComponent(
            'aRegisterUser',
            new Component(
                'a',
                [
                    'href' => $rc->getRoute('view-signUp')->getUrl()
                ],
                'Registrarse'
            )
        ); //aRegisterUser
        $c->addSubComponent(
            'p',
            new Component(
                'p',
                [],
                'Bienvenido a SinisterApp, la mejor aplicación para poder gestionar siniestros vehiculares.'
            )
        ); //p
        $this->addView('homeWithoutSession', 'Inicio', $c);

        //CREACION DE VISTA INICIAR SESION
        $c = new Component('main');
        $c->addSubComponent(
            'h3',
            new Component(
                'h3',
                [],
                'Opciones:'
            )
        ); //h3
        $c->addSubComponent(
            'ul',
            new Component(
                'ul'
            )
        ); //ul
        $c->getSubComponents(
            'ul'
        )->addSubComponent(
            'li1',
            new Component(
                'li'
            )
        ); //li1
        $c->getSubComponents(
            'ul'
        )->getSubComponents(
            'li1'
        )->addSubComponent(
            'aHome',
            new Component(
                'a',
                [
                    'href' => $rc->getRoute('view-home')->getUrl()
                ],
                'Volver a inicio'
            )
        ); //aHome
        $c->getSubComponents(
            'ul'
        )->addSubComponent(
            'li2',
            new Component(
                'li'
            )
        ); //li2
        $c->getSubComponents(
            'ul'
        )->getSubComponents(
            'li2'
        )->addSubComponent(
            'aRegisterUser',
            new Component(
                'a',
                [
                    'href' => $rc->getRoute('view-signUp')->getUrl()
                ],
                'Registrarse'
            )
        ); //aRegisterUser
        $c->addSubComponent(
            'p',
            new Component(
                'p',
                [],
                'Para iniciar sesiòn debes rellenar el siguiente formulario.'
            )
        ); //p
        $c->addSubComponent(
            'form',
            new Component(
                'form',
                [
                    'method' => 'POST',
                    'action' => $rc->getRoute('user-signIn')->getUrl()
                ]
            )); //form
        $c->getSubComponents(
            'form'
        )->addSubComponent(
            'sectionEmail',
            new Component(
                'section',
                [
                    'id' => 'sectionEmail'
                ]
            )
        ); //sectionEmail
        $c->getSubComponents(
            'form'
        )->getSubComponents(
            'sectionEmail'
        )->addSubComponent(
            'label',
            new Component(
                'label',
                [
                    'for' => 'inputEmail'
                ],
                'Correo electrónico'
            )
        ); //label
        $c->getSubComponents(
            'form'
        )->getSubComponents(
            'sectionEmail'
        )->addSubComponent(
            'input',
            new Component(
                'input',
                [
                    'type' => 'email',
                    'name' => 'email',
                    'id' => 'inputEmail'
                ]
            )
        ); //input
        $c->getSubComponents(
            'form'
        )->getSubComponents(
            'sectionEmail'
        )->addSubComponent(
            'span',
            new Component(
                'span',
                [],
                'Notificación de email'
            )
        ); //span
        $c->getSubComponents(
            'form'
        )->addSubComponent(
            'sectionPassword',
            new Component(
                'section',
                [
                    'id' => 'sectionPassword'
                ]
            )
        ); //sectionPassword
        $c->getSubComponents(
            'form'
        )->getSubComponents(
            'sectionPassword'
        )->addSubComponent(
            'label',
            new Component(
                'label',
                [
                    'for' => 'inputPassword'
                ],
                'Contraseña'
            )
        ); //label
        $c->getSubComponents(
            'form'
        )->getSubComponents(
            'sectionPassword'
        )->addSubComponent(
            'input',
            new Component(
                'input',
                [
                    'type' => 'password',
                    'name' => 'password',
                    'id' => 'inputPassword'
                ]
            )
        ); //input
        $c->getSubComponents(
            'form'
        )->getSubComponents(
            'sectionPassword'
        )->addSubComponent(
            'span',
            new Component(
                'span',
                [],
                'Notificación de password'
            )
        ); //span
        $c->getSubComponents(
            'form'
        )->addSubComponent(
            'sectionRememberMe',
            new Component(
                'section',
                [
                    'id' => 'sectionRememberMe'
                ]
            )
        ); //sectionRememberMe
        $c->getSubComponents(
            'form'
        )->getSubComponents(
            'sectionRememberMe'
        )->addSubComponent(
            'input',
            new Component(
                'input',
                [
                    'type' => 'checkbox',
                    'name' => 'rememberMe',
                    'id' => 'inputRememberMe'
                ]
            )
        ); //input
        $c->getSubComponents(
            'form'
        )->getSubComponents(
            'sectionRememberMe'
        )->addSubComponent(
            'label',
            new Component(
                'label',
                [
                    'for' => 'inputRememberMe'
                ],
                'Recordarme en este dispositivo'
            )
        ); //label
        $c->getSubComponents(
            'form'
        )->addSubComponent(
            'input',
            new Component(
                'input',
                [
                    'type' => 'submit',
                    'value' => 'INICIAR SESION',
                ]
            )
        ); //input
        $this->addView('signIn', 'Iniciar sesiòn', $c);
    }

    private function addView(string $viewName, string $title, Component $mainContent): void
    {
        $v = new View(
            $title
        );
        $v->addComponent(
            'doctype',
            new Component(
                '!DOCTYPE',
                [
                    'noKey' => 'html'
                ]
            )
        ); //DOCTYPE
        $v->addComponent(
            'html',
            new Component(
                'html',
                [
                    'lang' => 'es'
                ]
            )
        ); //html
        $v->getViewComponents(
            'html'
        )->addSubComponent(
            'head',
            new Component(
                'head'
            )
        ); //head
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'head'
        )->addSubComponent(
            'meta1',
            new Component(
                'meta',
                [
                    'charset' => 'UTF-8'
                ]
            )
        ); //meta1
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'head'
        )->addSubComponent(
            'meta2',
            new Component(
                'meta',
                [
                    'name' => 'viewport',
                    'content' => 'width=device-width, initial-scale=1.0'
                ]
            )
        ); //meta2
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'head'
        )->addSubComponent(
            'title',
            new Component(
                'title',
                [],
                $v->getTitle()
            )
        ); //title
        $v->getViewComponents(
            'html'
        )->addSubComponent(
            'body',
            new Component(
                'body'
            )
        ); //body
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->addSubComponent(
            'header',
            new Component(
                'header'
            )
        ); //header
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'header'
        )->addSubComponent(
            'h1',
            new Component(
                'h1',
                [],
                strtoupper(
                    $v->getTitle()
                )
            )
        ); //h1
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'header'
        )->addSubComponent(
            'h2',
            new Component(
                'h2',
                [],
                'SinisterApp'
            )
        ); //h2
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->addSubComponent(
            'main',
            $mainContent
        ); //main
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->addSubComponent(
            'footer',
            new Component(
                'footer'
            )
        ); //footer
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'footer'
        )->addSubComponent(
            'ul',
            new Component(
                'ul'
            )
        ); //ul
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'footer'
        )->getSubComponents(
            'ul'
        )->addSubComponent(
            'li1',
            new Component(
                'li'
            )
        ); //li1
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'footer'
        )->getSubComponents(
            'ul'
        )->getSubComponents(
            'li1'
        )->addSubComponent(
            'aAboutUs',
            new Component(
                'a',
                [
                    'href' => '#'
                ],
                'Acerca de nosotros'
            )
        ); //aAboutUs
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'footer'
        )->getSubComponents(
            'ul'
        )->addSubComponent(
            'li2',
            new Component(
                'li'
            )
        ); //li2
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'footer'
        )->getSubComponents(
            'ul'
        )->getSubComponents(
            'li2'
        )->addSubComponent(
            'aContactUs',
            new Component(
                'a',
                [
                    'href' => '#'
                ],
                'Contáctanos'
            )
        ); //aContactUs
        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'footer'
        )->addSubComponent(
            'span',
            new Component(
                'span',
                [],
                'Illesoft © Derechos reservados'
            )
        ); //span
        $this->views[$viewName] = $v;
    }

    private function checkView(string $viewName)
    {
        return isset($this->views[$viewName]);
    }

    private function getView(string $viewName): View
    {
        if ($this->checkView($viewName) === false) {
            $viewName = 'notFoundView';
        }
        return $this->views[$viewName];
    }

    public function showView(string $viewName)
    {
        $this->getView($viewName)->show();
    }
}
