<?php

	/*
	================================================
	== Items Page
	================================================
	*/

	ob_start(); 					// Output Buffering Start
	session_start();
	$pageTitle = 'Items';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {


			$stmt = $con->prepare("SELECT 
										items.*, 
										categories.Name AS category_name, 
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
									ORDER BY 
										Item_ID DESC");

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$items = $stmt->fetchAll();

			if (! empty($items)) {

			?>

			<h1 class="text-center">Manage Items</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table mange-items text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td class='desc'>Image</td>
							<td>Item Name</td>
							<td>Description</td>
							<td>Price</td>
							<td>Adding Date</td>
							<td>Category</td>
							<td>Username</td>
							<td>Count</td>
							<td>Control</td>
						</tr>
						<?php
							foreach($items as $item) {
								echo "<tr>";
									echo "<td>" . $item['Item_ID'] . "</td>";
									echo "<td>";
										if (empty($item['Image'])) {
											echo 'No Image';
										} else {?>
											<img src="<?php echo $ItemsDir . $item['Image'] ?>" alt='' />
										<?php }
									echo "</td>";
									echo "<td>" . $item['Name'] . "</td>";
									echo "<td class='desc'>" . $item['Description'] . "</td>";
									echo "<td>" . $item['Price'] . "$	</td>";
									echo "<td>" . $item['Add_Date'] ."</td>";
									echo "<td>" . $item['category_name'] ."</td>";
									echo "<td>" . $item['Username'] ."</td>";
									if (isset($item['Count']) && $item['Count'] > 0) {
										echo "<td>" . $item['Count'] ."</td>";
									} else {
										echo "<td class='OOF'>Out Of Stuck</td>";
									}
									
									echo "<td>
										<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm delete'><i class='fa fa-close'></i> Delete </a>";
										if ($item['Approve'] == 0) {
											echo "<a 
													href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' 
													class='btn btn-info activate'>
													<i class='fa fa-check'></i> Approve</a>";
										}
									echo "</td>";
								echo "</tr>";
							}
						?>
						<tr>
					</table>
				</div>
				<a href="items.php?do=Add" class="btn btn-sm btn-primary">
					<i class="fa fa-plus"></i> New Item
				</a>
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="nice-message">There\'s No Items To Show</div>';
					echo '<a href="items.php?do=Add" class="btn btn-sm btn-primary">
							<i class="fa fa-plus"></i> New Item
						</a>';
				echo '</div>';

			} ?>

		<?php 

		} elseif ($do == 'Add') { ?>

			<h1 class="text-center">Add New Item</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input 
								pattern=".{3,18}"
								title="This Field Require At Least 3 And Less Than 19 Characters"
								type="text" 
								name="name" 
								class="form-control" 
								required="required"  
								placeholder="Name of The Item" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="description" 
								class="form-control" 
								required="required"  
								placeholder="Description of The Item" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="price" 
								class="form-control" 
								required="required" 
								placeholder="Price of The Item" />
						</div>
					</div>
					<!-- End Price Field -->
					<!-- Start Country Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="country" 
								class="form-control" 
								required="required" 
								placeholder="Country of Made" />
						</div>
					</div>
					<!-- End Country Field -->
					<!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-6">
							<select name="status">
								<option value="0">...</option>
								<option value="1">New</option>
								<option value="2">Like New</option>
								<option value="3">Used</option>
								<option value="4">Very Old</option>
							</select>
						</div>
					</div>
					<!-- End Status Field -->
					<!-- Start Members Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Member</label>
						<div class="col-sm-10 col-md-6">
							<select name="member">
								<option value="0">...</option>
								<?php
									$allMembers = getAllFrom("*", "users", "", "", "UserID");
									foreach ($allMembers as $user) {
										echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					<!-- End Members Field -->
					<!-- Start Categories Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10 col-md-6">
							<select name="category">
								<option value="0">...</option>
								<?php
									$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
									foreach ($allCats as $cat) {
										echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
										$childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
										foreach ($childCats as $child) {
											echo "<option value='" . $child['ID'] . "'>--- " . $child['Name'] . "</option>";
										}
									}
								?>
							</select>
						</div>
					</div>
					<!-- End Categories Field -->
					<!-- Start Featured Field -->
					<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Featured</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="vis-yes" type="radio" name="featured" value="1" />
									<label for="vis-yes">Yes</label> 
								</div>
								<div>
									<input id="vis-no" type="radio" name="featured" value="0" checked />
									<label for="vis-no">No</label> 
								</div>
							</div>
						</div>
						<!-- End Featured Field -->
					<!-- Start Avatar Field -->
					<div class="form-group form-group-lg" style="margin-top:20px;">
						<label class="col-sm-2 control-label">Main Image</label>
						<div class="col-sm-10 col-md-6 custom-file custom-file2" style="top:13px; left:14px">
							<span>Choose Your File</span>
							<input type="file" name="main-image" class="form-control" required="required" />
						</div>
					</div>
					<!-- End Avatar Field -->
					<!-- Start Image1 Field -->
					<div class="form-group form-group-lg" style="margin-top:20px;">
						<label class="col-sm-2 control-label">Image 1</label>
						<div class="col-sm-10 col-md-6 custom-file custom-file2" style="top:13px; left:14px">
							<span>Choose Your File</span>
							<input type="file" name="image1" class="form-control" required="required" />
						</div>
					</div>
					<!-- End Image1 Field -->
					<!-- Start Image2 Field -->
					<div class="form-group form-group-lg" style="margin-top:20px;">
						<label class="col-sm-2 control-label">Image 2</label>
						<div class="col-sm-10 col-md-6 custom-file custom-file2" style="top:13px; left:14px">
							<span>Choose Your File</span>
							<input type="file" name="image2" class="form-control" required="required" />
						</div>
					</div>
					<!-- End Image2 Field -->
					<!-- Start Image3 Field -->
					<div class="form-group form-group-lg" style="margin-top:20px;">
						<label class="col-sm-2 control-label">Image 3</label>
						<div class="col-sm-10 col-md-6 custom-file custom-file2" style="top:13px; left:14px">
							<span>Choose Your File</span>
							<input type="file" name="image3" class="form-control" required="required" />
						</div>
					</div>
					<!-- End Image3 Field -->
					<!-- Start Image4 Field -->
					<div class="form-group form-group-lg" style="margin-top:20px;">
						<label class="col-sm-2 control-label">Image 4</label>
						<div class="col-sm-10 col-md-6 custom-file custom-file2" style="top:13px; left:14px">
							<span>Choose Your File</span>
							<input type="file" name="image4" class="form-control" required="required" />
						</div>
					</div>
					<!-- End Image3 Field -->
					<!-- Start Tags Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Tags</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="tags" 
								class="form-control" 
								placeholder="Separate Tags With Comma (,)" />
						</div>
					</div>
					<!-- End Tags Field -->
					<!-- Start Count Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Count</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="number"
								min="0"
								name="count" 
								class="form-control" 
								placeholder="Count Of The Item" />
						</div>
					</div>
					<!-- End Count Field -->
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Item" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>

			<?php

		} elseif ($do == 'Insert') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Insert Item</h1>";
				echo "<div class='container'>";

				// Upload Variables
				$avatarName = $_FILES['main-image']['name'];
				$avatarSize = $_FILES['main-image']['size'];
				$avatarTmp	= $_FILES['main-image']['tmp_name'];
				$avatarType = $_FILES['main-image']['type'];

				// List Of Allowed File Typed To Upload
				$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get Avatar Extension
				$avatarExplode 		= explode('.', $avatarName);
				$avatarEnd 				= end($avatarExplode);
				$avatarExtension 	= strtolower($avatarEnd);
				/* ---------------------------------------------------------------- */
				// Upload Variables
				$image1Name = $_FILES['image1']['name'];
				$image1Size = $_FILES['image1']['size'];
				$image1Tmp	= $_FILES['image1']['tmp_name'];
				$image1Type = $_FILES['image1']['type'];

				// List Of Allowed File Typed To Upload
				$image1AllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get image1 Extension
				$image1Explode 		= explode('.', $image1Name);
				$image1End 				= end($image1Explode);
				$image1Extension 	= strtolower($image1End);
				/* ---------------------------------------------------------------- */
				// Upload Variables
				$image2Name = $_FILES['image2']['name'];
				$image2Size = $_FILES['image2']['size'];
				$image2Tmp	= $_FILES['image2']['tmp_name'];
				$image2Type = $_FILES['image2']['type'];

				// List Of Allowed File Typed To Upload
				$image2AllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get image1 Extension
				$image2Explode 		= explode('.', $image1Name);
				$image2End 				= end($image2Explode);
				$image2Extension 	= strtolower($image2End);
				/* ---------------------------------------------------------------- */
				// Upload Variables
				$image3Name = $_FILES['image3']['name'];
				$image3Size = $_FILES['image3']['size'];
				$image3Tmp	= $_FILES['image3']['tmp_name'];
				$image3Type = $_FILES['image3']['type'];

				// List Of Allowed File Typed To Upload
				$image3AllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get image1 Extension
				$image3Explode 		= explode('.', $image3Name);
				$image3End 				= end($image3Explode);
				$image3Extension 	= strtolower($image3End);
				/* ---------------------------------------------------------------- */
				// Upload Variables
				$image4Name = $_FILES['image4']['name'];
				$image4Size = $_FILES['image4']['size'];
				$image4Tmp	= $_FILES['image4']['tmp_name'];
				$image4Type = $_FILES['image4']['type'];

				// List Of Allowed File Typed To Upload
				$image4AllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get image1 Extension
				$image4Explode 		= explode('.', $image4Name);
				$image4End 				= end($image4Explode);
				$image4Extension 	= strtolower($image4End);
				/* ---------------------------------------------------------------- */
				

				// Get Variables From The Form
				$name			= $_POST['name'];
				$desc 		= $_POST['description'];
				$price 		= $_POST['price'];
				$country 	= $_POST['country'];
				$status 	= $_POST['status'];
				$member 	= $_POST['member'];
				$cat 			= $_POST['category'];
				$tags 		= $_POST['tags'];

				$count		= $_POST['count'];

				$feat 		= $_POST['featured'];

				// Validate The Form

				$formErrors = array();

				if (empty($name)) {
					$formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
				}

				if (empty($desc)) {
					$formErrors[] = 'Description Can\'t be <strong>Empty</strong>';
				}

				if (empty($price)) {
					$formErrors[] = 'Price Can\'t be <strong>Empty</strong>';
				}

				if (empty($country)) {
					$formErrors[] = 'Country Can\'t be <strong>Empty</strong>';
				}

				if ($status == 0) {
					$formErrors[] = 'You Must Choose the <strong>Status</strong>';
				}

				if ($member == 0) {
					$formErrors[] = 'You Must Choose the <strong>Member</strong>';
				}

				if ($cat == 0) {
					$formErrors[] = 'You Must Choose the <strong>Category</strong>';
				}

				if ($count < 0) {
					$formErrors[] = 'Count Of The Item Can\'t Be Smaller Than 0.';
				}

				if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
					$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
				}

				if (empty($avatarName)) {
					$formErrors[] = 'Avatar Is <strong>Required</strong>';
				}

				if ($avatarSize > 4194304) {
					$formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
				}

				if (! empty($image1Name) && ! in_array($image1Extension, $image1AllowedExtension)) {
					$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
				}

				if (empty($image1Name)) {
					$formErrors[] = 'Avatar Is <strong>Required</strong>';
				}

				if ($image1Size > 4194304) {
					$formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
				}

				if (! empty($image2Name) && ! in_array($image2Extension, $image2AllowedExtension)) {
					$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
				}

				if (empty($image2Name)) {
					$formErrors[] = 'Avatar Is <strong>Required</strong>';
				}

				if ($image2Size > 4194304) {
					$formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
				}

				if (! empty($image3Name) && ! in_array($image3Extension, $image3AllowedExtension)) {
					$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
				}

				if (empty($image3Name)) {
					$formErrors[] = 'Avatar Is <strong>Required</strong>';
				}

				if ($image3Size > 4194304) {
					$formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
				}

				if (! empty($image4Name) && ! in_array($image4Extension, $image4AllowedExtension)) {
					$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
				}

				if (empty($image4Name)) {
					$formErrors[] = 'Avatar Is <strong>Required</strong>';
				}

				if ($image4Size > 4194304) {
					$formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
				}

				// Loop Into Errors Array And Echo It
				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)) {

					$avatar = rand(0, 10000000000) . '_' . $avatarName;
					move_uploaded_file($avatarTmp, $ItemsDir . $avatar);

					$image1 = rand(0, 10000000000) . '_' . $image1Name;
					move_uploaded_file($image1Tmp, $ItemsDir . $image1);

					$image2 = rand(0, 10000000000) . '_' . $image2Name;
					move_uploaded_file($image2Tmp, $ItemsDir . $image2);

					$image3 = rand(0, 10000000000) . '_' . $image3Name;
					move_uploaded_file($image3Tmp, $ItemsDir . $image3);

					$image4 = rand(0, 10000000000) . '_' . $image4Name;
					move_uploaded_file($image4Tmp, $ItemsDir . $image4);

					// Insert Userinfo In Database
					$stmt = $con->prepare("INSERT INTO 
						items(Name, Description, Price, Country_Made, Image, Status, Add_Date, Approve, Cat_ID, Member_ID, tags, Count, img1, img2, img3, img4, Featured)
						VALUES(:zname, :zdesc, :zprice, :zcountry, :zavatar, :zstatus, now(), 1, :zcat, :zmember, :ztags, :zcount, :zimg1, :zimg2, :zimg3, :zimg4, :zfeat)");

					$stmt->execute(array(
						'zname' 		=> $name,
						'zdesc' 		=> $desc,
						'zprice' 		=> $price,
						'zcountry' 	=> $country,
						'zavatar'		=> $avatar,
						'zstatus' 	=> $status,
						'zcat'			=> $cat,
						'zmember'		=> $member,
						'ztags'			=> $tags,
						'zcount'		=> $count,
						'zimg1'			=> $image1,
						'zimg2'			=> $image2,
						'zimg3'			=> $image3,
						'zimg4'			=> $image4,
						'zfeat'			=> $feat
					));

					// Echo Success Message

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

					redirectHome($theMsg, 'back');

				}

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

				echo "</div>";

			}

			echo "</div>";

		} elseif ($do == 'Edit') {

			// Check If Get Request item Is Numeric & Get Its Integer Value

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			// Select All Data Depend On This ID

			$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");

			// Execute Query

			$stmt->execute(array($itemid));

			// Fetch The Data

			$item = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			// If There's Such ID Show The Form

			if ($count > 0) { ?>

				<h1 class="text-center">Edit Item</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									pattern=".{3,18}"
									title="This Field Require At Least 3 And Less Than 19 Characters"
									name="name" 
									class="form-control" 
									required="required"  
									placeholder="Name of The Item"
									value="<?php echo $item['Name'] ?>" />
							</div>
						</div>
						<!-- End Name Field -->
						<!-- Start Description Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="description" 
									class="form-control" 
									required="required"  
									placeholder="Description of The Item"
									value="<?php echo $item['Description'] ?>" />
							</div>
						</div>
						<!-- End Description Field -->
						<!-- Start Price Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Price</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="price" 
									class="form-control" 
									required="required" 
									placeholder="Price of The Item"
									value="<?php echo $item['Price'] ?>" />
							</div>
						</div>
						<!-- End Price Field -->
						<!-- Start Country Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Country</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="country" 
									class="form-control" 
									required="required" 
									placeholder="Country of Made"
									value="<?php echo $item['Country_Made'] ?>" />
							</div>
						</div>
						<!-- End Country Field -->
						<!-- Start Status Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-md-6">
								<select name="status">
									<option value="1" <?php if ($item['Status'] == 1) { echo 'selected'; } ?>>New</option>
									<option value="2" <?php if ($item['Status'] == 2) { echo 'selected'; } ?>>Like New</option>
									<option value="3" <?php if ($item['Status'] == 3) { echo 'selected'; } ?>>Used</option>
									<option value="4" <?php if ($item['Status'] == 4) { echo 'selected'; } ?>>Very Old</option>
								</select>
							</div>
						</div>
						<!-- End Status Field -->
						<!-- Start Members Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Member</label>
							<div class="col-sm-10 col-md-6">
								<select name="member">
									<?php
										$allMembers = getAllFrom("*", "users", "", "", "UserID");
										foreach ($allMembers as $user) {
											echo "<option value='" . $user['UserID'] . "'"; 
											if ($item['Member_ID'] == $user['UserID']) { echo 'selected'; } 
											echo ">" . $user['Username'] . "</option>";
										}
									?>
								</select>
							</div>
						</div>
						<!-- End Members Field -->
						<!-- Start Categories Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Category</label>
							<div class="col-sm-10 col-md-6">
								<select name="category">
									<?php
										$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
										foreach ($allCats as $cat) {
											echo "<option value='" . $cat['ID'] . "'";
											if ($item['Cat_ID'] == $cat['ID']) { echo ' selected'; }
											echo ">" . $cat['Name'] . "</option>";
											$childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
											foreach ($childCats as $child) {
												echo "<option value='" . $child['ID'] . "'";
												if ($item['Cat_ID'] == $child['ID']) { echo ' selected'; }
												echo ">--- " . $child['Name'] . "</option>";
											}
										}
									?>
								</select>
							</div>
						</div>
						<!-- End Categories Field -->
						<!-- Start Avatar Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Main Image</label>
							<div class="col-sm-10 col-md-6 custom-file custom-file2" style="top:13px; left:14px">
								<span>Choose Your File</span>
								<input type="file" value="<?php echo $item['Image'] ?>" name="main-image2" class="form-control" />
							</div>
						</div>
						<!-- End Avatar Field -->
						<!-- Start Featured Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Featured</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="vis-yes" type="radio" name="featured" value="1" <?php if($item['Featured'] == 1) { echo 'checked'; } ?> />
									<label for="vis-yes">Yes</label> 
								</div>
								<div>
									<input id="vis-no" type="radio" name="featured" value="0" <?php if($item['Featured'] == 0) { echo 'checked'; } ?> />
									<label for="vis-no">No</label> 
								</div>
							</div>
						</div>
						<!-- End Featured Field -->
						<!-- Start Image1 Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Image 1</label>
							<div class="col-sm-10 col-md-6 custom-file custom-file2" style="top:13px; left:14px">
								<span>Choose Your File</span>
								<input type="file" value="<?php echo $item['img1'] ?>" name="image1" class="form-control" />
							</div>
						</div>
						<!-- End Image1 Field -->
						<!-- Start Image2 Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Image 2</label>
							<div class="col-sm-10 col-md-6 custom-file custom-file2" style="top:13px; left:14px">
								<span>Choose Your File</span>
								<input type="file" value="<?php echo $item['img2'] ?>" name="image2" class="form-control" />
							</div>
						</div>
						<!-- End Image2 Field -->
						<!-- Start Image3 Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Image 3</label>
							<div class="col-sm-10 col-md-6 custom-file custom-file2" style="top:13px; left:14px">
								<span>Choose Your File</span>
								<input type="file" value="<?php echo $item['img3'] ?>" name="image3" class="form-control" />
							</div>
						</div>
						<!-- End Image3 Field -->
						<!-- Start Image4 Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Image 4</label>
							<div class="col-sm-10 col-md-6 custom-file custom-file2" style="top:13px; left:14px">
								<span>Choose Your File</span>
								<input type="file" value="<?php echo $item['img4'] ?>" name="image4" class="form-control" />
							</div>
						</div>
						<!-- End Image4 Field -->
						<!-- Start Tags Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Tags</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="tags" 
									class="form-control" 
									placeholder="Separate Tags With Comma (,)" 
									value="<?php echo $item['tags'] ?>" />
							</div>
						</div>
						<!-- End Tags Field -->
						<!-- Start Count Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Count</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="number"
								min="0"
								name="count" 
								class="form-control" 
								value="<?php echo $item['Count'] ?>" 
								required="required"/>
						</div>
					</div>
					<!-- End Count Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save Item" class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>

					<?php

					// Select All Users Except Admin 

					$stmt = $con->prepare("SELECT 
												comments.*, users.Username AS Member  
											FROM 
												comments
											INNER JOIN 
												users 
											ON 
												users.UserID = comments.user_id
											WHERE item_id = ?");

					// Execute The Statement

					$stmt->execute(array($itemid));

					// Assign To Variable 

					$rows = $stmt->fetchAll();

					if (! empty($rows)) {
						
					?>
					<h1 class="text-center">Manage [ <?php echo $item['Name'] ?> ] Comments</h1>
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>Comment</td>
								<td>User Name</td>
								<td>Added Date</td>
								<td>Control</td>
							</tr>
							<?php
								foreach($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['comment'] . "</td>";
										echo "<td>" . $row['Member'] . "</td>";
										echo "<td>" . $row['comment_date'] ."</td>";
										echo "<td>
											<a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
											<a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
											if ($row['status'] == 0) {
												echo "<a href='comments.php?do=Approve&comid="
														. $row['c_id'] . "' 
														class='btn btn-info activate'>
														<i class='fa fa-check'></i> Approve</a>";
											}
										echo "</td>";
									echo "</tr>";
								}
							?>
							<tr>
						</table>
					</div>
					<?php } ?>
				</div>

			<?php

			// If There's No Such ID Show Error Message

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

				redirectHome($theMsg);

				echo "</div>";

			}			

		} elseif ($do == 'Update') {

			echo "<h1 class='text-center'>Update Item</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Upload Variables
				$avatarName = $_FILES['main-image2']['name'];
				$avatarSize = $_FILES['main-image2']['size'];
				$avatarTmp	= $_FILES['main-image2']['tmp_name'];
				$avatarType = $_FILES['main-image2']['type'];

				// List Of Allowed File Typed To Upload
				$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get Avatar Extension
				$explode 					= explode('.', $avatarName);
				$end 							= end($explode);
				$avatarExtension 	= strtolower($end);
				/* ------------------------------------------------------------------ */
				// Upload Variables
				$image1Name = $_FILES['image1']['name'];
				$image1Size = $_FILES['image1']['size'];
				$image1Tmp	= $_FILES['image1']['tmp_name'];
				$image1Type = $_FILES['image1']['type'];

				// List Of Allowed File Typed To Upload
				$image1AllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get Avatar Extension
				$image1Explode 		= explode('.', $image1Name);
				$image1End 				= end($image1Explode);
				$image1Extension 	= strtolower($image1End);
				/* ------------------------------------------------------------------ */
				// Upload Variables
				$image2Name = $_FILES['image2']['name'];
				$image2Size = $_FILES['image2']['size'];
				$image2Tmp	= $_FILES['image2']['tmp_name'];
				$image2Type = $_FILES['image2']['type'];

				// List Of Allowed File Typed To Upload
				$image2AllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get Image2 Extension
				$image2Explode 		= explode('.', $image2Name);
				$image2End 				= end($image2Explode);
				$image2Extension 	= strtolower($image2End);
				/* ------------------------------------------------------------------ */
				// Upload Variables
				$image3Name = $_FILES['image3']['name'];
				$image3Size = $_FILES['image3']['size'];
				$image3Tmp	= $_FILES['image3']['tmp_name'];
				$image3Type = $_FILES['image3']['type'];

				// List Of Allowed File Typed To Upload
				$image3AllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get Image3 Extension
				$image3Explode 		= explode('.', $image3Name);
				$image3End 				= end($image3Explode);
				$image3Extension 	= strtolower($image3End);
				/* ------------------------------------------------------------------ */
				// Upload Variables
				$image4Name = $_FILES['image4']['name'];
				$image4Size = $_FILES['image4']['size'];
				$image4Tmp	= $_FILES['image4']['tmp_name'];
				$image4Type = $_FILES['image4']['type'];

				// List Of Allowed File Typed To Upload
				$image4AllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get Image3 Extension
				$image4Explode 		= explode('.', $image4Name);
				$image4End 				= end($image4Explode);
				$image4Extension 	= strtolower($image4End);
				/* ------------------------------------------------------------------ */


				// Get Variables From The Form
				$id 			= $_POST['itemid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$price 		= $_POST['price'];
				$country	= $_POST['country'];
				$status 	= $_POST['status'];
				$cat 			= $_POST['category'];
				$member 	= $_POST['member'];
				$tags 		= $_POST['tags'];

				$count 		= $_POST['count'];

				$feat 		= $_POST['featured'];


				// Validate The Form

				$formErrors = array();

				if (empty($name)) {
					$formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
				}

				if (empty($desc)) {
					$formErrors[] = 'Description Can\'t be <strong>Empty</strong>';
				}

				if (empty($price)) {
					$formErrors[] = 'Price Can\'t be <strong>Empty</strong>';
				}

				if (empty($country)) {
					$formErrors[] = 'Country Can\'t be <strong>Empty</strong>';
				}

				if ($status == 0) {
					$formErrors[] = 'You Must Choose the <strong>Status</strong>';
				}

				if ($member == 0) {
					$formErrors[] = 'You Must Choose the <strong>Member</strong>';
				}

				if ($cat == 0) {
					$formErrors[] = 'You Must Choose the <strong>Category</strong>';
				}

				if ($count < 0) {
					$formErrors[] = 'Count Of The Item Can\'t Be Smaller Than 0.';
				}

				// Loop Into Errors Array And Echo It

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)) {

					$avatar2 = rand(0, 10000000000) . '_' . $avatarName;
					move_uploaded_file($avatarTmp, $ItemsDir	 . $avatar2);

					$image1 = rand(0, 10000000000) . '_' . $image1Name;
					move_uploaded_file($image1Tmp, $ItemsDir	 . $image1);

					$image2 = rand(0, 10000000000) . '_' . $image2Name;
					move_uploaded_file($image2Tmp, $ItemsDir	 . $image2);

					$image3 = rand(0, 10000000000) . '_' . $image3Name;
					move_uploaded_file($image3Tmp, $ItemsDir	 . $image3);

					$image4 = rand(0, 10000000000) . '_' . $image4Name;
					move_uploaded_file($image4Tmp, $ItemsDir	 . $image4);


					if (!empty($avatarName) && empty($image1) && empty($image2) && empty($image3) && empty($image4)) {
						// Update The Database With This Info
						$stmt = $con->prepare("UPDATE 
																		items 
																	SET 
																		Name 					= ?, 
																		Description 	= ?, 
																		Price 				= ?, 
																		Country_Made 	= ?,
																		Image 				= ?,
																		Status 				= ?,
																		Cat_ID 				= ?,
																		Member_ID 		= ?,
																		tags 					= ?,
																		Count 				= ?,
																		Featured			= ?
																	WHERE 
																		Item_ID 			= ?"
																	);

						$stmt->execute(array($name, $desc, $price, $country, $avatar2, $status, $cat, $member, $tags, $count, $feat, $id));

					} elseif (!empty($avatarName) && !empty($image1) && !empty($image2) && !empty($image3) && !empty($image4)) {
						// Update The Database With This Info
						$stmt = $con->prepare("UPDATE 
																		items 
																	SET 
																		Name 					= ?, 
																		Description 	= ?, 
																		Price 				= ?, 
																		Country_Made 	= ?,
																		Image 				= ?,
																		Status 				= ?,
																		Cat_ID 				= ?,
																		Member_ID 		= ?,
																		tags 					= ?,
																		Count 				= ?,
																		img1					= ?,
																		img2					= ?,
																		img3					= ?,
																		img4					= ?,
																		Featured			= ?
																	WHERE 
																		Item_ID 			= ?"
																	);

						$stmt->execute(array($name, $desc, $price, $country, $avatar2, $status, $cat, $member, $tags, $count, $image1, $image2, $image3, $image4, $feat, $id));

					} elseif(empty($avatarName) && !empty($image1) && !empty($image2) && !empty($image3) && !empty($image4)) {

						// Update The Database With This Info
						$stmt = $con->prepare("UPDATE 
																			items 
																		SET 
																			Name 					= ?, 
																			Description 	= ?, 
																			Price 				= ?, 
																			Country_Made 	= ?,
																			Status 				= ?,
																			Cat_ID 				= ?,
																			Member_ID 		= ?,
																			tags 					= ?,
																			Count 				= ?,
																			img1					= ?,
																			img2					= ?,
																			img3					= ?,
																			img4					= ?,
																			Featured			= ?
																		WHERE 
																			Item_ID 			= ?"
																		);

						$stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $count, $image1, $image2, $image3, $image4, $feat, $id));


					} elseif(empty($avatarName) && empty($image1) && empty($image2) && empty($image3) && empty($image4)) {

						// Update The Database With This Info
						$stmt = $con->prepare("UPDATE 
																			items 
																		SET 
																			Name 					= ?, 
																			Description 	= ?, 
																			Price 				= ?, 
																			Country_Made 	= ?,
																			Status 				= ?,
																			Cat_ID 				= ?,
																			Member_ID 		= ?,
																			tags 					= ?,
																			Count 				= ?,
																			Featured			= ?
																		WHERE 
																			Item_ID 			= ?"
																		);

						$stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $count, $feat, $id));


					}
					
					// Echo Success Message

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

					redirectHome($theMsg, 'back');

				}

			} else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

			}

			echo "</div>";

		} elseif ($do == 'Delete') {

			echo "<h1 class='text-center'>Delete Item</h1>";
			echo "<div class='container'>";

				// Check If Get Request Item ID Is Numeric & Get The Integer Value Of It

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

					$stmt->bindParam(":zid", $itemid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		} elseif ($do == 'Approve') {

			echo "<h1 class='text-center'>Approve Item</h1>";
			echo "<div class='container'>";

				// Check If Get Request Item ID Is Numeric & Get The Integer Value Of It
				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend On This ID
				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form
				if ($check > 0) {

					// Approve The Item
					$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
					$stmt->execute(array($itemid));

					// fetch the user id
					$stmt2 = $con->prepare("SELECT Member_ID FROM items WHERE Item_ID = ? LIMIT 1");
					$stmt2->execute(array($itemid));
					$lastUid = $stmt2->fetchAll();

					foreach ($lastUid as $lastId) {
						// Add Notification Item
						$stmt3 = $con->prepare("INSERT INTO  notifications (u_id, item_id) VALUES (:zUid, :zItemId)");
						$stmt3->execute(array(
							'zUid' 		=> $lastId[0],
							'zItemId' => $itemid
						));
					}

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		}

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>