<?php
require_once('includes/init.php');
cek_login($role = array(1));
$page = "Kriteria";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Kriteria</h1>
	<a href="tambah-kriteria.php" class="btn btn-primary"> <i class="fa fa-plus"></i> Tambah Data </a>
</div>

<?php
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
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<th>ID</th>
						<th>Nama Kriteria</th>
						<th>Status Kriteria</th>
						<th width="15%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					$query = mysqli_query($koneksi, "SELECT *, jenis_atribut.ID_JENIS 
					FROM kriteria INNER JOIN jenis_atribut ON jenis_atribut.ID_JENIS = kriteria.ID_JENIS ORDER BY ID_KRITERIA ASC");
					while ($data = mysqli_fetch_array($query)) :
					?>
						<tr align="center">
							<td><?php echo "C".$no; ?></td>
							<td align="left"><?php echo $data['NAMA_KRITERIA']; ?></td>
							<td><?php echo $data['STATUS_KRITERIA'] ? 'On' : 'Off'; ?></td>
							<td>
								<div class="btn-group" role="group">
									<a data-toggle="tooltip" data-placement="bottom" title="Edit Data" href="edit-kriteria.php?id=<?php echo $data['ID_KRITERIA']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
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