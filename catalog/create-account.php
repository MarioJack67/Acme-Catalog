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
	function createSetupPage($isError)
	{
		$form = '<div class="create-box"><h1 class="create-title">Create Account</h1>';
		$form .= '<form id="create-form" method="post">';
		$form .= '<div class="username"><label for="user">User</label><input type="text" name="user" id="user" placeholder="e.g., john"></div>';
		$form .= '<div class="password"><label for="pass">Pass</label><input type="password" name="pass" id="pass" placeholder="e.g., pork"></div>';
		$form .= '<div class="verify-pass"><label for="verify">Verify</label><input type="password" name="verify" id="verify" placeholder="Confirm Password"></div>';
		$form .= '<div class="create-clear"><input type="submit" name="create" id="create" value="Create Account" disabled>';
		$form .= '<button id="clear">Clear</button></div></form>';
		if($isError) $form .= '<p id="error-text" class="error">Warning! Username already exists or is empty</p>';
		$form .= '<div class="container"><div class="requirement"><p id="number" class="invalid">Password must contain a number</p></div><div class="requirement"><p id="eight" class="invalid">Password must be 8 characters long</p></div></div><div class="requirement"><p id="match" class="blank"></p></div></div>';
		return $form;
	}
	function createSuccessMessage()
	{
		$message = '<div class="success-box"><h1 class="success-title">Account Successfully Created!</h1>';
		$message .= '<div class="login-account"><a class="return-link" href=".">Return To Login</a></div>';
		$message .= '</div>';
		return $message;
	}
	function catalogHash($password)
	{
		$salt1 = 'ieugoiaheogu493tu09u';
		$salt2 = 'nvdakubarkvo%&782094859';
		$password = $salt1.$password.$salt2;
		$password = hash('sha512', $password);
		return $password;
	}
	function checkUser($user)
	{
		if(!empty($user))
		{
			$conn = connectToDB();
			$query = 'SELECT * FROM users WHERE username="'.$user.'";';
			$results = mysqli_query($conn, $query);
			mysqli_close($conn);
			if(mysqli_num_rows($results) == 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	function addUser($user, $pass)
	{
		$pass = catalogHash($pass);
		$conn = connectToDB();
		$query = 'INSERT INTO users (username, password) VALUES("'.$user.'", "'.$pass.'");';
		mysqli_query($conn, $query);
		mysqli_close($conn);
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
			$nav .= '<li><a href=".">Log In</a></li>';
			$nav .= '<li><a class="active" href="create-account.php">Create Account</a></li>';
			$nav .= '<li><a href="catalog.php">Products</a></li>';
			$nav .= '</ul></nav>';
			return $nav;
		}
	}
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>Create Account</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href='https://fonts.googleapis.com/css?family=Bangers' rel='stylesheet'>
		<script src="js/script.js" defer></script>
	</head>
	
	<body>
		<?php
			if(!isset($_SESSION["granted"]))
			{
				echo createNavigation(isset($_SESSION["granted"]));
				if(!isset($_POST['create']))
				{
					echo createSetupPage(false);
				}
				else
				{
					if(checkUser($_POST['user']))
					{
						addUser($_POST['user'], $_POST['pass']);
						echo createSuccessMessage();
					}
					else
					{
						echo createSetupPage(true);
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