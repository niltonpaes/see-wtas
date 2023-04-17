<?php
 function dd($value)
 {
     echo "<br><pre>";
     var_dump($value);
     echo "</pre><br>";

     // die();
 }
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    dd("deu merda - customErrorHandler");
    dd($errno);
    dd($errstr);
    dd($errfile);
    dd($errline);
}
  
// set_error_handler("customErrorHandler");

dd("Teste: $teste");

$complete = ' "choices": [
    {
        "message": {
            "role": "assistant",
            "content": "{
                "pros": [    
                    "Silent clicks",    
                    "Customizable settings",    
                    "Great for scrolling websites",    
                    "Effortless connection",    
                    "Fast and accurate",
                    ],
                    "cons": [    
                        "Randomly disconnects from MacBook Pro",    
                        "Cannot pair with MX Keys",    
                        "Slightly big for mobile use",    
                        "Horizontal scrolling needs to be paused to change direction",    
                        "DPI could be higher",
                        ],
                        "total_reviews": 19,
                        "positive_reviews": 16,
                        "negative_reviews": 3\n
                        }"
        },
        "finish_reason": "stop",
        "index": 0
    }
]
';
dd($complete);

$json_data = json_decode($complete, true);
dd($json_data ?? "nulo");

$content = json_decode($json_data["choices"][0]["message"]["content"], true);
dd($content);





