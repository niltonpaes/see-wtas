<?php
function dd($value)
{
	// echo "<br><br><pre>";
	// var_dump($value);
	// echo "</pre><br><br>";

	// die();
}

// $a1=array("red","green");
// $a2="";
// $conc = array_merge($a1,$a2);

// dd($conc);

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="" />
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
	<meta name="generator" content="Hugo 0.108.0" />
	<title>Album example · Bootstrap v5.3</title>

	<link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

	<!-- SEO information -->
	<link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/album/" />

	<!-- google fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet" />

	<style>
		
		.bi {
			vertical-align: -0.125em;
			fill: currentColor;
		}

		.navTitle {
			font-family: 'Bangers', cursive;
			font-size: 45px;
		}

		@media (max-width: 767px) {
			.navTitle {
				font-size: 22px;
			}
		}

		.logoSize {
			height: 130px;
		}

		@media (max-width: 767px) {
			.logoSize {
				height: 100px;
			}
		}
	</style>
</head>

<body>
	<header>
		<div class="collapse bg-dark bg-gradient" id="navbarHeader">
			<div class="container">
				<div class="row">
					<div class="col-sm-8 col-md-7 py-4">
						<h4 class="text-white">About</h4>
						<p class="text-white">
							<!-- Com a ajuda da inteligência artificial do ChatGPT, somos capazes de resumir avaliações reais de clientes postadas em grandes sites de vendas e também threads do Twitter. Isso permite que você descubra rapidamente o que as pessoas estão dizendo sobre um produto específico ou tweet sem ter que ler todas as postagens. <span class="fw-bold text-warning">Nós resumimos o que as pessoas estão dizendo para você.<i class="bi bi-hand-thumbs-up-fill"></i></span> -->
							With the help of ChatGPT's artificial intelligence, we are able to summarize real customer reviews posted on large sales sites and Twitter threads. This allows you to quickly find out what people are saying about a specific product or tweet without having to read through all the posts. <span class="fw-bold text-warning">We summarize what people are saying for you.<i class="bi bi-hand-thumbs-up-fill"></i></span>
						</p>
					</div>
					<div class="col-sm-4 offset-md-1 py-4">
						<h4 class="text-white">Contact</h4>
						<ul class="list-unstyled">
							<li><a href="#" class="text-white">Follow on Twitter</a></li>
							<li><a href="#" class="text-white">Like on Facebook</a></li>
							<li><a href="#" class="text-white">Email me</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="navbar navbar-dark bg-dark shadow-sm">
			<div class="container">
				<a href="#" class="navbar-brand d-flex flex-column flex-md-row align-items-center">
					<!-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24">
					<path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
					<circle cx="12" cy="13" r="4" />
					</svg> -->
					<img class="rounded-4 logoSize" src="new_logo_1_transp_bg.png" alt="...">

					<h1><span class="px-0 px-md-3 navTitle">See what they are saying...</span></h1>
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			</div>
		</div>
	</header>

	<main>
		<section class="container">
			<div class="row">
				<div class="col">
					<a href="index.html" class="btn btn-primary btn-lg rounded-4 my-2">
						<span class="d-flex flex-column flex-md-row align-items-center"><i class="bi bi-house-door-fill"></i></span>
					</a>
					<a href="#" class="btn btn-primary btn-lg active rounded-4 my-2">
						<span class="d-flex flex-column flex-md-row align-items-center"><i class="bi bi-bar-chart-steps me-2"></i><span>Products</span></span>
					</a>
					<a href="#" class="btn btn-primary btn-lg rounded-4 my-2">
						<span class="d-flex flex-column flex-md-row align-items-center"><i class="bi bi-twitter me-2"></i><span>Tweets</span></span>
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
									<img src="https://multimedia.bbycastatic.ca/multimedia/products/500x500/161/16157/16157519.jpg" class="img-fluid rounded-start" alt="...">
								</div>
								<div class="col-md-9 px-4 py-5">
									<div class="card-body">
										<h2 class="card-title mb-5">Logitech MX Master 3S Wireless Darkfield Mouse</h2>

										<div class="container">


											<?php

											// declaring ChatGPT API
											require __DIR__ . '/vendor/autoload.php'; // remove this line if you use a PHP Framework.
											use Orhanerday\OpenAi\OpenAi;

											$keepScraping = true;
											$page = 1;

											$fullPros = [];
											$fullCons = [];
											$fullTotalReviews = 0;
											$fullPositiveReviews = 0;
											$fullNegativeReviews = 0;

											while ($keepScraping) {

												// ****************** calling BestBuy endpoit - BEGIN

												// create & initialize a curl session
												$curl = curl_init();

												// set our url with curl_setopt()
												curl_setopt($curl, CURLOPT_URL, "https://www.bestbuy.ca/api/reviews/v2/products/16157519/reviews?source=all&lang=en-CA&pageSize=15&page={$page}&sortBy=date&sortDir=desc");

												// return the transfer as a string, also with setopt()
												curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

												// curl_exec() executes the started curl session
												// $output contains the output string
												$output = curl_exec($curl);

												// close curl resource to free up system resources
												// (deletes the variable made by curl_init)
												curl_close($curl);

												$json_data = json_decode($output, true);
												$reviewsForGPT = "";

												foreach ($json_data['reviews'] as $index => $review) {
													$comment = $review['comment'];

													// cleaning the review
													$comment = str_replace("'", ' ', $comment);
													$comment = str_replace('"', ' ', $comment);
													$comment = str_replace(array("\r\n", "\r", "\n"), '', $comment);

													// appending to the list of reviews
													$reviewsForGPT = $reviewsForGPT . $page . " - " . $index . " - " . $comment . "\n\n";
												}

												// check the current page
												$currentPage = $json_data['currentPage'];

												//check total of pages
												$totalPages = $json_data['totalPages'];

												// check if the loop should keepScraping or not
												// $totalPages = 25;
												if ($currentPage == $totalPages) {
													$keepScraping = false;
												} else {
													$page = $page + 1;
												}

												// ****************** calling BestBuy endpoit - END



												// ****************** chatGPT - BEGIN

												$fullChatGPTMessage = "Summarize/consolidate the list of reviews below. \n\n";
												$fullChatGPTMessage .= "The response should have ONLY a JSON string with the following keys: \n\n";
												$fullChatGPTMessage .= "key 'pros', should contain the PROS of the product, and should not have more than 10 items. \n\n";
												$fullChatGPTMessage .= "key 'cons', should contain the CONS of the product, and should not have more than 10 items. \n\n";
												$fullChatGPTMessage .= "key 'total_reviews', should contain the number of reviews processed \n\n";
												$fullChatGPTMessage .= "key 'positive_reviews', should contain the number of positive reviews \n\n";
												$fullChatGPTMessage .= "key 'negative_reviews', should contain the number of negative reviews \n\n";
												$fullChatGPTMessage .= "List of reviews: \n\n";
												$fullChatGPTMessage .= $reviewsForGPT;

												dd($fullChatGPTMessage);

												$open_ai_key = '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';

												$open_ai = new OpenAi($open_ai_key);

												$complete = $open_ai->chat([
													'model' => 'gpt-3.5-turbo',
													'messages' => [
														[
															"role" => "system",
															"content" => "You are gonna summarize the review for a product"
														],
														[
															"role" => "user",
															"content" => $fullChatGPTMessage
														],
													],
													'temperature' => 1.0,
													'max_tokens' => 2500,
													'frequency_penalty' => 0,
													'presence_penalty' => 0,
												]);

												dd($complete);

												// getting data from the chatGPT return
												$json_data = json_decode($complete, true);
												$content = json_decode($json_data["choices"][0]["message"]["content"], true);

												// ****************** chatGPT - END



												if ( $complete !== false && !array_key_exists('error', $json_data) ) {

													// ****************** totals - BEGIN
													$fullPros = array_merge($fullPros, $content["pros"]);
													$fullCons = array_merge($fullCons, $content["cons"]);
													$fullTotalReviews = $fullTotalReviews + $content["total_reviews"];
													$fullPositiveReviews = $fullPositiveReviews + $content["positive_reviews"];
													$fullNegativeReviews = $fullNegativeReviews + $content["negative_reviews"];
													// ****************** totals - END

													// dd($fullPros);
													// dd($fullCons);
													// dd($fullTotalReviews);
													// dd($fullPositiveReviews);
													// dd($fullNegativeReviews);

													dd($content["pros"]);
													dd($content["cons"]);
													dd($content["total_reviews"]);
													dd($content["positive_reviews"]);
													dd($content["negative_reviews"]);

												}
											}


											?>



											<div class="row">
												<div class="col-6">
													<h3 class="d-flex align-items-center mb-4"><i class="fs-1 text-success bi bi-hand-thumbs-up me-2"></i><span>Pros</span></h3>
													<ul class="list-group">
														<?php foreach ($fullPros as $itemPros) : ?>
															<li class="list-group-item"><?= $itemPros ?></li>
														<?php endforeach; ?>
													</ul>
												</div>
												<div class="col-6">
													<h3 class="d-flex align-items-center mb-4"><i class="fs-1 text-warning bi bi-hand-thumbs-down me-2"></i><span>Cons</span></h3>
													<ul class="list-group">
														<?php foreach ($fullCons as $itemCons) : ?>
															<li class="list-group-item"><?= $itemCons ?></li>
														<?php endforeach; ?>
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
												<div class="col">
													<div class="card mb-4 rounded-3 shadow-sm">
														<div class="card-header py-3 text-center">
															<h4 class="my-0 fw-normal">Postive Reviews</h4>
														</div>
														<div class="card-body text-center">
															<h1 class="card-title pricing-card-title"><?= $fullPositiveReviews ?></h1>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="card mb-4 rounded-3 shadow-sm">
														<div class="card-header py-3 text-center">
															<h4 class="my-0 fw-normal">Negative Reviews</h4>
														</div>
														<div class="card-body text-center">
															<h1 class="card-title pricing-card-title"><?= $fullNegativeReviews ?></h1>
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

	<footer class="text-muted py-5">
		<div class="container">
			<p class="float-end mb-1">
				<a href="#">Back to top</a>
			</p>
			<p class="mb-1">Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
			<p class="mb-0">New to Bootstrap? <a href="/">Visit the homepage</a> or read our <a href="../getting-started/introduction/">getting started guide</a>.</p>
		</div>
	</footer>

	<script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>