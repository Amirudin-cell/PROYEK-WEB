$(document).ready(function () {
    // Load data alumni saat halaman dimuat
    loadAlumniData();

    // Event untuk submit form
    $("#alumniForm").submit(function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post("proses.php", formData, function (response) {
            alert(response.message);
            $("#alumniForm")[0].reset();
            loadAlumniData();
        }, "json");
    });

    // Fungsi untuk memuat data alumni
    function loadAlumniData() {
        $.get("proses.php", function (data) {
            let html = "<table><thead><tr><th>Nama</th><th>Email</th><th>Status Pekerjaan</th></tr></thead><tbody>";
            if (data.length > 0) {
                $.each(data, function (index, alumni) {
                    html += `<tr>
                                <td>${alumni.name}</td>
                                <td>${alumni.email}</td>
                                <td>${alumni.job_status}</td>
                            </tr>`;
                });
            } else {
                html += `<tr><td colspan="3">Belum ada data alumni.</td></tr>`;
            }
            html += "</tbody></table>";
            $("#alumniData").html(html);
        }, "json");
    }
});
