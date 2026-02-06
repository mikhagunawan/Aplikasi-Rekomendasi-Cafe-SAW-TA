<?php
//Koneksi DB
$koneksi = mysqli_connect("localhost", "root", "", "dbcafesaw");

function redirect_to($url = '')
{
	header('Location: ' . $url);
	exit();
}

function cek_login($status = array())
{

	if (isset($_SESSION['id']) && isset($_SESSION['status']) && in_array($_SESSION['status'], $status)) {
		// do nothing
	} else {
		redirect_to("mainform.php");
	}
}

function get_role()
{
	// Cek apakah session user_id ada
	if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
		$id = $_SESSION['id'];
		$username = $_SESSION['username'];

		// Menghubungkan ke database (ganti dengan koneksi DB Anda)
		$conn = new mysqli('localhost', 'root', '', 'dbcafesaw');

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		// Cek apakah user_id ada di tabel user (admin) dengan status_admin
		$sql = "SELECT ID_ADMIN, USERNAME, STATUS_ADMIN FROM user WHERE ID_ADMIN = ? AND USERNAME = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("is", $id, $username);
		$stmt->execute();
		$stmt->store_result();

		// Cek apakah ada hasil untuk admin
		if ($stmt->num_rows > 0) {
			// Jika ada di tabel user, cek status_admin
			$stmt->bind_result($db_id, $db_username, $db_status_admin);
			$stmt->fetch();
			if ($db_status_admin == 1) { // Admin aktif dan status sesuai
				$stmt->close();
				$conn->close();
				return 'admin';
			}
		}

		// Jika tidak ditemukan di tabel user, cek di tabel konsumen
		$sql = "SELECT ID_KONSUMEN, USERNAME, STATUS_KONSUMEN FROM konsumen WHERE ID_KONSUMEN = ? AND USERNAME = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("is", $id, $username);
		$stmt->execute();
		$stmt->store_result();

		// Cek apakah ada hasil untuk konsumen
		if ($stmt->num_rows > 0) {
			// Jika ada di tabel konsumen, cek status_konsumen
			$stmt->bind_result($db_id_konsumen, $db_username_konsumen, $db_status_konsumen);
			$stmt->fetch();
			if ($db_status_konsumen == 1) { // Konsumen aktif dan status sesuai
				$stmt->close();
				$conn->close();
				return 'konsumen';
			}
		}

		// Jika tidak ada di kedua tabel atau status tidak aktif
		$stmt->close();
		$conn->close();
		return false;
	} else {
		// Jika session user_id tidak ada
		return false;
	}
}

