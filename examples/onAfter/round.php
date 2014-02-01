<?php

require "../../Decorate.php";

$operation = function ($a, $b)
{
    return $a * $b;
}
;

$round = function ($a)
{
    return round($a);
}
;

$operation = Decorate::onAfter($operation, $round);
echo $operation(3, 5.2);
