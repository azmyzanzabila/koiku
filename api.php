<?php
// Konfigurasi database
$host = "localhost"; // Sesuaikan dengan host database Anda
$username = "root"; // Sesuaikan dengan username database Anda
$password = ""; // Sesuaikan dengan password database Anda
$database = "kolamkoi"; // Sesuaikan dengan nama database Anda

// Fungsi untuk mencatat log
function writeLog($message)
{
	$logFile = "kolamkoi_log.txt";
	$timestamp = date("Y-m-d H:i:s");
	file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

// Buat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
	writeLog("Koneksi database gagal: " . $conn->connect_error);
	die("Koneksi gagal: " . $conn->connect_error);
}

// Tentukan action berdasarkan parameter URL
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle request berdasarkan action
if ($action == 'post_sensor') {
	// Tangani POST data sensor
	$json = file_get_contents('php://input');
	writeLog("Menerima data: " . $json);

	// Decode JSON
	$data = json_decode($json, true);

	if ($data && isset($data['pH']) && isset($data['tds']) && isset($data['turbidity'])) {
		// Siapkan statement SQL
		$stmt = $conn->prepare("INSERT INTO sensor (pH, tds, turbidity, created_at) VALUES (?, ?, ?, NOW())");
		$stmt->bind_param("ddd", $data['pH'], $data['tds'], $data['turbidity']);

		// Eksekusi query
		if ($stmt->execute()) {
			writeLog("Data berhasil disimpan ke database. ID: " . $conn->insert_id);
			echo json_encode(["status" => "success", "message" => "Data berhasil disimpan"]);
		} else {
			writeLog("Error menyimpan data: " . $stmt->error);
			echo json_encode(["status" => "error", "message" => "Gagal menyimpan data: " . $stmt->error]);
		}

		$stmt->close();
	} else {
		writeLog("Data tidak lengkap atau format tidak valid");
		echo json_encode(["status" => "error", "message" => "Data tidak lengkap atau format tidak valid"]);
	}
} elseif ($action == 'get_status') {
	// Tangani GET untuk status kontrol
	$query = "SELECT * FROM pompa ORDER BY id DESC LIMIT 1";
	$result = $conn->query($query);

	if ($result && $result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$response = [
			"mode" => $row['mode'] ?? "auto",
			"pompa" => (int)($row['statusPompa'] ?? 0),
			"valve" => (int)($row['statusValve'] ?? 0)
		];
	} else {
		// Default jika tidak ada data
		$response = [
			"mode" => "auto",
			"pompa" => 0,
			"valve" => 0
		];
	}

	writeLog("Mengirim status: " . json_encode($response));
	echo json_encode($response);
} else {
	// Tampilkan halaman informasi jika tidak ada action yang ditentukan
	echo "<h1>Kolamkoi API</h1>";
	echo "<p>API aktif dan berjalan. Gunakan parameter action=post_sensor untuk POST data atau action=get_status untuk GET status.</p>";
}

// Tutup koneksi database
$conn->close();
