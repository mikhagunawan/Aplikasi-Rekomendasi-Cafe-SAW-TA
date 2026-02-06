<?php
require('includes/init.php');
$errors = array();
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['username']) ? trim($_POST['password']) : '';

if (isset($_POST["login"])) {

    // Validasi
    if (!$username) {
        $errors[] = 'Username tidak boleh kosong';
    }
    if (!$password) {
        $errors[] = 'Password tidak boleh kosong';
    }

    if (empty($errors)) :
        $result = mysqli_query($koneksi, "SELECT * FROM konsumen WHERE USERNAME = '$username'");
        //$result2 = mysqli_query($koneksi, "SELECT * FROM user WHERE USERNAME = '$username'");

        if (mysqli_num_rows($result) === 1) {
            $data = mysqli_fetch_assoc($result);
            if (password_verify($password, $data['PASSWORD'])) {
                $_SESSION["login"] = true;
                $_SESSION["id"] = $data['ID_KONSUMEN'];
                $_SESSION["username"] = $data["USERNAME"];
                $_SESSION["status"] = $data["STATUS_KONSUMEN"];
                header('Location: dashboard.php');
                exit;
            } else {
                echo "Gagal Login";
            }
        } else {
            echo "<script>
        alert('Username Pengguna Tidak Tersedia/Belum Terdaftar, Silahkan Registrasi!');
        </script>";
        }
    endif;
}
if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
        alert('Pengguna baru berhasil ditambahkan!');
        </script>";
    } else {
        echo mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Aplikasi Rekomendasi Pemilihan Cafe Kota Surabaya Metode SAW</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="assets/css/mdb.min.css">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet" />
    <!-- <link rel="shortcut icon" href="assets/img/favi.ico" type="image/x-icon">
    <link rel="icon" href="assets/img/favi.ico" type="image/x-icon"> -->
    <style>
        body {
            background: linear-gradient(rgba(15, 23, 43, .9), rgba(15, 23, 43, .9)), url(assets/img/bg-hero.jpg);
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Outer Row -->
        <div class="row d-plex justify-content-center align-items-center">

            <div class="col-xl-5 col-lg-6 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <!-- Pills navs -->
                                    <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="tab-login" data-mdb-pill-init href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">Login</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="tab-register" data-mdb-pill-init href="#pills-register" role="tab" aria-controls="pills-register" aria-selected="false">Register</a>
                                        </li>
                                    </ul>
                                    <!-- Pills navs -->

                                    <!-- Pills content -->
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                                            <form action="mainform.php" method="post">
                                                <div class="text-center mb-3">
                                                    <h1 class="h4 text-gray-900 mb-4">Sign In</h1>
                                                </div>

                                                <!-- Email input -->
                                                <div data-mdb-input-init class="form-outline mb-4">
                                                    <input required autocomplete="off" type="text" id="loginName" name="username" class="form-control" />
                                                    <label class="form-label" for="loginName">Username</label>
                                                </div>

                                                <!-- Password input -->
                                                <div data-mdb-input-init class="form-outline mb-4">
                                                    <input required autocomplete="off" type="password" id="loginPassword" name="password" class="form-control" />
                                                    <label class="form-label" for="loginPassword">Password</label>
                                                </div>

                                                <!-- Submit button -->
                                                <button name="login" type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

                                            </form>
                                        </div>
                                        <?php
                                        // Query untuk mendapatkan ID maksimal dari tabel KONSUMEN
                                        $queryKonsumen = mysqli_query($koneksi, "SELECT MAX(CAST(ID_KONSUMEN AS INTEGER)) AS idKons FROM KONSUMEN");
                                        $dataKonsumen = mysqli_fetch_array($queryKonsumen);
                                        $IDKons = $dataKonsumen['idKons'];

                                        // Query untuk mendapatkan ID maksimal dari tabel user (Admin)
                                        $queryAdmin = mysqli_query($koneksi, "SELECT MAX(CAST(ID_ADMIN AS INTEGER)) AS idAdm FROM user");
                                        $dataAdmin = mysqli_fetch_array($queryAdmin);
                                        $IDAdm = $dataAdmin['idAdm'];

                                        // Increment untuk mendapatkan ID selanjutnya
                                        $IDKons++;
                                        $IDAdm++;
                                        ?>

                                        <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
                                            <form action="mainform.php" method="post">
                                                <div class="text-center mb-3">
                                                    <h1 class="h4 text-gray-900 mb-4">Sign Up</h1>
                                                </div>

                                                <!-- Tipe Pengguna (Admin atau Konsumen) -->
                                                <div class="mb-4">
                                                    <label class="form-label" for="userType">Tipe Pengguna</label>
                                                    <select name="tipeuser" id="userType" class="form-control" required>
                                                        <option value="konsumen">Konsumen</option>
                                                        <option value="admin">Admin</option>
                                                    </select>
                                                </div>

                                                <script>
                                                    // JavaScript to update the ID based on the selected user type
                                                    document.getElementById('userType').addEventListener('change', function() {
                                                        var userType = this.value;
                                                        var registerID = document.getElementById('registerID');

                                                        // Update ID based on user type selection
                                                        if (userType === 'konsumen') {
                                                            registerID.value = '<?php echo $IDKons; ?>';
                                                        } else if (userType === 'admin') {
                                                            registerID.value = '<?php echo $IDAdm; ?>';
                                                        }
                                                    });
                                                </script>

                                                <!-- ID Konsumen input -->
                                                <div data-mdb-input-init class="form-outline mb-4">
                                                    <input type="text" id="registerID" name="iduser" value="<?php echo $IDKons; ?>" class="form-control" readonly />
                                                    <label class="form-label" for="registerID">ID User </label>
                                                </div>

                                                <!-- Name input -->
                                                <div data-mdb-input-init class="form-outline mb-4">
                                                    <input type="text" id="registerName" name="fullname" class="form-control" required />
                                                    <label class="form-label" for="registerName">Nama Lengkap</label>
                                                </div>

                                                <!-- HP input -->
                                                <div data-mdb-input-init class="form-outline mb-4">
                                                    <input type="tel" id="registerNumber" name="number" class="form-control" pattern="^\d{1,13}$" maxlength="13" required />
                                                    <label class="form-label" for="registerNumber">Nomor HP</label>
                                                </div>

                                                <!-- Username input -->
                                                <div data-mdb-input-init class="form-outline mb-4">
                                                    <input type="text" id="registerUsername" name="username" class="form-control" required />
                                                    <label class="form-label" for="registerUsername">Username</label>
                                                </div>

                                                <!-- Password input -->
                                                <div data-mdb-input-init class="form-outline mb-4">
                                                    <input type="password" id="registerPassword" name="password" class="form-control" required />
                                                    <label class="form-label" for="registerPassword">Password</label>
                                                </div>

                                                <!-- Repeat Password input -->
                                                <div data-mdb-input-init class="form-outline mb-4">
                                                    <input type="password" id="registerRepeatPassword" name="password2" class="form-control" required />
                                                    <label class="form-label" for="registerRepeatPassword">Konfirmasi password</label>
                                                </div>

                                                <!-- Status Admin input -->
                                                <div class="mb-4">
                                                    <label class="form-label" for="userType">Status Pengguna</label>
                                                    <select name="statususer" class="select form-control" required>
                                                        <option value="0">Off</option>
                                                        <option value="1">On</option>
                                                    </select>
                                                </div>

                                                <!-- Submit button -->
                                                <button name="register" type="submit" class="btn btn-primary btn-block mb-3">Sign Up</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Pills content -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>
    <script type="text/javascript" src="assets/js/mdb.umd.min.js"></script>
</body>

</html>