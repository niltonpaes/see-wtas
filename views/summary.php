<?php 
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
	http_response_code(404);
	require base_path("views/404.php");
	die();
}
else {
	if ($dataset == "product") {

		// general info related to the product
		$productTitle = $result['product_title'];
		$productCompany = $result['product_company'];
		$category = ($locale == "en") ? $result['category_en'] : $result['category_ptbr'];
		$subCategory = ($locale == "en") ? $result['sub_category_en'] : $result['sub_category_ptbr'];


		if ($locale == "en") {
			$summary = 	json_decode($result['summary_en']);

			$prosText = "Pros";
			$consText = "Cons";
			$neutralText = "Neutrals";
		}
		else {
			$summary = 	json_decode($result['summary_ptbr']);

			$prosText = "Pros";
			$consText = "Cons";
			$neutralText = "Neutros";
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

		// general info related to the product
		$fromId = $result['from_id'];
		$fromName = $result['from_name'];
		$category = ($locale == "en") ? $result['category_en'] : $result['category_ptbr'];
		$subCategory = ($locale == "en") ? $result['sub_category_en'] : $result['sub_category_ptbr'];


		if ($locale == "en") {
			$summary = 	json_decode($result['summary_en']);

			$prosText = "<span class='fs-6'><small>'Kinda'</small></span> In favor/Supportive. <span class='fs-6'><small>Sometimes it's hard for the AI to tell.</small></span>";
			$consText = "<span class='fs-6'><small>'Kinda'</small></span> Against/Critical. <span class='fs-6'><small>Sometimes it's hard for the AI to tell.</small></span>";
			$neutralText = "<span class='fs-6'><small>'Kinda'</small></span> Neutral. <span class='fs-6'><small>Sometimes it's hard for the AI to tell.</small></span>";
			$aiText = "AI Comments";
		}
		else {
			$summary = 	json_decode($result['summary_ptbr']);

			$prosText = "<span class='fs-6'><small>'Mais ou menos'</small></span> A favor/Apoiador. <span class='fs-6'><small>Às vezes é difícil para a IA distinguir.</small></span>";
			$consText = "<span class='fs-6'><small>'Mais ou menos'</small></span> Contra/Crítico. <span class='fs-6'><small>Às vezes é difícil para a IA distinguir.</small></span>";
			$neutralText = "<span class='fs-6'><small>'Mais ou menos'</small></span> Neutro. <span class='fs-6'><small>Às vezes é difícil para a IA distinguir.</small></span>";
			$aiText = "Comentários da IA";
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

<?php 
require base_path('views/partials/head.php');
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
													<h2 class="card-title"><?= $productTitle ?></h2>
												</div>
											</div>
										<?php else: ?>
											<!-- Tweet -->
											<div class="row align-items-center mb-4">
												<div class="col-12 col-md-8 px-1 px-lg-3">
													<h2 class="card-title"><?= "Tweet - $fromId" ?></h2>

													<?= $result['tweet_blockquote'] ?>
												</div>
											</div>
										<?php endif; ?>

										
										<!-- SUMMARY -->
										<div class="row">

											<!-- PROS -->
											<div class="col-12 px-1 px-lg-3 mb-2">
												<h4 class="d-flex align-items-center"><i class="fs-1 text-success bi bi-hand-thumbs-up me-2"></i><span><?= $prosText ?></span></h4>
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
													<ul class="list-group">
														<?php foreach ($pros as $item): ?>
															<li class="list-group-item"><?= $item ?></li>
														<?php endforeach; ?>
													</ul>
												</div>
											<?php endif; ?>

											<div class="col-12 col-md-4 px-1 px-lg-3 mb-5">
												<div class="card mb-4 rounded-3 shadow-sm">
													<div class="card-header py-3 text-center">
														<h5 class="my-0 fw-normal">Total</h5>
													</div>
													<div class="card-body text-center">
														<h5 class="card-title pricing-card-title fw-bold fs-3"><?= $prosTotalPerc ?></h5>
													</div>
												</div>
											</div>
											

											
											<!-- CONS -->
											<div class="col-12 px-1 px-lg-3 mb-2">
												<h4 class="d-flex align-items-center"><i class="fs-1 text-warning bi bi-hand-thumbs-down me-2"></i><span><?= $consText ?></span></h4>
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
													<ul class="list-group">
														<?php foreach ($cons as $item): ?>
															<li class="list-group-item"><?= $item ?></li>
														<?php endforeach; ?>
													</ul>
												</div>
											<?php endif; ?>
											
											<div class="col-12 col-md-4 px-1 px-lg-3 mb-5">
												<div class="card mb-4 rounded-3 shadow-sm">
													<div class="card-header py-3 text-center">
														<h5 class="my-0 fw-normal">Total</h5>
													</div>
													<div class="card-body text-center">
														<h5 class="card-title pricing-card-title fw-bold fs-3"><?= $consTotalPerc ?></h5>
													</div>
												</div>
											</div>
											
											

											<!-- NEUTRALS -->
											<div class="col-12 px-1 px-lg-3 mb-2">
												<h4 class="d-flex align-items-center"><i class="fs-1 text-success bi bi-hand-thumbs-up me-2"></i><i class="fs-1 text-warning bi bi-hand-thumbs-down me-2"></i><span><span><?= $neutralText ?></span></h4>
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
													<ul class="list-group">
														<?php foreach ($neutral as $item): ?>
															<li class="list-group-item"><?= $item ?></li>
														<?php endforeach; ?>
													</ul>
												</div>
											<?php endif; ?>

											<div class="col-12 col-md-4 px-1 px-lg-3 mb-5">
												<div class="card mb-4 rounded-3 shadow-sm">
													<div class="card-header py-3 text-center">
														<h5 class="my-0 fw-normal">Total</h5>
													</div>
													<div class="card-body text-center">
														<h5 class="card-title pricing-card-title fw-bold fs-3"><?= $neutralTotalPerc ?></h5>
													</div>
												</div>
											</div>



											<!-- AI Comments -->
											<?php if ($dataset == "tweet"): ?>
												<div class="col-12 px-1 px-lg-3 mb-2">
													<h4 class="d-flex align-items-center"><i class="fs-1 text-success bi bi-chat-left-text me-2"></i><span><?= $aiText ?></span></h4>
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