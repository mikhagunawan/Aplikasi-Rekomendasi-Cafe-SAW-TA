<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$page = "Alternatif";
require_once('template/header.php');

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users"></i> Data Cafe</h1>

	<a href="tambah-alternatif.php" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
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
		<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Daftar Pilihan Cafe</h6>
	</div>

	<div class="card-body">
		<?php $query = mysqli_query($koneksi, "SELECT * FROM alternatif;");
		$cek = mysqli_num_rows($query);
		if ($cek <= 0) {
		?><div class="alert alert-info">
				Data tidak ada.
			</div>
		<?php
		} else {
		?>
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="bg-primary text-white">
						<tr align="center">
							<th width="5%">No</th>
							<th width="20%">Tgl Alternatif</th>
							<th width="45%">Nama Cafe</th>
						</tr>
					</thead>
					<tbody style="font-weight: bold;">
						<?php
						$no = 1;
						$query = mysqli_query($koneksi, "SELECT DATE_FORMAT(alternatif.TGL_ALTERNATIF,'%d-%m-%Y') AS TGL_ALTERNATIF, cafe.NAMA_CAFE 
					FROM alternatif INNER JOIN cafe ON alternatif.ID_CAFE = cafe.ID_CAFE 
					WHERE alternatif.TGL_ALTERNATIF = CURDATE()
					ORDER BY alternatif.ID_CAFE;");
						while ($data = mysqli_fetch_assoc($query)) :
						?>
							<tr align="center">
								<td><?php echo $no; ?></td>
								<td><?php echo $data["TGL_ALTERNATIF"]; ?></td>
								<td align="left"><?php echo $data['NAMA_CAFE']; ?></td>
							</tr>
						<?php
							$no++;
						endwhile;
						?>
					</tbody>
				</table>
			</div>
	</div>

<?php
		}
?>
</div>

<?php
require_once('template/footer.php');
?>