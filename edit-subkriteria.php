<<<<<<< HEAD
<?php require_once('includes/init.php');
$user_role = get_role();
if ($user_role == 'admin') {
	$errors = array();
	$sukses = false;

	$id_subkri = (isset($_GET['id'])) ? trim($_GET['id']) : '';

	if (isset($_POST['submit'])) {
		$id_subkri = $_POST['idsubkri'];
		$id_kriteria = $_POST['idkriteria'];
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
			$errors[] = 'Indikator Fasilitas tidak boleh kosong';
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

		// Update Indikator Umum
		if (empty($errors) && $id_kriteria != "C2") {

			$update = mysqli_query($koneksi, "UPDATE sub_kriteria 
			SET ID_KRITERIA = '$id_kriteria',
			ID_SUB_KRITERIA = '$id_subkri',
			NAMA_SUB_KRITERIA = '$nama_subkri',
			INDIKATOR = '$indikator',
			NILAI_SUB_KRITERIA = '$nilai',
			STATUS_SUB_KRITERIA = '$stssubkri',
			BATAS_ATAS = '$btsatas',
			BATAS_BAWAH = '$btsbwh' 
			WHERE ID_KRITERIA = '$id_kriteria' AND ID_SUB_KRITERIA = '$id_subkri';");

			if ($update) {
				redirect_to('list-sub-kriteria.php?status=sukses-edit');
			} else {
				$errors[] = 'Data gagal diupdate';
			}
		}
		// Update Indikator Fasilitas
		if (empty($errors) && $id_kriteria == "C2") {
			$updateindikator = mysqli_query($koneksi, "UPDATE sub_kriteria 
			SET ID_KRITERIA = '$id_kriteria',
			ID_SUB_KRITERIA = '$id_subkri',
			NAMA_SUB_KRITERIA = '$nama_subkri',
			INDIKATOR = '$indikatorfas',
			NILAI_SUB_KRITERIA = '$nilai',
			STATUS_SUB_KRITERIA = '$stssubkri',
			BATAS_ATAS = '$btsatas',
			BATAS_BAWAH = '$btsbwh' 
			WHERE ID_KRITERIA = '$id_kriteria' AND ID_SUB_KRITERIA = '$id_subkri';");

			if ($updateindikator) {
				mysqli_query($koneksi,"DELETE FROM detil_subkri_fas WHERE ID_KRITERIA = 'C2' && ID_SUB_KRITERIA = '$id_subkri'");
				$temp = "";
				$fas = $_POST['indikatorfas'];
				foreach ($fas as $fas => $value) {
					$temp = $value;
					mysqli_query($koneksi, "INSERT INTO detil_subkri_fas (ID_KRITERIA,ID_SUB_KRITERIA,ID_FASILITAS) VALUES ('$id_kriteria','$id_subkri','$temp')");
				}
				redirect_to('list-sub-kriteria.php?status=sukses-edit');
			} else {
				$errors[] = 'Data gagal diupdate';
			}
		}
	}

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
		<div class="alert alert-primary">
			<?php foreach ($errors as $error) : ?>
				<?php echo $error; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>


	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-edit"></i> Edit Data Sub Kriteria</h6>
		</div>

		<form action="edit-subkriteria.php?id=<?php echo $id_subkri; ?>" method="post">
			<?php
			if (!$id_subkri) {
			?>
				<div class="card-body">
					<div class="alert alert-primary">Data tidak ada</div>
				</div>
				<?php
			} else {
				$data = mysqli_query($koneksi, "SELECT * FROM sub_kriteria WHERE ID_SUB_KRITERIA = '$id_subkri'");
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
									<input autocomplete="off" type="text" name="idkriteria" value="<?php echo $d["ID_KRITERIA"] ?>" readonly class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">ID Sub Kriteria</label>
									<input autocomplete="off" type="text" name="idsubkri" value="<?php echo $d["ID_SUB_KRITERIA"] ?>" readonly class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Nama Sub Kriteria</label>
									<input autocomplete="off" type="text" name="namasubkri" value="<?php echo $d["NAMA_SUB_KRITERIA"] ?>"" class=" form-control" />
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
								<?php
								// Query untuk mengambil data fasilitas
								$data2 = mysqli_query($koneksi, "SELECT * FROM fasilitas ORDER BY CAST(ID_FASILITAS AS INTEGER) ASC");

								// Query untuk mengambil ID fasilitas yang sudah dipilih dari subkriteria
								$data = mysqli_query($koneksi, "SELECT INDIKATOR FROM sub_kriteria WHERE ID_KRITERIA = 'C2' && ID_SUB_KRITERIA = '$id_subkri'");

								// Mengambil data INDIKATOR dan mengubahnya menjadi array
								$indikatorArray = [];
								while ($row = mysqli_fetch_assoc($data)) {

									// Pisahkan INDIKATOR berdasarkan koma dan tambahkan ke array
									$indikatorArray = array_merge($indikatorArray, explode(', ', $row['INDIKATOR']));
								}

								?>
								<div id="inputContainer" class="form-group col-md-6" style="display: none;">
									<label class="font-weight-bold"> Pilih Fasilitas</label><br>
									<?php $data2 = mysqli_query($koneksi, "SELECT * FROM fasilitas order by CAST(RIGHT(ID_FASILITAS,2) as INTEGER) asc");
									while ($d2 = mysqli_fetch_array($data2)) {
										// Memeriksa apakah fasilitas sudah terpilih sebelumnya
										$isChecked = in_array($d2["ID_FASILITAS"], $indikatorArray) ? 'checked' : '';
									?> <input type="checkbox" name="indikatorfas[]" value="<?php echo $d2["ID_FASILITAS"] ?>" <?php echo $isChecked; ?>>
										<label for="indikatorfas"><?php echo $d2["NAMA_FASILITAS"] ?></label><br>
									<?php
									}
									?>
								</div>

								<div id="batas" class="form-group col-md-6">
									<label class="font-weight-bold">Indikator</label>
									<input style="margin-bottom: 15px;" autocomplete="off" type="text" class="form-control" name="indikator" value="<?php echo $d["INDIKATOR"] ?>">
									<label class=" font-weight-bold">Batas Atas</label>
									<input style="margin-bottom: 15px;" autocomplete="off" type="text" class="form-control" name="btsatas" value="<?php echo $d["BATAS_ATAS"] ?>">
									<label class=" font-weight-bold">Batas Bawah</label>
									<input autocomplete="off" type="text" class="form-control" name="btsbwh" value="<?php echo $d["BATAS_BAWAH"] ?>"">
								</div>

								<div class=" form-group col-md-6">
									<label class="font-weight-bold">Nilai Sub Kriteria</label>
									<input autocomplete="off" type="number" min="1" name="nilai" class="form-control" value="<?php echo $d["NILAI_SUB_KRITERIA"] ?>"">
								</div>

								<div class=" form-group col-md-6">
									<label class="font-weight-bold">Status Sub Kriteria</label>
									<select name="statussubkri" class="form-control" required>
										<option value="">--Pilih--</option>
										<option value="0" <?php if ($d['STATUS_SUB_KRITERIA'] == "0") {
																echo "selected";
															} ?>>Off</option>
										<option value="1" <?php if ($d['STATUS_SUB_KRITERIA'] == "1") {
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
=======
<?php require_once('includes/init.php');
$user_role = get_role();
if ($user_role == 'admin') {
	$errors = array();
	$sukses = false;

	$id_subkri = (isset($_GET['id'])) ? trim($_GET['id']) : '';

	if (isset($_POST['submit'])) {
		$id_subkri = $_POST['idsubkri'];
		$id_kriteria = $_POST['idkriteria'];
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
			$errors[] = 'Indikator Fasilitas tidak boleh kosong';
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

		// Update Indikator Umum
		if (empty($errors) && $id_kriteria != "C2") {

			$update = mysqli_query($koneksi, "UPDATE sub_kriteria 
			SET ID_KRITERIA = '$id_kriteria',
			ID_SUB_KRITERIA = '$id_subkri',
			NAMA_SUB_KRITERIA = '$nama_subkri',
			INDIKATOR = '$indikator',
			NILAI_SUB_KRITERIA = '$nilai',
			STATUS_SUB_KRITERIA = '$stssubkri',
			BATAS_ATAS = '$btsatas',
			BATAS_BAWAH = '$btsbwh' 
			WHERE ID_KRITERIA = '$id_kriteria' AND ID_SUB_KRITERIA = '$id_subkri';");

			if ($update) {
				redirect_to('list-sub-kriteria.php?status=sukses-edit');
			} else {
				$errors[] = 'Data gagal diupdate';
			}
		}
		// Update Indikator Fasilitas
		if (empty($errors) && $id_kriteria == "C2") {
			$updateindikator = mysqli_query($koneksi, "UPDATE sub_kriteria 
			SET ID_KRITERIA = '$id_kriteria',
			ID_SUB_KRITERIA = '$id_subkri',
			NAMA_SUB_KRITERIA = '$nama_subkri',
			INDIKATOR = '$indikatorfas',
			NILAI_SUB_KRITERIA = '$nilai',
			STATUS_SUB_KRITERIA = '$stssubkri',
			BATAS_ATAS = '$btsatas',
			BATAS_BAWAH = '$btsbwh' 
			WHERE ID_KRITERIA = '$id_kriteria' AND ID_SUB_KRITERIA = '$id_subkri';");

			if ($updateindikator) {
				mysqli_query($koneksi,"DELETE FROM detil_subkri_fas WHERE ID_KRITERIA = 'C2' && ID_SUB_KRITERIA = '$id_subkri'");
				$temp = "";
				$fas = $_POST['indikatorfas'];
				foreach ($fas as $fas => $value) {
					$temp = $value;
					mysqli_query($koneksi, "INSERT INTO detil_subkri_fas (ID_KRITERIA,ID_SUB_KRITERIA,ID_FASILITAS) VALUES ('$id_kriteria','$id_subkri','$temp')");
				}
				redirect_to('list-sub-kriteria.php?status=sukses-edit');
			} else {
				$errors[] = 'Data gagal diupdate';
			}
		}
	}

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
		<div class="alert alert-primary">
			<?php foreach ($errors as $error) : ?>
				<?php echo $error; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>


	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-edit"></i> Edit Data Sub Kriteria</h6>
		</div>

		<form action="edit-subkriteria.php?id=<?php echo $id_subkri; ?>" method="post">
			<?php
			if (!$id_subkri) {
			?>
				<div class="card-body">
					<div class="alert alert-primary">Data tidak ada</div>
				</div>
				<?php
			} else {
				$data = mysqli_query($koneksi, "SELECT * FROM sub_kriteria WHERE ID_SUB_KRITERIA = '$id_subkri'");
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
									<input autocomplete="off" type="text" name="idkriteria" value="<?php echo $d["ID_KRITERIA"] ?>" readonly class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">ID Sub Kriteria</label>
									<input autocomplete="off" type="text" name="idsubkri" value="<?php echo $d["ID_SUB_KRITERIA"] ?>" readonly class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Nama Sub Kriteria</label>
									<input autocomplete="off" type="text" name="namasubkri" value="<?php echo $d["NAMA_SUB_KRITERIA"] ?>"" class=" form-control" />
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
								<?php
								// Query untuk mengambil data fasilitas
								$data2 = mysqli_query($koneksi, "SELECT * FROM fasilitas ORDER BY CAST(ID_FASILITAS AS INTEGER) ASC");

								// Query untuk mengambil ID fasilitas yang sudah dipilih dari subkriteria
								$data = mysqli_query($koneksi, "SELECT INDIKATOR FROM sub_kriteria WHERE ID_KRITERIA = 'C2' && ID_SUB_KRITERIA = '$id_subkri'");

								// Mengambil data INDIKATOR dan mengubahnya menjadi array
								$indikatorArray = [];
								while ($row = mysqli_fetch_assoc($data)) {

									// Pisahkan INDIKATOR berdasarkan koma dan tambahkan ke array
									$indikatorArray = array_merge($indikatorArray, explode(', ', $row['INDIKATOR']));
								}

								?>
								<div id="inputContainer" class="form-group col-md-6" style="display: none;">
									<label class="font-weight-bold"> Pilih Fasilitas</label><br>
									<?php $data2 = mysqli_query($koneksi, "SELECT * FROM fasilitas order by CAST(RIGHT(ID_FASILITAS,2) as INTEGER) asc");
									while ($d2 = mysqli_fetch_array($data2)) {
										// Memeriksa apakah fasilitas sudah terpilih sebelumnya
										$isChecked = in_array($d2["ID_FASILITAS"], $indikatorArray) ? 'checked' : '';
									?> <input type="checkbox" name="indikatorfas[]" value="<?php echo $d2["ID_FASILITAS"] ?>" <?php echo $isChecked; ?>>
										<label for="indikatorfas"><?php echo $d2["NAMA_FASILITAS"] ?></label><br>
									<?php
									}
									?>
								</div>

								<div id="batas" class="form-group col-md-6">
									<label class="font-weight-bold">Indikator</label>
									<input style="margin-bottom: 15px;" autocomplete="off" type="text" class="form-control" name="indikator" value="<?php echo $d["INDIKATOR"] ?>">
									<label class=" font-weight-bold">Batas Atas</label>
									<input style="margin-bottom: 15px;" autocomplete="off" type="text" class="form-control" name="btsatas" value="<?php echo $d["BATAS_ATAS"] ?>">
									<label class=" font-weight-bold">Batas Bawah</label>
									<input autocomplete="off" type="text" class="form-control" name="btsbwh" value="<?php echo $d["BATAS_BAWAH"] ?>"">
								</div>

								<div class=" form-group col-md-6">
									<label class="font-weight-bold">Nilai Sub Kriteria</label>
									<input autocomplete="off" type="number" min="1" name="nilai" class="form-control" value="<?php echo $d["NILAI_SUB_KRITERIA"] ?>"">
								</div>

								<div class=" form-group col-md-6">
									<label class="font-weight-bold">Status Sub Kriteria</label>
									<select name="statussubkri" class="form-control" required>
										<option value="">--Pilih--</option>
										<option value="0" <?php if ($d['STATUS_SUB_KRITERIA'] == "0") {
																echo "selected";
															} ?>>Off</option>
										<option value="1" <?php if ($d['STATUS_SUB_KRITERIA'] == "1") {
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
>>>>>>> 576b185375d749f33752cc2e77735153d7fe4856
?>