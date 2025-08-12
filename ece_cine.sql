-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 12 août 2025 à 01:09
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ece_cine`
--

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

CREATE TABLE `film` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `realisateur` varchar(255) DEFAULT NULL,
  `annee_sortie` year(4) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `synopsis` text DEFAULT NULL,
  `url_affiche` varchar(255) DEFAULT NULL,
  `trailer` varchar(255) DEFAULT NULL,
  `date_ajout` datetime DEFAULT current_timestamp(),
  `id_users` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `film`
--

INSERT INTO `film` (`id`, `titre`, `realisateur`, `annee_sortie`, `genre`, `synopsis`, `url_affiche`, `trailer`, `date_ajout`, `id_users`) VALUES
(1, 'Les figures de l’ombre', 'Theodore Melfi', '2016', 'Biographie, Drame, Historique', 'Trois scientifiques afro-américaines de la NASA ont joué un rôle crucial dans la conquête spatiale américaine.', 'https://upload.wikimedia.org/wikipedia/en/4/4f/Hidden_Figures_poster.png', NULL, '2025-08-07 12:03:36', 1),
(2, 'Une merveilleuse histoire du temps', 'James Marsh', '2014', 'Biographie, Drame, Romance', 'La vie et les travaux du physicien Stephen Hawking, de ses débuts à Cambridge à ses découvertes majeures.', 'https://upload.wikimedia.org/wikipedia/en/b/b8/The_Theory_of_Everything_%28film%29_poster.jpg', NULL, '2025-08-07 12:03:36', 1),
(3, 'A Beautiful Mind', 'Ron Howard', '2001', 'Biographie, Drame', 'L’histoire du mathématicien John Nash et sa lutte contre la schizophrénie tout en poursuivant ses recherches.', 'https://upload.wikimedia.org/wikipedia/en/b/b8/A_Beautiful_Mind_Poster.jpg', NULL, '2025-08-07 12:03:36', 1),
(4, 'Le Cercle des poètes disparus', 'Peter Weir', '1989', 'Drame', 'Un professeur de littérature inspire ses élèves à penser par eux-mêmes et à vivre pleinement.', 'https://upload.wikimedia.org/wikipedia/en/4/49/Dead_Poets_Society.jpg', NULL, '2025-08-07 12:03:36', 1),
(5, 'Interstellar', 'Christopher Nolan', '2014', 'Science-fiction, Drame', 'Un groupe de scientifiques explore une faille spatio-temporelle pour sauver l’humanité.', 'https://upload.wikimedia.org/wikipedia/en/b/bc/Interstellar_film_poster.jpg', NULL, '2025-08-07 12:03:36', 1),
(6, 'The Social Network', 'David Fincher', '2010', 'Biographique, Drame', 'La naissance de Facebook et les conflits entre Mark Zuckerberg et ses associés.', 'url_de_votre_affiche_1.jpg', NULL, '2025-08-07 23:53:32', 1),
(7, 'Her', 'Spike Jonze', '2013', 'Science-fiction, Romance', 'Un homme tombe amoureux d\'une intelligence artificielle.', 'url_de_votre_affiche_2.jpg', NULL, '2025-08-07 23:53:32', 1),
(8, 'Blade Runner 2049', 'Denis Villeneuve', '2017', 'Science-fiction, Action', 'Un \"blade runner\" découvre un secret enfoui qui pourrait bouleverser la société.', 'url_de_votre_affiche_3.jpg', NULL, '2025-08-07 23:53:32', 1),
(9, 'Ex Machina', 'Alex Garland', '2014', 'Science-fiction, Thriller', 'Un programmeur est invité à évaluer une intelligence artificielle humanoïde.', 'url_de_votre_affiche_4.jpg', NULL, '2025-08-07 23:53:32', 1),
(10, 'Minority Report', 'Steven Spielberg', '2002', 'Science-fiction, Action', 'Dans le futur, la police arrête les criminels avant qu\'ils ne commettent leurs crimes, mais un agent est lui-même accusé.', 'url_de_votre_affiche_5.jpg', NULL, '2025-08-07 23:53:32', 1),
(11, 'Lady Bird', 'Greta Gerwig', '2017', 'Comédie dramatique', 'Le passage à l\'âge adulte d\'une lycéenne et sa relation conflictuelle avec sa mère.', 'url_de_votre_affiche_6.jpg', NULL, '2025-08-07 23:53:32', 1),
(12, 'Le Cercle des Poètes Disparus', 'Peter Weir', '1989', 'Drame', 'Un professeur de lettres anticonformiste inspire ses élèves à penser par eux-mêmes.', 'url_de_votre_affiche_7.jpg', NULL, '2025-08-07 23:53:32', 1),
(13, 'Boyhood', 'Richard Linklater', '2014', 'Drame', 'L\'histoire d\'une famille sur douze ans, filmée avec les mêmes acteurs.', 'url_de_votre_affiche_8.jpg', NULL, '2025-08-07 23:53:32', 1),
(14, 'Juno', 'Jason Reitman', '2007', 'Comédie dramatique', 'Une adolescente se retrouve enceinte et doit faire face aux conséquences.', 'url_de_votre_affiche_9.jpg', NULL, '2025-08-07 23:53:32', 1),
(15, 'The Breakfast Club', 'John Hughes', '1985', 'Comédie dramatique', 'Cinq lycéens aux personnalités très différentes se retrouvent en retenue.', 'url_de_votre_affiche_10.jpg', NULL, '2025-08-07 23:53:32', 1),
(16, 'La Ligne Verte', 'Frank Darabont', '1999', 'Drame, Fantastique', 'Un gardien de prison découvre que l\'un de ses prisonniers possède un don miraculeux.', 'url_de_votre_affiche_11.jpg', NULL, '2025-08-07 23:53:32', 1),
(17, 'Parasite', 'Bong Joon-ho', '2019', 'Thriller, Comédie noire', 'Une famille pauvre s\'infiltre dans la vie d\'une famille riche.', 'url_de_votre_affiche_12.jpg', NULL, '2025-08-07 23:53:32', 1),
(18, 'Douze Hommes en Colère', 'Sidney Lumet', '1957', 'Drame judiciaire', 'Un juré essaie de convaincre ses onze collègues de réexaminer les faits d\'un procès.', 'url_de_votre_affiche_13.jpg', NULL, '2025-08-07 23:53:32', 1),
(19, 'Joker', 'Todd Phillips', '2019', 'Thriller, Drame', 'Un humoriste raté bascule dans la folie et le crime à Gotham City.', 'url_de_votre_affiche_14.jpg', NULL, '2025-08-07 23:53:32', 1),
(20, 'Gone Girl', 'David Fincher', '2014', 'Thriller', 'Un homme devient le suspect principal de la disparition de sa femme.', 'url_de_votre_affiche_15.jpg', NULL, '2025-08-07 23:53:32', 1),
(21, 'Ready Player One', 'Steven Spielberg', '2018', 'Science-fiction, Action', 'Un adolescent navigue dans un monde virtuel pour trouver un \"œuf de Pâques\" caché.', 'url_de_votre_affiche_16.jpg', NULL, '2025-08-07 23:53:32', 1),
(22, 'Fight Club', 'David Fincher', '1999', 'Thriller, Drame', 'Un homme désabusé forme un club de combat secret avec un inconnu charismatique.', 'url_de_votre_affiche_18.jpg', NULL, '2025-08-07 23:53:32', 1),
(23, 'The Truman Show', 'Peter Weir', '1998', 'Comédie dramatique', 'La vie d\'un homme est filmée en permanence pour une émission de télévision.', 'url_de_votre_affiche_19.jpg', NULL, '2025-08-07 23:53:32', 1),
(24, 'À Vif ! (Burnt)', 'John Wells', '2015', 'Drame', 'Un ancien chef de restaurant tente de relancer sa carrière à Londres.', 'url_de_votre_affiche_20.jpg', NULL, '2025-08-07 23:53:32', 1);

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_film` int(11) NOT NULL,
  `date_like` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `id_users`, `id_film`, `date_like`) VALUES
