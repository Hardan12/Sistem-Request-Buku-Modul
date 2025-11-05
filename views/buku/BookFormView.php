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
    <title>Form Request Buku</title>
    <link rel="icon" href="../../images/Icon-Perpustakaan.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="buku.css">

</head>

<body>
    <div class="form-container">
        <h2>Form Request Buku</h2>

        <?php if (isset($_GET['success'])) : ?>
            <div class="toast show bg-success text-white" data-delay="2000">
                <div class="toast-body">
                    <i class="fas fa-check-circle"></i> Data buku berhasil disimpan. Mengalihkan ke halaman status...
                </div>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = '../status/StatusView.php';
                }, 2000);
            </script>
        <?php endif; ?>

        <?php if (isset($_GET['error'])) : ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form id="bookForm" action="../../controllers/BookController.php" method="POST">
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" class="form-control">
            </div>

            <div class="form-group">
                <label for="buku_judul">Judul Buku</label>
                <input type="text" id="buku_judul" name="buku_judul" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="buku_penerbit">Penerbit Buku</label>
                <input type="text" id="buku_penerbit" name="buku_penerbit" class="form-control">
            </div>
            <div class="form-group">
                <label for="buku_harga">Harga Buku</label>
                <input type="number" id="buku_harga" name="buku_harga" class="form-control">
            </div>
            <div class="form-group">
                <label for="buku_pengarang">Pengarang Buku</label>
                <input type="text" id="buku_pengarang" name="buku_pengarang" class="form-control">
            </div>
            <div class="form-group">
                <label for="buku_kategori">Kategori Buku</label>
                <input type="text" id="buku_kategori" name="buku_kategori" class="form-control">
            </div>
            <!-- Hidden fields for user-specific data -->
            <input type="hidden" id="nim" name="nim" value="<?php echo $_SESSION['user']['nim'] ?? ''; ?>">
            <input type="hidden" id="staff_id" name="staff_id" value="<?php echo $_SESSION['user']['staff_id'] ?? ''; ?>">
            <input type="hidden" id="nip" name="nip" value="<?php echo $_SESSION['user']['nip'] ?? ''; ?>">

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary" onclick="resetForm()">Clear</button>
               
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="buku.js"></script>
    <script>
        function resetForm() {
            document.getElementById('bookForm').reset();
        }

        function confirmBack() {
            if (confirm("Anda yakin ingin kembali? Semua perubahan akan hilang.")) {
                window.location.href = "../profil/navBar.php"; // Ganti dengan URL homepage Anda
            }
        }
    </script>
</body>

</html>

<?php
// Include footer.php
include '../profil/footer.php';
?>