<?php
/**
 * Copyright © 2010 jstar88
 *  
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *  
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *  
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

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
