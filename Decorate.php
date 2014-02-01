<?php

abstract class Decorate
{
    static $cache = false;
    public static function onBefore($function, $newFunction)
    {
        return new OnBeforeFunctionEmulator($function, $newFunction);
    }
    public static function onAfter($function, $newFunction)
    {
        return new OnAfterFunctionEmulator($function, $newFunction);
    }
}
class FunctionEmulator
{
    public $function;
    public $newFunction;
    private $elaboratedFromInvoke;
    private $elaboratedFromReturn;
    private $lastArgs;
    protected $return;
    protected $return2;

    public function __construct($function, $newFunction)
    {
        $this->lastArgs = array();
        $this->elaboratedFromInvoke = false;
        $this->elaboratedFromReturn = false;
        $this->function = $function;
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
        return $this->function;
    }
}
class OnAfterFunctionEmulator extends FunctionEmulator
{
    public function elaborate($args)
    {
        $this->return = call_user_func_array($this->function, $args);
        $this->return2 = call_user_func_array($this->newFunction, array($this->return));
    }
}
class OnBeforeFunctionEmulator extends FunctionEmulator
{
    public function elaborate($args)
    {
        $this->return = call_user_func_array($this->newFunction, $args);
        $this->return2 = call_user_func_array($this->function, $args);
    }
}