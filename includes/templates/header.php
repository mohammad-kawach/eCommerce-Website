
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title><?php getTitle(); ?></title>
		<link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css" />
		<link rel="stylesheet" href="<?php echo $css ?>front.css" />
	</head>
	<body>
	<div class="upper-bar">
		<div class="container">
			<?php 
				if (isset($_SESSION['user'])) { 
					//echo $_SESSION['uid'];
					//echo $sessionUser;
					$stmt = $con->prepare("SELECT Username, avatar FROM users WHERE Username = ?");
					$stmt->execute(Array($sessionUser));
					$all = $stmt->fetchAll();
					?>

				<?php if (!empty($all)) { 
					foreach($all as $a){ ?>
						<?php if (!empty($a['avatar'])) {  ?>
							<img class="my-image img-thumbnail img-circle" src="<?php echo $avDir . $a['avatar']; ?>" alt="" />
						<?php } else { ?>
							<img class="my-image img-thumbnail img-circle" src="img.png" alt="" />
						<?php } ?>
					<?php } ?>
				<?php } ?>
				<div class="btn-group my-info">
					<span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<?php echo $sessionUser; ?>
						<span class="caret"></span>
					</span>
					<ul class="dropdown-menu user-dropdown  user-dropdown2">
						<li><a class="user-link" href="profile.php"><i class="fa fa-user" aria-hidden="true"></i> | My Profile</a></li>
						<li><a class="user-link" href="newad.php"><i class="fa fa-plus" aria-hidden="true"></i> | New Item</a></li>
						<li><a class="user-link" href="profile.php#my-ads"><i class="fa fa-check" aria-hidden="true"></i> | My Items</a></li>
						<li><a class="user-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> | Logout</a></li>
					</ul>
				</div>

				<div class="btn-group my-notifications pull-right">
					<span class="btn btn-default btn-notifications dropdown-toggle" data-toggle="dropdown">
						Notifications
						<span class="caret"></span>
					</span>
					<?php
						$stmt = $con->prepare("SELECT * FROM notifications WHERE u_id = ? ORDER BY notification_id DESC");
						$stmt->execute(array($_SESSION['uid']));
						$notis = $stmt->fetchAll();
						$notisCount = $stmt->rowCount();
					?>

					<div class="notis-rect"></div>
					<ul class="dropdown-menu user-dropdown notifications-dropdown">
						<?php foreach ($notis as $noti) { ?>
							<?php if ($notisCount > 0) { ?>
								<?php if (!empty($noti['item_id']) && empty($noti['out_of_stock'])) { ?>
									<li><a class="user-link" href="items.php?itemid=<?php echo $noti['item_id']; ?>"><i class="fa fa-check" aria-hidden="true"></i> | your item has approved</a></li>
								<?php } elseif (!empty($noti['user_approve'])) { ?>
									<li><a class="user-link" href="profile.php"><i class="fa fa-thumbs-up" aria-hidden="true"></i> | your account has been activated</a></li>
								<?php } elseif (!empty($noti['comm_id'])) { ?>
									<li><a class="user-link" href="#"><i class="fa fa-check" aria-hidden="true"></i> | your comment has been approved</a></li>
								<?php } elseif (!empty($noti['order_id'])) { ?>
									<li><a class="user-link" href="invoice.php?orderid=<?php echo $noti['order_id']; ?>"><i class="fa fa-car" aria-hidden="true"></i> | your Order has been approved</a></li>
								<?php } elseif (!empty($noti['out_of_stock']) && $noti['out_of_stock'] == 1) { ?>
									<li><a class="user-link" href="editItem.php?Itemid=<?php echo $noti['item_id']; ?>"><i class="fa fa-info" aria-hidden="true"></i> | your item is out of stock</a></li>
								<?php } ?>
							<?php } elseif ($notisCount == 0) { ?>
								<li><a class="user-link" href="#">your account has not activated yet</a></li>
							<?php } ?>
						<?php } ?>
					</ul>
				</div>
				
				<?php
				} else {
			?>
			<a  class="btn btn-default pull-right" href="login.php">
				<span>Login / Signup</span>
			</a>
			<?php } ?>
		</div>
	</div>
	<nav class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button 
						type="button" 
						class="navbar-toggle collapsed" 
						data-toggle="collapse" 
						data-target="#app-nav" 
						aria-expanded="false">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"><i class="fa fa-skyatlas" aria-hidden="true"></i> SHOPIFY</a>
					<form class="navbar-form navbar-left" action="searchPage.php" method="POST">
						<div class="form-group">
							<input type="text" name="searchInput" class="form-control" placeholder="Search" />
						</div>
						<button  class="btn btn-primary">
							<input type="submit" value="" class="submit" />
							<i class="fa fa-search" aria-hidden="true"></i>
						</button>
					</form>
			</div>
			<div class="collapse navbar-collapse" id="app-nav">
				<ul class="nav navbar-nav navbar-right">
					<!--
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo lang('LANGUAGES'); ?><span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li>
								<a href="#"><?php $language = "en"; echo lang('ENGLISH'); ?></a>
								<a href="#"><?php $language = "ar"; echo lang('ARABIC'); ?></a>
							</li>
						</ul>
					</li>
					-->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo lang('CATEGORIES'); ?><span class="caret"></span></a>
						<ul class="dropdown-menu categories-dropdown">
							<li>
								<a href="allItems.php">All Items</a>
							</li>
							<?php
								$allCats = getAllFrom("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
								foreach ($allCats as $cat) { ?>
								<li>
									<?php
									echo '<a href="categories.php?pageid=' . $cat['ID'] . '&pagename=' . $cat['Name'] . '">';
										echo $cat['Name'];
									echo '</a>'
									?>
								</li>
								<?php
								}
								?>
						</ul>
					</li>
					<li><a href="cart.php">Cart <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
					<li><a href="contactUs.php" ><?php echo 'Contact Us'; ?></a></li>
				</ul>
			</div>
		</div>
	</nav>
