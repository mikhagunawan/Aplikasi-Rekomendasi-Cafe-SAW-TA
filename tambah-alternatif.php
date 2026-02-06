<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

$idk = (isset($_SESSION['id'])) ? trim($_SESSION['id']) : '';
date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu sesuai kebutuhan

if (isset($_POST['submit'])) :

    $idk = $_POST['id'];
    $idpilih = $_POST['cafe'];
    $jarak = $_POST['jarak'];


    // Check if the number of selected items is less than 2
    if (count($idpilih) < 2) {
        $errors[] = 'Silakan pilih minimal 2 Data Cafe!';
    }

    // Proceed only if there are no errors
    if (empty($errors)) :
        $date = date('Y-m-d');

        //Pilih Alternatif
        foreach ($idpilih as $idx => $value) {
            $temp = $jarak[$idx] * 1000;
            //$hasil = $nilai_v[$idx];
            $query = mysqli_query($koneksi, "SELECT MAX(ID_ALTERNATIF) as idAlt FROM alternatif");
            $data = mysqli_fetch_array($query);
            $ida = $data['idAlt'];
            $ida++;

            $simpan = mysqli_query($koneksi, "INSERT INTO alternatif (ID_ALTERNATIF,TGL_ALTERNATIF,ID_CAFE,ID_KONSUMEN,JARAK,HASIL,RANGKING) VALUES ($ida,'$date','$value','$idk',$temp,'','')");

            //HAPUS ID_SUB_KRITERIA C3 TB.SUB_KRITERIA_CAFE
            mysqli_query($koneksi, "DELETE FROM sub_kriteria_cafe WHERE ID_KRITERIA = 'C3' AND ID_CAFE = '$idcafe'");
				
            //Simpan ke tabel Sub Kriteria Cafe - Jarak
            $query4 = mysqli_query($koneksi, "SELECT ID_KRITERIA, ID_SUB_KRITERIA, NAMA_SUB_KRITERIA, BATAS_BAWAH 
                FROM sub_kriteria 
                WHERE BATAS_BAWAH <= $temp AND BATAS_ATAS > $temp AND ID_KRITERIA = 'C3'");

            $idkri = "";
            $idsubkri = "";

            while ($row = mysqli_fetch_assoc($query4)) {
                //echo $row['NAMA_SUB_KRITERIA'];
                $idkri = $row['ID_KRITERIA'];
                $idsubkri = $row['ID_SUB_KRITERIA'];
                break;
            }
        }
        mysqli_query($koneksi, "INSERT INTO sub_kriteria_cafe (ID_KRITERIA, ID_SUB_KRITERIA, ID_CAFE) VALUES ('$idkri', '$idsubkri', '$value')");

        if ($simpan) {
            //echo "<script> alert('Data berhasil disimpan!'); </script>";
            redirect_to('bobot-kriteria.php?status=sukses-baru');
        } else {
            $errors[] = 'Data gagal disimpan';
        }
    endif;
endif;

$page = "Alternatif";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users"></i> Data Cafe</h1>

    <a href="list-alternatif.php" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
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

<form action="tambah-alternatif.php" method="post">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Silahkan pilih cafe tujuan yang ingin dijadikan rekomendasi (Maksimal 5 Pilihan)</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr align="center">
                            <th width="5%"><i class="fa fa-check-square"></i></th>
                            <th>Nama Cafe</th>
                            <th>Alamat</th>
                            <th>Jarak Konsumen ke Cafe (Km)</th>
                            <th>Profil Cafe</th>
                            <!-- <th>Hasil</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <input type="text" value="<?php echo $_SESSION['id']; ?>" name="id" required hidden>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM cafe order by CAST(RIGHT(ID_CAFE,2) AS INTEGER) asc");

                        while ($d = mysqli_fetch_array($query)) :
                        ?>
                            <tr align="center">
                                <td><input type="checkbox" name="cafe[]" value="<?php echo $d["ID_CAFE"] ?>" id="checkbox_<?php echo $d["ID_CAFE"] ?>" onchange="toggleJarak('<?php echo $d["ID_CAFE"] ?>')"></td>
                                <td align="left"><label for="cafe" class="font-weight-bold text-black"><?php echo $d["NAMA_CAFE"] ?></label></td>
                                <td align="left"><label for="cafe" class="font-weight-bold text-black"><?php echo $d["ALAMAT"] ?></label></td>
                                <td><input autocomplete="off" class="form-control" type="number" name="jarak[]" min="0" max="100" required id="jarak_<?php echo $d["ID_CAFE"] ?>" disabled></td>
                                <td><a href="<?php echo $d["GAMBAR"] ?>"><i class="fa fa-link"> Lihat Cafe</i></a></td>
                            </tr>
                            <script>
                                function toggleJarak(cafeId) {
                                    // Get the checkbox and the corresponding jarak input element
                                    var checkbox = document.getElementById('checkbox_' + cafeId);
                                    var jarakInput = document.getElementById('jarak_' + cafeId);

                                    // Enable or disable the jarak input based on the checkbox state
                                    if (checkbox.checked) {
                                        jarakInput.disabled = false;
                                    } else {
                                        jarakInput.disabled = true;
                                    }
                                }
                            </script>
                        <?php
                            $no++;
                        endwhile; ?>
                    </tbody>
                </table>
                <script>
                    $('input[type=checkbox]').on('change', function(evt) {
                        if ($('input[id=cafe]:checked').length >= 6) {
                            this.checked = false;
                            alert('Hanya boleh memilih maksimal 5 Cafe !');
                        }
                    });
                </script>
            </div>
        </div>
        <div class="card-footer text-right">
            <button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
        </div>
    </div>
</form>

<!-- Modal Pilih Cafe -->
<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #4e73df; color: white; border-bottom: 2px solid #d1d3e2;">
                <h5 class="modal-title" id="welcomeModalLabel">Menu Pilih Cafe - Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-family: 'Arial', sans-serif; text-align: center; padding: 2rem; background-color: #f8f9fc;">
                <p style="font-size: 16px; color: #6c757d; font-weight: bold;">
                    Silakan pilih <i class="fa fa-check-square" aria-hidden="true"></i> minimal 2 cafe pilihan Anda dan isi jarak perkiraan dari posisi Anda ke cafe yang dipilih.
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
require_once('template/footer.php');
?>