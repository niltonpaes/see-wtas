<?php require base_path('views/partials/head.php') ?>

<?php
// Connect to the database using PDO
$dsn = "mysql:host=localhost:3306;dbname=seewtas";
$username = "root";
$password = "";
// $dsn = "mysql:host=localhost:8889;dbname=seewtas";
// $username = "root";
// $password = "root";

$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$pdo = new PDO($dsn, $username, $password, $options);

// Prepare the SELECT statement
// $sql = "SELECT  FROM mytable WHERE id = ?";
$sql = "SELECT * FROM reviews where path = ? and status='active'";

$stmt = $pdo->prepare($sql);

// Bind the parameter to the statement
$stmt->bindParam(1, $product);

// Execute the statement and fetch the result
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if a record exists
if (!$result) {
	dd("**** No result ***");
	die();
}
else {
	// dd($result);
	// dd($result['summary_pros']);
	// dd(json_decode($result['summary_pros']));
	// die();

	$pros = json_decode($result['pros'])->pros;
	$cons = json_decode($result['cons'])->cons;
	$prosTotal = round( ( $result['pros_total'] / ( $result['pros_total'] + $result['cons_total'] ) ) *100 , 1) . "%" ;
	$consTotal = round( ( $result['cons_total'] / ( $result['pros_total'] + $result['cons_total'] ) ) *100 , 1) . "%" ;
}
?>

<main>
	<section class="container">
		<div class="row">
			<div class="col">
				<a href="/" class="btn btn-primary btn-md rounded-3 my-2">
					<span class="d-flex align-items-center"><i class="bi bi-house-door-fill"></i></span>
				</a>
				<a href="#" class="btn btn-primary btn-md active rounded-3 my-2">
					<span class="d-flex align-items-center"><i class="bi bi-bar-chart-steps me-2"></i><span>Products</span></span>
				</a>
				<a href="#" class="btn btn-primary btn-md rounded-3 my-2">
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
							<div class="col-md-3 p-3">
								<img src="<?= $result['image'] ?>" class="img-fluid rounded-start" alt="...">
							</div>
							<div class="col-md-9 px-0 py-2 px-lg-4 py-lg-5">
								<div class="card-body px-2">
									<h2 class="card-title mb-5"><?= $result['product_title'] ?></h2>

									<div class="container">


										<div class="row">
											<div class="col-6 px-1 px-lg-3">
												<h3 class="d-flex align-items-center mb-4"><i class="fs-1 text-success bi bi-hand-thumbs-up me-2"></i><span>Pros</span></h3>
												<ul class="list-group">
													<?php 
														foreach ($pros as $item) : 
													?>
														<li class="list-group-item"><?= $item ?></li>
													<?php 
														endforeach; 
													?>

													<!-- <li class="list-group-item">An item</li>
													<li class="list-group-item">A second item</li>
													<li class="list-group-item">A third item</li>
													<li class="list-group-item">A fourth item</li>
													<li class="list-group-item">And a fifth one</li>
													<li class="list-group-item">An item</li>
													<li class="list-group-item">A second item</li>
													<li class="list-group-item">A third item</li>
													<li class="list-group-item">A fourth item</li>
													<li class="list-group-item">And a fifth one</li>
													<li class="list-group-item">An item</li>
													<li class="list-group-item">A second item</li>
													<li class="list-group-item">A third item</li>
													<li class="list-group-item">A fourth item</li>
													<li class="list-group-item">And a fifth one</li> -->
												</ul>
											</div>
											<div class="col-6 px-1 px-lg-3">
												<h3 class="d-flex align-items-center mb-4"><i class="fs-1 text-warning bi bi-hand-thumbs-down me-2"></i><span>Cons</span></h3>
												<ul class="list-group">
													<?php 
														foreach ($cons as $item) : 
													?>
														<li class="list-group-item"><?= $item ?></li>
													<?php 
														endforeach; 
													?>

													<!-- <li class="list-group-item">An item</li>
													<li class="list-group-item">A second item</li>
													<li class="list-group-item">A third item</li>
													<li class="list-group-item">A fourth item</li>
													<li class="list-group-item">And a fifth one</li>
													<li class="list-group-item">An item</li>
													<li class="list-group-item">A second item</li>
													<li class="list-group-item">A third item</li>
													<li class="list-group-item">A fourth item</li> -->
												</ul>
											</div>
										</div>

										<div class="row mt-4">
											<!-- <div class="col">
												<div class="card mb-4 rounded-3 shadow-sm">
													<div class="card-header py-3 text-center">
														<h4 class="my-0 fw-normal">Total of Reviews</h4>
													</div>
													<div class="card-body text-center">
														<h1 class="card-title pricing-card-title"><?= $fullTotalReviews ?></h1>
													</div>
												</div>
											</div> -->
											<div class="col px-1 px-lg-3">
												<div class="card mb-4 rounded-3 shadow-sm">
													<div class="card-header py-3 text-center">
														<h4 class="my-0 fw-normal">Postive Reviews</h4>
													</div>
													<div class="card-body text-center">
														<h1 class="card-title pricing-card-title"><?= $prosTotal ?></h1>
													</div>
												</div>
											</div>
											<div class="col px-1 px-lg-3">
												<div class="card mb-4 rounded-3 shadow-sm">
													<div class="card-header py-3 text-center">
														<h4 class="my-0 fw-normal">Negative Reviews</h4>
													</div>
													<div class="card-body text-center">
														<h1 class="card-title pricing-card-title"><?= $consTotal ?></h1>
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
			</div>
		</div>
	</div>
</main>

<?php require base_path('views/partials/footer.php') ?>