(1, 1, 4, '2025-08-07 23:37:29'),
(2, 1, 5, '2025-08-07 23:37:32'),
(3, 1, 3, '2025-08-07 23:37:35');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `message` text NOT NULL,
  `est_lu` tinyint(1) DEFAULT 0,
  `date_notification` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('etudiant','enseignant','administrateur') DEFAULT 'etudiant',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approuve` tinyint(1) DEFAULT 1,
  `photo` varchar(255) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `fond_ecran` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `nom`, `email`, `password_hash`, `role`, `created_at`, `approuve`, `photo`, `prenom`, `adresse`, `telephone`, `fond_ecran`) VALUES
(1, 'ECE CINE ADMIN', '', 'ececine@admin.fr', '$2y$10$TxKE1hyGGVKqjIKO5fPexOLo23jd8RJ0cJbTtlvx1pk9A3DBKSTUu', 'administrateur', '2025-08-05 20:18:44', 1, NULL, '', NULL, '+33712344455', 'default.jpg'),
(2, 'etudiant', 'Lea', 'ececine@etudiant.fr', '$2y$10$D4SQpBefe0ICzTYwFzfWjeclKnOw4d6uC277oX6AiSCrXjpXvaGLK', 'etudiant', '2025-08-05 21:06:56', 1, NULL, 'Ali', '5 Rue du centre 99487 Paris', NULL, 'default.jpg'),
(3, 'test', '', 'test@etudiant.fr', '$2y$10$QCBzCoKA/jDKtJtBehNx3eGP9TtqLomdj1ASeWKIhkUzQoku/sO/6', 'etudiant', '2025-08-06 07:11:16', 1, NULL, NULL, NULL, NULL, 'default.jpg'),
(5, 'admin', '', 'admin@admin.fr', '$2y$10$7TT5zVnwc5YEyrOne1MO6O97JvYlvO2js6Kd5ln16hcocd3oy9I4W', 'administrateur', '2025-08-11 20:33:20', 1, NULL, NULL, NULL, NULL, 'default.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_users` (`id_users`,`id_film`),
  ADD KEY `id_film` (`id_film`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `film`
--
ALTER TABLE `film`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `film_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `film` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
