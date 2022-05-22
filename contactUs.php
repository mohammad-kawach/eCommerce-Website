<?php
	ob_start();
	session_start();
	$pageTitle = 'Contact Us';
	if (! isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	include 'init.php';

  // Check if User Coming From A Request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Assign Variables
    $user = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $mail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $cell = filter_var($_POST['cellphone'], FILTER_SANITIZE_NUMBER_INT);
    $msg  = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
    
    // Creating Array of Errors
    $formErrors = array();
    if (strlen($user) <= 3) {
      $formErrors[] = 'Username Must Be Larger Than <strong>3</strong> Characters';
    }
    if (strlen($msg) < 10) {
      $formErrors[] = 'Message Can\'t Be Less Than <strong>10</strong> Characters'; 
    }
    
    // If No Errors Send The Email [ mail(To, Subject, Message, Headers, Parameters) ]
    
    $headers = 'From: ' . $mail . '\r\n';
    $myEmail = 'mohmad.kawach.777@gmail.com';
    $subject = 'Contact Form';
    
    if (empty($formErrors)) {
      mail($myEmail, $subject, $msg, $headers);
      
      $user = '';
      $mail = '';
      $cell = '';
      $msg = '';
      
      $success = '<div class="alert alert-success">We Have Recieved Your Message</div>';
    }
  
  }

  $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

  // Execute Query
  $stmt->execute(array($_SESSION['uid']));

  // Fetch The Data
  $user = $stmt->fetch();
?>

<!-- Start Form -->
        
<div class="container">
  <h1 class="text-center">Contact Us</h1>
  <form class="contact-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <?php if (! empty($formErrors)) { ?>
        <div class="alert alert-danger alert-dismissible" role="start">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <?php
                foreach($formErrors as $error) {
                    echo $error . '<br/>';
                }
            ?>
        </div>
      <?php } ?>
      <?php if (isset($success)) { echo $success; } ?>
      <div class="form-group">
        <input 
            class="username form-control" 
            type="text" 
            name="username" 
            placeholder="Type Your Username"
            value="<?php if (isset($_SESSION['user'])) { echo $user['Username']; } ?>" />
        <i class="fa fa-user fa-fw"></i>
        <span class="asterisx">*</span>
        <div class="alert alert-danger custom-alert">
          Username Must Be Larger Than <strong>3</strong> Characters
        </div>
      </div>
      <div class="form-group">
        <input 
          class="email form-control" 
          type="email" 
          name="email" 
          placeholder="Please Type a Valid Email" 
          value="<?php if (isset($_SESSION['user'])) { echo $user['Email']; } ?>" />
        <i class="fa fa-envelope fa-fw"></i>
        <span class="asterisx">*</span>
        <div class="alert alert-danger custom-alert">
          Email Can't Be <strong>Empty</strong>
        </div>
      </div>
      <input 
          class="form-control" 
          type="text" 
          name="cellphone" 
          placeholder="Type Your Cell Phone" 
          value="<?php if (isset($cell)) { echo $cell; } ?>" />
      <i class="fa fa-phone fa-fw"></i>
      <div class="form-group">
        <textarea 
              class="message form-control" 
              name="message"
              placeholder="Your Message!"><?php if (isset($msg)) { echo $msg; } ?></textarea>
        <span class="asterisx">*</span>
        <div class="alert alert-danger custom-alert">
            Message Can\'t Be Less Than <strong>10</strong> Characters
        </div>
      </div>
      <input 
        class="btn btn-success" 
        type="submit" 
        value="Send Message" />
      <i class="fa fa-send fa-fw send-icon"></i>
  </form>
</div>
<!-- End Form -->

<?php 
  include $tpl . 'footerDesig.php';
	include $tpl . 'footer.php';
	ob_end_flush();
?>
