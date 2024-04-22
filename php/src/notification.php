<?php

class Notification
{
    private string $type;
    private string $title;
    private string $message;

    public function __construct(string $type = '', string $title = '', string $message = '')
    {
        $this->setType($type);
        $this->setTitle($title);
        $this->setMessage($message);
    }

    public function getType()
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }

    public function setMessage($message): void
    {
        $this->message = $message;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }
}