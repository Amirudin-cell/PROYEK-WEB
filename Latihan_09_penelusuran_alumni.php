<?php
include 'Latihan_09_config.php';

// Inisialisasi parameter pencarian
$searchQuery = "";
$searchYear = "";
$searchMajor = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchQuery = isset($_POST['search']) ? $_POST['search'] : '';
    $searchYear = isset($_POST['year']) ? $_POST['year'] : '';
    $searchMajor = isset($_POST['major']) ? $_POST['major'] : '';
}

// Membuat query SQL berdasarkan parameter pencarian
$sql = "SELECT * FROM alumni WHERE 1=1";

if (!empty($searchQuery)) {
    $sql .= " AND nama LIKE '%$searchQuery%'";
}
if (!empty($searchYear)) {
    $sql .= " AND tahun_lulus = '$searchYear'";
}
if (!empty($searchMajor)) {
    $sql .= " AND jurusan LIKE '%$searchMajor%'";
}

$result = $conn->query($sql);

// Mengambil tahun dan jurusan unik untuk dropdown filter
$yearsQuery = "SELECT DISTINCT tahun_lulus FROM alumni ORDER BY tahun_lulus DESC";
$yearsResult = $conn->query($yearsQuery);

$majorsQuery = "SELECT DISTINCT jurusan FROM alumni ORDER BY jurusan ASC";
$majorsResult = $conn->query($majorsQuery);
?>

<h3 class="text-center">PENCARIAN ALUMNI</h3>
<hr>

<!-- Form Pencarian Lanjutan -->
<div class="container mt-3">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Filter Pencarian</h5>
            <form method="POST" action="" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Nama Alumni</label>
                    <input type="text" class="form-control" name="search" id="search" 
                           placeholder="Masukkan nama..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                </div>
                <div class="col-md-4">
                    <label for="year" class="form-label">Tahun Lulus</label>
                    <select class="form-select" name="year" id="year">
                        <option value="">Semua Tahun</option>
                        <?php while($year = $yearsResult->fetch_assoc()): ?>
                            <option value="<?php echo $year['tahun_lulus']; ?>" 
                                    <?php if($searchYear == $year['tahun_lulus']) echo 'selected'; ?>>
                                <?php echo $year['tahun_lulus']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="major" class="form-label">Jurusan</label>
                    <select class="form-select" name="major" id="major">
                        <option value="">Semua Jurusan</option>
                        <?php while($major = $majorsResult->fetch_assoc()): ?>
                            <option value="<?php echo $major['jurusan']; ?>"
                                    <?php if($searchMajor == $major['jurusan']) echo 'selected'; ?>>
                                <?php echo $major['jurusan']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="?menu=salumni" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hasil Pencarian -->
<div class="container mt-4">
    <?php if ($result && $result->num_rows > 0): ?>
        <div class="alert alert-info">
            Ditemukan <?php echo $result->num_rows; ?> alumni
        </div>
        
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?php echo $row['foto']; ?>" class="card-img-top" 
                             alt="Foto <?php echo $row['nama']; ?>"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['nama']); ?></h5>
                            <p class="card-text">
                                <strong>Tahun Lulus:</strong> <?php echo htmlspecialchars($row['tahun_lulus']); ?><br>
                                <strong>Jurusan:</strong> <?php echo htmlspecialchars($row['jurusan']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            Tidak ada alumni yang ditemukan dengan kriteria pencarian tersebut.
        </div>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>