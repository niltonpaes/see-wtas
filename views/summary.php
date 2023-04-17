<?php 
require base_path('views/partials/head.php');
require base_path('core/database_connection.php');
?>

<?php
// Prepare the SELECT statement
if ($dataset == "product") {
	$sql = "SELECT * FROM reviews where path = ? and status_toprod is true";
	$stmt = $pdo->prepare($sql);

	// Bind the parameter to the statement
	$stmt->bindParam(1, $path);
}
else {
	$sql = "SELECT * FROM tweets where path = ? and status_toprod is true";
	$stmt = $pdo->prepare($sql);

	// Bind the parameter to the statement
	$stmt->bindParam(1, $path);
}


// Execute the statement and fetch the result
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);


// Check if a record exists
if (!$result) {
	dd("**** No result ***");
	die();
}
else {
	if ($dataset == "product") {

		if ($locale == "en") {
			$summary = 	json_decode($result['summary_en']);
		}
		else {
			$summary = 	json_decode($result['summary_ptbr']);
		}

		$pros = $summary->pros;
		$cons = $summary->cons;
		$neutral = $summary->neutral;

		$prosTotal = $summary->prosTotal;
		$consTotal = $summary->consTotal;
		$neutralTotal = $summary->neutralTotal;

		$prosTotalPerc = round( ( $prosTotal / ( $prosTotal + $consTotal +  $neutralTotal ) ) *100 , 1) . "%" ;
		$consTotalPerc = round( ( $consTotal / ( $prosTotal + $consTotal +  $neutralTotal ) ) *100 , 1) . "%" ;
		$neutralTotalPerc = round( ( $neutralTotal / ( $prosTotal + $consTotal +  $neutralTotal ) ) *100 , 1) . "%" ;
	}
	else {
		if ($locale == "en") {
			$summary = 	json_decode($result['summary_en']);
		}
		else {
			$summary = 	json_decode($result['summary_ptbr']);
		}

		$pros = $summary->pros;
		$cons = $summary->cons;
		$neutral = $summary->neutral;

		$prosTotalPerc = $summary->prosTotal;
		$consTotalPerc = $summary->consTotal;
		$neutralTotalPerc = $summary->neutralTotal;

		$ai = $summary->ai;
	}
}
?>

