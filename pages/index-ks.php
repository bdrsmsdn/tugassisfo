<?php 
require_once('./header2.php') ;
?>
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
$db=dbConnect();
$batas = 10;
$halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	

  $previous = $halaman - 1;
  $next = $halaman + 1;
  
	$data=mysqli_query($conn,"SELECT * FROM surat WHERE kode_surat != 0");
$jumlah_data = mysqli_num_rows($data);
$total_halaman = ceil($jumlah_data / $batas);
$halaman_2akhir = $total_halaman - 1;
$adjacents = "2";

$data_produk = mysqli_query($conn,"SELECT * FROM surat, pegawai WHERE surat.kode_surat != 0 AND surat.username = pegawai.username limit $halaman_awal, $batas");
       ?> 
            <div class="row">
                  <table class="table table-dark text-white text-center table-striped table-responsive-sm">
                    <tr>
                        <th>Kode Jenis</th><th>Kode Surat</th><th>Nama Surat</th>
                        <th>Tanggal</th><th>Pegawai</th><th colspan="2">Aksi</th>
                    </tr> 
                    <?php
  while($d = mysqli_fetch_array($data_produk)){
    ?>     
                    <tr>
                        <td><?php echo $d["kode_jenis"] ?></td>
                        <td><?php echo $d["kode_surat"] ?></td>
                        <td><a href="../upload/<?php echo $d["dokumen"] ?>"><?= $d["nama_surat"] ?></a></td>
                        <td><?php echo $d["tgl_buat"] ?></td>
                        <td><?php echo $d["nama_pegawai"] ?></td>
                        <td>
                            <div>
                                <a class="TblEdit" href="" name="TblEdit" data-toggle="modal" data-id="modal" data-target="#edit_modal"><i class="far fa-edit"></i>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div>
                                <a class="TblDelete" href="" name="TblDelete" data-toggle="modal" data-id="modal" data-target="#delete_modal"><i class="far fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php
		}
		?>
    </table>
                  </div>
                  <nav aria-label="Search results">
			<ul class="pagination justify-content-center">
				<li class="page-item">
					<a class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$previous'"; } ?>>Previous</a>
				</li>
				<?php 
        if ($total_halaman <= 10){  	 
          for ($x = 1; $x <= $total_halaman; $x++){
          if ($x == $halaman) {
            ?>
          <li class="page-item active" aria-current="page"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>	
          <?php
                  }else{
                ?>
          <li class="page-item" aria-current="page"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                <?php
                        }
                }
                ?>
                <li class="page-item">
                <a  class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
              </li>
              <?php
        } else {
      if($halaman <= 4 ){
				for($x=1;$x < 6;$x++){
          if($x == $halaman){
            ?>
            <li class="page-item active" aria-current="page"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
          <?php
          } else {
            ?>
            <li class="page-item" aria-current="page"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
          <?php
          }
				}
					?> 
        <li class="page-item">
        <li><a class="page-link" href="">...</a></li>
        </li>	
        <li class="page-item">
        <li><a class="page-link" href="?halaman=<?php echo $halaman_2akhir ?>"><?php echo $halaman_2akhir; ?></a></li>
        </li>			
        <li class="page-item">
        <li><a class="page-link" href="?halaman=<?php echo $total_halaman ?>"><?php echo $total_halaman; ?></a></li>
        </li>	
					<?php
      } elseif($halaman > 4 && $halaman < $total_halaman - 3){
        ?>
        <li class="page-item">
        <li><a class="page-link" href="?halaman=1">1</a></li>
        </li>	
        <li class="page-item">
        <li><a class="page-link" href="?halaman=2">2</a></li>
        </li>		
        <li class="page-item">
        <li><a class="page-link" href="">...</a></li>
        </li>	
        <?php
        for ($x = $halaman - $adjacents;$x <= $halaman + $adjacents;$x++){
          if($x == $halaman){
            ?>
            <li class="page-item active" aria-current="page"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
          <?php
          } else {
            ?>
            <li class="page-item" aria-current="page"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
          <?php
          }
        }
        ?>
                <li class="page-item">
        <li><a class="page-link" href="">...</a></li>
        </li>	
        <li class="page-item">
        <li><a class="page-link" href="?halaman=<?php echo $halaman_2akhir ?>"><?php echo $halaman_2akhir; ?></a></li>
        </li>			
        <li class="page-item">
        <li><a class="page-link" href="?halaman=<?php echo $total_halaman ?>"><?php echo $total_halaman; ?></a></li>
        </li>	
        <?php
      } else {
        ?>
        <li class="page-item">
        <li><a class="page-link" href="?halaman=1">1</a></li>
        </li>	
        <li class="page-item">
        <li><a class="page-link" href="?halaman=2">2</a></li>
        </li>		
        <li class="page-item">
        <li><a class="page-link" href="">...</a></li>
        </li>	
        <?php
        for ($x = $total_halaman - 4;$x <= $total_halaman;$x++){
          if($x == $halaman){
            ?>
            <li class="page-item active" aria-current="page"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
          <?php
          } else {
            ?>
            <li class="page-item" aria-current="page"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
          <?php
          }
        }
      }
				?>	
				<li class="page-item">
					<a  class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
				</li>
        <?php
        }
        ?>
			</ul>
		</nav>
                </div>
              </div>
            </div>
          </section>
        </div>
<?php require_once('./footer.php') ?>
  </body>
</html>
