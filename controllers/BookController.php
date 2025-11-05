<?php
session_start();
require_once '../core/db.php';
require_once '../model/BookModel.php';

class BookController
{
    private $bookModel;

    public function __construct($pdo)
    {
        $this->bookModel = new BookModel($pdo);
    }

    public function saveBook()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'isbn' => $_POST['isbn'],
                'buku_judul' => $_POST['buku_judul'],
                'buku_penerbit' => $_POST['buku_penerbit'],
                'buku_harga' => $_POST['buku_harga'],
                'buku_pengarang' => $_POST['buku_pengarang'],
                'buku_kategori' => $_POST['buku_kategori'],
                'buku_status' => 'Sedang diproses',
                'nim' => null,
                'staff_id' => null,
                'nip' => null,
            ];

            // Set user-specific data based on role
            if ($_SESSION['user']['user_role'] == 'mahasiswa') {
                $data['nim'] = $_SESSION['user']['nim'];
            } elseif ($_SESSION['user']['user_role'] == 'dosen') {
                $data['nip'] = $_SESSION['user']['nip'];
            } elseif ($_SESSION['user']['user_role'] == 'staff') {
                $data['staff_id'] = $_SESSION['user']['staff_id'];
            }

            try {
                $this->bookModel->saveBook($data);
                header('Location: ../views/buku/BookFormView.php?success=1');
            } catch (Exception $e) {
                header('Location: ../views/buku/BookFormView.php?error=' . urlencode($e->getMessage()));
            }
            exit();
        }
    }
}

$bookController = new BookController($pdo);
$bookController->saveBook();
?>
