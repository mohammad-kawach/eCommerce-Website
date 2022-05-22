<?php
	ob_start();
	session_start();
	$pageTitle = 'Profile';
	include 'init.php';
	if (isset($_SESSION['user'])) {
		$getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
		//$getUser->execute(array($sessionUser));
		$getUser->execute(array($_SESSION['user']));
		$info = $getUser->fetch();
		//$userid = $info['UserID'];
		//$userav = $info['avatar'];
		//print_r($info);
		if(!empty($info)) {
			$stmt = $con->prepare("SELECT * FROM orders Where user_id = ?");
			$stmt->execute(array($_SESSION['uid']));
			$allOrders = $stmt->fetchAll();
?>
<h1 class="text-center">My Profile <?php echo $_SESSION['user']; ?></h1>
<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Information</div>
			<div class="panel-body">
				<?php if (!empty($info['avatar'])) { ?>
					<img class="img-responsive img-thumbnail img-size" src="<?php echo $avDir . $info['avatar']; ?>" alt="" />
				<?php } else { ?>
					<img class="img-responsive img-thumbnail" src="img.png" alt="" />
				<?php } ?>
				<!--<img class="img-responsive img-thumbnail" src="img.png" alt="" />-->
				<div class="info pull-right col-md-9">
					<ul class="list-unstyled">
						<li>
							<i class="fa fa-unlock-alt fa-fw"></i>
							<span>Login Name</span> : <?php echo $info['Username'] ?>
						</li>
						<li>
							<i class="fa fa-envelope-o fa-fw"></i>
							<span>Email</span> : <?php echo $info['Email'] ?>
						</li>
						<li>
							<i class="fa fa-user fa-fw"></i>
							<span>Full Name</span> : <?php echo $info['FullName'] ?>
						</li>
						<li>
							<i class="fa fa-calendar fa-fw"></i>
							<span>Registered Date</span> : <?php echo $info['Date'] ?>
						</li>
						<li>
							<i class="fa fa-tags fa-fw"></i>
							<span>Fav Category</span> :
						</li>
					</ul>
					<a href="editProfile.php" class="btn btn-default">Edit Information</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="my-ads block">
	<div class="container">
		<!-- Start Orders -->
		<div class="panel panel-primary">
      <!--<h3 class="panel-heading orders-heading" style="margin-top:0;">Orders</h3>-->
			<div class="panel-heading orders-panel-heading">
				<h3 class="orders-heading" style="margin-top:0;">Orders</h3>
				<span class="pull-right toggle-orders">
					<i class="fa fa-plus fa-lg fa-lg"></i>
				</span>
			</div>
			<div class="panel-body panel-body-orders">
				<form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
					<?php if (! empty($allOrders)) {
						foreach ($allOrders as $order) { ?>
							<div class="alert alert-info invoice"  style="margin:15px;">
								<label>Invoice #<?php echo $order['order_id']; ?></label>
								<div class="pull-right invoice-links">
									<input type="number" name="order_id" value="<?php echo $order['order_id'];?>" hidden />
									<a href="invoice.php?orderid=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-success">Show</a>
								</div>
							</div>
						<?php } ?>
					<?php } else { ?>
						<div class="alert alert-danger invoice" style="margin:15px;">There is No Orders</div>
					<?php } ?>
				</form>
			</div>
    </div>
		<!-- End Orders -->
		<div id="my-ads block" class="panel panel-primary">
			<!--<div class="panel-heading">My Items</div>-->
			<div class="panel-heading orders-panel-heading">
				<h3 class="orders-heading" style="margin-top:0;">My Items</h3>
				<span class="pull-right toggle-items">
					<i class="fa fa-plus fa-lg fa-lg"></i>
				</span>
			</div>
			<div class="panel-body panel-body-items">
			<?php
				$myItems = getAllFrom("*", "items", "where Member_ID = {$_SESSION['uid']}", "", "Item_ID");
				if (! empty($myItems)) {
					echo '<div class="row">';
					foreach ($myItems as $item) {
						echo '<div class="col-sm-6 col-md-3">';
							echo '<div class="thumbnail item-box">';
								if ($item['Approve'] == 0) { 
									echo '<span class="approve-status">Waiting Approval</span>'; 
								}
								if (is_null($item['Count']) || $item['Count'] == 0) {
									echo '<span class="OOF">Out Of Stock</span>';
								} else {
									echo '<span class="price-tag">' . $item['Price'] . '$</span>';
								}
								?>
								<!--//echo '<img class="img-responsive" src="'{$ItemsDir . $item["Image"]}'" alt="" />';-->
								<!--<img class="img-responsive" src="<?php echo $ItemsDir . $item['Image'] ?>" alt="" />-->

								<?php if (!empty($item['Image'])) { ?>
									<img class="img-responsive img-thumbnail img-size2" src="<?php echo $ItemsDir . $item['Image']; ?>" alt="" />
								<?php } else { ?>
									<img class="img-responsive img-thumbnail img-size2" src="img.png" alt="" />
								<?php } ?>
								<?php
								echo '<div class="caption">';
									echo '<h3><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] .'</a></h3>';
									echo '<p>' . $item['Description'] . '</p>';
									?>
									<!--echo '<button class="btn btn-sm btn-success pull-left edit-btn"><a href="editItem.php">Edit</a></button>';-->
									<a href="editItem.php?Itemid=<?php echo $item['Item_ID']; ?>" class="btn btn-sm btn-success pull-left edit-btn">Edit</a>
									<?php
									echo '<div class="date">' . $item['Add_Date'] . '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					}
					echo '</div>';
				} else {
					echo '<div class="alert alert-info">Sorry There\' No Ads To Show, Create <a href="newad.php">New Ad</a></div>';
				}
			?>
			</div>
		</div>
		
	</div>
</div>
<div class="my-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<!--<div class="panel-heading">Latest Comments</div>-->
			<div class="panel-heading orders-panel-heading">
				<h3 class="orders-heading" style="margin-top:0;">Latest Comments</h3>
				<span class="pull-right toggle-comments">
					<i class="fa fa-plus fa-lg fa-lg"></i>
				</span>
			</div>
			<div class="panel-body panel-body-comments">
			<?php
				$myComments = getAllFrom("*", "comments", "where user_id = {$_SESSION['uid']}", "", "c_id");
				if (! empty($myComments)) {
					foreach ($myComments as $comment) {
						$itemPage = 'items.php?itemid=' . $comment['item_id'];
						echo '<div class="alert alert-info">' . $comment['comment'] . '<a href="items.php?itemid= '. $comment['item_id'] . '" class="pull-right">Show</a></div>';
					}
				} else {
					echo '<div class="alert alert-danger">There\'s No Comments to Show</div>';
				}
			?>
			</div>
		</div>
	</div>
</div>
<?php
		}
	} else {
		header('Location: login.php');
		exit();
	}
	include $tpl . 'footerDesig.php';
	include $tpl . 'footer.php';
	ob_end_flush();
?>