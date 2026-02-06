<?php require_once('includes/init.php');
$user_role = get_role();
if ($user_role == 'admin') {
	$errors = array();
	$sukses = false;

	$id_kriteria = (isset($_GET['id'])) ? trim($_GET['id']) : '';

	if (isset($_POST['submit'])) {
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

		// Jika lolos validasi lakukan hal di bawah ini
		if (empty($errors)) {

			$update = mysqli_query($koneksi, "UPDATE kriteria 
			SET ID_KRITERIA = '$id_kriteria', ID_JENIS = '$id_jenis', NAMA_KRITERIA = '$nama', STATUS_KRITERIA = '$statuskr' 
			WHERE ID_KRITERIA = '$id_kriteria'");

			if ($update) {
				redirect_to('list-kriteria.php?status=sukses-edit');
			} else {
				$errors[] = 'Data gagal diupdate';
			}
		}
	}

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
		<div class="alert alert-primary">
			<?php foreach ($errors as $error) : ?>
				<?php echo $error; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>


	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-edit"></i> Edit Data Kriteria</h6>
		</div>

		<form action="edit-kriteria.php?id=<?php echo $id_kriteria; ?>" method="post">
			<?php
			if (!$id_kriteria) {
			?>
				<div class="card-body">
					<div class="alert alert-primary">Data tidak ada</div>
				</div>
				<?php
			} else {
				$data = mysqli_query($koneksi, "SELECT kriteria.ID_KRITERIA, jenis_atribut.ID_JENIS, kriteria.NAMA_KRITERIA, kriteria.STATUS_KRITERIA 
				FROM kriteria INNER JOIN jenis_atribut ON jenis_atribut.ID_JENIS = kriteria.ID_JENIS WHERE kriteria.ID_KRITERIA='$id_kriteria'");
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
									<label class="font-weight-bold">ID Kriteria</label>
									<input autocomplete="off" type="text" name="id_kriteria" required value="<?php echo $d['ID_KRITERIA']; ?>" readonly class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Jenis Atribut</label>
									<select name="id_jenis" class="form-control" required>
										<option value="">--Pilih--</option>
										<option value="1" <?php if ($d['ID_JENIS'] == "1") {
																	echo "selected";
																} ?>>Cost</option>
										<option value="2" <?php if ($d['ID_JENIS'] == "2") {
																	echo "selected";
																} ?>>Benefit</option>
									</select>
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Nama Kriteria</label>
									<input autocomplete="off" type="text" name="nama" required value="<?php echo $d['NAMA_KRITERIA']; ?>" class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Status Kriteria</label>
									<select name="statuskr" class="form-control" required>
										<option value="">--Pilih--</option>
										<option value="0" <?php if ($d['STATUS_KRITERIA'] == "0") {
																echo "selected";
															} ?>>Off</option>
										<option value="1" <?php if ($d['STATUS_KRITERIA'] == "1") {
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