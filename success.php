<?php include 'inc/header.php';?>
<?php
$login = Session::get("cuslogin");
if ($login == false) {
    header("Location:login.php");
}
?>
<style >
	.psuccess{
        width: 500px;
        min-height: 200px;
        text-align: center;
        border:1px solid #ddd;
        margin:0 auto;
        padding:50px;
    }
    .psuccess h2{
        border-bottom: 1px solid #ddd;
        margin-bottom: 65px;
        padding-bottom: 10px;
    }
    .psuccess p{
       line-height: 25px;
       text-align: left;
       font-size: 18px;
    }
    
</style>
 <div class="main">
    <div class="content">
    	<div class="section group">
    		<div class="psuccess">
                <h2>Success</h2>
                <?php
                $cmrId = Session::get("cmrId");
                $amount = $ct->payableAmount($cmrId);
                if ($amount) {
                    $sum = 0;
                    while ($result = $amount->fetch_assoc()) {
                        $price = $result['price'];
                        $sum = $sum + $price;
                    ?>


                <p style="color:red">Total Payable Amount(Including Vat) : TK. 
                   <?php 

                        $vat = $sum * 0.1;
                        $gtotal = $sum + $vat;
                        echo $gtotal;
                    ?> 
                    <?php  
                  }
                }
                ?>      
                    </p>
                <p>Thanks for purchase. Receive Your Order Successfully. We will contact with ASAP With delevery details. Here is Your order details....<a href="orderdetails.php">Visite Here..</a></p>
                
            </div>
            
    	</div>		
    </div>
 </div>
<?php include 'inc/footer.php';?>