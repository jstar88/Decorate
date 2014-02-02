<?php

class OnAfterDecorativeLinkedList extends SplDoublyLinkedList implements FunctionEmulable
{

    public function __invoke()
    {
        $rfcn = function (){};
        foreach ($this as $node => $value)
        {
            $rfcn = Decorate::onAfter($rfcn, $value);
        }
        call_user_func_array($rfcn, func_get_args());
    }
}
