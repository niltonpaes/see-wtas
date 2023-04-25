<?php

    // ----------------------------------------------------------------------------------------
    // set the base_path
    // ----------------------------------------------------------------------------------------
    const BASE_PATH = __DIR__.'/../../';

    require BASE_PATH.'core/functions.php';
    require base_path('core/database_connection.php');



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
    // $dsn = "mysql:host=localhost:8889;dbname=seewtas";
    // $username = "root";
    // $password = "root";

    // $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    // $pdo = new PDO($dsn, $username, $password, $options);



    // ********************************************************************************* DUMP and DIE
    function local_dd($value)
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
                'temperature' => 1.0,
                'max_tokens' => 1000,
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
    function callChatGPT_Posts($open_ai, $posts, $firstPost, $summaryOrTotals)
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

            if ($summaryOrTotals == "summary") {
                $fullChatGPTMessage .= "key named 'pros' = List of what people are saying in favor of the initial tweet. Not the actual replies, but a summary. \n\n";
                $fullChatGPTMessage .= "key named 'cons' = List of what people are saying against the initial tweet. Not the actual replies, but a summary. \n\n";
                $fullChatGPTMessage .= "key named 'neutral' = List of what people are saying neutral about the initial tweet. Not the actual replies, but a summary. \n\n";
    
                $fullChatGPTMessage .= "key named 'ai' = Based on social, cultural, economic, scientific, historical, and political facts, create a text adding new perspectives and insights that help illuminate the discussion. \n\n";
            }
            else {
                $fullChatGPTMessage .= "key named 'prosTotal' = What is the percentage of replies in favor of the initial tweet? \n\n";
                $fullChatGPTMessage .= "key named 'consTotal' = What is the percentage of replies against the initial twee? \n\n";
                $fullChatGPTMessage .= "key named 'neutralTotal' = What is the percentage of replies neutral about the initial tweet? \n\n";
            }
            
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
                'temperature' => 0.5,
                'max_tokens' => 900,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
                'top_p' => 0.5
            ]);

            dd($complete);

            // getting data from the chatGPT return
            $json_data = json_decode($complete, true);

            if ( $complete && array_key_exists('error', $json_data) ) {
                dd("********************************************************************************* VALID ERROR from CHATGPT (probably max TOKENS)");
                $validResponse = false;

                // let's try again with less elements in the array, sleep first
                sleep(50);
                // prepare the posts for GPT summay
                array_splice($posts, 0, 4);
                $postsForGPT = "";
                foreach ($posts as $index => $post) {
                    // appending to the list of posts
                    $postsForGPT = $postsForGPT . "- " . $post . "\n\n";
                }
            }
            else {
                $content = json_decode($json_data["choices"][0]["message"]["content"], true);

                if ($summaryOrTotals == "summary")
                {
                    if ( 
                        $complete && 
                        $content &&
                        !array_key_exists('error', $json_data) &&
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
                else {
                    if ( 
                        $complete && 
                        $content &&
                        !array_key_exists('error', $json_data) &&
                        array_key_exists('prosTotal', $content) &&
                        array_key_exists('consTotal', $content) &&
                        array_key_exists('neutralTotal', $content)
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

        $limit_calls = 100; // *** NOTE: getting 100 items each call. $limit below
        dd('$limit_calls = ' . $limit_calls);
        $limit_min_chars = 35;
        dd('$limit_min_chars = ' . $limit_min_chars);
        $limit_max_chars = 1000;
        dd('$limit_max_chars = ' . $limit_max_chars);
        $limit_max_posts = 85;
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


        // ********************************************************************************* CALLCHATGPT - SUMMARY
        $content_summary = callChatGPT_Posts($open_ai, $posts, $firstPost, "summary");
        if ( $content_summary ) {
            dd("********************************************************************************* RESULTS FROM callChatGPT_Posts - SUMMARY");
            dd($content_summary["pros"]);
            dd($content_summary["cons"]);
            dd($content_summary["neutral"]);
            dd($content_summary["ai"]);
        }

        // ********************************************************************************* CALLCHATGPT - TOTALS
        $content_totals = callChatGPT_Posts($open_ai, $posts, $firstPost, "totals");
        if ( $content_totals ) {
            dd("********************************************************************************* RESULTS FROM callChatGPT_Posts - SUMMARY");
            dd($content_totals["prosTotal"]);
            dd($content_totals["consTotal"]);
            dd($content_totals["neutralTotal"]);
        }

        // ********************************************************************************* TRANSLATE
        if ( $content_summary && $content_totals ) {
            $content_en = json_encode (
                array(
                    "pros" => $content_summary["pros"],
                    "cons" => $content_summary["cons"],
                    "neutral" => $content_summary["neutral"],
                    "ai" => $content_summary["ai"],
                    "prosTotal" => $content_totals["prosTotal"],
                    "consTotal" => $content_totals["consTotal"],
                    "neutralTotal" => $content_totals["neutralTotal"]
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