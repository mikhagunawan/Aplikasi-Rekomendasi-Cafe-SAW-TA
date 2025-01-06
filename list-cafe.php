<?php
require_once('includes/init.php');
cek_login($role = array(1));
$page = "Cafe";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Cafe</h1>
	<div class="btn-group">
		<a href="tambah-cafe.php" class="btn btn-primary"> <i class="fa fa-plus"></i> Tambah Data </a>
		<!-- <a href="detail-fas-cafe.php" class="btn btn-info"><i class="fa fa-info"></i> Data Fasilitas Cafe</a> -->
	</div>

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
		<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Daftar Data Cafe</h6>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<th>No</th>
						<th>Nama Cafe</th>
						<th>Alamat</th>
						<th width="15%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = mysqli_query($koneksi, "SELECT * FROM cafe");
					while ($data = mysqli_fetch_array($query)) :
					?>
						<tr>
							<td><?php echo $data['ID_CAFE']; ?></td>
							<td align="left"><?php echo $data['NAMA_CAFE']; ?></td>
							<td><?php echo $data['ALAMAT']; ?></td>
							<td align="center">
								<div class="btn-group" role="group">
									<a data-toggle="tooltip" data-placement="bottom" title="Lihat Cafe" href="<?php echo $data['GAMBAR']; ?>" class="btn btn-secondary btn-sm"><i class="fa fa-search"></i></a>
									<a data-toggle="tooltip" data-placement="bottom" title="Edit Data" href="edit-cafe.php?id=<?php echo $data['ID_CAFE']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
									<!-- <a data-toggle="tooltip" data-placement="bottom" title="Hapus Data" href="hapus-cafe.php?id=<?php echo $data['ID_CAFE']; ?>" onclick="return confirm ('Apakah anda yakin untuk menghapus data ini?')" class="btn btn-primary btn-sm"><i class="fa fa-trash"></i></a> -->
								</div>
							</td>
						</tr>
					<?php
					endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
require_once('template/footer.php');
?>