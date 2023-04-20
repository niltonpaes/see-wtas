<?php

// product_title
// product_company
// category
// sub_category

// title - 60-70 chars
// <title>Example Page Title</title>
// en:      <product_title> | See what they are saying AI
// pt-br:   <product_title> | Veja o que estão falando AI

// <meta name="description" content="This is an example meta description. It should be concise, informative, and include relevant keywords.">
// 155 - 160 chars
// en:      Check out product reviews and twitter threads. Our AI aggregator summarizes real feedback from sales sites and Twitter posts, allowing you to stay informed quickly and easily.
// pt-br:   Confira avaliações de produtos e threads do Twitter. Nosso agregador AI resume feedbacks reais de sites de vendas e postagens no Twitter, permitindo que você se mantenha informado de forma rápida e fácil.

// <meta name="keywords" content="example, keywords, on-page optimization">
// 1024 with comma
// en:      review, reviews, product, products, summary, tweet, twitter, AI, artificial inteligence, <product_title>, <product_company>, <category>, <sub_category>, <4 pros>, <4 cons>
// pr-br:   feedback, feedbacks, review, reviews, avaliação, avaliações, produto, produtos, resumo, tweet, twitter, AI, IA, inteligência artificial, <product_title>, <product_company>, <category>, <sub_category>, <4 pros>, <4 cons>



    // ********************************************************************************* CHATGPT CONFIGURATION
    require __DIR__ . '/../../vendor/autoload.php'; // remove this line if you use a PHP Framework.
    use Orhanerday\OpenAi\OpenAi;
    // Nilton 
    // $open_ai_key = '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';
    // Kita 
    // $open_ai_key = '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';
    // Lipe
    $open_ai_key = "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";
    $open_ai = new OpenAi($open_ai_key);

    // ********************************************************************************* MYSQL CONFIGURATION
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



    // ********************************************************************************* DUMP and DIE
    function dd($value)
    {
        echo "*********************************************************************************************************************";

        echo "<pre>";
        var_dump($value);
        echo "</pre>";

        echo "*********************************************************************************************************************";
        echo "<br>";
        echo "<br>";
        echo "<br>";

        // die();
    }


    function randomNoDuplicate($min, $max, $selectedNumbers) {
        $range = range($min, $max);
        $diff = array_diff($range, $selectedNumbers);
    
        if (count($diff) === 0) {
            return null; // Return null if all numbers in the range are selected
        }
    
        $randomIndex = array_rand($diff);
        return $diff[$randomIndex];
    }


    // ********************************************************************************* callChatGPT_Translation
    function callChatGPT_Translation($open_ai, $summaryJson)
    {
        $validResponse = false;
        $numberRetries = 0;

        while(!$validResponse) {

            $fullChatGPTMessage = "";
            $fullChatGPTMessage .= "Translate the content inside the keys to Portuguese-Brasil on the following JSON: \n\n";
            $fullChatGPTMessage .= $summaryJson;
            $fullChatGPTMessage .= "The response MUST have just the JSON object, same stricture with the translated content NOTHING ELSE. \n\n";

            dd("********************************************************************************* callChatGPT_Translation");
            dd($fullChatGPTMessage);

            $complete = $open_ai->chat([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role" => "system",
                        "content" =>  "You are going to translate some content."
                    ],
                    [
                        "role" => "user",
                        "content" => $fullChatGPTMessage
                    ],
                ],
                'temperature' => 0.8,
                'max_tokens' => 500,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]);

            dd($complete);

            // getting data from the chatGPT return
            $json_data = json_decode($complete, true);

            if ( $complete && array_key_exists('error', $json_data) ) {
                dd("********************************************************************************* VALID ERROR from CHATGPT (probably max TOKENS)");
                $validResponse = true;
                return null;
            }
            else {
                $content = json_decode($json_data["choices"][0]["message"]["content"], true);

                if ( 
                    $complete && 
                    $content &&
                    !array_key_exists('error', $json_data) &&
                    array_key_exists('prosTotal', $content) &&
                    array_key_exists('consTotal', $content) &&
                    array_key_exists('neutralTotal', $content) &&
                    array_key_exists('pros', $content) &&
                    array_key_exists('cons', $content) &&
                    array_key_exists('neutral', $content)
                ) 
                {
                    dd("********************************************************************************* GOOD RESPONSE from CHATGPT and VALID return for the APP");
                    $validResponse = true;
                    return $content;
                }
                else {
                    dd("********************************************************************************* GOOD RESPONSE from CHATGPT BUT NOT VALID return for the APP  - LET'S TRY AGAIN");
                    $validResponse = false;
                }
            }
         

            $numberRetries = $numberRetries + 1;
            if ($numberRetries > 3) {
                dd("********************************************************************************* TRIED 3 times ALREADY and NOTHING");
                die();
            }
        }
    }


    // ********************************************************************************* callChatGPT_Posts
    function callChatGPT_Posts($open_ai, $posts)
    {
        // prepare the posts for GPT summay
        $postsForGPT = "";
        foreach ($posts as $index => $post) {
            // appending to the list of posts
            $postsForGPT = $postsForGPT . "- " . $post . "\n\n";
        }


        $validResponse = false;
        $numberRetries = 0;

        while(!$validResponse) {

            $fullChatGPTMessage = "";
            $fullChatGPTMessage .= "Take this list of reviews of a product: \n\n";
            $fullChatGPTMessage .= $postsForGPT;
            $fullChatGPTMessage .= "Exclusively based on the list create a perfect/valid JSON object with the following keys: \n\n";
            
            // $fullChatGPTMessage .= "key named 'pros'. This key should be an array. And should contain a summary of the POSITIVE/PROS reviews listing the positive points of the product. It should not have more than 20 items. \n\n";
            // $fullChatGPTMessage .= "key named 'cons'. This key should be an array. And should contain a summary of the NEGATIVE/CONS reviews listing the negative points of the product. It should not have more than 20 items. \n\n";
            // $fullChatGPTMessage .= "key named 'neutral'. This key should be an array. And should contain a summary of the indeterminate/neutral reviews listing the indeterminate/neutral points of the product. It should not have more than 20 items. \n\n";
            $fullChatGPTMessage .= "key named 'pros'. This key should be an array. And should contain the list of the most relevant POSITIVE/PROS points of the product, and should not have more than 20 items. \n\n";
            $fullChatGPTMessage .= "key named 'cons'. This key should be an array. And should contain the list of the most relevant NEGATIVE/CONS points of the product, and should not have more than 20 items. \n\n";
            $fullChatGPTMessage .= "key named 'neutral'. This key should be an array. And should contain the list of the most relevant NEUTRAL points of the product, points that are neither positive nor negative , and should not have more than 20 items. \n\n";

            $fullChatGPTMessage .= "key named 'prosTotal'. How many positive reviews were there in the list? \n\n";
            $fullChatGPTMessage .= "key named 'consTotal'. How many negative reviews were there in the list? \n\n";
            $fullChatGPTMessage .= "key named 'neutralTotal'. How many indeterminate reviews were there in the list? \n\n";

            $fullChatGPTMessage .= "The response MUST have just the JSON object, NOTHING ELSE. \n\n";

            dd("********************************************************************************* callChatGPT_Posts");
            dd($fullChatGPTMessage);

            $complete = $open_ai->chat([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role" => "system",
                        "content" =>  "You are going to summarize product reviews."
                    ],
                    [
                        "role" => "user",
                        "content" => $fullChatGPTMessage
                    ],
                ],
                'temperature' => 0.8,
                'max_tokens' => 500,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]);
            // $complete = $open_ai->completion([
            //     'model' => 'text-davinci-003',
            //     'prompt' => $fullChatGPTMessage,
            //     'temperature' => 1.0,
            //     'max_tokens' => 1000,
            //     'frequency_penalty' => 0,
            //     'presence_penalty' => 0,
            // ]);

            dd($complete);

            // getting data from the chatGPT return
            $json_data = json_decode($complete, true);

            if ( $complete && array_key_exists('error', $json_data) ) {
                dd("********************************************************************************* VALID ERROR from CHATGPT (probably max TOKENS)");
                $validResponse = false;

                // let's try again with less elements in the array, sleep first
                sleep(50);
                // prepare the posts for GPT summay
                array_splice($posts, 0, 2);
                $postsForGPT = "";
                foreach ($posts as $index => $post) {
                    // appending to the list of posts
                    $postsForGPT = $postsForGPT . "- " . $post . "\n\n";
                }
            }
            else {
                $content = json_decode($json_data["choices"][0]["message"]["content"], true);

                if ( 
                    $complete && 
                    $content &&
                    !array_key_exists('error', $json_data) &&
                    array_key_exists('prosTotal', $content) &&
                    array_key_exists('consTotal', $content) &&
                    array_key_exists('neutralTotal', $content) &&
                    array_key_exists('pros', $content) &&
                    array_key_exists('cons', $content) &&
                    array_key_exists('neutral', $content)
                ) 
                {
                    dd("********************************************************************************* GOOD RESPONSE from CHATGPT and VALID return for the APP");
                    $validResponse = true;
                    return $content;
                }
                else {
                    dd("********************************************************************************* GOOD RESPONSE from CHATGPT BUT NOT VALID return for the APP  - LET'S TRY AGAIN");
                    $validResponse = false;
                }
            }
         

            $numberRetries = $numberRetries + 1;
            if ($numberRetries > 3) {
                dd("********************************************************************************* TRIED 3 times ALREADY and NOTHING");
                // die();
                $validResponse = true;
                return null;
            }
        }
    }

