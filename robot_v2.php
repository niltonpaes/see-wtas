<?php
    function dd($value)
    {
        // echo "<br><br><pre>";
        var_dump($value);
        // echo "</pre><br><br>";

        // die();
    }

    // $a1=array("red","green");
    // $a2="";
    // $conc = array_merge($a1,$a2);

    // dd($conc);
?>


<?php

    // declaring ChatGPT API
    require __DIR__ . '/vendor/autoload.php'; // remove this line if you use a PHP Framework.
    use Orhanerday\OpenAi\OpenAi;
    $open_ai_key = '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';
    $open_ai = new OpenAi($open_ai_key);

    

    $fullPros = [];
    $fullCons = [];
    $fullTotalReviews = 0;
    $fullPositiveReviews = 0;
    $fullNegativeReviews = 0;

    $keepScraping = true;
    $page = 1;
    $reviews = [];
    // ****************** GET REVIEWS FROM BESTBUY
    while ($keepScraping) {

        // ****************** calling BestBuy endpoit - BEGIN

        // create & initialize a curl session
        $curl = curl_init();

        // set our url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, "https://www.bestbuy.ca/api/reviews/v2/products/16157519/reviews?source=all&lang=en-CA&pageSize=20&page={$page}&sortBy=date&sortDir=desc");

        // return the transfer as a string, also with setopt()
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // curl_exec() executes the started curl session
        // $output contains the output string
		$output = curl_exec($curl);

        // Check for errors
        if (curl_errno($curl)) {
            dd('cURL error: ' . curl_error($curl));
        }

        // close curl resource to free up system resources
        // (deletes the variable made by curl_init)
        curl_close($curl);

        $json_data = json_decode($output, true);

        dd("********************************* BESTBUY - Page: " . $page);

        foreach ($json_data['reviews'] as $index => $review) {
            $reviews[] = $review['comment'];
            dd($review['comment']);
        }

        // check the current page
        $currentPage = $json_data['currentPage'];

        //check total of pages
        $totalPages = $json_data['totalPages'];

        // check if the loop should keepScraping or not
        // force an end
        // $totalPages = 34;
        if ($currentPage == $totalPages) {
            $keepScraping = false;
        } else {
            $page = $page + 1;
        }
    }

    dd($reviews);




    // ****************** GET ONLY 500 review randomly
    // Length
    if (count($reviews) > 500) {
        // Get an array of 500 random keys from the original array
        $randomKeys = array_rand($reviews, 500);

        // Create a new array with the 500 random items
        $randomItems = array();
        foreach ($randomKeys as $key) {
            $randomItems[] = $reviews[$key];
        }

        $reviews = $randomItems;
    }
    


    $totalReview = count($reviews);

    $numberReviewsForGPT = 1;
    $reviewsForGPT = "";
    foreach ($reviews as $index => $comment) {

        // cleaning the review
        $comment = str_replace("'", ' ', $comment);
        $comment = str_replace('"', ' ', $comment);
        $comment = str_replace(array("\r\n", "\r", "\n"), '', $comment);

        // appending to the list of reviews
        $reviewsForGPT = $reviewsForGPT . "- " . $comment . "\n\n";



        if (($numberReviewsForGPT == 20) || ($index == $totalReview - 1)) {

            // ****************** chatGPT - BEGIN

            $fullChatGPTMessage = "Create a detailed summary list of the reviews PROVIDED by the user in a JSON format. \n\n";
            $fullChatGPTMessage .= "The response must have ONLY the JSON object with the following keys: \n\n";
            $fullChatGPTMessage .= "key 'pros', that should contain an array of the summary list of the POSITIVE points of the product, and should not have more than 5 items. \n\n";
            $fullChatGPTMessage .= "key 'cons', that should contain an array of the summary list of the NEGATIVE points of the product, and should not have more than 5 items. \n\n";
            $fullChatGPTMessage .= "key 'total_reviews', should contain the number of reviews processed. \n\n";
            $fullChatGPTMessage .= "key 'positive_reviews', should contain the number of positive reviews. \n\n";
            $fullChatGPTMessage .= "key 'negative_reviews', should contain the number of negative reviews. \n\n";

            dd("*******************************************************");
            dd($fullChatGPTMessage);
            dd("List of reviews: \n\n" . $reviewsForGPT);

            $complete = $open_ai->chat([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role" => "system",
                        "content" =>  $fullChatGPTMessage
                    ],
                    [
                        "role" => "user",
                        "content" => "List of reviews: \n\n" . $reviewsForGPT
                    ],
                ],
                'temperature' => 1.0,
                'max_tokens' => 400,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]);

            dd($complete);

            // getting data from the chatGPT return
            $json_data = json_decode($complete, true);
            $content = json_decode($json_data["choices"][0]["message"]["content"], true);

            // ****************** chatGPT - END


                
            if ( $complete !== false && !array_key_exists('error', $json_data) && $content["pros"] && $content["cons"] && $content["total_reviews"] && $content["positive_reviews"] && $content["negative_reviews"]) {
                // ****************** TOTALS - BEGIN
                $fullPros = array_merge($fullPros, $content["pros"]);
                $fullCons = array_merge($fullCons, $content["cons"]);
                $fullTotalReviews = $fullTotalReviews + $content["total_reviews"];
                $fullPositiveReviews = $fullPositiveReviews + $content["positive_reviews"];
                $fullNegativeReviews = $fullNegativeReviews + $content["negative_reviews"];
                // ****************** TOTALS - END

                dd("****************************** partial pros/cons ***********************************");
                dd($content["pros"]);
                dd($content["cons"]);
                dd($content["total_reviews"]);
                dd($content["positive_reviews"]);
                dd($content["negative_reviews"]);
            }



            $numberReviewsForGPT = 0;
            $reviewsForGPT = "";

        }

        $numberReviewsForGPT = $numberReviewsForGPT + 1;

    }




    dd("****************************** full pros/cons ***********************************");
    dd($fullPros);
    dd($fullCons);
    dd($fullTotalReviews);
    dd($fullPositiveReviews );
    dd($fullNegativeReviews );




    // ****************** summarize final PROS reviews

    // ****************** chatGPT - BEGIN
    $validResponse = false;
    while($validResponse) {
        $reviewsForGPT = "";
        foreach ($fullPros as $index => $comment) {
            // cleaning the review
            $comment = str_replace("'", ' ', $comment);
            $comment = str_replace('"', ' ', $comment);
            $comment = str_replace(array("\r\n", "\r", "\n"), '', $comment);

            // appending to the list of reviews
            $reviewsForGPT = $reviewsForGPT . "- " . $comment . "\n\n";
        }
        $fullChatGPTMessage = "Summarize, consolidate, merge, combine the list of the reviews PROVIDED by the user in a JSON format. \n\n";
        $fullChatGPTMessage .= "The response must have ONLY the JSON object with a key named 'summaryPros' that should contain an array with the summarized list, and must not have more than 20 items. \n\n";

        dd($fullChatGPTMessage);
        dd("List of reviews: \n\n" . $reviewsForGPT);

        $complete = $open_ai->chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    "role" => "system",
                    "content" => $fullChatGPTMessage
                ],
                [
                    "role" => "user",
                    "content" => "List of reviews: \n\n" . $reviewsForGPT
                ],
            ],
            'temperature' => 1.0,
            'max_tokens' => 400,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        dd($complete);

        // getting data from the chatGPT return
        $json_data = json_decode($complete, true);
        $content = json_decode($json_data["choices"][0]["message"]["content"], true);

        $summaryPros = [];
        if ($complete !== false && !array_key_exists('error', $json_data) && $content["summaryPros"]) {
            $summaryPros = $content["summaryPros"];
            $validResponse = true;
        }
        else {
            dd("*********************** RETRY ***********************");
        }
        dd($summaryPros);
    }
    // ****************** chatGPT - END

    

    
    // ****************** summarize final CONS reviews

    // ****************** chatGPT - BEGIN
    $validResponse = false;
    while($validResponse) {
        $reviewsForGPT = "";
        foreach ($fullCons as $index => $comment) {
            // cleaning the review
            $comment = str_replace("'", ' ', $comment);
            $comment = str_replace('"', ' ', $comment);
            $comment = str_replace(array("\r\n", "\r", "\n"), '', $comment);

            // appending to the list of reviews
            $reviewsForGPT = $reviewsForGPT . "- " . $comment . "\n\n";
        }
        $fullChatGPTMessage = "Summarize, consolidate, merge and combine the list of the reviews PROVIDED by the user in a JSON format \n\n";
        $fullChatGPTMessage .= "The response must have ONLY the JSON object with a key named 'summaryCons' that should contain an array with the summarized list, and must not have more than 20 items. \n\n";

        dd($fullChatGPTMessage);
        dd("List of reviews: \n\n" . $reviewsForGPT);

        $complete = $open_ai->chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    "role" => "system",
                    "content" => $fullChatGPTMessage
                ],
                [
                    "role" => "user",
                    "content" => "List of reviews: \n\n" . $reviewsForGPT
                ],
            ],
            'temperature' => 1.0,
            'max_tokens' => 400,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        dd($complete);

        // getting data from the chatGPT return
        $json_data = json_decode($complete, true);
        $content = json_decode($json_data["choices"][0]["message"]["content"], true);

        $summaryCons = [];
        if ( $complete !== false && !array_key_exists('error', $json_data) && $content["summaryCons"]) {
            $summaryCons = $content["summaryCons"];
            $validResponse = true;
        }
        else {
            dd("*********************** RETRY ***********************");
        }
        dd($summaryCons);
    }
    // ****************** chatGPT - END

?>