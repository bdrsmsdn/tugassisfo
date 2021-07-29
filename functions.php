<?php
define("DEVELOPMENT",TRUE);
function dbConnect(){
	$db=new mysqli("localhost","root","","dbsurat");// Sesuaikan dengan konfigurasi server anda.
	return $db;
}

function getJenis(){
	$db=dbConnect();
	if($db->connect_errno==0){
		$res=$db->query("SELECT * 
						 FROM jenis_surat
						 ORDER BY kode_jenis");
		if($res){
			$data=$res->fetch_all(MYSQLI_ASSOC);
			$res->free();
			return $data;
		}
		else
			return FALSE; 
	}
	else
		return FALSE;
}

function showError($message){
	?>
<div class="alert alert-danger" role="alert">
<?php echo $message;?>
</div>
	<?php
}

function getRomawi($bln){

	switch ($bln){

			  case 1:

				  return "I";

				  break;

			  case 2:

				  return "II";

				  break;

			  case 3:

				  return "III";

				  break;

			  case 4:

				  return "IV";

				  break;

			  case 5:

				  return "V";

				  break;

			  case 6:

				  return "VI";

				  break;

			  case 7:

				  return "VII";

				  break;

			  case 8:

				  return "VIII";

				  break;

			  case 9:

				  return "IX";

				  break;

			  case 10:

				  return "X";

				  break;

			  case 11:

				  return "XI";

				  break;

			  case 12:

				  return "XII";

				  break;

		}

 }

$sname= "localhost";
$unmae= "root";
$pwd = "";

$db_name = "dbsurat";

$conn = mysqli_connect($sname, $unmae, $pwd, $db_name);

if (!$conn) {
	echo "Connection failed!";
}


function showTrue($message){
	?>
<div style="background-color:#d4edda;padding:10px;border:1px solid red;margin:15px 0px">
<?php echo $message;?>
</div>
	<?php
}