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
					font-size: calc(17px + 0.6vw);
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

						<div class="d-flex align-items-center">
							<h1 class="navTitle fw-bolder mb-0 px-0 px-md-2">See what they are saying...</h1>
							<p class="blinking fw-normal mb-0 px-2 px-md-0 h-100">&#9608;</p>
						</div>
						
					</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
				</div>
			</div>
		</header>

		<main>
			<section class="py-5 text-center container">
				<div class="row py-lg-3">
					<div class="col-lg-6 col-md-8 mx-auto">
						<h2>Sorry. Page Not Found.</h2>
					</div>
				</div>
			</section>
		</main>


		<script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
	</body>
</html>
