<?php
// Include header.php
include '../profil/header.php';
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/auth.php');
    exit();
}

require_once '../../controllers/UserProfileController.php';
$userProfileController = new UserProfileController($pdo);

$user = $userProfileController->getUser($_SESSION['user']['user_id'], $_SESSION['user']['user_role']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="icon" href="../../images/Icon-Perpustakaan.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
       
        .kontainer {
            max-width: 600px;
            background: #fff;
            padding: 30px;
            margin: 50px auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            animation: fadeInUp 1s ease-out;
            transition: transform 0.3s ease-out;
        }
        .kontainer:hover {
            transform: scale(1.05);
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }
        .form-group label {
            font-weight: bold;
            color: #555;
            transition: color 0.3s;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
        }
        .btn-primary {
            background: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background 0.3s, transform 0.3s;
        }
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        .password-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .password-toggle img {
            width: 20px;
            height: 20px;
            transition: transform 0.3s;
        }
        .password-toggle img:hover {
            transform: scale(1.2);
        }
        .alert-success {
            animation: fadein 1s, fadeout 1s 4s;
        }
        @keyframes fadein {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeout {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="kontainer mt-5">
        <h2>Profil Pengguna</h2>

        <?php if (isset($_GET['success'])) : ?>
            <div class="alert alert-success">Data berhasil diperbarui.</div>
        <?php endif; ?>

        <form action="../../controllers/UserProfileController.php" method="POST">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" class="form-control" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>

            <div class="form-group password-container">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" value="<?php echo htmlspecialchars($user['password']); ?>" required>
                <span class="password-toggle" onclick="togglePasswordVisibility()">
                    <img src="https://img.icons8.com/ios-glyphs/30/000000/visible.png" id="toggle-icon"/>
                </span>
            </div>

            <?php if ($_SESSION['user']['user_role'] == 'mahasiswa') : ?>
                <div class="form-group">
                    <label for="prodi">Program Studi</label>
                    <input type="text" id="prodi" name="prodi" class="form-control" value="<?php echo htmlspecialchars($user['prodi']); ?>" required>
                </div>
            <?php endif; ?>

            <?php if ($_SESSION['user']['user_role'] == 'mahasiswa') : ?>
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" id="nim" name="nim" class="form-control" value="<?php echo htmlspecialchars($user['user_id']); ?>" readonly>
                </div>
            <?php elseif ($_SESSION['user']['user_role'] == 'dosen') : ?>
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" id="nip" name="nip" class="form-control" value="<?php echo htmlspecialchars($user['user_id']); ?>" readonly>
                </div>
            <?php elseif ($_SESSION['user']['user_role'] == 'staff') : ?>
                <div class="form-group">
                    <label for="staff_id">Staff ID</label>
                    <input type="text" id="staff_id" name="staff_id" class="form-control" value="<?php echo htmlspecialchars($user['user_id']); ?>" readonly>
                </div>
            <?php endif; ?>

            <button type="submit" name="update_profile" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var passwordToggle = document.getElementById("toggle-icon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordToggle.src = "https://img.icons8.com/ios-glyphs/30/000000/invisible.png";
            } else {
                passwordField.type = "password";
                passwordToggle.src = "https://img.icons8.com/ios-glyphs/30/000000/visible.png";
            }
        }
    </script>
</body>
</html>


<?php
// Include header.php
include '../profil/footer.php';
?>