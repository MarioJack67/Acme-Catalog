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
	function catalogHash($password)
	{
		$salt1 = 'ieugoiaheogu493tu09u';
		$salt2 = 'nvdakubarkvo%&782094859';
		$password = $salt1.$password.$salt2;
		$password = hash('sha512', $password);
		return $password;
	}
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
			$nav .= '<li><a class="active" href=".">Home</a></li>';
			$nav .= '<li><a href="catalog.php">Products</a></li>';
			$nav .= '<li><a href="cart.php">Cart</a></li>';
			$nav .= '<li><a href="logout.php">Log Out</a></li>';
			$nav .= '</ul></nav>';
			return $nav;
		}
		else
		{
			$nav = '<nav><ul class="nav">';
			$nav .= '<li><a class="active" href=".">Log In</a></li>';
			$nav .= '<li><a href="create-account.php">Create Account</a></li>';
			$nav .= '<li><a href="catalog.php">Products</a></li>';
			$nav .= '</ul></nav>';
			return $nav;
		}
	}
	function createLoginForm($isError)
	{
		$form = '<div class="'.($isError ? "login-box-error":"login-box").'"><h1 class="login-title">Welcome To Acme Catalog!</h1>';
		$form .= '<form method="post">';
		$form .= '<div class="username"><label for="user">User</label><input type="text" name="user" id="user" placeholder="e.g., john"></div>';
		$form .= '<div class="password"><label for="pass">Pass</label><input type="password" name="pass" id="pass" placeholder="e.g., pork"></div>';
		$form .= '<div class="login-clear"><input type="submit" name="login" value="Login">';
		$form .= '<input type="reset" name="clear" value="Clear"></div>';
		$form .= '</form>';
		$form .= '<div class="create-account"><a class="create-link" href="create-account.php">Create Account</a></div>';
		if($isError) $form .= '<div class="login-error"><p class="error">Warning! Incorrect Credentials Entered</p></div>';
		$form .= '</div>';
		return $form;
	}
	function validateLoginData($user, $pass)
	{
		$pass = catalogHash($pass);
		$conn = connectToDB();
		$query = 'SELECT * FROM users WHERE username="'.$user.'" && password="'.$pass.'";';
		$results = mysqli_query($conn, $query);
		mysqli_close($conn);
		if(mysqli_num_rows($results) != 0)
		{
			$_SESSION['granted'] = true;
			return true;
		}
		else
		{
			return false;
		}
	}
	function createIntroMessage()
	{
		$message = '<div class="intro-box"><h1 class="intro-title">An Introduction To Acme Catalog</h1>';
		$message .= '<h3 class="intro-message">Welcome to the Acme Catalog!</h3>';
		$message .= '<p class="intro-message">Our mission is to produce and deliver the most high-quality tools on the market for you most whimsical, and probably illegal, dreams! Our founders understood the natural human emotion of wanting our greatest enemies, or slight annoyances, to be completely wiped from our minds and lives! That is why we have developed a catalog to showcase the various tools we have created over the years to deal with such troublesome problems. Whether you have a giant bird, an insufferable online troll, or even your in-laws for the holidays again, we definitely have a product that will "resolve" these problems. Furthermore, if you find any products you order to be unsastifactory, we will give you a 100% refund guarented! Start browsing the catalog and become like one of our many satisfied customers below!</p>';
		$message .= '<img class="review" src="img/customer-review.png" width=300px height=200px></div>';
		return $message;
	}
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>The Acme Catalog</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href='https://fonts.googleapis.com/css?family=Bangers' rel='stylesheet'>
	</head>
	
	<body>
		<?php
			if(!isset($_SESSION['granted']))
			{
				echo createNavigation(isset($_SESSION['granted']));
				if(!isset($_POST["login"]))
				{
					echo createLoginForm(false);
				}
				else
				{
					if(validateLoginData($_POST["user"], $_POST["pass"]))
					{
						$_SESSION['user'] = $_POST['user'];
						header('location: .');
					}
					else
					{
						echo createLoginForm(true);
					}
				}
			}
			else
			{
				echo createNavigation(isset($_SESSION['granted']));
				echo createIntroMessage();
			}
		?>
	</body>
</html>