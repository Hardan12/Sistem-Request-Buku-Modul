<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../../images/Icon-Perpustakaan.png">
    <title>Login</title>
</head>

<body>
    <div class="container <?php echo isset($_SESSION['success_message']) ? '' : 'right-panel-active'; ?>">
        <!-- Sign Up -->
        <div class="container__form container--signup">
            <form action="../../controllers/AuthController.php" method="POST" class="form" id="form1">
                <h2 class="form__title">Sign Up</h2>
                <?php if (isset($_SESSION['register_error'])) : ?>
                    <div class="notification error">
                        <span><?php echo $_SESSION['register_error']; ?></span>
                        <button class="notification-close" onclick="this.parentElement.style.display='none';">&times;</button>
                    </div>
                    <?php unset($_SESSION['register_error']); ?>
                <?php endif; ?>
                <select class="input" id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                    <option value="staff">Staff</option>
                </select>
                <input type="text" placeholder="Name" name="nama" class="input" required />
                <input type="text" placeholder="Username" name="username" class="input" required />
                <input type="email" placeholder="Email" name="email" class="input" required />
                <input type="password" placeholder="Password" name="password" class="input" required />
                <div id="additional-fields"></div>
                <button class="btn" name="register">Sign Up</button>
                <button class="btn btn-cancel" onclick="window.location.href='../../index.php'">Cancel</button>
            </form>
        </div>

        <!-- Sign In -->
        <div class="container__form container--signin">
            <form action="../../controllers/AuthController.php" method="POST" class="form" id="form2">
                <h2 class="form__title">Sign In</h2>
                <?php if (isset($_SESSION['login_error'])) : ?>
                    <div class="notification error">
                        <span><?php echo $_SESSION['login_error']; ?></span>
                        <button class="notification-close" onclick="this.parentElement.style.display='none';">&times;</button>
                    </div>
                    <?php unset($_SESSION['login_error']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['success_message'])) : ?>
                    <div class="notification">
                        <span><?php echo $_SESSION['success_message']; ?></span>
                        <button class="notification-close" onclick="this.parentElement.style.display='none';">&times;</button>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>
                <input type="email" placeholder="Email" name="email" class="input" required />
                <input type="password" placeholder="Password" name="password" class="input" required />

                <button class="btn" name="login">Sign In</button>
                <button class="btn btn-cancel" onclick="window.location.href='../../index.php'">Cancel</button>
            </form>
        </div>

        <!-- Overlay -->
        <div class="container__overlay">
            <div class="overlay">
                <div class="overlay__panel overlay--left">
                    <button class="btn" id="signIn">Sign In</button>
                </div>
                <div class="overlay__panel overlay--right">
                    <button class="btn" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function() {
            const role = this.value;
            const additionalFields = document.getElementById('additional-fields');
            additionalFields.innerHTML = ''; // Clear previous fields

            if (role === 'mahasiswa') {
                additionalFields.innerHTML = `
                <input type="text" placeholder="NIM" name="nim" class="input" required />
                <select name="prodi" class="input" required>
                    <option value="">Select Program Studi</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Teknologi Rekayasa Komputer">Teknologi Rekayasa Komputer</option>
                    <option value="Teknik Mesin">Teknik Mesin</option>
                    <option value="Teknik Elektro">Teknik Elektro</option>
                </select>
            `;
            } else if (role === 'dosen') {
                additionalFields.innerHTML = `
                <input type="text" placeholder="NIP" name="nip" class="input" required />
            `;
            } else if (role === 'staff') {
                additionalFields.innerHTML = `
                <input type="text" placeholder="Staff ID" name="staff_id" class="input" required />
            `;
            }
        });

        const signInButton = document.getElementById('signIn');
        const signUpButton = document.getElementById('signUp');
        const container = document.querySelector('.container');

        signInButton.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });

        signUpButton.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        // Check if there's a success message and switch to sign in form
        <?php if (isset($_SESSION['success_message'])) : ?>
            container.classList.remove('right-panel-active');
            document.querySelector('.notification').style.display = 'block';
        <?php endif; ?>
    </script>
</body>

</html>
