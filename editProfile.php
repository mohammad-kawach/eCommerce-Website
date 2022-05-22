<?php
	ob_start();
	session_start();
	$pageTitle = 'Edit Profile';
	if (!isset($_SESSION['user'])) {
		header('Location: login.php');
	}
	include 'init.php';
?>


<?php
$userid = isset($_SESSION['uid']) && is_numeric($_SESSION['uid']) ? intval($_SESSION['uid']) : 0;

// Select All Data Depend On This ID

$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

// Execute Query

$stmt->execute(array($userid));

// Fetch The Data

$row = $stmt->fetch();

// The Row Count

$count = $stmt->rowCount();

// If There's Such ID Show The Form

if ($count > 0) { 
?>


<div class="container login-page">
	<h1 class="text-center">Edit Profile Info</h1>
	<!-- Start Signup Form -->
	<form class="Edit" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
		<div class="input-container">
			<input 
				pattern=".{4,}"
				title="Username Must Be Between 4 Chars"
				class="form-control" 
				type="text" 
				name="username" 
				autocomplete="off"
				placeholder="Type your username" 
        value="<?php echo $row['Username'] ?>" />
		</div>
		<div class="input-container">
			<input 
				pattern=".{4,}"
				title="Fullname Must Be Between 4 Chars"
				class="form-control" 
				type="text" 
				name="fullname" 
				autocomplete="off"
				placeholder="Type your full name" 
        value="<?php echo $row['FullName'] ?>" />
		</div>
		<div class="input-container">
      <input 
        class="form-control"
        type="hidden" 
        name="oldpassword" 
        value="<?php echo $row['Password'] ?>" />
			<input 
				minlength="4"
				class="form-control" 
				type="password" 
				name="password" 
				autocomplete="new-password"
				placeholder="Leave Blank If You Dont Want To Change The Password" />
		</div>
		<div class="input-container">
			<input 
				class="form-control" 
				type="email" 
				name="email" 
				placeholder="Type a Valid email" 
        value="<?php echo $row['Email'] ?>" />
		</div>
    <!--
		<div class="input-container">
      <input 
        class="form-control"
        type="hidden" 
        name="oldavatar" 
        value="<?php echo $row['avatar'] ?>" />	
      <input 
        class="form-control" 
        type="file" 
        name="newavatar" />
		</div>
    -->
    <!-- Old Avatar -->
    <div style="display:none;">
      <input type="file" name="oldavatar" class="form-control" value="<?php echo $row['avatar'] ?>" />
    </div>
		<!-- New Avatar -->
    <div>
			<div class="custom-file custom-file2 input-container">
				<span>Choose Your Avatar</span>
				<input type="file" name="newavatar" class="form-control" />
			</div>
		</div>
		<input class="btn btn-success btn-block" name="signup" type="submit" value="Edit Profile" />
	</form>
	<!-- End Signup Form -->
</div>
<?php
}
?>

<?php 
  /* ------------------------------------------------------------------------ */
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $avatarName = $_FILES['newavatar']['name'];
    $avatarSize = $_FILES['newavatar']['size'];
    $avatarTmp	= $_FILES['newavatar']['tmp_name'];
    $avatarType = $_FILES['newavatar']['type'];

    // Get Variables From The Form
    $username 	    = $_POST['username'];
    $email 	        = $_POST['email'];
    $fullName 	    = $_POST['fullname'];

    // Password Trick
    $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
    
    // Validate The Form
    $formErrors = array();

    if (strlen($username) < 4) {
      $formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
    }

    if (strlen($username) > 20) {
      $formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
    }

    if (empty($username)) {
      $formErrors[] = 'Username Cant Be <strong>Empty</strong>';
    }

    if (empty($fullName)) {
      $formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
    }

    if (empty($email)) {
      $formErrors[] = 'Email Cant Be <strong>Empty</strong>';
    }

    // Loop Into Errors Array And Echo It

    foreach($formErrors as $error) {
      echo '<div class="alert alert-danger">' . $error . '</div>';
    }

    // Check If There's No Error Proceed The Update Operation

    if (empty($formErrors)) {

      global $avatar2;

      if (!empty($avatarName)) {
        $avatar2 = rand(0, 10000000000) . '_' . $avatarName;
        move_uploaded_file($avatarTmp, $avDir . $avatar2);
      }


      $stmt2 = $con->prepare("SELECT 
                    *
                  FROM 
                    users
                  WHERE
                    Username = ?"
                  );

      $stmt2->execute(array($username));

      $count = $stmt2->rowCount();

      if (!empty($avatarName)) {

        // Update The Database With This Info
        $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ?, avatar = ? WHERE UserID = ?");
        $stmt->execute(array($username, $email, $fullName, $pass, $avatar2, $_SESSION['uid']));

        // Echo Success Message
        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

        //redirectHome($theMsg, 'back');
        header("Location: logout.php"); 
      } else {

        // Update The Database With This Info
        $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
        $stmt->execute(array($username, $email, $fullName, $pass, $_SESSION['uid']));

        // Echo Success Message
        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

        //redirectHome($theMsg, 'back');
        header("Location: logout.php"); 

      }
  }
  
}
  
  /* ----------------------------------------------------------------------------------------------- */


  #include $tpl . 'footerDesig.php';
	include $tpl . 'footer.php';
	ob_end_flush();
?>