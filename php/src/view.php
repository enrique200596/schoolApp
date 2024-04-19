<?php
require_once 'componentController.php';

class View
{
    private array $viewComponents;
    private string $title;

    public function __construct(string $title)
    {
        $this->setTitle($title);
    }

    public function getViewComponents(string $optionViewComponent = '*'): array|Component
    {
        if ($optionViewComponent === '*') {
            return $this->viewComponents;
        } else {
            if ($this->checkComponent($optionViewComponent) === true) {
                return $this->viewComponents[$optionViewComponent];
            } else {
                return [];
            }
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setViewComponents(array $viewComponents): void
    {
        $this->viewComponents = $viewComponents;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function addComponent(string $componentName, Component $c)
    {
        $this->viewComponents[$componentName] = $c;
    }

    public function checkComponent(string $componentName)
    {
        return isset($this->viewComponents[$componentName]);
    }

    public function removeComponent(string $componentName)
    {
        if ($this->checkComponent($componentName) === true) {
            unset($this->viewComponents[$componentName]);
        }
    }


}
