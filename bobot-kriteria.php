<?php
require_once('includes/init.php');
// cek_login2($role = array(1));
cek_login($role = array(1));
$page = "Bobot Kriteria";

require_once('template/header.php');

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Entry Bobot Kriteria</h1>
</div>

<?php
$errors = array();
$sukses = false;

$idk = (isset($_SESSION['id'])) ? trim($_SESSION['id']) : '';
// Check if the bobot_kriteria table already has data for the current user (ID_KONSUMEN)
// $cek_bobot_kriteria = mysqli_query($koneksi, "SELECT * FROM bobot_kriteria WHERE ID_KONSUMEN = '$idk'");
// $data_bobot = mysqli_fetch_array($cek_bobot_kriteria);

// If there is data, prevent showing the modal
//$showModal = !$data_bobot; // If there's no data, set showModal to true, otherwise false

$kriteria = array();
$q1 = mysqli_query(
	$koneksi,
	"SELECT * 
		 FROM kriteria
		 INNER JOIN jenis_atribut ON kriteria.ID_JENIS = jenis_atribut.ID_JENIS 
		 INNER JOIN bobot_kriteria ON kriteria.ID_KRITERIA = bobot_kriteria.ID_KRITERIA
		 WHERE STATUS_KRITERIA = 1  
		 ORDER BY kriteria.ID_KRITERIA ASC"
);

while ($krit = mysqli_fetch_array($q1)) {
	$kriteria[$krit['ID_KRITERIA']]['ID_KRITERIA'] = $krit['ID_KRITERIA'];
	$kriteria[$krit['ID_KRITERIA']]['NAMA_KRITERIA'] = $krit['NAMA_KRITERIA'];
	$kriteria[$krit['ID_KRITERIA']]['NAMA_JENIS'] = $krit['NAMA_JENIS'];
	$kriteria[$krit['ID_KRITERIA']]['BOBOT'] = $krit['BOBOT'];
}

