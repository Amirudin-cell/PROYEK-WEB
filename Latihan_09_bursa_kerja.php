<?php
include 'Latihan_09_config.php';

// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'tambah':
                $nama_perusahaan = htmlspecialchars($_POST['nama_perusahaan']);
                $posisi = htmlspecialchars($_POST['posisi']);
                $deskripsi = htmlspecialchars($_POST['deskripsi']);
                $tanggal_posting = date('Y-m-d');

                $sql = "INSERT INTO bursa_kerja (nama_perusahaan, posisi, deskripsi, tanggal_posting) 
                        VALUES ('$nama_perusahaan', '$posisi', '$deskripsi', '$tanggal_posting')";
                if ($conn->query($sql)) {
                    echo "<div class='alert alert-success'>Lowongan berhasil ditambahkan!</div>";
                }
                break;

            case 'edit':
                $id = $_POST['id'];
                $nama_perusahaan = htmlspecialchars($_POST['nama_perusahaan']);
                $posisi = htmlspecialchars($_POST['posisi']);
                $deskripsi = htmlspecialchars($_POST['deskripsi']);

                $sql = "UPDATE bursa_kerja 
                        SET nama_perusahaan='$nama_perusahaan', 
                            posisi='$posisi', 
                            deskripsi='$deskripsi' 
                        WHERE id=$id";
                if ($conn->query($sql)) {
                    echo "<div class='alert alert-success'>Lowongan berhasil diperbarui!</div>";
                }
                break;

            case 'lamar':
                $lowongan_id = $_POST['lowongan_id'];
                $nama_pelamar = htmlspecialchars($_POST['nama_pelamar']);
                $email = htmlspecialchars($_POST['email']);
                $cv = htmlspecialchars($_POST['cv']); // Idealnya ini adalah upload file

                $sql = "INSERT INTO lamaran (lowongan_id, nama_pelamar, email, cv, tanggal_lamar) 
                        VALUES ($lowongan_id, '$nama_pelamar', '$email', '$cv', NOW())";
                if ($conn->query($sql)) {
                    echo "<div class='alert alert-success'>Lamaran berhasil dikirim!</div>";
                }
                break;
        }
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM bursa_kerja WHERE id=$id";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Lowongan berhasil dihapus!</div>";
    }
}

// Get job listings
$sql = "SELECT * FROM bursa_kerja ORDER BY tanggal_posting DESC";
$result = $conn->query($sql);
?>

<h3 class="text-center">BURSA KERJA</h3>
<hr>

<div class="container mt-4">
    <h4 class="mb-3">Tambah Lowongan Kerja</h4>
    <form method="POST" action="">
        <input type="hidden" name="action" value="tambah">
        <div class="mb-3">
            <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required>
        </div>
        <div class="mb-3">
            <label for="posisi" class="form-label">Posisi</label>
            <input type="text" class="form-control" id="posisi" name="posisi" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Pekerjaan</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Lowongan</button>
    </form>

    <h4 class="mt-5">Daftar Lowongan Kerja</h4>
    <?php if ($result->num_rows > 0) { ?>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><?php echo $row['nama_perusahaan']; ?></h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $row['posisi']; ?></h6>
                            <p class="card-text"><?php echo nl2br($row['deskripsi']); ?></p>
                            <p class="card-text"><small class="text-muted">Diposting: <?php echo date('d/m/Y', strtotime($row['tanggal_posting'])); ?></small></p>
                            
                            <!-- Tombol Aksi -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" 
                                        data-bs-target="#lamarModal<?php echo $row['id']; ?>">
                                    Lamar Sekarang
                                </button>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" 
                                        data-bs-target="#editModal<?php echo $row['id']; ?>">
                                    Edit
                                </button>
                                <a href="?menu=bursa_kerja&delete=<?php echo $row['id']; ?>" 
                                   class="btn btn-danger" 
                                   onclick="return confirm('Yakin ingin menghapus lowongan ini?')">
                                    Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Lamar -->
                <div class="modal fade" id="lamarModal<?php echo $row['id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Lamar Posisi <?php echo $row['posisi']; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="lamar">
                                    <input type="hidden" name="lowongan_id" value="<?php echo $row['id']; ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama_pelamar" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Link CV (Google Drive/Dropbox)</label>
                                        <input type="url" class="form-control" name="cv" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Lowongan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nama Perusahaan</label>
                                        <input type="text" class="form-control" name="nama_perusahaan" 
                                               value="<?php echo $row['nama_perusahaan']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Posisi</label>
                                        <input type="text" class="form-control" name="posisi" 
                                               value="<?php echo $row['posisi']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Pekerjaan</label>
                                        <textarea class="form-control" name="deskripsi" rows="4" required><?php echo $row['deskripsi']; ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-info">Belum ada lowongan tersedia.</div>
    <?php } ?>
</div>

<?php $conn->close(); ?>