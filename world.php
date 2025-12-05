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

<ul>
<?php foreach ($results as $row): ?>
  <li>
    <?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?>
  </li>
<?php endforeach; ?>
</ul>
