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
				font-family: 'Bangers', cursive;
				font-size: 45px;
			}
			@media (max-width: 767px) {
				.navTitle {
					font-size: 22px;
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
										<div class="row">
											<div class="col-6">
												<h3 class="d-flex align-items-center mb-4"><i class="fs-1 text-success bi bi-hand-thumbs-up me-2"></i><span>Pros</span></h3>
												<ul class="list-group">
													<li class="list-group-item">An item</li>
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
													<li class="list-group-item">And a fifth one</li>
												</ul>

											</div>
											<div class="col-6">
												<h3 class="d-flex align-items-center mb-4"><i class="fs-1 text-warning bi bi-hand-thumbs-down me-2"></i><span>Cons</span></h3>
												<ul class="list-group">
													<li class="list-group-item">An item</li>
													<li class="list-group-item">A second item</li>
													<li class="list-group-item">A third item</li>
													<li class="list-group-item">A fourth item</li>
													<li class="list-group-item">And a fifth one</li>
													<li class="list-group-item">An item</li>
													<li class="list-group-item">A second item</li>
													<li class="list-group-item">A third item</li>
													<li class="list-group-item">A fourth item</li>
												</ul>
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
