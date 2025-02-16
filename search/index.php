<?php
/* // Datos simulados (mock data)
$mockData = [
    ['first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john.doe@example.com'],
    ['first_name' => 'Jane', 'last_name' => 'Doe', 'email' => 'jane.doe@example.com'],
    ['first_name' => 'Alice', 'last_name' => 'Smith', 'email' => 'alice.smith@example.com'],
    ['first_name' => 'Bob', 'last_name' => 'Brown', 'email' => 'bob.brown@example.com'],
    ['first_name' => 'Charlie', 'last_name' => 'Davis', 'email' => 'charlie.davis@example.com'],
];

// Obtener el término de búsqueda
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// Filtrar los datos simulados basados en el término de búsqueda
$filteredResults = array_filter($mockData, function ($contact) use ($searchTerm) {
    // Buscar en primer nombre, apellido y correo electrónico
    return stripos($contact['first_name'], $searchTerm) !== false ||
           stripos($contact['last_name'], $searchTerm) !== false ||
           stripos($contact['email'], $searchTerm) !== false;
});

// Si hay resultados, generar el HTML para la tabla
if (!empty($filteredResults)) {
    foreach ($filteredResults as $contact) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($contact['first_name']) . '</td>';
        echo '<td>' . htmlspecialchars($contact['last_name']) . '</td>';
        echo '<td>' . htmlspecialchars($contact['email']) . '</td>';
        echo '</tr>';
    }
} else {
    // Si no hay resultados, mostrar un mensaje
    echo '<tr><td colspan="3">No results found.</td></tr>';
}
?> */

include "config.php";

try {
    $result = $db->query("SELECT * FROM $db_name");
    while ($row = $result->fetchArray()) {
        foreach ($row as $column => $value) {
            echo $column . ": " . $value . "<br>";
        }
        echo "<br>";
    }
} catch (Exception) {
    echo("null");
}