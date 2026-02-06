<<<<<<< HEAD
<?php
require('includes/init.php');

// $username = isset($_POST['username']) ? trim($_POST['username']) : '';
// $password = isset($_POST['username']) ? trim($_POST['password']) : '';

if (isset($_POST['login'])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($koneksi, "SELECT * FROM user WHERE USERNAME = '$username'");

    //Cek Username
    if (mysqli_num_rows($result) > 0) {

        //Cek Password
        $data = mysqli_fetch_assoc($result);
        if (password_verify($password, $data["PASSWORD"])) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $data["ID_ADMIN"];
            $_SESSION["username"] = $data["USERNAME"];
            $_SESSION["status"] = $data["STATUS_ADMIN"];
            header('Location: dashboard.php');
            exit;
        }
    } else {
        echo "<script>
        alert('Akun Tidak Valid!');
        </script>";
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

    <title>Administrator - Aplikasi Rekomendasi Pemilihan Cafe Kota Surabaya Metode SAW</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/mdb.min.css">
    <!-- <link rel="shortcut icon" href="assets/img/favi.ico" type="image/x-icon">
    <link rel="icon" href="assets/img/favi.ico" type="image/x-icon"> -->
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-xl-5 col-lg-6 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">

                                    <form class="user" action="formadmin.php" method="post">
                                        <!-- Pills navs -->
                                        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="tab-login" data-mdb-pill-init href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">Login Administrator</a>
                                            </li>
                                        </ul>
                                        <!-- Pills navs -->

                                        <div class="text-center mb-3">
                                            <!-- Pills content -->
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                                                    <form action="formadmin.php" method="post">
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
                                                        <button type="submit" name="login" class="btn btn-primary btn-block mb-4">Sign in</button>

                                                    </form>
                                                </div>
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

=======
<?php
require('includes/init.php');

// $username = isset($_POST['username']) ? trim($_POST['username']) : '';
// $password = isset($_POST['username']) ? trim($_POST['password']) : '';

if (isset($_POST['login'])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($koneksi, "SELECT * FROM user WHERE USERNAME = '$username'");

    //Cek Username
    if (mysqli_num_rows($result) > 0) {

        //Cek Password
        $data = mysqli_fetch_assoc($result);
        if (password_verify($password, $data["PASSWORD"])) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $data["ID_ADMIN"];
            $_SESSION["username"] = $data["USERNAME"];
            $_SESSION["status"] = $data["STATUS_ADMIN"];
            header('Location: dashboard.php');
            exit;
        }
    } else {
        echo "<script>
        alert('Akun Tidak Valid!');
        </script>";
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

    <title>Administrator - Aplikasi Rekomendasi Pemilihan Cafe Kota Surabaya Metode SAW</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/mdb.min.css">
    <!-- <link rel="shortcut icon" href="assets/img/favi.ico" type="image/x-icon">
    <link rel="icon" href="assets/img/favi.ico" type="image/x-icon"> -->
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-xl-5 col-lg-6 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">

                                    <form class="user" action="formadmin.php" method="post">
                                        <!-- Pills navs -->
                                        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="tab-login" data-mdb-pill-init href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">Login Administrator</a>
                                            </li>
                                        </ul>
                                        <!-- Pills navs -->

                                        <div class="text-center mb-3">
                                            <!-- Pills content -->
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                                                    <form action="formadmin.php" method="post">
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
                                                        <button type="submit" name="login" class="btn btn-primary btn-block mb-4">Sign in</button>

                                                    </form>
                                                </div>
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

>>>>>>> 576b185375d749f33752cc2e77735153d7fe4856
</html>