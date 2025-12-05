<?php
$host = 'localhost';
$username = 'lab5_user';          
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? $_GET['country'] : '';
$lookup  = isset($_GET['lookup'])  ? $_GET['lookup']  : '';



if ($lookup === 'cities') {

    // --- CITIES MODE ---

    if ($country === '') {
        $stmt = $conn->query(
            "SELECT cities.name, cities.district, cities.population
             FROM cities
             JOIN countries ON countries.code = cities.country_code
             ORDER BY cities.name"
        );
    } else {
        // Filter by country name using LIKE
        $stmt = $conn->prepare(
            "SELECT cities.name, cities.district, cities.population
             FROM cities
             JOIN countries ON countries.code = cities.country_code
             WHERE countries.name LIKE :country
             ORDER BY cities.name"
        );
        $search = "%" . $country . "%";
        $stmt->bindParam(':country', $search, PDO::PARAM_STR);
        $stmt->execute();
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <table class="result-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>District</th>
                <th>Population</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['district']); ?></td>
                <td><?= htmlspecialchars($row['population']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    exit;
}

/* --------- COUNTRIES MODE (default) --------- */

if ($country === '') {
    // No search term → all countries
    $stmt = $conn->query(
        "SELECT name, continent, independence_year, head_of_state
         FROM countries"
    );
} else {
    // Partial search on country name
    $stmt = $conn->prepare(
        "SELECT name, continent, independence_year, head_of_state
         FROM countries
         WHERE name LIKE :country"
    );
    $search = "%" . $country . "%";
    $stmt->bindParam(':country', $search, PDO::PARAM_STR);
    $stmt->execute();
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="result-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td><?= htmlspecialchars($row['continent']); ?></td>
            <td><?= htmlspecialchars($row['independence_year']); ?></td>
            <td><?= htmlspecialchars($row['head_of_state']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
