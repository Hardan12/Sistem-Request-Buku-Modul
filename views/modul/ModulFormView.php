<?php
session_start();

?>
<?php
// Include header.php
include '../profil/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Form Request Modul</title>
    <link rel="icon" href="../../images/Icon-Perpustakaan.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="modul.css">
    <style>
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 200px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Form Request Modul</h2>

        <!-- Tampilkan pesan sukses atau error -->
        <?php if (isset($_GET['success'])) : ?>
            <div class="toast show bg-success text-white" data-delay="2000">
                <div class="toast-body">
                    Data modul berhasil disimpan. Mengalihkan ke ke halaman status...
                </div>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = '../status/StatusView.php';
                }, 2000);
            </script>
        <?php endif; ?>

        <?php if (isset($_GET['error'])) : ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <form id="modulForm" action="../../controllers/ModulController.php?action=save" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="modul_judul">Judul Modul</label>
                <input type="text" id="modul_judul" name="modul_judul" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="modul_penulis">Penulis Modul</label>
                <input type="text" id="modul_penulis" name="modul_penulis" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="modul_file">File Modul</label>
                <input type="file" id="modul_file" name="modul_file" class="form-control" required>
            </div>
            <!-- Hidden fields for user-specific data -->
            <input type="hidden" id="nip" name="nip" value="<?php echo $_SESSION['user']['nip'] ?? ''; ?>">
            <input type="hidden" id="staff_id" name="staff_id" value="<?php echo $_SESSION['user']['staff_id'] ?? ''; ?>">

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary" onclick="resetForm()">Clear</button>
               
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function resetForm() {
            document.getElementById('modulForm').reset();
        }

        function confirmBack() {
            if (confirm("Anda yakin ingin kembali? Semua perubahan akan hilang.")) {
                window.location.href = "../profil/navBar.php"; // Ganti dengan URL homepage Anda
            }
        }
    </script>
</body>
<?php
include '../profil/footer.php';
?>

</html>