<?php 
require base_path('views/partials/head.php');
require base_path('core/database_connection.php');
?>

<?php
// PAGINATION
// Determine the total number of products
if ($dataset == ''){
	$sql = "
	SELECT COUNT(*) AS total_records
	FROM (
	SELECT path 
	from reviews where status_toprod is true
	UNION
	SELECT path 
	from tweets where status_toprod is true
	) AS union_query;
	";
}
else if ($dataset == 'products') {
	$sql = "
	SELECT COUNT(*) AS total_records
	FROM reviews where status_toprod is true
	";
}
else if ($dataset == 'tweets') {
	$sql = "
	SELECT COUNT(*) AS total_records
	FROM tweets where status_toprod is true
	";
}

$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$totalRecords = $result['total_records'];

// Determine the current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset and limit
$recordsPerPage = 6;
$offset = ($page - 1) * $recordsPerPage;
$limit = $recordsPerPage;



// Prepare the SELECT statement
// $sql = "SELECT  FROM mytable WHERE id = ?";
// $sql = "SELECT * FROM reviews where status_ok is true";
if ($dataset == ''){
	$sql = " 
	select * from 
	(
		select 
			'reviews' as `table`,
			path,
			image,
			product_title as title,
			null as tweet_blockquote,
			summary_en,
			summary_ptbr,
			IF(
				TIMESTAMPDIFF(HOUR, created_at, NOW()) >= 24, 
				concat(FLOOR(TIMESTAMPDIFF(HOUR, created_at, NOW()) / 24) , ' day(s)'), 
				concat(FLOOR(TIMESTAMPDIFF(HOUR, created_at, NOW())) , ' hour(s)')
			)
			AS time_diff,
			TIMESTAMPDIFF(HOUR, created_at, NOW()) as time_hours_diff
		from reviews where status_toprod is true
		union
		select 
			'tweets' as `table`,
			path,
			null as image,
			concat('Tweet - ', from_id) as title,
			tweet_blockquote,
			summary_en,
			summary_ptbr,
			IF(
				TIMESTAMPDIFF(HOUR, created_at, NOW()) >= 24, 
				concat(FLOOR(TIMESTAMPDIFF(HOUR, created_at, NOW()) / 24) , ' day(s)'), 
				concat(FLOOR(TIMESTAMPDIFF(HOUR, created_at, NOW())) , ' hour(s)')
			)
			AS time_diff,
			TIMESTAMPDIFF(HOUR, created_at, NOW()) as time_hours_diff
		from tweets where status_toprod is true
		order by time_hours_diff asc
	) AS union_query
	LIMIT $offset, $limit
	";
}
else if ($dataset == 'products') {
	$sql = " 
	select 
		'reviews' as `table`,
		path,
		image,
		product_title as title,
		null as tweet_blockquote,
		summary_en,
		summary_ptbr,
		IF(
			TIMESTAMPDIFF(HOUR, created_at, NOW()) >= 24, 
			concat(FLOOR(TIMESTAMPDIFF(HOUR, created_at, NOW()) / 24) , ' day(s)'), 
			concat(FLOOR(TIMESTAMPDIFF(HOUR, created_at, NOW())) , ' hour(s)')
		)
		AS time_diff,
		TIMESTAMPDIFF(HOUR, created_at, NOW()) as time_hours_diff
	from reviews where status_toprod is true
	order by time_hours_diff asc
	LIMIT $offset, $limit
	";
}
else if ($dataset == 'tweets') {
	$sql = " 
	select 
		'tweets' as `table`,
		path,
		null as image,
		concat('Tweet - ', from_id) as title,
		tweet_blockquote,
		summary_en,
		summary_ptbr,
		IF(
			TIMESTAMPDIFF(HOUR, created_at, NOW()) >= 24, 
			concat(FLOOR(TIMESTAMPDIFF(HOUR, created_at, NOW()) / 24) , ' day(s)'), 
			concat(FLOOR(TIMESTAMPDIFF(HOUR, created_at, NOW())) , ' hour(s)')
		)
		AS time_diff,
		TIMESTAMPDIFF(HOUR, created_at, NOW()) as time_hours_diff
	from tweets where status_toprod is true
	order by time_hours_diff asc
	LIMIT $offset, $limit
	";
}


$stmt = $pdo->prepare($sql);

// Bind the parameter to the statement
// $stmt->bindParam(1, $product);

// Execute the statement and fetch the result
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if a record exists
if (!$result) {
    dd("**** No result ***");
	die();
}
?>

