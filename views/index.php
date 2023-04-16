<?php require base_path('views/partials/head.php') ?>

<?php
// ******************** MYSQL CONFIGURATION ********************
// --- PC 
// $dsn = "mysql:host=localhost:3306;dbname=seewtas";
// $username = "root";
// $password = "";
// --- MAC
$dsn = "mysql:host=localhost:8889;dbname=seewtas";
$username = "root";
$password = "root";

$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$pdo = new PDO($dsn, $username, $password, $options);

// Prepare the SELECT statement
// $sql = "SELECT  FROM mytable WHERE id = ?";
$sql = "SELECT * FROM reviews where status_ok  is true";

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

				<h2>Try it now!</h2>
				<!-- <h2>Experimente agora!</h2> -->

				<p class="lead text-muted">Tired of reading too many reviews about that product you're interested in or several posts about that tweet that caught your attention? Don't worry! We can summarize all of that for you.</p>
				<!-- <p class="lead text-muted">Está cansado de ler muitos reviews sobre aquele produto que você está interessado ou vários posts sobre aquele tweet que chamou sua atenção? Não se preocupe! Nós podemos resumir tudo isso para você.</p> -->
				<p>
					<a href="#" class="btn btn-primary btn-lg rounded-4 my-2">
						<span class="d-flex align-items-center"><i class="bi bi-bar-chart-steps me-2"></i><span>Products</span></span>
					</a>
					<a href="#" class="btn btn-primary btn-lg rounded-4 my-2">
						<span class="d-flex align-items-center"><i class="bi bi-twitter me-2"></i><span>Tweets</span></span>
					</a>
				</p>
			</div>
		</div>
	</section>

	<div class="album py-5 bg-light">
		<div class="container">
			<div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-3">


				<!-- <div class="col">
					<div class="card shadow-sm">
						<img class="card-img-top" width="100%" src="https://multimedia.bbycastatic.ca/multimedia/products/500x500/161/16157/16157519.jpg" class="img-fluid" alt="..." />
						<div class="card-body">
							<p class="card-text">Logitech MX Master 3S Wireless Darkfield Mouse</p>

							<div class="d-flex justify-content-between align-items-center">
								<div class="btn-group">
									<a href="/en/products/logitech-mx-master-3s" class="btn btn-sm btn-outline-secondary">View</a>
								</div>
								<small class="text-muted">9 mins</small>
							</div>
						</div>
					</div>
				</div> -->

				<div class="col">
					<div class="card shadow-sm h-100">
						<div class="card-body">
							<div>
								<blockquote class="twitter-tweet"><p lang="en" dir="ltr">Cash Money goes Flying after a Renegade Cop Eliminates a Woman with &#39;The Rock Bottom&#39; during a Chaotic Rumble... <a href="https://t.co/SJCmIoIh2R">pic.twitter.com/SJCmIoIh2R</a></p>&mdash; Fight Haven (@FightHaven) <a href="https://twitter.com/FightHaven/status/1642874603545706498?ref_src=twsrc%5Etfw">April 3, 2023</a></blockquote>
								<!-- <blockquote class="twitter-tweet">
									<p lang="pt" dir="ltr">Estão com vergonha de postar o gol da classificação????<br />Posta aí ????</p>
									&mdash; Ronaldo Giovaneli (@Ronaldo601) <a href="https://twitter.com/Ronaldo601/status/1637564460532482048?ref_src=twsrc%5Etfw">March 19, 2023</a>
								</blockquote>
								<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> -->
							</div>

							<div class="d-flex justify-content-between align-items-center">
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-outline-secondary">View</button>
								</div>
								<small class="text-muted">9 mins</small>
							</div>
						</div>
					</div>
				</div>

				<?php foreach ($result as $item) : ?>

					<div class="col">
						<div class="card shadow-sm h-100">
							<img class="card-img-top p-3 p-md-4" width="100%" src="<?= $item['image'] ?>" class="img-fluid" alt="..." />
							<div class="card-body">
								<p class="card-text"><?= $item['product_title'] ?></p>

								<div class="d-flex justify-content-between align-items-center">
									<div class="btn-group">
										<!-- <a href="/en/products/logitech-mx-master-3s" class="btn btn-sm btn-outline-secondary">View</a> -->
										<a href="<?= "/en/products/{$item['path']}" ?>" class="btn btn-sm btn-outline-secondary">View</a>
									</div>
									<small class="text-muted">9 mins</small>
								</div>
							</div>
						</div>
					</div>

				<?php endforeach; ?>

				<div class="col">
					<div class="card shadow-sm h-100">
						<div class="card-body">
							<div>
								<!-- <blockquote class="twitter-tweet"><p lang="en" dir="ltr">Cash Money goes Flying after a Renegade Cop Eliminates a Woman with &#39;The Rock Bottom&#39; during a Chaotic Rumble... <a href="https://t.co/SJCmIoIh2R">pic.twitter.com/SJCmIoIh2R</a></p>&mdash; Fight Haven (@FightHaven) <a href="https://twitter.com/FightHaven/status/1642874603545706498?ref_src=twsrc%5Etfw">April 3, 2023</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> -->
								<!-- <blockquote class="twitter-tweet">
									<p lang="pt" dir="ltr">Estão com vergonha de postar o gol da classificação????<br />Posta aí ????</p>
									&mdash; Ronaldo Giovaneli (@Ronaldo601) <a href="https://twitter.com/Ronaldo601/status/1637564460532482048?ref_src=twsrc%5Etfw">March 19, 2023</a>
								</blockquote>
								<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> -->
								<blockquote class="twitter-tweet"><p lang="pt" dir="ltr">O cancelamento da Feira Israelense na UNICAMP por conta de manifestações contrárias é um episódio muito triste. Inviabilizaram um evento só pela participação de Israel. Isso é inaceitável. Há muito tempo nossas Universidades deixaram de ser ambientes democráticos.<br><br>Não é de hoje…</p>&mdash; Kim Kataguiri (@KimKataguiri) <a href="https://twitter.com/KimKataguiri/status/1643242411542425605?ref_src=twsrc%5Etfw">April 4, 2023</a></blockquote> 
							</div>

							<div class="d-flex justify-content-between align-items-center">
								<div class="btn-group">
									<button type="button" class="btn btn-sm btn-outline-secondary">View</button>
								</div>
								<small class="text-muted">9 mins</small>
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