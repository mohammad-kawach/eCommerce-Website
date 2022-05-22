<?php
	ob_start();
	session_start();
	$pageTitle = 'Cart';
	include 'init.php';

  if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
      foreach ($_SESSION["shopping_cart"] as $keys => $values) {
        if ($values["item_id"] == $_GET["id"]) {
          unset($_SESSION["shopping_cart"][$keys]);
          echo '<script>alert("Item Removed")</script>';
          echo '<script>window.location="cart.php"</script>';
        }
      }
    }
  }


  /*
  $formErrors = array();

  foreach ($_SESSION["shopping_cart"] as $keys => $values) {
    $item = getAllFrom("*", "items", "WHERE Item_ID = {$values['item_id']}");
    if ($values["item_price"] > $item['Price']) {
      echo 'Too many!';
    }
  }
  */
?>

<div class="container">
  <div class="main">
    <h1 class="text-center">Order Details</h1>
    <?php if (!empty($_SESSION["shopping_cart"])) { ?>
    <div class="table-responsive">
      <table class="table table-bordered">
        <tr>
          <th width="40%">Item Name</th>
          <th width="10%">Quantity</th>
          <th width="20%">Price</th>
          <th width="15%">Total</th>
          <th width="5%">Action</th>
        </tr>
        <?php
        if (!empty($_SESSION["shopping_cart"])) {
          $total = 0;

          foreach ($_SESSION["shopping_cart"] as $keys => $values) { ?>

            <?php if ($values["item_quantity"] > 0) { ?>
              <tr>
                <td><?php echo $values["item_name"]; ?></td>
                <td><?php echo $values["item_quantity"]; ?></td>
                <td><?php echo $values["item_price"]; ?> $</td>
                <td><?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                <td><a href="cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="btn btn-sm btn-danger">Remove</span></a></td>
              </tr>
            <?php } ?>
            
          <?php 
          $total = $total + ($values["item_quantity"] * $values["item_price"]);
          }
          ?>
          <tr>
            <td colspan="3" align="right">Total</td>
            <td align="right"><?php echo number_format($total, 2); ?> $</td>
            <td></td>
          </tr>
          <?php
        }
        ?>
      </table>
      <a href="paymnet.php" class="btn btn-success buy-btn">Buy Now</a>
    </div>
    <?php } else { ?>
      <div class="alert alert-danger text-center">Your Cart Is Empty !</div>
    <?php } ?>
  </div>
</div>

<?php
  #include $tpl . 'footerDesig.php';
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>