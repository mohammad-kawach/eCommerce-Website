<?php
	ob_start();
	session_start();
	$pageTitle = 'Create New Item';
	include 'init.php';
	if (isset($_SESSION['user'])) {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$formErrors = array();

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
			$avatarExtension 	= strtolower($avatarEnd );

			/* --------------------------------------------------------------- */
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
			/* --------------------------------------------------------------- */
			// Upload Variables
			$image2Name = $_FILES['image2']['name'];
			$image2Size = $_FILES['image2']['size'];
			$image2Tmp	= $_FILES['image2']['tmp_name'];
			$image2Type = $_FILES['image2']['type'];

			// List Of Allowed File Typed To Upload
			$image2AllowedExtension = array("jpeg", "jpg", "png", "gif");

			// Get Avatar Extension
			$image2Explode 		= explode('.', $image2Name);
			$image2End 				= end($image2Explode);
			$image2Extension 	= strtolower($image2End);
			/* --------------------------------------------------------------- */
			// Upload Variables
			$image3Name = $_FILES['image3']['name'];
			$image3Size = $_FILES['image3']['size'];
			$image3Tmp	= $_FILES['image3']['tmp_name'];
			$image3Type = $_FILES['image3']['type'];

			// List Of Allowed File Typed To Upload
			$image3AllowedExtension = array("jpeg", "jpg", "png", "gif");

			// Get Avatar Extension
			$image3Explode 		= explode('.', $image3Name);
			$image3End 				= end($image3Explode);
			$image3Extension 	= strtolower($image3End);
			/* --------------------------------------------------------------- */
			// Upload Variables
			$image4Name = $_FILES['image4']['name'];
			$image4Size = $_FILES['image4']['size'];
			$image4Tmp	= $_FILES['image4']['tmp_name'];
			$image4Type = $_FILES['image4']['type'];

			// List Of Allowed File Typed To Upload
			$image4AllowedExtension = array("jpeg", "jpg", "png", "gif");

			// Get Avatar Extension
			$image4Explode 		= explode('.', $image4Name);
			$image4End 				= end($image4Explode);
			$image4Extension 	= strtolower($image4End);
			/* --------------------------------------------------------------- */

			$name 				= filter_var($_POST['name'], FILTER_SANITIZE_STRING);
			$desc 				= filter_var($_POST['description'], FILTER_SANITIZE_STRING);
			$price 				= filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
			$country 			= filter_var($_POST['country'], FILTER_SANITIZE_STRING);
			$status 			= filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
			$category 		= filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
			$subcategory 	= filter_var($_POST['subcategory'], FILTER_SANITIZE_NUMBER_INT);
			$tags 				= filter_var($_POST['tags'], FILTER_SANITIZE_STRING);
			$count 				= filter_var($_POST['count'], FILTER_SANITIZE_NUMBER_INT);

			if (strlen($name) < 3) {

				$formErrors[] = 'Item Title Must Be At Least 3 Characters';

			}

			if (strlen($name) > 18) {

				$formErrors[] = 'Item Title Can Not Be More Than 18 Characters';

			}

			if (strlen($desc) < 10) {

				$formErrors[] = 'Item Description Must Be At Least 10 Characters';

			}

			if (strlen($country) < 2) {

				$formErrors[] = 'Country Name Must Be At Least 2 Characters';

			}

			if (empty($price)) {

				$formErrors[] = 'Item Price Cant Be Empty';

			}

			if (empty($status)) {

				$formErrors[] = 'Item Status Cant Be Empty';

			}

			if (empty($category)) {

				$formErrors[] = 'Item Category Cant Be Empty';

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

			if ($count < 0) {
				$formErrors[] = 'Count Can\'t Be Empty';
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
				items(Name, Description, Price, Country_Made, Image, Status, Add_Date, Cat_ID, Member_ID, tags, Count, img1, img2, img3, img4)
				VALUES(:zname, :zdesc, :zprice, :zcountry, :zavatar, :zstatus, now(), :zcat, :zmember, :ztags, :zcount, :zimg1, :zimg2, :zimg3, :zimg3)");

				$stmt->execute(array(
				'zname' 		=> $name,
				'zdesc' 		=> $desc,
				'zprice' 		=> $price,
				'zcountry' 	=> $country,
				'zavatar'		=> $avatar,
				'zstatus' 	=> $status,
				'zcat'			=> $category,
				'zmember'		=> $_SESSION['uid'],
				'ztags'			=> $tags,
				'zcount'		=> $count,
				'zimg1'			=> $image1,
				'zimg2'			=> $image2,
				'zimg3'			=> $image3,
				'zimg4'			=> $image4
				));
				

				// Echo Success Message
				if ($stmt) {
					$succesMsg = 'Item Has Been Added';
				}

			}

		}

?>

<h1 class="text-center"><?php echo $pageTitle ?></h1>
<div class="create-ad block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading"><?php echo $pageTitle ?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
							<!-- Start Name Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-1 control-label">Name</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9">
									<input 
										pattern=".{3,18}"
										title="This Field Require At Least 3 And Less Than 19 Characters"
										type="text" 
										name="name" 
										class="form-control live"  
										placeholder="Name of The Item"
										data-class=".live-title"
										required />
								</div>
							</div>
							<!-- End Name Field -->
							<!-- Start Description Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-1 control-label">Description</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9">
									<input 
										pattern=".{10,}"
										title="This Field Require At Least 10 Characters"
										type="text" 
										name="description" 
										class="form-control live"   
										placeholder="Description of The Item" 
										data-class=".live-desc"
										required />
								</div>
							</div>
							<!-- End Description Field -->
							<!-- Start Price Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-1 control-label">Price</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9">
									<input 
										type="text" 
										name="price" 
										class="form-control live" 
										placeholder="Price of The Item" 
										data-class=".live-price" 
										required />
								</div>
							</div>
							<!-- End Price Field -->
							<!-- Start Country Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-1 control-label">Country</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9">
									<input 
										type="text" 
										name="country" 
										class="form-control" 
										placeholder="Country of Made" 
										required />
								</div>
							</div>
							<!-- End Country Field -->
							<!-- Start Status Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-1 control-label">Status</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9">
									<select name="status" required>
										<option value="">...</option>
										<option value="1">New</option>
										<option value="2">Like New</option>
										<option value="3">Used</option>
										<option value="4">Very Old</option>
									</select>
								</div>
							</div>
							<!-- End Status Field -->
							<!-- Start Categories Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-1 control-label">Category</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9">
									<select name="category" required>
										<option value="">...</option>
										<?php
											$cats = getAllFrom('*' ,'categories', 'WHERE parent = 0', '', 'ID');
											foreach ($cats as $cat) {
												echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
											}
										?>
									</select>
								</div>
							</div>
							<!-- End Categories Field -->
							<!-- Start SubCategories Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-1 control-label">Subcategory</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9">
									<select name="subcategory" required>
										<option value="">...</option>
										<?php
											$cats = getAllFrom('*' ,'categories', 'WHERE parent != 0', '', 'ID');
											foreach ($cats as $cat) {
												echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
											}
										?>
									</select>
								</div>
							</div>
							<!-- End SubCategories Field -->
							<!-- Start Avatar Field -->
							<div class="form-group form-group-lg" style="margin-top:20px;">
								<label class="col-sm-1 control-label">Main Image</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9 custom-file custom-file2" style="top:13px; left:14px">
									<span>Choose Your File</span>
									<input type="file" name="main-image" class="form-control" />
								</div>
							</div>
							<!-- End Avatar Field -->
							<!-- Start Image1 Field -->
							<div class="form-group form-group-lg" style="margin-top:20px;">
								<label class="col-sm-1 control-label">image 1</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9 custom-file custom-file2" style="top:13px; left:14px">
									<span>Choose Your File</span>
									<!--<input type="file" name="main-image" class="form-control" multiple required="required" />-->
									<input type="file" name="image1" class="form-control" accept="image/jpg, image/jpeg" />
								</div>
							</div>
							<!-- End Image1 Field -->
							<!-- Start Image2 Field -->
							<div class="form-group form-group-lg" style="margin-top:20px;">
								<label class="col-sm-1 control-label">image 2</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9 custom-file custom-file2" style="top:13px; left:14px">
									<span>Choose Your File</span>
									<!--<input type="file" name="main-image" class="form-control" multiple required="required" />-->
									<input type="file" name="image2" class="form-control" accept="image/jpg, image/jpeg" />
								</div>
							</div>
							<!-- End Image2 Field -->
							<!-- Start Image3 Field -->
							<div class="form-group form-group-lg" style="margin-top:20px;">
								<label class="col-sm-1 control-label">image 3</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9 custom-file custom-file2" style="top:13px; left:14px">
									<span>Choose Your File</span>
									<!--<input type="file" name="main-image" class="form-control" multiple required="required" />-->
									<input type="file" name="image3" class="form-control" accept="image/jpg, image/jpeg" />
								</div>
							</div>
							<!-- End Image3 Field -->
							<!-- Start Image4 Field -->
							<div class="form-group form-group-lg" style="margin-top:20px;">
								<label class="col-sm-1 control-label">image 4</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9 custom-file custom-file2" style="top:13px; left:14px">
									<span>Choose Your File</span>
									<!--<input type="file" name="main-image" class="form-control" multiple required="required" />-->
									<input type="file" name="image4" class="form-control" accept="image/jpg, image/jpeg" />
								</div>
							</div>
							<!-- End Image4 Field -->
							<!-- Start Tags Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-1 control-label">Tags</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9">
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
								<label class="col-sm-1 control-label">Count</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9">
									<input 
										type="number"
										min="0"
										name="count" 
										class="form-control" 
										placeholder="Count Of The Item" 
										required />
								</div>
							</div>
							<!-- End Count Field -->
							<!-- Start Submit Field -->
							<div class="form-group form-group-lg">
								<div class="col-sm-offset-2 col-sm-9">
									<input type="submit" value="Add Item" class="btn btn-primary btn-lg" />
								</div>
							</div>
							<!-- End Submit Field -->
						</form>
					</div>
					<div class="col-md-4">
						<div class="thumbnail item-box live-preview">
							<span class="price-tag">
								$<span class="live-price">0</span>
							</span>
							<img class="img-responsive" src="img.png" alt="" />
							<div class="caption">
								<h3 class="live-title">Title</h3>
								<p class="live-desc">Description</p>
							</div>
						</div>
					</div>
				</div>
				<!-- Start Loopiong Through Errors -->
				<?php 
					if (! empty($formErrors)) {
						foreach ($formErrors as $error) {
							echo '<div class="alert alert-danger">' . $error . '</div>';
						}
					}
					if (isset($succesMsg)) {
						echo '<div class="alert alert-success">' . $succesMsg . '</div>';
					}
				?>
				<!-- End Loopiong Through Errors -->
			</div>
		</div>
	</div>
</div>
<?php
	} else {
		header('Location: login.php');
		exit();
	}
	include $tpl . 'footerDesig.php';
	include $tpl . 'footer.php';
	ob_end_flush();
?>