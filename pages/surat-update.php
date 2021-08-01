<?php include_once("./header.php");?>
<!-- Main Content -->
<div class="main-content">
          <section class="section">
            <div class="section-header">
              <h1>Dokumentasi</h1>
            </div>
            <div class="row">
              <!-- <div class="mb-4 p-3">
                <button class="btn btn-dark btn-lg" name="TblTambah" data-toggle="modal" data-id="modal" data-target="#tambah_modal">
                Tambah</button>
              </div> -->
              <div class="mb-4 p-3">
                <form method="POST" action="index-cari.php" class="needs-validation">
                  <div class="input-group">
                    <input type="text" class="form-control" name="cari" placeholder="Search" required="">
                    <div class="input-group-btn">
                      <button class="btn btn-dark" name="TblCari"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <?php
if(isset($_POST["TblUpdate"])){
	$db=dbConnect();
	$jenis  =$db->escape_string($_POST["jenis_surat"]);
	$kode  =$db->escape_string($_POST["kode_surat"]);
	$nama  =$db->escape_string($_POST["nama_surat"]);
	$tgl   =$db->escape_string($_POST["tanggal"]);

	$file = $_FILES["file"]["name"];
	$temp_file = $_FILES["file"]["tmp_name"];
	$size = $_FILES["file"]["size"];

	$path = '../upload/';
	$validext = array('doc','docx','pdf');
	$fltext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
	//rename
	$fq = $nama.".".$fltext;

	if(in_array($fltext, $validext)){
		if($size < 2000000){
			$sql = "UPDATE surat SET nama_surat = '$nama', tgl_buat = '$tgl', dokumen = '$fq', username = '$np' WHERE kode_jenis = '$jenis' AND kode_surat = '$kode'";
			$res =$db->query($sql);
			if(!$res){
?>
				<div class="row">
					<div class="alert alert-danger" role="alert">
						Terjadi kesalahan. <a href="javascript:history.back()">Ketuk untuk <b>kembali.</b></a>
					</div>
				</div>
<?php
			} else {
				move_uploaded_file($temp_file, $path.$fq);
?>
				<div class="row">
					<div class="alert alert-success" role="alert">
						Berhasil menambahkan ke database. <a href="javascript:history.back()">Ketuk untuk <b>kembali.</b></a>
					</div>
				</div>
<?php
			}
		} else {
?>
			<div class="row">
				<div class="alert alert-danger" role="alert">
					Ukuran file terlalu besar. <a href="javascript:history.back()">Ketuk untuk <b>kembali.</b></a>
				</div>
			</div>
<?php
		}            
	} else {
?>
		<div class="row">
			<div class="alert alert-danger" role="alert">
				Format file tidak didukung! <a href="javascript:history.back()">Ketuk untuk <b>kembali.</b></a>
			</div>
		</div>
<?php
	}
}
?>
<?php require_once('./footer.php') ?>
</body>
</html>
