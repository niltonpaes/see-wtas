<?php

     // apify API
    // https://api.apify.com/v2/actor-tasks/niltonpa~kimkataguiri-1643242411542425605-fullset/run-sync-get-dataset-items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=0&limit=100&fields=full_text&method=POST
    // https://api.apify.com/v2/actor-tasks/janedoe~my-task/run-sync-get-dataset-items?token=soSkq9ekdmfOslopH&offset=0&limit=100&fields=text_field
    // https://api.apify.com/v2/actor-tasks/niltonpa~twitter-url-scraper-task/run-sync-get-dataset-items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=0&limit=50&fields=full_text&desc=true&method=POST
    // https://api.apify.com/v2/actor-tasks/niltonpa~twitter-url-scraper-task/run-sync-get-dataset-items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=0&limit=50&fields=full_text&&method=POST

    // https://api.apify.com/v2/actor-tasks/niltonpa~kimkataguiri-1643242411542425605-full/run-sync-get-dataset-items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=0&limit=99&fields=full_text&method=POST
    // https://api.apify.com/v2/actor-tasks/niltonpa~kimkataguiri-1643242411542425605-full/run-sync-get-dataset-items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&fields=full_text&method=POST


    // limit the time for the PHP code execution
    set_time_limit(10);


    // ******************** CHATGPT CONFIGURATION ********************
    require __DIR__ . '/../../vendor/autoload.php'; // remove this line if you use a PHP Framework.
    use Orhanerday\OpenAi\OpenAi;
    // Nilton 
    // $open_ai_key = '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';
    // Kita 
    // $open_ai_key = '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';
    // Lipe
    $open_ai_key = "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";
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
    function callChatGPT_OriginalTweets($open_ai, $tweetsForGPT, $firstTweet)
    {
        $validResponse = false;
        $numberRetries = 0;

        while(!$validResponse) {

            $fullChatGPTMessage = "";
            $fullChatGPTMessage .= "Exclusively based on the Twitter thread below, and I meant, not using any other source of data. Please create an analytical summary text about it. The text MUST have 5 paragraphs in a JSON format as follows: \n\n";
            
            // $fullChatGPTMessage .= "- key 'first_paragraph': must exclusively talk about the Initial tweet in between 10 to 120 words. \n\n";
            // $fullChatGPTMessage .= "- key 'second_paragraph': must exclusively talk about the replies in favor of the initial tweet in between 10 to 120 words. \n\n";
            // $fullChatGPTMessage .= "- key 'third_paragraph': must exclusively talk about the replies against the initial tweet in between 10 to 120 words. \n\n";
            // $fullChatGPTMessage .= "- key 'fourth_paragraph': must exclusively talk about the neutral replies in relation to the initial tweet in between 10 to 120 words. \n\n";
            // $fullChatGPTMessage .= "- key 'fifth_paragraph: should have just the word 'FAVOR' if the rough number of replies were in favor of the initial tweet OR just the word 'AGAINST' if the rough number of replies were against the initial tweet. \n\n";

            $fullChatGPTMessage .= "- key 'first_paragraph': must have the summary of what the initial tweet is talking about in between 20 to 100 words. \n\n";
            $fullChatGPTMessage .= "- key 'second_paragraph': must exclusively talk about the replies in favor of the initial tweet in between 20 to 100 words. Important: If there are no replies in favor you must set this key to an empty string. \n\n";
            $fullChatGPTMessage .= "- key 'third_paragraph': must exclusively talk about the replies against the initial tweet in between 20 to 100 words. Important: If there are no replies against you must set this key to an empty string. \n\n";
            $fullChatGPTMessage .= "- key 'fourth_paragraph': must exclusively talk about the neutral replies in relation to the initial tweet in between 20 to 100 words. Important: If there are no neutral replies you must set this key to an empty string. \n\n";
            $fullChatGPTMessage .= "- key 'fifth_paragraph: should have just the word 'FAVOR' if the rough number of replies were in favor of the initial tweet OR just the word 'AGAINST' if the rough number of replies were against the initial tweet. \n\n";
            
            $fullChatGPTMessage .= "Important: The response MUST have just the JSON object. \n\n";
            $fullChatGPTMessage .= "Initial tweet: \n\n";
            $fullChatGPTMessage .= "$firstTweet \n\n";
            $fullChatGPTMessage .= "List of replies: \n\n";
            $fullChatGPTMessage .= $tweetsForGPT;

            dd("*************************************************************************************************************");
            dd("********************************************** CALLING CHATGPT **********************************************");
            dd("*************************************************************************************************************");
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
                'temperature' => 0.7,
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
            // $content = json_decode($json_data["choices"][0]["text"], true);
            $content = json_decode($json_data["choices"][0]["message"]["content"], true);

            dd($content);

            if ( $complete && array_key_exists('error', $json_data) ) {
                dd("****************************** VALID ERROR from CHATGPT (probably max TOKENS) ***********************************");
                $validResponse = true;
                return null;
            }
            else if ( 
                    $complete && 
                    $content &&
                    !array_key_exists('error', $json_data) &&
                    array_key_exists('first_paragraph', $content) &&
                    array_key_exists('second_paragraph', $content) &&
                    array_key_exists('third_paragraph', $content) &&
                    array_key_exists('fourth_paragraph', $content) &&
                    array_key_exists('fifth_paragraph', $content)
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


            $numberRetries = $numberRetries + 1;
            if ($numberRetries > 3) {
                dd("****************************** TRIED 3 times ALREADY and NOTHING ***********************************");
                die();
            }
        }
    }


    function callChatGPT_ConsolidateSummaries( $open_ai, $contentIn, $consolidatedIn )
    {
        dd('***** inside callChatGPT_ConsolidateSummaries');
        dd('***** content');
        dd($contentIn);
        dd('***** consolidated');
        dd($consolidatedIn);

        if ( !$contentIn && !$consolidatedIn ){
            dd('***** nothing to consolidate ********************');
            return null;
        }

        if ( $contentIn && !$consolidatedIn ){
            dd('***** empty consolidatedIn returning contentIn ********************');
            return $contentIn;
        }

        if ( !$contentIn && $consolidatedIn ){
            dd('***** empty contentIn returning consolidatedIn ********************');
            return $consolidatedIn;
        }

        $validResponse = false;
        $numberRetries = 0;

        while(!$validResponse) {
            $fullChatGPTMessage = "";
            $fullChatGPTMessage .= "Consolidate/merge the text from each key of the 2 JSON objects below in an academic paper style. The JSON response MUST have the same structure, 5 paragraphs, as follows: \n\n";
            $fullChatGPTMessage .= "- key 'first_paragraph': should have the consolidated/merged text of the keys first_paragraph. In between 20 to 150 words. \n\n";
            $fullChatGPTMessage .= "- key 'second_paragraph': should have the consolidated/merged text of the keys second_paragraph. In between 20 to 150 words. \n\n";
            $fullChatGPTMessage .= "- key 'third_paragraph': should have the consolidated/merged text of the keys third_paragraph. In between 20 to 150 words. \n\n";
            $fullChatGPTMessage .= "- key 'fourth_paragraph': should have the consolidated/merged text of the keys fourth_paragraph. In between 20 to 150 words. \n\n";
            $fullChatGPTMessage .= "- key 'fifth_paragraph: should be always an empty string. \n\n";
            $fullChatGPTMessage .= "Important: The response MUST have just the JSON object. \n\n";
            $fullChatGPTMessage .= "JSON - 1: \n\n";
            $fullChatGPTMessage .= json_encode($consolidatedIn);
            $fullChatGPTMessage .= "\n\n";
            $fullChatGPTMessage .= "JSON - 2: \n\n";
            $fullChatGPTMessage .= json_encode($contentIn);

            dd($fullChatGPTMessage);

            $complete = $open_ai->chat([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role" => "system",
                        "content" => "You are going to consolidate 2 JSON objects."
                    ],
                    [
                        "role" => "user",
                        "content" => $fullChatGPTMessage
                    ],
                ],
                'temperature' => 0.7,
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
            // $content = json_decode($json_data["choices"][0]["text"], true);
            $content = json_decode($json_data["choices"][0]["message"]["content"], true);

            dd($content);

            if ( $complete && array_key_exists('error', $json_data) ) {
                dd("****************************** VALID ERROR from CHATGPT (probably max TOKENS) ***********************************");
                $validResponse = true;
                return null;
            }
            else if ( 
                    $complete && 
                    $content &&
                    !array_key_exists('error', $json_data) &&
                    array_key_exists('first_paragraph', $content) &&
                    array_key_exists('second_paragraph', $content) &&
                    array_key_exists('third_paragraph', $content) &&
                    array_key_exists('fourth_paragraph', $content) &&
                    array_key_exists('fifth_paragraph', $content)
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


            $numberRetries = $numberRetries + 1;
            if ($numberRetries > 3) {
                dd("****************************** TRIED 3 times ALREADY and NOTHING ***********************************");
                die();
            }
        }
    }
?>

<?php

    // -----------------------------------------------------------------------------------------------------------
    // MYSQL - select the list of Tweets from the MySQL ----------------------------------------------------------
    // -----------------------------------------------------------------------------------------------------------
    //
    // Prepare the SELECT statement
    // $sql = "SELECT FROM mytable WHERE id = ?";
    $sql = "SELECT * FROM tweets where status = 'active'";

    $stmt = $pdo->prepare($sql);

    // Bind the parameter to the statement
    // $stmt->bindParam(1, $product);

    // Execute the statement and fetch the result
    $stmt->execute();
    $result = $stmt->fetchAll();
    //
    // -----------------------------------------------------------------------------------------------------------
    // MYSQL - select the list of Tweets from the MySQL ----------------------------------------------------------
    // -----------------------------------------------------------------------------------------------------------


    foreach ($result as $tweet) {

        $urlTweetDataFullset = $tweet["url_tweet_data_fullset"];
        dd('$urlTweetDataFullset = ' . $urlTweetDataFullset);
        $tweetPath = $tweet["path"];
        dd('$urlTweetDataFullset = ' . $tweetPath);
        $tweetFromId = $tweet["from_id"];
        dd('$tweetFromId = ' . $tweetFromId);


        $tweets = [];

        // ****************** calling APIFY endpoit - BEGIN

        if (false) {
        // create & initialize a curl session
        $curl = curl_init();

        // set our url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, $urlTweetDataFullset);

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
        }

        $output = '
        [
            {
                "full_text": "O cancelamento da Feira Israelense na UNICAMP por conta de manifestações contrárias é um episódio muito triste. Inviabilizaram um evento só pela participação de Israel. Isso é inaceitável. Há muito tempo nossas Universidades deixaram de ser ambientes democráticos.\n\nNão é de hoje…"
            },
            {
                "full_text": "@KimKataguiri Se vc tá triste eu tô feliz"
            },
            {
                "full_text": "@gatinncomunista @KimKataguiri E eu triste por você 😿"
            },
            {
                "full_text": "@KimKataguiri Relaxe que o amor vence sempre … o amor venceu 🫶\nOlha como eles são tolerantes.. \nmas se fosse Cuba, Venezuela … Rapaz!!"
            },
            {
                "full_text": "@KimKataguiri Enquanto não judicializarem esses episódios, nada vai mudar"
            },
            {
                "full_text": "@KimKataguiri Precisa ser judicializado, entrar com um processo contra a @ujcbr"
            },
            {
                "full_text": "@KimKataguiri a gente sabe o tipo de democracia e liberdade que você quer, lembro bem do podcast"
            },
            {
                "full_text": "@KimKataguiri Se a intenção fosse boa iriam conseguir que o evento não fosse realizado com argumento ou na justiça, mas é clara militancia por nada"
            },
            {
                "full_text": "@KimKataguiri FALA SOBRE ISSO KIM!!!!\n\n🗣🗣🗣🗣🗣 https://t.co/7mF8XAoGI6"
            },
            {
                "full_text": "@KimKataguiri Tem alguma explicação \"plausível\" para protestar contra a feira israelense?"
            },
            {
                "full_text": "@KimKataguiri 🫣 https://t.co/MR3E0Ue3Xe"
            },
            {
                "full_text": "@KimKataguiri A esquerda brasileira sempre escondeu seu ódio aos judeus com esse discurso antissionista forçado. Aceitar a existência de um estado judeu é inaceitável pra essa gente."
            },
            {
                "full_text": "@KimKataguiri Episódio triste foi o bombardeio que Israel fez à capital Síria esta noite. Cadê aquela história de respeito ao território do outro país, que vcs utilizam pra defender a ditadura nazista ucraniana?"
            },
            {
                "full_text": "@KimKataguiri Nazismo do bem"
            },
            {
                "full_text": "@KimKataguiri Kim queria mesmo é ser um líder de esquerda, mas lá  coisa é mais difícil, muita gente inteligente, é mais fácil lidar com o gado alienado. Então ele vive no purgatório da direita, ora sendo um fascistas e hora sendo um cara sério. O importante são os votos"
            },
            {
                "full_text": "@KimKataguiri Antissemitismo de esquerda é equivalente ao amor.\nEsquerda sendo esquerda. https://t.co/qrq0zFUDE4"
            },
            {
                "full_text": "@KimKataguiri Realmente, é lamentável o antissemitismo velado disfarçado de academicismo que está em voga neste país."
            },
            {
                "full_text": "@KimKataguiri Isso começou a acontecer em 2016, com o advento de grupos como o MBL, que por fim resultaram no bolsonarismo."
            },
            {
                "full_text": "@KimKataguiri Lembro da reuniões do CA, as votações só eram feitas quando restava apenas o grupelho que já tinha escolhido o resultado. Isso há 25 anos."
            },
            {
                "full_text": "@KimKataguiri Dou graças a Deus por ter feito faculdade nos anos 90... Não aguentaria o ambiente acadêmico tóxico de hoje."
            },
            {
                "full_text": "@KimKataguiri E chega de manifestação sem propósito real! Vejo muitos postarem e bradarem SALVE A AMAZÔNIA, por exemplo, e não se juntam e articulam algo para salvar a pracinha do bairro! Vamos fazer algo mais próximo, e qdo tudo ao nosso redor estiver melhor, isso refletirá no mais longe!"
            },
            {
                "full_text": "@KimKataguiri O poder público dá respaldo a esses atos, então..."
            },
            {
                "full_text": "@KimKataguiri Vai lá cobrar, a gente sabe q geral lá te ama."
            },
            {
                "full_text": "@KimKataguiri Nazistas na unicamp?"
            },
            {
                "full_text": "@KimKataguiri Não foram apenas manifestações contrárias. Houve violência."
            },
            {
                "full_text": "@KimKataguiri \"Magina\" que o Magnífico Reitor da UNICAMP emitirá uma nota \"lamemtando\" o ocorrido."
            },
            {
                "full_text": "@KimKataguiri Os responsáveis devem ser processados por crime de racismo. Cade o @MPF_SP ?"
            },
            {
                "full_text": "@KimKataguiri Violência é o que o palestino sofre diariamente. Das ocupações ilegais que Israel promove vc não fala, não crítica com essa veemência, né ?"
            },
            {
                "full_text": "@KimKataguiri @mpsp_oficial ?"
            },
            {
                "full_text": "@KimKataguiri Censura do bem! Eles podem tudo..."
            },
            {
                "full_text": "@KimKataguiri https://t.co/zuBM2ew2sG"
            },
            {
                "full_text": "@KimKataguiri Se fosse democracias como Cuba e Venezuela, tava de boas …."
            },
            {
                "full_text": "@KimKataguiri a gente sabe o nome daquilo, mas enfim"
            },
            {
                "full_text": "@KimKataguiri TKS @KimKataguiri"
            },
            {
                "full_text": "@KimKataguiri E sobre o partido nazista? Acho."
            },
            {
                "full_text": "@KimKataguiri E teve deputado da ALESP achando bonito."
            },
            {
                "full_text": "@KimKataguiri A pergunta é, qual providência os parlamentares estão tomando para melhorar a qualidade do ensino?"
            },
            {
                "full_text": "@KimKataguiri Aciona o MP..."
            },
            {
                "full_text": "@KimKataguiri https://t.co/s7P5pnqi0Y"
            },
            {
                "full_text": "@KimKataguiri Israel se vc fosse um estado legítimo quem vc seria?"
            },
            {
                "full_text": "@KimKataguiri O AMOR VENCEU 😍"
            },
            {
                "full_text": "@KimKataguiri Nossa \"imprensa\" finge que não está vendo.. @CNNBrasil @GloboNews \n\nSerá que vão chamar esses bandidos de lulistas ou vão passar a mão na cabeça desses delinquentes?"
            },
            {
                "full_text": "@KimKataguiri Faz o L 🤡 https://t.co/wEg847gIqZ"
            },
            {
                "full_text": "@KimKataguiri Tô com medo desse povo, cadê o amor?"
            },
            {
                "full_text": "@KimKataguiri Notas de repúdio!"
            },
            {
                "full_text": "@KimKataguiri Está na hora de apresentar um projeto de lei para PUNIR os reitores por esse tipo de situação."
            },
            {
                "full_text": "@KimKataguiri Não tem conversa com país que impõe apartheid"
            },
            {
                "full_text": "@KimKataguiri Sei lá talvez deveriam fazer uma chamada no BBB, para conscientização ou a Anita usar uma calcinha com a escrita \" que mundo é esse?\"!"
            },
            {
                "full_text": "@KimKataguiri Cadê o policiamento pra garantir a andamento do evento, já que era tão importante assim e tinha até participação de outros países???? Brasil nunca será nada se continuar com a esquerda, nunca!!!!!!"
            },
            {
                "full_text": "@KimKataguiri Relaxa @KimKataguiri bolsonaro e a turma do PT/MST eram iguais; o amor finalmente venceu"
            },
            {
                "full_text": "@KimKataguiri Democracia? Se fosse algo da Venezuela, Nicaragua, como seria?"
            },
            {
                "full_text": "@KimKataguiri Seus amigos petistas que apoiam isso https://t.co/vP9OOF6TIf"
            },
            {
                "full_text": "@KimKataguiri https://t.co/FYBdjwiRxw"
            },
            {
                "full_text": "@KimKataguiri é o anti-semitismo do bem, só é nazismo quando é de direita"
            },
            {
                "full_text": "@KimKataguiri E isso aí que precisa ser regulado essa farra de militância de DCE que acha que universidades públicas são de propriedade deles, passou dos limites tá na hora de vcs apresentar um projeto que cria algum tipo de norma para impedir esse tipo de coisa faculdade pública e de todos."
            },
            {
                "full_text": "@KimKataguiri Sem entrar no mérito da motivação, manifestação , debate e divergência essência da democracia Deputado, ou só vale a narrativa quando é para espalhar fake news?"
            },
            {
                "full_text": "@KimKataguiri Curioso, eu lembro de outro grupo que era contra judeus"
            },
            {
                "full_text": "@KimKataguiri Tu avisou o pessoal da feira israelense que você apoia a existência de partidos nazistas no Brasil?!"
            },
            {
                "full_text": "@KimKataguiri Depois que aparecer um governo de ultra-direita e acaba com as universidades, com apoio popular, não haverá pelo que protestar. É saudável a convivência com os diferentes...Universal, universidade...tendeu?"
            },
            {
                "full_text": "@KimKataguiri Universidades não é espaço para canalhas."
            },
            {
                "full_text": "@KimKataguiri Vai fazer uma nota de repúdio? \n\nPutaqueopariu"
            },
            {
                "full_text": "@KimKataguiri Vc como político, procure tomar atitudes para que isso não ocorra mais."
            },
            {
                "full_text": "@KimKataguiri Os universitários ditadores (boa parte deles, playboys) só devem dar ar cartas nas universidades. Fora dali, devem fazer os pais dormirem quando começam com seus discursinhos fajutos. Os vizinhos se escondem. Os amigos mudam de assunto. São chatos e ditadores. ninguém gosta!"
            },
            {
                "full_text": "@KimKataguiri Ninguém quer sua solidariedade. Tome uma atitude contra isso. Você é deputado, pode tomar uma atitude enérgica. Notas de repúdio quem faz somos nós os internautas."
            },
            {
                "full_text": "@KimKataguiri Vc apoio tudo isso não se lembra , então vou mandar uma foto sua com essa turma https://t.co/wVXvRvN4np"
            },
            {
                "full_text": "@KimKataguiri Mt engraçado vc dizendo q tem q ter a feira de israelense por conta de pluralidade, mas defendeu a criação de um partido nazista ao vivo na conversa com o monark.\nSe faz de desentendido, se faz..."
            },
            {
                "full_text": "@KimKataguiri Ambiente democratico é diferente de ambiente despolitizado. Nao confunda."
            },
            {
                "full_text": "@KimKataguiri o cara paga Twitter Blue pra escrever textao kkkkkkk"
            },
            {
                "full_text": "@KimKataguiri Já temos insegurança jurídica, insegurança na economia e agora insegurança nas universidades. Uma maldição esse Petismo."
            },
            {
                "full_text": "@KimKataguiri A @tabataamaralsp não vai se manifestar em repúdio aos atos da extrema esquerda?? 🤔"
            },
            {
                "full_text": "@KimKataguiri Bom dia. Infelizmente não vai dar em nada reclamar. Os pseudo-alunos não serão punidos e no meio em que habitam serão elogiados."
            },
            {
                "full_text": "@KimKataguiri Vote nulo"
            },
            {
                "full_text": "@KimKataguiri Impeçam mais este retrocesso desse desgoverno... https://t.co/5XVvFMBNG9"
            },
            {
                "full_text": "@KimKataguiri Bandeiras dos EUA e de Israel queimando 🤝"
            },
            {
                "full_text": "@KimKataguiri Já que tu não aceita, senta e chora."
            },
            {
                "full_text": "@KimKataguiri Triste é o que Israel faz com a Palestina, mas vc não tem sensibilidade suficiente para ter algo chamado humanismo, opta em defender um país que propaga ódio."
            },
            {
                "full_text": "@KimKataguiri Israel é super democrática com a Palestina. A gente percebe...."
            },
            {
                "full_text": "@KimKataguiri E Israel é democrático por acaso ?"
            },
            {
                "full_text": "@KimKataguiri Deve ter alguma coisa a ver com o que aquele povo anda fazendo com os palestinos. Acho que eu também não apoiaria. Pare de ficar querendo ficar bem na fita com a comunidade judaica e insinuar antissemitismo."
            },
            {
                "full_text": "@KimKataguiri Vc chega a ser engraçado até,  de tão medíocre"
            },
            {
                "full_text": "@KimKataguiri O amor venceu."
            },
            {
                "full_text": "@KimKataguiri Vamos fazer uma feira Russa junto. Assim aprendemos com eles como invadir países e bombardear as casas das pessoas que tornamos refugiados depois de tomar as terra deles. HIPOCRISIA É MATO NO MBL..."
            },
            {
                "full_text": "@KimKataguiri Tipo essas \"manifestações\" aqui sr deputado ?? \n\nhttps://t.co/vVXr8EBAoj"
            },
            {
                "full_text": "@KimKataguiri Israel n existe e n deve ser reconhecida,q vá pra fora das nossas universidades"
            },
            {
                "full_text": "@KimKataguiri O crime que os bandidos cometeram na UNICAMP não pode passar despercebido, esses criminosos precisam irem para a cadeia e serem expulsos de qualquer universidade que façam parte"
            },
            {
                "full_text": "@KimKataguiri Tu quer é muita pika"
            },
            {
                "full_text": "@KimKataguiri E trabalhar que é bom nada né deputado !?"
            },
            {
                "full_text": "@KimKataguiri Faz o L katacoquinho"
            },
            {
                "full_text": "@KimKataguiri São apenas massas de manobras,verdadeiros bonecos de ventríloquo,achando que sabem de muita coisa."
            },
            {
                "full_text": "@KimKataguiri Palestina sofre muito e vcs defendem quem tem maior poder economico. O Dinheiro acima de tudo."
            },
            {
                "full_text": "@KimKataguiri https://t.co/2P9RDWIO1A"
            },
            {
                "full_text": "@KimKataguiri Aí ai"
            },
            {
                "full_text": "@KimKataguiri Não são manifestantes contrários, são radicais de extrema esquerda antissemitas \nA prudência no tratamento deste imbecis neste tipo de acontecimento ajudam que eles percebam a fraqueza e o medo. E os encorajam a atacar sem piedade ou receio"
            },
            {
                "full_text": "@KimKataguiri O que tens a falar do povo palestinos? Conte pra nós, vcs viu o primeiro ministro d Israel, sobre a suprema corte  deles? Conte pra nós estes fatos pra não sermos enganados pelas mídias d plantão"
            },
            {
                "full_text": "@KimKataguiri Estão deixando essa gente ir longe demais. Vocês precisam se unir para o bem do Brasil."
            },
            {
                "full_text": "@KimKataguiri Nessa sou obrigado a concordar com você."
            },
            {
                "full_text": "@KimKataguiri Como torcer para os filhos passarem em uma universidade federal se cada vez mais elas pioram o ensino e aumentam as balbúrdias. \nIntolerância ,\nDrogas, \nAtivismo antidemocrático ,\nViolência.\nDentro das UFs e IFs deveriam existir ordem,   segurança, principalemte disciplina"
            },
            {
                "full_text": "@KimKataguiri Jura!!??"
            },
            {
                "full_text": "@KimKataguiri Mas era tudo igual né?"
            },
            {
                "full_text": "@KimKataguiri Quem estava lutando para acabar com a politizaçao ridícula da universidades, o amigo lutou pra tirar. Agora apresenta a tua solução aí, gênio."
            },
            {
                "full_text": "@KimKataguiri Isso não seria antissemitismo??????"
            },
            {
                "full_text": "@KimKataguiri Nossa… antissemitismo será? Que horror!"
            },
            {
                "full_text": "@KimKataguiri Democrático é defender partido n@zista?"
            },
            {
                "full_text": "@KimKataguiri Esse é o Brazil do lulala que vc ajudou a eleger"
            },
            {
                "full_text": "@KimKataguiri Nossa, lembrei de um deputado que foi em um podcast defender a existência de um partido NAZI, que coisa…"
            },
            {
                "full_text": "@KimKataguiri @jonesmanoel_PE"
            },
            {
                "full_text": "@KimKataguiri Tem que cancelar mesmo. Sionistas não tem lugar em uma sociedade democrática."
            },
            {
                "full_text": "@KimKataguiri Na foto em vi uns 15 \"manifestantes\", num campus com 11 mil funcionários e 30 mil alunos. Fazer o que? Ir lá bater boca?"
            },
            {
                "full_text": "@KimKataguiri 1 fuzil resolve tudo"
            },
            {
                "full_text": "@KimKataguiri Tem que ser feito algo, qualquer um que queira impor sua vontade sem aceitar o contraditório deveria ser expulso, não pagamos para “educar” militantes, mas cidadãos de todo espectro ideológico e que saiba debater e viver em ambiente de pluralidade 😉"
            },
            {
                "full_text": "@KimKataguiri Faz décadas que é assim, tá atrasado hein..."
            },
            {
                "full_text": "@KimKataguiri Protesto é uma coisa, violência é outra. \"Manifestações contrárias\" seriam aceitáveis, mas houve violência física."
            },
            {
                "full_text": "@KimKataguiri Parabéns a Unicamp."
            },
            {
                "full_text": "@KimKataguiri deputado que defende a existência de partido nazista é democrático?"
            },
            {
                "full_text": "@KimKataguiri Não adianta falar isso é depois ir lá fazer selfie com quem comanda tudo isso. Hipocrisia que chama ?"
            },
            {
                "full_text": "@KimKataguiri Nazistas"
            },
            {
                "full_text": "@KimKataguiri O amor venceu, a tolerância venceu,  a diversidade venceu."
            },
            {
                "full_text": "@KimKataguiri Engraçado como as pessoas tem a capacidade de ler A, entender B e responder Z"
            },
            {
                "full_text": "@KimKataguiri Olha o estatuto e cobra na lei"
            },
            {
                "full_text": "@KimKataguiri Isso se chama auto regulação de mercado, o direitista reclamando. Kkkm"
            },
            {
                "full_text": "@KimKataguiri Isso só ocorre pq eles aceitam ser tratados como coitados e acham que com este tipo de imposição vão melhorar a vida deles. É a chamada massa de bestas das universidades e escolas, já que ambas deixaram de ensinar para passar a doutrinar."
            },
            {
                "full_text": "@KimKataguiri Em dizer que vc é cúmplice disso hein..."
            },
            {
                "full_text": "@KimKataguiri Desde 2019, pau que bate em Chico bate em Francisco"
            },
            {
                "full_text": "@KimKataguiri Vc ajudou essa militância política voltar ⏮️"
            },
            {
                "full_text": "@KimKataguiri bom é Israel bombardear ne?"
            },
            {
                "full_text": "@KimKataguiri Kim, vc e o resto do pessoal de direita não tá sabendo lidar com esse tema. Essa é uma das melhores chances q a gnt tá tendo de desmascarar o pessoal da esquerda, tem que chamar eles das mesmas coisas q te chamaram qnd tu foi pro Flow, só assim vai mostrar a índole dessa gente"
            },
            {
                "full_text": "@KimKataguiri Normal ter um partido nazista, né ?"
            },
            {
                "full_text": "@KimKataguiri Finalmente não falou m....."
            },
            {
                "full_text": "@KimKataguiri E ainda dizem que o nazismo não é de esquerda."
            },
            {
                "full_text": "@KimKataguiri E cadê a punição dos estudantes que fizeram isso?"
            },
            {
                "full_text": "@KimKataguiri Vai fazer feira no Afeganistão."
            },
            {
                "full_text": "@KimKataguiri Isso que este \"estudantes\" fizeram não é antissemitismo ? e depois querem chamar a direita de fascismo"
            },
            {
                "full_text": "@KimKataguiri Calma !!!\nJá já você vai querer falar em dar luz ao nazismo, outra vez"
            },
            {
                "full_text": "@KimKataguiri MBL assim como PT se alimentam do caos , da pobreza e da ignorância"
            },
            {
                "full_text": "@KimKataguiri É o que nosso mundo está virando... Uma m.... dominada por nada menos que m..... Eles não querem e não gostam de progresso.\nMas agora eles estão fortalecidos com a m.... do nosso desgoverno."
            },
            {
                "full_text": "@KimKataguiri https://t.co/Fc0osV6od8"
            },
            {
                "full_text": "@KimKataguiri Faz o L, vc apoiou essa gente"
            },
            {
                "full_text": "@KimKataguiri Vai ter feira não"
            },
            {
                "full_text": "@KimKataguiri Ia ter spray nasal que o bananinha foi em Israel buscar??"
            },
            {
                "full_text": "@KimKataguiri Faça alguma coisa @KimKataguiri .\nSolidariedade não resolve nada."
            },
            {
                "full_text": "@KimKataguiri Pois é, é tipo tentar impedir uma exposição de museu só pq não concorda com os artistas."
            },
            {
                "full_text": "@KimKataguiri Faça o L"
            },
            {
                "full_text": "@KimKataguiri MBL é a anti-sala do fascismo. https://t.co/CPMcO84ZxG"
            },
            {
                "full_text": "@KimKataguiri Existe universitários no Brasil?  Pra mim o que existe é  (¨%$#¨&amp;*&amp;¨)"
            },
            {
                "full_text": "@KimKataguiri ...universidade publica:cursos  deveriam ser pagos ..."
            },
            {
                "full_text": "@KimKataguiri E a cartinha pela democracia não resolveu ?"
            },
            {
                "full_text": "@KimKataguiri Fascismo modo turbo nitro."
            },
            {
                "full_text": "@KimKataguiri FODASE Israel, sou 1000 X mais UNICAMP. Melhor curso de Engenharia Elétrica do mundo! Pioneira na area de Robótica."
            },
            {
                "full_text": "@KimKataguiri Agora que vc percebeu???"
            },
            {
                "full_text": "@KimKataguiri Duvido que você vá falar sobre isso aqui, quim 👇\nhttps://t.co/K13Nps0OJc"
            },
            {
                "full_text": "@KimKataguiri Que triste né, meia dúzia de estudantes protestando. Que ambiente hostil. Imagina se fosse isso aqui 👇🏽 https://t.co/S1omHpxQ7L"
            },
            {
                "full_text": "@KimKataguiri Depois o Nazista era o Bozo.\nAnti semitismo é a marca registrada dos nazistas."
            },
            {
                "full_text": "@KimKataguiri O que o povo de Israel tem a ver com isso?\nÉ a mesma coisa que condenar o povo Russo pelos atos de seu presidente."
            },
            {
                "full_text": "@KimKataguiri Mas e aí? Não é a hora de enquadrar as universidades? Eu posso discordar do @AbrahamWeint , mas nisso ele tinha razão, enquanto mantivermos reitores com salários gordos e vindo de partidos ideologicamente covardes como os de esquerda, teremos isso."
            },
            {
                "full_text": "@KimKataguiri Subiu no palanque com o pt  pra derrubar bolsonaro,🤮"
            },
            {
                "full_text": "@KimKataguiri Pra começo de conversa Israel ta em guerra com terroristas Palestinos e nao com o governo palestino. Bandidos no Brasil mata MUITO mais q Israel e esse mesmo povo passa a mão na cabeça. HIPOCRISIA QUE FALA NÉ?"
            },
            {
                "full_text": "@KimKataguiri É Nazista que fala?!"
            },
            {
                "full_text": "@KimKataguiri Cancelou foi pouco\nSem lugar pra nazi-sionistas"
            },
            {
                "full_text": "@KimKataguiri https://t.co/zpRxIlY8nk"
            },
            {
                "full_text": "@KimKataguiri Acho q teve um lider q odiava Judeus, ele fez umas coisinhas para tentar acabar com eles... Nesse momento ele deve estar sorrindo do inferno vendo esses \"estudantes\" propagar o ódio dele..."
            },
            {
                "full_text": "@KimKataguiri E aí? Vai culpar o Presidente Bolsonaro?"
            },
            {
                "full_text": "@KimKataguiri Dizem que estão chamando os estudantes de nazistas.... é verdade?"
            },
            {
                "full_text": "@KimKataguiri E sobre as joias?"
            },
            {
                "full_text": "@KimKataguiri Larguei direito na UFRJ justamente por isso. É insuportável."
            },
            {
                "full_text": "@KimKataguiri Cara, vc é um típico frustrado que não consegue passar em Cálculo I, por pura preguiça, na verdade. Aí vem com essa conversa mole 😂🤦"
            },
            {
                "full_text": "@KimKataguiri Tem método...."
            },
            {
                "full_text": "@KimKataguiri https://t.co/ml554ntJau"
            },
            {
                "full_text": "@KimKataguiri Oswaldo Aranha, Brasil, Israel. Fica a dor, o lamento e o não entendimento dessa idiotice chamada aluno politizado gourmet. Os caras ainda não sabem nem o que é a vida e ficam pagando de revolucionários EAD. Ir pra guerra ninguém quer, lá a mesada do pai não serve pra nada."
            },
            {
                "full_text": "@KimKataguiri O amor venceu"
            },
            {
                "full_text": "@KimKataguiri Estado sionista massacra o povo palestino"
            },
            {
                "full_text": "@KimKataguiri O deputado que defende um partido n@zist@ falando de democracia em uma universidade pública quem será que tá errado?"
            },
            {
                "full_text": "@KimKataguiri L"
            },
            {
                "full_text": "@KimKataguiri Esta na hora do freio nessa galera, inclusive professores, tem que haver um projeto que proiba esse tipo de assunto (política) em salas de aula, escolas e faculdades, salvo cursos específicos."
            },
            {
                "full_text": "@KimKataguiri https://t.co/g25orfbzZ4"
            },
            {
                "full_text": "@KimKataguiri Sim e ficará por isso mesmo? Quais medidas serão tomadas?"
            },
            {
                "full_text": "@KimKataguiri As universidades é muito gente, deputadinho Kim. Vc fala como se meia duzia fosse o todo. Inclusive o joio das universidades acaba na política, como tu."
            },
            {
                "full_text": "@KimKataguiri Esse registro é importante como referência do que a esquerda faz contra Israel e sua postura de ódio contra aquele país e seu povo. \n\nAcho que não resta a menor dúvida se os nazistas são esquerdistas ou não são."
            },
            {
                "full_text": "@KimKataguiri É tudo que a esquerda quer, um bando de alienados e dependentes do governo. Triste."
            },
            {
                "full_text": "@KimKataguiri Anti-semitismo simples assim! Ah agora tem uma roupa nova. Não podemos matá-los, mas podemos dizer que eles não tem direito de viver em sua terra Natal."
            },
            {
                "full_text": "@KimKataguiri Oxi mas não foi você que defendeu um partido nazista!?!"
            },
            {
                "full_text": "@KimKataguiri O cara defende um país que reprime a Palestina de maneira covarde e cruel e vem falar em democracia universitária? Só pode ser piada de mal gosto."
            },
            {
                "full_text": "@KimKataguiri Pq não fazem o mesmo nos eventos de esquerda??? Tem medo? Ou são frouxos"
            },
            {
                "full_text": "@KimKataguiri Qual universidade você frequentou, para tr conhecimento de causa? @KimKataguiri"
            },
            {
                "full_text": "@KimKataguiri Falou o Dep. Que esteve junto com essa galera falando em \"democracia\".\n\nVai jogar videogame japa, não enche o saco."
            },
            {
                "full_text": "@KimKataguiri Não seria racismo isso ?"
            },
            {
                "full_text": "@KimKataguiri Pense num cara hipócrita esse Kim. Ele é do tipo faça o que eu digo mas não faça o que eu faço. Mais um com o selo óleo de peroba de qualidade."
            },
            {
                "full_text": "@KimKataguiri Nem todo comunista, mas sempre um comunista."
            },
            {
                "full_text": "@KimKataguiri Ainda bem que os movimentos progressistas chegaram a esse estágio, de não ser tolerante com os intolerantes."
            },
            {
                "full_text": "@KimKataguiri Não abre mais essa boca…vc apoiou tudo isso"
            },
            {
                "full_text": "@KimKataguiri Israel é democrático?"
            },
            {
                "full_text": "@KimKataguiri Faz o L !!🤡🤡"
            },
            {
                "full_text": "@KimKataguiri Façam em outro lugar, é cada uma."
            },
            {
                "full_text": "@KimKataguiri Pronto! Agora já pode falar do golpe no Supremo por Netanyaho e do massacre do povo palestino pelos sionistas de Israel."
            },
            {
                "full_text": "@KimKataguiri Olha o defensor dos judeus que apoiam a não criminalização de um partido que prega o extermínio de judeus"
            },
            {
                "full_text": "@KimKataguiri Unicamp antes do Lula já era antro de esquerda. Depois de 2002 então. Hoje então.... Não a toa que é de lá que saem as ideias econômicas dignas do haddad"
            },
            {
                "full_text": "@KimKataguiri É uma pena...e lamentável...e isso não pode ocorrer...e isso acontece há muito tempo...\n\nPor isso, como membro do Legislativo, vou propor o projeto UniverCidade...vou criar uma CPI para entender o aparelhamento político e fomento de DCEs...ops...a segunda parte tu esqueceu."
            },
            {
                "full_text": "@KimKataguiri Faz o L"
            },
            {
                "full_text": "@KimKataguiri Vai trabalhar atoa"
            },
            {
                "full_text": "@KimKataguiri Militantes travestidos de Deputados !!! https://t.co/HkBj23AMCm"
            },
            {
                "full_text": "@KimKataguiri Tivemos quatro anos pra limpar nossas universidades e não conseguimos! Os vermelhos continuam lá dentro, no comando!!"
            },
            {
                "full_text": "@KimKataguiri E ai deputado, vai propor algum projeto para limitar este abestamento estudantil, ou vai apenas lamentar no twitter?"
            },
            {
                "full_text": "@KimKataguiri Cadê a galera contra o nazismo agora?"
            },
            {
                "full_text": "@KimKataguiri Penso quem tem a perde com isso o os estudantes brasileiros ou Israelitas"
            }
        ]
        ';


        $json_data = json_decode($output, true);

        dd("********************************* APIFY ");

        foreach ($json_data as $index => $tweet) {

            $comment = substr($tweet["full_text"], 0, 1800);

            // preparing/cleaning the text
            $pos = strpos($comment, $tweetFromId);
            if ($pos !== false) {
                $rest = substr($comment, $pos + strlen($tweetFromId));
                $comment = $rest;
            }

            $comment = str_replace("'", ' ', $comment);
            $comment = str_replace('"', ' ', $comment);
            $comment = str_replace(array("\r\n", "\r", "\n"), '', $comment);

            $tweets[] = $comment;

            dd($tweet["full_text"]);

        }


        // GET the initial POST and remove it fromo the list of tweets
        $firstTweet = array_shift($tweets);




        // ****************** GET ONLY $max items randomly
        $max = 50;
        if (count($tweets) > $max) {
            // Get an array of $max random keys from the original array
            $randomKeys = array_rand($tweets, $max);

            // Create a new array with the $max random items
            $randomItems = array();
            foreach ($randomKeys as $key) {
                $randomItems[] = $tweets[$key];
            }

            $tweets = $randomItems;
        }
        dd("*************************************************************************************************************");
        dd("************************************* ALL TWEETS **********************************************");
        dd("*************************************************************************************************************");
        dd($tweets);



        
        $consolidatedSummaries = null;
        $consolidatedInFavor = 0;
        $consolidatedAgainst = 0;

        $numberTweetsForGPT = 1;
        $tweetsForGPT = "";

        foreach ($tweets as $index => $comment) {

            // appending to the list of tweets
            $tweetsForGPT = $tweetsForGPT . "- " . $comment . "\n\n";


            if (($numberTweetsForGPT == 20) || ($index == count($tweets) - 1)) {

                dd("****************************** STARTING PROCESSING the BATCH - INDEX = $index ***********************************");

                // ******************** CALLCHATGPT ********************
                $content = callChatGPT_OriginalTweets($open_ai, $tweetsForGPT, $firstTweet);

                if ( $content ) {
                    dd("****************************** summary from the BATCH ***********************************");
                    dd($content);


                    dd("****************************** STARTING CONSOLIDATING ***********************************");
                    // **********************************************************************************
                    // ****************** CONSOLIDATE
                    // **********************************************************************************

                    if ($content["fifth_paragraph"] == "FAVOR") {
                        $consolidatedInFavor = $consolidatedInFavor + $numberTweetsForGPT;
                    }
                    else if ($content["fifth_paragraph"] == "AGAINST") {
                        $consolidatedAgainst = $consolidatedAgainst + $numberTweetsForGPT;
                    }

                    dd($consolidatedInFavor);
                    dd($consolidatedAgainst);

                    // ****************** consolidate summary
                    dd('***** consolidate summary');
                    $newConsolidatedSummaries = callChatGPT_ConsolidateSummaries ($open_ai, $content, $consolidatedSummaries);
                    if ( $newConsolidatedSummaries ) {
                        $consolidatedSummaries = $newConsolidatedSummaries;
                    }
                }
                else {
                    dd("****************************** ERROS PROCESSING the BATCH ***********************************");
                }


                $numberTweetsForGPT = 0;
                $tweetsForGPT = "";
            }

            $numberTweetsForGPT = $numberTweetsForGPT + 1;
        }



        dd("************************************************************************************************");
        dd("****************************** FINAL CONSOLIDATED ***********************************");
        dd("************************************************************************************************");
        dd($consolidatedSummaries);
        die();




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