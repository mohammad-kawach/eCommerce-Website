<?php 
	ob_start();
	session_start();
	#$pageName = $_GET['pagename'];
	#$pageTitle = $pageName;
	$pageTitle = $_GET['pagename'];
	include 'init.php';

	if (!isset($_SESSION['user'])) {
		header("Location: index.php");
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
?>

<div class="container">
	<h1 class="text-center"><?php echo $_GET['pagename']; ?></h1>
	<div class="row">
		
			<?php
			if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
				$category = intval($_GET['pageid']);
				$allItems = getAllFrom("*", "items", "where Cat_ID = {$category}", "AND Member_ID != {$_SESSION['uid']} AND Approve = 1", "Item_ID");
				if (! empty($allItems)) {
					foreach ($allItems as $item) { ?>
						<form method="post" action="index.php?action=add&id=<?php echo $item['Item_ID'] ?>">
						<?php echo '<div class="col-sm-6 col-md-3">';
							echo '<div class="thumbnail item-box">';
								echo '<span class="price-tag">' . $item['Price'] . '$</span>';
								if (isset($item['Image'])) { ?>
									<img class="img-responsive img-product" src="<?php echo $ItemsDir . $item['Image']; ?>" alt="" />
								<?php } else {
									echo '<img class="img-responsive img-product" src="img.png" alt="" />';
								}
								echo '<div class="caption">';
									echo '<h3><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] .'</a></h3>';
									echo '<p>' . $item['Description'] . '</p>'; ?>
									<?php if (isset($_SESSION['uid'])) { ?>
										<div>
											<input type="number" name="quantity" class="quantity" placeholder="max : <?php echo $item['Count']; ?>" min="0" max="<?php echo $item['Count']; ?>" />
											<input type="hidden" name="hidden_name" value="<?php echo $item['Name']; ?>" />
											<input type="hidden" name="hidden_price" value="<?php echo $item['Price']; ?>" />
											<input type="submit" name="add_to_cart" style="margin-bottom: 5px;" class="btn btn-primary btn-sm pull-right" value="Add To Cart" />
										</div>
									<?php } else {?>
										<div class="date"><?php echo $item['Add_Date'] ?></div>
									<?php } ?>
								<?php
								echo '</div>';
							echo '</div>';
						echo '</div>';
						echo '</form>';
					}
				} else { 
					echo'<div class="alert alert-danger">There Is No Items In This Categories Right Now !.</div>';
				}
				
			} else {
				echo 'You Must Add Page ID';
			}
			?>
	</div>
</div>

<?php 
	#include $tpl . 'footerDesig.php';
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>