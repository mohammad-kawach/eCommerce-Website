<?php
	ob_start();
	session_start();
	$pageTitle = 'Homepage';
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


	/*
		$_SESSION['uid'] 	=> For User ID
		$_SESSION['user'] => For User Name
	*/
?>


<div class="container">

<h1 class="text-center"><?php echo lang('Home_Page'); ?></h1>
	<!-- Start Slider -->
	<!-- Carousel container -->
	<div id="my-pics" class="carousel slide col-sm-12" data-ride="carousel" style="margin:auto;">

		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#my-pics" data-slide-to="0" class="active"></li>
			<li data-target="#my-pics" data-slide-to="1"></li>
			<li data-target="#my-pics" data-slide-to="2"></li>
		</ol>

		<!-- Content -->
		<div class="carousel-inner" role="listbox">

		<!-- Slide 1 -->
		<div class="item active">
			<img src="slides/black2.jpg" alt="Sunset over beach">
		</div>

		<!-- Slide 2 -->
		<div class="item">
			<img src="slides/photo_2021-06-30_17-19-34.jpg" alt="Rob Roy Glacier">
		</div>

		<!-- Slide 3 -->
		<div class="item">
			<img src="slides/Yakkety_Yak_Wallpaper.jpg" alt="Longtail boats at Phi Phi">
		</div>

		</div>

		<!-- Previous/Next controls -->
		<a class="left carousel-control" href="#my-pics" role="button" data-slide="prev">
			<span class="icon-prev" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#my-pics" role="button" data-slide="next">
			<span class="icon-next" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>

	</div>
	<!-- End Slider -->

	<hr class="index-hr">

	<!-- Start Latest Items -->
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">Latest Items</div>
				<div class="panel-body">
				<?php
					$allItems = '';
					if (isset($_SESSION['uid'])) {
						$getAll = $con->prepare("SELECT * FROM items ORDER BY Add_Date DESC LIMIT 8");
						$getAll->execute();
						$allItems = $getAll->fetchAll();
						#$allItems = getAllFrom('*', 'items', 'WHERE Approve = 1', "AND Count > 0 AND Member_ID != {$_SESSION['uid']}", 'Item_ID');
					} else {
						$getAll = $con->prepare("SELECT * FROM items ORDER BY Add_Date DESC LIMIT 8");
						$getAll->execute();
						$allItems = $getAll->fetchAll();
					}
					//$allItems = getAllFrom('*', 'items', 'WHERE Approve = 1', "AND Count > 0 AND Member_ID != {$_SESSION['uid']}", 'Item_ID');
					foreach ($allItems as $item) {
						echo '<div class="col-sm-6 col-md-3">'; ?>
							<form method="post" action="index.php?action=add&id=<?php echo $item['Item_ID'] ?>">
								<?php
								echo '<div class="thumbnail item-box">';
									if (is_null($item['Count']) || $item['Count'] == 0 || $item['Count'] < 0) {
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
										echo '<p>' . $item['Description'] . '</p>';
										?>
										<?php if (isset($_SESSION['uid']) && $item['Count'] > 0 && $_SESSION['uid'] != $item['Member_ID']) { ?>
										<div>
											<input type="number" name="quantity" class="quantity" placeholder="max : <?php echo $item['Count']; ?>" min="0" max="<?php echo $item['Count']; ?>" />
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
	</div>
	<!-- End Latest Items -->


	<!-- Start Featured Items -->
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">Featured Items</div>
				<div class="panel-body">
				<?php
					$allItems = '';
					if (isset($_SESSION['uid'])) {
						$getAll = $con->prepare("SELECT * FROM items WHERE Featured = 1 ORDER BY Add_Date DESC");
						$getAll->execute();
						$allItems = $getAll->fetchAll();
						#$allItems = getAllFrom('*', 'items', 'WHERE Approve = 1', "AND Count > 0 AND Member_ID != {$_SESSION['uid']}", 'Item_ID');
					} else {
						$allItems = getAllFrom('*', 'items', 'WHERE Approve = 1', "AND Count > 0 AND Featured = 1", 'Item_ID');
					}
					//$allItems = getAllFrom('*', 'items', 'WHERE Approve = 1', "AND Count > 0 AND Member_ID != {$_SESSION['uid']}", 'Item_ID');
					foreach ($allItems as $item) {
						echo '<div class="col-sm-6 col-md-3">'; ?>
							<form method="post" action="index.php?action=add&id=<?php echo $item['Item_ID'] ?>">
								<?php
								echo '<div class="thumbnail item-box">';
									if (is_null($item['Count']) || $item['Count'] == 0 || $item['Count'] < 0) {
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
										echo '<p>' . $item['Description'] . '</p>';
										?>
										<?php if (isset($_SESSION['uid']) && $item['Count'] > 0 && $_SESSION['uid'] != $item['Member_ID']) { ?>
										<div>
											<input type="number" name="quantity" class="quantity" placeholder="max : <?php echo $item['Count']; ?>" min="0" max="<?php echo $item['Count']; ?>" />
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
	</div>
	<!-- End Featured Items -->

</div>
<?php
	include $tpl . 'footerDesig.php'; 
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>