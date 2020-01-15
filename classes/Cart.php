<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
?>
<?php
class Cart
{
	
	private $db;
	private $fm;
	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function addToCart($quantity,$id)
	{
		$quantity = $this->fm->validation($quantity);

		$quantity = mysqli_real_escape_string($this->db->link,$quantity);
		$productId = mysqli_real_escape_string($this->db->link,$id);
		$sId = session_id();
		$squery = "SELECT * FROM tbl_product WHERE productId = '$productId'";
		$result = $this->db->select($squery)->fetch_assoc();
		$productName = $result['productName'];
		$price  	 = $result['price'];
		$image 		 = $result['image']; 

		$chquery = "SELECT * FROM tbl_cart WHERE productId = '$productId' And sId = '$sId'";
		$getPro = $this->db->select($chquery);
		if ($getPro) {
			$msg = "Product Already Added !";
			return $msg;
		}else{
			$query = "INSERT INTO tbl_cart(sId,productId,productName ,price,quantity,image) VALUES('$sId','$productId ','$productName','$price','$quantity','$image')";
    	 $insert_row = $this->db->insert($query);
			if ($insert_row) {
				echo "<script>window.location = 'cart.php';</script>";
			}else{
				echo "<script>window.location = '404.php';</script>";
			}  
		}
		  
	}
	public function getCartProduct()
	{
		$sId = session_id(); 
		$query = "SELECT  * FROM tbl_cart WHERE sId = '$sId'";
		$result = $this->db->select($query);
		return $result;
	}
	public function updateCart($quantity,$cartId)
	{
		$quantity = mysqli_real_escape_string($this->db->link,$quantity);
		$cartId = mysqli_real_escape_string($this->db->link,$cartId);

		$query = "UPDATE tbl_cart
					set
					quantity = '$quantity'
					where cartId = '$cartId'";
			$updated_row = $this->db->update($query);
			if ($updated_row) {
				echo "<script>window.location = 'cart.php';</script>";
			}else{
				$msg = "<span class='error'>Quantity not Updated successfully</span>";
				return $msg;
			}
	}
	public function delProById($delId)
	{
		$delId = mysqli_real_escape_string($this->db->link,$delId);
		$query = "DELETE FROM tbl_cart WHERE cartId = $delId";
  		$delcart = $this->db->delete($query);
  		if ($delcart) {
				echo "<script>window.location = 'cart.php';</script>";
			}else{
				$msg = "<span class='error'>Product not Deleted successfully</span>";
				return $msg;
			}
	}

	public function checkCartTable()
	{
		$sId = session_id(); 
		$query = "SELECT  * FROM tbl_cart WHERE sId = '$sId'";
		$result = $this->db->select($query);
		return $result;
	}
	public function delCustomerCart()
	{
		$sId = session_id(); 
		$query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
		$result = $this->db->select($query);
		return $result;
	}
	public function orderProduct($cmrId)
	{
		$sId = session_id(); 
		$query = "SELECT  * FROM tbl_cart WHERE sId = '$sId'";
		$getPro = $this->db->select($query);
		if ($getPro) {
			while ($result = $getPro->fetch_assoc()) {
				$productId = $result['productId'];
				$productName = $result['productName'];
				$quantity = $result['quantity'];
				$price = $result['price'] * $quantity;
				$image = $result['image'];

				$query = "INSERT INTO tbl_order(cmrId,productId,productName ,quantity,price,image) VALUES('$cmrId','$productId ','$productName','$quantity','$price','$image')";
    	 		$insert_row = $this->db->insert($query);
				
			}
		}
	}
	public function payableAmount($cmrId)
	{
		$query = "SELECT price FROM tbl_order WHERE cmrId = '$cmrId' AND date = now()";
		
		$result = $this->db->select($query);
		return $result;
	}
	public function getOrderProduct($cmrId)
	{
		$query = "SELECT * FROM tbl_order WHERE cmrId = '$cmrId' Order by date DESC";
		$result = $this->db->select($query);
		return $result;
	}
	public function checkOrder($cmrId)
	{
		$query = "SELECT  * FROM tbl_order WHERE cmrId = '$cmrId'";
		$result = $this->db->select($query);
		return $result;
	}
	public function getAllOrderProduct()
	{
		$query = "SELECT  * FROM tbl_order Order by date";
		$result = $this->db->select($query);
		return $result;
	}
	public function productShifted($id,$time,$price)
	{
		
		$id = mysqli_real_escape_string($this->db->link,$id);
		$time = mysqli_real_escape_string($this->db->link,$time);
		$price = mysqli_real_escape_string($this->db->link,$price);

			$query = "UPDATE tbl_order
					set
					status = '1'
					where cmrId = '$id' AND date= '$time' AND price = '$price'";
			$updated_row = $this->db->update($query);
			if ($updated_row) {
				$msg = "<span class='success'>Updated successfully</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Not Updated successfully</span>";
				return $msg;
			}
	}
	public function delProductShifted($id,$time,$price)
	{
		$id = mysqli_real_escape_string($this->db->link,$id);
		$time = mysqli_real_escape_string($this->db->link,$time);
		$price = mysqli_real_escape_string($this->db->link,$price);

		$query = "DELETE FROM tbl_order where cmrId = '$id' AND date= '$time' AND price = '$price'";
		$delOrderPro = $this->db->delete($query);
		if ($delOrderPro) {
				$msg = "<span class='success'>Product Deleted successfully</span>";
				return $msg;
			}else{
				$msg = "<span class='error'> Product Not Deleted successfully</span>";
				return $msg;
			}

	}
	public function productShiftConfirm($id,$time,$price)
	{
		$id = mysqli_real_escape_string($this->db->link,$id);
		$time = mysqli_real_escape_string($this->db->link,$time);
		$price = mysqli_real_escape_string($this->db->link,$price);

			$query = "UPDATE tbl_order
					set
					status = '3'
					where cmrId = '$id' AND date= '$time' AND price = '$price'";
			$updated_row = $this->db->update($query);
			if ($updated_row) {
				$msg = "<span class='success'>Updated successfully</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Not Updated successfully</span>";
				return $msg;
			}
	}
	public function delProductConfirm($id,$time,$price)
	{
		$id = mysqli_real_escape_string($this->db->link,$id);
		$time = mysqli_real_escape_string($this->db->link,$time);
		$price = mysqli_real_escape_string($this->db->link,$price);

		$query = "DELETE FROM tbl_order where cmrId = '$id' AND date= '$time' AND price = '$price'";
		$delOrderPro = $this->db->delete($query);
		if ($delOrderPro) {
				$msg = "<span class='success'>Product Deleted successfully</span>";
				return $msg;
			}else{
				$msg = "<span class='error'> Product Not Deleted successfully</span>";
				return $msg;
			}
	}
}
?>