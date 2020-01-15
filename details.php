<?php include 'inc/header.php';?>

<?php
if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
  echo "<script>window.location = '404.php';</script>";
}else{
  $id = $_GET['proid'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $quantity = $_POST['quantity'];
    $addCart = $ct->addToCart($quantity,$id);
 }

?>
<?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compare'])) {
   	$productId = $_POST['productId'];
    $insertCompare = $pd->insertCompareData($productId,$cmrId);
 }
?>
<?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wlist'])) {
    $saveWlist = $pd->saveWishListData($id,$cmrId);
 }
?>

<style type="text/css">
	.mybutton{width: 100px;float: left;margin-right: 50px;}
</style>
 <div class="main">
    <div class="content">
    	<div class="section group">
				<div class="cont-desc span_1_of_2">	
				<?php 
				$getPd = $pd->getSingleProduct($id); 
				if ($getPd) {
					while ($result = $getPd->fetch_assoc()) {
						
				
				?>			
					<div class="grid images_3_of_2">
						<img src="admin/<?php echo $result['image'];?>" alt="" />
					</div>
				<div class="desc span_3_of_2">
					<h2><?php echo $result['productName'];?></h2>
										
					<div class="price">
						<p>Price: <span>BDT <?php echo $result['price'];?></span></p>
						<p>Category: <span><?php echo $result['catName'];?></span></p>
						<p>Brand:<span><?php echo $result['brandName'];?></span></p>
					</div>
				<div class="add-cart">
					<form action="" method="post">
						<input type="number"  name="quantity" value="1" class="buyfield"/>
						<input type="submit" class="buysubmit" name="submit" value="Buy Now"/>
					</form>				
				</div>
	<span style="color: red; font-size: 19px;">
		<?php 
			if (isset($addCart)) {
				echo $addCart;
			}
		?>	
	</span>
		<?php 
			if (isset($insertCompare)) {
				echo $insertCompare;
			}
			if (isset($saveWlist)) {
				echo $saveWlist;
			}
		?>
<?php
	$login = Session::get("cuslogin");
	if ($login) { ?>
<div class="add-cart">
	<div class="mybutton">
		<form action="" method="post">
			<input type="hidden"  name="productId" value="<?php echo $result['productId'];?>" class="buyfield"/>
			<input type="submit" class="buysubmit" name="compare" value="Add to Compare"/>
		</form>
	</div>
	<div class="mybutton">
		<form action="" method="post">
			<input type="submit" class="buysubmit" name="wlist" value="Save to List"/>
		</form>
	</div>
</div>
<?php } ?>
				<!-- <div class="add-cart">
					<a class="buysubmit" href="?wlistid=<?php //echo $result['productId'];?>">Save to List</a>			
					<a class="buysubmit" href="?cmprid=<?php //echo $result['productId'];?>"></a>			
				</div> -->
			</div>
			<div class="product-desc">
			<h2>Product Details</h2>
			<?php echo $result['body'];?>
	    </div>
				
	</div>
	<?php 	} }?>
				<div class="rightsidebar span_3_of_1">
					<h2>CATEGORIES</h2>
					<ul>
						<?php
						$getcat = $cat->getAllCat();
						if ($getcat) {
							while ($result = $getcat->fetch_assoc()) {
								
						
						?>
				      <li><a href="productbycat.php?catId=<?php echo $result['catId'];?> "><?php echo $result['catName'];?></a></li>
				      <?php
				      	}
						}
				      ?>
    				</ul>
    	
 				</div>
 		</div>
 	</div>
	</div>
   <?php include 'inc/footer.php';?>