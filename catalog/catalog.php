<?php
	session_start();
	//Define credentials for local and remote DB
	if($_SERVER['HTTP_HOST'] == 'localhost')
	{
		define('HOST', 'localhost');
		define('USER', 'root');
		define('PASS', '1550');
		define('DB', 'palindromes');
	}
	else
	{
		define('HOST', 'sql101.infinityfree.com');
		define('USER', 'if0_42588468');
		define('PASS', 'bem8p2DmdWaJ');
		define('DB', 'f0_42588468_catalog');
	}
	//Connects to local or remote database
	function connectToDB()
	{	
		//Connect to Database
		$connect = mysqli_connect(HOST, USER, PASS, DB);
		return $connect;
	}
	function createNavigation($isGranted)
	{
		if($isGranted)
		{
			$nav = '<nav><ul class="nav">';
			$nav .= '<li><a href=".">Home</a></li>';
			$nav .= '<li><a class="active" href="catalog.php">Products</a></li>';
			$nav .= '<li><a href="cart.php">Cart</a></li>';
			$nav .= '<li><a href="logout.php">Log Out</a></li>';
			$nav .= '</ul></nav>';
			return $nav;
		}
		else
		{
			$nav = '<nav><ul class="nav">';
			$nav .= '<li><a href=".">Log In</a></li>';
			$nav .= '<li><a href="create-account.php">Create Account</a></li>';
			$nav .= '<li><a class="active" href="catalog.php">Products</a></li>';
			$nav .= '</ul></nav>';
			return $nav;
		}
	}
	function createCatalog()
	{
		$conn = connectToDB();
		$query = 'SELECT * FROM product;';
		$results = mysqli_query($conn, $query);
		$catalog = '<table class="catalog-table"><tr><th>Product Name</th><th>Image</th><th>Price</th><th>Details</th></tr>';
		mysqli_close($conn);
		while($rows = mysqli_fetch_array($results, MYSQLI_ASSOC))
		{
			$catalog .= '<tr>';
			$catalog .= '<td>'.$rows["name"].'</td><td><img src="'.$rows["image"].'" width=150px height=150px></td><td>$'.$rows["price"].'</td><td><a href="product.php?id='.$rows["id"].'">View Product</a></td>';
			$catalog .= '</tr>';
		}
		$catalog .= '</table>';
		return $catalog;
	}
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>The Acme Product Catalog!</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href='https://fonts.googleapis.com/css?family=Bangers' rel='stylesheet'>
	</head>
	
	<body>
		<?php  echo createNavigation(isset($_SESSION['granted'])); ?>
		<div class="catalog-box"><h1 class="catalog-title">Our World-Class Product Catalog!</h1>
		<p class="catalog-message">Below, you will find 20 of our most quality and highly sought-after tools. We've got a product for every problem you might have, big or small, human or non-human. Need to give your neighbor a 700lb wakeup call? Take a look at our extremely popular Anvils made from stainless steel in the mountains of Japan. Is there any annoying door with a "Restricted Access" sign blocking your way? Pick up one of our Atom Re-Arranger Guns and simply bend its molecular composition to your will. Perhaps you have a friend that just beat you at Mario Kart for the billionth time? Buy our highly versatile Disintegration Pistol, they won't ever win again!<br><br> What are you waiting for? Scroll our catalog and click "View Product" to start buying.</p></div>
		<?php
			echo createCatalog();
		?>
	</body>
</html>