<html>
<meta http-equiv="Content-Type"'.' content="text/html; charset=utf8"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<body>
<?php
session_start();
	if(isset($_POST['ac'])){
		$servername = "localhost";
		$username = "root";
		$password = "";

		$conn = new mysqli($servername, $username, $password);

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "USE foodstore";
		$conn->query($sql);

		$sql = "SELECT * FROM food WHERE FoodID = '".$_POST['ac']."'";
		$result = $conn->query($sql);

		while($row = $result->fetch_assoc()){
			$foodID = $row['FoodID'];
			$quantity = $_POST['quantity'];
			$price = $row['Price'];
		}

		$sql = "INSERT INTO cart(FoodID, Quantity, Price, TotalPrice) VALUES('".$foodID."', ".$quantity.", ".$price.", Price * Quantity)";
		$conn->query($sql);
	}

	if(isset($_POST['delc'])){
		$servername = "localhost";
		$username = "root";
		$password = "";

		$conn = new mysqli($servername, $username, $password);

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "USE foodstore";
		$conn->query($sql);

		$sql = "DELETE FROM cart";
		$conn->query($sql);
	}

	$servername = "localhost";
	$username = "root";
	$password = "";

	$conn = new mysqli($servername, $username, $password);

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "USE foodstore";
	$conn->query($sql);	

	$sql = "SELECT * FROM food";
	$result = $conn->query($sql);
?>	

<?php
if(isset($_SESSION['id'])){
	echo '<header>';
	echo '<blockquote>';
	echo '<a href="leirence.php"><img src="image/logo-new.png"  width="120" height="auto"></a>';
	echo '<form class="hf" action="logout.php"><input class="hi" type="submit" name="submitButton" value="Logout"></form>';
	echo '<form class="hf" action="edituser.php"><input class="hi" type="submit" name="submitButton" value="Edit Profile"></form>';
	echo '</blockquote>';
	echo '</header>';
}

if(!isset($_SESSION['id'])){
	echo '<header>';
	echo '<blockquote>';
	echo '<div class="search-bar-container">
    <input type="text" id="searchInput" placeholder="Search for food..." />
		  </div>';
	echo '<a href="leirence.php"><img src="image/logo-new.png"  width="120" height="auto"></a>';
	echo '<form class="hf" action="Register.php"><input class="hi" type="submit" name="submitButton" value="Register"></form>';
	echo '<form class="hf" action="login.php"><input class="hi" type="submit" name="submitButton" value="Login"></form>';
	echo '</blockquote>';
	echo '</header>';
}
echo '<blockquote>';
echo "<table id='myTable' style='width: 100%; border-spacing: 15px 20px;'>";

echo "<tr id='foodResults'>";

while($row = $result->fetch_assoc()) {
    echo "<td style='width: 33%; padding: 10px; vertical-align: top;'>";
    echo "<div class='food-card' style='animation: slideIn 0.8s ease;'>";

    echo "<table style='width: 100%; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); transition: transform 0.3s;'>";
    
    echo "<tr><td><img src='{$row["Image"]}' width='100%' style='border-radius: 8px 8px 0 0;'></td></tr>";
    
    echo "<td style='padding: 10px; vertical-align: top;'>Title: <strong>{$row["FoodTitle"]}</strong></td></tr>";
    echo "<td style='padding: 10px; vertical-align: top;'>ISBN: {$row["ISBN"]}</td></tr>";
    echo "<td style='padding: 10px; vertical-align: top;'>From: {$row["From"]}</td></tr>";
   echo "<td style='padding: 10px; vertical-align: top;'>Type: {$row["Type"]}</td></tr>";
    echo "<tr><td style='padding: 10px; vertical-align: top;'>Price: Php {$row["Price"]}</td></tr>";

    echo "<tr><td style='padding: 10px;'>";
    echo "<form action='' method='post'>";
    echo "Quantity: <input type='number' name='quantity' value='1' min='1' style='width: 60px; margin-bottom: 10px;'><br>";
    echo "<input type='hidden' name='ac' value='{$row['FoodID']}'>";
    echo "<input class='button' data-id='123' type='submit' value='Add to Cart'>";
    echo "</form>";
    echo "</td></tr>";

    echo "</table>";
    echo "</div>";
    echo "</td>";
}

echo "</tr>";
echo "</table>";
echo '</blockquote>';


	$sql = "SELECT food.FoodTitle, food.Image, cart.Price, cart.Quantity, cart.TotalPrice FROM food,cart WHERE food.FoodID = cart.FoodID;";
	$result = $conn->query($sql);

    $cartItemCount = 0;
$total = 0;
$cartItemsHtml = "";

while ($row = $result->fetch_assoc()) {
    $cartItemCount += $row["Quantity"];
    $total += $row["TotalPrice"];

    $cartItemsHtml .= "<div class='cart-item'>";
    $cartItemsHtml .= "<img src='{$row["Image"]}' class='cart-img'>";
    $cartItemsHtml .= "<div>";
    $cartItemsHtml .= "<strong>{$row['FoodTitle']}</strong><br>";
    $cartItemsHtml .= "Php {$row['Price']}<br>";
    $cartItemsHtml .= "Qty: {$row['Quantity']}<br>";
    $cartItemsHtml .= "Total: Php {$row['TotalPrice']}";
    $cartItemsHtml .= "</div></div>";
}
?>


<div class="cart-bubble" id="cartToggle">
    <i class="fa fa-shopping-cart"></i>
    <span class="cart-count"><?= $cartItemCount ?></span>
</div>

<div class="cart-panel" id="cartPanel">
    <div class="cart-header">
        <strong>Your Cart</strong>
        <form style="float:right;" action="" method="post">
            <input type="hidden" name="delc"/>
            <input class="cbtn" type="submit" value="Empty">
        </form>
    </div>

    <div class="cart-content">
        <?= $cartItemsHtml ?>
    </div>

    <div class="cart-footer">
        <div>Total: <b>Php <?= $total ?></b></div>
        <form action="checkout.php" method="post">
            <input class="button" type="submit" name="checkout" value="CHECKOUT">
        </form>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>