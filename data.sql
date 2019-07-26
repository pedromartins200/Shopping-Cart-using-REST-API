-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Jul-2019 às 13:49
-- Versão do servidor: 10.3.16-MariaDB
-- versão do PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_teste`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`) VALUES
(1, 1),
(9, 44);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `user_id`, `product_id`, `quantity`) VALUES
(357, 9, 44, 3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`) VALUES
(1, 'Photography And Art', 'Books dedicated to art and photography, music, design, fashion, movies.', NULL),
(2, 'Biography', 'Books dedicated to biography in sports, science, history, crime and drama.', NULL),
(3, 'Food & Beverage', 'Books dedicated to food, deserts and beverages.', NULL),
(4, 'School', 'Books dedicated to primary, secondary and universitary.', NULL),
(5, 'History', 'Books dedicated to miliary history, european and world.', NULL),
(6, 'Health And Well Being', 'Books dedicated to family, health and other aspects of social life.', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `password_digest` varchar(255) DEFAULT NULL,
  `remember_digest` varchar(255) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `activation_digest` varchar(255) DEFAULT NULL,
  `activated` tinyint(1) DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `api_key` varchar(40) DEFAULT NULL,
  `reset_digest` varchar(255) DEFAULT NULL,
  `reset_sent_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `created_at`, `updated_at`, `password_digest`, `remember_digest`, `admin`, `activation_digest`, `activated`, `activated_at`, `api_key`, `reset_digest`, `reset_sent_at`) VALUES
(1, 'joni', 'soprajogos311@gmail.com', '2018-11-21 23:00:42', '2018-11-21 23:00:42', 'd3ce9efea6244baa7bf718f12dd0c331', 'c979592a76ce88968083623f22ac38f7', NULL, NULL, NULL, NULL, 'ADkNjnBBKLi', NULL, NULL),
(44, 'odkjas', 'dasdc@gmail.com', '2019-07-23 20:25:37', '2019-07-23 20:25:37', 'd3ce9efea6244baa7bf718f12dd0c331', NULL, NULL, NULL, NULL, NULL, 'NrSNq54w0W', NULL, NULL),
(51, 'pedrocas', 'chourico@gmail.com', '2019-07-26 01:18:27', '2019-07-26 01:18:27', 'd3ce9efea6244baa7bf718f12dd0c331', NULL, NULL, NULL, NULL, NULL, 'VWcpqbeAYt', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `total` int(5) DEFAULT NULL,
  `voucher` int(11) DEFAULT NULL COMMENT 'percentagem do desconto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` int(5) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `cat_id`, `name`, `description`, `price`, `image`) VALUES
(1, 3, 'Calories, Fat & CarboHydrate', 'A effective guide to a healthy and lasting weight loss. (by Allan Borushek)', 25, 'books_image/calories_fat_carbohydrate.png'),
(2, 3, 'The Law Relating to Food', 'Every law and regulation related to the food industry. (by Ian Thomas)', 38, 'books_image/the_law_relating_to_food.png'),
(3, 3, 'It starts with food', 'A sustainable plan to change the way you eat forever. (by Dallas Hartwig)', 19, 'books_image/it_starts_with_food.png'),
(4, 3, 'Why we get fat ', 'What’s making us fat? And how can we change? (by Gary Taubes)', 26, 'books_image/why_we_get_fat.png'),
(5, 3, 'Almond Flour Recipes', 'Every recipe relating to almond flour. (by Ranae Richoux)', 14, 'books_image/almond_flour_recipes.png'),
(6, 3, 'Pediatric Nutrition', 'All the information related to nutrition to infants. (by AAP Committee)', 71, 'books_image/pediatric_nutrition.png'),
(7, 1, 'Veterans Crisis Hotline', 'What kind of help do our veterans get?', 43, 'books_image/veterans_crisis_hotline.png'),
(8, 1, 'American moderns', 'The bohemian lives of men and women in america.(by Christine Stansell)', 29, 'books_image/american_moderns.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `voucher_key` varchar(20) DEFAULT NULL,
  `discount_percentage` int(11) DEFAULT NULL,
  `valid_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `vouchers`
--

INSERT INTO `vouchers` (`id`, `voucher_key`, `discount_percentage`, `valid_until`) VALUES
(1, 'cookies', 10, '2020-04-16 00:00:00'),
(2, 'burguers', 20, '2020-04-03 00:00:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Índices para tabela `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index_users_on_email` (`email`);

--
-- Índices para tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Índices para tabela `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Índices para tabela `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=360;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Limitadores para a tabela `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Limitadores para a tabela `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
