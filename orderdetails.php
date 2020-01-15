<?php include 'inc/header.php';?>
<?php
$login = Session::get("cuslogin");
if ($login == false) {
    header("Location:login.php");
}
?>
<?php

if (isset($_GET['cnfirmid'])) {
    $id = $_GET['cnfirmid'];
    $time = $_GET['time'];
    $price = $_GET['price'];
    $confirm = $ct->productShiftConfirm($id,$time,$price);
}

if (isset($_GET['delPro'])) {
    $id = $_GET['delPro'];
    $time = $_GET['time'];
    $price = $_GET['price'];
    $delOrderConfirm = $ct->delProductConfirm($id,$time,$price);
    }
?>
<style >
tblone tr td{text-align: justify;}
</style>
 <div class="main">
    <div class="content">
    	<div class="section group">
    		<div class="notfound">
    			<h2>Your Order Details</h2>
                <table class="tblone">
                            <tr>
                                <th>No</th>
                                <th>Product Name</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <?php
                             $cmrId = Session::get("cmrId");
                            $getOrder = $ct->getOrderProduct($cmrId);
                            if ($getOrder) {
                                $id  = 0;
                                
                            while ($result = $getOrder->fetch_assoc()) {
                                $id++;
                            ?>
                            <tr>
                                <td><?php echo $id;?></td>
                                <td><?php echo $result['productName'];?></td>
                                <td><img src="admin/<?php echo $result['image'];?>" alt=""/></td>
                                <td>Tk.<?php echo $result['quantity'];?></td>
                                <td>Tk.<?php echo  $result['price'];?></td>
                                <td><?php echo $fm->formatDate($result['date']);?></td>
                                <td>
                                    <?php 
                                    if ($result['status'] == 0) {
                                        echo "Pending";
                                    }elseif ($result['status'] == 1) {?>
                                        <a href="?cnfirmid=<?php echo $cmrId; ?>&price=<?php echo $result['price']; ?>&time=<?php echo $result['date']; ?>">Shifted</a>
                                   <?php }else{
                                        echo "Confirm";
                                    }
                                    
                                    ?>
                                </td>
                                <?php
                                if ($result['status'] == 3) { ?>
                                    <td><a onclick="return confirm('Are you Sure to Delete ! ')" href="?delPro=<?php echo $result['cmrId']; ?>&price=<?php echo $result['price']; ?>&time=<?php echo $result['date']; ?>">X</a></td>
                               <?php }else{ ?>
                                    <td>N/A</td>
                              <?php }
                                ?>
                                
                            </tr>
                           
                            <?php }} ?>
                        </table>
                        
    		</div>
    	</div>		
			  	
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php';?>