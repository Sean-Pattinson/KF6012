<?php
include 'config/config.php';

$url = $_SERVER["REQUEST_URI"];
$path = parse_url($url)['path'];

$path = str_replace(BASEPATH,"",$path);
$pathArr = explode('/',$path);
$path = (empty($pathArr[0])) ? "main" : $pathArr[0];

$pageInfo = isset($path, $ini['routes'][$path])
    ? $ini['routes'][$path]
    : $ini['routes']['error'];

$page = new Router($pageInfo);
echo $page->get_page();
?>