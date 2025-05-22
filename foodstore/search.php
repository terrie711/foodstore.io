<?php
$search = $_POST['query'] ?? '';

$conn = new mysqli("localhost", "root", "", "foodstore");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = $conn->real_escape_string($search);
$sql = "SELECT * FROM food WHERE FoodTitle LIKE '%$search%' OR Type LIKE '%$search%' OR `From` LIKE '%$search%'";
$result = $conn->query($sql);

$output = '';

while ($row = $result->fetch_assoc()) {
    $output .= "<td style='width: 33%; padding: 10px; vertical-align: top;'>";
    $output .= "<div class='food-card'>";
    $output .= "<table style='width: 100%; background: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);'>";
    $output .= "<tr><td><img src='{$row["Image"]}' style='width: 100%; border-radius: 8px 8px 0 0;'></td></tr>";
    $output .= "<tr><td style='padding: 10px;'><strong>{$row["FoodTitle"]}</strong><br>ISBN: {$row["ISBN"]}<br>From: {$row["From"]}<br>Type: {$row["Type"]}<br>Price: Php {$row["Price"]}</td></tr>";
    $output .= "<tr><td><form class='add-to-cart-form' data-id='{$row['FoodID']}'>";
    $output .= "Quantity: <input type='number' name='quantity' value='1' min='1' style='width: 60px; margin-bottom: 10px;'><br>";
    $output .= "<input class='button add-to-cart-btn' type='submit' value='Add to Cart'></form></td></tr>";
    $output .= "</table></div></td>";
}

echo $output ?: "<td colspan='3'>No matching food found.</td>";