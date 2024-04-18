<?php
require_once 'view.php';
require_once 'component.php';

class ViewController
{
    private View $views;

    public function __construct()
    {
        $this->views = [];
    }

    private function addView(string $viewName, View $v)
    {
        $this->views[$viewName] = $v;
    }

    private function buildSignIn()
    {
        $v=new View('Iniciar sesión')
    }
}
