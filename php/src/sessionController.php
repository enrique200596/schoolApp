<?php

class SessionController
{
    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
    }

    public function getPasswordOfLoggedInUser()
    {
        return $this->getData('user');
    }

    public function getData(string $dataName)
    {
        if ($this->checkData($dataName) === true) {
            return $_SESSION['sinisterApp'][$dataName];
        } else {
            return null;
        }
    }

    public function setData(string $dataName, mixed $data)
    {
        $_SESSION['sinisterApp'][$dataName] = $data;
    }

    private function checkData(string $dataName)
    {
        return isset($_SESSION['sinisterApp'][$dataName]);
    }

    public function removeData(string $dataName)
    {
        if ($this->checkData($dataName) === true) {
            unset($_SESSION['sinisterApp'][$dataName]);
        }
    }
}
