<?php
class ViewController
{
    private $views;

    private function checkView(string $viewName)
    {
        return isset($this->views[$viewName]);
    }

    private function getView(string $viewName)
    {
        if ($this->checkView($viewName) === false) {
            $viewName = 'nonExistentView';
        }
        return $this->views[$viewName];
    }

    public function showView(string $viewName)
    {
        $this->getView($viewName)->build();
        $this->getView($viewName)->show();
    }
}