function registrasi($data)
{
	global $koneksi;
	$iduser = $data["iduser"];
	$nama = $data["fullname"];
	$nohp = $data["number"];
	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($koneksi, $data["password"]);
	$password2 = mysqli_real_escape_string($koneksi, $data["password2"]);
	$status = $data["statususer"];
	$tipe = $data['tipeuser']; // Admin or Konsumen

	// Prepared statement untuk cek username di tabel user
	$stmt = mysqli_prepare($koneksi, "SELECT * FROM user WHERE USERNAME = ?");
	mysqli_stmt_bind_param($stmt, 's', $username); // 's' untuk string
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	// Prepared statement untuk cek username di tabel konsumen
	$stmt2 = mysqli_prepare($koneksi, "SELECT * FROM konsumen WHERE USERNAME = ?");
	mysqli_stmt_bind_param($stmt2, 's', $username); // 's' untuk string
	mysqli_stmt_execute($stmt2);
	$result2 = mysqli_stmt_get_result($stmt2);

	// Jika username sudah ada di tabel user atau konsumen
	if (mysqli_fetch_assoc($result) || mysqli_fetch_assoc($result2)) {
		echo "<script>
    alert('Username Pengguna sudah terdaftar!');
    </script>";
		return false;
	}

	// Cek Konfirmasi Password
	if ($password !== $password2) {
		echo "<script>
	alert('Password Tidak Sesuai!');
	</script>";

		return false;
	}

	//Enkripsi PW
	$password = password_hash($password, PASSWORD_DEFAULT);

	// Insert data ke tabel yang sesuai berdasarkan tipe pengguna
	if ($tipe == 'admin') {
		// Insert ke tabel user (admin)
		$stmt_insert = mysqli_prepare($koneksi, "INSERT INTO user (ID_ADMIN, NAMA_ADMIN, NOHP, USERNAME, PASSWORD, STATUS_ADMIN) VALUES (?, ?, ?, ?, ?, ?)");
		mysqli_stmt_bind_param($stmt_insert, 'ssssss', $iduser, $nama, $nohp, $username, $password, $status);
		mysqli_stmt_execute($stmt_insert);
	} elseif ($tipe == 'konsumen') {
		// Insert ke tabel konsumen (pengguna umum)
		$stmt_insert = mysqli_prepare($koneksi, "INSERT INTO konsumen (ID_KONSUMEN, NAMA_KONSUMEN, NOHP, USERNAME, PASSWORD, STATUS_KONSUMEN) VALUES (?, ?, ?, ?, ?, ?)");
		mysqli_stmt_bind_param($stmt_insert, 'ssssss', $iduser, $nama, $nohp, $username, $password, $status);
		mysqli_stmt_execute($stmt_insert);
	} else {
		echo "<script>alert('Tipe pengguna tidak valid!');</script>";
		return false;
	}

	// Cek apakah insert berhasil
	return mysqli_affected_rows($koneksi);
}

// Fungsi untuk memperbarui alternatif setelah insert atau update bobot
function updateHasil($kriteria, $alternatif, $idk, $koneksi)
{
	foreach ($alternatif as $keys) :
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
                                            FROM kriteria 
                                            JOIN sub_kriteria_cafe ON sub_kriteria_cafe.ID_KRITERIA=kriteria.ID_KRITERIA 
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
		endforeach;
		$idalt = $keys['ID_ALTERNATIF'];
		$tgl = $keys['TGL_ALTERNATIF'];
		$idcafe = $keys['ID_CAFE'];

		mysqli_query($koneksi, "UPDATE alternatif SET HASIL = '$nilai_v' WHERE ID_ALTERNATIF = '$idalt' AND TGL_ALTERNATIF = '$tgl' AND ID_CAFE = '$idcafe' AND ID_KONSUMEN = '$idk'");
	endforeach;
}

function updateRanking($koneksi)
{
    // Query untuk mendapatkan nilai HASIL dan ranking berdasarkan urutan HASIL
    $query = "SELECT ID_ALTERNATIF, TGL_ALTERNATIF, ID_CAFE, ID_KONSUMEN, HASIL,
                     ROW_NUMBER() OVER(PARTITION BY TGL_ALTERNATIF ORDER BY HASIL DESC) AS RANK
              FROM alternatif";
    
    $result = mysqli_query($koneksi, $query);
    
    if ($result) {
        // Iterasi setiap baris hasil query untuk memperbarui ranking
        while ($row = mysqli_fetch_assoc($result)) {
            $idalt = $row['ID_ALTERNATIF'];
            $tgl = $row['TGL_ALTERNATIF'];
            $idcafe = $row['ID_CAFE'];
            $idk = $row['ID_KONSUMEN'];
            $rank = $row['RANK'];
            
            // Update kolom RANGKING dengan nilai ranking yang sudah dihitung
            $updateQuery = "UPDATE alternatif
                            SET RANGKING = '$rank'
                            WHERE ID_ALTERNATIF = '$idalt'
                            AND TGL_ALTERNATIF = '$tgl'
                            AND ID_CAFE = '$idcafe'
                            AND ID_KONSUMEN = '$idk'";
            
            mysqli_query($koneksi, $updateQuery);
        }
    } else {
        // Jika query gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($koneksi);
    }
}