?>

<?php


    // ********************************************************************************* MYSQL - select the records from the MySQL
    // Prepare the SELECT statement
    // $sql = "SELECT FROM mytable WHERE id = ?";
    $sql = "SELECT * FROM reviews where status_torun is true";

    $stmt = $pdo->prepare($sql);

    // Bind the parameter to the statement
    // $stmt->bindParam(1, $product);

    // Execute the statement and fetch the result
    $stmt->execute();
    $result = $stmt->fetchAll();

    // dd("********************************************************************************* MySQL result");
    // dd($result);

    foreach ($result as $post) {

        $urlData = $post["url_bestbuy"];
        dd('$urlData = ' . $urlData);

        $postPath = $post["path"];
        dd('$postPath = ' . $postPath);

        $limit_calls = 15; // *** NOTE: API return 10 items only
        dd('$limit_calls = ' . $limit_calls);
        $limit_min_chars = 60;
        dd('$limit_min_chars = ' . $limit_min_chars);
        $limit_max_chars = 400;
        dd('$limit_max_chars = ' . $limit_max_chars);
        $limit_max_posts = 87;
        dd('$limit_max_posts = ' . $limit_max_posts);



        $keepScraping = true;
        $posts = [];

        // pagination
        $page = 1;
        $numberOfPages = 0;
        $selectedPages = array();

        while ($keepScraping) {
            // ********************************************************************************* CALL API DATA
            dd("API DATA PAGE: $page | TOTAL PAGES PROCESSED: $numberOfPages");



            // create & initialize a curl session
            $curl = curl_init();

            // set CURL URL
            dd(sprintf($urlData, $page));
            curl_setopt($curl, CURLOPT_URL, sprintf($urlData, $page));
            
            // IF needed wait some time just to be under the radar for anti scrapping sites
            sleep(rand(10, 30));

            // return the transfer as a string, also with setopt()
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            // curl_exec() executes the started curl session
            // $output contains the output string
            $output = curl_exec($curl);

            // Check for errors
            if (curl_errno($curl)) {
                dd('cURL error: ' . curl_error($curl));
                die();
            }

            // close curl resource to free up system resources
            // (deletes the variable made by curl_init)
            curl_close($curl);

            $json_data = json_decode($output, true);
            dd('$json_data');
            dd($json_data);



            if ( !empty($json_data) && !empty($json_data['reviews']) ) {

                // valid return from the API
                foreach ($json_data['reviews'] as $index => $post) {

                    if ( array_key_exists("comment", $post) ) {
                        $postText = $post["comment"];

                        // preparing/cleaning the text
                        $postText = str_replace("'", ' ', $postText);
                        $postText = str_replace('"', ' ', $postText);
                        $postText = str_replace(array("\r\n", "\r", "\n"), '', $postText);

                        // check the length of the post
                        if ( strlen($postText) > $limit_min_chars && strlen($postText) < $limit_max_chars ) {
                            $posts[] = $postText;
                        }
                    }

                }

                $numberOfPages = $numberOfPages + 1;

                $randomNumber = randomNoDuplicate(2, $json_data['totalPages'], $selectedPages);
                if ($randomNumber === null) {
                    // All numbers in range are already selected
                    $keepScraping = false;
                } else {
                    // Random number selected: $randomNumber
                    $page = $randomNumber;
                    $selectedNumbers[] = $randomNumber;
                }
            }
            else {
                $keepScraping = false;
            }



            // force an end IF NEEDED
            if ($numberOfPages > $limit_calls) {
                $keepScraping = false;
            }
        }



        // ********************************************************************************* GET ONLY $max items randomly
        $max = $limit_max_posts;
        if (count($posts) > $max) {
            // Get an array of $max random keys from the original array
            $randomKeys = array_rand($posts, $max);

            // Create a new array with the $max random items
            $randomItems = array();
            foreach ($randomKeys as $key) {
                $randomItems[] = $posts[$key];
            }

            $posts = $randomItems;
        }
        dd('********************************************************************************* FINAL POSTS ARRAY - $posts');
        dd($posts);


        $content_en = null;
        $content_ptbr = null;


        // ********************************************************************************* CALLCHATGPT
        $content = callChatGPT_Posts($open_ai, $posts);

        if ( $content ) {
            dd("********************************************************************************* RESULTS FROM callChatGPT_Posts");
            dd($content["prosTotal"]);
            dd($content["consTotal"]);
            dd($content["neutralTotal"]);
            dd($content["pros"]);
            dd($content["cons"]);
            dd($content["neutral"]);

            $content_en = json_encode (
                array(
                    "prosTotal" => $content["prosTotal"],
                    "consTotal" => $content["consTotal"],
                    "neutralTotal" => $content["neutralTotal"],
                    "pros" => $content["pros"],
                    "cons" => $content["cons"],
                    "neutral" => $content["neutral"]
                )
            );

            // translate the content
            $content_ptbr = callChatGPT_Translation($open_ai, $content_en);
        }

        if ( $content_en && $content_ptbr) {
            dd("********************************************************************************* RESULTS FROM callChatGPT_Posts");
            dd( $content_ptbr);
            $content_ptbr = json_encode($content_ptbr);

            // ***************************** UPDATE ON MYSQL

            // Prepare the UPDATE statement
            $stmt = $pdo->prepare("
            UPDATE reviews set 
            summary_en = :summary_en,
            summary_ptbr = :summary_ptbr,
            status_torun = 0,
            status_ok = 1,
            `error` = null
            where path = :postPath
            ");

            // Bind the JSON object to the parameter
            $stmt->bindParam(':summary_en', $content_en);
            $stmt->bindParam(':summary_ptbr', $content_ptbr);
            $stmt->bindParam(':postPath', $postPath);

            // Execute the statement
            $stmt->execute();
        }
        else {
            dd("*********************************************************************************  ERRORS PROCESSING the BATCH");

            // ***************************** UPDATE ON MYSQL

            // Prepare the UPDATE statement
            $stmt = $pdo->prepare("
            UPDATE reviews set 
            status_torun = 0,
            status_ok = 0,
            error = 'ERRORS PROCESSING the BATCH'
            where path = :postPath
            ");

            // Bind parametes
            $stmt->bindParam(':postPath', $postPath);

            // Execute the statement
            $stmt->execute();
        }

    }
?>