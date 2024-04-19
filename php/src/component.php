<?php

class Component
{
    private string $tag;
    private array $attributes;
    private string $value;
    private array $subComponents;
    private string $html;

    public function __construct(string $tag, array $attributes = [], string $value = '', array $subComponents = [])
    {
        $this->setTag($tag);
        $this->setAttributes($attributes);
        $this->setValue($value);
        $this->setSubComponents($subComponents);
        $this->setHtml('');
    }

    private function getTag()
    {
        return $this->tag;
    }

    private function getAttributes()
    {
        return $this->attributes;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getSubComponents(string $subComponentName = '*'): array|Component
    {
        if ($subComponentName === '*') {
            return $this->subComponents;
        } else {
            if (isset($this->subComponents[$subComponentName]) === true) {
                return $this->subComponents[$subComponentName];
            } else {
                return [];
            }
        }
    }

    public function getHtml()
    {
        return $this->html;
    }

    private function setTag(string $tag)
    {
        $this->tag = $tag;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }

    public function setSubComponents(array $subComponents)
    {
        $this->subComponents = $subComponents;
    }

    private function setHtml(string $html)
    {
        $this->html = $html;
    }

    public function addSubComponent(string $subComponentName, Component $subComponent): void
    {
        $this->subComponents[$subComponentName] = $subComponent;
    }

    private function checkSubComponent(string $subComponentName): bool
    {
        return isset($this->subComponents[$subComponentName]);
    }

    public function removeSubComponent(string $subComponentName): void
    {
        if ($this->checkSubComponent($subComponentName) === true) {
            unset($this->subComponents[$subComponentName]);
        }
    }

    public function build(): void
    {
        $attributes = '';
        if (!empty($this->getAttributes()) === true) {
            foreach ($this->getAttributes() as $key => $value) {
                if ($key === 'noKey') {
                    $attributes = $attributes . ' ' . $value;
                } else {
                    $attributes = $attributes . ' ' . $key . '=' . $value;
                }
            }
        }
        $tag = $this->getTag();
        if ($tag === '!DOCTYPE' || $tag === 'input' || $tag === 'br' || $tag === 'hr' || $tag === 'meta') {
            $this->setHtml('<' . $tag . ' ' . $attributes . '>');
        } else {
            $value = '';
            if (!empty($this->getSubComponents()) === true) {
                foreach ($this->getSubComponents() as $key => $v) {
                    $v->build();
                    $value = $value . $v->getHtml();
                }
            } else {
                $value = $this->getValue();
            }
            $this->setHtml('<' . $tag . ' ' . $attributes . '>' . $value . '</' . $tag . '>');
        }
    }
}
