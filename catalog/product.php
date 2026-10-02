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
	function createProductPage($id)
	{
		
		$conn = connectToDB();
		$query = 'SELECT * FROM product WHERE id='.$id.';';
		$result = mysqli_query($conn, $query);
		$page = '';
		mysqli_close($conn);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$page .= '<div class="product-box"><h1 class="product-title">'.$row["name"].'</h1>';
			$page .= '<img src="'.$row["image"].'" width=200px height=200px>';
			$page .= '<h3 class="product-price">$'.$row["price"].' Per Unit</h3>';
			$page .= '<p class="product-description">'.$row["description"].'</p>';
		}
		if(!isset($_SESSION["product-id"]))
		{
			$_SESSION["product-id"] = array();
			$_SESSION["qty"] = array();
			$_SESSION["price"] = array();
			$_SESSION["product-name"] = array();
		}
		switch($id)
		{
			case "1":
				$page .= '<p class="product-description">*Note: We are not responsible nor liable for the movement of this item or the logistics of carrying it. It is at the discretion of the customer to find a way to lift this item in a manner that does not cause serious harm or injury.</p>';
				break;
			case "2":
				$page .= '<p class="product-description">*Note: Please avoid skin contact with this item as the affects of such contamination are currently being reviewed. If you recieve a mysterious looking rash, please consult your doctor immediately.</p>';
				break;
			case "3":
				$page .= '<p class="product-description">*Note: This is an experimental item. The functionality and legality of this item is still currently being reviewed and updated. Buy at your own discretion.</p>';
				break;
			case "4":
				$page .= '<p class="product-description">*Note: There is only one size for this particular item. So please stop asking if we have any smaller sizes, becuase the answer is no.</p>';
				break;
			case "5":
				$page .= '<p class="product-description">*Note: This item is not designed to attract any specific bird. We only guarentee that it attracts "a" bird.</p>';
				break;
			case "6":
				$page .= '<p class="product-description">*Note: This is a highly flammable and explosive item. We are not liable for any resulting injury or death.</p>';
				break;
			case "7":
				$page .= '<p class="product-description">*Note: This item does not come in a one uniform size. Be wary that you could get the small or gigantic version of this item.</p>';
				break;
			case "8":
				$page .= '<p class="product-description">*Note: This is an experimental item. The functionality and legality of this item is still currently being reviewed and updated. Buy at your own discretion.</p>';
				break;
			case "9":
				$page .= '<p class="product-description">*Note: The health effects of this item are still being reviewed. Please consult your doctor if you begin to have too much shakiness.</p>';
				break;
			case "10":
				$page .= '<p class="product-description">*Note: The actual effectiveness of this costume has not yet been tested. Please be wary of unwanted bird attention.</p>';
				break;
			case "11":
				$page .= '<p class="product-description">*Note: By federal regulations, we are required to say that we do not condone the usage of this item for human slingshots.</p>';
				break;
			case "12":
				$page .= '<p class="product-description">*Note: This is a new and untested item with no refunds right now. Please buy at your own discretion. </p>';
				break;
			case "13":
				$page .= '<p class="product-description">*Note: We are not liable for dental damage. Please stop sending your dental bills to us.</p>';
				break;
			case "14":
				$page .= '<p class="product-description">*Note: A lot of the jets attached to this item have been known to malafunction. Buy at your own discretion.</p>';
				break;
			case "15":
				$page .= '<p class="product-description">*Note: This item has been known to explode if used to extremely. Please be wary of its limits.</p>';
				break;
			case "16":
				$page .= '<p class="product-description">*Note: We are not responsible for moving or placing this item. This is at the customers discretion.</p>';
				break;
			case "17":
				$page .= '<p class="product-description">*Note: We are not liable for any injury or maiming as a result of the rocket on this item.</p>';
				break;
			case "18":
				$page .= '<p class="product-description">*Note: This is an experimental item. The functionality and legality of this item is still currently being reviewed and updated. Buy at your own discretion.</p>';
				break;
			case "19":
				$page .= '<p class="product-description">*Note: This is an experimental item. The functionality and legality of this item is still currently being reviewed and updated. Buy at your own discretion.</p>';
				break;
			case "20":
				$page .= '<p class="product-description">*Note: Radiation poisoning is a common symptom of this item. Please consult your doctor if you feel that your internal organs are failing.</p>';
				break;
		}
		$page .= '</div>';
		return $page;
	}
	function addToCart($id, $qty)
	{
		$conn = connectToDB();
		$query = 'SELECT * FROM product WHERE id='.$id.';';
		$result = mysqli_query($conn, $query);
		mysqli_close($conn);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$name = $row["name"];
			$price = $row["price"];
		}
		
		if(in_array($id, $_SESSION["product-id"]))
		{
			$target = array_search($id, $_SESSION["product-id"]);
			if($qty == 0)
			{
				unset($_SESSION["product-id"][$target]);
				unset($_SESSION["qty"][$target]);
				unset($_SESSION["price"][$target]);
				unset($_SESSION["product-name"][$target]);
				$_SESSION["product-id"] = array_values($_SESSION["product-id"]);
				$_SESSION["qty"] = array_values($_SESSION["qty"]);
				$_SESSION["price"] = array_values($_SESSION["price"]);
				$_SESSION["product-name"] = array_values($_SESSION["product-name"]);
			}
			else
			{
				$_SESSION["qty"][$target] = $qty;
			}
		}
		else
		{
			if($qty == 0)
			{
				//Do Nothing
			}
			else
			{
				array_push($_SESSION["product-id"], $id);
				array_push($_SESSION["qty"], $qty);
				array_push($_SESSION["price"], $price);
				array_push($_SESSION["product-name"], $name);
			}
		}
	}
	function createDenyMessage()
	{
		$message = '<div class="deny-box"><h1 class="deny-title">Account Required</h1>';
		$message .= '<p class="deny-message">An account is required to continue, please log in.</p>';
		$message .= '<a class="deny-link" href=".">Log In</a>';
		$message .= '<img src="img/person.png" width=150px height=150px></div>';
		return $message;
	}
	function createQuantityForm($isError, $id, $message)
	{
		$form = '<div class="add-cart-box"><form method="post">';
		$form .= '<input type="hidden" name="id" value="'.$id.'">';
		$form .= '<div class="add-qty"><label for="qty">Quantity</label><input type="text" id="qty" name="qty" placeholder="e.g. 4">';
		$form .= '<input type="submit" value="Add To Cart" name="add"></div>';
		if($isError) $form .= '<p class="error-product">Warning! Quantity must be a non-negative, non-decimal number</p>';
		$form .= $message;
		$form .= '</div>';
		return $form;
	}
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>Product Info</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href='https://fonts.googleapis.com/css?family=Bangers' rel='stylesheet'>
	</head>
	
	<body>
		<?php  
			if(!isset($_POST["add"]))
			{
				echo createNavigation(isset($_SESSION["granted"]));
				if(isset($_GET["id"]) && !empty($_GET["id"]))
				{
					echo createProductPage($_GET["id"]);
					echo createQuantityForm(false, $_GET["id"], "");
				}
				else
				{
					header('location: .');
				}
			}
			else
			{
				if(isset($_SESSION["granted"]))
				{
					echo createNavigation(isset($_SESSION["granted"]));
					if(filter_var($_POST["qty"], FILTER_VALIDATE_INT) !== false && $_POST["qty"] >= 0)
					{
						if(in_array($_POST["id"], $_SESSION["product-id"]))
						{
							if($_POST["qty"] == 0)
							{
								$message = '<p class="product-result-message">Item Removed from Cart!</p>';
							}
							else
							{
								$message = '<p class="product-result-message">Item Quantity Changed in Cart!</p>';
							}
						}
						else
						{
							if($_POST["qty"] == 0)
							{
								$message = '<p class="product-result-message">Nothing Added to Cart!</p>';
							}
							else
							{
								$message = '<p class="product-result-message">Item Added to Cart!</p>';
							}
						}
						addToCart($_POST["id"], $_POST["qty"]);
						echo createProductPage($_POST["id"]);
						echo createQuantityForm(false, $_POST["id"], $message);
					}
					else
					{
						echo createProductPage($_POST["id"]);
						echo createQuantityForm(true, $_POST["id"], "");
					}
				}
				else
				{
					echo createDenyMessage();
				}
			}
		?>
	</body>
</html>