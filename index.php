<?php
// Mengambil data pada file data.json di folder data
$berkas = "data/data.json";
$jsonData = file_get_contents($berkas);
$dataHpAll = json_decode($jsonData, true);
// Mengambil data merk pada file merk.json di folder data
$berkasMerk = "data/merk.json";
$jsonMerk = file_get_contents($berkasMerk);
$dataMerkAll = json_decode($jsonMerk, true);

$listDiskon = array ("-", "5%", "10%", "20%", "25%", "40%");  // array diskon untuk ditampilkan di form input
$kaliDiskon = array("-"=>1, "5%"=>0.95, "10%"=>0.9, "20%"=>0.8, "25%"=>0.75, "40%"=>0.6);  // array diskon dengan key sesuai form input dan valuenya persen yang didapatkan dari diskon

// Fungsi menghitung pajak
/**
Fungsi menghitung Pajak dari harga pabrik
- Argumennya ialah harga handphone dari pabrik
Balikan dari fungsi ini ialah pajak dari harga handphonenya
**/
function pajak($hargaPabrik){
  if ($hargaPabrik >0 && $hargaPabrik < 1000000) {
    $pajak = $hargaPabrik * 0.05; // Pajak 5%
  } elseif ($hargaPabrik >= 1000000 && $hargaPabrik < 2500000) {
    $pajak = $hargaPabrik * 0.07; // Pajak 7%
  } elseif ($hargaPabrik >= 2500000 && $hargaPabrik < 5000000) {
    $pajak = $hargaPabrik * 0.09; // Pajak 9%
  } elseif ($hargaPabrik >= 5000000 && $hargaPabrik < 10000000) {
    $pajak = $hargaPabrik * 0.11; // Pajak 11%
  } elseif ($hargaPabrik >= 10000000) {
    $pajak = $hargaPabrik * 0.12; // Pajak 12%
  } else {
    return "Error";
  }
  
  return $pajak;
}

