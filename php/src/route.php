<?php
class Route
{
    private $object;
    private $process;
    private $function;

    public function __construct($object = '', $process = '', $function = null)
    {
        $this->setObject($object);
        $this->setProcess($process);
        $this->setFunction($function);
    }

    private function setObject($object)
    {
        $this->object = $object;
    }

    private function getObject()
    {
        return $this->object;
    }

    private function setProcess($process)
    {
        $this->process = $process;
    }

    private function getProcess()
    {
        return $this->process;
    }

    private function setFunction($function)
    {
        $this->function = $function;
    }

    private function getFunction()
    {
        return $this->function;
    }

    public function identify(): void
    {
        $this->identifyObject();
        $this->identifyProcess();
    }

    private function identifyObject(): void
    {
        if (isset($_GET['object']) === true) {
            $this->setObject($_GET['object']);
        } else {
            $this->setObject(null);
        }
    }

    private function identifyProcess(): void
    {
        if (isset($_GET['process']) === true) {
            $this->setProcess($_GET['process']);
        } else {
            $this->setProcess(null);
        }
    }

    public function getName()
    {
        return $this->getObject() . '-' . $this->getProcess();
    }
}
