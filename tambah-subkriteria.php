<<<<<<< HEAD
<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

if (isset($_POST['submit'])) :
    $id_subkri = $_POST['idsubkri'];
    $id_kriteria = $_POST['jeniskriteria'];
    $nama_subkri = $_POST['namasubkri'];
    $indikator = $_POST['indikator'];
    $indikatorfas = implode(', ', $_POST['indikatorfas']);
    $nilai = $_POST['nilai'];
    $stssubkri = $_POST['statussubkri'];
    $btsatas = $_POST['btsatas'];
    $btsbwh = $_POST['btsbwh'];

    // Validasi Sub Kriteria
    if (!$id_subkri) {
        $errors[] = 'ID Sub Kriteria tidak boleh kosong';
    }
    //Validasi Kriteria
    if (!$id_kriteria) {
        $errors[] = 'ID Kriteria tidak boleh kosong';
    }
    // Validasi Nama Sub Kriteria
    if (!$nama_subkri) {
        $errors[] = 'Nama Sub Kriteria tidak boleh kosong';
    }
    // Validasi Indikator
    if (!$indikator) {
        $errors[] = 'Indikator tidak boleh kosong';
    }
    // Validasi Indikator Fasilitas
    if (!$indikatorfas) {
        $errors[] = 'Indikator Fasilitas tidak boleh kosong, Centang Minimal 2 Pilihan';
    }
    // Validasi Batas Atas
    if (!$btsatas) {
        $errors[] = 'Batas Atas tidak boleh kosong';
    }
    // Validasi Batas Bawah
    if (!$btsbwh) {
        $errors[] = 'Batas Bawah tidak boleh kosong';
    }
    // Validasi Nilai
    if (!$nilai) {
        $errors[] = 'Nilai tidak boleh kosong';
    }
    //Insert Indikator Umum
    if (empty($errors) && $id_kriteria != "C2") :

        $simpan = mysqli_query($koneksi, "INSERT INTO sub_kriteria (ID_SUB_KRITERIA, 
        ID_KRITERIA, 
        NAMA_SUB_KRITERIA, 
        INDIKATOR, 
        NILAI_SUB_KRITERIA, 
        STATUS_SUB_KRITERIA, 
        BATAS_ATAS, 
        BATAS_BAWAH) 
        VALUES ('$id_subkri',
        '$id_kriteria',
        '$nama_subkri',
        '$indikator',
        '$nilai',
        '$stssubkri',
        '$btsatas',
        '$btsbwh')");
        if ($simpan) {
            redirect_to('list-sub-kriteria.php?status=sukses-baru');
        } else {
            $errors[] = 'Data gagal disimpan';
        }
    endif;

    //Insert Indikator Fasilitas
    if (empty($errors) && $id_kriteria == "C2") :

        $simpan = mysqli_query($koneksi, "INSERT INTO sub_kriteria (ID_SUB_KRITERIA, 
        ID_KRITERIA, 
        NAMA_SUB_KRITERIA, 
        INDIKATOR, 
        NILAI_SUB_KRITERIA, 
        STATUS_SUB_KRITERIA, 
        BATAS_ATAS, 
        BATAS_BAWAH) 
        VALUES ('$id_subkri',
        '$id_kriteria',
        '$nama_subkri',
        '$indikatorfas',
        '$nilai',
        '$stssubkri',
        '$btsatas',
        '$btsbwh')");
        if ($simpan) {
            //Simpan ke tabel detil sub kriteria fasilitas
            $temp = "";
            $fas = $_POST['indikatorfas'];
            foreach ($fas as $fas => $value) {
                $temp = $value;
                mysqli_query($koneksi, "INSERT INTO detil_subkri_fas (ID_KRITERIA,ID_SUB_KRITERIA,ID_FASILITAS) VALUES ('$id_kriteria','$id_subkri','$temp')");
            }
            redirect_to('list-sub-kriteria.php?status=sukses-baru');
        } else {
            $errors[] = 'Data gagal disimpan';
        }
    endif;

endif;