<main>
	<section class="container">
		<div class="row">
			<div class="col">
				<a href="/<?= ($locale == "en") ? 'en' : 'ptbr' ?>" class="btn btn-primary btn-md rounded-3 my-2">
					<span class="d-flex align-items-center"><i class="bi bi-house-door-fill"></i></span>
				</a>
				<a href="/<?= ($locale == "en") ? 'en' : 'ptbr' ?>/products" class="btn btn-primary btn-md <?= ($dataset == "product") ? 'active' : '' ?> rounded-3 my-2">
					<span class="d-flex align-items-center"><i class="bi bi-bar-chart-steps me-2"></i><span><?= ($locale == "en") ? 'Products' : 'Produtos' ?></span></span>
				</a>
				<a href="/<?= ($locale == "en") ? 'en' : 'ptbr' ?>/tweets" class="btn btn-primary btn-md <?= ($dataset == "tweet") ? 'active' : '' ?> rounded-3 my-2">
					<span class="d-flex align-items-center"><i class="bi bi-twitter me-2"></i><span>Tweets</span></span>
				</a>
			</div>
		</div>
	</section>

	<div class="album py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="card mb-3">
						<div class="row g-0">
							<div class="col-md-9 px-0 py-2 px-lg-4 py-lg-4">
								<div class="card-body px-2">

									<div class="container">

										<?php if ($dataset == "product"): ?>
											<!-- PRODUCT IMAGE AND TITLE -->
											<div class="row align-items-center mb-4">
												<div class="col-12 col-md-4 px-1 px-lg-3">
													<img src="<?= $result['image'] ?>" class="img-fluid rounded-start" alt="...">
												</div>
												<div class="col-12 col-md-8 px-1 px-lg-3">
													<h2 class="card-title"><?= $result['product_title'] ?></h2>
												</div>
											</div>
										<?php else: ?>
											<!-- Tweet -->
											<div class="row align-items-center mb-4">
												<div class="col-12 col-md-4 px-1 px-lg-3">
													<?= $result['tweet_blockquote'] ?>
												</div>
											</div>
										<?php endif; ?>

										
										<!-- SUMMARY -->
										<div class="row">

											<!-- PROS -->
											<div class="col-12 px-1 px-lg-3 mb-2">
												<h3 class="d-flex align-items-center"><i class="fs-1 text-success bi bi-hand-thumbs-up me-2"></i><span>Pros</span></h3>
											</div>

											<?php if ($dataset == "product"): ?>
												<div class="col-12 col-md-8 px-1 px-lg-3 mb-5">
													<ul class="list-group">
														<?php foreach ($pros as $item): ?>
															<li class="list-group-item"><?= $item ?></li>
														<?php endforeach; ?>
													</ul>
												</div>
											<?php else: ?>
												<div class="col-12 col-md-8 px-1 px-lg-3 mb-5">
													<p><?= $pros ?></p>
												</div>
											<?php endif; ?>

											<div class="col-12 col-md-4 px-1 px-lg-3 mb-5">
												<div class="card mb-4 rounded-3 shadow-sm">
													<div class="card-header py-3 text-center">
														<h4 class="my-0 fw-normal">Postive Reviews</h4>
													</div>
													<div class="card-body text-center">
														<h1 class="card-title pricing-card-title"><?= $prosTotalPerc ?></h1>
													</div>
												</div>
											</div>
											

											
											<!-- CONS -->
											<div class="col-12 px-1 px-lg-3 mb-2">
												<h3 class="d-flex align-items-center"><i class="fs-1 text-warning bi bi-hand-thumbs-down me-2"></i><span>Cons</span></h3>
											</div>

											<?php if ($dataset == "product"): ?>
												<div class="col-12 col-md-8 px-1 px-lg-3 mb-5">
													<ul class="list-group">
														<?php foreach ($cons as $item): ?>
															<li class="list-group-item"><?= $item ?></li>
														<?php endforeach; ?>
													</ul>
												</div>
											<?php else: ?>
												<div class="col-12 col-md-8 px-1 px-lg-3 mb-5">
													<p><?= $cons ?></p>
												</div>
											<?php endif; ?>
											
											<div class="col-12 col-md-4 px-1 px-lg-3 mb-5">
												<div class="card mb-4 rounded-3 shadow-sm">
													<div class="card-header py-3 text-center">
														<h4 class="my-0 fw-normal">Negative Reviews</h4>
													</div>
													<div class="card-body text-center">
														<h1 class="card-title pricing-card-title"><?= $consTotalPerc ?></h1>
													</div>
												</div>
											</div>
											
											

											<!-- NEUTRALS -->
											<div class="col-12 px-1 px-lg-3 mb-2">
												<h3 class="d-flex align-items-center"><i class="fs-1 text-success bi bi-hand-thumbs-up me-2"></i><i class="fs-1 text-warning bi bi-hand-thumbs-down me-2"></i><span>Neutrals</span></h3>
											</div>

											<?php if ($dataset == "product"): ?>
												<div class="col-12 col-md-8 px-1 px-lg-3 mb-5">
													<ul class="list-group">
														<?php foreach ($neutral as $item): ?>
															<li class="list-group-item"><?= $item ?></li>
														<?php endforeach; ?>
													</ul>
												</div>
											<?php else: ?>
												<div class="col-12 col-md-8 px-1 px-lg-3 mb-5">
													<p><?= $neutral ?></p>
												</div>
											<?php endif; ?>

											<div class="col-12 col-md-4 px-1 px-lg-3 mb-5">
												<div class="card mb-4 rounded-3 shadow-sm">
													<div class="card-header py-3 text-center">
														<h4 class="my-0 fw-normal">Neutral Reviews</h4>
													</div>
													<div class="card-body text-center">
														<h1 class="card-title pricing-card-title"><?= $neutralTotalPerc ?></h1>
													</div>
												</div>
											</div>



											<!-- AI Comments -->
											<?php if ($dataset == "tweet"): ?>
												<div class="col-12 px-1 px-lg-3 mb-2">
													<h3 class="d-flex align-items-center"><i class="fs-1 text-success bi bi-chat-left-text me-2"></i><span>AI Comments</span></h3>
												</div>
											
												<div class="col-12 col-md-8 px-1 px-lg-3 mb-5">
													<p><?= $ai ?></p>
												</div>
											<?php endif; ?>

										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

<?php require base_path('views/partials/footer.php') ?>