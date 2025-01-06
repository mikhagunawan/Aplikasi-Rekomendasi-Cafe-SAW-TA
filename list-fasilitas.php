<?php
require_once('includes/init.php');
cek_login($statusadmin = array(1));
$page = "Fasilitas";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Fasilitas</h1>

	<a href="tambah-fasilitas.php" class="btn btn-primary"> <i class="fa fa-plus"></i> Tambah Data </a>
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
?>

<div class="card shadow mb-4">
	<!-- /.card-header -->
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Daftar Data Fasilitas</h6>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<th>ID</th>
						<th>Nama Fasilitas</th>
						<th>Status Fasilitas</th>
						<th width="15%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					$query = mysqli_query($koneksi, "SELECT * FROM fasilitas ORDER BY cast(ID_FASILITAS as integer) asc;");
					while ($data = mysqli_fetch_array($query)) :
					?>
						<tr align="center">
							<td><?php echo $data['ID_FASILITAS']; ?></td>
							<td align="left"><?php echo $data['NAMA_FASILITAS']; ?></td>
							<td><?php echo $data['STATUS_FASILITAS'] ? 'On' : 'Off'; ?></td>
							<td>
								<div class="btn-group" role="group">
									<a data-toggle="tooltip" data-placement="bottom" title="Edit Data" href="edit-fasilitas.php?id=<?php echo $data['ID_FASILITAS']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
									<!-- <a data-toggle="tooltip" data-placement="bottom" title="Hapus Data" href="hapus-fasilitas.php?id=<?php echo $data['ID_FASILITAS']; ?>" onclick="return confirm ('Apakah anda yakin untuk menghapus data ini')" class="btn btn-primary btn-sm"><i class="fa fa-trash"></i></a> -->
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