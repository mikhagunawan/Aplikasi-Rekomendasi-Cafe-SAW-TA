<?php require_once('includes/init.php');
$user_role = get_role();
if ($user_role == 'admin') {
	$errors = array();
	$sukses = false;

	$idjenis = (isset($_GET['id'])) ? trim($_GET['id']) : '';

	if (isset($_POST['submit'])) {
		$idjenis = $_POST['idjenis'];
		$namajenis = $_POST['namajenis'];
		$stsjenis = $_POST['stsjenis'];

		if (empty($errors)) {

			$update = mysqli_query($koneksi, "UPDATE jenis_atribut 
			SET ID_JENIS = $idjenis, NAMA_JENIS = '$namajenis', STATUS_JENIS = '$stsjenis' 
			WHERE ID_JENIS = $idjenis");

			if ($update) {
				redirect_to('list-jenis.php?status=sukses-edit');
			} else {
				$errors[] = 'Data gagal diupdate';
			}
		}
	}

	$page = "Jenis Atribut";
	require_once('template/header.php');
?>


	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Jenis Atribut</h1>

		<a href="list-jenis.php" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
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
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-edit"></i> Edit Data Jenis Atribut</h6>
		</div>

		<form action="edit-jenis.php?id=<?php echo $idjenis; ?>" method="post">
			<?php
			$data = mysqli_query($koneksi, "SELECT * from jenis_atribut WHERE ID_JENIS = '$idjenis'");
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
						<div class="col">
							<div class="form-group">
								<label class="font-weight-bold">ID Jenis</label>
								<input autocomplete="off" type="text" name="idjenis" value="<?php echo $d['ID_JENIS']; ?>" readonly class="form-control" />
							</div>

							<div class="form-group">
								<label class="font-weight-bold">Jenis Atribut</label>
								<select name="namajenis" class="form-control" required>
									<option value="">--Pilih--</option>
									<option value="Cost" <?php if ($d['NAMA_JENIS'] == "Cost") {
																echo "selected";
															} ?>>Cost</option>
									<option value="Benefit" <?php if ($d['NAMA_JENIS'] == "Benefit") {
																echo "selected";
															} ?>>Benefit</option>
								</select>
							</div>

							<div class="form-group">
								<label class="font-weight-bold">Status Jenis Atribut</label>
								<select name="stsjenis" class="form-control" required>
									<option value="">--Pilih--</option>
									<option value="0" <?php if ($d['STATUS_JENIS'] == "0") {
															echo "selected";
														} ?>>Off</option>
									<option value="1" <?php if ($d['STATUS_JENIS'] == "1") {
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
			?>
		</form>
	</div>

<?php
	require_once('template/footer.php');
} else {
	header('Location: login.php');
}
?>