<?php

class OnAfterFunctionEmulator extends FunctionEmulator
{
    public function elaborate($args)
    {
        $this->return = call_user_func_array($this->oldFunction, $args);
        $this->return2 = call_user_func_array($this->newFunction, array($this->return));
    }
}
