-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 18, 2022 at 06:12 AM
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
  `prix` decimal(10,2) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `panier`
--

INSERT INTO `panier` (`id`, `idProduit`, `quantite`, `prix`, `create_date`, `idClient`) VALUES
(45, 21, 1, '12.36', '2022-10-17 17:15:25', 8),
(46, 22, 1, '74.95', '2022-10-17 17:42:44', 8),
(47, 23, 1, '14.56', '2022-10-17 17:42:45', 8),
(48, 24, 1, '1.95', '2022-10-17 17:42:46', 8),
(49, 26, 1, '45.23', '2022-10-17 17:42:48', 8),
(50, 25, 2, '30.99', '2022-10-17 17:42:50', 8);

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `plateforme` enum('PS1','PS2','PS3','PS4','PS5','PSP','PS-VITA','XBOX-X','XBOX-ONE','XBOX-360','SWITCH','WII-U','WII','3DS','DS','PC','RETRO') NOT NULL,
  `editeur` varchar(50) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stock` int(11) NOT NULL DEFAULT '0',
  `isDisponible` tinyint(1) NOT NULL DEFAULT '1',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `fabricant` varchar(50) DEFAULT NULL,
  `idGenre` int(11) NOT NULL,
  `idCategorie` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(250) NOT NULL,
  `isSelected` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`id`, `libelle`, `description`, `plateforme`, `editeur`, `create_date`, `stock`, `isDisponible`, `isActive`, `fabricant`, `idGenre`, `idCategorie`, `prix`, `image`, `isSelected`) VALUES
(21, 'Fifa 23', 'FIFA 23', 'WII-U', 'azerty', '2022-10-14 15:10:29', 454, 1, 1, '', 1, 2, '12.36', 'Fifa23.jpg', 1),
(22, 'Muv-Luv Alternative', 'Muv-Luv Alternative', 'PS-VITA', 'PQube', '2022-10-14 15:12:54', 120, 1, 1, '', 1, 1, '74.95', 'muv-luv-alternative-e155877.jpg', 1),
(23, 'Super Mario Bros. 3', 'Super Mario Bros. 3', 'RETRO', 'Nintendo', '2022-10-14 15:58:46', 10, 1, 1, '', 1, 2, '14.56', 'super-mario-bros-3-eu-e107824.jpg', 1),
(24, 'This is Football 2002 Platinum', 'This is Football 2002 Platinum', 'PS2', ' Playstati', '2022-10-14 16:03:29', 45, 1, 1, '', 5, 1, '1.95', 'this-is-football-2002-plat-e178603.jpg', 1),
(25, 'Manette Spider-Man', 'Manette Spider-Man', 'PS2', 'Manette Sp', '2022-10-14 16:06:26', 2, 1, 1, 'Manette Spider-Man', 1, 3, '30.99', 'ps2-manette-spiderman-e160258.jpg', 1),
(26, 'Mario brush', 'ertertert', 'PS5', 'etttet', '2022-10-17 14:16:16', 445, 1, 1, '', 5, 3, '45.23', 'mario_carte.jpg', 1);

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
  `isBlocked` tinyint(1) NOT NULL DEFAULT '0',
  `profilImage` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `cle`, `role`, `isBlocked`, `profilImage`) VALUES
(8, 'rachid', 'rachid', 'rachid.abbou@gmail.com', 'aq116ebc405f841bd16d7cc29e2c83a055196da403325', '66f611432b50f7d3a4dcd540aa7c55c2d67e27271665406270', 'Client', 0, 'profil_1.jpg'),
(10, 'test', 'test', 'test@google.fr', 'aq17288edd0fc3ffcbe93a0cf06e3568e28521687bc25', 'b835fd27b1e7782d1f5346b21d8c226f5e69eeb31665512289', 'Client', 0, 'profil_2.jpg'),
(11, 'vendeur', 'vendeur', 'vendeur@gmail.com', 'aq110d8a5fbb3ea35add960d0602bc5f6b3eb162fc225', '99ae0e2f2511082550a840d24e9a458f4f6844fb1665564464', 'Vendeur', 0, NULL),
(15, 'abbou', 'rachid', 'rachid.abbou@gmail.com', 'aq116ebc405f841bd16d7cc29e2c83a055196da403325', '9a2912bce0ca2cec8f51ab7ed3aacdc9b42425e31665833417', 'Vendeur', 0, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sadmin`
--
ALTER TABLE `sadmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