// Menghitung harga jual 
/**
 Fungsi hargaJual
 - Argumen pertama berisikan harga HP dari pabrik
 - Argumen kedua berisikan diskon 
 Balikan dari fungsi ini ialah harga jual atau harga akhir, setelah diberi pajak dan dikurangi diskon
**/
function hargaJual($hargaPabrik, $diskon){
  global $kaliDiskon;           // variabel global

  foreach ($kaliDiskon as $diskonKey=>$diskon_value){  // Mengambil value array meggunakan foreach dengan mencari key yang sama
    if ($diskon == $diskonKey){
      $nilaiDiskon = $diskon_value;
    }
  }
  $hargaJual = $hargaPabrik + pajak($hargaPabrik);   // Menghitung harga jual dengan menambahkan harga dari pabrik dengan pajak kemudian dikurangi diskon
  $hargaJual = $hargaJual * $nilaiDiskon;

  return $hargaJual;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>ReyPhone</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/hero.png" rel="icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="assets/vendor/datatables/css/datatables.min.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />
  </head>

  <body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top">
      <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="<?=$_SERVER['PHP_SELF'];?>" class="logo d-flex align-items-center">
          <img src="assets/img/hero.png" alt="Logo" />
          <span>ReyPhone</span>
        </a>

        <nav id="navbar" class="navbar">
          <ul>
            <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
            <li>
              <a class="nav-link scrollto" href="#data">Data HandPhone</a>
            </li>
            <li>
              <a class="getstarted scrollto shadow" href="" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah data <i class="bi bi-phone"></i></a>
            </li>
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <!-- .navbar -->
      </div>
    </header>
    <!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 d-flex flex-column justify-content-center">
            <h1 data-aos="fade-up">ReyPhone</h1>
            <h2 data-aos="fade-up" data-aos-delay="400">Bersinar Terang dengan Penawaran dan Layanan Terbaik!</h2>
            <div data-aos="fade-up" data-aos-delay="600">
              <div class="text-center text-lg-start">
                <a href="" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  <span>Tambah Data</span>
                  <i class="bi bi-phone"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="200">
            <div class="text-center">
              <img src="assets/img/hero.png" class="img-fluid" alt="Phone" width="300" />
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Hero -->

    <main id="main">
      <!-- ======= Data Hp Section ======= -->
      <section id="data" class="values">
        <div class="container" data-aos="fade-up">
          <header class="section-header">
            <h2>Tabel</h2>
            <p>Data HandPhone</p>
          </header>
          <div class="pt-4">
            <table id="myTable" class="table table-primary table-striped table-hover">
              <thead>
                <tr>
                  <th>Merk</th>
                  <th>Tipe</th>
                  <th>Harga Pabrik</th>
                  <th>Pajak</th>
                  <th>Diskon</th>
                  <th>Harga Jual</th>
                </tr>
              </thead>
              <tbody>
                <!-- Perulangan untuk menampilkan seluruh data HP dari array yang didapat pada file data.json -->
                <?php
                for($i=0; $i<count($dataHpAll); $i++){
                  
                ?>
                <tr>
                  <td><?=$dataHpAll[$i][0]?></td>
                  <td><?=$dataHpAll[$i][1]?></td>
                  <td><?=$dataHpAll[$i][2]?></td>
                  <td><?=$dataHpAll[$i][3]?></td>
                  <td><?=$dataHpAll[$i][4]?></td>
                  <td><?=$dataHpAll[$i][5]?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
      <!-- End Data Hp Section -->
    </main>

    <!-- Modal Tambah HP -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data HandPhone</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row mb-3">
                <label for="merkHp" class="col-sm-3 col-form-label">Merk</label>
                <div class="col-sm-7">
                  <select class="form-select shadow-sm" aria-label="Default select example" name="merkHp" id="merkHp">
                    <!-- Perulangan untuk menampilkan Merk HP yang ada -->
                    <?php
                    foreach ($dataMerkAll as $merk) {
                      echo "<option value='".$merk."'>".$merk."</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="col-2">
                  <a class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModalToggle2" data-bs-dismiss="modal">
                    <i class="bi bi-plus-lg"></i>
                  </a>
                </div>
              </div>
              <div class="row mb-3">
                <label for="tipe" class="col-sm-3 col-form-label">Tipe</label>
                <div class="col-sm-9">
                  <input type="text" name="tipe" class="form-control shadow-sm" id="tipe" placeholder="Masukan Tipe HP" />
                </div>
              </div>
              <div class="row mb-3">
                <label for="hargaPabrik" class="col-sm-3 col-form-label">Harga Pabrik</label>
                <div class="col-sm-9">
                  <input type="number" name="hargaPabrik" class="form-control shadow-sm" id="hargaPabrik" placeholder="Masukan harga dari pabrik" />
                </div>
              </div>
              <div class="row mb-3">
                <label for="diskon" class="col-sm-3 col-form-label">Diskon</label>
                <div class="col-sm-9">
                  <select class="form-select shadow-sm" aria-label="Default select example" name="diskon" id="diskon">
                    <!-- Perluangan untuk menampilkan array diskon -->
                    <?php
                    foreach ($listDiskon as $diskon){
                      echo "<option value='".$diskon."'>".$diskon."</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Tutup</button>
              <input type="submit" name="submitHp" class="btn btn-primary shadow-sm" value="Tambah" />
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- End Modal Tambah HP -->

    <!-- Menampung hasil inputan data HP -->
    <?php
    if (isset($_POST['submitHp'])){
      $merkHp = $_POST['merkHp'];
      $tipe = $_POST['tipe'];
      $hargaPabrik = $_POST['hargaPabrik'];
      $diskon = $_POST['diskon'];
      $pajak = pajak($hargaPabrik);
      $hargaJual = hargaJual($hargaPabrik, $diskon);

      $dataHpBaru = [$merkHp, $tipe, $hargaPabrik, $pajak, $diskon, $hargaJual];
      array_push($dataHpAll, $dataHpBaru);
      array_multisort($dataHpAll, SORT_ASC);
      $jsonData = json_encode($dataHpAll, JSON_PRETTY_PRINT);
      file_put_contents($berkas, $jsonData);
      ?>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <body>
          <script>
              Swal.fire({
              icon: 'success',
              title: 'Sukses',
              text: 'Data HP berhasil ditambahkan!',
              timer: 1500
              }).then((result) => {
                  window.location='<?=$_SERVER['PHP_SELF'];?>';
              })
          </script>
        </body>
      <?php
    }
    ?>


    <!-- Modal Tambah Merk -->
    <div class="modal fade nested-modal" id="exampleModalToggle2" tabindex="-1" aria-labelledby="exampleModalToggle2" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalToggle2">Tambah Merk HP</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row mb-3">
                <label for="merkBaru" class="col-sm-3 col-form-label">Merk</label>
                <div class="col-sm-9">
                  <input type="text" name="merkBaru" class="form-control shadow-sm" id="merkBaru" />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">Kembali</button>
              <input type="submit" name="submitMerk" class="btn btn-primary" value="Tambah Merk" />
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- End Modal Tambah Merk -->

    <!-- Menampung hasil inputan merk baru -->
    <?php
    if (isset($_POST['submitMerk'])) {
      $merkInput = $_POST['merkBaru'];

      array_push($dataMerkAll, $merkInput);
      array_multisort($dataMerkAll, SORT_ASC);
      $jsonMerk = json_encode($dataMerkAll, JSON_PRETTY_PRINT);
      file_put_contents($berkasMerk, $jsonMerk);

      ?>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <body>
          <script>
              Swal.fire({
              icon: 'success',
              title: 'Sukses',
              text: 'Merk berhasil ditambahkan!',
              timer: 1500
              }).then((result) => {
                  window.location='<?=$_SERVER['PHP_SELF'];?>';
              })
          </script>
        </body>
      <?php
    }
    ?>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
      <div class="container">
        <div class="copyright">
          <strong><span>ReyPhone</span></strong>
        </div>
        <div class="credits">
          Made by <a target="_blank" href="https://instagram.com/reynold.sgn/">Reynold Andre</a>
        </div>
      </div>
    </footer>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/vendor/datatables/js/datatables.min.js"></script>

    <script>
      $(document).ready(function () {
        $("#myTable").DataTable();
      });
    </script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
  </body>
</html>
