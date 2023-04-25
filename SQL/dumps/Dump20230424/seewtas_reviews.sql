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
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `index` bigint unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_en` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_ptbr` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_category_en` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_category_ptbr` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_bestbuy` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,'logitech-mx-master-3s','https://multimedia.bbycastatic.ca/multimedia/products/500x500/161/16157/16157519.jpg','Logitech MX Master 3S','Logitech','Computer Accessories','Acessórios de Computador','Mice & Keyboards','Mouses e Teclados','https://www.bestbuy.ca/api/reviews/v2/products/16157519/reviews?source=all&lang=en-CA&pageSize=10&page=%s&sortBy=date&sortDir=desc','{\"cons\": [\"Limited programmability\", \"A bit heavy\"], \"pros\": [\"Smooth and accurate cursor movement\", \"Ultra-quiet operation\", \"Customizable buttons within individual apps\", \"Works directly on glass\", \"Great for CAD modelling\", \"Ergonomic design\", \"Tactile feel of mouse buttons\", \"Rechargeable battery\", \"Comfortable grip\", \"Useful horizontal scrolling\", \"Fast and easy to use\", \"Great for document reviewers\", \"Fits nicely in hand\", \"Good for spreadsheets\", \"Responsive for music and video production\", \"Good for gaming\", \"Consistent and reliable\", \"Very tactile while being very quiet\", \"One of the best mice out there\", \"Great all-around mouse\"], \"neutral\": [\"Limited to Microsoft Office Pro 2019\", \"Expensive but worth the money\", \"Software doesn\'t work always\", \"Lagging here and there\", \"Bulky to carry around\", \"Not a good gaming mouse\", \"Only works with Logi Options+ application\"], \"consTotal\": 2, \"prosTotal\": 66, \"neutralTotal\": 7}','{\"cons\": [\"Programação limitada\", \"Um pouco pesado\"], \"pros\": [\"Movimento suave e preciso do cursor\", \"Operação ultra silenciosa\", \"Botões personalizáveis dentro de aplicativos individuais\", \"Funciona diretamente em superfícies de vidro\", \"Ótimo para modelagem CAD\", \"Design ergonômico\", \"Sensação táctil dos botões do mouse\", \"Bateria recarregável\", \"Pegada confortável\", \"Scroll horizontal útil\", \"Rápido e fácil de usar\", \"Ótimo para revisores de documentos\", \"Encaixa bem na mão\", \"Bom para planilhas\", \"Responsivo para produção de música e vídeo\", \"Bom para jogos\", \"Consistente e confiável\", \"Muito tátil enquanto é muito silencioso\", \"Um dos melhores mouses do mercado\", \"Ótimo mouse para todas as finalidades\"], \"neutral\": [\"Limitado ao Microsoft Office Pro 2019\", \"Caro, mas vale o dinheiro\", \"O software nem sempre funciona\", \"Alguma lentidão aqui e ali\", \"Volumoso para ser transportado\", \"Não é um bom mouse para jogos\", \"Funciona apenas com o aplicativo Logi Options+\"], \"consTotal\": 2, \"prosTotal\": 66, \"neutralTotal\": 7}',NULL,'2023-03-29 03:23:28','2023-03-29 03:23:28',0,1,NULL,1),(2,'dyson-v8-animal-cordless-stick-vacuum','https://multimedia.bbycastatic.ca/multimedia/products/500x500/152/15265/15265629.jpg','Dyson V8 Animal Cordless Stick Vacuum','Dyson','Vacuums & Floor Care','Aspiradores e Limpeza de Pisos','Stick Vacuums','Aspiradores Verticais (Stick Vacuums)','https://www.bestbuy.ca/api/reviews/v2/products/15265629/reviews?source=all&lang=en-CA&pageSize=10&page=%s&sortBy=date&sortDir=desc','{\"cons\": [\"Battery life could be longer\", \"Small dust compartment\", \"Expensive\", \"Battery life drains quickly on high suction\", \"Battery takes a long time to charge\", \"Difficult to clean\", \"Suction quality decreases over time\"], \"pros\": [\"Lightweight and portable\", \"Powerful suction\", \"No cords or canisters to deal with\", \"Good for pet hair\", \"Easy to maneuver\", \"Good for quick clean-ups\", \"Excellent performance\", \"Versatile use of handheld to floor\", \"Great for hard surfaces and rugs\", \"Quick charge time\", \"Easy to use and store\", \"Good for small messes\", \"Lots of attachments\", \"Great for cleaning car\", \"Very functional\", \"Quiet operation\", \"Beautiful design\", \"Compact size\", \"Effective at removing dust and dirt\", \"Good for cleaning edges and corners\"], \"neutral\": [\"Mixed feelings on battery life\", \"Not enough battery life for larger areas\", \"Dirt compartment could be bigger\", \"Docking station only holds two attachments\", \"Trigger doesn\'t lock\"], \"consTotal\": 7, \"prosTotal\": 62, \"neutralTotal\": 5}','{\"cons\": [\"Vida útil da bateria poderia ser mais longa\", \"Compartimento de poeira pequeno\", \"Caro\", \"Vida útil da bateria esgota rapidamente em alta sucção\", \"Bateria leva muito tempo para carregar\", \"Difícil de limpar\", \"Qualidade de sucção diminui ao longo do tempo\"], \"pros\": [\"Leve e portátil\", \"Sucção poderosa\", \"Sem fios ou reservatórios para lidar\", \"Bom para pelos de animais\", \"Fácil de manobrar\", \"Bom para limpezas rápidas\", \"Excelente desempenho\", \"Uso versátil de manual para chão\", \"Ótimo para superfícies duras e tapetes\", \"Tempo de carga rápida\", \"Fácil de usar e armazenar\", \"Bom para pequenas bagunças\", \"Muitos acessórios\", \"Ótimo para limpeza de carro\", \"Muito funcional\", \"Operação silenciosa\", \"Design bonito\", \"Tamanho compacto\", \"Efetivo na remoção de poeira e sujeira\", \"Bom para limpeza de bordas e cantos\"], \"neutral\": [\"Sentimentos mistos sobre vida útil da bateria\", \"Não há bateria suficiente para áreas maiores\", \"Compartimento de sujeira poderia ser maior\", \"Estação de ancoragem só contém dois acessórios\", \"Gatilho não trava\"], \"consTotal\": 7, \"prosTotal\": 62, \"neutralTotal\": 5}',NULL,'2023-03-29 03:23:28','2023-03-29 03:23:28',0,1,NULL,1),(5,'logitech-studio-desk-mat ','https://multimedia.bbycastatic.ca/multimedia/products/500x500/157/15766/15766138.jpg','Logitech Studio Desk Mat','Logitech','Computer Accessories','Acessórios de Computador','Mice & Keyboards','Mouses e Teclados','https://www.bestbuy.ca/api/reviews/v2/products/15766138/reviews?source=all&lang=en-CA&pageSize=10&page=%s&sortBy=date&sortDir=desc','{\"cons\": [\"Quality falls short and mouse won\'t sense after a month\"], \"pros\": [\"Feels great right out of the box\", \"Large enough area for moving the mouse around\", \"Protects desk and looks good\", \"Quality desk mat with no signs of cheap corners\", \"Great product with a even greater price\", \"Perfect mousepad with nice stitching\", \"Soft fabric and good traction for day to day and office use\", \"Matches the look I was going for on my desk\", \"Super nice color and feel that contrasts great with black peripherals\", \"Fits a full sized keyboard and mouse with room to spare\", \"Great for laptop and monitor set up\", \"Awesome mousepad with great material and value\", \"Great addition to home office set-up\", \"Perfect size for keyboard and mouse\", \"High quality mouse pad with nice design\", \"Well constructed and goes well with Logitech keyboard and mouse\", \"Replaced 2 items with one item\", \"Breathes life into an otherwise bland desk\", \"Soft fabric and good traction for daily use\", \"Gray color matches new MX Keys\"], \"neutral\": [\"Great desk mat but the color makes it a stain magnet\", \"Quality of the material could be better\", \"Issue with keeping it clean\"], \"consTotal\": 1, \"prosTotal\": 66, \"neutralTotal\": 5}','{\"cons\": [\"A qualidade deixa a desejar e o mouse não responde após um mês\"], \"pros\": [\"Ótima sensação ao retirar da caixa\", \"Área grande o suficiente para movimentar o mouse\", \"Protege a mesa e tem boa aparência\", \"Tapete de mesa de qualidade sem sinais de cantos baratos\", \"Ótimo produto com preço ainda melhor\", \"Mousepad perfeito com costura agradável\", \"Tecido macio e boa tração para uso diário e de escritório\", \"Combina com a aparência que eu queria para a minha mesa\", \"Cor e sensação super agradáveis ​​que contrastam muito bem com os periféricos pretos\", \"Serve para um teclado de tamanho completo e mouse com espaço de sobra\", \"Ótimo para configuração de laptop e monitor\", \"Mousepad incrível com excelente material e valor\", \"Ótima adição para configuração de home office\", \"Tamanho perfeito para teclado e mouse\", \"Mousepad de alta qualidade com bom design\", \"Bem construído e combina bem com teclado e mouse da Logitech\", \"Substituiu 2 itens por um\", \"Dá vida a uma mesa sem graça\", \"Tecido macio e boa tração para uso diário\", \"Cor cinza combina com o novo MX Keys\"], \"neutral\": [\"Ótimo tapete de mesa, mas a cor faz com que seja um ímã de manchas\", \"Qualidade do material poderia ser melhor\", \"Problema para mantê-lo limpo\"], \"consTotal\": 1, \"prosTotal\": 66, \"neutralTotal\": 5}',NULL,'2023-04-02 04:12:31','2023-04-02 04:12:31',0,1,NULL,1),(6,'dyson-v15-detect-total-clean-cordless-stick-vacuum','https://multimedia.bbycastatic.ca/multimedia/products/500x500/152/15265/15265969.jpg','Dyson V15 Detect Total Clean Cordless Stick Vacuum','Dyson','Vacuums & Floor Care','Aspiradores e Limpeza de Pisos','Stick Vacuums','Aspiradores Verticais (Stick Vacuums)','https://www.bestbuy.ca/api/reviews/v2/products/15265969/reviews?source=all&lang=en-CA&pageSize=10&page=%s&sortBy=date&sortDir=desc','{\"cons\": [\"Expensive\", \"Trigger requires constant pressure to activate\"], \"pros\": [\"Powerful suction\", \"Laser light identifies hidden dirt\", \"Easy to use\", \"Great for pet hair\", \"Excellent for hardwood floors\", \"Lightweight\", \"Includes useful accessories\", \"Cleans efficiently\", \"Reliable\", \"Cordless\", \"Long battery life\", \"Quiet\", \"Laser dust light is helpful\", \"Great for basic house chores\", \"Great for allergies\", \"Good for cleaning cars\", \"Works better than previous vacuum\", \"Fun to use\", \"Great for OCD cleaning\", \"Makes floors look cleaner\"], \"neutral\": [\"Some reviewers wish it came with more than one battery\", \"Some reviewers found it heavier than expected\", \"One reviewer had issues with the LCD screen\"], \"consTotal\": 2, \"prosTotal\": 66, \"neutralTotal\": 2}','{\"cons\": [\"Caro\", \"Gatilho requer pressão constante para ativar\"], \"pros\": [\"Sucção poderosa\", \"Luz laser identifica sujeira escondida\", \"Fácil de usar\", \"Ótimo para pelos de animais\", \"Excelente para pisos de madeira\", \"Leve\", \"Inclui acessórios úteis\", \"Limpa eficientemente\", \"Confiável\", \"Sem fio\", \"Longa duração da bateria\", \"Silencioso\", \"Laser dust light é útil\", \"Ótimo para tarefas domésticas básicas\", \"Ótimo para alergias\", \"Bom para limpar carros\", \"Funciona melhor do que o aspirador anterior\", \"Divertido de usar\", \"Ótimo para limpeza OCD\", \"Faz os pisos parecerem mais limpos\"], \"neutral\": [\"Alguns avaliadores gostariam que viesse com mais de uma bateria\", \"Alguns avaliadores acharam mais pesado do que o esperado\", \"Um avaliador teve problemas com a tela LCD\"], \"consTotal\": 2, \"prosTotal\": 66, \"neutralTotal\": 2}',NULL,'2023-04-12 03:50:02','2023-04-12 03:50:02',0,1,NULL,1),(7,'jbl-boombox-2-waterproof-bluetooth-wireless-speaker','https://multimedia.bbycastatic.ca/multimedia/products/500x500/144/14498/14498673.jpg','BL Boombox 2 Waterproof Bluetooth Wireless Speaker','JBL','Portable Audio','Áudio Portátil','\rPortable Bluetooth Speakers','Caixas de Som Portáteis Bluetooth','https://www.bestbuy.ca/api/reviews/v2/products/14498673/reviews?source=all&lang=en-CA&pageSize=10&page=%s&sortBy=date&sortDir=desc','{\"cons\": [\"Expensive\", \"Not worth the money\", \"Stopped functioning unless plugged in\", \"Heavy and bulky\", \"Charging light stopped working\", \"Not loud enough in open spaces with crowds\", \"Vulnerable speakers/woofers\", \"No loud mode\", \"Base could be better\", \"Missing deeper base\", \"Should have made a couple places for a shoulder strap\"], \"pros\": [\"Excellent sound\", \"Great battery life\", \"Portable and lightweight\", \"Outstanding bass\", \"Clear and faithful sound\", \"Easy to use\", \"Very loud\", \"Crystal clear sound\", \"Great for outdoor adventures\", \"Good battery life\", \"Amazing sound quality\", \"Very satisfied with the purchase\", \"Ultra portable\", \"Love it\", \"Best Bluetooth speaker ever owned\", \"Clear highs and great feeling bass\", \"Easy to set up and use\", \"Great quality sound\", \"Excellent equipment for all time party\", \"Best speaker ever\"], \"neutral\": [\"Should be priced between $350-$400\", \"Party boost feature is hit and miss\", \"Missing the ability to Bluetooth calls through the speaker\"], \"consTotal\": 11, \"prosTotal\": 44, \"neutralTotal\": 3}','{\"cons\": [\"Caro\", \"Não vale o dinheiro\", \"Parou de funcionar a menos que esteja conectado\", \"Pesado e volumoso\", \"Luz de carga parou de funcionar\", \"Não é alto o suficiente em espaços abertos com multidões\", \"Alto-falantes / woofers vulneráveis\", \"Sem modo alto\", \"Base poderia ser melhor\", \"Faltando graves mais profundos\", \"Deveria ter feito um casal de lugares para uma alça de ombro\"], \"pros\": [\"Excelente som\", \"Ótima duração da bateria\", \"Portátil e leve\", \"Graves excepcionais\", \"Som claro e fiel\", \"Fácil de usar\", \"Muito alto\", \"Som cristalino\", \"Ótimo para aventuras ao ar livre\", \"Boa duração da bateria\", \"Qualidade de som incrível\", \"Muito satisfeito com a compra\", \"Ultra portátil\", \"Adoro\", \"Melhor alto-falante Bluetooth já possuído\", \"Agudos claros e graves com ótimo feeling\", \"Fácil de configurar e usar\", \"Ótima qualidade de som\", \"Excelente equipamento para festas\", \"Melhor alto-falante já visto\"], \"neutral\": [\"Deveria ter preço entre $350-$400\", \"Feature de boost para festas é meio a meio\", \"Faltando a capacidade de realizar chamadas Bluetooth pelo alto-falante\"], \"consTotal\": 11, \"prosTotal\": 44, \"neutralTotal\": 3}',NULL,'2023-04-16 14:59:01','2023-04-12 03:59:01',0,1,NULL,1);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-24 22:09:05