$alternatif = array();
$q2 = mysqli_query($koneksi, "SELECT alternatif.ID_ALTERNATIF,alternatif.TGL_ALTERNATIF,alternatif.ID_CAFE,cafe.NAMA_CAFE, alternatif.HASIL,ROW_NUMBER() OVER(ORDER BY alternatif.HASIL DESC) AS RANGKING
	FROM alternatif 
	INNER JOIN cafe ON alternatif.ID_CAFE = cafe.ID_CAFE
    INNER JOIN konsumen ON alternatif.ID_KONSUMEN = konsumen.ID_KONSUMEN
    WHERE konsumen.ID_KONSUMEN = '$idk' AND alternatif.TGL_ALTERNATIF = CURDATE()
	ORDER BY alternatif.HASIL DESC;");
while ($alt = mysqli_fetch_array($q2)) {
	$alternatif[$alt['ID_CAFE']]['ID_ALTERNATIF'] = $alt['ID_ALTERNATIF'];
	$alternatif[$alt['ID_CAFE']]['TGL_ALTERNATIF'] = $alt['TGL_ALTERNATIF'];
	$alternatif[$alt['ID_CAFE']]['ID_CAFE'] = $alt['ID_CAFE'];
	$alternatif[$alt['ID_CAFE']]['NAMA_CAFE'] = $alt['NAMA_CAFE'];
	$alternatif[$alt['ID_CAFE']]['HASIL'] = $alt['HASIL'];
	$alternatif[$alt['ID_CAFE']]['RANGKING'] = $alt['RANGKING'];
}

if (isset($_POST['submit'])) :
	$idkri = $_POST['idkri'];
	$idk = $_POST['id'];
	$bbt = $_POST['bobot'];

	if (!$idkri) {
		$errors[] = 'ID Kriteria tidak boleh kosong';
	}

	if (!$idk) {
		$errors[] = 'ID Konsumen tidak boleh kosong';
	}

	$cek_konsumen = mysqli_query($koneksi, "SELECT * FROM bobot_kriteria where ID_KONSUMEN = '$idk'");
	$jumlah = mysqli_num_rows($cek_konsumen);

	// Insert Bobot
	if ($jumlah < 1) {
		$temp = "";
		foreach ($idkri as $kri => $value) {
			$temp = $value;
			$temp2 = floatval($bbt[$kri]) / 100;

			mysqli_query($koneksi, "INSERT INTO bobot_kriteria (ID_KRITERIA, ID_KONSUMEN, BOBOT) VALUES ('$temp','$idk','$temp2')");
		}

	} else {
		// Update Bobot
		$temp = "";
		foreach ($idkri as $kri => $value) {
			$temp = $value;
			$temp2 = floatval($bbt[$kri]) / 100;
			mysqli_query($koneksi, "UPDATE bobot_kriteria SET BOBOT = $temp2 WHERE ID_KRITERIA = '$temp' AND ID_KONSUMEN = '$idk'");
		}

		// Setelah update, update alternatif
		updateHasil($kriteria, $alternatif, $idk, $koneksi);
		updateRanking($koneksi);
	}
endif;

$status = isset($_GET['status']) ? $_GET['status'] : '';
$msg = '';
switch ($status):
	case 'sukses-baru':
		$msg = 'Data berhasil disimpan';
		break;
	case 'sukses-hapus':
		$msg = 'Data berhasil dihapus';
		break;
	case 'sukses-edit':
		$msg = 'Data berhasil diupdate';
		break;
endswitch;

if ($msg) :
	echo '<div class="alert alert-info">' . $msg . '</div>';
endif;
?>

<div class="card shadow mb-4">
	<!-- /.card-header -->
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Daftar Data Kriteria</h6>
	</div>

	<div class="card-body">
		<?php echo '<div class="alert alert-info"> <b>Note : </b>
		Total Bobot harus sama dengan 100%. Jika kurang/lebih dari 100%, total bobot berwarna <b style="color: red;">MERAH</b>. </div>'; ?>

		<form action="bobot-kriteria.php" method="post">
			<div class="table-responsive">
				<table class="table table-bordered font-weight-bold" width="100%" cellspacing="0">
					<thead class="bg-primary text-white">
						<tr align="center">
							<th>No</th>
							<!-- <th>ID</th> -->
							<th width="70%">Nama Kriteria</th>
							<th width="20%">Nilai Bobot (%)</th>
						</tr>
					</thead>
					<tbody>
						<!-- Untuk Halaman Bobot Kriteria hanya tinggal ubah di session user saja, dan pastikan role login -->
						<input type="text" value="<?php echo $_SESSION['id']; ?>" name="id" hidden>
						<?php
						$no = 1;
						$query = mysqli_query($koneksi, "SELECT * FROM kriteria WHERE STATUS_KRITERIA = 1");
						while ($data = mysqli_fetch_array($query)) :
						?>
							<tr align="center">
								<td><?php echo $no; ?></td>
								<input class="form-control col-md-5" type="text" value="<?php echo $data['ID_KRITERIA']; ?>" name="idkri[]" hidden>
								<td align="left"><?php echo $data['NAMA_KRITERIA']; ?></td>
								<td>
									<input style=" text-align: center;" type="number" min="0" max="100" name="bobot[]" onchange="sum()" class="bbtkri form-control">
								</td>
							</tr>
						<?php
							$no++;
						endwhile; ?>
						<tr align="center">
							<td colspan="2" class="font-weight-bold" align="right">Total Bobot (%)</td>
							<td><input class="form-control" style="text-align: center;" type="number" min="0" max="100" name="totalbobot" id="totalbbt" readonly></td>
						</tr>
					</tbody>
				</table>
				<div class="card-footer text-right" id="btngroup" style="display: none;">
					<button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
					<button type="reset" onclick="window.location.reload();" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
				</div>

				<script>
					function sum() {
						var inputs = document.getElementsByClassName('bbtkri'); // Get all elements with class 'bbtkri'
						var total = 0;
						// Iterate through each input element
						for (var i = 0; i < inputs.length; i++) {
							var value = parseFloat(inputs[i].value) || 0; // Parse input value to float, default to 0 if NaN
							total += value; // Add value to total
							// Update the totalbobot input with the calculated total
							document.getElementById('totalbbt').value = total;
						}
						// Ensure total does not exceed 100
						if (document.getElementById('totalbbt').value != 100) {
							document.getElementById('totalbbt').style.color = 'red';
							document.getElementById('btngroup').style.display = 'none';
							//alert('Total Bobot harus 100%. Sesuaikan bobot kembali!.');
							// You might want to reset or adjust the inputs here if needed
							//total = 100; // Or any other handling you prefer
						} else {
							document.getElementById('totalbbt').style.color = 'black';
							document.getElementById('btngroup').style.display = 'block';
						}
					}
				</script>
			</div>
		</form>
	</div>
</div>

<!-- Modal Bobot Kriteria -->

<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4e73df; color: white; border-bottom: 2px solid #d1d3e2;">
				<h5 class="modal-title" id="welcomeModalLabel">Menu Entry Bobot</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="font-family: 'Arial', sans-serif; text-align: center; padding: 2rem; background-color: #f8f9fc;">
				<p style="font-size: 16px; color: #6c757d; font-weight: bold;">
					Jika sudah melakukan pemilihan cafe, silahkan isi nilai bobot kriteria yang telah ditentukan berdasarkan prioritas kepentingan anda.<br>
					Lakukan pengisian ulang nilai bobot kembali, kemudian Buka Menu Histori Rekomendasi untuk dapat melihat hasil.
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