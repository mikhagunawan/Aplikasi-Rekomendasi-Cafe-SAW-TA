<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

if (isset($_POST['submit'])) :
	$id_kriteria = $_POST['id_kriteria'];
	$id_jenis = $_POST['id_jenis'];
	$nama = $_POST['nama'];
	$statuskr = $_POST['statuskr'];

	if (!$id_kriteria) {
		$errors[] = 'ID kriteria tidak boleh kosong';
	}
	// Validasi ID Jenis
	if (!$id_jenis) {
		$errors[] = 'ID Jenis tidak boleh kosong';
	}
	// Validasi Nama Kriteria
	if (!$nama) {
		$errors[] = 'Nama kriteria tidak boleh kosong';
	}


	if (empty($errors)) :

		$simpan = mysqli_query($koneksi, "INSERT INTO kriteria (ID_KRITERIA,ID_JENIS,NAMA_KRITERIA, STATUS_KRITERIA) VALUES ('$id_kriteria','$id_jenis', '$nama', '$statuskr')");
		if ($simpan) {
			redirect_to('list-kriteria.php?status=sukses-baru');
		} else {
			$errors[] = 'Data gagal disimpan';
		}
	endif;

endif;

$query = mysqli_query($koneksi, "SELECT CAST(RIGHT(MAX(ID_KRITERIA),1) AS INTEGER) AS idKriteria FROM KRITERIA;");
$data = mysqli_fetch_array($query);
$IDKriteria = $data['idKriteria'];
$IDKriteria++;

$huruf = "C";
$idauto = $huruf . $IDKriteria;
?>

<?php
$page = "Kriteria";
require_once('template/header.php');
?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Kriteria</h1>

	<a href="list-kriteria.php" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
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
		<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-plus"></i> Tambah Data Kriteria</h6>
	</div>

	<form action="tambah-kriteria.php" method="post">
		<div class="card-body">
			<div class="row">

				<div class="form-group col-md-6">
					<label class="font-weight-bold">ID Kriteria</label>
					<input autocomplete="off" type="text" name="id_kriteria" required value="<?php echo $idauto ?>" readonly class="form-control" />
				</div>

				<div class="form-group col-md-6">
					<label class="font-weight-bold">Kategori Kriteria</label>
					<select name="id_jenis" class="form-control" required>
						<option value="">--Pilih Jenis Atribut--</option>
						<option value="1">Cost</option>
						<option value="2">Benefit</option>
					</select>
				</div>

				<div class="form-group col-md-6">
					<label class="font-weight-bold">Nama Kriteria</label>
					<input autocomplete="off" type="text" name="nama" required class="form-control" />
				</div>

				<div class="form-group col-md-6">
					<label class="font-weight-bold">Status Kriteria</label>
					<select name="statuskr" class="form-control" required>
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