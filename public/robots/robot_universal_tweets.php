<?php

     // apify API
    // https://api.apify.com/v2/actor-tasks/niltonpa~kimkataguiri-1643242411542425605-fullset/run-sync-get-dataset-items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=0&limit=100&fields=full_text&method=POST
    // https://api.apify.com/v2/actor-tasks/janedoe~my-task/run-sync-get-dataset-items?token=soSkq9ekdmfOslopH&offset=0&limit=100&fields=text_field
    // https://api.apify.com/v2/actor-tasks/niltonpa~twitter-url-scraper-task/run-sync-get-dataset-items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=0&limit=50&fields=full_text&desc=true&method=POST
    // https://api.apify.com/v2/actor-tasks/niltonpa~twitter-url-scraper-task/run-sync-get-dataset-items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=0&limit=50&fields=full_text&&method=POST

    // https://api.apify.com/v2/actor-tasks/niltonpa~kimkataguiri-1643242411542425605-full/run-sync-get-dataset-items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=0&limit=99&fields=full_text&method=POST
    // https://api.apify.com/v2/actor-tasks/niltonpa~kimkataguiri-1643242411542425605-full/run-sync-get-dataset-items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&fields=full_text&method=POST

    // https://api.apify.com/v2/datasets/RWamoTAvghnjrbyj0/items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=100&limit=99&fields=full_text



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



    // ********************************************************************************* CALLCHATGPT
    function callChatGPT_Posts($open_ai, $postsForGPT, $firstPost, $postFromId, $postFromName)
    {
        $validResponse = false;
        $numberRetries = 0;

        while(!$validResponse) {

            $fullChatGPTMessage = "";
            $fullChatGPTMessage .= "Exclusively based on the Twitter thread below: \n\n";
            $fullChatGPTMessage .= "Initial tweet post: \n\n";
            $fullChatGPTMessage .= "$firstPost \n\n";
            $fullChatGPTMessage .= "List of replies: \n\n";
            $fullChatGPTMessage .= $postsForGPT;
            $fullChatGPTMessage .= "\n\n";
            $fullChatGPTMessage .= "Create a perfect/valid JSON object with the following keys: \n\n";
            $fullChatGPTMessage .= "key named 'prosTotal' = How many replies are agreeing with what the initial tweet says? \n\n";
            $fullChatGPTMessage .= "key named 'consTotal' = How many replies are disagreeing with what the initial tweet says? \n\n";
            $fullChatGPTMessage .= "key named 'neutralTotal' = How many replies are neither agreeing nor disagreeing with what the initial tweet says? \n\n";
            $fullChatGPTMessage .= "key named 'pros' = Create a text analyzing and summarizing what people are saying in the replies that are agreeing with what the initial tweet says. In between 100 to 200 words. \n\n";
            $fullChatGPTMessage .= "key named 'cons' = Create a text analyzing and summarizing what people are saying in the replies that are disagreeing with what the initial tweet says. In between 100 to 200 words. \n\n";
            $fullChatGPTMessage .= "key named 'neutral' = Create a text analyzing and summarizing what people are saying in the replies that are neither agreeing nor disagreeing with what the initial tweet says. In between 100 to 200 words. \n\n";
            $fullChatGPTMessage .= "key named 'ai' = Based on social, cultural, economic, scientific, historical, and political facts, create a text about other things that should be pointed out that are somehow related with this discussion. Bring additional points, different points of view, etc. In between 50 to 150 words. \n\n";
            // $fullChatGPTMessage .= "key named 'ai' = Based on social, cultural, economic, scientific, historical, and political facts, create a text about things that should be considered that are somehow related with the initial tweet and all the replies. Bring additional points, different points of view, etc. In between 50 to 150 words. \n\n";
            // $fullChatGPTMessage .= "key named 'ai' = Create a text on the following topic: What are some social, cultural, economic, scientific, historical, and political factors that have contributed to the topic being discussed on this twitter thread? How have these factors influenced the different perspectives and arguments presented in the discussion? In between 50 to 150 words. \n\n";
            
            $fullChatGPTMessage .= "key named 'title' = Create the HTML title tag for the page that will have this content. You should use the discussion about the twitter thread, the name of the website 'See what they are saying', and the id, name of the initial tweet author: $postFromId, $postFromName  \n\n";
            $fullChatGPTMessage .= "key named 'meta_description' = Create the HTML meta name/description tag for the page that will have this content. You should use the discussion about the twitter thread, the name of the website 'See what they are saying', and the id, name of the initial tweet author: $postFromId, $postFromName  \n\n";
            $fullChatGPTMessage .= "key named 'meta_keywords' = Create the HTML meta name/keywords tag for the page that will have this content. You should use the discussion about the twitter thread, the name of the website 'See what they are saying', and the id, name of the initial tweet author: $postFromId, $postFromName  \n\n";
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
                'max_tokens' => 600,
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
                die();
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
        $postFromName = $post["from_name"];
        dd('$postFromName = ' . $postFromName);




        $keepScraping = true;
        $posts = [];

        // pagination
        $offset = 0;
        $limit = 100;

        while ($keepScraping) {
            // ********************************************************************************* CALL API DATA
            dd('API DATA OFFSET - $offset : ' . $offset);

            // create & initialize a curl session
            $curl = curl_init();

            // set CURL URL
            dd(sprintf($urlData, $offset, $limit));
            curl_setopt($curl, CURLOPT_URL, sprintf($urlData, $offset, $limit));
            
            // IF needed wait some time just to be under the radar for anti scrapping sites
            // sleep(rand(10, 60));

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

                    if ( strlen($postText) > 40 && strlen($postText) < 1000 ) {
                        $posts[] = $postText;
                    }
                }

                $offset = $offset + $limit;
            }
            else {
                $keepScraping = false;
            }

            // force an end IF NEEDED
            // if ($offset > 99) {
            //     $keepScraping = false;
            // }
        }


        // GET the initial POST and remove it from the list of posts
        $firstPost = array_shift($posts);
        dd('********************************************************************************* FIRST POST');
        dd($firstPost);


        // ********************************************************************************* GET ONLY $max items randomly
        $max = 80;
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


        $postsForGPT = "";
        foreach ($posts as $index => $post) {
            // appending to the list of posts
            $postsForGPT = $postsForGPT . "- " . $post . "\n\n";
        }


        // ********************************************************************************* CALLCHATGPT
        $content = callChatGPT_Posts($open_ai, $postsForGPT, $firstPost, $postFromId, $postFromName);


        if ( $content ) {
            dd("********************************************************************************* FINAL RESULTS FROM CHAT GPT");
            dd($content["prosTotal"]);
            dd($content["consTotal"]);
            dd($content["neutralTotal"]);
            dd($content["pros"]);
            dd($content["cons"]);
            dd($content["neutral"]);
            dd($content["ai"]);
            dd($content["title"]);
            dd($content["meta_description"]);
            dd($content["meta_keywords"]);
        }
        else {
            dd("*********************************************************************************  ERROS PROCESSING the BATCH");
        }





        // ***************************** INSERT INTO SQL
        $summary = json_encode (
            array(
                "prosTotal" => $content["prosTotal"],
                "consTotal" => $content["consTotal"],
                "neutralTotal" => $content["neutralTotal"],
                "pros" => $content["pros"],
                "cons" => $content["cons"],
                "neutral" => $content["neutral"],
                "ai" => $content["ai"],
                "title" => $content["title"],
                "meta_description" => $content["meta_description"],
                "meta_keywords" => $content["meta_keywords"]
            )
        );

        // Prepare the INSERT statement
        $stmt = $pdo->prepare("
        UPDATE tweets set 
        summary = :summary
        where path = :postPath
        ");

        // Bind the JSON object to the parameter
        $stmt->bindParam(':summary', $summary);
        $stmt->bindParam(':postPath', $postPath);

        // Execute the statement
        $stmt->execute();

        // die();




    }
?>