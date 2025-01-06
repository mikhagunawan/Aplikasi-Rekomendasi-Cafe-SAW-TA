<?php require_once('includes/init.php');
$user_role = get_role();
if ($user_role == 'admin') {
	$errors = array();
	$sukses = false;

	$idfas = (isset($_GET['id'])) ? trim($_GET['id']) : '';

	if (isset($_POST['submit'])) {
		$idfas = $_POST['idfas'];
		$namafas = $_POST['namafas'];
		$statusfas = $_POST['statusfas'];

		if (!$idfas) {
			$errors[] = 'ID Fasilitas tidak boleh kosong';
		}

		// Validasi Nama Kriteria
		if (!$namafas) {
			$errors[] = 'Nama Fasilitas tidak boleh kosong';
		}

		// Jika lolos validasi lakukan hal di bawah ini
		if (empty($errors)) {

			$update = mysqli_query($koneksi, "UPDATE fasilitas 
			SET ID_FASILITAS = '$idfas', NAMA_FASILITAS = '$namafas', STATUS_FASILITAS = '$statusfas' 
			WHERE ID_FASILITAS = '$idfas'");

			if ($update) {
				redirect_to('list-fasilitas.php?status=sukses-edit');
			} else {
				$errors[] = 'Data gagal diupdate';
			}
		}
	}

	$page = "Fasilitas";
	require_once('template/header.php');
?>


	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Fasilitas Cafe</h1>

		<a href="list-fasilitas.php" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
			<span class="text">Kembali</span>
		</a>
	</div>

	<?php if (!empty($errors)) : ?>
		<div class="alert alert-primary">
			<?php foreach ($errors as $error) : ?>
				<?php echo $error; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>


	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-edit"></i> Edit Data Fasilitas Cafe</h6>
		</div>

		<form action="edit-fasilitas.php?id=<?php echo $idfas; ?>" method="post">
			<?php
			if (!$idfas) {
			?>
				<div class="card-body">
					<div class="alert alert-primary">Data tidak ada</div>
				</div>
				<?php
			} else {
				$data = mysqli_query($koneksi, "SELECT * FROM fasilitas WHERE ID_FASILITAS ='$idfas'");
				$cek = mysqli_num_rows($data);
				if ($cek <= 0) {
				?>
					<div class="card-body">
						<div class="alert alert-primary">Data tidak ada</div>
					</div>
					<?php
				} else {
					while ($d = mysqli_fetch_array($data)) {
					?>
						<div class="card-body">
							<div class="row">
								<div class="form-group col-md-6">
									<label class="font-weight-bold">ID Fasilitas</label>
									<input autocomplete="off" type="text" name="idfas" required value="<?php echo $d['ID_FASILITAS']; ?>" readonly class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Nama Fasilitas</label>
									<input autocomplete="off" type="text" name="namafas" required value="<?php echo $d['NAMA_FASILITAS']; ?>" class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Status Fasilitas</label>
									<select name="statusfas" class="form-control" required>
										<option value="">--Pilih--</option>
										<option value="0" <?php if ($d['STATUS_FASILITAS'] == "0") {
																echo "selected";
															} ?>>Off</option>
										<option value="1" <?php if ($d['STATUS_FASILITAS'] == "1") {
																echo "selected";
															} ?>>On</option>
									</select>
								</div>
							</div>
						</div>
						<div class="card-footer text-right">
							<button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
							<button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
						</div>
			<?php
					}
				}
			}
			?>
		</form>
	</div>

<?php
	require_once('template/footer.php');
} else {
	header('Location: login.php');
}
?>