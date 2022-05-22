<?php
  ob_start();
	session_start();
	$pageTitle = 'Edit Item';
	include 'init.php'; 
  $ItemID = $_GET['Itemid'];
  $theItems = getAllFromItems($ItemID);
  
  if (isset($_SESSION['user'])) {
    foreach ($theItems as $item) {
      if ($item['Member_ID'] != $_SESSION['uid']) {
        header('Location: index.php');
      }
    }
  

  /*---------------------------------------------------------*/
  // Select All Data Depend On This ID
  $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? LIMIT 1");

  // Execute Query
  $stmt->execute(array($ItemID));

  // Fetch The Data
  $item = $stmt->fetch();
  /*---------------------------------------------------------*/

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Upload Variables
    $avatarName = $_FILES['newavatar']['name'];
    $avatarSize = $_FILES['newavatar']['size'];
    $avatarTmp	= $_FILES['newavatar']['tmp_name'];
    $avatarType = $_FILES['newavatar']['type'];
    
    // List Of Allowed File Typed To Upload
    $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

    // Get Avatar Extension
    $explode 					= explode('.', $avatarName);
    $end 							= end($explode);
    $avatarExtension 	= strtolower($end);
    /*---------------------------------------------------------*/
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
    /*---------------------------------------------------------*/
    // Upload Variables
    $image2Name = $_FILES['image2']['name'];
    $image2Size = $_FILES['image2']['size'];
    $image2Tmp	= $_FILES['image2']['tmp_name'];
    $image2Type = $_FILES['image2']['type'];
    
    // List Of Allowed File Typed To Upload
    $image2AllowedExtension = array("jpeg", "jpg", "png", "gif");

    // Get Avatar Extension
    $image2Explode 					= explode('.', $image2Name);
    $image2End 							= end($image2Explode);
    $image2Extension 	= strtolower($image2End);
    /*---------------------------------------------------------*/
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
    /*---------------------------------------------------------*/
    // Upload Variables
    $image4Name = $_FILES['image4']['name'];
    $image4Size = $_FILES['image4']['size'];
    $image4Tmp	= $_FILES['image4']['tmp_name'];
    $image4Type = $_FILES['image4']['type'];
    
    // List Of Allowed File Typed To Upload
    $image4AllowedExtension = array("jpeg", "jpg", "png", "gif");

    // Get Avatar Extension
    $image4Explode 		= explode('.', $image3Name);
    $image4End 				= end($image4Explode);
    $image4Extension 	= strtolower($image4End);
    /*---------------------------------------------------------*/

    // Get Variables From The Form
    $name 		= $_POST['name'];
    $desc 		= $_POST['description'];
    $price 		= $_POST['price'];
    $country	= $_POST['country'];
    $status 	= $_POST['status'];
    $cat 			= $_POST['category'];
    $tags 		= $_POST['tags'];
    $count    = $_POST['count'];

    $theId = $_POST['id'];

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

    if ($cat == 0) {
      $formErrors[] = 'You Must Choose the <strong>Category</strong>';
    }

    if ($count < 0) {
      $formErrors[] = 'Count Can\'t Be Empty';
    }

    // Loop Into Errors Array And Echo It

    foreach($formErrors as $error) {
      echo '<div class="alert alert-danger">' . $error . '</div>';
    }

    // Check If There's No Error Proceed The Update Operation

    if (empty($formErrors)) {

      global $avatar2;
      
      if (!empty($avatarName)) {
        $avatar2 = rand(0, 10000000000) . '_' . $avatarName;
        move_uploaded_file($avatarTmp, $ItemsDir . $avatar2);
      }

      if (!empty($image1Name)) {
        $newImage1 = rand(0, 10000000000) . '_' . $image1Name;
        move_uploaded_file($image1Tmp, $ItemsDir . $newImage1);
      }
      if (!empty($image2Name)) {
        $newImage2 = rand(0, 10000000000) . '_' . $image2Name;
        move_uploaded_file($image2Tmp, $ItemsDir . $newImage2);
      }
      if (!empty($image3Name)) {
        $newImage3 = rand(0, 10000000000) . '_' . $image3Name;
        move_uploaded_file($image3Tmp, $ItemsDir . $newImage3);
      }
      if (!empty($image4Name)) {
        $newImage4 = rand(0, 10000000000) . '_' . $image4Name;
        move_uploaded_file($image4Tmp, $ItemsDir . $newImage4);
      }

      if(!empty($avatarName) && empty($image1Name) && empty($image2Name) && empty($image3Name) && empty($image4Name)) {
      
        // Update The Database With This Info
        $stmt = $con->prepare("UPDATE 
                                items 
                              SET 
                                Name = ?, 
                                Description = ?, 
                                Price = ?, 
                                Country_Made = ?,
                                Image = ?,
                                Status = ?,
                                Cat_ID = ?,
                                tags = ?,
                                Count = ?
                              WHERE 
                                Item_ID = ?");
  
        $stmt->execute(array($name, $desc, $price, $country, $avatar2, $status, $cat, $tags, $count, $theId));
  
        //Echo Success Message
        //$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
  
        //redirectHome($theMsg, 'back');
        header("Location: profile.php");
  
      } elseif(!empty($avatarName) && !empty($image1Name) && !empty($image2Name) && !empty($image3Name) && !empty($image4Name)) {
      
      // Update The Database With This Info
      $stmt = $con->prepare("UPDATE 
                              items 
                            SET 
                              Name = ?, 
                              Description = ?, 
                              Price = ?, 
                              Country_Made = ?,
                              Image = ?,
                              Status = ?,
                              Cat_ID = ?,
                              tags = ?,
                              Count = ?,
                              img1 = ?,
                              img2 = ?,
                              img3 = ?,
                              img4 = ?
                            WHERE 
                              Item_ID = ?");

      $stmt->execute(array($name, $desc, $price, $country, $avatar2, $status, $cat, $tags, $count, $newImage1, $newImage2, $newImage3, $newImage4, $theId));

      //Echo Success Message
      //$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

      //redirectHome($theMsg, 'back');
      header("Location: profile.php");

    } elseif(empty($avatarName) && empty($image1Name) && empty($image2Name) && empty($image3Name) && empty($image4Name)) {
              
          // Update The Database With This Info
          $stmt = $con->prepare("UPDATE 
                                  items 
                                SET 
                                  Name = ?, 
                                  Description = ?, 
                                  Price = ?, 
                                  Country_Made = ?,
                                  Status = ?,
                                  Cat_ID = ?,
                                  tags = ?,
                                  Count = ?
                                WHERE 
                                  Item_ID = ?");

          $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $tags, $count, $theId));

          //Echo Success Message
          //$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

          //redirectHome($theMsg, 'back');
          header("Location: profile.php");

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
                    value = "<?php echo $item['Name']; ?>"
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
                    value = "<?php echo $item['Description']; ?>"
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
                    value = "<?php echo $item['Price']; ?>"
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
                    value = "<?php echo $item['Country_Made']; ?>"
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
                  <select name="status">
                    <option value="1" <?php if ($item['Status'] == 1) { echo 'selected'; } ?>>New</option>
                    <option value="2" <?php if ($item['Status'] == 2) { echo 'selected'; } ?>>Like New</option>
                    <option value="3" <?php if ($item['Status'] == 3) { echo 'selected'; } ?>>Used</option>
                    <option value="4" <?php if ($item['Status'] == 4) { echo 'selected'; } ?>>Very Old</option>
                  </select>
                </div>
              </div>
							<!-- End Status Field -->
							<!-- Start Categories Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-1 control-label">Category</label>
                <div class="col-sm-offset-1 col-sm-10 col-md-9">
                  <select name="category">
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
							<!-- Start Avatar Field -->
              <div style="display:none;">
                <input type="file" name="oldavatar" class="form-control" value="<?php echo $row['avatar'] ?>" />
              </div>
							<div class="form-group form-group-lg" style="margin-top:20px;">
								<label class="col-sm-1 control-label">Image</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9 custom-file custom-file2" style="top:13px; left:14px">
									<span>Choose Your File</span>
									<input type="file" name="newavatar" class="form-control" value = "<?php echo $item['Image']; ?>" />
								</div>
							</div>
							<!-- End Avatar Field -->
              <!-- Start Image1 Field -->
              <div style="display:none;">
                <input type="file" name="oldimage1" class="form-control" value="<?php echo $row['img1'] ?>" />
              </div>
							<div class="form-group form-group-lg" style="margin-top:20px;">
								<label class="col-sm-1 control-label">Image 1</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9 custom-file custom-file2" style="top:13px; left:14px">
									<span>Choose Your File</span>
									<input type="file" name="image1" class="form-control" value="<?php echo $item['img1']; ?>" />
								</div>
							</div>
							<!-- End Image1 Field -->
              <!-- Start Image2 Field -->
              <div style="display:none;">
                <input type="file" name="oldimage2" class="form-control" value="<?php echo $row['img2'] ?>" />
              </div>
							<div class="form-group form-group-lg" style="margin-top:20px;">
								<label class="col-sm-1 control-label">Image 2</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9 custom-file custom-file2" style="top:13px; left:14px">
									<span>Choose Your File</span>
									<input type="file" name="image2" class="form-control" value="<?php echo $item['img2']; ?>" />
								</div>
							</div>
							<!-- End Image2 Field -->
              <!-- Start Image3 Field -->
              <div style="display:none;">
                <input type="file" name="oldimage3" class="form-control" value="<?php echo $row['img3'] ?>" />
              </div>
							<div class="form-group form-group-lg" style="margin-top:20px;">
								<label class="col-sm-1 control-label">Image 3</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9 custom-file custom-file2" style="top:13px; left:14px">
									<span>Choose Your File</span>
									<input type="file" name="image3" class="form-control" value="<?php echo $item['img3']; ?>" />
								</div>
							</div>
							<!-- End Image3 Field -->
              <!-- Start Image4 Field -->
              <div style="display:none;">
                <input type="file" name="oldimage4" class="form-control" value="<?php echo $row['img4'] ?>" />
              </div>
							<div class="form-group form-group-lg" style="margin-top:20px;">
								<label class="col-sm-1 control-label">Image 4</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9 custom-file custom-file2" style="top:13px; left:14px">
									<span>Choose Your File</span>
									<input type="file" name="image4" class="form-control" value="<?php echo $item['img4']; ?>" />
								</div>
							</div>
							<!-- End Image4 Field -->
              <!-- Start Hidden Item ID -->
              <input hidden type="number" name="id" value="<?php echo $ItemID; ?>">
              <!-- End Hidden Item ID-->
							<!-- Start Tags Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-1 control-label">Tags</label>
								<div class="col-sm-offset-1 col-sm-10 col-md-9">
									<input 
										type="text" 
										name="tags" 
										class="form-control" 
                    value = "<?php echo $item['tags']; ?>"
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
                    value = "<?php echo $item['Count']; ?>"
										placeholder="Count Of The Item" 
                    required />
								</div>
							</div>
							<!-- End Count Field -->
							<!-- Start Submit Field -->
							<div class="form-group form-group-lg">
								<div class="col-sm-offset-2 col-sm-9">
									<input type="submit" value="Edit Item" class="btn btn-primary btn-lg" />
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
              <?php if (!empty($item['Image'])) { ?>
                <img class="img-responsive" src="<?php echo $ItemsDir . $item['Image']; ?>" alt="" />
              <?php } else { ?>
                <img class="img-responsive" src="img.png" alt="" />
              <?php } ?>
							<div class="caption">
								<h3 class="live-title">Title</h3>
								<p class="live-desc">Description</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
  

  
  /* ----------------------------------------------------------------------------- */
  }
  include $tpl . 'footerDesig.php';
  include $tpl . 'footer.php';
	ob_end_flush();
?>