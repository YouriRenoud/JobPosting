<?php
$pageTitle = "Home";
include '../app/Views/partials/header.php';

require_once '../app/controllers/JobsController.php';
require_once '../app/controllers/CategoriesController.php';
require_once '../app/controllers/AdminController.php';

$jobsController = new JobsController();
$categoriesController = new CategoriesController();

$jobsPerPage = 12;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $jobsPerPage;

$totalJobs = 0;

$categories = $categoriesController->getAllCategories();

$keyword = $_GET['keyword'] ?? null;
$category_id = $_GET['category_id'] ?? null;

if (!empty($keyword)) {
    // To search approved job postings with pagination from offset to limit
    $jobs = $jobsController->searchJobsPaginated($keyword, $jobsPerPage, $offset);

    $totalJobs = $jobsController->countSearchJobs($keyword);
} elseif (!empty($category_id)) {
    // To get job postings by category with pagination from offset to limit
    $jobs = $jobsController->showByCategoryPaginated($category_id, $jobsPerPage, $offset);

    $totalJobs = $jobsController->countJobsByCategory($category_id);
} else {
    // To list approved job postings with pagination from offset to limit
    $jobs = $jobsController->listApprovedJobsPaginated($jobsPerPage, $offset);

    $totalJobs = $jobsController->countApprovedJobs();
}

// Round up total pages: 13 jobs (13/12 = 1.08) -> 2 pages
$totalPages = ceil($totalJobs / $jobsPerPage);
?>

<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') { 
    $adminController = new AdminController();
    $stats = $adminController->getStats();
    ?>
    <section class="text-center py-5 bg-white shadow-sm rounded mb-4">
        <h1 class="fw-bold mb-3">Stats of JobFinder</h1>
        <p class="text-muted mb-4">Total Jobs: <?= $stats['total_jobs'] ?></p>
        <p class="text-muted mb-4">Total Pending Jobs: <?= $stats['pending_jobs'] ?></p>
        <p class="text-muted mb-4">Total Users: <?= $stats['users_number'] ?></p>
        <p class="text-muted mb-4">Total Employers: <?= $stats['active_employers'] ?></p>
    </section>
<?php } ?>

<section class="text-center py-5 bg-white shadow-sm rounded mb-4">
    <h1 class="fw-bold mb-3">Find Your Next Opportunity</h1>
    <p class="text-muted mb-4">Browse thousands of job openings from top companies.</p>
    <form class="d-flex justify-content-center" method="get" action="">
        <input type="text" name="keyword" value="<?= htmlspecialchars($keyword ?? '') ?>"
                class="form-control w-50 me-2" placeholder="Search by title, keyword, location or company">
        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
    </form>
</section>

<section class="my-5">
    <h2 class="text-center mb-4"><i class="fa-solid fa-layer-group"></i> Popular Categories</h2>
    <div class="row text-center">
        <?php foreach ($categories as $cat): ?>
            <div class="col-md-2 col-6 mb-3">
                <a  href="<?= (isset($category_id) && $category_id == $cat['id']) ? 'index.php' : 'index.php?category_id=' . $cat['id'] ?>"
                    class="btn <?= (isset($category_id) && $category_id == $cat['id']) ? 'btn-primary' : 'btn-outline-primary' ?> w-100">
                    <?= htmlspecialchars($cat['category_name']) ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="my-5">
    <h2 class="text-center mb-4"><i class="fa-solid fa-briefcase"></i>
        <?php
        if ($keyword) echo "Search results for “" . htmlspecialchars($keyword) . "”";
        elseif ($category_id) echo "Jobs in selected category";
        else echo "Latest Job Listings";
        ?>
    </h2>

    <?php if (empty($jobs)): ?>
        <p class="text-center text-muted">No jobs found matching your criteria.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($jobs as $job): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($job['title']) ?></h5>
                            <p class="text-muted mb-1">
                                <i class="fa-solid fa-building"></i> <?= htmlspecialchars($job['company_name']) ?>
                            </p>
                            <p class="text-muted">
                                <i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($job['location']) ?>
                            </p>
                            <p class="small"><?= htmlspecialchars(substr($job['description'], 0, 100)) ?>...</p>
                            <a href="../app/Views/jobs/show.php?id=<?= $job['id'] ?>" class="btn btn-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <nav aria-label="Job pagination">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link"
                        href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                        <?= $i ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</section>

<?php include '../app/Views/partials/footer.php'; ?>