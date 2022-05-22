<?php
	ob_start();
	session_start();
	$pageTitle = 'Orders';
  include 'init.php';
  if (isset($_SESSION['Username'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $orderID  = $_POST['order_id'];
      $userID   = $_POST['user_id'];

      $stmt = $con->prepare("UPDATE orders
                              SET approve = 1
                              WHERE order_id = ?;"
                            );
      $stmt->execute(array($orderID));

      $stmt2 = $con->prepare("INSERT INTO notifications(u_id, order_id) VALUES(:zuserID, :zorderID)");
      $stmt2->execute(array(
                              'zuserID'   => $userID,
                              'zorderID'  => $orderID
                            ));
    }

    echo '<div class="container">';
    echo '<h1 class="text-center">' . $pageTitle . '</h1>';

    $stmt = $con->prepare("SELECT * FROM orders Where approve = 0");
    $stmt->execute();
		$allOrders = $stmt->fetchAll();

    $stmt2 = $con->prepare("SELECT * FROM orders Where approve = 1");
    $stmt2->execute();
		$approvedOrders = $stmt2->fetchAll();
    ?>
    <div class="panel panel-primary">
      <h3 class="panel-heading orders-heading">Waiting Approval</h3>
      <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <?php if (! empty($allOrders)) {
          foreach ($allOrders as $order) { ?>
            <div class="alert alert-info invoice">
              <label>Invoice #<?php echo $order['order_id']; ?></label>
              <div class="pull-right invoice-links">
                <input type="number" name="order_id" value="<?php echo $order['order_id'];?>" hidden />
                <input type="number" name="user_id" value="<?php echo $order['user_id'];?>" hidden />
                <input type="submit" value="Approve" class="btn btn-sm btn-primary" />
                <a href="invoice.php?orderid=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-success" target="_blank">Show</a>
              </div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <div class="alert alert-danger invoice">All Orders Approved</div>
        <?php } ?>
      </form>
    </div>

    <div class="panel panel-primary">
      <h3 class="panel-heading orders-heading">Approved Orders</h3>
      <?php if (! empty($approvedOrders)) {
          foreach ($approvedOrders as $order) { ?>
            <div class="alert alert-info invoice">
              <label>Invoice #<?php echo $order['order_id']; ?></label>
              <div class="pull-right invoice-links">
                <a href="invoice.php?orderid=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-success">Show</a>
              </div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <div class="alert alert-danger invoice">All Orders Approved</div>
        <?php } ?>
    </div>

<?php
    echo '</div>';
  } else {
    header('Location: index.php');
    exit();
  }

  include $tpl . 'footer.php';
  ob_end_flush(); // Release The Output
?>