<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['user_role'] !== 'staff') {
    header('Location: ../auth/auth.php');
    exit();
}

require_once __DIR__ . '/../../controllers/ManageStatusController.php';
$manageStatusController = new ManageStatusController($pdo);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10; // Default limit is 10
$order = isset($_GET['order']) ? $_GET['order'] : 'latest'; // Default order is latest

$bookRequests = $manageStatusController->getAllBookRequests($page, $limit, $search, $order);
$totalBookRequests = $manageStatusController->countAllBookRequests($search);
$totalBookPages = ceil($totalBookRequests / $limit);
?>

<?php include '../profil/header.php'; ?>
<style>
    .form-group {
        display: flex;
        align-items: center;
    }

    .form-group label {
        margin-right: 10px;
    }

    #limit, #order {
        width: auto; 
        display: inline-block; 
    }

    .pagination {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        margin-top: 20px;
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
</style>

<body class="hero-anime">
    <div class="container">
        <h2>Manage Book Requests</h2>
        <form action="" method="GET">
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary ml-2">Search</button>
            </div>
        </form>
        
        <form action="" method="GET" id="limitForm">
            <div class="form-group">
                <label for="limit">Show</label>
                <select name="limit" id="limit" class="form-control" onchange="document.getElementById('limitForm').submit();">
                    <option value="5" <?php if ($limit == 5) echo 'selected'; ?>>5</option>
                    <option value="10" <?php if ($limit == 10) echo 'selected'; ?>>10</option>
                    <option value="20" <?php if ($limit == 20) echo 'selected'; ?>>20</option>
                    <option value="50" <?php if ($limit == 50) echo 'selected'; ?>>50</option>
                </select>
                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <input type="hidden" name="page" value="<?php echo htmlspecialchars($page); ?>">
                <input type="hidden" name="order" value="<?php echo htmlspecialchars($order); ?>">
            </div>
        </form>

        <form action="" method="GET" id="orderForm">
            <div class="form-group">
                <label for="order">Sort by</label>
                <select name="order" id="order" class="form-control" onchange="document.getElementById('orderForm').submit();">
                    <option value="latest" <?php if ($order == 'latest') echo 'selected'; ?>>Latest</option>
                    <option value="oldest" <?php if ($order == 'oldest') echo 'selected'; ?>>Oldest</option>
                </select>
                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <input type="hidden" name="page" value="<?php echo htmlspecialchars($page); ?>">
                <input type="hidden" name="limit" value="<?php echo htmlspecialchars($limit); ?>">
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Requester</th>
                        <th>Role</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 + ($page - 1) * $limit;
                    foreach ($bookRequests as $request) : ?>
                        <tr>
                            <td><?php echo $no; $no++ ?></td>
                            <td><?php echo $request['title']; ?></td>
                            <td><?php echo $request['status']; ?></td>
                            <td><?php echo $request['requester_name']; ?></td>
                            <td><?php echo ucfirst($request['requester_role']); ?></td>
                            <td><?php echo ucfirst($request['type']); ?></td>
                            <td>
                                <form action="../../controllers/ManageStatusController.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $request['id']; ?>">
                                    <input type="hidden" name="type" value="<?php echo $request['type']; ?>">
                                    <select name="status" class="form-control">
                                        <option value="Sedang diproses" <?php if ($request['status'] == 'Sedang diproses') echo 'selected'; ?>>Sedang diproses</option>
                                        <option value="Ditolak" <?php if ($request['status'] == 'Ditolak') echo 'selected'; ?>>Ditolak</option>
                                        <option value="Dapat diambil" <?php if ($request['status'] == 'Dapat diambil') echo 'selected'; ?>>Dapat diambil</option>
                                        <option value="Selesai" <?php if ($request['status'] == 'Selesai') echo 'selected'; ?>>Selesai</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&order=<?php echo $order; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalBookPages; $i++) : ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&limit=<?php echo $limit; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&order=<?php echo $order; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalBookPages) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>&order=<?php echo $order; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <?php include '../profil/footer.php'; ?>
</body>
</html>
