<?php
include("classes/newclass.class.php");
include("classes/secretAgent.class.php");
$newObject = new NewClass("Hello!");
$newObject2 = new NewClass("Aloha!");
echo $newObject->getMessage();
echo $newObject2->getMessage();

$agent1 = new SecretAgent("Wolf", "Howl", "Buy milk");
$agent2 = new SecretAgent("Lion", "Roar", "Watch TV");

echo $agent1->getMission("Wolf");
?>
