<?php
	ob_start();
	session_start();
  $search = $_POST['searchInput'];
	$pageTitle = 'Search';
	include 'init.php';

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
?>

  <h1 class="text-center">Search Results</h1>
  <div class="container">
    <?php
      $all = array();
      $allItems = getAllFrom("*", "items", "", "where Approve = 1 AND Member_ID != {$_SESSION['uid']}", "Item_ID");
      if (sizeof($allItems) > 0) {
        foreach ($allItems as $item) {
          $checkName    = stripos($item['Name'], $search) !== false;
          $checkDesc    = stripos($item['Description'], $search) !== false;
          $checkCountry = stripos($item['Country_Made'], $search) !== false;
          $checkDate    = stripos($item['Add_Date'], $search) !== false;
          $checkPrice   = stripos($item['Price'] . '$', $search) !== false;
          $checkTag     = stripos($item['tags'], $search) !== false;
          if ($checkName || $checkDesc || $checkCountry || $checkDate || $checkPrice || $checkTag) {
            $all[] = $item;
          }
        }
        if (! empty($all)) {
          foreach ($all as $item) {
            echo '<div class="col-sm-6 col-md-3 item-size2" style="margin-top:20px;">';?>
              <form method="post" action="index.php?action=add&id=<?php echo $item['Item_ID'] ?>">
                <?php
                  echo '<div class="thumbnail item-box">';
                    if ($item['Count'] > 0) {
                      echo '<span class="price-tag">' . $item['Price'] . '$</span>';
                    } else {
                      echo '<span class="OOF">Out Of Stock</span>';
                    }
                    if (empty($item['Image'])) { ?>
                      <img class="img-responsive img-product img-size2" src="img.png" alt="" />
                    <?php } else { ?>
                      <img class="img-responsive img-product img-size2" src="<?php echo $ItemsDir . $item['Image']; ?>" alt="" />
                    <?php }
                    /*echo '<img class="img-responsive img-product" src="img.png" alt="" />';*/
                    if ($item['Count'] > 0) {
                      echo '<div class="caption">';
                        echo '<h3><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] .'</a></h3>';
                        echo '<p style="margin-bottom: 0px;">' . $item['Description'] . '</p>';
                        ?>
                        <?php if (isset($_SESSION['uid'])) { ?>
                        <div>
                          <input type="number" name="quantity" class="quantity" placeholder="max : <?php echo $item['Count']; ?>" min="0" max="<?php echo $item['Count']; ?>" />
                          <input type="hidden" name="hidden_name" value="<?php echo $item['Name']; ?>" />
                          <input type="hidden" name="hidden_price" value="<?php echo $item['Price']; ?>" />
                          <input type="submit" name="add_to_cart" style="margin-bottom: 5px;" class="btn btn-primary btn-sm pull-right" value="Add To Cart" />
                        </div>
                        <?php } else { ?>
                          <div class="date" style="margin-top: 10px;margin-bottom: 8px;"><?php echo $item['Add_Date']; ?></div>
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
          echo '<div class="alert alert-danger">Nothing Found</div>';
        }
      }
    ?>
  </div>
  
<?php
  include $tpl . 'footerDesig.php';
  include $tpl . 'footer.php';
	ob_end_flush();
?>