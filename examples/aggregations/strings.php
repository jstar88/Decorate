<?php

require "../../Decorate.php";

$function = function ()
{
    return " World";
}
;
$intercept = function ()
{
    return "Hello";
}
;
$intercept2 = function ()
{
    return ", I'm Oliver";
}
;

/**
 * echo $function(); //will print " World"
 */


$function = Decorate::onBefore($function, $intercept);
/**
 * echo $function(); //now will print "Hello"
 */


$function = Decorate::onAfter($function, $intercept2);
/**
 * echo $function(); //now will print ", I'm Oliver"
 */


echo $function->getParent()->getPreReturn() . $function->getPreReturn() . $function();
// will print "Hello World, I'm Oliver"
