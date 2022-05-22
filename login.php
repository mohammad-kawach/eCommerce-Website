<?php
	ob_start();
	session_start();
	$pageTitle = 'Login';
	if (isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	include 'init.php';

	// Check If User Coming From HTTP Post Request

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['login'])) {

			$user = $_POST['username'];
			$pass = $_POST['password'];
			$hashedPass = sha1($pass);

			// Check If The User Exist In Database

			$stmt = $con->prepare("SELECT 
										UserID, Username, Password 
									FROM 
										users 
									WHERE 
										Username = ? 
									AND 
										Password = ?");

			$stmt->execute(array($user, $hashedPass));

			$get = $stmt->fetch();

			$count = $stmt->rowCount();

			// If Count > 0 This Mean The Database Contain Record About This Username

			if ($count > 0) {

				$_SESSION['user'] = $user; 						// Register Session Name
				$_SESSION['uid'] 	= $get['UserID']; 	// Register User ID in Session
				header('Location: index.php'); 				// Redirect To Dashboard Page

				exit();
			}

		} elseif ((isset($_POST['signup']))) {

			$formErrors = array();

			// Upload Variables
			$avatarName = $_FILES['avatar2']['name'];
			$avatarSize = $_FILES['avatar2']['size'];
			$avatarTmp	= $_FILES['avatar2']['tmp_name'];
			$avatarType = $_FILES['avatar2']['type'];

			// List Of Allowed File Typed To Upload
			$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

			// Get Avatar Extension
			$explode 					= explode('.', $avatarName);
			$end 							= end($explode);
			$avatarExtension 	= strtolower($end);

			$username 	= $_POST['username'];
			$fullname		= $_POST['fullname'];
			$password 	= $_POST['password'];
			$password2 	= $_POST['password2'];
			$email 			= $_POST['email'];

			if (isset($username)) {

				$filterdUser = filter_var($username, FILTER_SANITIZE_STRING);

				if (strlen($filterdUser) < 4) {
					$formErrors[] = 'Username Must Be Larger Than 4 Characters';
				}

			}

			if (isset($fullname)) {
				$filterdFull = filter_var($fullname, FILTER_SANITIZE_STRING);

				if (strlen($filterdUser) < 4) {
					$formErrors[] = 'Username Must Be Larger Than 4 Characters';
				}

			}

			if (isset($password) && isset($password2)) {
				if (empty($password)) {
					$formErrors[] = 'Sorry Password Cant Be Empty';
				}
		
				if (sha1($password) !== sha1($password2)) {
					$formErrors[] = 'Sorry Password Is Not Match';
				}

			}

			if (isset($email)) {

				$filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

				if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {

					$formErrors[] = 'This Email Is Not Valid';

				}

			}

			if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
				$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
			}

			if (empty($avatarName)) {
				$formErrors[] = 'Avatar Is <strong>Required</strong>';
			}

			if ($avatarSize > 4194304) {
				$formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
			}

			// Check If There's No Error Proceed The User Add

			if (empty($formErrors)) {

				$avatar2 = rand(0, 10000000000) . '_' . $avatarName;
				move_uploaded_file($avatarTmp, $avDir . $avatar2);

				// Check If User Exist in Database
				$check = checkItem("Username", "users", $username);

				if ($check == 1) {

					$formErrors[] = 'Sorry This User Is Exists';

				} else {

					// Insert Userinfo In Database

					$stmt = $con->prepare("INSERT INTO 
											users(Username, Password, Email, FullName, RegStatus, Date, avatar)
										VALUES(:zuser, :zpass, :zmail, :zfull, 0, now(), :zavatar)");
					$stmt->execute(array(

						'zuser' 	=> $username,
						'zpass' 	=> sha1($password),
						'zfull' 	=> $fullname,
						'zmail' 	=> $email,
						'zavatar' => $avatar2

					));

					// Echo Success Message

					$succesMsg = 'Congrats You Are Now Registerd User';

				}

			} else {
				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}
			}

		}

	}

?>

<div class="container login-page">
	<h1 class="text-center">
		<span class="selected" data-class="login">Login</span> | 
		<span data-class="signup">Signup</span>
	</h1>
	<!-- Start Login Form -->
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<div class="input-container">
			<input 
				class="form-control" 
				type="text" 
				name="username" 
				autocomplete="off"
				placeholder="Type your username" 
				required />
		</div>
		<div class="input-container">
			<input 
				class="form-control" 
				type="password" 
				name="password" 
				autocomplete="new-password"
				placeholder="Type your password" 
				required />
		</div>
		<input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
	</form>
	<!-- End Login Form -->
	<!-- Start Signup Form -->
	<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
		<div class="input-container">
			<input 
				pattern=".{4,}"
				title="Username Must Be Between 4 Chars"
				class="form-control" 
				type="text" 
				name="username" 
				autocomplete="off"
				placeholder="Type your username" 
				required />
		</div>
		<div class="input-container">
			<input 
				pattern=".{4,}"
				title="Username Must Be Between 4 Chars"
				class="form-control" 
				type="text" 
				name="fullname" 
				autocomplete="off"
				placeholder="Type your full name" 
				required />
		</div>
		<div class="input-container">
			<input 
				minlength="4"
				class="form-control" 
				type="password" 
				name="password" 
				autocomplete="new-password"
				placeholder="Type a Complex password" 
				required />
		</div>
		<div class="input-container">
			<input 
				minlength="4"
				class="form-control" 
				type="password" 
				name="password2" 
				autocomplete="new-password"
				placeholder="Type a password again" 
				required />
		</div>
		<div class="input-container">
			<input 
				class="form-control" 
				type="email" 
				name="email" 
				placeholder="Type a Valid email" 
				required />
		</div>
		<!--
		<div class="input-container">
			<input 
				class="form-control" 
				type="file" 
				name="avatar2"
				required />
		</div>
		-->
		<div>
			<div class="custom-file custom-file3 input-container">
				<span>Choose Your Avatar</span>
				<input type="file" name="avatar2" class="form-control signup-avatar" required="required" />
			</div>
		</div>
		<input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" />
	</form>
	<!-- End Signup Form -->
	<div class="the-errors text-center">
		<?php 

			if (!empty($formErrors)) {

				foreach ($formErrors as $error) {

					/*echo '<div class="msg error">' . $error . '</div>';*/
					echo '<div class="alert alert-danger">' . $error . '</div>';

				}

			}

			if (isset($succesMsg)) {

				/*echo '<div class="msg success">' . $succesMsg . '</div>';*/
				echo '<div class="alert alert-success">' . $succesMsg . '</div>';

			}

		?>
	</div>
</div>

<?php 
	include $tpl . 'footer.php';
	ob_end_flush();
?>