<?php
class User
{
    private $name;
    private $email;
    private $password;
    private $accessKey;

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function setAccessKey(string $accessKey)
    {
        $this->accessKey = $accessKey;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getAccessKey()
    {
        return $this->accessKey;
    }

    public function store()
    {
        $conecction = new mysqli('db', 'root', '123456', 'sinister');
        $result = $conecction->query("INSERT INTO users (name, email, password) VALUES ('" . $this->getName() . "','" . $this->getEmail() . "','" . $this->getPassword() . "')");
        $conecction->close();
        return $result;
    }

    public function checkEmail()
    {
        $connection = new mysqli('db', 'root', '123456', 'sinister');
        $result = $connection->query("SELECT * FROM users WHERE email='" . $this->getEmail() . "'");
        $connection->close();
        return $result;
    }
}
