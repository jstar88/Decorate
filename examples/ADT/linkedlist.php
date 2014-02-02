<?php
require '../../Decorate.php';

$a = new OnAfterDecorativeLinkedList();
$a->push(function(){ echo 1;});
$a->push(function(){ echo 2;});
$a->push(function(){ echo 3;});
$a();

echo '<br>';

$a = new OnBeforeDecorativeLinkedList();
$a->push(function(){ echo 1;});
$a->push(function(){ echo 2;});
$a->push(function(){ echo 3;});
$a();

?>