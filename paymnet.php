<?php
	ob_start();
	session_start();
	$pageTitle = 'Payment';
	include 'init.php';
?>

<?php if (isset($_SESSION["shopping_cart"]) && !empty($_SESSION["shopping_cart"])) { 

  $totalPrice = 0;

  foreach ($_SESSION["shopping_cart"] as $keys => $values) {

    $formErrors = array();

    $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");
    $stmt->execute(array($values['item_id']));
    $oldItem = $stmt->fetchAll();
    
    $newCount = 0;

    foreach ($oldItem as $old) {
      #echo $old['Name'] . ' : ' . $old['Count'] . '<br>';
      
    #$stmt2 = $con->prepare("UPDATE items SET Count");
    #$stmt2->execute();


    $totalPrice = $totalPrice + ($values["item_quantity"] * $values["item_price"]);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    $country  = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
    $city     = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
    $address  = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    $phone 		= filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);

    $items_array = serialize($_SESSION["shopping_cart"]);

    if (empty($country)) {
      $formErrors[] = 'Country Name Can Not Be Empty';
    }

    if (strlen($country) < 3) {
      $formErrors[] = 'Country Name Can Not Be Less Than 3 Character';
    }

    if (strlen($country) > 20) {
      $formErrors[] = 'Country Name Can Not Be More Than 20 Character';
    }

    if (empty($city)) {
      $formErrors[] = 'City Name Can Not Be Empty';
    }

    if (strlen($city) < 3) {
      $formErrors[] = 'City Name Can Not Be Less Than 3 Character';
    }

    if (strlen($city) > 20) {
      $formErrors[] = 'City Name Can Not Be More Than 20 Character';
    }

    if (empty($address)) {
      $formErrors[] = 'Address Can Not Be Empty';
    }

    if (strlen($address) < 3) {
      $formErrors[] = 'Address Can Not Be Less Than 3 Character';
    }

    if (strlen($address) > 30) {
      $formErrors[] = 'Address Can Not Be More Than 20 Character';
    }

    if (empty($phone)) {
      $formErrors[] = 'Phone Can Not Be Empty';
    }

    if (strlen($phone) < 5) {
      $formErrors[] = 'Phone Can Not Be Less Than 5 Digits';
    }

    if (strlen($phone) > 25) {
      $formErrors[] = 'Phone Can Not Be More Than 25 Digits';
    }

    if (empty($items_array)) {
      $formErrors[] = 'Your Cart Can Not Be Empty';
    }

    // If There Is No Errors
    if (empty($formErrors)) {
      // Insert Into Database

      $stmt = $con->prepare("INSERT INTO 
                              orders (user_id, country, city, address, phone, items_arr, price, approve, date) 
                              VALUES (:zuid, :zcountry, :zcity, :zaddress, :zphone, :zitems, :zprice, 0, now())");

      $stmt->execute(array(
        'zuid' 		  => $_SESSION['uid'],
        'zcountry'  => $country,
        'zcity'     => $city,
        'zaddress'  => $address,
        'zphone'    => $phone,
        'zitems'    => $items_array,
        'zprice'    => $totalPrice
      ));

      $newCount = 0;
      
      $stmt2 = $con->prepare("UPDATE items SET Count = ? WHERE Item_ID = ?");
      $stmt2->execute(array($newCount, $old['Item_ID']));

      $oldMemberID  = $old['Member_ID'];
      $oldItemID    = $old['Item_ID'];

      if ($newCount == 0) {
        $stmt3 = $con->prepare("INSERT INTO notifications (u_id, item_id, out_of_stock) VALUES (:zuserid, :zitemid, 1)");
        $stmt3->execute(array(
          'zuserid' =>  $oldMemberID,
          'zitemid' =>  $oldItemID
          ));
      }
    }
    
    $newCount = 0;

    unset($_SESSION["shopping_cart"]);
    
    echo '<div class="container">';
      echo '<h1 class="text-center">Payment</h1>';
      echo "<div class='alert alert-success'>We Have Recieved Your Order.</div>";
      echo "<div class='alert alert-info'>You Will Be Redirected to Home PAge After 5 Seconds.</div>";
    echo '</div>';
    header("refresh:5;url=index.php");
    exit();

    } else {
      foreach ($formErrors as $error) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
      }
    }
  }

  ?>
  <h1 class="text-center">Enter Your Payment Details</h1>
  <div class="container">
    <!--<form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">-->
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
      <div class="panel panel-primary">
        <h4 class="panel-heading payment-h4">Your Information</h4>
        <!-- Start Country Field --> 
        <div class="form-group form-group-lg info-panel">
          <label class="col-sm-1 control-label">Country</label>
          <div class="col-sm-offset-1 col-sm-10 col-md-9">
            <input 
              pattern=".{3,20}"
              title="This Field Require At Least 3 And Less Than 19 Characters"
              type="text" 
              name="country" 
              class="form-control live payment-input pull-right"  
              placeholder="Country Name"
              data-class=".live-title"
              data-info = "payment"
              required />
              <span class="asterisk-payment">*</span>
          </div>
        </div>
        <!-- End Country Field -->
        <!-- Start City Field --> 
        <div class="form-group form-group-lg info-panel">
          <label class="col-sm-1 control-label">City</label>
          <div class="col-sm-offset-1 col-sm-10 col-md-9">
            <input 
              pattern=".{3,20}"
              title="This Field Require At Least 3 And Less Than 19 Characters"
              type="text" 
              name="city" 
              class="form-control live payment-input pull-right"  
              placeholder="City Name"
              data-class=".live-title"
              data-info = "payment"
              required />
              <span class="asterisk-payment">*</span>
          </div>
        </div>
        <!-- End City Field -->
        <!-- Start Street Address Field --> 
        <div class="form-group form-group-lg info-panel">
          <label class="col-sm-1 control-label">Address</label>
          <div class="col-sm-offset-1 col-sm-10 col-md-9">
            <input 
              pattern=".{3,30}"
              title="This Field Require At Least 3 And Less Than 19 Characters"
              type="text" 
              name="address" 
              class="form-control live payment-input pull-right"  
              placeholder="Address"
              data-class=".live-title"
              data-info = "payment"
              required />
              <span class="asterisk-payment">*</span>
          </div>
        </div>
        <!-- End Street Address Field -->
        <!-- Start Phone Field --> 
        <div class="form-group form-group-lg info-panel">
          <label class="col-sm-1 control-label">Phone</label>
          <div class="col-sm-offset-1 col-sm-10 col-md-9">
            <input 
              pattern=".{5,25}"
              title="This Field Require At Least 5 And Not More Than 25 Characters"
              type="number" 
              name="phone" 
              class="form-control live payment-input pull-right"  
              placeholder="Phone Number"
              data-class=".live-title"
              data-info = "payment"
              required />
              <span class="asterisk-payment">*</span>
          </div>
        </div>
        <!-- End Phone Field -->
        <input type="submit" class="btn btn-success payment-submit" />
      </div>
    </form>
    
  <!-- Start Loopiong Through Errors -->
  <?php 
    if (! empty($formErrors)) {
      echo '<div class="container">';
      foreach ($formErrors as $error) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
      }
      echo '</div>';
    }
  ?>
  <!-- End Loopiong Through Errors -->
  </div>
<?php } else { ?>
  <div class="container">
    <h1 class="text-center">Enter Your Payment Details</h1>
    <div class="alert alert-danger">Your Cart Is Empty</div>
  </div>
<?php } ?>

<?php
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>