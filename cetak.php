<?php
require_once('includes/init.php');

$user_role = get_role();

if ($user_role == 'admin' || $user_role = 'konsumen') {
?>

	<html>

	<head>
		<title>Sistem Pendukung Keputusan Metode SAW</title>
	</head>

	<body onload="window.print();">

		<div style="width:80%;margin:0 auto;text-align:center;">
			<h4 style="margin-top: 40px;">Hasil Rekomendasi Cafe <br> Pengguna : <?php echo $_SESSION['username'] ?></h4>
			<table width="100%" cellspacing="0" cellpadding="5" border="1">
				<thead>
					<tr align="center">
						<th>Tanggal Rekomendasi</th>
						<th width="50%">Nama Alternatif</th>
						<th width="15%">Nilai</th>
						<th width="15%">Rank</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 0;
					// Ambil ID konsumen yang sedang login dari session
					$id_konsumen = $_SESSION['id'];

					// Query yang telah disiapkan
					$query = "SELECT DATE_FORMAT(alternatif.TGL_ALTERNATIF,'%d-%m-%Y') AS TGL_ALTERNATIF,alternatif.ID_CAFE, alternatif.HASIL, alternatif.RANGKING, cafe.NAMA_CAFE
          FROM alternatif
          JOIN cafe ON alternatif.ID_CAFE = cafe.ID_CAFE
          WHERE alternatif.ID_KONSUMEN = ?
          ORDER BY alternatif.TGL_ALTERNATIF DESC, alternatif.RANGKING ASC;";

					// Menyiapkan query
					$stmt = $koneksi->prepare($query);

					// Memeriksa apakah query berhasil disiapkan
					if ($stmt === false) {
						die('Prepare failed: ' . $koneksi->error);
					}

					// Mengikatkan parameter ID konsumen ke dalam prepared statement
					$stmt->bind_param("i", $id_konsumen); // "i" untuk integer

					// Menjalankan query
					$stmt->execute();

					// Mengikat hasil query ke variabel
					$stmt->bind_result($tgl, $id_cafe, $hasil, $rangking, $nama_cafe);

					// Menampilkan hasil query
					while ($stmt->fetch()) {
						$no++;
					?>
						<tr align="center">
							<td><?= htmlspecialchars($tgl) ?></td>
							<td align="left"><?= htmlspecialchars($nama_cafe) ?></td>
							<td><?= htmlspecialchars($hasil) ?></td>
							<td><?= htmlspecialchars($rangking) ?></td>
						</tr>
					<?php
					}

					// Menutup prepared statement
					$stmt->close();
					?>

				</tbody>
			</table>
		</div>

	</body>

	</html>

<?php
} else {
	header('Location: login.php');
}
?>