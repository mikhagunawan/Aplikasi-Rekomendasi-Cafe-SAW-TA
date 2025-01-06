<?php
require_once('includes/init.php');

$user_role = get_role();
if ($user_role == 'admin' || $user_role == 'konsumen') {
    $page = "Dashboard";
    require_once('template/header.php');

?>

    <div class="mb-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-home"></i> Dashboard</h1>
        </div>

        <?php
        if ($user_role == 'admin') {
        ?>

            <!-- Content Row -->
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                Selamat datang <span class="text-uppercase"><b> <?php echo $_SESSION['username']; ?>! </b></span> Anda bisa mengoperasikan sistem dengan wewenang tertentu melalui pilihan menu di bawah.
            </div>
            <div class="row">

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="list-jenis.php" class="text-secondary text-decoration-none">Data Jenis Atribut</a></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-cube fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="list-kriteria.php" class="text-secondary text-decoration-none">Data Kriteria</a></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-cubes fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="list-sub-kriteria.php" class="text-secondary text-decoration-none">Data Sub Kriteria</a></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="list-fasilitas.php" class="text-secondary text-decoration-none">Data Fasilitas</a></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-landmark fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="list-cafe.php" class="text-secondary text-decoration-none">Data Cafe</a></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-coffee fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="hasil.php" class="text-secondary text-decoration-none">Data Histori</a></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-signal fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="list-alternatif.php" class="text-secondary text-decoration-none">Pilih Cafe</a></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-table fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="bobot-kriteria.php" class="text-secondary text-decoration-none">Bobot Kriteria</a></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="#" data-toggle="modal" data-target="#rekomendasiCafeModal" class="text-secondary text-decoration-none">Histori Rekomendasi</a></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-area fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            <div class="row">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <a href="list-alternatif.php" class="text-secondary text-decoration-none">Pilih Cafe</a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-table fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <a href="bobot-kriteria.php" class="text-secondary text-decoration-none" <?php echo !$is_data_available ? 'style="pointer-events: none; opacity: 0.5;"' : ''; ?>>Bobot Kriteria</a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <a href="#" data-toggle="modal" data-target="#rekomendasiCafeModal" class="text-secondary text-decoration-none" <?php echo !$is_data_available ? 'style="pointer-events: none; opacity: 0.5;"' : ''; ?>>Histori Rekomendasi</a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-area fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Modal -->
            <div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #4e73df; color: white; border-bottom: 2px solid #d1d3e2;">
                            <h5 class="modal-title" id="welcomeModalLabel">WELCOME!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="font-family: 'Arial', sans-serif; text-align: center; padding: 2rem; background-color: #f8f9fc;">
                            <h4 style="font-weight: 600; color: #4e73df;">Hi, <?php echo $_SESSION['username']; ?>!</h4>
                            <p style="font-size: 16px; color: #6c757d; font-weight: bold;">
                                Selamat datang di Aplikasi Rekomendasi Cafe Kota Surabaya Berbasis Web.</br>
                                Aplikasi ini dapat memberikan rekomendasi alternatif cafe terbaik pilihanmu!
                                Enjoy..^^
                            </p>
                        </div>
                        <div class="modal-footer" style="border-top: 2px solid #d1d3e2;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 20px; padding: 10px 20px; background-color: #6c757d; color: white; border: none;">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Trigger the modal when the page loads
                $(document).ready(function() {
                    $('#welcomeModal').modal('show');
                });
            </script>
        <?php
        }
        ?>
    </div>
<?php
    require_once('template/footer.php');
} else {
    header('Location: login.php');
}
?>