<?php

class FunctionEmulator implements FunctionEmulable
{
    public $oldFunction;
    public $newFunction;
    private $elaboratedFromInvoke;
    private $elaboratedFromReturn;
    private $lastArgs;
    protected $return;
    protected $return2;

    public function __construct($oldFunction, $newFunction)
    {
        $this->lastArgs = array();
        $this->elaboratedFromInvoke = false;
        $this->elaboratedFromReturn = false;
        $this->oldFunction = $oldFunction;
        $this->newFunction = $newFunction;
    }
    public function __invoke()
    {
        $args = func_get_args();
        if (!Decorate::$cache || !$this->elaboratedFromReturn || $args !== $this->lastArgs)
        {
            $this->elaborate($args);
            $this->elaboratedFromInvoke = true;
            if ($args !== $this->lastArgs)
            {
                $this->lastArgs = $args;
                $this->elaboratedFromReturn = false;
            }
        }
        return $this->return2;
    }
    public function elaborate($args)
    {
    }
    public function getPreReturn()
    {
        $args = func_get_args();
        if (!Decorate::$cache || !$this->elaboratedFromInvoke || $args !== $this->lastArgs)
        {
            $this->elaborate($args);
            $this->elaboratedFromReturn = true;
            if ($args !== $this->lastArgs)
            {
                $this->lastArgs = $args;
                $this->elaboratedFromInvoke = false;
            }
        }
        return $this->return;
    }
    public function getParent()
    {
        return $this->oldFunction;
    }
}