//ID Otomatis
$query = mysqli_query($koneksi, "SELECT CAST(MAX(RIGHT(ID_SUB_KRITERIA,1)) AS INTEGER) as idSubkri FROM SUB_KRITERIA");
$data = mysqli_fetch_array($query);
$IDSubKri = $data['idSubkri'];
$IDSubKri++;
if ($IDSubKri < 10) {
    $huruf = "S0";
    $idauto = $huruf . $IDSubKri;
} else {
    $query2 = mysqli_query($koneksi, "SELECT CAST(MAX(RIGHT(ID_SUB_KRITERIA,2)) AS INTEGER) as idSubkri FROM SUB_KRITERIA");
    $data2 = mysqli_fetch_array($query2);
    $IDSubKri2 = $data2['idSubkri'];
    $IDSubKri2++;
    $huruf = "S";
    $idauto = $huruf . $IDSubKri2;
}

?>

<?php
$page = "Sub Kriteria";
require_once('template/header.php');
?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Sub Kriteria</h1>

    <a href="list-sub-kriteria.php" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
        <span class="text">Kembali</span>
    </a>
</div>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-info">
        <?php foreach ($errors as $error) : ?>
            <?php echo $error; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-plus"></i> Tambah Data Sub Kriteria</h6>
    </div>

    <form action="tambah-subkriteria.php" method="post">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold"> Jenis Kriteria</label>

                    <select name="jeniskriteria" class="form-control" required>
                        <option value="">--Pilih--</option>
                        <?php $data3 = mysqli_query($koneksi, "SELECT * FROM kriteria WHERE STATUS_KRITERIA = 1 order by cast(ID_KRITERIA as integer) asc;");
                        while ($d3 = mysqli_fetch_array($data3)) {
                        ?>
                            <option value="<?php echo $d3["ID_KRITERIA"]; ?>"><?php echo $d3["NAMA_KRITERIA"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">ID Sub Kriteria</label>
                    <input autocomplete="off" type="text" name="idsubkri" required value="<?php echo $idauto ?>" readonly class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Nama Sub Kriteria</label>
                    <input autocomplete="off" type="text" name="namasubkri" required class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <script>
                        function showInput() {
                            var selectBox = document.getElementById("indikator");
                            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
                            // Show Hide Form
                            var inputContainer = document.getElementById("inputContainer");
                            var batas = document.getElementById("batas");

                            if (selectedValue === "Fasilitas") {
                                inputContainer.style.display = "block";
                                batas.style.display = "none";
                            } else {
                                batas.style.display = "block";
                                inputContainer.style.display = "none";
                            }
                        }
                    </script>
                    <label class="font-weight-bold">Jenis Indikator</label>
                    <select id="indikator" class="form-control" onchange="showInput()" required>
                        <option value="Umum">Umum</option>
                        <option value="Fasilitas">Fasilitas</option>
                    </select>
                </div>

                <div id="inputContainer" class="form-group col-md-6" style="display: none;">
                    <label class="font-weight-bold"> Pilih Fasilitas</label><br>
                    <?php $data2 = mysqli_query($koneksi, "SELECT * FROM fasilitas order by CAST(RIGHT(ID_FASILITAS,2) as INTEGER) asc");
                    while ($d2 = mysqli_fetch_array($data2)) {
                    ?> <input type="checkbox" name="indikatorfas[]" value="<?php echo $d2["ID_FASILITAS"] ?>">
                        <label for="indikatorfas"><?php echo $d2["NAMA_FASILITAS"] ?></label><br>
                    <?php
                    }
                    ?>
                </div>

                <div id="batas" class="form-group col-md-6">
                    <label class="font-weight-bold">Indikator</label>
                    <input style="margin-bottom: 15px;" autocomplete="off" type="text" class="form-control" name="indikator" required>
                    <label class="font-weight-bold">Batas Atas</label>
                    <input style="margin-bottom: 15px;" autocomplete="off" type="text" class="form-control" name="btsatas" required>
                    <label class="font-weight-bold">Batas Bawah</label>
                    <input autocomplete="off" type="text" class="form-control" name="btsbwh" required>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Nilai Sub Kriteria</label>
                    <input autocomplete="off" type="number" min="1" name="nilai" class="form-control" required>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Status Sub Kriteria</label>
                    <select name="statussubkri" class="form-control" required>
                        <option value="">--Pilih--</option>
                        <option value="0">Off</option>
                        <option value="1">On</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="card-footer text-right">
            <button name="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
        </div>
    </form>
</div>


<?php
require_once('template/footer.php');
=======
<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

if (isset($_POST['submit'])) :
    $id_subkri = $_POST['idsubkri'];
    $id_kriteria = $_POST['jeniskriteria'];
    $nama_subkri = $_POST['namasubkri'];
    $indikator = $_POST['indikator'];
    $indikatorfas = implode(', ', $_POST['indikatorfas']);
    $nilai = $_POST['nilai'];
    $stssubkri = $_POST['statussubkri'];
    $btsatas = $_POST['btsatas'];
    $btsbwh = $_POST['btsbwh'];

    // Validasi Sub Kriteria
    if (!$id_subkri) {
        $errors[] = 'ID Sub Kriteria tidak boleh kosong';
    }
    //Validasi Kriteria
    if (!$id_kriteria) {
        $errors[] = 'ID Kriteria tidak boleh kosong';
    }
    // Validasi Nama Sub Kriteria
    if (!$nama_subkri) {
        $errors[] = 'Nama Sub Kriteria tidak boleh kosong';
    }
    // Validasi Indikator
    if (!$indikator) {
        $errors[] = 'Indikator tidak boleh kosong';
    }
    // Validasi Indikator Fasilitas
    if (!$indikatorfas) {
        $errors[] = 'Indikator Fasilitas tidak boleh kosong, Centang Minimal 2 Pilihan';
    }
    // Validasi Batas Atas
    if (!$btsatas) {
        $errors[] = 'Batas Atas tidak boleh kosong';
    }
    // Validasi Batas Bawah
    if (!$btsbwh) {
        $errors[] = 'Batas Bawah tidak boleh kosong';
    }
    // Validasi Nilai
    if (!$nilai) {
        $errors[] = 'Nilai tidak boleh kosong';
    }
    //Insert Indikator Umum
    if (empty($errors) && $id_kriteria != "C2") :

        $simpan = mysqli_query($koneksi, "INSERT INTO sub_kriteria (ID_SUB_KRITERIA, 
        ID_KRITERIA, 
        NAMA_SUB_KRITERIA, 
        INDIKATOR, 
        NILAI_SUB_KRITERIA, 
        STATUS_SUB_KRITERIA, 
        BATAS_ATAS, 
        BATAS_BAWAH) 
        VALUES ('$id_subkri',
        '$id_kriteria',
        '$nama_subkri',
        '$indikator',
        '$nilai',
        '$stssubkri',
        '$btsatas',
        '$btsbwh')");
        if ($simpan) {
            redirect_to('list-sub-kriteria.php?status=sukses-baru');
        } else {
            $errors[] = 'Data gagal disimpan';
        }
    endif;

    //Insert Indikator Fasilitas
    if (empty($errors) && $id_kriteria == "C2") :

        $simpan = mysqli_query($koneksi, "INSERT INTO sub_kriteria (ID_SUB_KRITERIA, 
        ID_KRITERIA, 
        NAMA_SUB_KRITERIA, 
        INDIKATOR, 
        NILAI_SUB_KRITERIA, 
        STATUS_SUB_KRITERIA, 
        BATAS_ATAS, 
        BATAS_BAWAH) 
        VALUES ('$id_subkri',
        '$id_kriteria',
        '$nama_subkri',
        '$indikatorfas',
        '$nilai',
        '$stssubkri',
        '$btsatas',
        '$btsbwh')");
        if ($simpan) {
            //Simpan ke tabel detil sub kriteria fasilitas
            $temp = "";
            $fas = $_POST['indikatorfas'];
            foreach ($fas as $fas => $value) {
                $temp = $value;
                mysqli_query($koneksi, "INSERT INTO detil_subkri_fas (ID_KRITERIA,ID_SUB_KRITERIA,ID_FASILITAS) VALUES ('$id_kriteria','$id_subkri','$temp')");
            }
            redirect_to('list-sub-kriteria.php?status=sukses-baru');
        } else {
            $errors[] = 'Data gagal disimpan';
        }
    endif;

endif;

//ID Otomatis
$query = mysqli_query($koneksi, "SELECT CAST(MAX(RIGHT(ID_SUB_KRITERIA,1)) AS INTEGER) as idSubkri FROM SUB_KRITERIA");
$data = mysqli_fetch_array($query);
$IDSubKri = $data['idSubkri'];
$IDSubKri++;
if ($IDSubKri < 10) {
    $huruf = "S0";
    $idauto = $huruf . $IDSubKri;
} else {
    $query2 = mysqli_query($koneksi, "SELECT CAST(MAX(RIGHT(ID_SUB_KRITERIA,2)) AS INTEGER) as idSubkri FROM SUB_KRITERIA");
    $data2 = mysqli_fetch_array($query2);
    $IDSubKri2 = $data2['idSubkri'];
    $IDSubKri2++;
    $huruf = "S";
    $idauto = $huruf . $IDSubKri2;
}

?>

<?php
$page = "Sub Kriteria";
require_once('template/header.php');
?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Sub Kriteria</h1>

    <a href="list-sub-kriteria.php" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
        <span class="text">Kembali</span>
    </a>
</div>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-info">
        <?php foreach ($errors as $error) : ?>
            <?php echo $error; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-plus"></i> Tambah Data Sub Kriteria</h6>
    </div>

    <form action="tambah-subkriteria.php" method="post">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold"> Jenis Kriteria</label>

                    <select name="jeniskriteria" class="form-control" required>
                        <option value="">--Pilih--</option>
                        <?php $data3 = mysqli_query($koneksi, "SELECT * FROM kriteria WHERE STATUS_KRITERIA = 1 order by cast(ID_KRITERIA as integer) asc;");
                        while ($d3 = mysqli_fetch_array($data3)) {
                        ?>
                            <option value="<?php echo $d3["ID_KRITERIA"]; ?>"><?php echo $d3["NAMA_KRITERIA"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">ID Sub Kriteria</label>
                    <input autocomplete="off" type="text" name="idsubkri" required value="<?php echo $idauto ?>" readonly class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Nama Sub Kriteria</label>
                    <input autocomplete="off" type="text" name="namasubkri" required class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <script>
                        function showInput() {
                            var selectBox = document.getElementById("indikator");
                            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
                            // Show Hide Form
                            var inputContainer = document.getElementById("inputContainer");
                            var batas = document.getElementById("batas");

                            if (selectedValue === "Fasilitas") {
                                inputContainer.style.display = "block";
                                batas.style.display = "none";
                            } else {
                                batas.style.display = "block";
                                inputContainer.style.display = "none";
                            }
                        }
                    </script>
                    <label class="font-weight-bold">Jenis Indikator</label>
                    <select id="indikator" class="form-control" onchange="showInput()" required>
                        <option value="Umum">Umum</option>
                        <option value="Fasilitas">Fasilitas</option>
                    </select>
                </div>

                <div id="inputContainer" class="form-group col-md-6" style="display: none;">
                    <label class="font-weight-bold"> Pilih Fasilitas</label><br>
                    <?php $data2 = mysqli_query($koneksi, "SELECT * FROM fasilitas order by CAST(RIGHT(ID_FASILITAS,2) as INTEGER) asc");
                    while ($d2 = mysqli_fetch_array($data2)) {
                    ?> <input type="checkbox" name="indikatorfas[]" value="<?php echo $d2["ID_FASILITAS"] ?>">
                        <label for="indikatorfas"><?php echo $d2["NAMA_FASILITAS"] ?></label><br>
                    <?php
                    }
                    ?>
                </div>

                <div id="batas" class="form-group col-md-6">
                    <label class="font-weight-bold">Indikator</label>
                    <input style="margin-bottom: 15px;" autocomplete="off" type="text" class="form-control" name="indikator" required>
                    <label class="font-weight-bold">Batas Atas</label>
                    <input style="margin-bottom: 15px;" autocomplete="off" type="text" class="form-control" name="btsatas" required>
                    <label class="font-weight-bold">Batas Bawah</label>
                    <input autocomplete="off" type="text" class="form-control" name="btsbwh" required>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Nilai Sub Kriteria</label>
                    <input autocomplete="off" type="number" min="1" name="nilai" class="form-control" required>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Status Sub Kriteria</label>
                    <select name="statussubkri" class="form-control" required>
                        <option value="">--Pilih--</option>
                        <option value="0">Off</option>
                        <option value="1">On</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="card-footer text-right">
            <button name="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
        </div>
    </form>
</div>


<?php
require_once('template/footer.php');
>>>>>>> 576b185375d749f33752cc2e77735153d7fe4856
?>