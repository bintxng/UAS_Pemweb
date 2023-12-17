<?php
session_start();
  
require 'form_validator.php';

$host = 'localhost';  
$username = 'id21683544_bankrc';   
$password = 'bY)9~D+coG@J)oAE';       
$database = 'id21683544_bank_rc';

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Koneksi ke database gagal: " . $mysqli->connect_error);
}

define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'bank_rc');

$formValidator = new FormValidator();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
    $ktp_address = isset($_POST['ktp_address']) ? $_POST['ktp_address'] : '';
    $dom_address = isset($_POST['dom_address']) ? $_POST['dom_address'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $terms = isset($_POST['terms']) && $_POST['terms'] === 'on' ? 1 : 0;
    $user_browser = $_SERVER['HTTP_USER_AGENT'];
    $user_ip = $_SERVER['REMOTE_ADDR'];
    
    $errors = $formValidator->validateForm($_POST);

    if (empty($errors)) {
        // Penanganan saat tidak ada kesalahan validasi

        $full_name = mysqli_real_escape_string($mysqli, $full_name);
        $email = mysqli_real_escape_string($mysqli, $email);
        $gender = mysqli_real_escape_string($mysqli, $gender);
        $birthdate = mysqli_real_escape_string($mysqli, $birthdate);
        $ktp_address = mysqli_real_escape_string($mysqli, $ktp_address);
        $dom_address = mysqli_real_escape_string($mysqli, $dom_address);
        $type = mysqli_real_escape_string($mysqli, $type);

        $insertQuery = "INSERT INTO user (full_name, email, gender, birthdate, ktp_address, dom_address, type, terms, user_browser, user_ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($insertQuery);

        $stmt->bind_param("ssssssssss", $full_name, $email, $gender, $birthdate, $ktp_address, $dom_address, $type, $terms, $user_browser, $user_ip);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }

        $stmt->close();
    } else {
        // Tampilkan pesan kesalahan validasi
        echo "Terjadi kesalahan validasi:<br>";
        foreach ($errors as $error) {
            echo "- $error<br>";
        }
    }
}
?>
