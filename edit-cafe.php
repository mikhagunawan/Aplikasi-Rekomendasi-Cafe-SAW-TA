<?php require_once('includes/init.php');
$user_role = get_role();
if ($user_role == 'admin') {
	$errors = array();
	$sukses = false;

	$idcafe = (isset($_GET['id'])) ? trim($_GET['id']) : '';

	if (isset($_POST['submit'])) {
		$idcafe = $_POST['idcafe'];
		$namacafe = $_POST['namacafe'];
		$alamat = $_POST['alamatcafe'];
		$notelp = $_POST['notelp'];
		$hargamin = $_POST['hargamin'];
		$fas = $_POST['fasilitas'];
		$jmlmenu = $_POST['jmlhmenu'];
		$pelayanan = $_POST['pelayanan'];
		$gambar = $_POST['gambar'];
		$deskripsi = $_POST['deskripsi'];
		$stscafe = $_POST['stscafe'];
		//$stsfascafe = $_POST['stsfascafe'];
		
		//Cek Harga Minimal
		if ($hargamin < 500) {
			$errors[] = 'Ulangi input harga minimal!';
		}
		// Jika lolos validasi lakukan hal di bawah ini
		if (empty($errors)) {

			$update = mysqli_query($koneksi, "UPDATE cafe 
			SET ID_CAFE = '$idcafe', NAMA_CAFE = '$namacafe', ALAMAT = '$alamat', NOTELP = '$notelp', HARGA_MIN = '$hargamin', JUMLAH_MENU = '$jmlmenu', PELAYANAN = '$pelayanan', GAMBAR = '$gambar', DESKRIPSI = '$deskripsi', STATUS_CAFE = '$stscafe' 
			WHERE ID_CAFE = '$idcafe'");

			if ($update) {
				//Delete Rows yang sudah ada di tabel Sub Kriteria Cafe
				mysqli_query($koneksi, "DELETE FROM sub_kriteria_cafe WHERE ID_KRITERIA = 'C1' AND ID_CAFE = '$idcafe'");
				mysqli_query($koneksi, "DELETE FROM sub_kriteria_cafe WHERE ID_KRITERIA = 'C2' AND ID_CAFE = '$idcafe'");
				mysqli_query($koneksi, "DELETE FROM sub_kriteria_cafe WHERE ID_KRITERIA = 'C4' AND ID_CAFE = '$idcafe'");
				mysqli_query($koneksi, "DELETE FROM sub_kriteria_cafe WHERE ID_KRITERIA = 'C5' AND ID_CAFE = '$idcafe'");
				//Delete Rows yang sudah ada di tabel Fasilitas Cafe
				mysqli_query($koneksi, "DELETE FROM fasilitas_cafe WHERE ID_CAFE = '$idcafe'");

				//Update Baru ke tabel Sub Kriteria Cafe - Harga
				$query3 = mysqli_query($koneksi, "SELECT
                ID_KRITERIA,ID_SUB_KRITERIA, NAMA_SUB_KRITERIA, BATAS_BAWAH
                FROM sub_kriteria
                WHERE BATAS_BAWAH <= $hargamin AND BATAS_ATAS > $hargamin AND ID_KRITERIA = 'C1'");

				$idkri = "";
				$idsubkri = "";

				while ($row = mysqli_fetch_assoc($query3)) {
					$idkri = $row['ID_KRITERIA'];
					$idsubkri = $row['ID_SUB_KRITERIA'];
					break;
				}
				mysqli_query($koneksi, "INSERT INTO sub_kriteria_cafe (ID_KRITERIA, ID_SUB_KRITERIA, ID_CAFE) VALUES ('$idkri','$idsubkri','$idcafe')");

				//Update Baru ke tabel Sub Kriteria Cafe - Fasilitas
				$q2 = mysqli_query($koneksi, "SELECT
                ID_KRITERIA,ID_SUB_KRITERIA, NAMA_SUB_KRITERIA,NILAI_SUB_KRITERIA
                FROM sub_kriteria
                WHERE ID_SUB_KRITERIA = '$fas' AND ID_KRITERIA = 'C2'");
				$r2 = mysqli_fetch_array($q2);
				$idkri = $r2['ID_KRITERIA'];
				$idsubkri = $r2['ID_SUB_KRITERIA'];

				mysqli_query($koneksi, "INSERT INTO sub_kriteria_cafe (ID_KRITERIA, ID_SUB_KRITERIA, ID_CAFE) VALUES ('$idkri','$idsubkri','$idcafe')");

				//Update Baru ke tabel Fasilitas Cafe
				$q3 = mysqli_query($koneksi, "SELECT `ID_FASILITAS` 
            FROM detil_subkri_fas
            WHERE ID_SUB_KRITERIA = '$fas'");

				while ($d3 = mysqli_fetch_array($q3)) {
					$temp = $d3['ID_FASILITAS'];
					mysqli_query($koneksi, "INSERT INTO fasilitas_cafe (ID_CAFE,ID_FASILITAS,STATUS_FAS_CAFE) VALUES ('$idcafe','$temp','$stsfascafe')");
				}

				//Update Status Fasilitas Cafe
				mysqli_query($koneksi, "UPDATE fasilitas_cafe SET STATUS_FAS_CAFE = 1 WHERE ID_CAFE = '$idcafe'");

				//Update Baru ke tabel Sub Kriteria Cafe - Varian Menu
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

				//Update Baru ke tabel Sub Kriteria Cafe - Pelayanan
				//$temp = "";
				$q5 = mysqli_query($koneksi, "SELECT
                ID_KRITERIA,ID_SUB_KRITERIA, NAMA_SUB_KRITERIA,NILAI_SUB_KRITERIA
                FROM sub_kriteria
                WHERE NILAI_SUB_KRITERIA = $pelayanan AND ID_KRITERIA = 'C5'");
				$r5 = mysqli_fetch_array($q5);
				$idkri = $r5['ID_KRITERIA'];
				$idsubkri = $r5['ID_SUB_KRITERIA'];

				mysqli_query($koneksi, "INSERT INTO sub_kriteria_cafe (ID_KRITERIA, ID_SUB_KRITERIA, ID_CAFE) VALUES ('$idkri','$idsubkri','$idcafe')");

				redirect_to('list-cafe.php?status=sukses-edit');
			} else {
				$errors[] = 'Data gagal diupdate';
			}
		}
	}

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
		<div class="alert alert-primary">
			<?php foreach ($errors as $error) : ?>
				<?php echo $error; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>


	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-edit"></i> Edit Data Cafe</h6>
		</div>

		<form action="edit-cafe.php?id=<?php echo $idcafe; ?>" method="post">
			<?php
			if (!$idcafe) {
			?>
				<div class="card-body">
					<div class="alert alert-primary">Data tidak ada</div>
				</div>
				<?php
			} else {
				$data = mysqli_query($koneksi, "SELECT * FROM cafe WHERE ID_CAFE = '$idcafe'");
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
									<label class="font-weight-bold">ID Cafe</label>
									<input autocomplete="off" type="text" name="idcafe" required readonly value="<?php echo $d['ID_CAFE']; ?>" class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Nama Cafe</label>
									<input autocomplete="off" type="text" name="namacafe" required value="<?php echo $d['NAMA_CAFE']; ?>" class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Alamat Cafe</label>
									<input autocomplete="off" type="text" name="alamatcafe" required value="<?php echo $d['ALAMAT']; ?>" class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">No Telp</label>
									<input autocomplete="off" type="text" name="notelp" required value="<?php echo $d['NOTELP']; ?>" class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Harga Minimal</label>
									<input autocomplete="off" type="text" name="hargamin" required value="<?php echo $d['HARGA_MIN']; ?>" class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Jumlah Menu</label>
									<input autocomplete="off" type="text" name="jmlhmenu" required value="<?php echo $d['JUMLAH_MENU']; ?>" class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Rating Pelayanan</label>
									<select name="pelayanan" class="form-control" required>
										<option value="">--Pilih--</option>
										<?php $data5 = mysqli_query($koneksi, "SELECT ID_SUB_KRITERIA, NAMA_SUB_KRITERIA, NILAI_SUB_KRITERIA FROM sub_kriteria 
										WHERE ID_KRITERIA = 'C5'");
										$pelayanan2 = intval($d["PELAYANAN"]);

										while ($d5 = mysqli_fetch_array($data5)) {
											$nilaiSubKriteria = intval($d5['NILAI_SUB_KRITERIA']);
										?>
											<option value="<?php echo $d5["NILAI_SUB_KRITERIA"]; ?>" <?php if ($nilaiSubKriteria == $pelayanan2) {
																											echo "Selected";
																										}
																										?>><?php echo $d5["NILAI_SUB_KRITERIA"] . " (" . $d5["NAMA_SUB_KRITERIA"] . ")" ?></option>
										<?php
										}
										?>
									</select>
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Gambar</label>
									<input autocomplete="off" type="url" name="gambar" required value="<?php echo $d['GAMBAR']; ?>" class="form-control" />
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Deskripsi</label>
									<textarea name="deskripsi" required rows="13" cols="50" class="form-control"><?php echo $d['DESKRIPSI']; ?></textarea>
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Fasilitas Cafe</label><br>
									<select class="form-control" name="fasilitas" required>
										<option value="">--Pilih--</option>
										<?php
										$data3 = mysqli_query($koneksi, "SELECT ID_SUB_KRITERIA FROM sub_kriteria_cafe WHERE ID_KRITERIA = 'C2' && ID_CAFE = '$idcafe'");
										$d3 = mysqli_fetch_array($data3);
										$data2 = mysqli_query($koneksi, "SELECT detil_subkri_fas.ID_SUB_KRITERIA,sub_kriteria.NAMA_SUB_KRITERIA, GROUP_CONCAT(ID_FASILITAS ORDER BY ID_FASILITAS ASC) AS 'DETAIL_FASILITAS',COUNT(detil_subkri_fas.ID_SUB_KRITERIA) AS 'TOTAL_FASILITAS' FROM `detil_subkri_fas` JOIN sub_kriteria ON detil_subkri_fas.ID_SUB_KRITERIA = sub_kriteria.ID_SUB_KRITERIA WHERE sub_kriteria.ID_SUB_KRITERIA = detil_subkri_fas.ID_SUB_KRITERIA GROUP BY ID_SUB_KRITERIA;");
										while ($d2 = mysqli_fetch_array($data2)) {
										?>
											<option value="<?php echo $d2["ID_SUB_KRITERIA"]; ?>" <?php if ($d2["ID_SUB_KRITERIA"] == $d3['ID_SUB_KRITERIA']) {
																										echo "selected";
																									} ?>><?php echo $d2["NAMA_SUB_KRITERIA"]; ?></option>
										<?php
										}
										?>
									</select>

									<table class="table mt-4">
										<?php $data4 = mysqli_query($koneksi, "SELECT *, fasilitas.NAMA_FASILITAS FROM fasilitas_cafe 
										JOIN FASILITAS ON fasilitas.ID_FASILITAS = fasilitas_cafe.ID_FASILITAS
										WHERE ID_CAFE = '$idcafe' AND fasilitas_cafe.ID_FASILITAS = fasilitas.ID_FASILITAS");

										while ($d4 = mysqli_fetch_array($data4)) {
											// Get the status of the facility
											$status_fas_cafe = $d4['STATUS_FAS_CAFE'];
											$checked = ($status_fas_cafe == "1") ? "checked disabled" : ""; // Checked if status is ON
											$disabled = ($status_fas_cafe == "0") ? "disabled" : ""; // Disabled if status is OFF
										?>
											<tr>
												<td><input type="checkbox" value="<?php echo $d4["ID_FASILITAS"]; ?>" <?php echo $checked; ?> <?php echo $disabled; ?>>
													<label><?php echo $d4['NAMA_FASILITAS']; ?></label>
												</td>
											</tr>

										<?php } ?>
									</table>
								</div>

								<div class="form-group col-md-6">
									<label class="font-weight-bold">Status Cafe</label>
									<select name="stscafe" class="form-control" required>
										<option value="">--Pilih--</option>
										<option value="0" <?php if ($d['STATUS_CAFE'] == "0") {
																echo "Selected";
															} ?>>Off</option>
										<option value="1" <?php if ($d['STATUS_CAFE'] == "1") {
																echo "Selected";
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