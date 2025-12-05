<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// 1. Get the country from the URL (may be empty)
$country = isset($_GET['country']) ? $_GET['country'] : '';

// 2. Decide which query to run
if ($country === '') {
    // No country entered → return ALL countries
    $stmt = $conn->query("SELECT * FROM countries");
} else {
    // Some text entered → use LIKE for partial search
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $search = "%" . $country . "%";   // <-- IMPORTANT: the % are inside quotes
    $stmt->bindParam(':country', $search, PDO::PARAM_STR);
    $stmt->execute();
}

// 3. Get all rows as an array
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
