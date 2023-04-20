<?php

const BASE_PATH = __DIR__.'/../';
require BASE_PATH.'core/functions.php';
require base_path('core/database_connection.php');


// Set the content type to XML
header("Content-Type: application/xml; charset=utf-8");

// Start the XML sitemap
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';



// ---------------------------------------------------
// reviews
// ---------------------------------------------------
$sql = "select path from reviews where status_toprod is true";

$stmt = $pdo->prepare($sql);

// Execute the statement and fetch the result
$stmt->execute();
$resultReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);



// ---------------------------------------------------
// tweets
// ---------------------------------------------------
$sql = "select path from tweets where status_toprod is true";

$stmt = $pdo->prepare($sql);

// Execute the statement and fetch the result
$stmt->execute();
$resultTweets = $stmt->fetchAll(PDO::FETCH_ASSOC);



// ---------------------------------------------------
// create pages array
// ---------------------------------------------------
$pages = array(
    'https://www.swtas.com/',

    'https://www.swtas.com/en/',
    'https://www.swtas.com/en/products/',
    'https://www.swtas.com/en/tweets/',

    'https://www.swtas.com/ptbr/',
    'https://www.swtas.com/ptbr/products/',
    'https://www.swtas.com/ptbr/tweets/',
);
foreach ($resultReviews as $item) {
    $path = $item['path'];

    $pages[] = "https://www.swtas.com/en/product/{$path}";
    $pages[] = "https://www.swtas.com/ptbr/product/{$path}";
}
foreach ($resultTweets as $item) {
    $path = $item['path'];

    $pages[] = "https://www.swtas.com/en/tweet/{$path}";
    $pages[] = "https://www.swtas.com/ptbr/tweet/{$path}";
}



// Loop through each page and add it to the sitemap
foreach ($pages as $page) {
    echo '<url>';
    echo '<loc>' . $page . '</loc>';
    echo '<lastmod>' . date('c', time()) . '</lastmod>';
    echo '<changefreq>daily</changefreq>';
    echo '<priority>0.5</priority>';
    echo '</url>';
}

// End the XML sitemap
echo '</urlset>';


?>