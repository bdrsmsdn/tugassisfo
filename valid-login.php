<?php include_once("functions.php");?>
<?php
if(isset($_POST["TblLogin"])){
$db=dbConnect();
if($db->connect_errno==0){
		$username=$db->escape_string($_POST["username"]);
		$password=md5($db->escape_string($_POST["password"]));
			$sql="SELECT * FROM pegawai
				WHERE username='$username' and password='$password'";
			$res=$db->query($sql);
			if($res){
				if($res->num_rows==1){
					$data=$res->fetch_assoc();
					session_start();
					$_SESSION["username"]=$data["username"];
					$_SESSION["nama_pegawai"]=$data["nama_pegawai"];
					header("Location:./pages/index.php");
				} else {
					header("Location: index.php?error=1");
				}
			}							
	} else {
		header("Location: index.php?error=2");
	}
} else {
	header("Location: index.php?error=3");
}
?>