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
                  <form method="post" name="frm" class="needs-validation" enctype="form-data">
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
        
        <button data-toggle="modal" data-id="modal" data-target="#tampil_modal" class="btn btn-warning" name="TblUpload" >Generate dan Upload</button>
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
        <div class="modal fade" id="tampil_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="" method="post" class="dropzone" enctype="multipart/form-data">
        <input type="file" name="file"/>           
    </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-warning" name="TblSave">Submit</button>
      </div>
    </div>
  </div>
 </form>
</div>   

<?php 
    if(isset($_POST['TblSave'])){
        $db=dbConnect();
        $jn	   =$db->escape_string($_POST["jenis"]);
        $p=$db->escape_string($_POST["pn"]);
        $da	   =$db->escape_string($_POST["date"]);
        $file = $_FILES["file"]["name"];
        $size = $_FILES["file"]["size"];
        $path = '../../upload/';

        $fltext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $validext = array('doc','docx','pdf');
        //rename
        $fq = rand(1000,1000000).".".$fltext;

        if(in_array($fltext, $validext)){
            //check size
            if($size < 10000000){
                //INI SQL NYA BLM --------------------------------------------------------------------
                $sql1 = "INSERT INTO surat(kode_surat) SELECT MAX(kode_surat)+1 FROM surat WHERE kode_jenis = '$jenis'";
                $sql2 = "UPDATE surat SET nama_surat = '$file', tgl_buat = '$da', dokumen = '', kode_jenis = '$jenis' WHERE kode_surat = (SELECT MAX(kode_surat) FROM surat WHERE kode_jenis IS NULL) AND kode_jenis IS NULL";
                $sql3 = "SELECT kode_surat FROM surat WHERE kode_jenis = '$jenis' AND kode_surat = (SELECT MAX(kode_surat) FROM surat WHERE kode_jenis = '$jenis')";
                $res1=$db->query($sql1);
                $res2=$db->query($sql2);
                $res3=$db->query($sql3);
                  $result = $db->query($sql);
                  if(!$result){
                    ?>
                    <div class="row">
                          <div class="alert alert-danger" role="alert">
                    Terjadi kesalahan. <a href="javascript:history.back()">Ketuk untuk <b>kembali.</b></a>
                  </div>
                </div>
                <?php
                  } else {
                    move_uploaded_file($file, $path.$fq);
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
  </div>
                </div>
  </body>
</html>