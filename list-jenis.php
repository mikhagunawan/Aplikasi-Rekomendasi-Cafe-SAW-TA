<?php
require_once('includes/init.php');
cek_login($statusadmin = array(1));
$page = "Jenis";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Jenis Atribut</h1>
	<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-plus"></i> Tambah Data </button>
</div>

<?php
$statusadmin = isset($_GET['status']) ? $_GET['status'] : '';
$msg = '';
switch ($statusadmin):
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

$query = mysqli_query($koneksi, "SELECT CAST(RIGHT(MAX(ID_JENIS),1) AS INTEGER) AS idJenis FROM jenis_atribut;");
$data = mysqli_fetch_array($query);
$idjenis = $data['idJenis'];
$idjenis++;

if (isset($_POST['submit'])) :
	$idjenis = $_POST['idjenis'];
	$namajenis = $_POST['namajenis'];
	$stsjenis = $_POST['stsjenis'];

	if (empty($errors)) :

		$simpan = mysqli_query($koneksi, "INSERT INTO jenis_atribut (ID_JENIS,NAMA_JENIS, STATUS_JENIS) VALUES ($idjenis,'$namajenis', $stsjenis)");
		if ($simpan) {
			echo '<script> alert("Data berhasil disimpan!") </script>';
		} else {
			$errors[] = 'Data gagal disimpan';
		}
	endif;

endif;
?>
<!-- Modal Tambah Data-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambah Data Jenis Atribut</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="list-jenis.php" method="post">
				<div class="modal-body">
					<div class="form-group">
						<label for="formGroupExampleInput">ID Jenis</label>
						<input type="text" class="form-control" name="idjenis" id="formGroupExampleInput" required value="<?php echo $idjenis ?>" placeholder="ID Jenis Atribut" readonly>
					</div>
					<div class="form-group">
						<label for="formGroupExampleInput2">Nama Jenis</label>
						<select class="form-control" name="namajenis">
							<option value="">--Pilih Atribut--</option>
							<option value="Cost">Cost</option>
							<option value="Benefit">Benefit</option>
						</select>
					</div>
					<div class="form-group">
						<label for="formGroupExampleInput3">Status Jenis Atribut</label>
						<select class="form-control" name="stsjenis">
							<option value="">--Status Jenis Atribut--</option>
							<option value="1">On</option>
							<option value="0">Off</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" name="submit" value="submit" class="btn btn-success">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="card shadow mb-4">
	<!-- /.card-header -->
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Daftar Data Jenis Atribut</h6>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<th>No</th>
						<th>Nama Jenis</th>
						<th>Status Jenis</th>
						<th width="15%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					$query = mysqli_query($koneksi, "SELECT * FROM jenis_atribut ORDER BY ID_JENIS ASC");
					while ($data = mysqli_fetch_array($query)) :
					?>
						<tr align="center">
							<td><?php echo $no; ?></td>
							<td align="left"><?php echo $data['NAMA_JENIS']; ?></td>
							<td><?php echo $data['STATUS_JENIS'] ? 'On' : 'Off'; ?></td>
							<td>
								<div class="btn-group" role="group">
									<a data-toggle="tooltip" href="edit-jenis.php?id=<?php echo $data['ID_JENIS']; ?>" data-placement="bottom" title="Edit Data" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
								</div>
							</td>
						</tr>
					<?php
						$no++;
					endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<?php
require_once('template/footer.php');
?>