INSERT INTO
    `seewtas`.`tweets` (
        `path`,
        `from_id`,
        `from_name`,
        `category_en`,
        `category_ptbr`,
        `sub_category_en`,
        `sub_category_ptbr`,
        `url_tweet_api_data`,
        `tweet_blockquote`
    )
VALUES
    (
        'BolsonaroSP-1650538474691231744',
        '@BolsonaroSP',
        'Eduardo Bolsonaro',
        'Politics',
        'Política',
        'Adriano Machado, Reuters, photographer, coverage, inauguration, prints, blocked',
        'Adriano Machado, Reuters, fotógrafo, cobertura, posse, prints, bloqueado',
        'https://api.apify.com/v2/datasets/S7RQA0VsM9PyAwPJe/items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=%s&limit=%s&fields=full_text',
        '<blockquote class=\"twitter-tweet\"><p lang=\"pt\" dir=\"ltr\">Posso até ser bloqueado mas os prints mostrando a cobertura do fotógrafo do Reuters, Adriano Machado, na posse já estão por todo lado. <a href=\"https://t.co/8KZ7KWHbN3\">pic.twitter.com/8KZ7KWHbN3</a></p>&mdash; Eduardo Bolsonaro🇧🇷 (@BolsonaroSP) <a href=\"https://twitter.com/BolsonaroSP/status/1650538474691231744?ref_src=twsrc%5Etfw\">April 24, 2023</a></blockquote>'
    );