<?php
	ob_start();
	session_start();
	$pageTitle = 'All Items';
	include 'init.php';

  if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
  }

	/* Start Cart */
	if (isset($_POST['add_to_cart'])) {
		if (isset($_SESSION["shopping_cart"])) {
			$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");

			if (!in_array($_GET["id"], $item_array_id)) {
				$count = count($_SESSION["shopping_cart"]);
				$item_array = array(
					'item_id' 			=> $_GET["id"],
					'item_name' 		=> $_POST["hidden_name"],
					'item_price' 		=> $_POST["hidden_price"],
					'item_quantity' => $_POST['quantity']
				);

				$_SESSION["shopping_cart"][$count] = $item_array;
			} else {
				echo '<script>window.alert("Item Already Added !.");</script>';
				echo '<script>window.location="index.php"</script>';
			}

		} else {
			$item_array = array(
				'item_id' 			=> $_GET["id"],
				'item_name' 		=> $_POST["hidden_name"],
				'item_price' 		=> $_POST["hidden_price"],
				'item_quantity' => $_POST['quantity']
			);

			$_SESSION["shopping_cart"][0] = $item_array;
		}
	}
	/* End Cart */


	/*
		$_SESSION['uid'] 	=> For User ID
		$_SESSION['user'] => For User Name
	*/
?>


<div class="container">

<h1 class="text-center">All Items</h1>
	<div class="row">
		<?php
    
			$allItems = '';

      $allItems = getAllFrom('*', 'items', 'WHERE Approve = 1', "", 'Add_Date');

			//$allItems = getAllFrom('*', 'items', 'WHERE Approve = 1', "AND Count > 0 AND Member_ID != {$_SESSION['uid']}", 'Item_ID');
			foreach ($allItems as $item) {
        $theCount = $item['Count'];
				echo '<div class="col-sm-6 col-md-3">'; ?>
					<form method="post" action="index.php?action=add&id=<?php echo $item['Item_ID'] ?>">
						<?php
						echo '<div class="thumbnail item-box item-size">';
							if (is_null($item['Count']) || $item['Count'] < 0 || $item['Count'] = 0) {
								echo '<span class="OOF">Out Of Stock</span>';
							} else {
								echo '<span class="price-tag">' . $item['Price'] . '$</span>';
							}
							if (empty($item['Image'])) { ?>
								<img class="img-responsive img-product" src="img.png" alt="" />
							<?php } else { ?>
								<img class="img-responsive img-product" src="<?php echo $ItemsDir . $item['Image']; ?>" alt="" />
							<?php }
							echo '<div class="caption">';
								echo '<h3 style="margin-top: 0px;"><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] .'</a></h3>';
								#echo '<p>' . $item['Description'] . '</p>';
                if ($theCount > 0 && $item['Member_ID'] != $_SESSION['uid']) { ?>
                  <div>
                    <input type="number" name="quantity" class="quantity" placeholder="max:<?php echo $theCount; ?>" min="0" max="<?php echo $theCount; ?>" />
                    <input type="hidden" name="hidden_name" value="<?php echo $item['Name']; ?>" />
                    <input type="hidden" name="hidden_price" value="<?php echo $item['Price']; ?>" />
                    <input type="submit" name="add_to_cart" style="margin-bottom: 5px;" class="btn btn-primary btn-sm pull-right" value="Add To Cart" />
                  </div>
								<?php } else { ?>
									<div class="date" style="margin-top: 21.44px;"><?php echo $item['Add_Date']; ?></div>
								<?php } ?>
								<?php
								/*echo '<div class="date" style="margin-top: 10px;">' . $item['Add_Date'] . '</div>';*/
							echo '</div>';	
						echo '</div>';
					echo '</form>';
				echo '</div>';
			}
		?>
	</div>
</div>
<?php
	include $tpl . 'footerDesig.php';
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>