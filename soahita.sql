-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 06 Novembre 2017 à 17:31
-- Version du serveur :  10.1.19-MariaDB
-- Version de PHP :  5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `soahita`
--

-- --------------------------------------------------------

--
-- Structure de la table `bs_brand`
--

CREATE TABLE `bs_brand` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `bs_brand`
--

INSERT INTO `bs_brand` (`id`, `name`, `description`, `deleted`) VALUES
(1, 'Samsung', 'Marque coréen', 0),
(2, 'Acer', 'marque acer', 0),
(3, 'Asus', 'ASUS is a leading company driven by innovation and commitment to quality for products that include notebooks, netbooks, motherboards, graphics cards, ...', 0),
(4, 'Schneider', NULL, 0),
(5, 'Sony', 'marque sony', 0),
(6, 'Logitech', 'marque logitech', 1),
(7, 'Western Digital', 'Spécialisé dans les stockages', 1),
(8, 'Apple', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `bs_category`
--

CREATE TABLE `bs_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `bs_category`
--

INSERT INTO `bs_category` (`id`, `name`) VALUES
(1, 'Informatique'),
(2, 'Services');

-- --------------------------------------------------------

--
-- Structure de la table `bs_expenditure`
--

CREATE TABLE `bs_expenditure` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `bs_expenditure`
--

INSERT INTO `bs_expenditure` (`id`, `name`, `amount`, `date`, `description`, `deleted`) VALUES
(1, 'Dépense be', 350000, '2017-10-02', 'Manahirana mits ny dépense tahak ''ireto. fandaniana amin''ny ts misy antony mits. mba marina e!', 0),
(2, 'Fandaniana maivana', 10000, '2017-10-04', 'Somary efa niezaka iany ka ts de nisy olana teo am fandaniana', 1),
(3, 'Fandaniana 12', 23002, '2017-02-02', 'okok', 1),
(4, 'Charge Jirama', 50000, '2017-10-19', 'Fandoavana facture tam volana octobre 2017', 0),
(5, 'Fandaniana 1', 3000, '2017-10-01', 'enjana mits izy ity', 1),
(6, 'lorem ipsum', 60000, '2017-10-01', 'description lorem ipsum', 1),
(7, 'dfsdfs', 600, '2017-10-01', 'sddsfsdfs', 1),
(8, 'depenses 2', 30000, '2017-10-01', 'dfdf', 1),
(9, 'depense 3', 40000, '2017-10-25', 'dffd', 1),
(10, 'qsdqs', 56464, '2017-10-01', 'sdqsd', 1),
(11, 'miompampana', 36000, '2017-10-24', 'Itony mits le karazana fandaniana miompampana.', 0),
(12, 'Test recettes', 5000, '2017-11-01', 'ok', 0),
(13, 'tst 2', 60000, '2017-11-02', 'dfsf sdf', 0),
(14, 'Mientsana ho an''n Cantine', 30000, '2017-11-03', 'Hen''omby sy anana', 0),
(15, 'Dépense kely', 20000, '2017-11-04', 'test recette aujourd''hui', 0),
(16, 'vola miala', 30000, '2017-11-05', 'ok basy', 0);

-- --------------------------------------------------------

--
-- Structure de la table `bs_gain`
--

CREATE TABLE `bs_gain` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `bs_gain`
--

INSERT INTO `bs_gain` (`id`, `name`, `amount`, `date`, `description`, `deleted`) VALUES
(1, 'Gain 1', 30000, '2017-11-04', 'Un dîner aux chandelles, un ciné en toute intimité, un week-end surprise... Hop, on le surprend et on lui dit Je t''aime. Si vous avez du mal à mettre des mots sur vos sentiments, piochez dans nos plus belles phrases d''amour. La rédac'' a sélectionné les meilleures. Cœur avec les doigts.', 0),
(2, 'Gain 2', 20000, '2017-11-03', 'df', 1),
(3, 'Gain 2', 30000, '2017-11-04', 'test', 0);

-- --------------------------------------------------------

--
-- Structure de la table `bs_product`
--

CREATE TABLE `bs_product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `reference` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL,
  `quantityalert` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `bs_product`
--

INSERT INTO `bs_product` (`id`, `name`, `description`, `reference`, `category_id`, `brand_id`, `deleted`, `quantityalert`, `slug`) VALUES
(1, 'Huawei P8', 'Lorem telephone vrai be', 'HP8', 1, 1, 0, 0, 'huawei-p8'),
(2, 'Ordinateur portable Acer', 'lorem ipsum ordinateur', 'acer 120', 1, 2, 0, 0, 'ordinateur-portable-acer'),
(8, 'samsung s6 edge +', 'Milay ity article ity...', 's6', 1, 1, 0, 0, 'samsung-s6-edge'),
(9, 'Portable acer', 'Ceci est un portable acer', 'acer 56', 1, 2, 0, 0, 'portable-acer'),
(10, 'Samsung J5', 'description du samsung j5', 'J5', 1, 1, 0, 0, 'samsung-j5'),
(11, 'samsung s6', 'Samsung Galaxy S6 smartphone was launched in March 2015. The phone comes with a 5.10-inch touchscreen display with a resolution of 1440 pixels by 2560 pixels at a PPI of 577 pixels per inch. Samsung Galaxy S6 price in India starts from Rs. 29,200.\r\n\r\nThe Samsung Galaxy S6 is powered by 1.5GHz octa-core Samsung Exynos 7420 processor and it comes with 3GB of RAM. The phone packs 32GB of internal storage that cannot be expanded. As far as the cameras are concerned, the Samsung Galaxy S6 packs a 16-megapixel primary camera on the rear and a 5-megapixel front shooter for selfies.\r\n\r\nThe Samsung Galaxy S6 runs Android 5.0 and is powered by a 2550mAh non removable battery. It measures 143.40 x 70.50 x 6.80 (height x width x thickness) and weigh 138.00 grams.\r\n\r\nThe Samsung Galaxy S6 is a single SIM (GSM) smartphone that accepts a Nano-SIM. Connectivity options include Wi-Fi, GPS, Bluetooth, NFC, Infrared, USB OTG, 3G and 4G (with support for Band 40 used by some LTE networks in India). Sensors on the phone include Compass Magnetometer, Proximity sensor, Accelerometer, Ambient light sensor, Gyroscope and Barometer.', 'Galaxy S6', 1, 1, 0, 0, 'samsung-s6'),
(12, 'Minions', 'description  a propos de minion', 'MK', 2, 2, 0, 0, 'minions'),
(13, 'gggg', 'grand be', 'ggg', 2, 1, 1, 0, 'gggg'),
(14, 'test hafa mits ity', 'description', 'sdfsdfsdfsdfs', 1, 2, 0, 0, 'test-hafa-mits-ity'),
(15, 'Chargeur pour portable', 'c''est un chargeur pour portable', '1248 GHJ', 1, 2, 0, 0, 'chargeur-pour-portable'),
(16, 'Souris', 'Ceci est un souris acer', '125sL', 1, 2, 1, 0, 'souris'),
(17, 'Stylo bleu', 'stylo le plus vendu la plupart du temps', '25324', 2, 4, 0, 0, 'stylo-bleu'),
(18, 'Ecran 17" vrai marque', 'ecran plat 17". HDMI. VGA. full hd', '17flatas', 1, 3, 0, 0, 'ecran-17-vrai-marque'),
(19, 'Clavier gamers 123', 'claviers pour gamers', 'CG ROG 123', 1, 3, 0, 0, 'clavier-gamers-123'),
(20, 'Cable hdmi', 'kable maditra', 'HD456', 1, 1, 0, 0, '16'),
(21, 'Produit test', 'specimen de produit a tester dans l''application...', 'PT123', 1, 1, 0, 0, 'produit-test'),
(22, 'Encre', NULL, 'en', 2, 2, 0, 0, 'encre'),
(23, 'fsdfsd', 'fsdfsdfsdfsdf', 'fsdfsdf', 1, 3, 0, 0, 'fsdfsd'),
(24, 'vrai nom de produit', 'sdfsdf', '2345', 1, 1, 0, 0, 'vrai-nom-de-produit'),
(25, 'test ndray', NULL, 'TN', 1, 3, 1, 0, 'test-ndray'),
(26, 'produit 123', NULL, 'dfdf', 1, NULL, 1, 0, 'produit-123'),
(27, 'Ram 4Go DDR4', 'ram 4g', 'DDR44g', 1, NULL, 0, 0, 'ram-4go-ddr4'),
(28, 'test lien controler', NULL, 'fsdf', 1, NULL, 0, 0, 'test-lien-controler'),
(29, 'fsdfs', 'sdfdsf', 'sdfs', 1, NULL, 1, 0, 'fsdfs'),
(30, 'Flash kingston 16G', NULL, 'KG16', 1, NULL, 0, 1, 'flash-kingston-16g'),
(31, 'sdfsdf', 'gdfgdf', 'dfd', 1, NULL, 0, 3, ''),
(32, 'Sony Xperia Z3', 'test slug', 'Sony Xperia Z3', 1, 5, 0, 1, 'sony-xperia-z3');

-- --------------------------------------------------------

--
-- Structure de la table `bs_productimage`
--

CREATE TABLE `bs_productimage` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `originalname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `current` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `bs_productimage`
--

INSERT INTO `bs_productimage` (`id`, `product_id`, `name`, `path`, `originalname`, `current`) VALUES
(11, 11, 'samsungs6.jpg', '13db7e8556da212_11_1507796136.jpeg', 'samsungs6.jpg', 1),
(12, 16, 'souris.jpg', '6b7e917fe178e74_16_1507796486.jpeg', 'souris.jpg', 1),
(13, 17, 'stylo.jpg', '5876611c9901443_17_1507796550.jpeg', 'stylo.jpg', 1),
(14, 18, 'ecranasus.jpg', '8fa8b44777530a4_18_1507796597.jpeg', 'ecranasus.jpg', 1),
(15, 19, 'keyboardgamer.jpg', 'e75f5d2e692b87e_19_1507796675.jpeg', 'keyboardgamer.jpg', 1),
(21, 12, 'minion.jpg', 'f6c66d6669ef74b_12_1507817780.jpeg', 'minion.jpg', 1),
(24, 13, 'usericon.png', '882a597f37b49df_13_1507818308.png', 'usericon.png', 1),
(29, 21, '0015.12594-1.png', 'ac3c242105db5a1_21_1507884343.png', '0015.12594-1.png', 0),
(32, 1, 'huawei p8.jpg', 'eef2ba353c56f20_1_1508932280.jpeg', 'huawei p8.jpg', 1),
(33, 9, 'portableacer.jpg', '1941ad7a26cde9d_9_1508932503.jpeg', 'portableacer.jpg', 1),
(34, 15, 'charger.jpg', '5c30b65cae46ab0_15_1508933416.jpeg', 'charger.jpg', 1),
(35, 22, 'encreimprimante.jpg', 'bb3cd8e4a8aabaf_22_1508933468.jpeg', 'encreimprimante.jpg', 1),
(36, 27, 'ram.jpg', '40da1b989a63894_27_1509644527.jpeg', 'ram.jpg', 1),
(37, 30, 'flash.jpg', 'c6b3850dc4346a9_30_1509644937.jpeg', 'flash.jpg', 1),
(38, 2, 'acer.jpg', '9061884ff4ffbdb_2_1509789923.jpeg', 'acer.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `bs_stock`
--

CREATE TABLE `bs_stock` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `bs_stock`
--

INSERT INTO `bs_stock` (`id`, `product_id`, `date`, `price`, `quantity`, `deleted`, `description`, `type`) VALUES
(1, 1, '2017-10-03', 520000, 1, 0, NULL, 0),
(2, 1, '2017-10-04', 130000, 32, 1, 'test modification', 0),
(3, 1, '2017-10-10', 125000, 12, 1, 'dsfdfsdf', 0),
(4, 11, '2017-12-09', 550000, 5, 0, 'desc', 0),
(5, 14, '2017-10-05', 1300, 12, 1, 'description', 0),
(6, 11, '2017-10-02', 700000, 2, 0, 'description de vente', 1),
(7, 11, '2017-09-03', 750000, 10, 0, 'ddddd', 1),
(8, 1, '2017-09-28', 1200, 2, 1, 'sdfsdfs', 1),
(9, 1, '2017-10-08', 1300, 12, 1, 'dsfsdf', 1),
(10, 1, '2017-08-10', 650000, 6, 0, '555', 1),
(11, 15, '2017-10-25', 30000, 2, 0, 'sdfsdf', 0),
(12, 1, '2017-10-17', 700000, 6, 0, 'rakoto no nividy an''ity azafady....', 1),
(13, 21, '2017-09-24', 700000, 20, 1, 'Ity lay produit tany am ndrabe iny.', 0),
(14, 1, '2017-09-25', 490000, 5, 0, 'rehefa nodinihana de mora iany izy ity ka nampiana 20 . sady be mpaka be le izy. tena tendance  be tatoato. am manaraka tonga de maka 40 any.', 0),
(15, 18, '2017-10-01', 250000, 5, 0, 'Ecran nalaina tam naza', 0),
(16, 1, '2017-10-02', 600000, 11, 0, 'nisy naka maromaro', 1),
(17, 11, '2017-10-25', 500000, 12, 0, 'vao tonga androany mits', 0),
(18, 22, '2017-10-25', 11000, 20, 0, 'Amle qualité tsara ireto tonga ireto', 0),
(19, 1, '2017-10-25', 3000, 20, 1, NULL, 1),
(20, 22, '2017-10-25', 13000, 20, 0, 'lafo daholo iz rehetra', 1),
(21, 16, '2017-10-01', 15000, 10, 0, 'souris amle 15000', 0),
(22, 16, '2017-10-25', 14500, 15, 0, 'souris amle 14500', 0),
(23, 16, '2017-10-04', 20000, 5, 0, 'namidy 20000. 5 no nalain''i Jean Fréderic Antalaha', 1),
(24, 22, '2017-10-02', 10000, 10, 0, NULL, 0),
(25, 9, '2017-10-24', 600000, 5, 0, 'Mila ampiana ity fa be mpitady', 0),
(26, 9, '2017-10-24', 600000, 3, 0, NULL, 0),
(27, 9, '2017-10-25', 700000, 1, 0, 'ffqd', 1),
(28, 11, '2017-10-31', 720000, 5, 0, NULL, 1),
(29, 1, '2017-10-24', 500000, 8, 0, 'Arrivage vao mafana be...', 0),
(30, 10, '2017-11-02', 250000, 5, 0, 'Description', 0),
(31, 10, '2017-11-02', 300000, 2, 0, 'Vente J5', 1),
(32, 27, '2017-11-01', 60000, 4, 0, 'Mividy ram', 0),
(33, 27, '2017-11-02', 70000, 2, 0, NULL, 1),
(34, 10, '2017-11-01', 300000, 3, 0, NULL, 1),
(35, 27, '2017-11-03', 70000, 2, 0, 'fdgsdf sdf', 1),
(36, 27, '2017-11-01', 60000, 2, 0, NULL, 0),
(37, 27, '2017-11-02', 55000, 2, 0, 'ok', 0),
(38, 13, '2017-11-01', 5000, 2, 0, 'type stock', 0),
(39, 13, '2017-11-01', 6000, 3, 0, NULL, 1),
(40, 1, '2017-11-01', 49000, 1, 0, NULL, 0),
(41, 13, '2017-11-01', 5000, 1, 0, NULL, 0),
(42, 9, '2017-11-03', 700000, 1, 0, NULL, 1),
(43, 18, '2017-11-03', 270000, 2, 0, NULL, 0),
(44, 22, '2017-11-03', 13200, 8, 0, 'varotra imprimente', 1),
(45, 27, '2017-11-04', 110000, 1, 0, 'test recette aujourd''hui', 0),
(46, 27, '2017-11-04', 120000, 1, 0, 'test recette', 1),
(47, 1, '2017-11-06', 600000, 1, 0, 'y', 1),
(48, 1, '2017-11-05', 500000, 2, 0, 'dfgdfg', 0),
(49, 1, '2017-11-06', 600000, 2, 0, NULL, 1),
(50, 1, '2017-11-06', 560000, 4, 0, NULL, 0),
(51, 1, '2017-11-06', 450000, 5, 0, 'fsdf', 0);

-- --------------------------------------------------------

--
-- Structure de la table `bs_transaction`
--

CREATE TABLE `bs_transaction` (
  `id` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `transaction_type_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `bs_transaction`
--

INSERT INTO `bs_transaction` (`id`, `description`, `date`, `amount`, `transaction_type_id`, `deleted`) VALUES
(1, NULL, '2017-10-01', 50000, 1, 1),
(2, 'description', '2017-10-03', 60000, 1, 1),
(3, 'lorem ipsum', '2017-10-04', 20000, 2, 1),
(4, 'sdfsd', '2017-10-03', 12, 1, 1),
(5, 'ceci est la description', '2017-09-05', 12000, 2, 1),
(6, 'dfgdf', '2017-10-10', 100000, 1, 1),
(7, 'sdfsfsd sdfdf', '2017-10-19', 12000, 1, 1),
(8, 'ddfdf', '2017-10-20', 3000, 1, 1),
(9, 'lst', '2017-09-24', 1200000, 2, 1),
(10, 'pas de description', '2017-10-02', 300000, 1, 1),
(11, NULL, '2017-10-01', 20000, 2, 1),
(12, 'Fait dans la plus breve delais. bon ça doit marcher', '2017-10-01', 300000, 1, 1),
(13, NULL, '2017-03-03', 36000, 2, 1),
(14, 'Ceci est un versement', '2008-10-30', 200000, 1, 1),
(15, 'fgdfgdfgdfggghfg', '2000-10-30', 200000, 1, 1),
(16, 'fgdfgdfgdfggghfg', '9999-10-30', 200000, 1, 1),
(17, 'Versement systématique', '2017-04-30', 15000, 1, 0),
(18, 'test date description', '2000-10-02', 30000, 1, 1),
(19, 'test date description', '2017-09-19', 12000, 1, 0),
(20, 'test date description', '2017-05-06', 32000, 2, 0),
(21, 'test date description', '2017-06-08', 30000, 1, 0),
(22, 'test date description', '2017-06-06', 5000, 2, 0),
(23, 'test date description', '2017-08-02', 30000, 2, 0),
(24, NULL, '2017-10-02', 133330, 1, 1),
(25, NULL, '2017-10-25', 133330, 1, 1),
(26, NULL, '2017-10-25', 133330, 1, 1),
(27, NULL, '2017-10-25', 133330, 1, 1),
(28, NULL, '2016-02-29', 133330, 1, 1),
(29, NULL, '2020-02-29', 133330, 1, 1),
(30, NULL, '2017-10-25', 133330, 1, 1),
(31, 'test modif', '2017-10-01', 300000, 2, 1),
(32, NULL, '2017-10-30', 40000, 1, 0),
(33, NULL, '2017-10-30', 60000, 2, 0),
(34, 'versement debut novembre', '2017-11-02', 5000, 1, 0),
(35, NULL, '2017-11-03', 3000, 1, 0),
(36, NULL, '2017-01-02', 10000, 1, 1),
(37, 'jklj', '2017-11-06', 5000, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `bs_transaction_type`
--

CREATE TABLE `bs_transaction_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `bs_transaction_type`
--

INSERT INTO `bs_transaction_type` (`id`, `name`) VALUES
(1, 'versement'),
(2, 'retrait');

-- --------------------------------------------------------

--
-- Structure de la table `pm_person`
--

CREATE TABLE `pm_person` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cindate` date DEFAULT NULL,
  `cinlocation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthlocation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `pm_person`
--

INSERT INTO `pm_person` (`id`, `name`, `firstname`, `cin`, `cindate`, `cinlocation`, `address`, `phone`, `email`, `birthdate`, `birthlocation`, `sex`) VALUES
(1, 'Rakotonandrasana', 'Andry Nantenaina Fanampin''anarana lava be', NULL, '2017-10-01', NULL, 'Antalaha Est 22 llo', NULL, NULL, '2017-10-01', NULL, 0),
(2, 'Randrianarisoa', 'franckie', '12345678789', '2010-10-02', 'Sambava', 'lot II 639 Sambava', '0341245678', 'randria12@gmail.com', '1987-10-04', 'franckie', 0),
(4, 'Rafanomezantsoa', 'Aina', '123456789456', '2017-10-14', 'Miarinarivo', 'Lot 125 Mahamasina Antananarivo 101', '03312123456', 'ainra@yahoo.fr', '2017-06-26', 'Aina', 0),
(5, 'Ranarisoa', 'mickael', '456789123456', NULL, NULL, 'antsobolo', '0341245785', 'ranami@gmail.com', '2017-05-02', NULL, 0),
(6, 'Minoarisoa', 'Angéline', '313112512542', '2007-10-03', 'Antalaha', 'Lot 12 Sambava', '0325687451', 'minoange2@yahoo1.fr', '1988-05-04', 'Angéline', 1),
(7, 'Zafinirina', 'Chantal', '12345679456', '2006-07-03', 'Ambatondrazaka', 'Lot ambolokandrina', '0342145689', 'ranami@gdmail.com', '1997-07-02', 'Chantal', 1),
(8, 'Rakotomandimby', 'Arinivo', '123456789456', '2017-09-24', 'Antananarivo', 'Lot 12 TER 12 Ambohijafy Antananarivo 102', '0345689745', 'arni123@gmail.com', '2017-09-24', 'Arinivo', 0),
(9, 'Hantariniaina', 'Fenitra Julie', '456123456789', '2006-10-10', 'Antananarivo', 'Lot 45 Andrefana Ambohijanahary Antananarivo 101', '0325412368', 'hanta456@hotmail.com', '1987-02-28', 'Fenitra Julie', 1),
(10, 'Rakotobe', 'Gerard', '456789456123', '2007-11-01', 'Antalaha', 'Andapa est', '+2613202312', 'gerard456@yahoo.fr', '2007-10-01', 'Anosizato Antananarivo', 0),
(11, 'Rakotomirana', 'Fenoharena', '31232541254', '2007-01-01', 'Ambovombe', 'Anosibe', '313022123102', 'fenomir@yahoo.fr', '2017-10-01', 'Moramanga', 1),
(12, 'Faniloarivelo misa', 'manantenasoa', '12345612345', '2017-10-02', 'Ambalamanasa', 'Lot 457', '0341245635', 'jkl@dfd.df', '2017-10-04', 'Ambalamanasa', 0),
(13, 'Andrianaina', 'Hery', '123456', '2017-10-02', 'jklj', 'jljlk', '123456', 'jkl@dfd.df', '2017-10-04', 'jkljlk', 0),
(14, 'Ranarivelo', 'ejameva', '123456', '2017-10-02', 'jklj', 'jljlk', '123456', 'jkl@dfd.df', '2017-10-04', 'jkljlk', 1),
(15, 'Rojofinaritra', 'Princia', '12345679456', '2017-10-02', 'Ambatofinandrahana', 'Lot 06235 Ambatoroka Antananarivo', '12345678', 'rojf12@gmail.com', '2017-10-02', 'Ambatofinandrahana', 1),
(16, 'Razaimanana', 'georgette', '458678645', '2017-10-01', 'wxcwx', 'wxcwx', '56456', 'dfsd@sdf.df', '2017-10-01', 'sdfsd', 1),
(17, 'Fenofitahiana', 'Herman', '456789456123', '2017-10-01', 'Fianarantsoa', 'Lot IVB Antalaha', '0325623112', 'sdfsdf@df.sdf', '2017-10-01', 'Anosiavaratra Antananarivo', 0),
(18, 'Andrianorotseheno', 'Francia Maminira Judith', NULL, NULL, NULL, 'Lot12 II Anjanahary Antananarivo', '0324512356', 'no55ro@gmail.com', '2017-10-01', 'Anosiavaratra Antananarivo', 1),
(19, 'Narimanana', 'Onitiana Lucky', '312325452123', '2007-10-01', 'Antananarivo', 'Lot IVB Manarintsoa Atsimo', '03412235469', 'onilu12@gmail.com', '2007-10-01', 'Anosibe', 0),
(20, 'Rabearivelo', 'Hasiniaina', '321524232891', '2007-11-01', 'Ambakireny', 'Lot II 5 Analamahitsy Antananarivo', '0325623189', 'hasiniaina.r@yahoo.com', '1997-02-05', 'Tsaratanana', 0),
(21, 'Rajaonary', 'Lova Fredy', '321232512321', '2005-10-07', 'Antsiranana', 'Lot 65 Antsiranana 1', '0321245123', 'ralova1@test.fr', '1987-03-04', 'Antsiranana', 0),
(22, 'Noroseheno', 'Malalatiana', '31232125458', '2008-10-01', 'Amparafaravola', 'Lot 25 Antaninandro', '0324215218', 'noro88@hotmail.com', '1997-01-02', 'Amboavory', 1),
(23, 'Ramarosandratana', 'Rivo', '3215423256', '2007-10-02', 'Analakely', 'Lot eto am ville', '0325412326', 'sandrat@gmail.com', '1987-04-10', 'Analamahitsy', 0),
(24, 'Imerimanana', 'André', '12345679456', '2017-10-01', 'lieu cin', 'adress', '032124512', 'dffd@dfd.df', '2017-10-01', 'Lieu', 0),
(25, 'Miranamahefa', 'Jean de Dieu', '123456789456', '2007-10-08', 'sdfsd', 'sdfsdf', '123456456', 'dfsdf@dfd.dfd', '1997-01-01', 'xcsdc', 0),
(26, 'Rafarasoa', 'Lanto', '123456786', '2017-10-02', 'sdf', 'sfsdf', 'sdfsd', 'sdfsdf@df.sdf', '2017-10-02', 'sdfsf', 1),
(27, 'Razafindrakoto', 'Edgard', '123123', '2017-10-09', 'klmkml', 'klmkml', 'klmkmlk', 'lmkml', '2017-10-17', 'sdfsdf', 0),
(28, 'sdfsdf', 'sdfsdf', '345345', '2017-10-01', 'sdfsf', 'sdfsdf', 'sfdsdf', 'sdfsdf', '2017-10-01', 'sdfs', 0),
(29, 'Rakoto', 'Riantsoa', NULL, '2017-10-01', NULL, NULL, NULL, NULL, '2017-10-01', NULL, 0),
(30, 'Norofitahiana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(31, 'rakoto test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `pm_personimage`
--

CREATE TABLE `pm_personimage` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `originalname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `current` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `pm_personimage`
--

INSERT INTO `pm_personimage` (`id`, `person_id`, `name`, `path`, `originalname`, `current`) VALUES
(5, 6, 'cntemad.jpeg', '4ed49b16db4056d_6_1507921825.jpeg', 'cntemad.jpeg', 1),
(6, 5, 'usericon.png', 'd76e0f252eb3db7_5_1507923209.png', 'usericon.png', 0),
(7, 7, 'iscamland1.jpg', '0470f82c3fdc681_7_1507924474.jpeg', 'iscamland1.jpg', 1),
(8, 4, 'usericon.png', '609e3ade4c6acde_4_1507961629.png', 'usericon.png', 1),
(9, 9, 'Great-FC-Barcelona-Neymar-Kit-Number-FC-Barcelona-Wallpaper-HD-2017-DJF9.png', '2ad828d38f8b3b5_9_1507970857.png', 'Great-FC-Barcelona-Neymar-Kit-Number-FC-Barcelona-Wallpaper-HD-2017-DJF9.png', 1),
(12, 13, 'reinedesneignes.jpg', 'bb7d4537e7b24e4_13_1507985068.jpeg', 'reinedesneignes.jpg', 1),
(15, 16, 'img.jpg', '709168dd300ce2b_16_1508404845.jpeg', 'img.jpg', 1),
(16, 15, 'cntemad.jpeg', '680ee894d3afa7a_15_1508407782.jpeg', 'cntemad.jpeg', 0),
(17, 14, 'sipatest.jpg', 'e11b2ee36eacf86_14_1508856439.jpeg', 'sipatest.jpg', 1),
(18, 2, 'portraithomme.jpg', '66274b70c56cbb1_2_1508949784.jpeg', 'portraithomme.jpg', 1),
(19, 19, 'portraithomme2.jpg', '8bb00de74350525_19_1508950117.jpeg', 'portraithomme2.jpg', 1),
(20, 11, 'portraitfemm.jpg', '0f268ae6df97448_11_1508951110.jpeg', 'portraitfemm.jpg', 0),
(21, 15, 'portraitfemm2.jpg', 'cc7d7c7c9f46c66_15_1509030181.jpeg', 'portraitfemm2.jpg', 1),
(22, 21, 'ph1.jpg', '2347a115f457e18_21_1509086791.jpeg', 'ph1.jpg', 1),
(23, 1, 'portraithomme2.jpg', '62dd399c693c211_1_1509375968.jpeg', 'portraithomme2.jpg', 0),
(24, 10, 'njarivo2.jpg', 'def188167fe405f_10_1509646154.jpeg', 'njarivo2.jpg', 0),
(25, 18, 'photof.jpg', '23b9e2dc83e7211_18_1509705285.jpeg', 'photof.jpg', 1),
(26, 8, 'ph1.jpg', 'c4a0d23486612f5_8_1509964092.jpeg', 'ph1.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `pm_taking`
--

CREATE TABLE `pm_taking` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `datebegin` date NOT NULL,
  `dateend` date NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `pm_taking`
--

INSERT INTO `pm_taking` (`id`, `date`, `datebegin`, `dateend`, `reference`, `state`) VALUES
(1043, '2017-11-06 17:11:23', '2017-11-06', '2017-11-06', NULL, 0),
(1044, '2017-11-06 17:11:52', '2017-11-06', '2017-11-06', NULL, 0),
(1045, '2017-11-06 17:11:59', '2017-11-06', '2017-11-06', NULL, 0),
(1046, '2017-11-06 17:12:03', '2017-11-06', '2017-11-06', NULL, 0),
(1047, '2017-11-06 17:12:13', '2017-11-06', '2017-11-06', NULL, 0),
(1048, '2017-11-06 17:14:36', '2017-11-06', '2017-11-06', NULL, 0),
(1049, '2017-11-06 17:14:38', '2017-11-06', '2017-11-06', NULL, 0),
(1050, '2017-11-06 17:14:53', '2017-11-05', '2017-11-05', NULL, 0),
(1051, '2017-11-06 17:14:53', '2017-11-06', '2017-11-06', NULL, 0),
(1052, '2017-11-06 17:14:58', '2017-11-01', '2017-11-30', NULL, 0),
(1053, '2017-11-06 17:14:58', '2017-11-06', '2017-11-06', NULL, 0),
(1054, '2017-11-06 17:15:07', '2016-11-06', '2017-11-06', NULL, 0),
(1055, '2017-11-06 17:15:08', '2017-11-06', '2017-11-06', NULL, 0),
(1056, '2017-11-06 17:15:45', '2016-11-09', '2017-11-06', NULL, 0),
(1057, '2017-11-06 17:15:46', '2017-11-06', '2017-11-06', NULL, 0),
(1058, '2017-11-06 17:15:58', '2017-11-06', '2017-11-21', NULL, 0),
(1059, '2017-11-06 17:15:58', '2017-11-06', '2017-11-06', NULL, 0),
(1060, '2017-11-06 17:17:47', '2017-11-06', '2017-11-06', NULL, 0),
(1061, '2017-11-06 17:20:32', '2017-11-06', '2017-11-06', NULL, 0),
(1062, '2017-11-06 17:20:40', '2017-11-06', '2017-11-06', NULL, 0),
(1063, '2017-11-06 17:22:29', '2017-11-06', '2017-11-06', NULL, 0),
(1064, '2017-11-06 17:25:00', '2017-11-06', '2017-11-06', NULL, 0),
(1065, '2017-11-06 17:29:20', '2017-11-06', '2017-11-06', NULL, 0),
(1066, '2017-11-06 17:29:31', '2017-11-06', '2017-11-06', NULL, 0),
(1067, '2017-11-06 17:29:50', '2017-11-06', '2017-11-06', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `pm_takingline`
--

CREATE TABLE `pm_takingline` (
  `id` int(11) NOT NULL,
  `taking_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `pm_takingline`
--

INSERT INTO `pm_takingline` (`id`, `taking_id`, `date`, `amount`, `quantity`, `description`, `name`) VALUES
(9858, 1043, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(9859, 1043, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(9860, 1043, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9861, 1043, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(9862, 1043, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(9863, 1043, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(9864, 1044, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(9865, 1044, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(9866, 1044, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9867, 1044, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(9868, 1044, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(9869, 1044, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(9870, 1045, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(9871, 1045, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(9872, 1045, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9873, 1045, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(9874, 1045, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(9875, 1045, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(9876, 1046, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(9877, 1046, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(9878, 1046, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9879, 1046, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(9880, 1046, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(9881, 1046, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(9882, 1047, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(9883, 1047, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(9884, 1047, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9885, 1047, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(9886, 1047, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(9887, 1047, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(9888, 1048, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(9889, 1048, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(9890, 1048, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9891, 1048, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(9892, 1048, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(9893, 1048, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(9894, 1049, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(9895, 1049, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(9896, 1049, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9897, 1049, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(9898, 1049, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(9899, 1049, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(9900, 1050, '2017-11-05', -500000, 2, 'dfgdfg', 'Mouvement article (Entrée en stock) Huawei P8'),
(9901, 1050, '2017-11-05', -30000, 1, 'ok basy', 'Dépense : vola miala'),
(9902, 1050, '2017-11-05', 80000, 1, NULL, 'Règlement frais de cours : Razaimanana georgette'),
(9903, 1051, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(9904, 1051, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(9905, 1051, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9906, 1051, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(9907, 1051, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(9908, 1051, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(9909, 1052, '2017-11-02', -250000, 5, 'Description', 'Mouvement article (Entrée en stock) Samsung J5'),
(9910, 1052, '2017-11-02', 300000, 2, 'Vente J5', 'Mouvement article (Vente) Samsung J5'),
(9911, 1052, '2017-11-01', -60000, 4, 'Mividy ram', 'Mouvement article (Entrée en stock) Ram 4Go DDR4'),
(9912, 1052, '2017-11-02', 70000, 2, NULL, 'Mouvement article (Vente) Ram 4Go DDR4'),
(9913, 1052, '2017-11-01', 300000, 3, NULL, 'Mouvement article (Vente) Samsung J5'),
(9914, 1052, '2017-11-03', 70000, 2, 'fdgsdf sdf', 'Mouvement article (Vente) Ram 4Go DDR4'),
(9915, 1052, '2017-11-01', -60000, 2, NULL, 'Mouvement article (Entrée en stock) Ram 4Go DDR4'),
(9916, 1052, '2017-11-02', -55000, 2, 'ok', 'Mouvement article (Entrée en stock) Ram 4Go DDR4'),
(9917, 1052, '2017-11-01', -5000, 2, 'type stock', 'Mouvement article (Entrée en stock) gggg'),
(9918, 1052, '2017-11-01', 6000, 3, NULL, 'Mouvement article (Vente) gggg'),
(9919, 1052, '2017-11-01', -49000, 1, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9920, 1052, '2017-11-01', -5000, 1, NULL, 'Mouvement article (Entrée en stock) gggg'),
(9921, 1052, '2017-11-03', 700000, 1, NULL, 'Mouvement article (Vente) Portable acer'),
(9922, 1052, '2017-11-03', -270000, 2, NULL, 'Mouvement article (Entrée en stock) Ecran 17" vrai marque'),
(9923, 1052, '2017-11-03', 13200, 8, 'varotra imprimente', 'Mouvement article (Vente) Encre'),
(9924, 1052, '2017-11-04', -110000, 1, 'test recette aujourd''hui', 'Mouvement article (Entrée en stock) Ram 4Go DDR4'),
(9925, 1052, '2017-11-04', 120000, 1, 'test recette', 'Mouvement article (Vente) Ram 4Go DDR4'),
(9926, 1052, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(9927, 1052, '2017-11-05', -500000, 2, 'dfgdfg', 'Mouvement article (Entrée en stock) Huawei P8'),
(9928, 1052, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(9929, 1052, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9930, 1052, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(9931, 1052, '2017-11-04', 30000, 1, 'Un dîner aux chandelles, un ciné en toute intimité, un week-end surprise... Hop, on le surprend et on lui dit Je t''aime. Si vous avez du mal à mettre des mots sur vos sentiments, piochez dans nos plus belles phrases d''amour. La rédac'' a sélectionné les meilleures. Cœur avec les doigts.', 'Gain : Gain 1'),
(9932, 1052, '2017-11-04', 30000, 1, 'test', 'Gain : Gain 2'),
(9933, 1052, '2017-11-01', -5000, 1, 'ok', 'Dépense : Test recettes'),
(9934, 1052, '2017-11-02', -60000, 1, 'dfsf sdf', 'Dépense : tst 2'),
(9935, 1052, '2017-11-03', -30000, 1, 'Hen''omby sy anana', 'Dépense : Mientsana ho an''n Cantine'),
(9936, 1052, '2017-11-04', -20000, 1, 'test recette aujourd''hui', 'Dépense : Dépense kely'),
(9937, 1052, '2017-11-05', -30000, 1, 'ok basy', 'Dépense : vola miala'),
(9938, 1052, '2017-11-04', 20000, 1, NULL, 'Règlement frais de cours : Rakotobe Gerard'),
(9939, 1052, '2017-11-04', 10000, 1, 'test recette', 'Règlement frais de cours : Rakotobe Gerard'),
(9940, 1052, '2017-11-04', 30000, 1, 'mizotra araka ny tokony izy ny fianarana zay nataony. kinga sy mahay izy', 'Règlement frais de cours : Andrianaina Hery'),
(9941, 1052, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(9942, 1052, '2017-11-01', 80000, 1, 'tertre', 'Règlement frais de cours : sdfsdf sdfsdf'),
(9943, 1052, '2017-11-05', 80000, 1, NULL, 'Règlement frais de cours : Razaimanana georgette'),
(9944, 1052, '2017-11-04', 50000, 1, 'ok', 'Règlement frais de cours : Fenofitahiana Herman'),
(9945, 1052, '2017-11-04', 200000, 1, 'okok', 'Règlement frais de cours : Fenofitahiana Herman'),
(9946, 1052, '2017-11-01', 70000, 1, 'test rectet', 'Règlement frais de cours : Razaimanana georgette'),
(9947, 1052, '2017-11-04', 30000, 1, NULL, 'Règlement frais de cours : Rojofinaritra Princia'),
(9948, 1052, '2017-11-02', 50000, 1, 'tst2', 'Règlement frais de cours : Fenofitahiana Herman'),
(9949, 1052, '2017-11-04', 40000, 1, NULL, 'Règlement frais de cours : Fenofitahiana Herman'),
(9950, 1052, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(9951, 1052, '2017-11-01', 100000, 1, 'Aucune bae', 'Règlement frais de cours : Rafarasoa Lanto'),
(9952, 1053, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(9953, 1053, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(9954, 1053, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9955, 1053, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(9956, 1053, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(9957, 1053, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(9958, 1054, '2017-10-03', -520000, 1, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9959, 1054, '2017-10-02', 700000, 2, 'description de vente', 'Mouvement article (Vente) samsung s6'),
(9960, 1054, '2017-09-03', 750000, 10, 'ddddd', 'Mouvement article (Vente) samsung s6'),
(9961, 1054, '2017-08-10', 650000, 6, '555', 'Mouvement article (Vente) Huawei P8'),
(9962, 1054, '2017-10-25', -30000, 2, 'sdfsdf', 'Mouvement article (Entrée en stock) Chargeur pour portable'),
(9963, 1054, '2017-10-17', 700000, 6, 'rakoto no nividy an''ity azafady....', 'Mouvement article (Vente) Huawei P8'),
(9964, 1054, '2017-09-25', -490000, 5, 'rehefa nodinihana de mora iany izy ity ka nampiana 20 . sady be mpaka be le izy. tena tendance  be tatoato. am manaraka tonga de maka 40 any.', 'Mouvement article (Entrée en stock) Huawei P8'),
(9965, 1054, '2017-10-01', -250000, 5, 'Ecran nalaina tam naza', 'Mouvement article (Entrée en stock) Ecran 17" vrai marque'),
(9966, 1054, '2017-10-02', 600000, 11, 'nisy naka maromaro', 'Mouvement article (Vente) Huawei P8'),
(9967, 1054, '2017-10-25', -500000, 12, 'vao tonga androany mits', 'Mouvement article (Entrée en stock) samsung s6'),
(9968, 1054, '2017-10-25', -11000, 20, 'Amle qualité tsara ireto tonga ireto', 'Mouvement article (Entrée en stock) Encre'),
(9969, 1054, '2017-10-25', 13000, 20, 'lafo daholo iz rehetra', 'Mouvement article (Vente) Encre'),
(9970, 1054, '2017-10-01', -15000, 10, 'souris amle 15000', 'Mouvement article (Entrée en stock) Souris'),
(9971, 1054, '2017-10-25', -14500, 15, 'souris amle 14500', 'Mouvement article (Entrée en stock) Souris'),
(9972, 1054, '2017-10-04', 20000, 5, 'namidy 20000. 5 no nalain''i Jean Fréderic Antalaha', 'Mouvement article (Vente) Souris'),
(9973, 1054, '2017-10-02', -10000, 10, NULL, 'Mouvement article (Entrée en stock) Encre'),
(9974, 1054, '2017-10-24', -600000, 5, 'Mila ampiana ity fa be mpitady', 'Mouvement article (Entrée en stock) Portable acer'),
(9975, 1054, '2017-10-24', -600000, 3, NULL, 'Mouvement article (Entrée en stock) Portable acer'),
(9976, 1054, '2017-10-25', 700000, 1, 'ffqd', 'Mouvement article (Vente) Portable acer'),
(9977, 1054, '2017-10-31', 720000, 5, NULL, 'Mouvement article (Vente) samsung s6'),
(9978, 1054, '2017-10-24', -500000, 8, 'Arrivage vao mafana be...', 'Mouvement article (Entrée en stock) Huawei P8'),
(9979, 1054, '2017-11-02', -250000, 5, 'Description', 'Mouvement article (Entrée en stock) Samsung J5'),
(9980, 1054, '2017-11-02', 300000, 2, 'Vente J5', 'Mouvement article (Vente) Samsung J5'),
(9981, 1054, '2017-11-01', -60000, 4, 'Mividy ram', 'Mouvement article (Entrée en stock) Ram 4Go DDR4'),
(9982, 1054, '2017-11-02', 70000, 2, NULL, 'Mouvement article (Vente) Ram 4Go DDR4'),
(9983, 1054, '2017-11-01', 300000, 3, NULL, 'Mouvement article (Vente) Samsung J5'),
(9984, 1054, '2017-11-03', 70000, 2, 'fdgsdf sdf', 'Mouvement article (Vente) Ram 4Go DDR4'),
(9985, 1054, '2017-11-01', -60000, 2, NULL, 'Mouvement article (Entrée en stock) Ram 4Go DDR4'),
(9986, 1054, '2017-11-02', -55000, 2, 'ok', 'Mouvement article (Entrée en stock) Ram 4Go DDR4'),
(9987, 1054, '2017-11-01', -5000, 2, 'type stock', 'Mouvement article (Entrée en stock) gggg'),
(9988, 1054, '2017-11-01', 6000, 3, NULL, 'Mouvement article (Vente) gggg'),
(9989, 1054, '2017-11-01', -49000, 1, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(9990, 1054, '2017-11-01', -5000, 1, NULL, 'Mouvement article (Entrée en stock) gggg'),
(9991, 1054, '2017-11-03', 700000, 1, NULL, 'Mouvement article (Vente) Portable acer'),
(9992, 1054, '2017-11-03', -270000, 2, NULL, 'Mouvement article (Entrée en stock) Ecran 17" vrai marque'),
(9993, 1054, '2017-11-03', 13200, 8, 'varotra imprimente', 'Mouvement article (Vente) Encre'),
(9994, 1054, '2017-11-04', -110000, 1, 'test recette aujourd''hui', 'Mouvement article (Entrée en stock) Ram 4Go DDR4'),
(9995, 1054, '2017-11-04', 120000, 1, 'test recette', 'Mouvement article (Vente) Ram 4Go DDR4'),
(9996, 1054, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(9997, 1054, '2017-11-05', -500000, 2, 'dfgdfg', 'Mouvement article (Entrée en stock) Huawei P8'),
(9998, 1054, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(9999, 1054, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10000, 1054, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10001, 1054, '2017-11-04', 30000, 1, 'Un dîner aux chandelles, un ciné en toute intimité, un week-end surprise... Hop, on le surprend et on lui dit Je t''aime. Si vous avez du mal à mettre des mots sur vos sentiments, piochez dans nos plus belles phrases d''amour. La rédac'' a sélectionné les meilleures. Cœur avec les doigts.', 'Gain : Gain 1'),
(10002, 1054, '2017-11-04', 30000, 1, 'test', 'Gain : Gain 2'),
(10003, 1054, '2017-10-02', -350000, 1, 'Manahirana mits ny dépense tahak ''ireto. fandaniana amin''ny ts misy antony mits. mba marina e!', 'Dépense : Dépense be'),
(10004, 1054, '2017-10-19', -50000, 1, 'Fandoavana facture tam volana octobre 2017', 'Dépense : Charge Jirama'),
(10005, 1054, '2017-10-24', -36000, 1, 'Itony mits le karazana fandaniana miompampana.', 'Dépense : miompampana'),
(10006, 1054, '2017-11-01', -5000, 1, 'ok', 'Dépense : Test recettes'),
(10007, 1054, '2017-11-02', -60000, 1, 'dfsf sdf', 'Dépense : tst 2'),
(10008, 1054, '2017-11-03', -30000, 1, 'Hen''omby sy anana', 'Dépense : Mientsana ho an''n Cantine'),
(10009, 1054, '2017-11-04', -20000, 1, 'test recette aujourd''hui', 'Dépense : Dépense kely'),
(10010, 1054, '2017-11-05', -30000, 1, 'ok basy', 'Dépense : vola miala'),
(10011, 1054, '2017-10-01', 20000, 1, 'Mba miezaka n mandoa tsikelikely iany.', 'Règlement frais de cours : Rakotobe Gerard'),
(10012, 1054, '2017-10-03', 20000, 1, 'kely sisa de voaloha daholo', 'Règlement frais de cours : Rakotobe Gerard'),
(10013, 1054, '2017-10-01', 30000, 1, 'Ceci est une description', 'Règlement frais de cours : Rakotobe Gerard'),
(10014, 1054, '2017-10-01', 30000, 1, NULL, 'Règlement frais de cours : Rakotobe Gerard'),
(10015, 1054, '2017-10-02', 20000, 1, 'Descritpion', 'Règlement frais de cours : Rakotobe Gerard'),
(10016, 1054, '2017-10-03', 10000, 1, NULL, 'Règlement frais de cours : Rakotobe Gerard'),
(10017, 1054, '2017-10-04', 6000, 1, 'sahirana be hono lery de io aloha ny tratra fa am manaraka mameno azy...', 'Règlement frais de cours : Rakotobe Gerard'),
(10018, 1054, '2017-10-01', 14000, 1, 'ok amzay', 'Règlement frais de cours : Rakotobe Gerard'),
(10019, 1054, '2017-11-04', 20000, 1, NULL, 'Règlement frais de cours : Rakotobe Gerard'),
(10020, 1054, '2017-11-04', 10000, 1, 'test recette', 'Règlement frais de cours : Rakotobe Gerard'),
(10021, 1054, '2017-10-24', 50000, 1, 'dimy arivo iany aloh no tratra', 'Règlement frais de cours : Rakotomirana Fenoharena'),
(10022, 1054, '2017-10-02', 70000, 1, NULL, 'Règlement frais de cours : Rakotomirana Fenoharena'),
(10023, 1054, '2017-10-03', 60000, 1, 'lorem ipsum description', 'Règlement frais de cours : Andrianaina Hery'),
(10024, 1054, '2017-10-19', 40000, 1, 'consecturem file', 'Règlement frais de cours : Andrianaina Hery'),
(10025, 1054, '2017-10-02', 30000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10026, 1054, '2017-11-04', 30000, 1, 'mizotra araka ny tokony izy ny fianarana zay nataony. kinga sy mahay izy', 'Règlement frais de cours : Andrianaina Hery'),
(10027, 1054, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10028, 1054, '2017-10-02', 45000, 1, 'juste ho hanovana desciption fotsiny', 'Règlement frais de cours : Ranarivelo ejameva'),
(10029, 1054, '2017-10-01', 65000, 1, 'Manakory tsara ma izy ity', 'Règlement frais de cours : Ranarivelo ejameva'),
(10030, 1054, '2017-10-08', 90000, 1, 'Mba faniriana ny hahay bureautique hono ny azy. Manatenana ny fanohananreo izy...', 'Règlement frais de cours : Ranarivelo ejameva'),
(10031, 1054, '2017-10-01', 100000, 1, NULL, 'Règlement frais de cours : Rojofinaritra Princia'),
(10032, 1054, '2017-10-01', 20000, 1, 'klkmlkml', 'Règlement frais de cours : Rojofinaritra Princia'),
(10033, 1054, '2017-11-01', 80000, 1, 'tertre', 'Règlement frais de cours : sdfsdf sdfsdf'),
(10034, 1054, '2017-11-05', 80000, 1, NULL, 'Règlement frais de cours : Razaimanana georgette'),
(10035, 1054, '2017-11-04', 50000, 1, 'ok', 'Règlement frais de cours : Fenofitahiana Herman'),
(10036, 1054, '2017-11-04', 200000, 1, 'okok', 'Règlement frais de cours : Fenofitahiana Herman'),
(10037, 1054, '2017-11-01', 70000, 1, 'test rectet', 'Règlement frais de cours : Razaimanana georgette'),
(10038, 1054, '2017-10-01', 80000, 1, NULL, 'Règlement frais de cours : Rojofinaritra Princia'),
(10039, 1054, '2017-10-02', 30000, 1, 'mbola io iany aloh no mety ho voalohany', 'Règlement frais de cours : Rojofinaritra Princia'),
(10040, 1054, '2017-01-18', 35000, 1, 'tsisy ambara', 'Règlement frais de cours : Rojofinaritra Princia'),
(10041, 1054, '2017-10-31', 55000, 1, 'Voaloha jiaby', 'Règlement frais de cours : Rojofinaritra Princia'),
(10042, 1054, '2017-11-04', 30000, 1, NULL, 'Règlement frais de cours : Rojofinaritra Princia'),
(10043, 1054, '2017-10-18', 180000, 1, NULL, 'Règlement frais de cours : Andrianorotseheno Francia Maminira Judith'),
(10044, 1054, '2017-10-02', 20000, 1, 'Aleo mb tena atao mazava tsara ny description mb ts ho sahirana isika', 'Règlement frais de cours : Fenofitahiana Herman'),
(10045, 1054, '2017-10-01', 45000, 1, 'fandoavana ecolage ho an''ni fenofitahiana', 'Règlement frais de cours : Fenofitahiana Herman'),
(10046, 1054, '2017-10-01', 75000, 1, 'lorem ipsum description', 'Règlement frais de cours : Fenofitahiana Herman'),
(10047, 1054, '2017-11-02', 50000, 1, 'tst2', 'Règlement frais de cours : Fenofitahiana Herman'),
(10048, 1054, '2017-11-04', 40000, 1, NULL, 'Règlement frais de cours : Fenofitahiana Herman'),
(10049, 1054, '2017-10-20', 120000, 1, 'ok pour le 1er payement...', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10050, 1054, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10051, 1054, '2017-11-01', 100000, 1, 'Aucune bae', 'Règlement frais de cours : Rafarasoa Lanto'),
(10052, 1055, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10053, 1055, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10054, 1055, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10055, 1055, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10056, 1055, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10057, 1055, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10058, 1056, '2017-10-03', -520000, 1, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10059, 1056, '2017-10-02', 700000, 2, 'description de vente', 'Mouvement article (Vente) samsung s6'),
(10060, 1056, '2017-09-03', 750000, 10, 'ddddd', 'Mouvement article (Vente) samsung s6'),
(10061, 1056, '2017-08-10', 650000, 6, '555', 'Mouvement article (Vente) Huawei P8'),
(10062, 1056, '2017-10-25', -30000, 2, 'sdfsdf', 'Mouvement article (Entrée en stock) Chargeur pour portable'),
(10063, 1056, '2017-10-17', 700000, 6, 'rakoto no nividy an''ity azafady....', 'Mouvement article (Vente) Huawei P8'),
(10064, 1056, '2017-09-25', -490000, 5, 'rehefa nodinihana de mora iany izy ity ka nampiana 20 . sady be mpaka be le izy. tena tendance  be tatoato. am manaraka tonga de maka 40 any.', 'Mouvement article (Entrée en stock) Huawei P8'),
(10065, 1056, '2017-10-01', -250000, 5, 'Ecran nalaina tam naza', 'Mouvement article (Entrée en stock) Ecran 17" vrai marque'),
(10066, 1056, '2017-10-02', 600000, 11, 'nisy naka maromaro', 'Mouvement article (Vente) Huawei P8'),
(10067, 1056, '2017-10-25', -500000, 12, 'vao tonga androany mits', 'Mouvement article (Entrée en stock) samsung s6'),
(10068, 1056, '2017-10-25', -11000, 20, 'Amle qualité tsara ireto tonga ireto', 'Mouvement article (Entrée en stock) Encre'),
(10069, 1056, '2017-10-25', 13000, 20, 'lafo daholo iz rehetra', 'Mouvement article (Vente) Encre'),
(10070, 1056, '2017-10-01', -15000, 10, 'souris amle 15000', 'Mouvement article (Entrée en stock) Souris'),
(10071, 1056, '2017-10-25', -14500, 15, 'souris amle 14500', 'Mouvement article (Entrée en stock) Souris'),
(10072, 1056, '2017-10-04', 20000, 5, 'namidy 20000. 5 no nalain''i Jean Fréderic Antalaha', 'Mouvement article (Vente) Souris'),
(10073, 1056, '2017-10-02', -10000, 10, NULL, 'Mouvement article (Entrée en stock) Encre'),
(10074, 1056, '2017-10-24', -600000, 5, 'Mila ampiana ity fa be mpitady', 'Mouvement article (Entrée en stock) Portable acer'),
(10075, 1056, '2017-10-24', -600000, 3, NULL, 'Mouvement article (Entrée en stock) Portable acer'),
(10076, 1056, '2017-10-25', 700000, 1, 'ffqd', 'Mouvement article (Vente) Portable acer'),
(10077, 1056, '2017-10-31', 720000, 5, NULL, 'Mouvement article (Vente) samsung s6'),
(10078, 1056, '2017-10-24', -500000, 8, 'Arrivage vao mafana be...', 'Mouvement article (Entrée en stock) Huawei P8'),
(10079, 1056, '2017-11-02', -250000, 5, 'Description', 'Mouvement article (Entrée en stock) Samsung J5'),
(10080, 1056, '2017-11-02', 300000, 2, 'Vente J5', 'Mouvement article (Vente) Samsung J5'),
(10081, 1056, '2017-11-01', -60000, 4, 'Mividy ram', 'Mouvement article (Entrée en stock) Ram 4Go DDR4'),
(10082, 1056, '2017-11-02', 70000, 2, NULL, 'Mouvement article (Vente) Ram 4Go DDR4'),
(10083, 1056, '2017-11-01', 300000, 3, NULL, 'Mouvement article (Vente) Samsung J5'),
(10084, 1056, '2017-11-03', 70000, 2, 'fdgsdf sdf', 'Mouvement article (Vente) Ram 4Go DDR4'),
(10085, 1056, '2017-11-01', -60000, 2, NULL, 'Mouvement article (Entrée en stock) Ram 4Go DDR4'),
(10086, 1056, '2017-11-02', -55000, 2, 'ok', 'Mouvement article (Entrée en stock) Ram 4Go DDR4'),
(10087, 1056, '2017-11-01', -5000, 2, 'type stock', 'Mouvement article (Entrée en stock) gggg'),
(10088, 1056, '2017-11-01', 6000, 3, NULL, 'Mouvement article (Vente) gggg'),
(10089, 1056, '2017-11-01', -49000, 1, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10090, 1056, '2017-11-01', -5000, 1, NULL, 'Mouvement article (Entrée en stock) gggg'),
(10091, 1056, '2017-11-03', 700000, 1, NULL, 'Mouvement article (Vente) Portable acer'),
(10092, 1056, '2017-11-03', -270000, 2, NULL, 'Mouvement article (Entrée en stock) Ecran 17" vrai marque'),
(10093, 1056, '2017-11-03', 13200, 8, 'varotra imprimente', 'Mouvement article (Vente) Encre'),
(10094, 1056, '2017-11-04', -110000, 1, 'test recette aujourd''hui', 'Mouvement article (Entrée en stock) Ram 4Go DDR4'),
(10095, 1056, '2017-11-04', 120000, 1, 'test recette', 'Mouvement article (Vente) Ram 4Go DDR4'),
(10096, 1056, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10097, 1056, '2017-11-05', -500000, 2, 'dfgdfg', 'Mouvement article (Entrée en stock) Huawei P8'),
(10098, 1056, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10099, 1056, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10100, 1056, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10101, 1056, '2017-11-04', 30000, 1, 'Un dîner aux chandelles, un ciné en toute intimité, un week-end surprise... Hop, on le surprend et on lui dit Je t''aime. Si vous avez du mal à mettre des mots sur vos sentiments, piochez dans nos plus belles phrases d''amour. La rédac'' a sélectionné les meilleures. Cœur avec les doigts.', 'Gain : Gain 1'),
(10102, 1056, '2017-11-04', 30000, 1, 'test', 'Gain : Gain 2'),
(10103, 1056, '2017-10-02', -350000, 1, 'Manahirana mits ny dépense tahak ''ireto. fandaniana amin''ny ts misy antony mits. mba marina e!', 'Dépense : Dépense be'),
(10104, 1056, '2017-10-19', -50000, 1, 'Fandoavana facture tam volana octobre 2017', 'Dépense : Charge Jirama'),
(10105, 1056, '2017-10-24', -36000, 1, 'Itony mits le karazana fandaniana miompampana.', 'Dépense : miompampana'),
(10106, 1056, '2017-11-01', -5000, 1, 'ok', 'Dépense : Test recettes'),
(10107, 1056, '2017-11-02', -60000, 1, 'dfsf sdf', 'Dépense : tst 2'),
(10108, 1056, '2017-11-03', -30000, 1, 'Hen''omby sy anana', 'Dépense : Mientsana ho an''n Cantine'),
(10109, 1056, '2017-11-04', -20000, 1, 'test recette aujourd''hui', 'Dépense : Dépense kely'),
(10110, 1056, '2017-11-05', -30000, 1, 'ok basy', 'Dépense : vola miala'),
(10111, 1056, '2017-10-01', 20000, 1, 'Mba miezaka n mandoa tsikelikely iany.', 'Règlement frais de cours : Rakotobe Gerard'),
(10112, 1056, '2017-10-03', 20000, 1, 'kely sisa de voaloha daholo', 'Règlement frais de cours : Rakotobe Gerard'),
(10113, 1056, '2017-10-01', 30000, 1, 'Ceci est une description', 'Règlement frais de cours : Rakotobe Gerard'),
(10114, 1056, '2017-10-01', 30000, 1, NULL, 'Règlement frais de cours : Rakotobe Gerard'),
(10115, 1056, '2017-10-02', 20000, 1, 'Descritpion', 'Règlement frais de cours : Rakotobe Gerard'),
(10116, 1056, '2017-10-03', 10000, 1, NULL, 'Règlement frais de cours : Rakotobe Gerard'),
(10117, 1056, '2017-10-04', 6000, 1, 'sahirana be hono lery de io aloha ny tratra fa am manaraka mameno azy...', 'Règlement frais de cours : Rakotobe Gerard'),
(10118, 1056, '2017-10-01', 14000, 1, 'ok amzay', 'Règlement frais de cours : Rakotobe Gerard'),
(10119, 1056, '2017-11-04', 20000, 1, NULL, 'Règlement frais de cours : Rakotobe Gerard'),
(10120, 1056, '2017-11-04', 10000, 1, 'test recette', 'Règlement frais de cours : Rakotobe Gerard'),
(10121, 1056, '2017-10-24', 50000, 1, 'dimy arivo iany aloh no tratra', 'Règlement frais de cours : Rakotomirana Fenoharena'),
(10122, 1056, '2017-10-02', 70000, 1, NULL, 'Règlement frais de cours : Rakotomirana Fenoharena'),
(10123, 1056, '2017-10-03', 60000, 1, 'lorem ipsum description', 'Règlement frais de cours : Andrianaina Hery'),
(10124, 1056, '2017-10-19', 40000, 1, 'consecturem file', 'Règlement frais de cours : Andrianaina Hery'),
(10125, 1056, '2017-10-02', 30000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10126, 1056, '2017-11-04', 30000, 1, 'mizotra araka ny tokony izy ny fianarana zay nataony. kinga sy mahay izy', 'Règlement frais de cours : Andrianaina Hery'),
(10127, 1056, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10128, 1056, '2017-10-02', 45000, 1, 'juste ho hanovana desciption fotsiny', 'Règlement frais de cours : Ranarivelo ejameva'),
(10129, 1056, '2017-10-01', 65000, 1, 'Manakory tsara ma izy ity', 'Règlement frais de cours : Ranarivelo ejameva'),
(10130, 1056, '2017-10-08', 90000, 1, 'Mba faniriana ny hahay bureautique hono ny azy. Manatenana ny fanohananreo izy...', 'Règlement frais de cours : Ranarivelo ejameva'),
(10131, 1056, '2017-10-01', 100000, 1, NULL, 'Règlement frais de cours : Rojofinaritra Princia'),
(10132, 1056, '2017-10-01', 20000, 1, 'klkmlkml', 'Règlement frais de cours : Rojofinaritra Princia'),
(10133, 1056, '2017-11-01', 80000, 1, 'tertre', 'Règlement frais de cours : sdfsdf sdfsdf'),
(10134, 1056, '2017-11-05', 80000, 1, NULL, 'Règlement frais de cours : Razaimanana georgette'),
(10135, 1056, '2017-11-04', 50000, 1, 'ok', 'Règlement frais de cours : Fenofitahiana Herman'),
(10136, 1056, '2017-11-04', 200000, 1, 'okok', 'Règlement frais de cours : Fenofitahiana Herman'),
(10137, 1056, '2017-11-01', 70000, 1, 'test rectet', 'Règlement frais de cours : Razaimanana georgette'),
(10138, 1056, '2017-10-01', 80000, 1, NULL, 'Règlement frais de cours : Rojofinaritra Princia'),
(10139, 1056, '2017-10-02', 30000, 1, 'mbola io iany aloh no mety ho voalohany', 'Règlement frais de cours : Rojofinaritra Princia'),
(10140, 1056, '2017-01-18', 35000, 1, 'tsisy ambara', 'Règlement frais de cours : Rojofinaritra Princia'),
(10141, 1056, '2017-10-31', 55000, 1, 'Voaloha jiaby', 'Règlement frais de cours : Rojofinaritra Princia'),
(10142, 1056, '2017-11-04', 30000, 1, NULL, 'Règlement frais de cours : Rojofinaritra Princia'),
(10143, 1056, '2017-10-18', 180000, 1, NULL, 'Règlement frais de cours : Andrianorotseheno Francia Maminira Judith'),
(10144, 1056, '2017-10-02', 20000, 1, 'Aleo mb tena atao mazava tsara ny description mb ts ho sahirana isika', 'Règlement frais de cours : Fenofitahiana Herman'),
(10145, 1056, '2017-10-01', 45000, 1, 'fandoavana ecolage ho an''ni fenofitahiana', 'Règlement frais de cours : Fenofitahiana Herman'),
(10146, 1056, '2017-10-01', 75000, 1, 'lorem ipsum description', 'Règlement frais de cours : Fenofitahiana Herman'),
(10147, 1056, '2017-11-02', 50000, 1, 'tst2', 'Règlement frais de cours : Fenofitahiana Herman'),
(10148, 1056, '2017-11-04', 40000, 1, NULL, 'Règlement frais de cours : Fenofitahiana Herman'),
(10149, 1056, '2017-10-20', 120000, 1, 'ok pour le 1er payement...', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10150, 1056, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10151, 1056, '2017-11-01', 100000, 1, 'Aucune bae', 'Règlement frais de cours : Rafarasoa Lanto'),
(10152, 1057, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10153, 1057, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10154, 1057, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10155, 1057, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10156, 1057, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10157, 1057, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10158, 1058, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10159, 1058, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10160, 1058, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10161, 1058, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10162, 1058, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10163, 1058, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10164, 1059, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10165, 1059, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10166, 1059, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10167, 1059, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10168, 1059, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10169, 1059, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10170, 1060, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10171, 1060, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10172, 1060, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10173, 1060, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10174, 1060, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10175, 1060, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10176, 1061, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10177, 1061, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10178, 1061, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10179, 1061, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10180, 1061, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10181, 1061, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10182, 1062, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10183, 1062, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10184, 1062, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10185, 1062, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10186, 1062, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10187, 1062, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10188, 1063, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10189, 1063, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10190, 1063, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10191, 1063, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10192, 1063, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10193, 1063, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10194, 1064, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10195, 1064, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10196, 1064, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10197, 1064, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10198, 1064, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10199, 1064, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10200, 1065, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10201, 1065, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10202, 1065, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10203, 1065, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10204, 1065, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10205, 1065, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10206, 1066, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10207, 1066, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10208, 1066, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10209, 1066, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10210, 1066, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10211, 1066, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana'),
(10212, 1067, '2017-11-06', 600000, 1, 'y', 'Mouvement article (Vente) Huawei P8'),
(10213, 1067, '2017-11-06', 600000, 2, NULL, 'Mouvement article (Vente) Huawei P8'),
(10214, 1067, '2017-11-06', -560000, 4, NULL, 'Mouvement article (Entrée en stock) Huawei P8'),
(10215, 1067, '2017-11-06', -450000, 5, 'fsdf', 'Mouvement article (Entrée en stock) Huawei P8'),
(10216, 1067, '2017-11-06', 10000, 1, NULL, 'Règlement frais de cours : Andrianaina Hery'),
(10217, 1067, '2017-11-06', 80000, 1, 'Lorem ipsum dolor et sit amet consecturen mvu', 'Règlement frais de cours : Noroseheno Malalatiana');

-- --------------------------------------------------------

--
-- Structure de la table `sf_absence`
--

CREATE TABLE `sf_absence` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `employeeinterim_id` int(11) DEFAULT NULL,
  `reason` longtext COLLATE utf8_unicode_ci,
  `datebegin` datetime NOT NULL,
  `dateend` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `sf_absence`
--

INSERT INTO `sf_absence` (`id`, `employee_id`, `employeeinterim_id`, `reason`, `datebegin`, `dateend`, `deleted`) VALUES
(1, 4, 9, 'Nohon''ny fiparitahan''ny valan''aretina Pesta izao de naleony mits aloh naka congé.', '2017-10-03 07:40:00', '2017-10-31 10:51:00', 1),
(31, 4, NULL, 'test validation', '2017-10-01 00:00:00', '2017-10-02 00:00:00', 1),
(32, 5, 6, 'ceci est un test', '2017-10-25 08:00:00', '2017-11-02 16:42:00', 1),
(33, 8, 4, 'Raison familiale. Namonjy famadihana. tokony tonga alohan''ny 28 octobre 2017 fa misy asa tokony ho enjehiny zay.', '2017-10-27 07:54:00', '2017-10-30 07:54:00', 0),
(34, 4, 6, 'raikitra zany e!', '2017-10-11 00:00:00', '2017-10-13 00:00:00', 1),
(35, 12, 9, NULL, '2017-10-19 16:46:00', '2017-10-23 08:30:00', 0),
(36, 9, 4, 'test modification fotsiny', '2017-10-27 07:44:00', '2017-10-27 08:45:00', 0),
(37, 4, 8, 'juste absent fotsiny', '2017-10-25 08:00:00', '2017-11-02 08:00:00', 1),
(38, 8, 9, NULL, '2017-11-02 00:00:00', '2017-11-03 16:08:00', 0),
(39, 13, NULL, NULL, '2017-11-01 00:00:00', '2017-11-06 00:00:00', 0),
(40, 7, 6, 'nanao vacances...', '2017-11-03 08:00:00', '2017-11-08 08:00:00', 0),
(41, 4, 5, 'tets', '2017-11-01 00:00:00', '2017-11-07 00:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `sf_employee`
--

CREATE TABLE `sf_employee` (
  `id` int(11) NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salary` int(11) NOT NULL,
  `positiondate` date NOT NULL,
  `person_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `sf_employee`
--

INSERT INTO `sf_employee` (`id`, `position`, `salary`, `positiondate`, `person_id`, `deleted`) VALUES
(4, 'Chaufeur', 650000, '2017-10-25', 2, 0),
(5, 'Enseignant', 650000, '2017-09-24', 4, 1),
(6, 'Coursier', 400000, '2017-09-25', 5, 0),
(7, 'Comptable', 600000, '2016-08-10', 6, 0),
(8, 'Superviseur', 600000, '2017-07-31', 7, 0),
(9, 'Directeur', 940000, '2017-09-24', 8, 0),
(10, 'Standardiste', 750000, '2015-10-14', 9, 0),
(11, 'Superviseur adjoint', 500000, '2017-10-01', 19, 0),
(12, 'Agent de sécurité', 650000, '2017-10-16', 21, 0),
(13, 'Coursier', 500000, '2017-10-17', 29, 0);

-- --------------------------------------------------------

--
-- Structure de la table `tg_course`
--

CREATE TABLE `tg_course` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `tg_course`
--

INSERT INTO `tg_course` (`id`, `name`, `reference`, `description`, `deleted`, `price`) VALUES
(1, 'bureautique classique', 'BC1', 'Description bureautique classique', 0, 220000),
(2, 'multimédia classique', 'MC', 'Description multimédia accéléré. le but est de faire connaitre au élèves les notions sur les PAO et DAO', 0, 180000),
(3, 'bureautique accéléré', 'BA', 'Cours de bureautique accéléré', 1, 200000),
(4, 'Multimédia accéléré', 'MA', 'Cours de multimédia accéléré', 0, 250000),
(5, 'Initiation à l''internet', 'WEB', 'cours à savoir sur l''utilisation de l''internet', 0, 300000),
(6, 'Informatique de gestion', 'IG', 'cours à savoir sur l''utilisation de l''informatique de gestion', 1, 400000),
(7, 'fsdfs', 'dfdf', 'ssdf', 1, 220000);

-- --------------------------------------------------------

--
-- Structure de la table `tg_fee`
--

CREATE TABLE `tg_fee` (
  `id` int(11) NOT NULL,
  `studentgroup_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `paymentdate` date NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `tg_fee`
--

INSERT INTO `tg_fee` (`id`, `studentgroup_id`, `amount`, `paymentdate`, `description`, `deleted`) VALUES
(1, 1, 20000, '2017-10-01', 'Mba miezaka n mandoa tsikelikely iany.', 0),
(2, 1, 20000, '2017-10-03', 'kely sisa de voaloha daholo', 0),
(3, 1, 30000, '2017-10-01', 'Ceci est une description', 0),
(4, 1, 30000, '2017-10-01', NULL, 0),
(5, 1, 20000, '2017-10-02', 'Descritpion', 0),
(6, 1, 10000, '2017-10-03', NULL, 0),
(7, 11, 80000, '2017-10-01', NULL, 0),
(8, 11, 30000, '2017-10-02', 'mbola io iany aloh no mety ho voalohany', 0),
(9, 11, 35000, '2017-01-18', 'tsisy ambara', 0),
(10, 9, 25000, '2017-10-03', 'ekolazy', 1),
(11, 1, 6000, '2017-10-04', 'sahirana be hono lery de io aloha ny tratra fa am manaraka mameno azy...', 0),
(12, 4, 45000, '2017-10-02', 'juste ho hanovana desciption fotsiny', 0),
(13, 10, 20000, '2017-10-02', 'Aleo mb tena atao mazava tsara ny description mb ts ho sahirana isika', 0),
(14, 10, 45000, '2017-10-01', 'fandoavana ecolage ho an''ni fenofitahiana', 0),
(15, 1, 14000, '2017-10-01', 'ok amzay', 0),
(16, 5, 100000, '2017-10-01', NULL, 0),
(17, 5, 20000, '2017-10-01', 'klkmlkml', 0),
(18, 12, 100000, '2017-10-01', 'ok', 1),
(19, 12, 55000, '2017-10-10', 'kely sisa de voaloha', 1),
(20, 12, 145000, '2017-10-02', 'vita n payement', 1),
(21, 10, 75000, '2017-10-01', 'lorem ipsum description', 0),
(22, 4, 65000, '2017-10-01', 'Manakory tsara ma izy ity', 0),
(23, 4, 90000, '2017-10-08', 'Mba faniriana ny hahay bureautique hono ny azy. Manatenana ny fanohananreo izy...', 0),
(24, 9, 55000, '2017-10-18', 'am manaraka manao be', 1),
(25, 3, 60000, '2017-10-03', 'lorem ipsum description', 0),
(26, 3, 40000, '2017-10-19', 'consecturem file', 0),
(27, 8, 180000, '2017-10-18', NULL, 0),
(28, 2, 50000, '2017-10-24', 'dimy arivo iany aloh no tratra', 0),
(29, 2, 70000, '2017-10-02', NULL, 0),
(30, 14, 120000, '2017-10-20', 'ok pour le 1er payement...', 0),
(31, 14, 80000, '2017-10-02', NULL, 1),
(32, 15, 100000, '2017-10-01', 'sfgsgfd fjgjgj', 1),
(33, 11, 55000, '2017-10-31', 'Voaloha jiaby', 0),
(34, 3, 30000, '2017-10-02', NULL, 0),
(35, 6, 200000, '2017-10-09', NULL, 1),
(36, 7, 70000, '2017-11-01', 'test rectet', 0),
(37, 10, 50000, '2017-11-02', 'tst2', 0),
(38, 15, 100000, '2017-11-01', 'Aucune bae', 0),
(39, 18, 80000, '2017-11-01', 'tertre', 0),
(40, 9, 10000, '2017-11-03', '10000 ar no payeny anio 03-11-2017.', 1),
(41, 11, 30000, '2017-11-04', NULL, 0),
(42, 1, 20000, '2017-11-04', NULL, 0),
(43, 1, 10000, '2017-11-04', 'test recette', 0),
(44, 10, 40000, '2017-11-04', NULL, 0),
(45, 3, 30000, '2017-11-04', 'mizotra araka ny tokony izy ny fianarana zay nataony. kinga sy mahay izy', 0),
(46, 6, 50000, '2017-11-04', 'ok', 0),
(47, 6, 200000, '2017-11-04', 'okok', 0),
(48, 20, 80000, '2017-11-05', NULL, 0),
(49, 3, -10000, '2017-11-01', NULL, 1),
(50, 3, 10000, '2017-11-06', NULL, 0),
(51, 14, 80000, '2017-11-06', 'Lorem ipsum dolor et sit amet consecturen mvu', 0);

-- --------------------------------------------------------

--
-- Structure de la table `tg_group`
--

CREATE TABLE `tg_group` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `price` double NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `tg_group`
--

INSERT INTO `tg_group` (`id`, `course_id`, `name`, `description`, `price`, `deleted`) VALUES
(1, 1, 'Groupe 1 bureautique classique', 'Description groupe 1', 160000, 0),
(2, 2, 'Groupe 2 multimédia classique', 'Description 2', 200000, 0),
(3, 4, 'Group multimedia accéléré', 'ceci est une description', 230000, 0),
(4, 3, 'Groupe BA1', 'Groupe ho an''ny maika', 300000, 1),
(5, 5, 'Groupe internet 1', 'GI : Groupe d''initiation à internet 1', 300000, 0);

-- --------------------------------------------------------

--
-- Structure de la table `tg_student`
--

CREATE TABLE `tg_student` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `matricule` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `tg_student`
--

INSERT INTO `tg_student` (`id`, `person_id`, `matricule`, `deleted`) VALUES
(1, 10, '001/MUG/12', 0),
(2, 11, 'BUR/20/17', 0),
(3, 12, '45/JI/52', 0),
(4, 13, '123', 0),
(5, 14, '123', 0),
(6, 15, 'BUR/21/17', 0),
(7, 16, '546/17', 0),
(8, 17, '12', 0),
(9, 18, '12345', 0),
(10, 20, 'BUR/22/17', 1),
(11, 22, 'BU/78/5', 0),
(12, 23, 'V12V/55', 0),
(13, 24, 'dsf', 0),
(14, 25, '12345678', 0),
(15, 26, 'dfdsf', 0),
(16, 27, 'sdfsdf', 0),
(17, 28, 'sdfsdf', 0),
(18, 30, '12-45-56', 0),
(19, 31, '123', 1);

-- --------------------------------------------------------

--
-- Structure de la table `tg_studentgroup`
--

CREATE TABLE `tg_studentgroup` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `tg_studentgroup`
--

INSERT INTO `tg_studentgroup` (`id`, `student_id`, `group_id`, `price`, `deleted`) VALUES
(1, 1, 1, 180000, 0),
(2, 2, 1, 150000, 0),
(3, 4, 1, 170000, 0),
(4, 5, 1, 200000, 0),
(5, 6, 1, 200000, 0),
(6, 8, 2, 250000, 0),
(7, 7, 2, 200000, 0),
(8, 9, 3, 230000, 0),
(9, 9, 1, 160000, 1),
(10, 8, 3, 230000, 0),
(11, 6, 2, 220000, 0),
(12, 4, 4, 300000, 1),
(13, 7, 1, 160000, 1),
(14, 11, 5, 300000, 0),
(15, 15, 5, 300000, 0),
(16, 16, 4, 300000, 1),
(17, 18, 2, 200000, 0),
(18, 17, 1, 160000, 0),
(19, 3, 1, 170000, 1),
(20, 7, 1, 160000, 0),
(21, 19, 1, 160000, 1),
(22, 3, 1, 170000, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ur_user`
--

CREATE TABLE `ur_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `date` datetime NOT NULL,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `ur_user`
--

INSERT INTO `ur_user` (`id`, `username`, `token`, `password`, `salt`, `roles`, `date`, `person_id`) VALUES
(1, 'user1', 'b7ILgAuPQ2cRFOkYWMOKog8he6h9aFHtqLmPKMKjjwPxSl3zD6o0j8kX8hP0NSmf', 'Rm5EXn+/rs1DcjgIZk5AFf5+Lzpv//JwBjmn9rFjEqBnGQQEt/gL2KZnpD2dUX+ku1VVAlThH/DqKjdZeE823w==', '10e5f90d7339069fc348e82591d36cbd', 'a:1:{i:0;s:10:"ROLE_ADMIN";}', '2016-12-02 07:27:13', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `bs_brand`
--
ALTER TABLE `bs_brand`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bs_category`
--
ALTER TABLE `bs_category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bs_expenditure`
--
ALTER TABLE `bs_expenditure`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bs_gain`
--
ALTER TABLE `bs_gain`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bs_product`
--
ALTER TABLE `bs_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_3D967992989D9B62` (`slug`),
  ADD KEY `IDX_3D96799212469DE2` (`category_id`),
  ADD KEY `IDX_3D96799244F5D008` (`brand_id`);

--
-- Index pour la table `bs_productimage`
--
ALTER TABLE `bs_productimage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EBBA13C54584665A` (`product_id`);

--
-- Index pour la table `bs_stock`
--
ALTER TABLE `bs_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5AA0A9464584665A` (`product_id`);

--
-- Index pour la table `bs_transaction`
--
ALTER TABLE `bs_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EC695349B3E6B071` (`transaction_type_id`);

--
-- Index pour la table `bs_transaction_type`
--
ALTER TABLE `bs_transaction_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pm_person`
--
ALTER TABLE `pm_person`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pm_personimage`
--
ALTER TABLE `pm_personimage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_459DF45C217BBB47` (`person_id`);

--
-- Index pour la table `pm_taking`
--
ALTER TABLE `pm_taking`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pm_takingline`
--
ALTER TABLE `pm_takingline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2692D541E8BE7A6B` (`taking_id`);

--
-- Index pour la table `sf_absence`
--
ALTER TABLE `sf_absence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6BD701E8C03F15C` (`employee_id`),
  ADD KEY `IDX_B6BD701E61C5A287` (`employeeinterim_id`);

--
-- Index pour la table `sf_employee`
--
ALTER TABLE `sf_employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_45E8D546217BBB47` (`person_id`);

--
-- Index pour la table `tg_course`
--
ALTER TABLE `tg_course`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tg_fee`
--
ALTER TABLE `tg_fee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F005E77A672A8DC2` (`studentgroup_id`);

--
-- Index pour la table `tg_group`
--
ALTER TABLE `tg_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_55133B92591CC992` (`course_id`);

--
-- Index pour la table `tg_student`
--
ALTER TABLE `tg_student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_826330DE217BBB47` (`person_id`);

--
-- Index pour la table `tg_studentgroup`
--
ALTER TABLE `tg_studentgroup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E80AF2ECCB944F1A` (`student_id`),
  ADD KEY `IDX_E80AF2ECFE54D947` (`group_id`);

--
-- Index pour la table `ur_user`
--
ALTER TABLE `ur_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_7342DD77F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_7342DD77217BBB47` (`person_id`),
  ADD UNIQUE KEY `UNIQ_7342DD775F37A13B` (`token`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `bs_brand`
--
ALTER TABLE `bs_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `bs_category`
--
ALTER TABLE `bs_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `bs_expenditure`
--
ALTER TABLE `bs_expenditure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `bs_gain`
--
ALTER TABLE `bs_gain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `bs_product`
--
ALTER TABLE `bs_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT pour la table `bs_productimage`
--
ALTER TABLE `bs_productimage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT pour la table `bs_stock`
--
ALTER TABLE `bs_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT pour la table `bs_transaction`
--
ALTER TABLE `bs_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT pour la table `bs_transaction_type`
--
ALTER TABLE `bs_transaction_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `pm_person`
--
ALTER TABLE `pm_person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `pm_personimage`
--
ALTER TABLE `pm_personimage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT pour la table `pm_taking`
--
ALTER TABLE `pm_taking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1068;
--
-- AUTO_INCREMENT pour la table `pm_takingline`
--
ALTER TABLE `pm_takingline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10218;
--
-- AUTO_INCREMENT pour la table `sf_absence`
--
ALTER TABLE `sf_absence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT pour la table `sf_employee`
--
ALTER TABLE `sf_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `tg_course`
--
ALTER TABLE `tg_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `tg_fee`
--
ALTER TABLE `tg_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT pour la table `tg_group`
--
ALTER TABLE `tg_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `tg_student`
--
ALTER TABLE `tg_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `tg_studentgroup`
--
ALTER TABLE `tg_studentgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `ur_user`
--
ALTER TABLE `ur_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `bs_product`
--
ALTER TABLE `bs_product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `bs_category` (`id`),
  ADD CONSTRAINT `FK_D34A04AD44F5D008` FOREIGN KEY (`brand_id`) REFERENCES `bs_brand` (`id`);

--
-- Contraintes pour la table `bs_productimage`
--
ALTER TABLE `bs_productimage`
  ADD CONSTRAINT `FK_EBBA13C54584665A` FOREIGN KEY (`product_id`) REFERENCES `bs_product` (`id`);

--
-- Contraintes pour la table `bs_stock`
--
ALTER TABLE `bs_stock`
  ADD CONSTRAINT `FK_5AA0A9464584665A` FOREIGN KEY (`product_id`) REFERENCES `bs_product` (`id`);

--
-- Contraintes pour la table `bs_transaction`
--
ALTER TABLE `bs_transaction`
  ADD CONSTRAINT `FK_723705D1B3E6B071` FOREIGN KEY (`transaction_type_id`) REFERENCES `bs_transaction_type` (`id`);

--
-- Contraintes pour la table `pm_personimage`
--
ALTER TABLE `pm_personimage`
  ADD CONSTRAINT `FK_459DF45C217BBB47` FOREIGN KEY (`person_id`) REFERENCES `pm_person` (`id`);

--
-- Contraintes pour la table `pm_takingline`
--
ALTER TABLE `pm_takingline`
  ADD CONSTRAINT `FK_2692D541E8BE7A6B` FOREIGN KEY (`taking_id`) REFERENCES `pm_taking` (`id`);

--
-- Contraintes pour la table `sf_absence`
--
ALTER TABLE `sf_absence`
  ADD CONSTRAINT `FK_B6BD701E61C5A287` FOREIGN KEY (`employeeinterim_id`) REFERENCES `sf_employee` (`id`),
  ADD CONSTRAINT `FK_B6BD701E8C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `sf_employee` (`id`);

--
-- Contraintes pour la table `sf_employee`
--
ALTER TABLE `sf_employee`
  ADD CONSTRAINT `FK_45E8D546217BBB47` FOREIGN KEY (`person_id`) REFERENCES `pm_person` (`id`);

--
-- Contraintes pour la table `tg_fee`
--
ALTER TABLE `tg_fee`
  ADD CONSTRAINT `FK_F005E77A672A8DC2` FOREIGN KEY (`studentgroup_id`) REFERENCES `tg_studentgroup` (`id`);

--
-- Contraintes pour la table `tg_group`
--
ALTER TABLE `tg_group`
  ADD CONSTRAINT `FK_55133B92591CC992` FOREIGN KEY (`course_id`) REFERENCES `tg_course` (`id`);

--
-- Contraintes pour la table `tg_student`
--
ALTER TABLE `tg_student`
  ADD CONSTRAINT `FK_826330DE217BBB47` FOREIGN KEY (`person_id`) REFERENCES `pm_person` (`id`);

--
-- Contraintes pour la table `tg_studentgroup`
--
ALTER TABLE `tg_studentgroup`
  ADD CONSTRAINT `FK_A5CFFA83CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `tg_student` (`id`),
  ADD CONSTRAINT `FK_A5CFFA83FE54D947` FOREIGN KEY (`group_id`) REFERENCES `tg_group` (`id`);

--
-- Contraintes pour la table `ur_user`
--
ALTER TABLE `ur_user`
  ADD CONSTRAINT `FK_7342DD77217BBB47` FOREIGN KEY (`person_id`) REFERENCES `pm_person` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
