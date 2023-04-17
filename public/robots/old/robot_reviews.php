<?php

    // ******************** CHATGPT CONFIGURATION ********************
    require __DIR__ . '/../../vendor/autoload.php'; // remove this line if you use a PHP Framework.
    use Orhanerday\OpenAi\OpenAi;
    $open_ai_key = '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';
    $open_ai = new OpenAi($open_ai_key);

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



    // ******************** DUMP and DIE ********************
    function dd($value)
    {
        echo "<br><pre>";
        var_dump($value);
        echo "</pre><br>";

        // die();
    }

    // ******************** CALLCHATGPT ********************
    function callChatGPT_OriginalReviews($open_ai, $reviewsForGPT)
    {
        $validResponse = false;

        while(!$validResponse) {

            $fullChatGPTMessage = "Take this list of reviews of a product: \n\n";
            $fullChatGPTMessage .= $reviewsForGPT;
            $fullChatGPTMessage .= "Exclusively based on the list create a perfect valid JSON object with the following keys: \n\n";
            $fullChatGPTMessage .= "key named 'numberOfReviews'. How many reviews were there in the list? \n\n";
            $fullChatGPTMessage .= "key named 'prosTotal'. How many positive reviews were there in the list? \n\n";
            $fullChatGPTMessage .= "key named 'consTotal'. How many negative reviews were there in the list? \n\n";
            $fullChatGPTMessage .= "key named 'indeterminateTotal'. How many indeterminate reviews were there in the list? \n\n";
            $fullChatGPTMessage .= "key named 'pros'. This key should be an array. And should contain a list of the most relevants POSITIVE/PROS points of the product, and should not have more than 20 items. \n\n";
            $fullChatGPTMessage .= "key named 'cons'. This key should be an array. And should contain a list of the most relevants NEGATIVE/CONS points of the product, and should not have more than 20 items. \n\n";
            $fullChatGPTMessage .= "The response MUST have just the JSON object, NOTHING ELSE. \n\n";

            dd("*************************************************************************************************************");
            dd("********************************************** CALLING CHATGPT **********************************************");
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
                'temperature' => 0.8,
                'max_tokens' => 1000,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]);

            dd($complete);

            // getting data from the chatGPT return
            $json_data = json_decode($complete, true);
            $content = json_decode($json_data["choices"][0]["message"]["content"], true);

            if ( $complete && array_key_exists('error', $json_data) ) {
                dd("****************************** VALID ERROR from CHATGPT (probably max TOKENS) ***********************************");
                $validResponse = true;
                return null;
            }
            else if ( 
                    $complete && 
                    $content &&
                    !array_key_exists('error', $json_data) &&
                    array_key_exists('pros', $content) &&
                    array_key_exists('cons', $content) &&
                    array_key_exists('prosTotal', $content) &&
                    array_key_exists('consTotal', $content)
                ) 
            {
                dd("****************************** GOOD RESPONSE from CHATGPT and VALID return for the APP  ***********************************");
                $validResponse = true;
                return $content;
            }
            else {
                dd("****************************** GOOD RESPONSE from CHATGPT BUT NOT VALID return for the APP  - LET'S TRY AGAIN ***********************************");
                $validResponse = false;
            }
        }
    }


    function callChatGPT_ConsolidateReviews( $open_ai, $contentIn, $consolidatedIn )
    {
        dd('***** inside callChatGPT_ConsolidateReviews');
        dd('***** content');
        dd($contentIn);
        dd('***** consolidated');
        dd($consolidatedIn);

        if ( empty($contentIn) && empty($consolidatedIn) ){
            dd('***** nothing to consolidate ********************');
            return ["consolidated" => []];
        }

        if ( !empty($contentIn) && empty($consolidatedIn) ){
            dd('***** empty consolidatedIn returning contentIn ********************');
            return ["consolidated" => $contentIn];
        }

        if ( empty($contentIn) && !empty($consolidatedIn) ){
            dd('***** empty contentIn returning consolidatedIn ********************');
            return ["consolidated" => $consolidatedIn];
        }

        $validResponse = false;

        while(!$validResponse) {

            $reviewsForGPT = "";
            foreach ($contentIn as $comment) {
                // appending to the list of reviews
                $reviewsForGPT = $reviewsForGPT . "- " . $comment . "\n\n";
            }
            foreach ($consolidatedIn as $comment) {
                // appending to the list of reviews
                $reviewsForGPT = $reviewsForGPT . "- " . $comment . "\n\n";
            }

            $fullChatGPTMessage = "Take this list of reviews of a product: \n\n";
            $fullChatGPTMessage .= $reviewsForGPT;
            $fullChatGPTMessage .= "Exclusively based on the list create a perfect valid JSON object with the following key: \n\n";
            $fullChatGPTMessage .= "key named 'consolidated'. This key should be an array. And should contain a summary of the List of reviews, and should not have more than 20 items. \n\n";
            $fullChatGPTMessage .= "The response MUST have just the JSON object, NOTHING ELSE. \n\n";

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
                'temperature' => 0.8,
                'max_tokens' => 1000,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]);

            dd($complete);

            // getting data from the chatGPT return
            $json_data = json_decode($complete, true);
            $content = json_decode($json_data["choices"][0]["message"]["content"], true);

            if ( $complete && array_key_exists('error', $json_data) ) {
                dd("****************************** VALID ERROR from CHATGPT (probably max TOKENS) ***********************************");
                $validResponse = true;
                return null;
            }
            else if ( 
                $complete && 
                $content && 
                !array_key_exists('error', $json_data) && 
                array_key_exists('consolidated', $content)
                )
            {
                dd("****************************** GOOD RESPONSE from CHATGPT and VALID return for the APP  ***********************************");
                $validResponse = true;
                return $content;
            }
            else {
                dd("****************************** GOOD RESPONSE from CHATGPT BUT NOT VALID return for the APP  - LET'S TRY AGAIN ***********************************");
                $validResponse = false;
            }
        }
    }
