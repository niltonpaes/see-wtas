<?php
    function dd($value)
    {
        echo "<br><pre>";
        var_dump($value);
        echo "</pre><br>";

        // die();
    }
?>


<?php


    // declaring ChatGPT API
    require __DIR__ . '/../../vendor/autoload.php'; // remove this line if you use a PHP Framework.
    use Orhanerday\OpenAi\OpenAi;
    $open_ai_key = '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';
    $open_ai = new OpenAi($open_ai_key);

    $complete = $open_ai->chat([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                "role" => "system",
                "content" =>  "You are going to summarize reviews."
            ],
            [
                "role" => "user",
                "content" => "hello"
            ],
        ],
        'temperature' => 1.0,
        'max_tokens' => 400,
        'frequency_penalty' => 0,
        'presence_penalty' => 0,
    ]);

    dd($complete);
    die();
    
    

    
    // ****************** GET REVIEWS FROM BESTBUY


    // MYSQL -------------------------------------------------------------------------
    //select the list of products from the MySQL
    // Connect to the database using PDO
    $dsn = "mysql:host=localhost:3306;dbname=seewtas";
    $username = "root";
    $password = "root";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $pdo = new PDO($dsn, $username, $password, $options);

    // Prepare the SELECT statement
    // $sql = "SELECT FROM mytable WHERE id = ?";
    $sql = "SELECT * FROM reviews";

    $stmt = $pdo->prepare($sql);

    // Bind the parameter to the statement
    // $stmt->bindParam(1, $product);

    // Execute the statement and fetch the result
    $stmt->execute();
    $result = $stmt->fetchAll();
    // MYSQL -------------------------------------------------------------------------


    foreach ($result as $product) {

        $productURL = $product["url_bestbuy"];

        $fullPros = [];
        $fullCons = [];
        $fullTotalReviews = 0;
        $fullPositiveReviews = 0;
        $fullNegativeReviews = 0;

        $keepScraping = true;
        $page = 1;
        $reviews = [];

        while ($keepScraping) {

            // ****************** calling BestBuy endpoit - BEGIN

            // create & initialize a curl session
            $curl = curl_init();

            // set our url with curl_setopt()
            dd(sprintf($productURL, $page));
            curl_setopt($curl, CURLOPT_URL, sprintf($productURL, $page));
            // curl_setopt($curl, CURLOPT_URL, "https://www.bestbuy.ca/api/reviews/v2/products/16157519/reviews?source=all&lang=en-CA&pageSize=20&page={$page}&sortBy=date&sortDir=desc");

            // return the transfer as a string, also with setopt()
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $certificate_location = "c:/MAMP/cacert.pem";
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $certificate_location);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $certificate_location);

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
            $totalPages = 2;
            if ($currentPage == $totalPages) {
                $keepScraping = false;
            } else {
                $page = $page + 1;
            }
        }

        dd("*************************************************************************************************************");
        dd("************************************* ALL REVIEW FROM BEST BUY **********************************************");
        dd("*************************************************************************************************************");
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

                $fullChatGPTMessage = "Take this List of reviews: \n\n";
                $fullChatGPTMessage .= $reviewsForGPT;
                $fullChatGPTMessage .= "Now, Create a valid JSON object with the following keys: \n\n";
                $fullChatGPTMessage .= "key 'pros'. This should be an array. And should contain a detailed summary of the POSITIVE points of the product, and should not have more than 5 items. \n\n";
                $fullChatGPTMessage .= "key 'cons'. This should be an array. And should contain a detailed summary of the NEGATIVE points of the product, and should not have more than 5 items. \n\n";
                $fullChatGPTMessage .= "key 'total_reviews'. This should be a number. And should contain the TOTAL number of items in the list of reviews. \n\n";
                $fullChatGPTMessage .= "key 'positive_reviews'. This should be a number. And should contain the number of POSITIVE reviews. \n\n";
                $fullChatGPTMessage .= "key 'negative_reviews'. This should be a number. And should contain the number of NEGATIVE reviews. \n\n";
                $fullChatGPTMessage .= "The responde MUST have just the JSON object, NOTHING ELSE. \n\n";


                dd("*************************************************************************************************************");
                dd("************************************* CALLING CHATGPT **********************************************");
                dd("*************************************************************************************************************");
                dd($fullChatGPTMessage);

                $complete = $open_ai->chat([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            "role" => "system",
                            "content" =>  "You are going to summarize reviews."
                        ],
                        [
                            "role" => "user",
                            "content" => $fullChatGPTMessage
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
                else {
                    dd("****************************** partial pros/cons  - FOUND ERROS ***********************************");
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


        die();



        // ****************** summarize final PROS reviews

        // ****************** chatGPT - BEGIN
        $validResponse = false;
        while(!$validResponse) {
            $reviewsForGPT = "";
            foreach ($fullPros as $index => $comment) {
                // cleaning the review
                $comment = str_replace("'", ' ', $comment);
                $comment = str_replace('"', ' ', $comment);
                $comment = str_replace(array("\r\n", "\r", "\n"), '', $comment);

                // appending to the list of reviews
                $reviewsForGPT = $reviewsForGPT . "- " . $comment . "\n\n";
            }
            $fullChatGPTMessage = "Take this List of reviews: \n\n";
            $fullChatGPTMessage .= $reviewsForGPT;
            $fullChatGPTMessage .= "Now, Create a valid JSON object with the following keys: \n\n";
            $fullChatGPTMessage .= "key 'summaryPros'. This should be an array. And should contain a detailed summary of the List of reviews, and should not have more than 20 items. \n\n";
            $fullChatGPTMessage .= "The responde MUST have just the JSON object, NOTHING ELSE. \n\n";

            dd($fullChatGPTMessage);

            $complete = $open_ai->chat([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role" => "system",
                        "content" => "You are going to summarize reviews."
                    ],
                    [
                        "role" => "user",
                        "content" => $fullChatGPTMessage
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
                dd("*********************** GOT an error Let's RETRY ***********************");
            }
        }
        dd($summaryPros);
        // ****************** chatGPT - END

        

        
        // ****************** summarize final CONS reviews

        // ****************** chatGPT - BEGIN
        $validResponse = false;
        while(!$validResponse) {
            $reviewsForGPT = "";
            foreach ($fullCons as $index => $comment) {
                // cleaning the review
                $comment = str_replace("'", ' ', $comment);
                $comment = str_replace('"', ' ', $comment);
                $comment = str_replace(array("\r\n", "\r", "\n"), '', $comment);

                // appending to the list of reviews
                $reviewsForGPT = $reviewsForGPT . "- " . $comment . "\n\n";
            }

            $fullChatGPTMessage = "Take this List of reviews: \n\n";
            $fullChatGPTMessage .= $reviewsForGPT;
            $fullChatGPTMessage .= "Now, Create a valid JSON object with the following keys: \n\n";
            $fullChatGPTMessage .= "key 'summaryCons'. This should be an array. And should contain a detailed summary of the List of reviews, and should not have more than 20 items. \n\n";
            $fullChatGPTMessage .= "The responde MUST have just the JSON object, NOTHING ELSE. \n\n";

            dd($fullChatGPTMessage);

            $complete = $open_ai->chat([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role" => "system",
                        "content" => "You are going to summarize reviews."
                    ],
                    [
                        "role" => "user",
                        "content" => $fullChatGPTMessage
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
                dd("*********************** GOT an error Let's RETRY ***********************");
            }
        }
        dd($summaryCons);
        // ****************** chatGPT - END



    }
?>