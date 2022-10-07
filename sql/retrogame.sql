-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 07, 2022 at 08:35 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `retrogame`
--

-- --------------------------------------------------------

--
-- Table structure for table `avis`
--

CREATE TABLE `avis` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idProduit` int(11) NOT NULL,
  `nomClient` varchar(50) NOT NULL,
  `note` decimal(3,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `catigories`
--

CREATE TABLE `catigories` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `catigories`
--

INSERT INTO `catigories` (`id`, `libelle`, `create_date`) VALUES
(1, 'JEUX', '2022-10-04 15:56:37'),
(2, 'JEUX RETRO', '2022-10-04 15:57:27'),
(3, 'ACCESSOIRES', '2022-10-04 15:57:27'),
(4, 'CONSOLES', '2022-10-04 15:57:27');

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Validée','Commandée','Annulée','Payée','Préparée','Livrée','En cours') DEFAULT 'En cours',
  `total` decimal(10,0) NOT NULL,
  `idClient` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `payment` enum('Carte','Virement') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `libelle`, `create_date`) VALUES
(1, 'ACTION', '2022-10-04 15:58:40'),
(2, 'AVIATION', '2022-10-04 15:58:40'),
(3, 'COMBAT', '2022-10-04 15:58:40'),
(4, 'COURSE', '2022-10-04 15:59:07'),
(5, 'JEUX DE SOCIETE', '2022-10-04 15:59:07'),
(6, 'JEUX DE RÔLE', '2022-10-04 15:59:41'),
(7, 'LUDO EDUCATION', '2022-10-04 15:59:41');

-- --------------------------------------------------------

--
-- Table structure for table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `quantite` int(11) DEFAULT '1',
  `prix` decimal(10,0) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `plateforme` enum('PS1','PS2','PS3','PS4','PS5','PSP','PS VITA','XBOX X','XBOX ONE','XBOX 360','SWITCH','WII U','WII','3DS','DS','PC','RETRO') NOT NULL,
  `editeur` varchar(50) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stock` int(11) NOT NULL DEFAULT '0',
  `isDisponible` tinyint(1) NOT NULL DEFAULT '1',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `fabriquant` varchar(50) DEFAULT NULL,
  `idGenre` int(11) NOT NULL,
  `idCategorie` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`id`, `libelle`, `description`, `plateforme`, `editeur`, `create_date`, `stock`, `isDisponible`, `isActive`, `fabriquant`, `idGenre`, `idCategorie`, `prix`, `image`) VALUES
(1, 'Fifa23', 'Toujours plus réaliste, plus précis et plus passionnant que jamais, Fifa 16 sur Xbox 360 fait entrer les équipes féminines sur le terrain.', 'PS1', 'Electronic Arts', '2022-10-04 15:55:37', 12, 1, 1, 'Electronic Arts', 1, 1, '99.45', 'Fifa23.jpg'),
(2, 'pokemon-ultra-lune', 'Retournez sur les îles de Kalos dans Pokemon Ultra Soleil sur Nintendo 3DS. De nouvelles aventures vous attendent, avec de nouvelles formes de pokémons et de nouvelles attaques spéciales Z !', '3DS', 'Nintendo', '2022-10-06 20:19:48', 120, 1, 1, NULL, 2, 1, '25.96', 'pokemon-ultra-lune-e122333.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sadmin`
--

CREATE TABLE `sadmin` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `cle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sadmin`
--

INSERT INTO `sadmin` (`id`, `nom`, `prenom`, `email`, `password`, `cle`) VALUES
(1, 'ra', 'ra', 'ra@ra.com', 'aq116ebc405f841bd16d7cc29e2c83a055196da403325', '663bcf3fb2d415d7763b5e81dcc3b75cd9f77f211664883874');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `cle` text NOT NULL,
  `role` enum('Client','Vendeur') NOT NULL,
  `isBlocked` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `cle`, `role`, `isBlocked`) VALUES
(1, 'rachid', 'rachid', 'rachid.abbou@gmail.com', 'aq1601f1889667efaebb33b8c12572835da3f027f7825', 'd46ada7b54fbc1677743693ec8819193573c23bb1664883482', 'Client', 0),
(2, 'rachid', 'rachid', 'auteur3@gmail.com', 'aq116ebc405f841bd16d7cc29e2c83a055196da403325', '663bcf3fb2d415d7763b5e81dcc3b75cd9f77f211664883874', 'Client', 0),
(3, 'abbou', 'rachid', 'rachid.abbou@gmail.com', 'aq116ebc405f841bd16d7cc29e2c83a055196da403325', '8e062616d9a3cb70798ab95f29d3c8350cfe413c1665055864', 'Vendeur', 0),
(4, 'ra', 'ra', 'ra@ra.com', 'aq116ebc405f841bd16d7cc29e2c83a055196da403325', '936973dba83029b2689139509afe87318f62014f1665056216', 'Vendeur', 1),
(6, 'zavata', 'dfdf', 'rrr@gmail.com', 'aq1c7b1eda25a16eeda205878bfc502c48c9e72d11c25', 'ef8aea9f32722d1cbb66ad729a12c2e01687a8091665056983', 'Vendeur', 1),
(7, 'sdsdsds', 'sdsdsd', 'rachid.abbou@gmail.com', 'aq11ab634afefdb407a6d03f72ee69f0f724e0f60c725', '4715f00ed7fa957b1992cbbef9b0a864605bd8be1665057070', 'Vendeur', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catigories`
--
ALTER TABLE `catigories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sadmin`
--
ALTER TABLE `sadmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catigories`
--
ALTER TABLE `catigories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sadmin`
--
ALTER TABLE `sadmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
