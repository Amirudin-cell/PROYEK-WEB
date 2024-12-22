<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $job_status = htmlspecialchars($_POST['job_status']);

    // Simpan data ke file JSON
    $file = 'alumni.json';
    $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

    $data[] = ['name' => $name, 'email' => $email, 'job_status' => $job_status];
    file_put_contents($file, json_encode($data));

    echo json_encode(['success' => true, 'message' => 'Data berhasil disimpan!']);
} else {
    // Ambil data alumni
    $file = 'alumni.json';
    if (file_exists($file) && filesize($file) > 0) {
        $data = json_decode(file_get_contents($file), true);
    } else {
        $data = [];
    }
    echo json_encode($data);
}
?>
