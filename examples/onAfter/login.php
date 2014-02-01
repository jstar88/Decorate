<?php

require "../../Decorate.php";

$login = function ($name)
{ 
    if ($name !== 'Oliver')
    {
        throw new Exception("sorry $name, this secret is not for you!<br>");
    }
}
;

$secret = function ($name)
{
    echo "welcome to the secret, $name<br>";
}
;

$secret = Decorate::onBefore($secret, $login);

try
{
    $secret('Oliver');
    $secret('Giulio');
}
catch (exception $e)
{
    echo ($e->getMessage());
}

?>