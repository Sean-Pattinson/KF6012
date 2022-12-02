<?php

//We won't worry about OO PHP or valid HTML5 in this exercise

function getDbConnection($dbname) {
    try {
        $dbConnection = new PDO('sqlite:'.$dbname);
    }
    catch( PDOException $e ) {
        echo "Database Connection Error: " . $e->getMessage();
        exit();
    }
    return $dbConnection;
}

function searchFilms($conn, $term) {
    $query = "SELECT * FROM film WHERE title LIKE :term";
    $stmt = $conn->prepare($query);

    $params = ["term" => "$term"];
    $stmt->execute($params);

    $output = "<h2>Search Films (term: $term)</h2>";
    if ($stmt) {
        while ($myLine = $stmt->fetchObject()) {
            $output.= "<p>" . $myLine->title . " " . $myLine->description . "</p>";
        }
    }
    else {
        $output = "<p>No data</p>";
    }
    return $output;
}

/**
 * Output the same as searchFilms but with the film category also listed
 */
function searchFilmsWithCategory($conn, $term) {
    $query = "SELECT * FROM film INNER JOIN category on film.category_id=category.category_id WHERE category.name LIKE :term";
    $stmt = $conn->prepare($query);

    $params = ["term" => "$term"];
    $stmt->execute($params);

    $output = "<h2>Search Films With Category(term: $term)</h2>";
    if ($stmt) {
        while ($myLine = $stmt->fetchObject()) {
            $output.= "<p>" . $myLine->title . " " . $myLine->description . " " .$myLine->name . "</p>";
        }
    }
    else {
        $output = "<p>No data</p>";
    }
    return $output;
}

/**
 * Similar to searchFilms but list actors
 */
function searchActors($conn, $firstname, $lastname) {
    $query = "SELECT * FROM actor WHERE first_name LIKE :first_name AND last_name LIKE :last_name";
    $stmt = $conn->prepare($query);

    $params = ["first_name" => "$firstname", "last_name" => $lastname];
    $stmt->execute($params);

    $output = "<h2>Search Films With Category(firstname: $firstname. lastname: $lastname.)</h2>";
    if ($stmt) {
        while ($myLine = $stmt->fetchObject()) {
            $output.= "<p>" . $myLine->first_name . " " . $myLine->last_name . "</p>";
        }
    }
    else {
        $output = "<p>No data</p>";
    }
    return $output;
}

/**
 * Insert an actor
 */
function insertActor($conn, $firstname, $lastname) {
    $query = "INSERT INTO actor (first_name, last_name) VALUES (:firstname, :lastname)";
    $stmt = $conn->prepare($query);
    $params = ["firstname" => "$firstname", "lastname" => "$lastname" ];
    $stmt->execute($params);
    $output = "<h2>Update actor (terms: $firstname $lastname)</h2>";
    if ($stmt) {
        $output.= "<p>Successfully added $firstname, $lastname</p>";
    }
    else {
        $output .= "<p>Error, could not insert into database</p>";
    }
    return $output;
}


$dbname = "films_2020.sqlite";
$conn = getDbConnection($dbname);

echo "<h1>Searches</h1>";
echo searchFilms($conn, "%good%");
echo searchFilmsWithCategory($conn, "%horror%");
echo searchActors($conn, "%a%", "%j%");
echo insertActor($conn, "Jennifer", "Jones");
echo searchActors($conn, "%j%", "%j%");