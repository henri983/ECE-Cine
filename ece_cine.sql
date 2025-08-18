-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 18 août 2025 à 15:58
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
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `id_film` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Les figures de l’ombre', 'Theodore Melfi', '2016', 'Biographie, Drame, Historique', 'Trois scientifiques afro-américaines de la NASA ont joué un rôle crucial dans la conquête spatiale américaine.', 'https://pixeladventurers.com/wp-content/uploads/2017/12/les_figures_de_l_ombre_aff-2-696x1010.jpg', NULL, '2025-08-07 12:03:36', 1),
(2, 'Une merveilleuse histoire du temps', 'James Marsh', '2014', 'Biographie, Drame, Romance', 'La vie et les travaux du physicien Stephen Hawking, de ses débuts à Cambridge à ses découvertes majeures.', 'https://image.tmdb.org/t/p/original/2yWJE3dAWcVeHg7OJ3ZgbFuYCOG.jpg', NULL, '2025-08-07 12:03:36', 1),
(3, 'A Beautiful Mind', 'Ron Howard', '2001', 'Biographie, Drame', 'L’histoire du mathématicien John Nash et sa lutte contre la schizophrénie tout en poursuivant ses recherches.', 'https://upload.wikimedia.org/wikipedia/en/b/b8/A_Beautiful_Mind_Poster.jpg', NULL, '2025-08-07 12:03:36', 1),
(4, 'Le Cercle des poètes disparus', 'Peter Weir', '1989', 'Drame', 'Un professeur de littérature inspire ses élèves à penser par eux-mêmes et à vivre pleinement.', 'https://www.ecranlarge.com/content/uploads/2019/11/mnhthfspwkffe98zggchx6oqqe3-488.jpg', NULL, '2025-08-07 12:03:36', 1),
(5, 'Interstellar', 'Christopher Nolan', '2014', 'Science-fiction, Drame', 'Un groupe de scientifiques explore une faille spatio-temporelle pour sauver l’humanité.', 'https://thumbnails.cbsig.net/CBS_Production_Entertainment_VMS/2021/07/09/1919558723588/INST_SAlone_16_9_1920x1080_1887272_1920x1080.jpg', NULL, '2025-08-07 12:03:36', 1),
(6, 'The Social Network', 'David Fincher', '2010', 'Biographique, Drame', 'La naissance de Facebook et les conflits entre Mark Zuckerberg et ses associés.', 'https://image.airtel.tv/SONYLIV_VOD/SONYLIV_VOD_MOVIE_1000042081/FEATURE_BANNER/the_social_network_Landscape_Thumb.jpg', NULL, '2025-08-07 23:53:32', 1),
(7, 'Her', 'Spike Jonze', '2013', 'Science-fiction, Romance', 'Un homme tombe amoureux d\'une intelligence artificielle.', 'https://tse1.explicit.bing.net/th/id/OIP.zXzCyFUSZBiGTOl0EdVRwAHaEK?rs=1&pid=ImgDetMain&o=7&rm=3', NULL, '2025-08-07 23:53:32', 1),
(8, 'Blade Runner 2049', 'Denis Villeneuve', '2017', 'Science-fiction, Action', 'Un \"blade runner\" découvre un secret enfoui qui pourrait bouleverser la société.', 'https://image.tmdb.org/t/p/original/4P6t1SVAy90q5kY88xIQ08RvZ1U.jpg', NULL, '2025-08-07 23:53:32', 1),
(9, 'Ex Machina', 'Alex Garland', '2014', 'Science-fiction, Thriller', 'Un programmeur est invité à évaluer une intelligence artificielle humanoïde.', 'https://tse3.mm.bing.net/th/id/OIP.8R6_zxnclZJLgAh2NsOkiQHaLH?rs=1&pid=ImgDetMain&o=7&rm=3', NULL, '2025-08-07 23:53:32', 1),
(10, 'Minority Report', 'Steven Spielberg', '2002', 'Science-fiction, Action', 'Dans le futur, la police arrête les criminels avant qu\'ils ne commettent leurs crimes, mais un agent est lui-même accusé.', 'https://www.themoviedb.org/t/p/original/ccqpHq5tk5W4ymbSbuoy4uYOxFI.jpg', NULL, '2025-08-07 23:53:32', 1),
(11, 'Lady Bird', 'Greta Gerwig', '2017', 'Comédie dramatique', 'Le passage à l\'âge adulte d\'une lycéenne et sa relation conflictuelle avec sa mère.', 'https://flxt.tmsimg.com/assets/p14426291_v_h8_be.jpg', NULL, '2025-08-07 23:53:32', 1),
(13, 'Boyhood', 'Richard Linklater', '2014', 'Drame', 'L\'histoire d\'une famille sur douze ans, filmée avec les mêmes acteurs.', 'https://thefilmstage.com/wp-content/uploads/2014/04/boyhood.jpg', NULL, '2025-08-07 23:53:32', 1),
(14, 'Juno', 'Jason Reitman', '2007', 'Comédie dramatique', 'Une adolescente se retrouve enceinte et doit faire face aux conséquences.', 'https://image.tmdb.org/t/p/original/eiu1Rj79675HQGUw2Tp6wsMfTOq.jpg', NULL, '2025-08-07 23:53:32', 1),
(15, 'The Breakfast Club', 'John Hughes', '1985', 'Comédie dramatique', 'Cinq lycéens aux personnalités très différentes se retrouvent en retenue.', 'https://alchetron.com/cdn/The-Breakfast-Club-images-fdce0f05-4593-472a-8387-533941b3e07.jpg', NULL, '2025-08-07 23:53:32', 1),
(16, 'La Ligne Verte', 'Frank Darabont', '1999', 'Drame, Fantastique', 'Un gardien de prison découvre que l\'un de ses prisonniers possède un don miraculeux.', 'https://th.bing.com/th/id/R.ffb06c591a0a78fe3fa046a9e60fae40?rik=%2bzOPH5N0dl8J3A&riu=http%3a%2f%2fwww.letribunaldunet.fr%2fwp-content%2fuploads%2f2019%2f07%2fligneverte.jpg&ehk=ZwL3BAJNRnV2lKDDTUVhGIVsG7V%2fJkN5YkxOzPcrjbM%3d&risl=&pid=ImgRaw&r=0', NULL, '2025-08-07 23:53:32', 1),
(17, 'Parasite', 'Bong Joon-ho', '2019', 'Thriller, Comédie noire', 'Une famille pauvre s\'infiltre dans la vie d\'une famille riche.', 'https://mamasgeeky.com/wp-content/uploads/2020/02/parasite-movie-poster.jpeg', NULL, '2025-08-07 23:53:32', 1),
(18, 'Douze Hommes en Colère', 'Sidney Lumet', '1957', 'Drame judiciaire', 'Un juré essaie de convaincre ses onze collègues de réexaminer les faits d\'un procès.', 'https://images.justwatch.com/poster/237926915/s718/12-hommes-en-colere.%7Bformat%7D', NULL, '2025-08-07 23:53:32', 1),
(19, 'Joker', 'Todd Phillips', '2019', 'Thriller, Drame', 'Un humoriste raté bascule dans la folie et le crime à Gotham City.', 'https://th.bing.com/th/id/R.859ec2caa7c8dc09ff5864af0a3708f5?rik=eDbqCqBGl5i%2fsg&pid=ImgRaw&r=0', NULL, '2025-08-07 23:53:32', 1),
(20, 'Gone Girl', 'David Fincher', '2014', 'Thriller', 'Un homme devient le suspect principal de la disparition de sa femme.', 'https://th.bing.com/th/id/R.15b1630b1ba1d9e072e2496a97d85b5d?rik=2X143z449sDb7w&riu=http%3a%2f%2fwww.stevenvanlijnden.com%2fwp-content%2fuploads%2f2015%2f12%2fGone-Girl-Poster.jpg&ehk=1tz8qO%2bvawhc%2fmEGzABgfBiBW6Jjx7CguVu%2fV8%2bbYaE%3d&risl=&pid=ImgRaw', NULL, '2025-08-07 23:53:32', 1),
(21, 'Ready Player One', 'Steven Spielberg', '2018', 'Science-fiction, Action', 'Un adolescent navigue dans un monde virtuel pour trouver un \"œuf de Pâques\" caché.', 'https://th.bing.com/th/id/R.7ae3e2b460582b4839e5051991bf17a1?rik=9WnJyuBDQuUZaQ&pid=ImgRaw&r=0', NULL, '2025-08-07 23:53:32', 1),
(22, 'Fight Club', 'David Fincher', '1999', 'Thriller, Drame', 'Un homme désabusé forme un club de combat secret avec un inconnu charismatique.', 'https://www.themoviedb.org/t/p/original/jSziioSwPVrOy9Yow3XhWIBDjq1.jpg', NULL, '2025-08-07 23:53:32', 1),
(23, 'The Truman Show', 'Peter Weir', '1998', 'Comédie dramatique', 'La vie d\'un homme est filmée en permanence pour une émission de télévision.', 'https://postertok.com/wp-content/uploads/2024/02/5337.webp', NULL, '2025-08-07 23:53:32', 1),
(24, 'À Vif ! (Burnt)', 'John Wells', '2015', 'Drame', 'Un ancien chef de restaurant tente de relancer sa carrière à Londres.', 'https://www.daily-movies.ch/wp-content/uploads/2016/05/daily-movies.ch_a_vif_burnt-9-198x250.jpg', NULL, '2025-08-07 23:53:32', 1);

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
(3, 1, 3, '2025-08-07 23:37:35'),
(4, 2, 14, '2025-08-12 01:14:36');

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
(1, 'ECE CINE ADMIN', '', 'ececine@admin.fr', '$2y$10$TxKE1hyGGVKqjIKO5fPexOLo23jd8RJ0cJbTtlvx1pk9A3DBKSTUu', 'administrateur', '2025-08-05 18:18:44', 1, NULL, '', NULL, '+33712344455', 'default.jpg'),
(2, 'etudiant', 'Lea', 'ececine@etudiant.fr', '$2y$10$D4SQpBefe0ICzTYwFzfWjeclKnOw4d6uC277oX6AiSCrXjpXvaGLK', 'etudiant', '2025-08-05 19:06:56', 1, '2_photo_1754954052.jpg', 'Ali', '5 Rue du centre 99487 Paris', NULL, 'default.jpg'),
(3, 'test', '', 'test@etudiant.fr', '$2y$10$QCBzCoKA/jDKtJtBehNx3eGP9TtqLomdj1ASeWKIhkUzQoku/sO/6', 'etudiant', '2025-08-06 05:11:16', 1, NULL, NULL, NULL, NULL, 'default.jpg'),
(5, 'admin', '', 'admin@admin.fr', '$2y$10$7TT5zVnwc5YEyrOne1MO6O97JvYlvO2js6Kd5ln16hcocd3oy9I4W', 'administrateur', '2025-08-11 18:33:20', 1, NULL, NULL, NULL, NULL, 'default.jpg'),
(6, 'ececine enseignant', '', 'ececine@enseignant.fr', '$2y$10$IcH/.GEv.qTaKxx07mwN.OG5uiYAnrDxGa.iQlFKRw6QBWvBkbpgy', 'enseignant', '2025-08-17 12:52:24', 1, NULL, NULL, NULL, NULL, 'default.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_film` (`id_film`),
  ADD KEY `id_users` (`id_users`);

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
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `film`
--
ALTER TABLE `film`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
