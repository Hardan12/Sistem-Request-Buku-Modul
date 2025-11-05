<?php
session_start();

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['user_role'], ['mahasiswa', 'dosen'])) {
    header('Location: ../auth/auth.php');
    exit();
}

require_once __DIR__ . '/../../controllers/StatusController.php';
$statusController = new StatusController($pdo);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';

$statuses = $statusController->getStatusByUser($page, $search, $_SESSION['user']['user_id'], $_SESSION['user']['user_role']);

$total_status = $statusController->countAllRequests($search, $_SESSION['user']['user_id'], $_SESSION['user']['user_role']);
$total_pages = ceil($total_status / 10); // 10 requests per page
?>

<?php
// Include header.php
include '../profil/header.php';
?>
<style>
    .pagination {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
       
    }

    .pagination a {
        color: #007bff;
        text-decoration: none;
        border: 1px solid #ddd;
        padding: 8px 16px;
        margin: 0 4px;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .pagination a:hover {
        background-color: #007bff;
        color: white;
    }

    .pagination a.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination a.disabled {
        color: #ccc;
        pointer-events: none;
        cursor: not-allowed;
    }

    .status {
        padding: 5px 10px;
        border-radius: 4px;
        color: white;
    }

    .status.sedang-diproses {
        background-color: orange;
    }

    .status.ditolak {
        background-color: red;
    }

    .status.dapat-dipinjam {
        background-color: green;
    }

    .status.selesai {
        background-color: blue;
    }

    .status.dicetak {
        background-color: purple;
    }
    .status.dapat-diambil {
        background-color: blue;
    }
</style>

<body class="hero-anime">

<div class="container">
    <h2>Status Requests</h2>
    <form action="" method="GET">
        <div class="form-group">
            <input type="text" class="form-control" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Search</button>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($statuses as $status) : ?>
                    <tr>
                        <td><?php echo $no; $no++; ?></td>
                        <td><?php echo $status['title']; ?></td>
                        <td><?php echo ucfirst($status['type']); ?></td>
                        <td><span class="status <?php echo strtolower(str_replace(' ', '-', $status['status'])); ?>"><?php echo $status['status']; ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1) : ?>
            <a href="?page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <a <?php if ($i == $page) echo 'class="active"'; ?> href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages) : ?>
            <a href="?page=<?php echo $page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">Next</a>
        <?php endif; ?>
    </div>
</div>

</body>
<?php
// Include footer.php
include '../profil/footer.php';
?>
