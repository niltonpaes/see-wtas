CREATE DATABASE  IF NOT EXISTS `seewtas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `seewtas`;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: seewtas
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tweets` (
  `index` bigint unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_en` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_ptbr` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_category_en` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_category_ptbr` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_tweet_api_data` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tweet_blockquote` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `summary_en` json DEFAULT NULL,
  `summary_ptbr` json DEFAULT NULL,
  `hits` mediumint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status_torun` tinyint(1) DEFAULT '0',
  `status_ok` tinyint(1) DEFAULT '0',
  `error` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_toprod` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`index`),
  UNIQUE KEY `path_UNIQUE` (`path`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
INSERT INTO `tweets` VALUES (1,'KimKataguiri-1643242411542425605','@KimKataguiri','Kim Kataguiri','Politics','Política','\"Feira Israelense, UNICAMP, Israel, cancellation, protests, democracy, totalitarianism, intolerance, coexistence, universities, plurality of ideas, rectorship, public power, solidarity, students, victims','Feira Israelense, UNICAMP, Israel, cancelamento, manifestações, democracia, totalitarismo, intolerância, convivência, universidades, pluralidade de ideias, reitoria, poder público, solidariedade, estudantes, vítimas','https://api.apify.com/v2/datasets/aKPhjcmX6XLh3U4Ih/items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=%s&limit=%s&fields=full_text','<blockquote class=\"twitter-tweet\"><p lang=\"pt\" dir=\"ltr\">O cancelamento da Feira Israelense na UNICAMP por conta de manifestações contrárias é um episódio muito triste. Inviabilizaram um evento só pela participação de Israel. Isso é inaceitável. Há muito tempo nossas Universidades deixaram de ser ambientes democráticos.<br><br>Não é de hoje…</p>&mdash; Kim Kataguiri (@KimKataguiri) <a href=\"https://twitter.com/KimKataguiri/status/1643242411542425605?ref_src=twsrc%5Etfw\">April 4, 2023</a></blockquote> ','{\"ai\": \"The cancellation of the Israeli fair at UNICAMP due to protests highlights the ongoing tensions surrounding the Israeli-Palestinian conflict and the role of universities in promoting free speech and political discourse. While some argue that the cancellation was necessary to prevent hate speech and discrimination, others see it as an infringement on academic freedom and a form of censorship. It is important to recognize the complex historical and political factors at play in this situation, including the ongoing occupation of Palestine by Israel and the rise of far-right and nationalist movements around the world. Ultimately, finding a path towards peace and justice in the region will require dialogue, empathy, and a commitment to human rights and dignity for all.\", \"cons\": [\"Many people are expressing opposition to the initial tweet\'s stance in favor of the Israeli fair at UNICAMP.\", \"Some are criticizing Israel\'s actions towards Palestine.\", \"Others are calling out the hypocrisy of the initial tweet\'s author and the MBL.\"], \"pros\": [\"Many people are expressing support for the initial tweet\'s stance against the cancellation of the Israeli fair at UNICAMP due to protests.\", \"Some are criticizing the left\'s supposed anti-Semitic tendencies.\", \"Others are calling for punishment for those who caused the cancellation.\"], \"neutral\": [\"Some people are asking for more information or context about the situation.\", \"Others are discussing the role of universities in promoting democracy and free speech.\", \"Some are questioning the effectiveness of protests and cancelations in achieving political goals.\"], \"consTotal\": \"66.67%\", \"prosTotal\": \"16.67%\", \"neutralTotal\": \"16.67%\"}','{\"ai\": \"O cancelamento da feira israelense na UNICAMP devido a protestos destaca as tensões em curso em torno do conflito israelense-palestino e o papel das universidades na promoção da liberdade de expressão e do discurso político. Enquanto alguns argumentam que o cancelamento era necessário para impedir discursos de ódio e discriminação, outros veem isso como uma violação da liberdade acadêmica e uma forma de censura. É importante reconhecer os complexos fatores históricos e políticos envolvidos nesta situação, incluindo a ocupação contínua da Palestina por Israel e o surgimento de movimentos de extrema-direita e nacionalistas ao redor do mundo. Por fim, encontrar um caminho para a paz e justiça na região exigirá diálogo, empatia e comprometimento com os direitos humanos e a dignidade de todos.\", \"cons\": [\"Muitas pessoas estão expressando oposição à posição inicial do tweet em favor da feira israelense na UNICAMP.\", \"Alguns estão criticando as ações de Israel em relação à Palestina.\", \"Outros estão denunciando a hipocrisia do autor do tweet inicial e do MBL.\"], \"pros\": [\"Muitas pessoas estão expressando apoio à posição inicial do tweet contra o cancelamento da feira israelense na UNICAMP devido a protestos.\", \"Alguns estão criticando as supostas tendências antissemitas da esquerda.\", \"Outros estão pedindo punição para os responsáveis pelo cancelamento.\"], \"neutral\": [\"Algumas pessoas estão pedindo mais informações ou contexto sobre a situação.\", \"Outros estão discutindo o papel das universidades na promoção da democracia e da liberdade de expressão.\", \"Algumas estão questionando a eficácia de protestos e cancelamentos na consecução de objetivos políticos.\"], \"consTotal\": \"66,67%\", \"prosTotal\": \"16,67%\", \"neutralTotal\": \"16,67%\"}',NULL,'2023-04-06 01:59:45','2023-04-06 01:59:45',0,1,NULL,1),(2,'choquei-1644790157210447883','@choquei','choquei','Society/Culture','Sociedade/Cultura','VEJA, mother, different method, child, not getting lost, viral video, internet users, divided opinions','VEJA, mãe, método diferente, filho, não se perder, vídeo viral, usuários da internet, opiniões divididas','https://api.apify.com/v2/datasets/Q3cBcSygeI46zpLwb/items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=%s&limit=%s&fields=full_text','<blockquote class=\"twitter-tweet\"><p lang=\"pt\" dir=\"ltr\">?VEJA: Mãe usa método diferente para filho não se perder, vídeo viraliza na web e divide opinões entre os internautas. <br><br> <a href=\"https://t.co/ol5msBgSpK\">pic.twitter.com/ol5msBgSpK</a></p>&mdash; CHOQUEI (@choquei) <a href=\"https://twitter.com/choquei/status/1644790157210447883?ref_src=twsrc%5Etfw\">April 8, 2023</a></blockquote>','{\"ai\": \"The use of leashes or harnesses for children is a controversial topic that raises questions about parenting styles, child safety, and social norms. While some parents see this method as a practical solution to keep their children safe and under control, others argue that it is dehumanizing and sends the wrong message to children. From a historical perspective, the use of leashes for children is not new and has been documented in various cultures and time periods. However, the social and cultural context in which this method is used can influence how it is perceived and accepted. For example, in some countries, the use of leashes for children is more common and accepted than in others. Additionally, the use of leashes for children with special needs or behavioral issues may be more justified than for typically developing children. Overall, the use of leashes for children is a personal choice that should be based on the child\'s individual needs and the parent\'s judgment.\", \"cons\": [\"Some people criticized this method, saying that it treats children like dogs or animals.\", \"A few people argued that this method is unnecessary and that parents should be responsible for their children without using a leash.\", \"A couple of people mentioned that this method could potentially harm the child\'s physical development if the leash is too tight or used for extended periods of time.\"], \"pros\": [\"Many parents agree that this method is practical and provides protection and security for the child.\", \"Some parents appreciate the freedom and mobility that this method gives to the child.\", \"A few people mentioned that this method is not new and has been used for years.\", \"Others pointed out that this method is especially useful for children with autism or other special needs.\"], \"neutral\": [\"Some people were indifferent to this method, saying that it is up to each parent to decide what is best for their child.\", \"A few people pointed out that this method is not new and has been used for years.\", \"Others mentioned that this method is practical and useful in certain situations, such as crowded places or when the child is particularly active.\"], \"consTotal\": \"20%\", \"prosTotal\": \"60%\", \"neutralTotal\": \"20%\"}','{\"ai\": \"O uso de coleiras ou arreios para crianças é um tópico controverso que levanta questões sobre estilos de parentalidade, segurança infantil e normas sociais. Enquanto alguns pais veem este método como uma solução prática para manter seus filhos seguros e sob controle, outros argumentam que é desumanizante e envia a mensagem errada para as crianças. Do ponto de vista histórico, o uso de coleiras para crianças não é novo e foi documentado em várias culturas e períodos de tempo. No entanto, o contexto social e cultural em que este método é usado pode influenciar como ele é percebido e aceito. Por exemplo, em alguns países, o uso de coleiras para crianças é mais comum e aceito do que em outros. Além disso, o uso de coleiras para crianças com necessidades especiais ou problemas comportamentais pode ser mais justificado do que para crianças tipicamente em desenvolvimento. Em geral, o uso de coleiras para crianças é uma escolha pessoal que deve ser baseada nas necessidades individuais da criança e no julgamento dos pais.\", \"cons\": [\"Algumas pessoas criticaram este método, dizendo que trata as crianças como cães ou animais.\", \"Algumas pessoas argumentaram que este método é desnecessário e que os pais devem ser responsáveis por seus filhos sem usar uma coleira.\", \"Algumas pessoas mencionaram que este método pode potencialmente prejudicar o desenvolvimento físico da criança se a coleira estiver muito apertada ou for usada por longos períodos de tempo.\"], \"pros\": [\"Muitos pais concordam que este método é prático e fornece proteção e segurança para a criança.\", \"Alguns pais apreciam a liberdade e mobilidade que este método dá à criança.\", \"Algumas pessoas mencionaram que este método não é novo e tem sido usado há anos.\", \"Outros destacaram que este método é especialmente útil para crianças com autismo ou outras necessidades especiais.\"], \"neutral\": [\"Algumas pessoas foram indiferentes a este método, dizendo que cabe a cada pai decidir o que é melhor para seu filho.\", \"Algumas pessoas apontaram que este método não é novo e tem sido usado há anos.\", \"Outros mencionaram que este método é prático e útil em certas situações, como lugares lotados ou quando a criança está particularmente ativa.\"], \"consTotal\": \"20%\", \"prosTotal\": \"60%\", \"neutralTotal\": \"20%\"}',NULL,'2023-04-06 01:59:45','2023-04-06 01:59:45',0,1,NULL,1),(6,'realDailyWire-1646143795333943296','@realDailyWire','Daily Wire','Society/Culture','Sociedade/Cultura','BBC, journalist, Twitter, hateful content, rise, Elon Musk, example, lied','BBC, jornalista, Twitter, conteúdo odioso, aumento, Elon Musk, exemplo, mentiu','https://api.apify.com/v2/datasets/DvT2zEe81Vv46Dfit/items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=%s&limit=%s&fields=full_text','<blockquote class=\"twitter-tweet\"><p lang=\"en\" dir=\"ltr\">BBC journalist: “There’s been a rise in hateful content on Twitter.”<br><br>Elon Musk: “Give me an example.”<br><br>Journalist: “I can’t.”<br><br>Musk: “You just lied.” <a href=\"https://t.co/LONdKdZJH8\">pic.twitter.com/LONdKdZJH8</a></p>&mdash; Daily Wire (@realDailyWire) <a href=\"https://twitter.com/realDailyWire/status/1646143795333943296?ref_src=twsrc%5Etfw\">April 12, 2023</a></blockquote>','{\"ai\": \"The discussion around hateful content on social media platforms like Twitter is complex and multifaceted. While it is important to address and combat hate speech and harmful content, it is equally important to ensure that claims are based on evidence and not just personal opinions or biases. Moreover, the issue of regulating online speech raises questions about free speech, censorship, and the role of social media companies in shaping public discourse. As such, it is crucial to approach this issue with nuance and to consider the broader social, cultural, economic, scientific, historical, and political factors that contribute to the problem of hateful content on social media.\", \"cons\": [\"Some people criticize the BBC journalist for not being prepared and not providing evidence to support the claim of a rise in hateful content on Twitter.\", \"A few people accuse the BBC of being a Marxist propaganda news agency and spreading mis/disinformation.\", \"Some people argue that hateful content is everywhere on the internet and that the journalist\'s claim is not surprising.\"], \"pros\": [\"Elon Musk challenges a BBC journalist to provide an example of the rise in hateful content on Twitter and exposes the lack of evidence behind the claim.\", \"Many people praise Elon Musk for fact-checking the journalist and exposing lazy journalism.\", \"Some people appreciate Elon Musk\'s critical analysis and common sense approach to the issue of hateful content on Twitter.\"], \"neutral\": [\"A few people share their personal experience with hateful content on Twitter.\", \"Some people comment on the quality of modern journalism and the need for evidence-based reporting.\", \"A few people make jokes or memes about the situation.\"], \"consTotal\": \"32%\", \"prosTotal\": \"58%\", \"neutralTotal\": \"10%\"}','{\"ai\": \"A discussão em torno de conteúdo odioso em plataformas de mídia social como o Twitter é complexa e multifacetada. Embora seja importante abordar e combater discursos de ódio e o conteúdo prejudicial, é igualmente importante garantir que as afirmações sejam baseadas em evidências e não apenas em opiniões pessoais ou preconceitos. Além disso, a questão de regular o discurso online suscita questões sobre liberdade de expressão, censura e o papel das empresas de mídia social na formação do discurso público. Como tal, é crucial abordar essa questão com nuance e considerar os fatores sociais, culturais, econômicos, científicos, históricos e políticos mais amplos que contribuem para o problema do conteúdo odioso nas mídias sociais.\", \"cons\": [\"Algumas pessoas criticam o jornalista da BBC por não estar preparado e não fornecer evidências para apoiar a afirmação de um aumento de conteúdo odioso no Twitter.\", \"Algumas pessoas acusam a BBC de ser uma agência de notícias de propaganda marxista e disseminar desinformação.\", \"Algumas pessoas argumentam que conteúdo odioso está em toda parte na internet e que a afirmação do jornalista não é surpreendente.\"], \"pros\": [\"Elon Musk desafia um jornalista da BBC a fornecer um exemplo do aumento de conteúdo odioso no Twitter e expõe a falta de evidências por trás da afirmação.\", \"Muitas pessoas elogiam Elon Musk por verificar os fatos do jornalista e expor o jornalismo preguiçoso.\", \"Algumas pessoas apreciam a análise crítica de Elon Musk e sua abordagem consciente à questão do conteúdo odioso no Twitter.\"], \"neutral\": [\"Algumas pessoas compartilham sua experiência pessoal com conteúdo odioso no Twitter.\", \"Algumas pessoas comentam sobre a qualidade do jornalismo moderno e a necessidade de relatórios baseados em evidências.\", \"Algumas pessoas fazem piadas ou memes sobre a situação.\"], \"consTotal\": \"32%\", \"prosTotal\": \"58%\", \"neutralTotal\": \"10%\"}',NULL,'2023-04-14 05:32:47','2023-04-14 05:32:47',0,1,NULL,1),(10,'BolsonaroSP-1650538474691231744','@BolsonaroSP','Eduardo Bolsonaro','Politics','Política','Adriano Machado, Reuters, photographer, coverage, inauguration, prints, blocked','Adriano Machado, Reuters, fotógrafo, cobertura, posse, prints, bloqueado','https://api.apify.com/v2/datasets/S7RQA0VsM9PyAwPJe/items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=%s&limit=%s&fields=full_text','<blockquote class=\"twitter-tweet\"><p lang=\"pt\" dir=\"ltr\">Posso até ser bloqueado mas os prints mostrando a cobertura do fotógrafo do Reuters, Adriano Machado, na posse já estão por todo lado. <a href=\"https://t.co/8KZ7KWHbN3\">pic.twitter.com/8KZ7KWHbN3</a></p>&mdash; Eduardo Bolsonaro?? (@BolsonaroSP) <a href=\"https://twitter.com/BolsonaroSP/status/1650538474691231744?ref_src=twsrc%5Etfw\">April 24, 2023</a></blockquote>','{\"ai\": \"The Twitter thread reflects the current state of political discourse in Brazil, marked by polarization, disinformation, and intolerance. The controversy over the photographer\'s coverage of the presidential inauguration illustrates the challenges faced by journalists in a context of political tension and hostility. The blocking of the initial tweet and the attempts to discredit the photographer\'s work and the authenticity of the images reveal the fragility of democratic institutions and the importance of a free press to hold power accountable. The use of screenshots and social media to preserve evidence and share information highlights the potential of technology to empower citizens and promote transparency. However, the proliferation of fake news, hate speech, and online harassment also exposes the risks of digital platforms and the need for ethical and responsible use of technology. Ultimately, the Twitter thread shows that the issues at stake go beyond the specific event and involve fundamental values such as truth, justice, and democracy.\", \"cons\": [\"Accusations of the photographer being a leftist and involved in a conspiracy.\", \"Insinuations that the photographer was paid by the government or the opposition.\", \"Claims that the photographer was involved in illegal activities or supported vandalism.\", \"Denial of the photographer\'s credibility and the authenticity of the images.\", \"Attacks on the initial tweet\'s author and his family, including personal insults and threats.\"], \"pros\": [\"Support for the photographer\'s coverage of the presidential inauguration.\", \"Acknowledgment of the photographer\'s job to cover political events.\", \"Defense of the journalist\'s work and the importance of a free press.\", \"Criticism of the blocking of the initial tweet and the attempt to silence voices.\", \"Recognition of the importance of evidence and the use of screenshots to preserve it.\"], \"neutral\": [\"Questions about the photographer\'s profession, age, and political affiliation.\", \"Comments on the political polarization, censorship, and freedom of expression.\", \"References to other events, such as the alleged fake stabbing of the president.\", \"Ironic comments, jokes, and memes about the situation and the people involved.\", \"Calls for investigations, justice, and transparency regarding the events.\"], \"consTotal\": \"83.0%\", \"prosTotal\": \"10.6%\", \"neutralTotal\": \"6.4%\"}','{\"ai\": \"O thread do Twitter reflete o atual estado do discurso político no Brasil, marcado por polarização, desinformação e intolerância. A controvérsia sobre a cobertura da posse presidencial pelo fotógrafo ilustra os desafios enfrentados pelos jornalistas em um contexto de tensão e hostilidade políticas. O bloqueio do tweet original e as tentativas de desacreditar o trabalho do fotógrafo e a autenticidade das imagens revelam a fragilidade das instituições democráticas e a importância de uma imprensa livre para responsabilizar o poder. O uso de capturas de tela e das mídias sociais para preservar evidências e compartilhar informações destaca o potencial da tecnologia para capacitar os cidadãos e promover a transparência. No entanto, a proliferação de notícias falsas, discurso de ódio e assédio online também expõe os riscos das plataformas digitais e a necessidade de uso ético e responsável da tecnologia. Em última análise, o thread do Twitter mostra que as questões em jogo vão além do evento específico e envolvem valores fundamentais como verdade, justiça e democracia.\", \"cons\": [\"Acusações de que o fotógrafo é de esquerda e envolvido em uma conspiração.\", \"Insinuações de que o fotógrafo foi pago pelo governo ou pela oposição.\", \"Alegações de que o fotógrafo estava envolvido em atividades ilegais ou apoiava vandalismo.\", \"Negação da credibilidade do fotógrafo e da autenticidade das imagens.\", \"Ataques ao autor do tweet original e sua família, incluindo insultos pessoais e ameaças.\"], \"pros\": [\"Apoio à cobertura do fotógrafo da posse presidencial.\", \"Reconhecimento do trabalho do fotógrafo em cobrir eventos políticos.\", \"Defesa do trabalho do jornalista e da importância de uma imprensa livre.\", \"Crítica ao bloqueio do tweet original e à tentativa de silenciar vozes.\", \"Reconhecimento da importância de evidências e do uso de capturas de tela para preservá-las.\"], \"neutral\": [\"Perguntas sobre a profissão, idade e afiliação política do fotógrafo.\", \"Comentários sobre a polarização política, censura e liberdade de expressão.\", \"Referências a outros eventos, como a suposta facada falsa do presidente.\", \"Comentários irônicos, piadas e memes sobre a situação e as pessoas envolvidas.\", \"Pedidos de investigações, justiça e transparência em relação aos eventos.\"], \"consTotal\": \"83,0%\", \"prosTotal\": \"10,6%\", \"neutralTotal\": \"6,4%\"}',NULL,'2023-04-24 18:32:58','2023-04-24 18:32:58',0,1,NULL,1),(11,'ClownWorld-1650469810227249152','@ClownWorld_','Clown World','Society/Culture','Sociedade/Cultura','why, hell, think, funny','por que, diabo, achar, engraçado','https://api.apify.com/v2/datasets/nTqVVmrJx8ylYhzfE/items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=%s&limit=%s&fields=full_text','<blockquote class=\"twitter-tweet\"><p lang=\"en\" dir=\"ltr\">Why the hell did he think this was going to be funny? ?‍♂️ <a href=\"https://t.co/sLa5rrbrVh\">pic.twitter.com/sLa5rrbrVh</a></p>&mdash; Clown World ™ ? (@ClownWorld_) <a href=\"https://twitter.com/ClownWorld_/status/1650469810227249152?ref_src=twsrc%5Etfw\">April 24, 2023</a></blockquote>','{\"ai\": \"The initial tweet and subsequent responses highlight the complex and often contentious issue of homelessness in society. While some may view the young man\'s actions as harmless or humorous, many others see it as a cruel and disrespectful act towards a vulnerable individual. The discussion also touches on broader issues of privilege, empathy, and societal values. It is important to recognize the humanity and dignity of all individuals, regardless of their circumstances, and to work towards creating a more compassionate and equitable society.\", \"cons\": [\"Many people are against the initial tweet, calling it cruel, heartless, and disrespectful towards the homeless man\", \"Some people are questioning the authenticity of the video and suggesting it was staged\", \"Others are criticizing the young man\'s upbringing and lack of empathy\", \"Many are calling for consequences for the young man\'s actions, such as unemployment or public shaming\", \"Several people are expressing their disgust and disappointment with the young man\'s behavior\"], \"pros\": [\"No one is in favor of the initial tweet\"], \"neutral\": [\"Some people are making jokes or sarcastic comments about the situation\", \"A few are questioning the homeless man\'s choices and suggesting he deserved to be treated poorly\", \"Others are commenting on the state of society and the lack of empathy towards the homeless\", \"Some are simply expressing their shock or confusion about the video\"], \"consTotal\": \"84.6%\", \"prosTotal\": \"2.7%\", \"neutralTotal\": \"12.7%\"}','{\"ai\": \"O tweet inicial e as respostas subsequentes destacam a questão complexa e muitas vezes controversa da falta de moradia na sociedade. Embora alguns possam ver as ações do jovem como inofensivas ou engraçadas, muitos outros o veem como um ato cruel e desrespeitoso com um indivíduo vulnerável. A discussão também aborda questões mais amplas de privilégio, empatia e valores sociais. É importante reconhecer a humanidade e a dignidade de todos os indivíduos, independentemente de suas circunstâncias, e trabalhar para criar uma sociedade mais compassiva e justa.\", \"cons\": [\"Muitas pessoas são contra o tweet inicial, chamando-o de cruel, sem coração e desrespeitoso com o homem sem-teto\", \"Algumas pessoas questionam a autenticidade do vídeo e sugerem que foi encenado\", \"Outros estão criticando a criação do jovem e a falta de empatia\", \"Muitos estão pedindo consequências para as ações do jovem, como desemprego ou vergonha pública\", \"Várias pessoas estão expressando sua nojo e decepção com o comportamento do jovem\"], \"pros\": [\"Ninguém está a favor do tweet inicial\"], \"neutral\": [\"Algumas pessoas estão fazendo piadas ou comentários sarcásticos sobre a situação\", \"Algumas questionam as escolhas do homem sem-teto e sugerem que ele merecia ser tratado mal\", \"Outros comentam sobre o estado da sociedade e a falta de empatia em relação aos sem-teto\", \"Algumas pessoas simplesmente expressam seu choque ou confusão sobre o vídeo\"], \"consTotal\": \"84,6%\", \"prosTotal\": \"2,7%\", \"neutralTotal\": \"12,7%\"}',NULL,'2023-04-25 01:14:55','2023-04-25 01:14:55',0,1,NULL,1),(13,'felipeneto-1650546314063622145','@felipeneto','Felipe Neto','Politics','Política','Sergio Moro, internet regulation, autonomous regulator, transparency, fines, expert opinion, platform control, censorship','Sergio Moro, regulamentação da internet, regulador autônomo, transparência, multas, opinião de especialistas, controle de plataformas, censura','https://api.apify.com/v2/datasets/gqR9VAhEzkVCygWC6/items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=%s&limit=%s&fields=full_text','<blockquote class=\"twitter-tweet\"><p lang=\"pt\" dir=\"ltr\">A fala do ex-juiz suspeito Sergio Moro é mentirosa e vergonhosa.<br><br>O Projeto de Lei de regulamentação da internet prevê a criação de um órgão regulador AUTÔNOMO e INDEPENDENTE para se relacionar com as plataformas.<br><br>Assim como existe o CRM, a OAB, a Anvisa, a Anatel e tantos…</p>&mdash; Felipe Neto ? (@felipeneto) <a href=\"https://twitter.com/felipeneto/status/1650546314063622145?ref_src=twsrc%5Etfw\">April 24, 2023</a></blockquote>','{\"ai\": \"The debate over regulating the internet is a complex and multifaceted issue that touches on a range of social, cultural, economic, scientific, historical, and political factors. On the one hand, there is a growing concern about the spread of misinformation, hate speech, and other harmful content online, and many people believe that some form of regulation is necessary to address these issues. On the other hand, there are also concerns about the potential for censorship, government overreach, and the stifling of free speech and innovation. In order to find a solution that balances these competing interests, it may be necessary to engage in a broader conversation about the role of the internet in society, and to explore alternative approaches to regulation that prioritize transparency, accountability, and democratic participation.\", \"cons\": [\"Many people are against the idea of an autonomous and independent regulatory body for the internet, as they believe it could lead to censorship and be used as a tool for political persecution.\", \"Some people believe that the ex-judge Sergio Moro is not credible and is not knowledgeable about laws.\", \"Others argue that there is no guarantee that such a regulatory body would be truly independent and autonomous, as it could still be controlled by the government or other powerful interests.\", \"Many people are concerned about the potential negative consequences of regulating the internet, such as limiting free speech and stifling innovation.\", \"Some people argue that the existing regulatory bodies, such as Anatel and Anvisa, are not truly independent and autonomous, and are often influenced by political interests.\"], \"pros\": [\"None\"], \"neutral\": [\"Some people are unsure about the idea of regulating the internet, and are open to hearing more about the potential benefits and drawbacks.\", \"Others are skeptical about the ability of any regulatory body to effectively regulate the internet, given its decentralized and global nature.\", \"Some people are curious about the specifics of the proposed regulatory body, such as who would be in charge and how it would be funded.\"], \"consTotal\": \"90.48%\", \"prosTotal\": \"4.76%\", \"neutralTotal\": \"4.76%\"}','{\"ai\": \"O debate sobre a regulamentação da internet é uma questão complexa e multifacetada que envolve uma série de fatores sociais, culturais, econômicos, científicos, históricos e políticos. Por um lado, há uma crescente preocupação com a disseminação de desinformação, discurso de ódio e outros conteúdos prejudiciais online, e muitas pessoas acreditam que alguma forma de regulamentação é necessária para lidar com esses problemas. Por outro lado, também há preocupações com o potencial de censura, excessos do governo e sufocamento da liberdade de expressão e inovação. Para encontrar uma solução que equilibre esses interesses concorrentes, pode ser necessário engajar em uma conversa mais ampla sobre o papel da internet na sociedade e explorar abordagens alternativas à regulamentação que priorizem a transparência, a responsabilidade e a participação democrática.\", \"cons\": [\"Muitas pessoas são contra a ideia de um órgão regulador autônomo e independente para a internet, pois acreditam que isso poderia levar à censura e ser usado como uma ferramenta para perseguição política.\", \"Algumas pessoas acreditam que o ex-juiz Sergio Moro não é credível e não tem conhecimento sobre leis.\", \"Outros argumentam que não há garantia de que esse órgão regulador seria realmente independente e autônomo, já que ainda poderia ser controlado pelo governo ou outros interesses poderosos.\", \"Muitas pessoas estão preocupadas com as potenciais consequências negativas da regulamentação da internet, como limitar a liberdade de expressão e sufocar a inovação.\", \"Algumas pessoas argumentam que os órgãos reguladores existentes, como a Anatel e a Anvisa, não são realmente independentes e autônomos, e são frequentemente influenciados por interesses políticos.\"], \"pros\": [\"Nenhum\"], \"neutral\": [\"Algumas pessoas não têm certeza sobre a ideia de regular a internet e estão abertas a ouvir mais sobre os possíveis benefícios e desvantagens.\", \"Outras são céticas sobre a capacidade de qualquer órgão regulador de regular efetivamente a internet, dada sua natureza descentralizada e global.\", \"Algumas pessoas estão curiosas sobre os detalhes do órgão regulador proposto, como quem estaria no comando e como seria financiado.\"], \"consTotal\": \"90,48%\", \"prosTotal\": \"4,76%\", \"neutralTotal\": \"4,76%\"}',NULL,'2023-04-25 01:28:22','2023-04-25 01:28:22',0,1,NULL,1),(15,'MapleLeafs-1650692284617302018','@MapleLeafs','Toronto Maple Leafs','Sports','Esportes','feelings, inquiry, emotion, expression, Toronto Maple Leafs, Tampa Bay Lightning, NHL, Stanley Cup','sentimentos, questionamento, emoção, expressão, Toronto Maple Leafs, Tampa Bay Lightning, NHL, Stanley Cup ','https://api.apify.com/v2/datasets/Kv9lGLekUYvNNBfwF/items?token=apify_api_7YCeaeDtENG6R6TlAN783bA1Z6Y3Pg3uTsQv&offset=%s&limit=%s&fields=full_text','<blockquote class=\"twitter-tweet\"><p lang=\"en\" dir=\"ltr\">Will ask again …. HOW WE FEELIN!!!!!<a href=\"https://twitter.com/LGCanada?ref_src=twsrc%5Etfw\">@LGCanada</a> | <a href=\"https://twitter.com/hashtag/LeafsForever?src=hash&amp;ref_src=twsrc%5Etfw\">#LeafsForever</a> <a href=\"https://t.co/AJ7eeyJU6I\">pic.twitter.com/AJ7eeyJU6I</a></p>&mdash; Toronto Maple Leafs (@MapleLeafs) <a href=\"https://twitter.com/MapleLeafs/status/1650692284617302018?ref_src=twsrc%5Etfw\">April 25, 2023</a></blockquote>','{\"ai\": \"The recent playoff series between the Leafs and the Lightning highlights the importance of momentum in sports. The Leafs\' ability to come back from a 3-1 deficit and win two games in a row shows the power of confidence and momentum in sports. This can be seen in other sports as well, such as basketball, where a team that wins a close game often has an advantage in the next game due to the confidence boost. Additionally, the passionate and emotional reactions of fans on social media demonstrate the strong connection between sports and culture, as well as the importance of sports in bringing people together and creating a sense of community.\", \"cons\": [\"Some fans expressing frustration and disappointment with the team\'s performance in previous games.\", \"Some fans expressing skepticism and doubt about the team\'s ability to win the series.\", \"Some fans expressing their annoyance with the initial tweet and the team\'s social media presence.\"], \"pros\": [\"Fans expressing their excitement and support for the Leafs\' recent comeback win in the playoffs.\", \"Fans expressing their confidence in the team\'s ability to win the next game and the series.\", \"Fans praising the team\'s growth and maturity throughout the season.\", \"Fans expressing their love for the team and their passion for the game.\"], \"neutral\": [\"Some fans requesting specific content, such as Bowen\'s call of the winning goal.\", \"Some fans making jokes or humorous comments about the game.\", \"Some fans expressing shock or disbelief at the team\'s comeback.\", \"Some fans expressing their love for the game of hockey and the playoffs in general.\"], \"consTotal\": \"4.9%\", \"prosTotal\": \"88.7%\", \"neutralTotal\": \"6.4%\"}','{\"ai\": \"A série recente dos playoffs entre os Leafs e o Lightning destaca a importância do momentum no esporte. A habilidade dos Leafs de voltar de um déficit de 3-1 e vencer dois jogos seguidos mostra o poder da confiança e momentum no esporte. Isso pode ser visto em outros esportes também, como no basquete, onde uma equipe que vence um jogo acirrado frequentemente tem vantagem no próximo jogo devido ao impulso de confiança. Além disso, as reações apaixonadas e emocionais dos torcedores nas mídias sociais demonstram a forte conexão entre esporte e cultura, bem como a importância do esporte em unir pessoas e criar um senso de comunidade.\", \"cons\": [\"Alguns torcedores expressando frustração e desapontamento com o desempenho da equipe em jogos anteriores.\", \"Alguns torcedores expressando ceticismo e dúvida sobre a habilidade da equipe em vencer a série.\", \"Alguns torcedores expressando sua irritação com o tweet inicial e a presença da equipe nas mídias sociais.\"], \"pros\": [\"Torcedores expressando sua excitação e apoio pela vitória de virada dos Leafs nos playoffs.\", \"Torcedores expressando sua confiança na habilidade da equipe em vencer o próximo jogo e a série.\", \"Torcedores elogiando o crescimento e maturidade da equipe ao longo da temporada.\", \"Torcedores expressando seu amor pela equipe e sua paixão pelo jogo.\"], \"neutral\": [\"Alguns torcedores pedindo conteúdo específico, como a narração de Bowen do gol da vitória.\", \"Alguns torcedores fazendo piadas ou comentários engraçados sobre o jogo.\", \"Alguns torcedores expressando choque ou incredulidade com a virada da equipe.\", \"Alguns torcedores expressando seu amor pelo esporte do hóquei e os playoffs de uma forma geral.\"], \"consTotal\": \"4,9%\", \"prosTotal\": \"88,7%\", \"neutralTotal\": \"6,4%\"}',NULL,'2023-04-25 03:37:12','2023-04-25 03:37:12',0,1,NULL,1);
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-25  0:15:49
