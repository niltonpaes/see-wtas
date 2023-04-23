<?php
	if ( !isset($locale) ) {
		$locale = "en";
	}

	if (isset($dataset) && $dataset == 'product') {
		$extraInfo = 
		(isset($productTitle) ? $productTitle . ', ' : '') .
		(isset($productCompany) ? $productCompany . ', ' : '') .
		(isset($category) ? $category . ', ' : '') .
		(isset($subCategory) ? $subCategory : '');
	}
	else if (isset($dataset) && $dataset == 'tweet') {
		$extraInfo = 
		(isset($fromId) ? $fromId . ', ' : '') .
		(isset($fromName) ? $fromName . ', ' : '') .
		(isset($category) ? $category . ', ' : '') .
		(isset($subCategory) ? $subCategory : '');
	}
	else {
		$extraInfo = ""	;
	}

	$titleText = ($locale == "en") ? 
	'See what they are saying AI | Check out product reviews and Twitter threads' . ($extraInfo ? ' | ' . $extraInfo : '') :
	'Veja o que estão falando AI | Confira avaliações de produtos e threads do Twitter' . ($extraInfo ? ' | ' . $extraInfo : '');

	$descriptionText = ($locale == "en") ? 
	"Check out product reviews and twitter threads. Our AI aggregator summarizes real feedback from sales sites and Twitter posts, allowing you to stay informed quickly and easily." : 
	"Confira avaliações de produtos e threads do Twitter. Nosso agregador IA resume feedbacks reais de sites de vendas e postagens no Twitter, permitindo que você se mantenha informado de forma rápida e fácil.";

	$keywordsText = ($locale == "en") ? 
	'review, reviews, product, products, summary, tweet, twitter, AI, artificial inteligence' . ($extraInfo ? ', ' . $extraInfo : '') :
	'feedback, feedbacks, review, reviews, avaliação, avaliações, produto, produtos, resumo, tweet, twitter, AI, IA, inteligência artificial' . ($extraInfo ? ', ' . $extraInfo : '');

?>

<!DOCTYPE html>
<html lang="en">
	<head>


		<!-- Google Search - not used - using domain -->
		<!-- <meta name="google-site-verification" content="9cof43C8dbqAyRQWuUBx92H-1lC8i7NaHjxhna46ECk" /> -->

		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-TC6JEGSV21"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'G-TC6JEGSV21');
		</script>
		
		<!-- Google ADSENSE -->
		<!-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3627558445921230"
     	crossorigin="anonymous"></script> -->


		
		<title><?= $titleText ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="<?= $descriptionText ?>">
    	<meta name="keywords" content="<?= $keywordsText ?>">

		<link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet" />

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

		<!-- google fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Anton&family=Audiowide&family=Bangers&family=Bungee&family=Carter+One&family=Lobster&family=Luckiest+Guy&family=Righteous&family=Roboto:ital,wght@0,400;0,500;1,500;1,700&family=Rock+Salt&family=Turret+Road:wght@400;500;700&family=Ultra&display=swap" rel="stylesheet">

		<style>
			.bd-placeholder-img {
				font-size: 1.125rem;
				text-anchor: middle;
				-webkit-user-select: none;
				-moz-user-select: none;
				user-select: none;
			}

			@media (min-width: 768px) {
				.bd-placeholder-img-lg {
					font-size: 3.5rem;
				}
			}

			.bi {
				vertical-align: -0.125em;
				fill: currentColor;
			}

			.navTitle {
				/* font-family: 'Bangers', cursive; */
				/* font-family: 'Anton', sans-serif; */
				/* font-family: 'Audiowide', cursive; */
				/* font-family: 'Bungee', cursive; */
				/* font-family: 'Carter One', cursive; */
				/* font-family: 'Lobster', cursive; */
				/* font-family: 'Luckiest Guy', cursive; */
				/* xxx font-family: 'Righteous', cursive; */
				/* font-family: 'Roboto', sans-serif; */
				/* font-family: 'Rock Salt', cursive; */
				font-family: 'Turret Road', cursive;
				/* font-family: 'Ultra', serif; */

				/* font-size: 40px; */
				font-size: calc(26px + 0.6vw);
			}
			@media (max-width: 767px) {
				.navTitle {
					/* font-size: 20px; */
					font-size: calc(16px + 0.6vw);
				}
			}

			.logoSize {
				height:130px;
			}
			@media (max-width: 767px) {
				.logoSize {
					height:100px;
				}
			}

			.blinking {
				animation: blink 1.1s infinite;
				font-size: calc(13px + 0.6vw);
			}
			@keyframes blink {
				50% {
					opacity: 0;
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
							<h4 class="text-white"><?= ($locale == "en") ? 'About' : 'Sobre' ?></h4>
							<p class="text-white">
								<?php if ($locale == "en"): ?>
									With the help of ChatGPT/OpenAI's artificial intelligence, we are able to summarize real customer reviews posted on large sales sites and Twitter threads. This allows you to quickly find out what people are saying about a specific product or tweet without having to read through all the posts. <span class="fw-bold text-warning">We summarize what people are saying for you.<i class="bi bi-hand-thumbs-up-fill"></i></span>
								<?php else: ?>
									Com a ajuda da inteligência artificial do ChatGPT/OpenAI, somos capazes de resumir avaliações reais de clientes postadas em grandes sites de vendas e também threads do Twitter. Isso permite que você descubra rapidamente o que as pessoas estão dizendo sobre um produto específico ou tweet sem ter que ler todas as postagens. <span class="fw-bold text-warning">Nós resumimos o que as pessoas estão dizendo para você.<i class="bi bi-hand-thumbs-up-fill"></i></span>
								<?php endif; ?>
							</p>
						</div>
						<div class="col-sm-4 offset-md-1 py-4">
							<h4 class="text-white">Contact</h4>
							<ul class="list-unstyled">
								<li><a href="https://www.twitter.com/" target="_blank" class="text-white">Follow on Twitter</a></li>
								<li><a href="https://www.youtube.com/" target="_blank" class="text-white">YouTube</a></li>
								<li><a href="https://www.tiktok.com/" target="_blank" class="text-white">TikTok</a></li>
								<li><a href="mailto:swtas.ai.contact@gmail.com" target="_blank" class="text-white">Email me</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="navbar navbar-dark bg-dark shadow-sm">
				<div class="container">
					<a href="/<?= $locale ?>" class="navbar-brand d-flex flex-column flex-md-row align-items-center">
						<img class="rounded-4 logoSize" src="/images/new_logo_1_transp_bg.png" alt="...">

						<div class="d-flex align-items-center">
							<h1 class="navTitle fw-bolder mb-0 px-0 px-md-2"><?= ($locale == "en") ? 'See what they are saying AI...' : 'Veja o que estão falando AI...' ?></h1>
							<p class="blinking fw-normal mb-0 px-2 px-md-0 h-100">&#9608;</p>
						</div>
						
					</a>
					<div class="d-flex flex-column">
						<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<?php if ($locale == "en"): ?>
							<a href="/ptbr" class="text-center mt-2"><img style="width:25px" src="/images/br.svg" alt="língua: Português-BR" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Português-BR"></a>
						<?php else: ?>
							<a href="/en" class="text-center mt-2"><img style="width:25px" src="/images/en.svg" alt="Language: English" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="English"></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</header>