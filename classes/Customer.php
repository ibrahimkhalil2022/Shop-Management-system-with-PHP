<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
?>
<?php
class Customer
{
	
	private $db;
	private $fm;
	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function customerRegistation($data)
	{
		$name = mysqli_real_escape_string($this->db->link,$data['name']);
		$address = mysqli_real_escape_string($this->db->link,$data['address']);
		$city = mysqli_real_escape_string($this->db->link,$data['city']);
		$country = mysqli_real_escape_string($this->db->link,$data['country']);
		$zip = mysqli_real_escape_string($this->db->link,$data['zip']);
		$phone = mysqli_real_escape_string($this->db->link,$data['phone']);
		$email = mysqli_real_escape_string($this->db->link,$data['email']);
		$pass = MD5(mysqli_real_escape_string($this->db->link,$data['pass']));

		if ($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == ""|| $email == "" || $pass == "") {
    	$msg = "<span class='error'>Field must not be empty!!</span>";
		return $msg;
    	}

    	$mailquery = "SELECT * FROM tbl_customer where email='$email' Limit 1";
    	$mailcheck = $this->db->select($mailquery);
    	if ($mailcheck != false ) {
    		$msg = "Emial is alrady exist !!";
    		return $msg;
    	}else{
    		$query = "INSERT INTO tbl_customer(name, address ,city ,country,zip,phone,email,pass) VALUES('$name','$address ','$city','$country','$zip','$phone','$email','$pass')";

    	 $insert_row = $this->db->insert($query);
			if ($insert_row) {
				$msg = "<span class='success'>Customer Data inserted successfully</span>";
				return $msg;
			}else{
				$msg = "<span class='error' style='color:red; font_size:18px;'>Customer Data  not inserted !!</span>";
				return $msg;
			}
    	}
	}
	public function customerLogin($data)
	{
		$email = mysqli_real_escape_string($this->db->link,$data['email']);
		$pass = mysqli_real_escape_string($this->db->link,md5($data['pass']));
		if (empty($email) || empty($pass)) {
			$msg = "<span class='error' style='color:red; font_size:18px;'>Field Must Not be Empty !!</span>";
				return $msg;
		}
		$query = "SELECT * FROM tbl_customer WHERE email = '$email' and pass = '$pass'";
		$result = $this->db->select($query);
		if ($result != false) {
			$value = $result->fetch_assoc();
			Session::set("cuslogin", true);
			Session::set("cmrId", $value['id']);
			Session::set("cmrName", $value['name']);
			header("Location:profile.php");
		}else{
			$msg = "<span class='error' style='color:red; font_size:18px;'>Email And Password Not Matched !!</span>";
				return $msg;
		}
	}
	public function getCustomerData($id)
	{
		$query = "SELECT  * FROM tbl_customer WHERE id = '$id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function customerUpdate($data,$cmrId)
	{
		$name = mysqli_real_escape_string($this->db->link,$data['name']);
		$address = mysqli_real_escape_string($this->db->link,$data['address']);
		$city = mysqli_real_escape_string($this->db->link,$data['city']);
		$country = mysqli_real_escape_string($this->db->link,$data['country']);
		$zip = mysqli_real_escape_string($this->db->link,$data['zip']);
		$phone = mysqli_real_escape_string($this->db->link,$data['phone']);
		$email = mysqli_real_escape_string($this->db->link,$data['email']);
		

		if ($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == ""|| $email == "") {
    	$msg = "<span class='error'>Field must not be empty!!</span>";
		return $msg;
    	}else{
				$query = "UPDATE tbl_customer
					set
					name = '$name',
					address = '$address',
					city = '$city',
					country = '$country',
					zip = '$zip',
					phone = '$phone',
					email = '$email'
					where id = '$cmrId'";
			$updated_row = $this->db->update($query);
			if ($updated_row) {
				$msg = "<span class='success'>Customer Data  Updated successfully</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Customer Data not Updated successfully</span>";
				return $msg;
			}
    	}
	}
}
?>