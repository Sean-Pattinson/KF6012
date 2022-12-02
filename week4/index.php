<?php
include('classes/pdodb.class.php');
include('classes/recordset.class.php');
include('classes/assocrecordset.class.php');
include('classes/htmlrecordset.class.php');

$query  = "SELECT first_name, last_name FROM actor WHERE last_name LIKE :initial";
$params = ["initial" => "%a%"];

$recordset = new AssocRecordSet("db/films_2020.sqlite");
$data      = $recordset->getAssocRecordSet($query, $params);

foreach ($data['data'] as $key => $value) {
    echo "<p>". $value['first_name'] . " <strong>" . $value['last_name'] . "</strong></p>";
}

$recordset = new HTMLRecordSet("db/films_2020.sqlite");
$data      = $recordset->getHTMLRecordSet($query, $params);

echo $data;
?>