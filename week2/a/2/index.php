<?php
include 'classes/webpage.class.php';
include 'classes/Router.class.php';
include 'classes/webpagewithnav.class.php';
$page = new Router("documentation");
echo $page->get_page();
?>