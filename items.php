<?php
	ob_start();
	session_start();
	$pageTitle = 'Show Items';
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

	// Check If Get Request item Is Numeric & Get Its Integer Value
	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

	/* IF THE ITEM IS NOT APPROVED */
	$stmt0 = $con->prepare("SELECT items.* FROM items WHERE Item_ID = ? AND Approve = 0");
	// Execute Query
	$stmt0->execute(array($itemid));
	$count0 = $stmt0->rowCount();
	/*---*/


	// Select All Data Depend On This ID
	$stmt = $con->prepare("SELECT 
														items.*, 
														categories.Name AS category_name, 
														categories.Allow_Comment AS commenting,
														users.Username 
													FROM 
														items
													INNER JOIN 
														categories 
													ON 
														categories.ID = items.Cat_ID 
													INNER JOIN 
														users 
													ON 
														users.UserID = items.Member_ID 
													WHERE 
														Item_ID = ?
													AND 
														Approve = 1");

	// Execute Query
	$stmt->execute(array($itemid));

	$count = $stmt->rowCount();

	if ($count > 0) {

	// Fetch The Data
	$item = $stmt->fetch();
?>
<h1 class="text-center"><?php echo $item['Name']; ?></h1>
<div class="container">
	<div class="row">
		<form method="post" action="index.php?action=add&id=<?php echo $item['Item_ID'] ?>">
			<div class="col-md-3">
				<?php if (!empty($item['Image'])) { ?>
					<a href="<?php echo $ItemsDir . $item['Image']; ?>"><img class="img-responsive img-thumbnail center-block item-image" src="<?php echo $ItemsDir . $item['Image']; ?>" alt="" /></a>
				<?php } else { ?>
					<img class="img-responsive img-thumbnail center-block item-image" src="img.png" alt="" />
				<?php } ?>
			</div>
			<div class="col-md-9 item-info">
				<h2><?php echo $item['Name'] ?></h2>
				<p><?php echo $item['Description'] ?></p>
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<span>Added Date</span> : <?php echo $item['Add_Date'] ?>
					</li>
					<li>
						<i class="fa fa-money fa-fw"></i>
						<span>Price</span> : <?php echo $item['Price'] ?>$
					</li>
					<li>
						<i class="fa fa-building fa-fw"></i>
						<span>Made In</span> : <?php echo $item['Country_Made'] ?>
					</li>
					<li>
						<i class="fa fa-tags fa-fw"></i>
						<span>Category</span> : <a class="item_page_links" href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>&pagename=<?php echo $item['category_name'] ?>"><?php echo $item['category_name'] ?></a>
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Added By</span> : <a class="item_page_links" href="otherProfile.php?otherid=<?php echo $item['Member_ID']; ?>"><?php echo $item['Username']; ?></a>
					</li>
					<li class="tags-items">
						<i class="fa fa-tags fa-fw"></i>
						<span>Tags</span> : 
						<?php 
							$allTags = explode(",", $item['tags']);
							foreach ($allTags as $tag) {
								$tag = str_replace(' ', '-', $tag);
								$lowertag = strtolower($tag);
								if (! empty($tag)) {
									echo "<a href='tags.php?name={$lowertag}'>" . $tag . '</a>';
								}
							}
						?>
					</li>
					<li>
						<i class="fa fa-plus-square fa-fw"></i>
						<span>Count</span> : 
						<?php
							if (is_null($item['Count']) || $item['Count'] == 0) {
								echo '<span class="OOS2">Out Of Stock</span>';
							} else {
								echo '<span>' . $item['Count'] . '</span>';
							}
						?>
					</li>
					<?php if (isset($_SESSION['uid']) && $item['Count'] > 0 && !is_null($item['Count']) && $_SESSION['uid'] != $item['Member_ID']) { ?>
					<li>
						<i class="fa fa-cart-plus fa-fw"></i>
						<span>Add To Cart</span> :
						<span class="add_to_card_item_page">
							<input type="number" name="quantity" class="quantity2" placeholder="max : <?php echo $item['Count']; ?>" min="0" max="<?php echo $item['Count']; ?>" />
							<input type="hidden" name="hidden_name" value="<?php echo $item['Name']; ?>" />
							<input type="hidden" name="hidden_price" value="<?php echo $item['Price']; ?>" />
							<input type="submit" name="add_to_cart" style="margin-bottom: 5px;" class="btn btn-primary btn-sm pull-right" value="Add To Cart" />
						</span>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</form>
	<div class="panel panel-primary gallery">
		<h3 class="panel-heading gallery-heading">Gallery</h3>
		<div class="panel-body">
			<?php if (!empty($item['img1'])) { ?>
				<a href="<?php echo $ItemsDir . $item['img1']; ?>"><img class="img-responsive col-sm-8 col-md-4 img-thumbnail gallery-image" src="<?php echo $ItemsDir . $item['img1']; ?>" alt=""/></a>
			<?php } ?>
			<?php if (!empty($item['img2'])) { ?>
				<a href="<?php echo $ItemsDir . $item['img2']; ?>"><img class="img-responsive col-sm-6 col-md-4 img-thumbnail gallery-image" src="<?php echo $ItemsDir . $item['img2']; ?>" alt="" /></a>
			<?php } ?>
			<?php if (!empty($item['img3'])) { ?>
				<a href="<?php echo $ItemsDir . $item['img3']; ?>"><img class="img-responsive col-sm-6 col-md-4 img-thumbnail gallery-image" src="<?php echo $ItemsDir . $item['img3']; ?>" alt="" /></a>
			<?php } ?>
			<?php if (!empty($item['img4'])) { ?>
				<a href="<?php echo $ItemsDir . $item['img4']; ?>"><img class="img-responsive col-sm-6 col-md-4 img-thumbnail gallery-image" src="<?php echo $ItemsDir . $item['img4']; ?>" alt="" /></a>
			<?php } ?>
		</div>
	</div>
	<hr class="custom-hr">
	<?php if (isset($_SESSION['user']) && $item['commenting'] == 0) { ?>
	<!-- Start Add Comment -->
	<div class="row">
		<div class="col-md-offset-3">
			<div class="add-comment">
				<h3>Add Your Comment</h3>
				<form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>" method="POST">
					<textarea name="comment" required></textarea>
					<input class="btn btn-primary" type="submit" value="Add Comment">
				</form>
				<?php 
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {

						$comment 	= filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
						$itemid 	= $item['Item_ID'];
						$userid 	= $_SESSION['uid'];

						if (! empty($comment)) {

							$stmt = $con->prepare("INSERT INTO 
								comments(comment, status, comment_date, item_id, user_id)
								VALUES(:zcomment, 1, NOW(), :zitemid, :zuserid)");

							$stmt->execute(array(

								'zcomment' => $comment,
								'zitemid' => $itemid,
								'zuserid' => $userid

							));

							if ($stmt) {

								echo '<div class="alert alert-success" style="margin-top:15px;">Comment Added</div>';

							}

						} else {
							echo '<div class="alert alert-danger">You Must Add Comment</div>';
						}

					}
				?>
			</div>
		</div>
	</div>
	<!-- End Add Comment -->
	<?php } elseif ($item['commenting'] == 1) {
							echo '<div class="alert alert-danger">Comments Are Not Allowed In This Category</div>';
						} else {
							echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> To Add Comment';
	} ?>
	<hr class="custom-hr">
		<?php

			// Select All Users Except Admin 
			$stmt = $con->prepare("SELECT 
										comments.*, 
										users.Username AS Member ,
										users.avatar AS Avatar
									FROM 
										comments
									INNER JOIN 
										users 
									ON 
										users.UserID = comments.user_id
									WHERE 
										item_id = ?
									AND 
										status = 1
									ORDER BY 
										c_id DESC");

			// Execute The Statement

			$stmt->execute(array($item['Item_ID']));

			// Assign To Variable 

			$comments = $stmt->fetchAll();

		?>
	
	<?php foreach ($comments as $comment) { ?>
		<div class="comment-box">
			<div class="row">
				<div class="col-sm-2 text-center">
					<?php if (!empty($comment['Avatar'])) { ?>
						<img class="img-responsive img-thumbnail img-circle center-block" src="<?php echo $avDir . $comment['Avatar']; ?>" alt="" />
					<?php } else { ?>
						<img class="img-responsive img-thumbnail img-circle center-block" src="img.png" alt="" />
					<?php } ?>
					<!--<img class="img-responsive img-thumbnail img-circle center-block" src="img.png" alt="" />-->
					<?php if ($comment['user_id'] == $_SESSION['uid']) { ?>
						<?php echo "<a class='comment-owner' href='profile.php'>" . $comment['Member'] . "</a>"; ?>
					<?php } else { ?>
						<?php echo "<a class='comment-owner' href='otherProfile.php?otherid={$comment['user_id']}'>" . $comment['Member'] . "</a>"; ?>
					<?php } ?>
				</div>
				<div class="col-sm-10">
					<p class="lead"><?php echo $comment['comment'] ?></p>
				</div>
			</div>
		</div>
		<hr class="custom-hr">
	<?php } ?>
</div>
<?php
	} elseif ($count0 > 0) {
		echo '<div class="container">';
			echo '<h1 class="text-center">Waiting Approval</h1>';
			echo '<div class="alert alert-danger">This Item Is Waiting Approval</div>';
		echo '</div>';
	} else {
		echo '<div class="container">';
			echo '<h1 class="text-center">ERROR 404 NOT FOUND</h1>';
			echo '<div class="alert alert-danger">There\'s No Such Item</div>';
		echo '</div>';
	}
	include $tpl . 'footerDesig.php';
	include $tpl . 'footer.php';
	ob_end_flush();
?>