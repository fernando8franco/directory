<?php
header('Content-Type: text/html; charset=UTF-8');

include_once "./templates/core/Template.php";
include_once "./database/DatabaseClass.php";

$search = $_POST['search'] ?? '';
$db = new SQLite3("directorio.db");
$db->enableExceptions(true);

try {
    if (empty($search)) {
        $stmt = $db->prepare("SELECT * FROM directorio");
    } else {
        $stmt = $db->prepare("SELECT * FROM directorio WHERE nombre LIKE ? OR cargo LIKE ?");
        $search = "%$search%";
        $stmt->bindValue(1, $search, SQLITE3_TEXT);
        $stmt->bindValue(2, $search, SQLITE3_TEXT);
    }

    $result = $stmt->execute();


    $counter = 0;
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $row['isEven'] = ($counter % 2 == 0) ? true : false;

        $temp = new Template("./templates/AccordeonTemplate.php", $row);
        echo $temp->render();

        $counter++;
    }
} catch (Exception) {
    echo("<div>Algo salio mal en la busqueda</div>");
}