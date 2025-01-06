<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

if (isset($_POST['submit'])) :
	$idfas = $_POST['idfas'];
	$namafas = $_POST['namafas'];
	$statusfas = $_POST['statusfas'];

	if (!$idfas) {
		$errors[] = 'ID Fasilitas tidak boleh kosong';
	}

	// Validasi Nama Fasilitas
	if (!$namafas) {
		$errors[] = 'Nama Fasilitas tidak boleh kosong';
	}


	if (empty($errors)) :

		$simpan = mysqli_query($koneksi, "INSERT INTO fasilitas (ID_FASILITAS, NAMA_FASILITAS, STATUS_FASILITAS) VALUES ('$idfas', '$namafas', '$statusfas')");
		if ($simpan) {
			redirect_to('list-fasilitas.php?status=sukses-baru');
		} else {
			$errors[] = 'Data gagal disimpan';
		}
	endif;

endif;

//ID Otomatis
$query = mysqli_query($koneksi, "SELECT CAST(MAX(RIGHT(ID_FASILITAS,1)) AS INTEGER) as IDFAS FROM FASILITAS");
$data = mysqli_fetch_array($query);
$idfas = $data['IDFAS'];
$idfas++;
if ($idfas < 10) {
	$huruf = "F0";
	$idauto = $huruf . $idfas;
} else {
	$query2 = mysqli_query($koneksi, "SELECT CAST(MAX(RIGHT(ID_FASILITAS,2)) AS INTEGER) as IDFAS FROM FASILITAS");
	$data2 = mysqli_fetch_array($query2);
	$idfas2 = $data2['IDFAS'];
	$idfas2++;
	$huruf = "F";
	$idauto = $huruf . $idfas2;
}

?>

<?php
$page = "Fasilitas";
require_once('template/header.php');
?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Fasilitas</h1>

	<a href="list-fasilitas.php" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
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
		<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-plus"></i> Tambah Data Fasilitas</h6>
	</div>

	<form action="tambah-fasilitas.php" method="post">
		<div class="card-body">
			<div class="row">
				<div class="form-group col-md-6">
					<label class="font-weight-bold">ID Fasilitas</label>
					<input autocomplete="off" type="text" name="idfas" required value="<?php echo $idauto ?>" readonly class="form-control" />
				</div>

				<div class="form-group col-md-6">
					<label class="font-weight-bold">Nama Fasilitas</label>
					<input autocomplete="off" type="text" name="namafas" required class="form-control" />
				</div>

				<div class="form-group col-md-6">
					<label class="font-weight-bold">Status Fasilitas</label>
					<select name="statusfas" class="form-control" required>
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