<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>

<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../classes/Customer.php');
?>
<?php
if (!isset($_GET['custid']) || $_GET['custid'] == NULL) {
  echo "<script>window.location = 'inbox.php';</script>";
}else{
  $id = $_GET['custid'];
}
$cus = new Customer();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  echo "<script>window.location = 'inbox.php';</script>";

 }

?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Customer Details</h2>
               <div class="block copyblock"> 
               <?php
               $getCust = $cus->getCustomerData($id);
               if ($getCust) {
              $i = 0;
              while ($result = $getCust->fetch_assoc()) {
                $i++;
               ?>
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                          <td>Name</td>
                            <td>
                                <input type="text" readonly="" value="<?php echo $result['name'];?>"  class="medium" />
                            </td>
                        </tr>
                        <tr>
                          <td>Address</td>
                            <td>
                                <input type="text" readonly="" value="<?php echo $result['address'];?>"  class="medium" />
                            </td>
                        </tr>
                        <tr>
                          <td>City</td>
                            <td>
                                <input type="text" readonly="" value="<?php echo $result['city'];?>"  class="medium" />
                            </td>
                        </tr>
                        <tr>
                          <td>Country</td>
                            <td>
                                <input type="text" readonly="" value="<?php echo $result['country'];?>"  class="medium" />
                            </td>
                        </tr>
                        <tr>
                          <td>Zip_Code</td>
                            <td>
                                <input type="text" readonly="" value="<?php echo $result['zip'];?>"  class="medium" />
                            </td>
                        </tr>
                        <tr>
                          <td>E-mail</td>
                            <td>
                                <input type="text" readonly="" value="<?php echo $result['email'];?>"  class="medium" />
                            </td>
                        </tr>
						            <tr> 
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                    </form>
                    <?php } } ?>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>
