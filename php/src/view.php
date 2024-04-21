<?php
require_once 'component.php';

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

    public function addComponent(string $componentName, Component $c): void
    {
        $this->viewComponents[$componentName] = $c;
    }

    public function checkComponent(string $componentName): bool
    {
        return isset($this->viewComponents[$componentName]);
    }

    public function removeComponent(string $componentName): void
    {
        if ($this->checkComponent($componentName) === true) {
            unset($this->viewComponents[$componentName]);
        }
    }

    public function show(): void
    {
        $page = '';
        foreach ($this->getViewComponents() as $component) {
            $component->build();
            $page = $page . $component->getHtml();
        }
        echo $page;
    }
}
