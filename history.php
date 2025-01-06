<?php
require_once('includes/init.php');
$user_role = get_role();
if ($user_role == 'admin' || $user_role == 'konsumen') {

	$page = "Hasil";

	require_once('template/header.php');

	// Koneksi ke database MySQL
	$koneksi = new mysqli("localhost", "root", "", "dbcafesaw");

	// Mengecek koneksi
	if ($koneksi->connect_error) {
		die("Koneksi gagal: " . $koneksi->connect_error);
	}

	// Ambil ID konsumen yang sedang login dari session
	$id_konsumen = $_SESSION['id'];

	// Query untuk mengambil data dari tabel 'alternatif' menggunakan prepared statement
	$sql = "SELECT alternatif.TGL_ALTERNATIF, cafe.NAMA_CAFE,alternatif.RANGKING
FROM alternatif
JOIN cafe ON alternatif.ID_CAFE = cafe.ID_CAFE
WHERE alternatif.ID_KONSUMEN = ? ORDER BY alternatif.TGL_ALTERNATIF DESC, alternatif.RANGKING ASC;";

	// Menyiapkan query
	$stmt = $koneksi->prepare($sql);

	// Memeriksa apakah query berhasil disiapkan
	if ($stmt === false) {
		die('Prepare failed: ' . $koneksi->error);
	}

	// Mengikatkan parameter ID konsumen ke dalam prepared statement
	$stmt->bind_param("i", $id_konsumen);  // "i" untuk integer

	// Menjalankan query
	$stmt->execute();

	// Memeriksa apakah query berhasil dieksekusi
	if ($stmt->errno) {
		die('Execute failed: ' . $stmt->error);
	}

	// Mendapatkan hasil query
	$result = $stmt->get_result();

?>

	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-chart-area"></i> Histori Pengguna Umum</h1>

		<?php if ($result->num_rows > 0): ?>
			<a href="cetak.php" target="_blank" class="btn btn-primary"> <i class="fa fa-print"></i> Cetak Data </a>
		<?php else: ?>
			<a href="#" class="btn btn-primary disabled"> <i class="fa fa-print"></i> Cetak Data </a>
		<?php endif; ?>
	</div>

	<div class="card shadow mb-4">
		<!-- /.card-header -->
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Daftar Hasil Rekomendasi Cafe</h6>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<?php if ($result->num_rows > 0): ?>
					<table class="table table-bordered" width="100%" cellspacing="0">
						<thead class="bg-primary text-white">
							<tr align="center">
								<!-- <th width="20%">ID Cafe</th> -->
								<th width="20%">Tgl Alternatif</th>
								<th width="45%">Nama Cafe</th>
								<th width="10%">Rangking</th>
							</tr>
						</thead>
						<tbody style="font-weight: bold;">
							<?php while ($row = $result->fetch_assoc()): ?>
								<tr align="center">
									<td><?php echo $row['TGL_ALTERNATIF']; ?></td>
									<td><?php echo $row['NAMA_CAFE']; ?></td>
									<td><?php echo $row['RANGKING']; ?></td>
								</tr>
							<?php endwhile; ?>
						</tbody>

					</table>

				<?php else: ?>
					<p>Data tidak tersedia.</p>
				<?php endif; ?>
			</div>

		</div>
	</div>

<?php
	require_once('template/footer.php');
} else {
	header('Location: login.php');
}
?>