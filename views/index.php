<?php 
require base_path('views/partials/head.php');
require base_path('core/database_connection.php');
?>

<?php
// Prepare the SELECT statement
// $sql = "SELECT  FROM mytable WHERE id = ?";
// $sql = "SELECT * FROM reviews where status_ok is true";
if ($dataset == ''){
	$sql = " 
	select 
		'reviews' as `table`,
		path,
		image,
		product_title,
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
		null product_title,
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
	order by time_hours_diff
	";
}
else if ($dataset == 'products') {
	$sql = " 
	select 
		'reviews' as `table`,
		path,
		image,
		product_title,
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
	order by time_hours_diff
	";
}
else if ($dataset == 'tweets') {
	$sql = " 
	select 
		'tweets' as `table`,
		path,
		null as image,
		null product_title,
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
	order by time_hours_diff
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
						"Tired of reading too many reviews about that product you're interested in or several posts about that tweet that caught your attention? Don't worry! We can summarize all of that for you."  
						: 
						"Cansado de ler aquele monte de reviews sobre o produto que você está interessado ou vários posts sobre aquele tweet que te chamou atenção? Não se preocupe! Nós resumimos tudo isso para você." 
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
								<img class="card-img-top p-3 p-md-4" width="100%" src="<?= $item['image'] ?>" class="img-fluid" alt="..." />
								<div class="card-body">
									<p class="card-text"><?= $item['product_title'] ?></p>

									<div class="d-flex justify-content-between align-items-center">
										<div class="btn-group">
											<a href="<?= "/$locale/product/{$item['path']}" ?>" class="btn btn-sm btn-outline-secondary"><?= ($locale == "en") ? 'View' : 'Visualizar' ?></a>
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
									<div>
										<?= $item['tweet_blockquote'] ?>
									</div>

									<div class="d-flex justify-content-between align-items-center">
										<div class="btn-group">
											<a href="<?= "/$locale/tweet/{$item['path']}" ?>" class="btn btn-sm btn-outline-secondary"><?= ($locale == "en") ? 'View' : 'Visualizar' ?></a>
										</div>
										<small class="text-muted"><?= $item['time_diff'] ?></small>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>

				<?php endforeach; ?>

			</div>
		</div>
	</div>
</main>

<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

<?php require base_path('views/partials/footer.php') ?>