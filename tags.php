<?php 
	session_start();
	include 'init.php';

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
	<div class="row">
		<?php
		if (isset($_GET['name'])) {
			$tag = str_replace('-', ' ', $_GET['name']);
			//$tag = $_GET['name'];
			//echo "<h1 class='text-center'>" . $tag . "</h1>";
			$tagItems = getAllFrom("*", "items", "WHERE tags like '%$tag%'", "AND Approve = 1", "Item_ID");
			if (!empty($tagItems)) {
				echo "<h1 class='text-center'>" . $tag . "</h1>";
				foreach ($tagItems as $item) {
					echo '<div class="col-sm-6 col-md-3">'; ?>
						<form method="post" action="index.php?action=add&id=<?php echo $item['Item_ID'] ?>">
						<?php
							echo '<div class="thumbnail item-box">';
							if ($item['Count'] > 0) {
								echo '<span class="price-tag">' . $item['Price'] . '$</span>';
							} else {
								echo '<span class="OOF">Out Of Stock</span>';
							}
								#echo '<img class="img-responsive" src="img.png" alt="" />';
								if (!empty($item['Image'])) { ?>
									<img class="img-responsive img-thumbnail img-size" src="<?php echo $ItemsDir . $item['Image']; ?>" alt="" />
								<?php } else { ?>
									<img class="img-responsive img-thumbnail" src="img.png" alt="" />
								<?php } if ($item['Count'] > 0) {
								echo '<div class="caption">';
									echo '<h3><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] .'</a></h3>';
									echo '<p>' . $item['Description'] . '</p>';
									?>
									<?php if (isset($_SESSION['uid'])) { ?>
									<div>
										<input type="number" name="quantity" class="quantity" placeholder="max : <?php echo $item['Count']; ?>" min="0" max="<?php echo $item['Count']; ?>" />
										<input type="hidden" name="hidden_name" value="<?php echo $item['Name']; ?>" />
										<input type="hidden" name="hidden_price" value="<?php echo $item['Price']; ?>" />
										<input type="submit" name="add_to_cart" style="margin-bottom: 5px;" class="btn btn-primary btn-sm pull-right" value="Add To Cart" />
									</div>
									<?php } else { ?>
										<div class="date" style="margin-top: 10px;"><?php echo $item['Add_Date']; ?></div>
									<?php } ?>
									<?php
									/*echo '<div class="date" style="margin-top: 10px;">' . $item['Add_Date'] . '</div>';*/
								echo '</div>';
								} else {
									echo '<div class="caption">';
										echo '<h3><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] .'</a></h3>';
										echo '<p>' . $item['Description'] . '</p>';
										echo '<div class="date">' . $item['Add_Date'] . '</div>';
									echo '</div>';
								}
							echo '</div>';
						echo '</form>';
					echo '</div>';
				}
			} else {
				echo '<div class="alert alert-danger" style="margin-top:25px;">Ther Is No Items Belong To This Tag.</div>';
			}
			
		} else {
			echo '<div class="alert alert-danger" style="margin-top:25px;">You Must Enter Tag Name</div>';
		}
		?>
	</div>
</div>

<?php include $tpl . 'footer.php'; ?>