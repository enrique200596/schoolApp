<?php
require_once 'component.php';

class View
{
    private $components;
    private $page;

    public function __construct(string $title)
    {
        $this->components = [];

        $this->addComponent('doctype', new Component('!DOCTYPE', ['noKey' => 'html']));

        $this->addComponent(
            'html',
            new Component('html', ['lang' => 'es'], '', [
                'head' => new Component('head', [], '', [
                    'metaCharset' => new Component('meta', ['charset' => 'UTF-8']),
                    'metaNameContent' => new Component('meta', ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']),
                    'title' => new Component('title', [], $title . ' - SinisterApp')
                ]),
                'body' => new Component('body', [], '', [
                    'header' => new Component('header', [], '', [
                        'h1' => new Component('h1', [], strtoupper($title)),
                        'h2' => new Component('h1', [], 'SinisterApp')
                    ]),
                    'main' => new Component('main'),
                    'footer' => new Component('footer')
                ])
            ])
        );
    }

    private function setPage(string $page)
    {
        $this->page = $page;
    }

    private function getPage()
    {
        return $this->page;
    }

    private function addComponent(string $componentName, Component $c)
    {
        $this->components[$componentName] = $c;
    }

    public function getComponent(string $componentName)
    {
        if (isset($this->components[$componentName]) === true) {
            return $this->components[$componentName];
        } else {
            return '';
        }
    }

    public function show()
    {
        echo $this->getPage();
    }
}
