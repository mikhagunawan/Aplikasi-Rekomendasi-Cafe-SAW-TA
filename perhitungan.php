<?php
require_once('includes/init.php');

$user_role = get_role();
if ($user_role == 'admin') {

	$page = "Perhitungan";
	require_once('template/header.php');

	$idk = (isset($_GET['id'])) ? trim($_GET['id']) : '';
	//var_dump($idk);
	//mysqli_query($koneksi, "TRUNCATE TABLE hasil;");

	$kriteria = array();
	$q1 = mysqli_query(
		$koneksi,
		"SELECT * 
		 FROM kriteria
		 INNER JOIN jenis_atribut ON kriteria.ID_JENIS = jenis_atribut.ID_JENIS 
		 INNER JOIN bobot_kriteria ON kriteria.ID_KRITERIA = bobot_kriteria.ID_KRITERIA
		 WHERE STATUS_KRITERIA = 1  
		 ORDER BY kriteria.ID_KRITERIA ASC"
	);

	while ($krit = mysqli_fetch_array($q1)) {
		$kriteria[$krit['ID_KRITERIA']]['ID_KRITERIA'] = $krit['ID_KRITERIA'];
		$kriteria[$krit['ID_KRITERIA']]['NAMA_KRITERIA'] = $krit['NAMA_KRITERIA'];
		$kriteria[$krit['ID_KRITERIA']]['NAMA_JENIS'] = $krit['NAMA_JENIS'];
		$kriteria[$krit['ID_KRITERIA']]['BOBOT'] = $krit['BOBOT'];
	}

	$alternatif = array();
	$q2 = mysqli_query($koneksi, "SELECT alternatif.ID_CAFE,cafe.NAMA_CAFE, alternatif.HASIL 
	FROM alternatif 
	INNER JOIN cafe ON alternatif.ID_CAFE = cafe.ID_CAFE
    INNER JOIN konsumen ON alternatif.ID_KONSUMEN = konsumen.ID_KONSUMEN
    WHERE konsumen.ID_KONSUMEN = '$idk' AND alternatif.TGL_ALTERNATIF = CURDATE()
	ORDER BY alternatif.HASIL DESC;");
	while ($alt = mysqli_fetch_array($q2)) {
		$alternatif[$alt['ID_CAFE']]['ID_CAFE'] = $alt['ID_CAFE'];
		$alternatif[$alt['ID_CAFE']]['NAMA_CAFE'] = $alt['NAMA_CAFE'];
		$alternatif[$alt['ID_CAFE']]['HASIL'] = $alt['HASIL'];
		// $alternatif[$alt['ID_CAFE']]['RANGKING'] = $alt['RANGKING'];
	}
?>

	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-calculator"></i> Detail Perhitungan SAW</h1>
		<a href="hasil.php" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
			<span class="text">Kembali</span>
		</a>
	</div>

	<div class="card shadow mb-4">
		<!-- /.card-header -->
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Matriks Keputusan (X)</h6>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="bg-primary text-white">
						<tr align="center">
							<th width="5%" rowspan="2">No</th>
							<th>Nama Alternatif</th>
							<?php foreach ($kriteria as $key) : ?>
								<th><?= $key['ID_KRITERIA'] ?></th>
							<?php endforeach ?>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($alternatif as $keys) : ?>
							<tr align="center">
								<td><?= $no; ?></td>
								<td align="left"><?= $keys['NAMA_CAFE'] ?></td>
								<?php foreach ($kriteria as $key) : ?>
									<td>
										<?php
										$q4 = mysqli_query($koneksi, "SELECT sub_kriteria.NILAI_SUB_KRITERIA 
											FROM sub_kriteria_cafe		
											JOIN sub_kriteria 
											ON sub_kriteria_cafe.ID_SUB_KRITERIA=sub_kriteria.ID_SUB_KRITERIA 		
											AND sub_kriteria_cafe.ID_CAFE='$keys[ID_CAFE]' 
											AND sub_kriteria_cafe.ID_KRITERIA='$key[ID_KRITERIA]'");
										$data = mysqli_fetch_array($q4);
										echo $data['NILAI_SUB_KRITERIA'];
										?>
									</td>
								<?php endforeach ?>
							</tr>
						<?php
							$no++;
						endforeach
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- MATRIX TERNORMALISASI -->
	<div class="card shadow mb-4">
		<!-- /.card-header -->
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Matriks Ternormalisasi (R)</h6>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="bg-primary text-white">
						<tr align="center">
							<th width="5%" rowspan="2">No</th>
							<th>Nama Alternatif</th>
							<?php foreach ($kriteria as $key) : ?>
								<th><?= $key['ID_KRITERIA'] ?></th>
							<?php endforeach ?>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($alternatif as $keys) : ?>
							<tr align="center">
								<td><?= $no; ?></td>
								<td align="left"><?= $keys['NAMA_CAFE'] ?></td>
								<?php foreach ($kriteria as $key) : ?>
									<td>
										<?php
										if ($key['NAMA_JENIS'] == "Cost") {
											$q4 = mysqli_query($koneksi, "SELECT sub_kriteria.NILAI_SUB_KRITERIA 
											FROM sub_kriteria_cafe		
											JOIN sub_kriteria 
											ON sub_kriteria_cafe.ID_SUB_KRITERIA=sub_kriteria.ID_SUB_KRITERIA 		
											AND sub_kriteria_cafe.ID_CAFE='$keys[ID_CAFE]' 
											AND sub_kriteria_cafe.ID_KRITERIA='$key[ID_KRITERIA]'");
											$data = mysqli_fetch_array($q4);
											//echo $data['NILAI_SUB_KRITERIA'];

											$q5 = mysqli_query($koneksi, "SELECT MIN(sub_kriteria.NILAI_SUB_KRITERIA) as min 
											FROM sub_kriteria_cafe 
											JOIN sub_kriteria ON sub_kriteria_cafe.ID_SUB_KRITERIA=sub_kriteria.ID_SUB_KRITERIA 
											JOIN kriteria ON kriteria.ID_KRITERIA=kriteria.ID_KRITERIA  
											WHERE sub_kriteria_cafe.ID_KRITERIA='$key[ID_KRITERIA]'");
											$dt2 = mysqli_fetch_array($q5);

											echo $dt2['min'] / $data['NILAI_SUB_KRITERIA'];
										} else {
											$q4 = mysqli_query($koneksi, "SELECT sub_kriteria.NILAI_SUB_KRITERIA 
											FROM sub_kriteria_cafe		
											JOIN sub_kriteria 
											ON sub_kriteria_cafe.ID_SUB_KRITERIA=sub_kriteria.ID_SUB_KRITERIA 		
											AND sub_kriteria_cafe.ID_CAFE='$keys[ID_CAFE]' 
											AND sub_kriteria_cafe.ID_KRITERIA='$key[ID_KRITERIA]'");
											$dt1 = mysqli_fetch_array($q4);

											$q5 = mysqli_query($koneksi, "SELECT MAX(sub_kriteria.NILAI_SUB_KRITERIA) as max 
											FROM kriteria JOIN sub_kriteria_cafe ON sub_kriteria_cafe.ID_KRITERIA=kriteria.ID_KRITERIA 
											JOIN sub_kriteria ON sub_kriteria.ID_SUB_KRITERIA = sub_kriteria_cafe.ID_SUB_KRITERIA 
											WHERE sub_kriteria_cafe.ID_KRITERIA='$key[ID_KRITERIA]'");
											$dt2 = mysqli_fetch_array($q5);

											echo $dt1['NILAI_SUB_KRITERIA'] / $dt2['max'];
										}
										?>
									</td>
								<?php endforeach ?>
							</tr>
						<?php
							$no++;
						endforeach
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="card shadow mb-4">
		<!-- /.card-header -->
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Bobot Preferensi (W)</h6>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="bg-primary text-white">
						<tr align="center">
							<?php foreach ($kriteria as $key) : ?>
								<th><?= $key['ID_KRITERIA'] ?> (<?= $key['NAMA_JENIS'] ?>)</th>
							<?php endforeach ?>
						</tr>
					</thead>
					<tbody>
						<tr align="center">
							<?php foreach ($kriteria as $key) : ?>
								<td>
									<?php
									echo $key['BOBOT'];
									?>
								</td>
							<?php endforeach ?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="card shadow mb-4">
		<!-- /.card-header -->
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Perhitungan (V)</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="bg-primary text-white">
						<tr align="center">
							<th width="5%" rowspan="2">No</th>
							<th>Nama Alternatif</th>
							<th>Perhitungan</th>
							<th>Nilai</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($alternatif as $keys) : ?>
							<tr align="center">
								<td><?= $no; ?></td>
								<td align="left"><?= $keys['NAMA_CAFE'] ?></td>
								<td>

									<?php
									$nilai_v = 0;
									foreach ($kriteria as $key) :
										$bobot = $key['BOBOT'];

										$q4 = mysqli_query($koneksi, "SELECT sub_kriteria.NILAI_SUB_KRITERIA 
										FROM sub_kriteria_cafe		
										JOIN sub_kriteria 
										ON sub_kriteria_cafe.ID_SUB_KRITERIA=sub_kriteria.ID_SUB_KRITERIA 		
										AND sub_kriteria_cafe.ID_CAFE='$keys[ID_CAFE]' 
										AND sub_kriteria_cafe.ID_KRITERIA='$key[ID_KRITERIA]'");
										$dt1 = mysqli_fetch_array($q4);

										$q5 = mysqli_query($koneksi, "SELECT MAX(sub_kriteria.NILAI_SUB_KRITERIA) as max, MIN(sub_kriteria.NILAI_SUB_KRITERIA) as min 
											FROM kriteria JOIN sub_kriteria_cafe ON sub_kriteria_cafe.ID_KRITERIA=kriteria.ID_KRITERIA 
											JOIN sub_kriteria ON sub_kriteria.ID_SUB_KRITERIA = sub_kriteria_cafe.ID_SUB_KRITERIA 
											WHERE sub_kriteria_cafe.ID_KRITERIA='$key[ID_KRITERIA]'");
										$dt2 = mysqli_fetch_array($q5);

										if ($key['NAMA_JENIS'] == "Cost") {
											$nilai_r = $dt2['min'] / $dt1['NILAI_SUB_KRITERIA'];
										} else {
											$nilai_r = $dt1['NILAI_SUB_KRITERIA'] / $dt2['max'];
										}

										$nilai_penjumlahan = $bobot * $nilai_r;
										$nilai_v += $nilai_penjumlahan;
										echo "(" . $bobot . "x" . $nilai_r . ") ";
									endforeach
									?>
								</td>
								<td>
									<!-- HASIL REKOMENDASI -->
									<p><?php echo $nilai_v; ?></p>
								</td>
							</tr>
						<?php
							$no++;
						endforeach
						?>
					</tbody>
				</table>
			</div>
		</div>

	</div>

<?php
	require_once('template/footer.php');
} else {
	header('Location: login.php');
}
?>