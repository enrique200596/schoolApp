<?php
class Route
{
    private $object;
    private $process;
    private $function;
    private $accessKey;

    public function __construct(string $object = '', string $process = '', string $accessKey = '')
    {
        $this->setObject($object);
        $this->setProcess($process);
        $this->setFunction($object . '-' . $process);
        $this->setAccessKey($accessKey);
    }

    public function setObject(string $object)
    {
        //Define la propiedad 'object' de la ruta.
        $this->object = $object;
    }

    public function setProcess(string $process)
    {
        //Define la propiedad 'process' de la ruta.
        $this->process = $process;
    }

    public function setFunction(string $function)
    {
        //Define la propiedad 'function' de la ruta.
        $this->function = $function;
    }

    public function setAccessKey(string $accessKey)
    {
        //Define la propiedad 'accessKey' de la ruta.
        $this->accessKey = $accessKey;
    }

    public function getObject()
    {
        //Devuelve la propiedad 'object' de la ruta.
        return $this->object;
    }

    public function getProcess()
    {
        //Devuelve la propiedad 'process' de la ruta.
        return $this->process;
    }

    public function getFunction()
    {
        //Devuelve la propiedad 'function' de la ruta.
        return $this->function;
    }

    public function getaccessKey()
    {
        //Devuelve la propiedad 'accessKey' de la ruta.
        return $this->accessKey;
    }

    public function identifyObject(): void
    {
        //Verifica si existe la variable $_GET['object']
        if (isset($_GET['object']) === true) {
            //Si existe lo guarda en la propiedad 'object' de la ruta.
            $this->setObject($_GET['object']);
        }
    }

    public function identifyProcess(): void
    {
        //Verifica si existe la variable $_GET['process']
        if (isset($_GET['process']) === true) {
            //Si existe lo guarda en la propiedad 'process' de la ruta.
            $this->setProcess($_GET['process']);
        }
    }

    public function getName(): string
    {
        //Devuelve el nombre de la ruta
        return $this->getObject() . '-' . $this->getProcess();
    }

    public function getUrl(): string
    {
        //Devuelve la URL de la ruta
        return "index.php?object=" . $this->getObject() . "&process=" . $this->getProcess();
    }
}
