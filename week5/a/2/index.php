<?php
$film1 = array("title" => "James Bond", "description" => "Secret agent 007 saves the world", "rating" => "PG");
$film2 = array("title" => "Godzilla", "description" => "Monster destroys Tokyo", "rating" => "12");

header("Content-Type: application/json;charset=utf-8");

echo json_encode($film1);
echo json_encode($film2);
?>