<?php
// Include footer.php
include '../profil/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link rel="icon" href="Icon-Perpustakaan.png">
    <style>
       

        

       
      

        .bookshelf {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .book {
            width: 150px;
            height: 220px;
            margin: 20px;
            position: relative;
            perspective: 1000px;
        }

        .book-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            cursor: pointer;
        }

        .book:hover .book-inner {
            transform: rotateY(180deg);
        }

        .book-cover,
        .book-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            padding: 10px;
        }

        .book-cover {
            background-color: #fff;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .book-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .book-author {
            font-size: 12px;
            color: #555;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .book-back {
            background-color: #f8f9fa;
            transform: rotateY(180deg);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .book:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }

        .tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-bottom: 5px;
            padding: 5px 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            border-radius: 3px;
            font-size: 12px;
            white-space: nowrap;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .book-details {
            display: none;
            margin-top: 20px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
            transform: scale(0.9); /* Mulai dengan ukuran sedikit lebih kecil */
        }

        .book-details.active {
            display: block;
            opacity: 1;
            transform: scale(1); /* Ukuran penuh ketika ditampilkan */
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

        .status-dapat-diambil {
            color: green;
            font-weight: bold;
        }

        .status-selesai {
            color: blue;
            font-weight: bold;
        }
    </style>
    <script>
        function showBookDetails(judul) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    console.log(response); 
                    if (response.error) {
                        alert(response.error);
                    } else {
                        var statusClass = '';
                        switch (response.buku_status) {
                            case 'Sedang diproses':
                                statusClass = 'status-sedang-diproses';
                                break;
                            case 'Ditolak':
                                statusClass = 'status-ditolak';
                                break;
                            case 'Dapat diambil':
                                statusClass = 'status-dapat-diambil';
                                break;
                            case 'Selesai':
                                statusClass = 'status-selesai';
                                break;
                        }
                        document.getElementById('book-details').innerHTML = `
                            <h2>Detail Buku</h2>
                            <table class="table table-bordered">
                                <tr><th>ID</th><td>${response.buku_id}</td></tr>
                                <tr><th>ISBN</th><td>${response.isbn}</td></tr>
                                <tr><th>Judul</th><td>${response.buku_judul}</td></tr>
                                <tr><th>Penerbit</th><td>${response.buku_penerbit}</td></tr>
                                <tr><th>Harga</th><td>${response.buku_harga}</td></tr>
                                <tr><th>Pengarang</th><td>${response.buku_pengarang}</td></tr>
                                <tr><th>Kategori</th><td>${response.buku_kategori}</td></tr>
                                <tr><th>Status</th><td class="${statusClass}">${response.buku_status}</td></tr>
                            </table>
                        `;
                        var bookDetails = document.getElementById('book-details');
                        bookDetails.classList.add('active');
                        bookDetails.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            };
            xhttp.open("GET", "get_buku_details.php?judul=" + encodeURIComponent(judul), true);
            xhttp.send();
        }

        function showTooltip(event, judul) {
            var tooltip = event.currentTarget.querySelector('.tooltip');
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    tooltip.innerHTML = response.input_count + " input";
                }
            };
            xhttp.open("GET", "get_input_count.php?judul=" + encodeURIComponent(judul), true);
            xhttp.send();
        }
    </script>
</head>

<body>
    <div class="container">
        <h1 class="mb-4">Daftar Buku</h1>
        <div class="bookshelf">
            <?php
            include '../../model/buku_model.php';
            $bukuList = getAllBuku($pdo);
            foreach ($bukuList as $buku) {
                echo '<div class="book" onclick="showBookDetails(\'' . htmlspecialchars($buku['buku_judul'], ENT_QUOTES) . '\')" onmouseover="showTooltip(event, \'' . htmlspecialchars($buku['buku_judul'], ENT_QUOTES) . '\')">';
                echo '<div class="book-inner">';
                echo '<div class="book-cover">';
                echo '<div class="book-title">' . htmlspecialchars($buku['buku_judul']) . '</div>';
                echo '<div class="book-author">' . htmlspecialchars($buku['buku_pengarang']) . '</div>';
                echo '</div>';
                echo '<div class="book-back">Klik untuk melihat detail</div>';
                echo '</div>';
                echo '<div class="tooltip">Loading...</div>';
                echo '</div>';
            }
            ?>
        </div>
        <div id="book-details" class="book-details"></div>
    </div>
</body>

</html>
<?php
include '../profil/footer.php';
?>