<main>
	<section class="py-5 text-center container">
		<div class="row py-lg-3">
			<div class="col-lg-6 col-md-8 mx-auto">

				<h2><?= ($locale == "en") ? 'Try it now!' : 'Experimente agora!' ?></h2>
 
				<p class="lead text-muted">
					<?= ($locale == "en") ? 
						"With no time or bored to read so many reviews about that product you're interested in or several posts about that tweet that caught your attention? Don't worry! We can summarize all of that for you."  
						: 
						"Sem tempo ou paciência pra ler aquele monte de reviews sobre o produto que você está interessado ou vários posts sobre aquele tweet que te chamou atenção? Não se preocupe! Nós resumimos tudo isso para você." 
					?>
				</p>
				
				<p>
					<a href="/<?= ($locale == "en") ? 'en' : 'ptbr' ?>/products" class="btn btn-primary btn-lg rounded-4 my-2 <?= ($dataset == "products") ? 'active' : '' ?>">
						<span class="d-flex align-items-center"><i class="bi bi-bar-chart-steps me-2"></i><span><?= ($locale == "en") ? 'Products' : 'Produtos' ?></span></span>
					</a>
					<a href="/<?= ($locale == "en") ? 'en' : 'ptbr' ?>/tweets" class="btn btn-primary btn-lg rounded-4 my-2 <?= ($dataset == "tweets") ? 'active' : '' ?>" >
						<span class="d-flex align-items-center"><i class="bi bi-twitter me-2"></i><span>Tweets</span></span>
					</a>
				</p>

				<form class="d-flex mt-3 mt-lg-0" role="search" method="GET" >
					<input class="form-control me-2" type="search" name="search"  placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success" type="submit">Search</button>
				</form>
			</div>
		</div>
	</section>

	<div class="album py-5 bg-light">
		<div class="container">
			<div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-3">

				<?php foreach ($result as $item): ?>

					<?php if ($item['table'] == 'reviews'): ?>
						<div class="col">
							<div class="card shadow-sm h-100">
								<div class="card-body">
									<h3 class="card-text fs-5"><?= $item['title'] ?></h3>
								
									<img class="card-img-top p-3 p-md-4" width="100%" src="<?= $item['image'] ?>" class="img-fluid" alt="..." />

									<div class="d-flex justify-content-between align-items-center py-3">
										<div class="btn-group">
											<a href="<?= "/$locale/product/{$item['path']}" ?>" class="btn btn-sm btn-primary"><?= ($locale == "en") ? 'See what they are saying' : 'Veja o que estão falando' ?></a>
										</div>
										<small class="text-muted"><?= $item['time_diff'] ?></small>
									</div>
								</div>
							</div>
						</div>
					<?php else: ?>
						<div class="col">
							<div class="card shadow-sm h-100">
								<div class="card-body">
									<h3 class="card-text fs-5"><?= $item['title'] ?></h3>

									<div>
										<?= $item['tweet_blockquote'] ?>
									</div>

									<div class="d-flex justify-content-between align-items-center py-3">
										<div class="btn-group">
											<a href="<?= "/$locale/tweet/{$item['path']}" ?>" class="btn btn-sm btn-primary"><?= ($locale == "en") ? 'See what they are saying' : 'Veja o que estão falando' ?></a>
										</div>
										<small class="text-muted"><?= $item['time_diff'] ?></small>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>

				<?php endforeach; ?>

			</div>


			<!-- PAGINATION -->
			<nav aria-label="Page navigation" class="mt-4">
				<ul class="pagination align-items-center">
					<?php
					$totalPages = ceil($totalRecords / $recordsPerPage);
					$showPages = 3;
					$middlePage = ($showPages - 1) / 2;
					
					$startPage = max(1, $page - $middlePage);
					$endPage = min($totalPages, $startPage + $showPages - 1);
					$startPage = max(1, $endPage - $showPages + 1);
					?>
					
					<li class="page-item<?php echo ($page == 1) ? ' disabled' : ''; ?>">
						<!-- <a class="page-link" href="?page=1"><i class="fs-4 bi-skip-start-btn"></i></a> -->
						<a class="page-link" href="?page=1"> << </a>
					</li>
					
					<li class="page-item<?php echo ($page == 1) ? ' disabled' : ''; ?>">
						<!-- <a class="page-link" href="?page=<?php echo $page - 1; ?>"><i class="fs-4 bi bi-skip-backward-btn"></i></a> -->
						<a class="page-link" href="?page=<?php echo $page - 1; ?>"> < </i></a>
					</li>
					
					<?php for ($i = $startPage; $i <= $endPage; $i++): ?>
						<li class="page-item<?php echo ($i == $page) ? ' active' : ''; ?>">
							<a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
						</li>
					<?php endfor; ?>
					
					<li class="page-item<?php echo ($page == $totalPages) ? ' disabled' : ''; ?>">
						<!-- <a class="page-link" href="?page=<?php echo $page + 1; ?>"><i class="fs-4 bi-skip-forward-btn"></i></a> -->
						<a class="page-link" href="?page=<?php echo $page + 1; ?>"> > </i></a>
					</li>
					
					<li class="page-item<?php echo ($page == $totalPages) ? ' disabled' : ''; ?>">
						<!-- <a class="page-link" href="?page=<?php echo $totalPages; ?>"><i class="fs-4 bi-skip-end-btn"></i></a> -->
						<a class="page-link" href="?page=<?php echo $totalPages; ?>"> >> </a>
					</li>
				</ul>
			</nav>


		</div>
	</div>
</main>

<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

<?php require base_path('views/partials/footer.php') ?>