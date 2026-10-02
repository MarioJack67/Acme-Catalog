<?php
	session_start();
	function createCartPage()
	{
		$isError = false;
		if(isset($_POST["update"]))
		{
			for($x = 0; $x < sizeof($_SESSION["qty"]); $x++)
			{
				$target = 'qty-'.$x;
				if(filter_var($_POST[$target], FILTER_VALIDATE_INT) !== false && $_POST[$target] >= 0)
				{
					if($_POST[$target] == 0)
					{
						unset($_SESSION["product-id"][$x]);
						unset($_SESSION["qty"][$x]);
						unset($_SESSION["price"][$x]);
						unset($_SESSION["product-name"][$x]);
					}
					else
					{
						$_SESSION["qty"][$x] = $_POST[$target];
					}
				} 
				else 
				{
					$isError = true;
				}
			}
			$_SESSION["product-id"] = array_values($_SESSION["product-id"]);
			$_SESSION["qty"] = array_values($_SESSION["qty"]);
			$_SESSION["price"] = array_values($_SESSION["price"]);
			$_SESSION["product-name"] = array_values($_SESSION["product-name"]);
		}
		if(empty($_SESSION["product-id"]))
		{
			header('location: cart.php');
		}
		
		$page = '<div class="cart-box"><h1 class="cart-title">Your Dynamic Shopping Cart!</h1>';
		$page .= '<p class="cart-message">Welcome to your shopping cart! You can view all of the items that are currently on your order along with their quantities.';
		$page .= ' See a mistake? Feel free to edit the quantity of any items!</p>';
		$page .= '<br><p class="cart-message">*Note: If you want to remove an item, simply enter a quantity of zero and press "Update Cart"</p></div>';
		$page .= '<form method="post"><table class="cart"><tr><th>Product Name</th><th>Unit Price</th><th>Qty</th><th>Total</th></tr>';
		$grandTotal = 0;
		for($x = 0; $x < sizeof($_SESSION["product-id"]); $x++)
		{
			$page .= '<tr>';
			$page .= '<td>'.$_SESSION["product-name"][$x].'</td>';
			$page .= '<td>$'.$_SESSION["price"][$x].'</td>';
			$page .= '<td><input type="text" placeholder="Qty" name="qty-'.$x.'" value="'.$_SESSION["qty"][$x].'"></td>';
			$page .= '<td>$'.(number_format($_SESSION["price"][$x] * $_SESSION["qty"][$x], 2)).'</td>';
			$page .= '</tr>';
			$grandTotal += ($_SESSION["price"][$x] * $_SESSION["qty"][$x]);
		}
		$page .= '<tr><td colspan="3">Grand Total:</td><td>$'.number_format($grandTotal, 2).'</td></tr>';
		$page .= '</table><div class="update-order"><input type="submit" name="update" value="Update Cart"><input type="submit" name="order" value="Place Order"></div>';
		if($isError) $page .= '<p class="error">Warning! Quantity must be a non-negative, non-decimal number</p>';
		$page .= '</form>';
		return $page;
	}
	function createEmptyMessage()
	{
		$message = '<div class="empty-box"><h1 class="empty-title">Your Cart is Empty!</h1>';
		$message .= '<p class="empty-message">There are no items currently in your cart. Please buy something.</p>';
		$message .= '<img src="img/shopping-cart.png" width=165px height=170px></div>';
		return $message;
	}
	function createPurchaseMessage()
	{
		if(empty($_SESSION["product-id"]))
		{
			header('location: cart.php');
		}
		else
		{
			$grandTotal = 0;
			$message = '<div class="purchase-box"><h1 class="purchase-title">Thank You For Purchasing!</h1>';
			$message .= '<p class="purchase-message">Your Order Includes:</p><ul class="purchase-list">';
			for($x=0; $x < sizeof($_SESSION["product-id"]); $x++)
			{
				$message .= '<li>'.$_SESSION["product-name"][$x].' x '.$_SESSION["qty"][$x].'</li>';
				$grandTotal += ($_SESSION["price"][$x] * $_SESSION["qty"][$x]);
			}
			$message .= '</ul><p class="purchase-message">Total Charge: $'.$grandTotal.'</p></div>';
			return $message;
		}
	}
	function createNavigation($isGranted)
	{
		if($isGranted)
		{
			$nav = '<nav><ul class="nav">';
			$nav .= '<li><a href=".">Home</a></li>';
			$nav .= '<li><a href="catalog.php">Products</a></li>';
			$nav .= '<li><a class="active" href="cart.php">Cart</a></li>';
			$nav .= '<li><a href="logout.php">Log Out</a></li>';
			$nav .= '</ul></nav>';
			return $nav;
		}
		else
		{
			$nav = '<nav><ul class="nav">';
			$nav .= '<li><a href=".">Log In</a></li>';
			$nav .= '<li><a href="create-account.php">Create Account</a></li>';
			$nav .= '<li><a href="catalog.php">Products</a></li>';
			$nav .= '</ul></nav>';
			return $nav;
		}
	}
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>Shopping Cart</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href='https://fonts.googleapis.com/css?family=Bangers' rel='stylesheet'>
	</head>
	
	<body>
		<?php
			if(isset($_SESSION["granted"]))
			{
				echo createNavigation(isset($_SESSION["granted"]));
				if(isset($_POST["order"]))
				{
					echo createPurchaseMessage();
					$_SESSION["product-id"] = array();
					$_SESSION["qty"] = array();
					$_SESSION["price"] = array();
					$_SESSION["product-name"] = array();
				}
				else
				{
					if(!isset($_SESSION["product-id"]) || empty($_SESSION["product-id"]))
					{
						echo createEmptyMessage();
					}
					else
					{
						echo createCartPage();
					}
				}
			}
			else
			{
				header('location: .');
			}
		?>
	</body>
</html>