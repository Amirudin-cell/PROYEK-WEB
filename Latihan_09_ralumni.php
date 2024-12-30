<h3>DAFTAR ALUMNI</h3>
<hr>
<!-- Form Pencarian Alumni -->
<form method="GET" action="Latihan_09_index.php?menu=alumni" class="mb-3">
    <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="Cari alumni berdasarkan nama, jurusan, atau tahun lulus">
        <button class="btn btn-primary" type="submit">Cari</button>
    </div>
</form>
<a href="?menu=calumni" class="btn btn-primary mb-3">Tambah</a>
<?php
include 'Latihan_09_config.php';

// Menangani pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mencari alumni berdasarkan nama, jurusan, atau tahun lulus
$sql = "SELECT * FROM alumni WHERE nama LIKE '%$search%' OR jurusan LIKE '%$search%' OR tahun_lulus LIKE '%$search%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-bordered'>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Tahun Lulus</th>
                <th>Jurusan</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["nama"] . "</td>
                <td>" . $row["tahun_lulus"] . "</td>
                <td>" . $row["jurusan"] . "</td>
                <td><img src='" . $row["foto"] . "' width='50'></td>
                <td>
                    <a class='btn btn-warning' href='Latihan_09_index.php?menu=ualumni&id=" . $row["id"] . "'>Edit</a>
                    <a class='btn btn-danger' href='Latihan_09_dalumni.php?id=" . $row["id"] . "'>Hapus</a>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>Tidak ada data yang ditemukan</p>";
}

$conn->close();
?>
