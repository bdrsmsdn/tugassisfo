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
if(isset($_POST["TblHapus"])){
	$db=dbConnect();
	if($db->connect_errno==0){
    $jenis  =$db->escape_string($_POST["jenis_surat"]);
    $kode  =$db->escape_string($_POST["kode_surat"]);
    $nama  =$db->escape_string($_POST["nama_surat"]);
    $tgl   =$db->escape_string($_POST["tanggal"]);
		// Susun query delete
    $sqldok     ="SELECT dokumen FROM surat WHERE kode_surat = '$kode' AND kode_jenis = '$jenis'";
    $resdok     =$db->query($sqldok);
    $datadok    =$resdok->fetch_row();
    unlink('../upload/'.$datadok[0]);
    $sql        ="DELETE FROM surat WHERE kode_surat = '$kode' AND kode_jenis = '$jenis'";
		// Eksekusi query delete
		$res=$db->query($sql);
		if($res){
			if($db->affected_rows>0){ // jika ada data terhapus
				?>
        <div class="row">
				  <div class="alert alert-success" role="alert">
            Data berhasil dihapus. <a href="menu.php">Ketuk untuk <b>kembali.</b></a>
          </div>
        </div>
				<?php
      }else{ // Jika sql sukses tapi tidak ada data yang dihapus
        ?>
        <div class="row">
				<div class="alert alert-danger" role="alert">
        Penghapusan gagal karena data yang dihapus tidak ada. <a href="index.php">Ketuk untuk <b>kembali.</b></a>
            </div>
        </div>
				<?php
      }
		}
		else{ // gagal query
			?>
				<div class="alert alert-danger" role="alert">
        Gagal menghapus data. <a href="index.php">Ketuk untuk <b>kembali.</b></a>
        </div>
            <?php
		}
	}
	else
		echo "Gagal koneksi".(DEVELOPMENT?" : ".$db->connect_error:"")."<br>";
}
?>
<?php include_once("./footer.php");?>
  </body>
</html>
