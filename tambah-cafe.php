<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

if (isset($_POST['submit'])) :
    $idcafe = $_POST['idcafe'];
    $namacafe = $_POST['namacafe'];
    $alamat = $_POST['alamat'];
    $notelp = $_POST['notelp'];
    $hargamin = $_POST['hargamin'];
    $fas = $_POST['fasilitas'];
    $jmlmenu = $_POST['jmlhmenu'];
    $pelayanan = $_POST['pelayanan'];
    $gambar = $_POST['gambar'];
    $deskripsi = $_POST['deskripsi'];
    $stscafe = $_POST['stscafe'];
    $stsfascafe = $_POST['stsfascafe'];

    //Cek Harga Minimal
    if ($hargamin < 500) {
        $errors[] = 'Ulangi input harga minimal!';
    }
    if (empty($errors)) :

        $simpan = mysqli_query($koneksi, "INSERT INTO cafe (ID_CAFE, NAMA_CAFE, ALAMAT, NOTELP, HARGA_MIN, JUMLAH_MENU, PELAYANAN, GAMBAR, DESKRIPSI, STATUS_CAFE) VALUES ('$idcafe','$namacafe','$alamat','$notelp','$hargamin','$jmlmenu','$pelayanan','$gambar','$deskripsi','$stscafe')");

        if ($simpan) {

            //Simpan ke tabel Sub Kriteria Cafe - Harga
            //$temp = "";
            $query3 = mysqli_query($koneksi, "SELECT
                ID_KRITERIA,ID_SUB_KRITERIA, NAMA_SUB_KRITERIA, BATAS_BAWAH
                FROM sub_kriteria
                WHERE BATAS_BAWAH <= $hargamin AND BATAS_ATAS > $hargamin AND ID_KRITERIA = 'C1'");

            $idkri = "";
            $idsubkri = "";

            while ($row = mysqli_fetch_assoc($query3)) {
                //echo $row['NAMA_SUB_KRITERIA'];
                $idkri = $row['ID_KRITERIA'];
                $idsubkri = $row['ID_SUB_KRITERIA'];
                break;
            }

            mysqli_query($koneksi, "INSERT INTO sub_kriteria_cafe (ID_KRITERIA, ID_SUB_KRITERIA, ID_CAFE) VALUES ('$idkri','$idsubkri','$idcafe')");

            //Simpan ke tabel Sub Kriteria Cafe - Fasilitas
            $q2 = mysqli_query($koneksi, "SELECT
                ID_KRITERIA,ID_SUB_KRITERIA, NAMA_SUB_KRITERIA,NILAI_SUB_KRITERIA
                FROM sub_kriteria
                WHERE ID_SUB_KRITERIA = '$fas' AND ID_KRITERIA = 'C2'");
            $r2 = mysqli_fetch_array($q2);
            $idkri = $r2['ID_KRITERIA'];
            $idsubkri = $r2['ID_SUB_KRITERIA'];

            mysqli_query($koneksi, "INSERT INTO sub_kriteria_cafe (ID_KRITERIA, ID_SUB_KRITERIA, ID_CAFE) VALUES ('$idkri','$idsubkri','$idcafe')");

            //Simpan ke tabel Fasilitas Cafe
            $q3 = mysqli_query($koneksi, "SELECT `ID_FASILITAS` 
            FROM detil_subkri_fas
            WHERE ID_SUB_KRITERIA = '$fas'");

            while ($d3 = mysqli_fetch_array($q3)) {
                $temp = $d3['ID_FASILITAS'];
                mysqli_query($koneksi, "INSERT INTO fasilitas_cafe (ID_CAFE,ID_FASILITAS,STATUS_FAS_CAFE) VALUES ('$idcafe','$temp','$stsfascafe')");
            }

            //Simpan ke tabel Sub Kriteria Cafe - Varian Menu
            //$temp = "";
            $query4 = mysqli_query($koneksi, "SELECT
                ID_KRITERIA,ID_SUB_KRITERIA, NAMA_SUB_KRITERIA, BATAS_BAWAH
                FROM sub_kriteria
                WHERE BATAS_BAWAH <= $jmlmenu AND BATAS_ATAS > $jmlmenu AND ID_KRITERIA = 'C4'");

            $idkri = "";
            $idsubkri = "";

            while ($row = mysqli_fetch_assoc($query4)) {
                //echo $row['NAMA_SUB_KRITERIA'];
                $idkri = $row['ID_KRITERIA'];
                $idsubkri = $row['ID_SUB_KRITERIA'];
                break;
            }

            mysqli_query($koneksi, "INSERT INTO sub_kriteria_cafe (ID_KRITERIA, ID_SUB_KRITERIA, ID_CAFE) VALUES ('$idkri','$idsubkri','$idcafe')");

            //Simpan ke tabel Sub Kriteria Cafe - Pelayanan
            //$temp = "";
            $q5 = mysqli_query($koneksi, "SELECT
                ID_KRITERIA,ID_SUB_KRITERIA, NAMA_SUB_KRITERIA,NILAI_SUB_KRITERIA
                FROM sub_kriteria
                WHERE NILAI_SUB_KRITERIA = $pelayanan AND ID_KRITERIA = 'C5'");
            $r5 = mysqli_fetch_array($q5);
            $idkri = $r5['ID_KRITERIA'];
            $idsubkri = $r5['ID_SUB_KRITERIA'];

            mysqli_query($koneksi, "INSERT INTO sub_kriteria_cafe (ID_KRITERIA, ID_SUB_KRITERIA, ID_CAFE) VALUES ('$idkri','$idsubkri','$idcafe')");

            redirect_to('list-cafe.php?status=sukses-baru');
        } else {
            $errors[] = 'Data gagal disimpan';
        }
    endif;

endif;

$query = mysqli_query($koneksi, "SELECT CAST(MAX(RIGHT(ID_CAFE,1)) AS INTEGER) as idCafe FROM cafe");
$data = mysqli_fetch_array($query);
$idc = $data['idCafe'];
$idc++;

if ($idc < 10) {
    $huruf = "K0";
    $idauto = $huruf . $idc;
} else {
    $query2 = mysqli_query($koneksi, "SELECT CAST(MAX(RIGHT(ID_CAFE,2)) AS INTEGER) as idCafe FROM cafe");
    $data2 = mysqli_fetch_array($query2);
    $idc2 = $data2['idCafe'];
    $idc2++;
    $huruf = "K";
    $idauto = $huruf . $idc2;
}
?>

<?php
$page = "Cafe";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Cafe</h1>

    <a href="list-cafe.php" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
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
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-plus"></i> Tambah Data Cafe</h6>
    </div>

    <form action="tambah-cafe.php" method="post">
        <div class="card-body">
            <div class="row">

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">ID Cafe</label>
                    <input autocomplete="off" type="text" name="idcafe" value="<?php echo $idauto ?>" readonly class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Nama Cafe</label>
                    <input autocomplete="off" type="text" name="namacafe" required class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Alamat</label>
                    <input autocomplete="off" type="text" name="alamat" required class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">No Telp</label>
                    <input autocomplete="off" type="text" name="notelp" required class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Rata-Rata Harga</label><br>
                    <input autocomplete="off" type="text" name="hargamin" id="hargamin" required class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Jumlah Varian Menu</label>
                    <input autocomplete="off" type="text" name="jmlhmenu" id="jmlhmenu" required class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Rating Pelayanan</label>
                    <select name="pelayanan" class="form-control" required>
                        <option value="">--Pilih--</option>

                        <?php $data = mysqli_query($koneksi, "SELECT * FROM `sub_kriteria` WHERE `ID_KRITERIA`= 'C5' ");
                        while ($d = mysqli_fetch_array($data)) {
                        ?>
                            <option value="<?php echo $d["NILAI_SUB_KRITERIA"] ?>"><?php echo $d["NILAI_SUB_KRITERIA"] . " (" . $d["NAMA_SUB_KRITERIA"] . ")" ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Link Cafe</label>
                    <input autocomplete="off" type="url" name="gambar" required class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Deskripsi</label><br>
                    <textarea id="deskripsi" name="deskripsi" rows="13" cols="50"></textarea>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Fasilitas Cafe</label><br>
                    <select class="form-control" required name="fasilitas" id="totalfas">
                        <option value="">--Pilih--</option>
                        <?php $data = mysqli_query($koneksi, "SELECT detil_subkri_fas.ID_SUB_KRITERIA,sub_kriteria.NAMA_SUB_KRITERIA, GROUP_CONCAT(ID_FASILITAS ORDER BY ID_FASILITAS ASC,', ') AS 'DETAIL_FASILITAS',COUNT(detil_subkri_fas.ID_SUB_KRITERIA) AS 'TOTAL_FASILITAS' 
                    FROM `detil_subkri_fas` 
                    JOIN sub_kriteria ON detil_subkri_fas.ID_SUB_KRITERIA = sub_kriteria.ID_SUB_KRITERIA 
                    GROUP BY ID_SUB_KRITERIA;");
                        while ($d = mysqli_fetch_array($data)) {
                        ?>
                            <option value="<?php echo $d["ID_SUB_KRITERIA"] ?>"><?php echo $d["NAMA_SUB_KRITERIA"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Status Cafe</label>
                    <select name="stscafe" class="form-control" required>
                        <option value="">--Pilih--</option>
                        <option value="0">Off</option>
                        <option value="1">On</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Status Fasilitas Cafe</label>
                    <select name="stsfascafe" class="form-control" required>
                        <option value="">--Pilih--</option>
                        <option value="0">Off</option>
                        <option value="1">On</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="card-footer text-right">
            <button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
        </div>
    </form>
</div>


<?php
require_once('template/footer.php');
?>