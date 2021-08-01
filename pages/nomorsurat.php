<?php require_once('./header.php');
  $db = dbConnect();?>
        <!-- Main Content -->
        <div class="main-content">
          <section class="section">
            <div class="section-header">
              <h1>Penomoran Surat</h1>
            </div>
            <div class="row-mt-3 mb-3 justify-content-center">
                <div class="col-lg-6">
                 <div class="card">             
                  <div class="card-body">
                  <?php
        if(isset($_POST['TblUpload'])){
        $db=dbConnect();
        $nm   =$db->escape_string($_POST["nama"]);
        $jn	   =$db->escape_string($_POST["jenis"]);
        $p=$db->escape_string($_POST["pn"]);
        $da	   =$db->escape_string($_POST["date"]);
        $file = $_FILES["file"]["name"];
        $temp_file = $_FILES["file"]["tmp_name"];
        $size = $_FILES["file"]["size"];
        $path = '../upload/';

        $fltext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $validext = array('doc','docx','pdf');
        //rename
        $fq = $nm.".".$fltext;

        if(in_array($fltext, $validext)){
            //check size
            if($size < 2000000){
                //INI SQL NYA BLM --------------------------------------------------------------------
                $sql1 = "INSERT INTO surat(kode_surat) SELECT MAX(kode_surat)+1 FROM surat WHERE kode_jenis = '$jn'";
                $sql2 = "UPDATE surat SET nama_surat = '$nm', tgl_buat = '$da', dokumen = '$fq', kode_jenis = '$jn', username = '$np' WHERE kode_surat = (SELECT MAX(kode_surat) FROM surat WHERE kode_jenis IS NULL) AND kode_jenis IS NULL";
                $sql3 = "SELECT kode_surat FROM surat WHERE kode_jenis = '$jn' AND kode_surat = (SELECT MAX(kode_surat) FROM surat WHERE kode_jenis = '$jn')";
                $res1=$db->query($sql1);
                $res2=$db->query($sql2);
                $res3=$db->query($sql3);
                  if(!$res1 || !$res2 || !$res3){
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
                  <form method="post" name="frm" class="needs-validation" enctype="multipart/form-data">
                  <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Nama File</label>
                    <div class="col-sm-9">
                        <input type="text" required class="form-control" name="nama" id="nama" placeholder="Masukkan nama file">
                    </div>
                    </div>  
                  <div class="form-group row">
                      <label for="select" class="col-sm-3 col-form-label">Jenis Surat</label>
                      <div class="col-sm-9">
                      <select name="jenis" class="form-control">
                      <option>Pilih Kategori</option>
                        <?php
                        $datakategori=getJenis();
                        foreach($datakategori as $data){
                          ?>
                        <option value="<?= $data['kode_jenis']; ?>"><?= $data['nama_jenis']; ?></option>";
                        <?php
                        }
                        ?>
                    </select>
                      </div>
                    </div>                    
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Penerbit</label>
                    <div class="col-sm-9">
                        <input type="text" required class="form-control" name="pn" id="inputEmail3" placeholder="Masukkan penerbit">
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Date</label>
                    <div class="col-sm-9">
                        <input type="date" name="date" class="form-control" required>
                    </div>                                                          
                    </div>
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Upload Surat</label>
                    <div class="col-sm-9">
                        <input name="file" type="file" />
                    </div>                                                          
                    </div>                    
                    <div class="modal-footer justify-content-center">
        <input type="submit" value="Generate No Surat" name="TblTampil" class="btn btn-warning"></input>
        <?php 
          if(isset($_POST['TblTampil'])){
            $jenis = $_POST['jenis'];
            $ddd = substr($_POST['date'],5,2);
            $ddq = substr($_POST['date'],0,4);
            $date = $_POST['date'];
            $dq = getRomawi($ddd);
            $sql1 = "INSERT INTO surat(kode_surat) SELECT MAX(kode_surat)+1 FROM surat WHERE kode_jenis = '$jenis'";
            $sql2 = "UPDATE surat SET tgl_buat = '$date', kode_jenis = '$jenis' WHERE kode_surat = (SELECT MAX(kode_surat) FROM surat WHERE kode_jenis IS NULL) AND kode_jenis IS NULL";
            $sql3 = "SELECT kode_surat FROM surat WHERE kode_jenis = '$jenis' AND kode_surat = (SELECT MAX(kode_surat) FROM surat WHERE kode_jenis = '$jenis')";
            $res1=$db->query($sql1);
            $res2=$db->query($sql2);
            $res3=$db->query($sql3);
            if ($res1 && $res2) {
              if($db->affected_rows>0){
                while ($kode = $res3->fetch_assoc()) {
                  ?>
                  <script>
                    prompt("Nomor Surat", "<?= $_POST['jenis']; ?>.<?= $kode['kode_surat']; ?>/<?= strtoupper($_POST['pn']); ?>/<?= $dq; ?>/<?= $ddq; ?>");
                  </script>
                <?php
                }
              } 
            }
          }
         ?>
        
        <input type="submit" class="btn btn-warning" name="TblUpload" value="Generate dan Upload"></input>        
                     </div>
                   </form>
                  </div>
                 </div>
                </div>
              </div>
            </div>
          </section>
        </div>
        <?php require_once('./footer.php') ?>
  </body>
</html>