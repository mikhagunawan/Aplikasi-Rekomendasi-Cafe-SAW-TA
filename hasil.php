<?php
require_once('includes/init.php');
cek_login($statusadmin = array(1));

$page = "Hasil";

require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-chart-area"></i> Data Histori Pengguna</h1>

	<!-- <a href="cetak.php" target="_blank" class="btn btn-primary"> <i class="fa fa-print"></i> Cetak Data </a> -->
</div>

<div class="card shadow mb-4">
	<!-- /.card-header -->
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Daftar Histori</h6>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<th>No</th>
						<th>Nama Pengguna</th>
						<th>Jumlah Rekomendasi</th>
						<th width="15%">Aksi</th>
				</thead>
				<tbody>
					<?php
					$no = 1;
					$query = mysqli_query($koneksi, "SELECT 
    konsumen.ID_KONSUMEN,
    konsumen.NAMA_KONSUMEN,
    COALESCE(COUNT(alternatif.HASIL), 0) AS 'JUMLAH_REKOMENDASI'
FROM 
    konsumen
LEFT JOIN 
    alternatif ON konsumen.ID_KONSUMEN = alternatif.ID_KONSUMEN
GROUP BY 
    konsumen.ID_KONSUMEN, konsumen.NAMA_KONSUMEN;
");
					while ($data = mysqli_fetch_array($query)) {
					?>
						<tr align="center">
							<td><?php echo $no; ?></td>
							<td align="left"><?= $data['NAMA_KONSUMEN']; ?></td>
							<td><?= $data['JUMLAH_REKOMENDASI']; ?></td>
							<td>
								<a href="perhitungan.php?id=<?php echo $data['ID_KONSUMEN']; ?>" class=" btn btn-sm btn-warning"> <i class="fa fa-search"></i> Detail </a>
							</td>
						</tr>
					<?php
						$no++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
require_once('template/footer.php');
?>