<?php

require "../../Decorate.php";

$bandwidth = function ($position)
{
    $position->x = min($position->x, 50);
    $position->y = min($position->y, 50);
    $position->z = min($position->z, 50);
}
;

$saveToDB = function ($position)
{
    //doquery etc..
    print_r($position);
}
;

$saveToDB = Decorate::onBefore($saveToDB, $bandwidth);

$position = (object)array(
    'x' => 100,
    'y' => 100,
    'z' => 100);
$saveToDB($position);
