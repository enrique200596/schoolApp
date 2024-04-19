<?php
require_once 'view.php';
require_once 'component.php';

class ViewController
{
    private array $views;

    public function __construct()
    {
        $this->views = [];

        //CREACION DE VISTA NO DEFINIDA
        $v = new View(
            'Página no definida'
        );

        $v->addComponent(
            'doctype',
            new Component(
                '!DOCTYPE',
                [
                    'noKey' => 'html'
                ]
            )
        );

        $v->addComponent(
            'html',
            new Component(
                'html',
                [
                    'lang' => 'es'
                ]
            )
        );

        $v->getViewComponents(
            'html'
        )->addSubComponent(
            'head',
            new Component(
                'head'
            )
        );

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
        );

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
        );

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
        );

        $v->getViewComponents(
            'html'
        )->addSubComponent(
            'body',
            new Component(
                'body'
            )
        );

        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->addSubComponent(
            'header',
            new Component(
                'header'
            )
        );

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
        );

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
        );

        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->addSubComponent(
            'main',
            new Component(
                'main'
            )
        );

        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'main'
        )->addSubComponent(
            'p',
            new Component(
                'p',
                [],
                'La vista que solicita no está definida.'
            )
        );

        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'main'
        )->addSubComponent(
            'h3',
            new Component(
                'h2',
                [],
                'Opciones'
            )
        );

        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'main'
        )->addSubComponent(
            'ul',
            new Component(
                'ul'
            )
        );

        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'main'
        )->getSubComponents(
            'ul'
        )->addSubComponent(
            'liHome',
            new Component(
                'li'
            )
        );

        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'main'
        )->getSubComponents(
            'ul'
        )->getSubComponents(
            'liHome'
        )->addSubComponent(
            'a',
            new Component(
                'a',
                [
                    'href' => '#'
                ],
                'Volver a inicio'
            )
        );

        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->addSubComponent(
            'footer',
            new Component(
                'footer'
            )
        );

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
        );

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
        );

        $v->getViewComponents(
            'html'
        )->getSubComponents(
            'body'
        )->getSubComponents(
            'footer'
        )->getSubComponents(
            'ul'
        )->getSubComponents(
            'li'
        )->addSubComponent(
            'a',
            new Component(
                'a',
                [
                    'href' => '#'
                ],
                'Acerca de nosotros'
            )
        );
    }

    private function addView(string $viewName, View $v): void
    {
        $this->views[$viewName] = $v;
    }

    private function checkView(string $viewName)
    {
        return isset($this->views[$viewName]);
    }

    private function getView(string $viewName)
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
