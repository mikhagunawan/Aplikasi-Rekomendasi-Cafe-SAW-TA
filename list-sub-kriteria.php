<?php

require_once('includes/init.php');
cek_login($role = array(1));
$page = "Sub Kriteria";
require_once('template/header.php');

if (isset($_POST['edit'])) :
	$id_subkri = $_POST['id_subkri'];
	$id_kriteria = $_POST['id_kriteria'];
	$nama_subkri = $_POST['nama_subkri'];
	$indikator = $_POST['indikator'];
	$btsatas = $_POST['btsatas'];
	$btsbwh = $_POST['btsbwh'];
	$nilai = $_POST['nilai'];
	$stssubkri = $_POST['statussubkri'];

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

	if (empty($errors)) :
		$update = mysqli_query($koneksi, "UPDATE sub_kriteria SET NAMA_SUB_KRITERIA = '$nama_subkri',INDIKATOR = '$indikator', NILAI_SUB_KRITERIA = '$nilai',STATUS_SUB_KRITERIA = '$stssubkri',BATAS_ATAS = '$btsatas',BATAS_BAWAH = '$btsbwh' WHERE ID_KRITERIA = '$id_kriteria' AND ID_SUB_KRITERIA = '$id_subkri'");

		if ($update) {
			$sts[] = 'Data berhasil diupdate';
		} else {
			$sts[] = 'Data gagal diupdate';
		}
	endif;
endif;
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cubes"></i> Data Sub Kriteria</h1>
	<a href="tambah-subkriteria.php" class="btn btn-primary"> <i class="fa fa-plus"></i> Tambah Data </a>
</div>

<?php if (!empty($sts)) : ?>
	<div class="alert alert-info">
		<?php foreach ($sts as $st) : ?>
			<?php echo $st; ?>
		<?php endforeach; ?>
	</div>
<?php
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


$query2 = mysqli_query($koneksi, "SELECT MAX(cast(ID_SUB_KRITERIA AS INTEGER)) as idSubkri FROM SUB_KRITERIA");
$data2 = mysqli_fetch_array($query2);
$IDSubkri = $data2['idSubkri'];
$IDSubkri++;
?>
<div class="card shadow mb-4">
	<!-- /.card-header -->
	<div class="card-header py-3">
		<div class="d-sm-flex align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Daftar Data Sub Kriteria </h6>

		</div>
	</div>

	<div class="card-body">
		<?php $query = mysqli_query($koneksi, "SELECT * FROM sub_kriteria;");
		$cek = mysqli_num_rows($query);
		if ($cek <= 0) {
		?><div class="alert alert-info">
				Data tidak ada.
			</div>
		<?php
		} else {
		?>
			<form action="" id="tampildata" method="post">
				<select style="width: 200px;" name="jeniskriteria" class="form-control" onchange="document.getElementById('tampildata').submit()">
					<option value="">--Pilih--</option>
					<?php
					$data3 = mysqli_query($koneksi, "SELECT * FROM KRITERIA WHERE STATUS_KRITERIA = 1");
					while ($d3 = mysqli_fetch_array($data3)) {
					?>
						<option value="<?php echo $d3["ID_KRITERIA"]; ?>"><?php echo $d3["NAMA_KRITERIA"]; ?></option>
					<?php
					}
					?>
				</select>

				<br>
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead class="bg-primary text-white">
							<tr align="center">
								<th width="5%">ID</th>
								<th>Nama Sub Kriteria</th>
								<th>Indikator</th>
								<th>Status Sub Kriteria</th>
								<th width="15%">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;

							if ($_SERVER["REQUEST_METHOD"] == "POST") {
								$idkri = $_POST['jeniskriteria'];
								$q = mysqli_query($koneksi, "SELECT * FROM sub_kriteria WHERE ID_KRITERIA = '$idkri' ORDER BY cast(ID_SUB_KRITERIA AS INTEGER) ASC;");
								while ($d = mysqli_fetch_array($q)) :
									//$id_kriteria = $data['ID_KRITERIA'];

							?>
									<tr align="center">
										<td><?php echo $d['ID_SUB_KRITERIA']; ?></td>
										<td align="left"><?= $d['NAMA_SUB_KRITERIA']; ?></td>
										<td><?= $d['INDIKATOR'] ?></td>
										<td><?= $d['STATUS_SUB_KRITERIA'] ? 'On' : 'Off'; ?></td>
										<td>
											<div class="btn-group" role="group">
												<a data-toggle="tooltip" title="Edit Data" href="edit-subkriteria.php?id=<?php echo $d['ID_SUB_KRITERIA']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
												<!-- <a data-toggle="tooltip" data-placement="bottom" title="Hapus Data" href="hapus-sub-kriteria.php?id=<?php echo $d['ID_SUB_KRITERIA']; ?>" onclick="return confirm ('Apakah anda yakin untuk menghapus data ini')" class="btn btn-primary btn-sm"><i class="fa fa-trash"></i></a> -->
											</div>
										</td>
									</tr>
								<?php
									$no++;
								endwhile;
							} else {
								$q = mysqli_query($koneksi, "SELECT * FROM sub_kriteria ORDER BY cast(ID_SUB_KRITERIA AS INTEGER) ASC;");
								while ($d = mysqli_fetch_array($q)) :
								?>
									<tr align="center">
										<td><?php echo $d['ID_SUB_KRITERIA']; ?></td>
										<td align="left"><?= $d['NAMA_SUB_KRITERIA']; ?></td>
										<td><?= $d['INDIKATOR'] ?></td>
										<td><?= $d['STATUS_SUB_KRITERIA'] ? 'On' : 'Off'; ?></td>
										<td>
											<div class="btn-group" role="group">
												<a data-toggle="tooltip" title="Edit Data" href="edit-subkriteria.php?id=<?php echo $d['ID_SUB_KRITERIA']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
												<!-- <a data-toggle="tooltip" data-placement="bottom" title="Hapus Data" href="hapus-sub-kriteria.php?id=<?php echo $d['ID_SUB_KRITERIA']; ?>" onclick="return confirm ('Apakah anda yakin untuk menghapus data ini')" class="btn btn-primary btn-sm"><i class="fa fa-trash"></i></a> -->
											</div>
										</td>
									</tr>
							<?php
								endwhile;
							} ?>
						</tbody>
					</table>
				</div>
			</form>
		<?php
		}
		?>
	</div>
</div>

<?php
require_once('template/footer.php');
?>