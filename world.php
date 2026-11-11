<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$country = isset($_GET['country']) ? trim($_GET['country']) : '';
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

// EXERCISE 5: City Lookup
if ($lookup === 'cities') {
    $stmt = $conn->prepare("
        SELECT cities.name AS city_name, cities.district, cities.population 
        FROM cities 
        JOIN countries ON cities.country_code = countries.code 
        WHERE countries.name LIKE :country
    ");
    $stmt->execute(['country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        echo "<table>";
        echo "<tr><th>Name</th><th>District</th><th>Population</th></tr>";
        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['city_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['district']) . "</td>";
            echo "<td>" . htmlspecialchars($row['population']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No cities found for this country.</p>";
    }
} 
// EXERCISE 4: Country Lookup (Default)
else {
    $stmt = $conn->prepare("
        SELECT name, continent, independence_year, head_of_state 
        FROM countries 
        WHERE name LIKE :country
    ");
    $stmt->execute(['country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        echo "<table>";
        echo "<tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>";
        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
            echo "<td>" . htmlspecialchars($row['independence_year'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($row['head_of_state'] ?? 'N/A') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No countries found.</p>";
    }
}
?>