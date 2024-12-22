<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Alumni</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Tracer Alumni</h1>
    <form id="alumniForm">
        <label for="name">Nama:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="job_status">Status Pekerjaan:</label><br>
        <select id="job_status" name="job_status">
            <option value="Bekerja">Bekerja</option>
            <option value="Belum Bekerja">Belum Bekerja</option>
            <option value="Wirausaha">Wirausaha</option>
        </select><br><br>

        <button type="submit">Kirim</button>
    </form>

    <h2>Data Alumni</h2>
    <div id="alumniData"></div>

    <script src="script.js"></script>
</body>
</html>
