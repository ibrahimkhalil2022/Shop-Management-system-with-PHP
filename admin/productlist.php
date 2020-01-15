<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include_once '../classes/Product.php';?>
<?php include_once '../helpers/Format.php';?>
<?php
$pd = new Product();
$fm = new Format();
?>
<?php

if (isset($_GET['delproduct'])) {
	$id = $_GET['delproduct'];
	$delproduct = $pd->delProById($id);
}

?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Post List</h2>
        <div class="block"> 
        <?php
               if (isset($delproduct)) {
                   echo $delproduct;
               }
          ?>  
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>SL</th>
					<th>Product Name</th>
					<th>Category</th>
					<th>Brand</th>
					<th>Description</th>
					<th>Price</th>
					<th>Image</th>
					<th>type</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$getPd = $pd->getAllProduct();
				if ($getPd) {
					$i = 0;
					while ($result = $getPd->fetch_assoc()) {
						$i++;
				
				?>
				<tr class="odd gradeX">
					<td><?php echo $i;?></td>
					<td><?php echo $result['productName'];?></td>
					<td><?php echo $result['catName'];?></td>
					<td><?php echo $result['brandName'];?></td>
					<td><?php echo $fm->textShorten($result['body'],50);?></td>
					<td>BDT <?php echo $result['price'];?></td>
					<td><img src="<?php echo $result['image'];?>" height="40px" width="60px"></td>
					<td>
						<?php 
						if ($result['type'] == 0) {
							echo "Featured";
						}else{
							echo "General";
						}
						?>
							
						</td>
					<td><a href="productedit.php?productid=<?php  echo $result['productId'];?>">Edit</a> || <a onclick="return confirm('Are you sure to Delete!')" href="?delproduct=<?php  echo $result['productId'];?>">Delete</a></td>
				</tr>
				<?php 	
				}
				}
				?>
			</tbody>
		</table>

       </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php'; ?>
