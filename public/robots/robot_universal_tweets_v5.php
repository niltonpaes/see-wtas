<?php
// apify API
// task end-point
// https://api.apify.com/v2/actor-tasks/niltonpa~kimkataguiri-1643242411542425605-full/run-sync-get-dataset-items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=0&limit=99&fields=full_text&method=POST
// https://api.apify.com/v2/actor-tasks/niltonpa~kimkataguiri-1643242411542425605-full/run-sync-get-dataset-items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&fields=full_text&method=POST
// storage end-point
// https://api.apify.com/v2/datasets/RWamoTAvghnjrbyj0/items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=100&limit=99&fields=full_text


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
// en:      Discover what people are saying about products and tweets. Our AI aggregator summarizes real feedback from sales sites and Twitter posts, allowing you to stay informed quickly and easily.
// pt-br:   Descubra o que as pessoas estão falando sobre produtos e tweets. Nosso agregador AI resume feedbacks reais de sites de vendas e postagens no Twitter, permitindo que você se mantenha informado de forma rápida e fácil.

// <meta name="keywords" content="example, keywords, on-page optimization">
// 1024 with comma
// en:      review, product, summary, tweet, twitter, AI, <product_title>, <product_company>, <category>, <sub_category>, <4 pros>, <4 cons>
// pr-br:   feedback, review, avaliação, produto, resumo, tweet, twitter, AI, IA, <product_title>, <product_company>, <category>, <sub_category>, <4 pros>, <4 cons>



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
                'max_tokens' => 700,
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
    function callChatGPT_Posts($open_ai, $posts, $firstPost)
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
            // $fullChatGPTMessage .= "Exclusively based on the Twitter thread below: \n\n";
            $fullChatGPTMessage .= "Take the Twitter thread below: \n\n";

            $fullChatGPTMessage .= "Initial tweet post: \n\n";
            $fullChatGPTMessage .= "$firstPost \n\n";
            $fullChatGPTMessage .= "List of replies: \n\n";
            $fullChatGPTMessage .= $postsForGPT;
            $fullChatGPTMessage .= "\n\n";

            $fullChatGPTMessage .= "Exclusively based on the Twitter thread above create a perfect/valid JSON object with the following keys: \n\n";
            // $fullChatGPTMessage .= "Create a perfect/valid JSON object with the following keys: \n\n";

            // $fullChatGPTMessage .= "key named 'pros' = Create a text analyzing and summarizing what people are saying in the replies that are agreeing with what the initial tweet says. In between 100 to 150 words. \n\n";
            // $fullChatGPTMessage .= "key named 'cons' = Create a text analyzing and summarizing what people are saying in the replies that are disagreeing with what the initial tweet says. In between 100 to 150 words. \n\n";
            // $fullChatGPTMessage .= "key named 'neutral' = Create a text analyzing and summarizing what people are saying in the replies that are neither agreeing nor disagreeing with what the initial tweet says. In between 100 to 150 words. \n\n";
            $fullChatGPTMessage .= "key named 'pros' = Create a text summarizing what people are saying in the replies that are agreeing with what the initial tweet says. In between 600 to 700 characters. \n\n";
            $fullChatGPTMessage .= "key named 'cons' = Create a text summarizing what people are saying in the replies that are disagreeing with what the initial tweet says. In between 600 to 700 characters. \n\n";
            $fullChatGPTMessage .= "key named 'neutral' = Create a text summarizing what people are saying in the replies that are neither agreeing nor disagreeing with what the initial tweet says. In between 600 to 700 characters. \n\n";

            // $fullChatGPTMessage .= "key named 'ai' = Based on social, cultural, economic, scientific, historical, and political facts, create a text about other things that should be pointed out that are somehow related with this discussion. Bring additional points, different points of view, etc. In between 50 to 150 words. \n\n";
            // $fullChatGPTMessage .= "key named 'ai' = Based on social, cultural, economic, scientific, historical, and political facts, create a text about things that should be considered that are somehow related with the initial tweet and all the replies. Bring additional points, different points of view, etc. In between 50 to 150 words. \n\n";
            // $fullChatGPTMessage .= "key named 'ai' = Create a text on the following topic: What are some social, cultural, economic, scientific, historical, and political factors that have contributed to the topic being discussed on this twitter thread? How have these factors influenced the different perspectives and arguments presented in the discussion? In between 50 to 150 words. \n\n";
            $fullChatGPTMessage .= "key named 'ai' = Based on social, cultural, economic, scientific, historical, and political facts, create a text adding new perspectives and insights that help illuminate the discussion. In between 600 to 700 characters. \n\n";

            $fullChatGPTMessage .= "key named 'prosTotal' = How many replies are agreeing with what the initial tweet says? \n\n";
            $fullChatGPTMessage .= "key named 'consTotal' = How many replies are disagreeing with what the initial tweet says? \n\n";
            $fullChatGPTMessage .= "key named 'neutralTotal' = How many replies are neither agreeing nor disagreeing with what the initial tweet says? \n\n";
            
            $fullChatGPTMessage .= "IMPORTANT: DO NOT USE ABSOLUTE NUMBERS USE PERCENTAGES! \n\n";
            $fullChatGPTMessage .= "The response MUST have just the JSON object, NOTHING ELSE. \n\n";

            dd("********************************************************************************* callChatGPT_Posts");
            dd($fullChatGPTMessage);

            $complete = $open_ai->chat([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role" => "system",
                        "content" =>  "You are going to summarize a twitter thread."
                    ],
                    [
                        "role" => "user",
                        "content" => $fullChatGPTMessage
                    ],
                ],
                'temperature' => 0.8,
                'max_tokens' => 700,
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
                    array_key_exists('neutral', $content) && 
                    array_key_exists('ai', $content)
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
    $sql = "SELECT * FROM tweets where status_torun is true";

    $stmt = $pdo->prepare($sql);

    // Bind the parameter to the statement
    // $stmt->bindParam(1, $product);

    // Execute the statement and fetch the result
    $stmt->execute();
    $result = $stmt->fetchAll();

    // dd("********************************************************************************* MySQL result");
    // dd($result);

    foreach ($result as $post) {

        $urlData = $post["url_tweet_api_data"];
        dd('$urlData = ' . $urlData);

        $postPath = $post["path"];
        dd('$postPath = ' . $postPath);

        $postFromId = $post["from_id"];
        dd('$postFromId = ' . $postFromId);

        $limit_calls = 100; // *** NOTE: getting 100 items each call
        dd('$limit_calls = ' . $limit_calls);
        $limit_min_chars = 30;
        dd('$limit_min_chars = ' . $limit_min_chars);
        $limit_max_chars = 1000;
        dd('$limit_max_chars = ' . $limit_max_chars);
        $limit_max_posts = 87;
        dd('$limit_max_posts = ' . $limit_max_posts);



        $keepScraping = true;
        $posts = [];

        // pagination
        $numberOfPages = 0;
        $offset = 0;
        $limit = 100;

        while ($keepScraping) {
            // ********************************************************************************* CALL API DATA
            dd("API DATA OFFSET: $offset | TOTAL PAGES PROCESSED: $numberOfPages");



            // create & initialize a curl session
            $curl = curl_init();

            // set CURL URL
            dd(sprintf($urlData, $offset, $limit));
            curl_setopt($curl, CURLOPT_URL, sprintf($urlData, $offset, $limit));
            
            // IF needed wait some time just to be under the radar for anti scrapping sites
            // sleep(rand(10, 30));

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



            if (!empty($json_data)) {
                // twitter API
                foreach ($json_data as $index => $post) {
                    $postText = $post["full_text"];

                    // remove the @fromID
                    $pos = strpos($postText, $postFromId);
                    if ($pos !== false) {
                        $rest = substr($postText, $pos + strlen($postFromId));
                        $postText = $rest;
                    }

                    // preparing/cleaning the text
                    $postText = str_replace("'", ' ', $postText);
                    $postText = str_replace('"', ' ', $postText);
                    $postText = str_replace(array("\r\n", "\r", "\n"), '', $postText);

                    // check the length of the post
                    if ( strlen($postText) > $limit_min_chars && strlen($postText) < $limit_max_chars ) {
                        $posts[] = $postText;
                    }
                }

                $numberOfPages = $numberOfPages + 1;

                $offset = $offset + $limit;
            }
            else {
                $keepScraping = false;
            }



            // force an end IF NEEDED
            if ($numberOfPages > $limit_calls) {
                $keepScraping = false;
            }
        }


        // GET the initial POST and remove it from the list of posts
        $firstPost = array_shift($posts);
        dd('********************************************************************************* FIRST POST');
        dd($firstPost);


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
        $content = callChatGPT_Posts($open_ai, $posts, $firstPost);

        if ( $content ) {
            dd("********************************************************************************* RESULTS FROM callChatGPT_Posts");
            dd($content["prosTotal"]);
            dd($content["consTotal"]);
            dd($content["neutralTotal"]);
            dd($content["pros"]);
            dd($content["cons"]);
            dd($content["neutral"]);
            dd($content["ai"]);

            $content_en = json_encode (
                array(
                    "prosTotal" => $content["prosTotal"],
                    "consTotal" => $content["consTotal"],
                    "neutralTotal" => $content["neutralTotal"],
                    "pros" => $content["pros"],
                    "cons" => $content["cons"],
                    "neutral" => $content["neutral"],
                    "ai" => $content["ai"]
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
            UPDATE tweets set 
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
            UPDATE tweets set 
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