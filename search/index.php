<?php
header('Content-Type: text/html; charset=UTF-8');

include_once "./templates/core/Template.php";
include_once "./database/DatabaseClass.php";
include_once "./environment/Environment.php";

$search = $_POST['search'] ?? '';

// Connection to de db
// The .env has the information of the dabase connection
$db = new Database(getenv('DB_HOST'), getenv('DB_PORT'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'));

if ($db->hasError()) {
    $errorTemp = new Template("./templates/ErrorTemplate.php");
    echo $errorTemp->render();
    exit;
}

if (empty($search)) {
    $dir = $db->fetchAll("SELECT * FROM tb_address_book");
} else {
    $search = "%{$search}%";
    $dir = $db->fetchAllWithTypes("SELECT * FROM tb_address_book WHERE name LIKE ? OR charge LIKE ?",
                                    "ss",
                                    [$search, $search]
                                );
}

if (empty($dir)) {
    $errorTemp = new Template("./templates/NotFoundTemplate.php");
    echo $errorTemp->render();
    exit;
}

$counter = 0;
foreach ($dir as $d) {
    $d['isEven'] = ($counter % 2 == 0) ? true : false;
    $temp = new Template("./templates/AccordeonTemplate.php", $d);
    echo $temp->render();
    $counter++;
}