<?php
  ob_start();
	session_start();
	$pageTitle = 'Invoices';
	include 'init.php';

	if (! isset($_SESSION['uid'])) {
		header('Location: login.php');
	}

  if (! isset($_GET['orderid']) || empty($_GET['orderid'])) {
		header('Location: index.php');
	}

  $stmt = $con->prepare("SELECT * FROM orders WHERE order_id = ?");
  $stmt->execute(array($_GET['orderid']));
  $orderInfos = $stmt->fetchAll();

  foreach ($orderInfos as $order) {

    $stmt2 = $con->prepare("SELECT * FROM users WHERE UserID = ?");
    $stmt2->execute(array($_SESSION['uid']));
    $userAvatars = $stmt2->fetchAll();
    $items_info = unserialize($order['items_arr']);

    foreach ($userAvatars as $avatar) { 

?>

<div class="container">
  <div class="col-md-12">   
    <div class="row">
      
      <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
        <div class="row">
          <div class="receipt-header">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="receipt-left">
                <!--<img class="img-responsive" alt="iamgurdeeposahan" src="https://bootdey.com/img/Content/avatar/avatar6.png" style="width: 71px; border-radius: 43px;">-->
                <?php if (!empty($avatar['avatar'])) { ?>
                  <img class="img-responsive invoice-img" alt="iamgurdeeposahan" src="<?php echo $avDir . $avatar['avatar']; ?>" style="width: 71px; border-radius: 43px;">
                <?php } else { ?>
                  <img class="img-responsive invoice-img" alt="iamgurdeeposahan" src="img.png" style="width: 71px; border-radius: 43px;">
                <?php } ?>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
              <div class="receipt-right">
                <h5>eCommerce</h5>
                <p>+1 3649-6589 <i class="fa fa-phone"></i></p>
                <p>eCommerce@gmail.com <i class="fa fa-envelope-o"></i></p>
                <p>SYRIA <i class="fa fa-location-arrow"></i></p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="receipt-header receipt-header-mid">
            <div class="col-xs-8 col-sm-8 col-md-8 text-left">
              <div class="receipt-right">
                <h5><?php echo $avatar['Username']; ?></h5>
                <!--<p><b>Mobile :</b> +1 12345-4569</p>-->
                <p><b>Email :</b> <?php echo $avatar['Email']; ?></p>
                <!--<p><b>Address :</b> New York, USA</p>-->
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4">
              <div class="receipt-left">
                <h3>INVOICE #<?php echo $order['order_id']; ?></h3>
              </div>
            </div>
          </div>
        </div>
        
        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th width="45%">Item Name</th>
                    <th width="15%">Quantity</th>
                    <th width="25%">Price</th>
                    <th width="15%">Total</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($items_info as $item) { ?>
                    <tr>
                      <td><?php echo $item['item_name']; ?></td>
                      <td><?php echo $item['item_quantity']; ?></td>
                      <td><?php echo $item['item_price']; ?></td>
                      <td><?php echo $item['item_quantity'] * $item['item_price']; ?></td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td colspan="2" class="text-right"><h5><strong>Total: </strong></h5></td>
                    <td colspan="2" class="text-left text-danger"><h5><strong><?php echo $order['price']; ?> <i class="fa fa-dollar"></i></strong></h2></td>
                  </tr>
                </tbody>
            </table>
        </div>
        
        <div class="row">
          <div class="receipt-header receipt-header-mid receipt-footer">
            <div class="col-xs-8 col-sm-8 col-md-8 text-left">
              <div class="receipt-right">
                <p><b>Date :</b> <?php echo $order['date']; ?></p>
                <h5 style="color: rgb(140, 140, 140);">Thanks for shopping.!</h5>
              </div>
            </div>
            <!--
            <div class="col-xs-4 col-sm-4 col-md-4">
              <div class="receipt-left">
                <h1>Stamp</h1>
              </div>
            </div>
            -->
          </div>
        </div>
        
      </div>    
      
    </div>
  </div>
</div>


<?php
    include $tpl . 'footerDesig.php';
    }
  }
  
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>