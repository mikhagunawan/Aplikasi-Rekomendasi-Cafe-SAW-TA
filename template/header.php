<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Aplikasi Rekomendasi Cafe Kota Surabaya</title>

  <!-- Custom fonts for this template-->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <!-- <link rel="shortcut icon" href="assets/img/favi.ico" type="image/x-icon">
  <link rel="icon" href="assets/img/favi.ico" type="image/x-icon"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon ">
          <i class="#">
            <img src="assets/img/cafe.png" alt="..." height="50"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SICAFE</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php if ($page == "Dashboard") {
                            echo "active";
                          } ?>">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span></a>
      </li>

      <?php
      $user_role = get_role();
      if ($user_role == 'admin') {
      ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Master Data
        </div>

        <li class="nav-item <?php if ($page == "Jenis") {
                              echo "active";
                            } ?>">
          <a class="nav-link" href="list-jenis.php">
            <i class="fas fa-fw fa-cube"></i>
            <span>Data Jenis Atribut</span></a>
        </li>

        <li class="nav-item <?php if ($page == "Kriteria") {
                              echo "active";
                            } ?>">
          <a class="nav-link" href="list-kriteria.php">
            <i class="fas fa-fw fa-cubes"></i>
            <span>Data Kriteria</span></a>
        </li>

        <li class="nav-item <?php if ($page == "Sub Kriteria") {
                              echo "active";
                            } ?>">
          <a class="nav-link" href="list-sub-kriteria.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Sub Kriteria</span></a>
        </li>

        <li class="nav-item <?php if ($page == "Fasilitas") {
                              echo "active";
                            } ?>">
          <a class="nav-link" href="list-fasilitas.php">
            <i class="fas fa-fw fa-landmark"></i>
            <span>Data Fasilitas</span></a>
        </li>

        <li class="nav-item <?php if ($page == "Cafe") {
                              echo "active";
                            } ?>">
          <a class="nav-link" href="list-cafe.php">
            <i class="fas fa-fw fa-coffee"></i>
            <span>Data Cafe</span></a>
        </li>

        <li class="nav-item <?php if ($page == "Hasil") {
                              echo "active";
                            } ?>">
          <a class="nav-link" href="hasil.php">
            <i class="fa fa-signal"></i>
            <span>Data Histori</span></a>
        </li>

      <?php
      } elseif ($user_role == 'konsumen') {
        $idk = (isset($_SESSION['id'])) ? trim($_SESSION['id']) : '';
        // Contoh pengecekan apakah ada data di tabel alternatif
        $query = "SELECT COUNT(*) AS total FROM alternatif WHERE ID_KONSUMEN = $idk"; // Gantilah dengan query yang sesuai dengan tabel alternatif Anda
        $result = mysqli_query($koneksi, $query); // $conn adalah koneksi ke database
        $data = mysqli_fetch_assoc($result);

        // Jika tidak ada data dalam tabel alternatif
        $is_data_available = $data['total'] > 0;
      ?>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Menu
        </div>

        <li class="nav-item <?php if ($page == "Alternatif") {
                              echo "active";
                            } ?>">
          <a class="nav-link" href="list-alternatif.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Pilih Cafe</span></a>
        </li>

        <li class="nav-item <?php if ($page == "Bobot Kriteria") {
                              echo "active";
                            } ?>">
          <a class="nav-link" href="bobot-kriteria.php" <?php echo !$is_data_available ? 'style="pointer-events: none; opacity: 0.5;"' : ''; ?>>
            <i class="fas fa-fw fa-balance-scale"></i>
            <span>Bobot Kriteria</span></a>
        </li>

        <li class="nav-item <?php if ($page == "Hasil") {
                              echo "active";
                            } ?>">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#rekomendasiCafeModal" <?php echo !$is_data_available ? 'style="pointer-events: none; opacity: 0.5;"' : ''; ?>>
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Histori Rekomendasi</span></a>
        </li>

      <?php
      }
      ?>

      <!-- Modal -->
      <div class="modal fade" id="rekomendasiCafeModal" tabindex="-1" aria-labelledby="rekomendasiCafeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="rekomendasiCafeModalLabel">Histori Rekomendasi Cafe</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- Pertanyaan interaktif -->
              <p>Apakah Anda ingin melihat histori rekomendasi cafe sebelumnya?</p>
            </div>
            <div class="modal-footer">
              <!-- Tombol Pilihan -->
              <button type="button" class="btn btn-secondary" id="noButton">Tidak, Terima Kasih</button>
              <button type="button" class="btn btn-primary" id="viewHistoryButton">Ya, Lihat Histori</button>
            </div>
          </div>
        </div>
      </div>
      <!-- JavaScript untuk menangani aksi tombol -->
      <script>
        // Mengambil elemen tombol
        const noButton = document.getElementById('noButton');
        const viewHistoryButton = document.getElementById('viewHistoryButton');

        // Ketika tombol "Tidak, Terima Kasih" diklik
        noButton.addEventListener('click', function() {
          // Menampilkan notifikasi dan mengarahkan pengguna ke halaman "Pilih Cafe"
          alert("Silakan melakukan pemilihan cafe pada menu PILIH CAFE.");
          window.location.href = "list-alternatif.php"; // Ganti dengan URL halaman pilih cafe yang sesuai
        });

        // Ketika tombol "Ya, Lihat Histori" diklik
        viewHistoryButton.addEventListener('click', function() {
          // Arahkan ke halaman baru untuk melihat histori rekomendasi cafe
          window.location.href = "history.php"; // Ganti dengan URL halaman histori yang sesuai
        });
      </script>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn text-primary d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-uppercase mr-2 d-none d-lg-inline text-gray-600 small">
                  <?php
                  echo $_SESSION['username'];
                  ?>
                </span>
                <img class="img-profile rounded-circle" src="assets/img/user.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <div class="container-fluid">