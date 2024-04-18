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
            return $_SESSION[$dataName];
        } else {
            return null;
        }
    }

    private function checkData(string $dataName)
    {
        return isset($_SESSION['sinisterApp'][$dataName]);
    }
}
