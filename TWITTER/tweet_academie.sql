-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 29 juil. 2021 à 14:40
-- Version du serveur :  8.0.26-0ubuntu0.20.04.2
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tweet_academie`

CREATE DATABASE IF NOT EXISTS `tweet_academie` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tweet_academie`;

-- --------------------------------------------------------

--
-- Structure de la table `directmessage`
--


-- Par rapport à latin1_general_cicela, il prend en charge une variété 
-- de caractères supplémentaires utilisés dans les langues européennes.

CREATE TABLE `directmessage` (
  `id_directmessage` int NOT NULL,
  `content` varchar(140) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int NOT NULL,
  `id_dest` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `id_favoris` int NOT NULL,
  `id_tweet` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `follow`
--

CREATE TABLE `follow` (
  `id_follow` int NOT NULL,
  `id_user` int NOT NULL,
  `id_user_follow` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hashtag`
--

CREATE TABLE `hashtag` (
  `id_hashtag` int NOT NULL,
  `name` varchar(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hashtagontweets`
--

CREATE TABLE `hashtagontweets` (
  `id_hashtagontweets` int NOT NULL,
  `id_tweet` int NOT NULL,
  `id_hashtag` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='liste des hastags lié aux tweets';

-- --------------------------------------------------------

--
-- Structure de la table `mention`
--

CREATE TABLE `mention` (
  `id_mention` int NOT NULL,
  `id_tweet` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `reply`
--

CREATE TABLE `reply` (
  `id_reply` int NOT NULL,
  `id_tweet_origin` int NOT NULL,
  `id_tweet_parent` int NOT NULL,
  `id_tweet` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `retweets`
--

CREATE TABLE `retweets` (
  `id_retweet` int NOT NULL,
  `id_tweet` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `signets`
--

CREATE TABLE `signets` (
  `id_signet` int NOT NULL,
  `id_user` int NOT NULL,
  `id_tweet` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `tweet`
--

CREATE TABLE `tweet` (
  `id_tweet` int NOT NULL,
  `content` varchar(140) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int NOT NULL,
  `media_link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `first_name` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `last_name` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `phone` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `birth_date` date NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `picture` varchar(16) DEFAULT NULL,
  `theme` enum('Blue','Red','Orange','Dark','Pink') NOT NULL DEFAULT 'Blue'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
--
-- Index pour la table `directmessage`
--
ALTER TABLE `directmessage`
  ADD PRIMARY KEY (`id_directmessage`);

--
-- Index pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD PRIMARY KEY (`id_favoris`);

--
-- Index pour la table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id_follow`);

--
-- Index pour la table `hashtag`
--
ALTER TABLE `hashtag`
  ADD PRIMARY KEY (`id_hashtag`);

--
-- Index pour la table `hashtagontweets`
--
ALTER TABLE `hashtagontweets`
  ADD PRIMARY KEY (`id_hashtagontweets`);

--
-- Index pour la table `mention`
--
ALTER TABLE `mention`
  ADD PRIMARY KEY (`id_mention`);

--
-- Index pour la table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`id_reply`);

--
-- Index pour la table `retweets`
--
ALTER TABLE `retweets`
  ADD PRIMARY KEY (`id_retweet`);

--
-- Index pour la table `signets`
--
ALTER TABLE `signets`
  ADD PRIMARY KEY (`id_signet`);

--
-- Index pour la table `tweet`
--
ALTER TABLE `tweet`
  ADD PRIMARY KEY (`id_tweet`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `directmessage`
--
ALTER TABLE `directmessage`
  MODIFY `id_directmessage` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `favoris`
--
ALTER TABLE `favoris`
  MODIFY `id_favoris` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `follow`
--
ALTER TABLE `follow`
  MODIFY `id_follow` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `hashtag`
--
ALTER TABLE `hashtag`
  MODIFY `id_hashtag` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `hashtagontweets`
--
ALTER TABLE `hashtagontweets`
  MODIFY `id_hashtagontweets` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mention`
--
ALTER TABLE `mention`
  MODIFY `id_mention` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reply`
--
ALTER TABLE `reply`
  MODIFY `id_reply` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `retweets`
--
ALTER TABLE `retweets`
  MODIFY `id_retweet` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `signets`
--
ALTER TABLE `signets`
  MODIFY `id_signet` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tweet`
--
ALTER TABLE `tweet`
  MODIFY `id_tweet` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;