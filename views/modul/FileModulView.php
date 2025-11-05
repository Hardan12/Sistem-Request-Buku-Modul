<?php
// Include header.php
include '../profil/header.php';
?>
<?php

require_once '../../controllers/FileModulController.php';
$fileModulController = new FileModulController($pdo);
$fileList = $fileModulController->getAllFiles();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar File Modul</title>
    <link rel="icon" href="../../images/Icon-Perpustakaan.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
       



        .bookshelf {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .modul {
            width: 150px;
            height: 220px;
            margin: 20px;
            position: relative;
            perspective: 1000px;
        }

        .modul-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            cursor: pointer;
        }

        .modul:hover .modul-inner {
            transform: rotateY(180deg);
        }

        .modul-cover,
        .modul-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            padding: 10px;
        }

        .modul-cover {
            background-color: #fff;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .modul-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .modul-author {
            font-size: 12px;
            color: #555;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .modul-back {
            background-color: #f8f9fa;
            transform: rotateY(180deg);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .modul-back a {
            margin: 5px 0;
            text-decoration: none;
            color: #007bff;
        }

        .modul-back a:hover {
            text-decoration: underline;
        }

        .modul-details {
            display: none;
            margin-top: 20px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
            transform: scale(0.9);
        }

        .modul-details.active {
            display: block;
            opacity: 1;
            transform: scale(1);
            animation: zoomIn 0.5s ease-in-out;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Tambahkan kelas untuk status dengan warna berbeda */
        .status-sedang-diproses {
            color: orange;
            font-weight: bold;
        }

        .status-ditolak {
            color: red;
            font-weight: bold;
        }

        .status-dicetak {
            color: purple;
            font-weight: bold;
        }

        .status-dapat-diambil {
            color: green;
            font-weight: bold;
        }

        .status-selesai {
            color: blue;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mb-4">Daftar File Modul</h1>
        <div class="bookshelf">
            <?php
            foreach ($fileList as $file) {
                echo '<div class="modul">';
                echo '<div class="modul-inner">';
                echo '<div class="modul-cover">';
                echo '<div class="modul-title">' . htmlspecialchars($file['modul_judul']) . '</div>';
                echo '<div class="modul-author">' . htmlspecialchars($file['modul_penulis']) . '</div>';
                echo '</div>';
                echo '<div class="modul-back">';
                echo '<a href="#" class="show-details" data-id="' . $file['modul_code'] . '">Tampilkan Detail Modul</a>';
                echo '<a href="../../controllers/FileModulController.php?modul_code=' . $file['modul_code'] . '" target="_blank">Download File PDF</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
        <div id="modul-details" class="modul-details"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".show-details").forEach(function(element) {
                element.addEventListener("click", function(event) {
                    event.preventDefault();
                    var modul_code = this.getAttribute("data-id");
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            var statusClass = '';
                            switch (response.modul_status) {
                                case 'Sedang diproses':
                                    statusClass = 'status-sedang-diproses';
                                    break;
                                case 'Ditolak':
                                    statusClass = 'status-ditolak';
                                    break;
                                case 'Dicetak':
                                    statusClass = 'status-dicetak';
                                    break;
                                case 'Dapat dipinjam':
                                    statusClass = 'status-dapat-dipinjam';
                                    break;
                                case 'Selesai':
                                    statusClass = 'status-selesai';
                                    break;
                            }
                            var details = `
                                <h2>Detail Modul</h2>
                                <table class="table table-bordered">
                                    <tr><th>Kode Modul</th><td>${response.modul_code}</td></tr>
                                    <tr><th>Judul Modul</th><td>${response.modul_judul}</td></tr>
                                    <tr><th>Penulis</th><td>${response.modul_penulis}</td></tr>
                                    <tr><th>Status</th><td class="${statusClass}">${response.modul_status}</td></tr>
                                </table>
                            `;
                            var modulDetails = document.getElementById("modul-details");
                            modulDetails.innerHTML = details;
                            modulDetails.classList.add("active");
                            modulDetails.scrollIntoView({
                                behavior: "smooth"
                            });
                        }
                    };
                    xhttp.open("GET", "../../controllers/FileModulController.php?modul_code=" + modul_code + "&details=true", true);
                    xhttp.send();
                });
            });
        });
    </script>
</body>

</html>
<?php
// Include header.php
include '../profil/footer.php';
?>