<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
?>

<?php
class Product 
{
	
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function productInsert($data,$files)
	{
		$productName = mysqli_real_escape_string($this->db->link,$data['productName']);
		$catId       = mysqli_real_escape_string($this->db->link,$data['catId']);
		$brandId     = mysqli_real_escape_string($this->db->link,$data['brandId']);
		$body        = mysqli_real_escape_string($this->db->link,$data['body']);
		$price       = mysqli_real_escape_string($this->db->link,$data['price']);
		$type        = mysqli_real_escape_string($this->db->link,$data['type']);

	$permited  = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $files['image']['name'];
    $file_size = $files['image']['size'];
    $file_temp = $files['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "uploads/".$unique_image;

    if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "") {
    	$msg = "<span class='error'>Field must not be empty!!</span>";
		return $msg;
    }else{
    	 move_uploaded_file($file_temp, $uploaded_image);
    	 $query = "INSERT INTO tbl_product(productName, catId ,brandId ,body,price,image,type) VALUES('$productName','$catId ','$brandId','$body','$price','$uploaded_image','$type')";

    	 $insert_row = $this->db->insert($query);
			if ($insert_row) {
				$msg = "<span class='success'>Category inserted successfully</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Category not inserted successfully</span>";
				return $msg;
			}
    }
	}
	public function getAllProduct()
	{
		$query = "SELECT p.*,c.catName,b.brandName
		FROM tbl_product as p, tbl_category as c, tbl_brand as b
		WHERE p.catId = c.catId AND p.brandId = b.brandId
		order by p.productId DESC";
		/*$query = "SELECT  tbl_product.*, tbl_category.catName,tbl_brand.brandName 
		From tbl_product
		INNER JOIN tbl_category
		ON tbl_product.catId = tbl_category.catId
		INNER JOIN tbl_brand
		ON tbl_product.brandId = tbl_brand.brandId
		order by tbl_product.productId DESC";*/
		$result = $this->db->select($query);
		return $result;
	}
	public function getProById($id)
	{
		$query = "SELECT  * FROM tbl_product WHERE productId = '$id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function productUpdate($data,$files,$id)
	{
		$productName = mysqli_real_escape_string($this->db->link,$data['productName']);
		$catId       = mysqli_real_escape_string($this->db->link,$data['catId']);
		$brandId     = mysqli_real_escape_string($this->db->link,$data['brandId']);
		$body        = mysqli_real_escape_string($this->db->link,$data['body']);
		$price       = mysqli_real_escape_string($this->db->link,$data['price']);
		$type        = mysqli_real_escape_string($this->db->link,$data['type']);

	$permited  = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $files['image']['name'];
    $file_size = $files['image']['size'];
    $file_temp = $files['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "uploads/".$unique_image;

    if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "") {
    	$msg = "<span class='error'>Field must not be empty!!</span>";
		return $msg;
    }else{
    	if (!empty($file_name)) {
    		# code...
    

    if (empty($file_name)) {
     echo "<span class='error'>Please Select any Image !</span>";
    }elseif ($file_size >1048567) {
     echo "<span class='error'>Image Size should be less then 1MB!
     </span>";
    } elseif (in_array($file_ext, $permited) === false) {
     echo "<span class='error'>You can upload only:-"
     .implode(', ', $permited)."</span>";
    } else{
    	 move_uploaded_file($file_temp, $uploaded_image);
    	
    	 $query = "UPDATE tbl_product
    	 			SET 
    	 			productName = '$productName',
    	 			catId 		= '$catId',
    	 			brandId 	= '$brandId',
    	 			body 		= '$body',
    	 			price 		= '$price',
    	 			image 		= '$uploaded_image',
    	 			type 		= '$type'
    	 			WHERE productId = '$id'
    	 			";

    	 $updat_row = $this->db->update($query);
			if ($updat_row) {
				$msg = "<span class='success'>Product Updated successfully</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Product not Updated successfully</span>";
				return $msg;
			}
    }

    	}else{

    	
    	 $query = "UPDATE tbl_product
    	 			SET 
    	 			productName 	= '$productName',
    	 			catId 			= '$catId',
    	 			brandId 		= '$brandId',
    	 			body 			= '$body',
    	 			price 			= '$price',
    	 			type 			= '$type'
    	 			WHERE productId = '$id'
    	 			";

    	 $updat_row = $this->db->update($query);
			if ($updat_row) {
				$msg = "<span class='success'>Product Updated successfully</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Product not Updated successfully</span>";
				return $msg;
			}
    	}
    }
	}
	public function delProById($id)
	{
		$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
		$getData = $this->db->select($query);
		if ($getData) {
			while ($delImg = $getData->fetch_assoc()) {
				$dellink = $delImg['image'];
				unlink($dellink);
			}
		}
		$delquery = "DELETE FROM tbl_product WHERE productId = '$id'";
		$delresult = $this->db->delete($delquery);
		
		if ($delresult) {
				$msg = "<span class='success'>Product Deleted successfully</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Product not Deleted successfully</span>";
				return $msg;
			}
		}

		public function getFeatureProduct()
		{
			$query = "SELECT  * FROM tbl_product WHERE type = '0' order by productId DESC LIMIT 4";
			$result = $this->db->select($query);
			return $result;
		}
		public function getNewProduct()
		{
			$query = "SELECT  * FROM tbl_product order by productId DESC LIMIT 4";
			$result = $this->db->select($query);
			return $result;
		}

		public function getSingleProduct($id)
		{
		$query = "SELECT p.*,c.catName,b.brandName
		FROM tbl_product as p, tbl_category as c, tbl_brand as b
		WHERE p.catId = c.catId AND p.brandId = b.brandId AND p.productId = '$id'";
		
		$result = $this->db->select($query);
		return $result;
		}
		public function latestFromIphone()
		{
			$query = "SELECT  * FROM tbl_product where brandId = '1'  order by productId DESC LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}
		public function latestFromSamsung()
		{
			$query = "SELECT  * FROM tbl_product where brandId = '2'  order by productId DESC LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}
		public function latestFromCanon()
		{
			$query = "SELECT  * FROM tbl_product where brandId = '3'  order by productId DESC LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}
		public function latestFromAcer()
		{
			$query = "SELECT  * FROM tbl_product where brandId = '4'  order by productId DESC LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}

		public function productByCat($id)
	{
		$catId        = mysqli_real_escape_string($this->db->link,$id);
		$query = "SELECT  * FROM tbl_product WHERE catId = '$catId'";
		$result = $this->db->select($query);
		return $result;
	}
	public function insertCompareData($cmprid,$cmrId)
	{
		$cmrId            = mysqli_real_escape_string($this->db->link,$cmrId);
		$productId        = mysqli_real_escape_string($this->db->link,$cmprid);
		$cquery = "SELECT  * FROM tbl_compare WHERE cmrId = '$cmrId' AND productId = '$productId'";
		$check = $this->db->select($cquery);
		if ($check) {
			$msg = "<span class='error'>Already Added to compare</span>";
			return $msg;
		}

		$query = "SELECT  * FROM tbl_product WHERE productId = '$productId'";
		$result = $this->db->select($query)->fetch_assoc();
		if ($result) {
			
				$productId = $result['productId'];
				$productName = $result['productName'];
				$price = $result['price'];
				$image = $result['image'];

				$query = "INSERT INTO tbl_compare(cmrId,productId,productName,price,image) VALUES('$cmrId','$productId ','$productName','$price','$image')";
    	 		$insert_row = $this->db->insert($query);
				
			if ($insert_row) {
				$msg = "<span class='success'>Added to compare</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Not Added !! </span>";
				return $msg;
			}
		}
	}
	public function getCompareData($cmrId)
	{
		$query = "SELECT  * FROM tbl_compare WHERE cmrId = '$cmrId' ORDER BY id DESC ";
		$result = $this->db->select($query);
		return $result;
	}
	public function delCompareData($cmrId)
	{
		 
		$query = "DELETE FROM tbl_compare WHERE cmrId = '$cmrId'";
		$result = $this->db->select($query);
		return $result;
	}
	public function saveWishListData($id,$cmrId)
	{	
		$cquery = "SELECT  * FROM tbl_wlist WHERE cmrId = '$cmrId' AND productId = '$id'";
		$check = $this->db->select($cquery);
		if ($check) {
			$msg = "<span class='error'>Already Added to compare !!</span>";
			return $msg;
		}
		$query = "SELECT  * FROM tbl_product WHERE productId = '$id'";
		$result = $this->db->select($query)->fetch_assoc();
		if ($result) {
			
				$productId = $result['productId'];
				$productName = $result['productName'];
				$price = $result['price'];
				$image = $result['image'];

				$query = "INSERT INTO tbl_wlist(cmrId,productId,productName,price,image) VALUES('$cmrId','$productId ','$productName','$price','$image')";
    	 		$insert_row = $this->db->insert($query);
				
			if ($insert_row) {
				$msg = "<span class='success'>Added to compare</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Not Added !! </span>";
				return $msg;
			}
		}
	}
	public function checkWishListData($cmrId)
	{
		$query = "SELECT  * FROM tbl_wlist WHERE cmrId = '$cmrId' ORDER BY id DESC ";
		$result = $this->db->select($query);
		return $result;
	}


public function delWistListData($cmrId)
	{
		 
		$query = "DELETE FROM tbl_wlist WHERE cmrId = '$cmrId'";
		$result = $this->db->select($query);
		return $result;
	}













}

?>