?>

<?php

    // MYSQL -------------------------------------------------------------------------
    //select the list of products from the MySQL
    // Connect to the database using PDO
   

    // Prepare the SELECT statement
    // $sql = "SELECT FROM mytable WHERE id = ?";
    $sql = "SELECT * FROM reviews where status = 'active'";

    $stmt = $pdo->prepare($sql);

    // Bind the parameter to the statement
    // $stmt->bindParam(1, $product);

    // Execute the statement and fetch the result
    $stmt->execute();
    $result = $stmt->fetchAll();
    // MYSQL -------------------------------------------------------------------------


    foreach ($result as $product) {

        $productURL = $product["url_bestbuy"];
        $productPath = $product["path"];



        $keepScraping = true;
        $page = 1;
        $reviews = [];

        while ($keepScraping) {

            // ****************** calling BestBuy endpoit - BEGIN

            // create & initialize a curl session
            $curl = curl_init();

            // set our url with curl_setopt()
            // dd(sprintf($productURL, $page));
            // curl_setopt($curl, CURLOPT_URL, "https://www.bestbuy.ca/api/reviews/v2/products/16157519/reviews?source=all&lang=en-CA&pageSize=10&page=1&sortBy=date&sortDir=desc");
            curl_setopt($curl, CURLOPT_URL, sprintf($productURL, $page));

            
            // wait some time just to be under the radar for anti scrapping sites
            sleep(rand(10, 60));
            

            // return the transfer as a string, also with setopt()
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            // forcing certifications
            // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            // $certificate_location = "c:/MAMP/cacert.pem";
            // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $certificate_location);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $certificate_location);

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
                if ( array_key_exists("comment", $review) ) {

                    // preparing/cleaning the text
                    $comment = substr($review['comment'], 0, 1800);
                    $comment = str_replace("'", ' ', $comment);
                    $comment = str_replace('"', ' ', $comment);
                    $comment = str_replace(array("\r\n", "\r", "\n"), '', $comment);

                    $reviews[] = $comment;

                    dd($review['comment']);
                }
            }

            // check the current page
            $currentPage = $json_data['currentPage'];

            //check total of pages
            $totalPages = $json_data['totalPages'];

            // check if the loop should keepScraping or not
            // force an end
            $totalPages = 5;
            if ($currentPage == $totalPages) {
                $keepScraping = false;
            } else {
                $page = $page + 1;
            }

        }



        
        // ****************** GET ONLY 3000 review randomly
        // Length
        if (count($reviews) > 3000) {
            // Get an array of 3000 random keys from the original array
            $randomKeys = array_rand($reviews, 3000);

            // Create a new array with the 3000 random items
            $randomItems = array();
            foreach ($randomKeys as $key) {
                $randomItems[] = $reviews[$key];
            }

            $reviews = $randomItems;
        }
        dd("*************************************************************************************************************");
        dd("************************************* ALL REVIEW FROM BEST BUY **********************************************");
        dd("*************************************************************************************************************");
        dd($reviews);




        
        $consolidatedPros = [];
        $consolidatedCons = [];
        $consolidatedProsTotal = 0;
        $consolidatedConsTotal = 0;

        $numberReviewsForGPT = 1;
        $reviewsForGPT = "";

        foreach ($reviews as $index => $comment) {

            // appending to the list of reviews
            $reviewsForGPT = $reviewsForGPT . "- " . $comment . "\n\n";


            if (($numberReviewsForGPT == 20) || ($index == count($reviews) - 1)) {

                dd("****************************** STARTING PROCESSING the BATCH ***********************************");

                // ******************** CALLCHATGPT ********************
                $content = callChatGPT_OriginalReviews($open_ai, $reviewsForGPT);

                if ( $content ) {
                    dd("****************************** pros/cons from the BATCH ***********************************");
                    dd($content["pros"]);
                    dd($content["cons"]);
                    dd($content["prosTotal"]);
                    dd($content["consTotal"]);


                    dd("****************************** STARTING CONSOLIDATING ***********************************");
                    // **********************************************************************************
                    // ****************** CONSOLIDATE
                    // **********************************************************************************

                     $consolidatedProsTotal = $consolidatedProsTotal + $content["prosTotal"];
                     $consolidatedConsTotal = $consolidatedConsTotal + $content["consTotal"];

                    // ****************** consolidate PROS reviews
                    dd('***** consolidate PROS reviews');
                    $consolidatedReviews = callChatGPT_ConsolidateReviews($open_ai, $content["pros"], $consolidatedPros);
                    if ( $consolidatedReviews ) {
                        $consolidatedPros = $consolidatedReviews["consolidated"];
                    }
                    // ****************** consolidate CONS reviews
                    dd('***** consolidate CONS reviews');
                    $consolidatedReviews = callChatGPT_ConsolidateReviews($open_ai, $content["cons"], $consolidatedCons);
                    if ( $consolidatedReviews ) {
                        $consolidatedCons = $consolidatedReviews["consolidated"];
                    }
                }
                else {
                    dd("****************************** ERROS PROCESSING the BATCH ***********************************");
                }


                $numberReviewsForGPT = 0;
                $reviewsForGPT = "";
            }

            $numberReviewsForGPT = $numberReviewsForGPT + 1;

        }



        dd("************************************************************************************************");
        dd("****************************** FINAL CONSOLIDATED pros/cons ***********************************");
        dd("************************************************************************************************");
        dd($consolidatedPros);
        dd($consolidatedCons);
        dd($consolidatedProsTotal );
        dd($consolidatedConsTotal );




        // ***************************** INSERT INTO SQL
        $consolidatedProsAArray = json_encode (
            array(
                "pros" => $consolidatedPros
            )
        );
        $consolidatedConsAArray = json_encode (
            array(
                "cons" => $consolidatedCons
            )
        );

        // Prepare the INSERT statement
        $stmt = $pdo->prepare("
        UPDATE reviews set 
        pros = :pros, 
        cons = :cons, 
        pros_total = :pros_total,
        cons_total = :cons_total
        where status = 'active' and path = :productPath
        ");

        // Bind the JSON object to the parameter
        $stmt->bindParam(':pros', $consolidatedProsAArray);
        $stmt->bindParam(':cons', $consolidatedConsAArray);
        $stmt->bindParam(':pros_total', $consolidatedProsTotal);
        $stmt->bindParam(':cons_total', $consolidatedConsTotal);
        $stmt->bindParam(':productPath', $productPath);

        // Execute the statement
        $stmt->execute();

        // die();




    }
?>