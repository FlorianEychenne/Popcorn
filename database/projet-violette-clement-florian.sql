-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 19 jan. 2022 à 12:48
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet-violette-clement-florian`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `review_id` int(11) DEFAULT NULL,
  `published_at` datetime NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `review_id`, `published_at`, `content`, `post_id`) VALUES
(28, 12, 15, '2022-01-19 11:25:01', 'Je viens de revenir de la séance ! Tu as bien raison !', 5),
(29, 12, 9, '2022-01-19 11:29:22', 'Un peu déçu du scenario en voyant ce casting 5 étoiles !', 17),
(30, 13, 9, '2022-01-19 11:32:10', 'Un régale ce film !', 17),
(31, 13, 14, '2022-01-19 11:32:51', 'Après réflexion, il n\'est pas si mal ...', 14),
(32, 13, 18, '2022-01-19 11:37:09', 'Plutôt d\'accord ce n\'est vraiment pas mon style ...', 11),
(33, 13, 19, '2022-01-19 11:38:00', 'G Del Toro est tellement fort !', 5),
(34, 13, 11, '2022-01-19 11:39:29', 'Une découverte totale de l\'importance du Lynx ! Convaincu', 16),
(35, 13, 15, '2022-01-19 11:41:09', 'Excellent film ! Je le recommande à tout le monde', 5),
(36, 15, 15, '2022-01-19 11:42:44', 'The Shape of Water était bien meilleur pour moi, mais c\'était tout de même un bon moment.', 5),
(37, 11, 20, '2022-01-19 11:55:26', 'Je ne vois pas comment tu peux dire ça si tu as vu le film Ben', 5),
(38, 11, 19, '2022-01-19 11:58:17', 'Il est excellent dans tout ses choix !', 5),
(39, 13, 21, '2022-01-19 12:01:10', 'Ils sortent bientôt ! J\'ai hâte', 2),
(40, 18, 21, '2022-01-19 12:10:41', 'Le respect de l\'œuvre m\'a conquis !', 2),
(41, 18, 20, '2022-01-19 12:11:14', 'Ben, sérieusement ...', 5),
(42, 18, 15, '2022-01-19 12:11:56', 'Une œuvre grandiose !', 5);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220111155247', '2022-01-11 16:52:58', 560),
('DoctrineMigrations\\Version20220111155646', '2022-01-11 16:56:54', 54),
('DoctrineMigrations\\Version20220111155833', '2022-01-11 16:58:38', 51),
('DoctrineMigrations\\Version20220112091023', '2022-01-12 10:10:30', 170),
('DoctrineMigrations\\Version20220112124843', '2022-01-12 13:48:49', 127);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `synopsis` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_at` datetime NOT NULL,
  `released_at` datetime NOT NULL,
  `categories` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `director` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actors` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `user_id`, `title`, `image`, `video`, `synopsis`, `published_at`, `released_at`, `categories`, `director`, `actors`) VALUES
(2, 5, 'Dune', 'dune.jpeg', 'https://www.youtube.com/embed/CjVqieIWGjM', 'L\'histoire de Paul Atreides, jeune homme aussi doué que brillant, voué à connaître un destin hors du commun qui le dépasse totalement. Car s\'il veut préserver l\'avenir de sa famille et de son peuple, il devra se rendre sur la planète la plus dangereuse de l\'univers – la seule à même de fournir la ressource la plus précieuse au monde, capable de décupler la puissance de l\'humanité. Tandis que des forces maléfiques se disputent le contrôle de cette planète, seuls ceux qui parviennent à dominer leur peur pourront survivre…', '2022-01-16 23:32:42', '2021-09-15 00:00:00', 'a:2:{i:0;s:2:\"SF\";i:1;s:8:\"Aventure\";}', 'Denis Villeneuve', 'Timothée Chalamet Rebecca Ferguson Oscar Isaac'),
(3, 1, 'Joker', '4765874.jpeg', 'https://www.youtube.com/embed/7CWqC3j7Y14', 'Le film, qui relate une histoire originale inédite sur grand écran, se focalise sur la figure emblématique de l’ennemi juré de Batman. Il brosse le portrait d’Arthur Fleck, un homme sans concession méprisé par la société.', '2022-01-11 17:15:44', '2019-10-09 00:00:00', 'a:2:{i:0;s:8:\"Thriller\";i:1;s:5:\"Drame\";}', 'Todd Phillips', 'Joaquin Phoenix Robert De Niro Zazie Beetz'),
(4, 5, 'Don\'t look up', 'Movie-Dont-Look-Up-2021-–-Hollywood-Movie.jpeg', 'https://www.youtube.com/embed/wplebVZB8FQ', 'Deux piètres astronomes s\'embarquent dans une gigantesque tournée médiatique pour prévenir l\'humanité qu\'une comète se dirige vers la Terre et s\'apprête à la détruire.', '2022-01-17 10:29:44', '2021-12-24 00:00:00', 'a:2:{i:0;s:8:\"Comédie\";i:1;s:5:\"Drame\";}', 'Adam McKay', 'Leonardo DiCaprio Jennifer Lawrence Meryl Streep'),
(5, 5, 'Nightmare Alley', '5664268.jpeg', 'https://www.youtube.com/embed/0nFVCTzeY64', 'Alors qu’il traverse une mauvaise passe, le charismatique Stanton Carlisle débarque dans une foire itinérante et parvient à s’attirer les bonnes grâces d’une voyante, Zeena et de son mari Pete, une ancienne gloire du mentalisme. S’initiant auprès d’eux, il voit là un moyen de décrocher son ticket pour le succès et décide d’utiliser ses nouveaux talents pour arnaquer l’élite de la bonne société new-yorkaise des années 40. Avec la vertueuse et fidèle Molly à ses côtés, Stanton se met à échafauder un plan pour escroquer un homme aussi puissant que dangereux. Il va recevoir l’aide d’une mystérieuse psychiatre qui pourrait bien se révéler la plus redoutable de ses adversaires…', '2022-01-19 09:52:11', '2022-01-19 00:00:00', 'a:2:{i:0;s:8:\"Thriller\";i:1;s:5:\"Drame\";}', 'Guillermo del Tora', 'Bradley Cooper, Cate Blanchett, Toni Collette'),
(6, 5, 'La panthère', 'lapantheredesneiges.jpg', 'https://www.youtube.com/embed/g3wepiH_hjY', 'Au cœur des hauts plateaux tibétains, le photographe Vincent Munier entraîne l’écrivain Sylvain Tesson dans sa quête de la panthère des neiges. Il l’initie à l’art délicat de l’affût, à la lecture des traces et à la patience nécessaire pour entrevoir les bêtes. En parcourant les sommets habités par des présences invisibles, les deux hommes tissent un dialogue sur notre place parmi les êtres vivants et célèbrent la beauté du monde.', '2022-01-18 22:49:10', '2021-12-15 00:00:00', 'a:2:{i:0;s:8:\"Aventure\";i:1;s:12:\"Documentaire\";}', 'Marie Amiguet', 'Sylvain Tesson, Vincent Munier'),
(7, 5, 'Jane par Charlotte', 'janeparcharlotte.jpg', 'https://www.youtube.com/embed/AzjCRsl1TQo', 'Charlotte Gainsbourg a commencé à filmer sa mère, Jane Birkin, pour la regarder comme elle ne l’avait jamais fait. La pudeur de l’une face à l’autre n’avait jamais permis un tel rapprochement. Mais par l’entremise de la caméra, la glace se brise pour faire émerger un échange inédit, sur plusieurs années, qui efface peu à peu les deux artistes et les met à nu dans une conversation intime inédite et universelle pour laisser apparaître une mère face à une fille. Jane par Charlotte.', '2022-01-17 22:54:06', '1999-01-12 00:00:00', 'a:2:{i:0;s:7:\"Romance\";i:1;s:12:\"Documentaire\";}', 'Charlotte Gainsbourg', 'Jane Birkin, Charlotte Gainsbourg'),
(8, 5, 'Animaux fantastiques', 'animauxfantastiques.jpg', 'https://www.youtube.com/embed/jC8xuFcMq20', 'New York, 1926. Le monde des sorciers est en grand danger. Une force mystérieuse sème le chaos dans les rues de la ville : la communauté des sorciers risque désormais d\'être à la merci des Fidèles de Salem, groupuscule fanatique des Non-Maj’ (version américaine du \"Moldu\") déterminé à les anéantir. Quant au redoutable sorcier Gellert Grindelwald, après avoir fait des ravages en Europe, il a disparu… et demeure introuvable.\r\nIgnorant tout de ce conflit qui couve, Norbert Dragonneau débarque à New York au terme d\'un périple à travers le monde : il a répertorié un bestiaire extraordinaire de créatures fantastiques dont certaines sont dissimulées dans les recoins magiques de sa sacoche en cuir – en apparence – banale.', '2022-01-10 23:04:05', '2016-08-16 00:00:00', 'a:2:{i:0;s:8:\"Aventure\";i:1;s:11:\"Fantastique\";}', 'J.K. Rowling', 'Eddie Redmayne, Katherine Waterston, Dan Fogler'),
(10, 5, 'En Avant', 'enavant.jpg', 'https://www.youtube.com/embed/XRF6uuubGcI', 'Ian et Barley Lightfoot ont perdu leur père très tôt. Ils habitent une ville de banlieue peuplée de créatures fantastiques (elfes, trolls, lutins ou encore licornes), mais dont la magie ancestrale a peu à peu disparu. Les deux jeunes frères partent à sa recherche à bord de leur camionnette Guinevere, dans l\'espoir de passer un dernier jour avec leur père', '2022-01-10 23:19:29', '2020-03-04 00:00:00', 'a:2:{i:0;s:9:\"Animation\";i:1;s:11:\"Fantastique\";}', 'Dan Scanlon', 'Thomas Solivérès, Pio Marmaï, Tom Holland'),
(11, 17, 'Last Night', 'lastnight.jpg', 'https://www.youtube.com/embed/AcVnFrxjPjI', 'L’histoire d’une jeune femme passionnée de mode et de design qui parvient mystérieusement à retourner dans les années 60 où elle rencontre son idole, une éblouissante jeune star montante. Mais le Londres des années 60 n’est pas ce qu’il parait, et le temps semble se désagréger entrainant de sombres répercussions.', '2022-01-19 12:35:46', '2021-08-27 00:00:00', 'a:2:{i:0;s:8:\"Thriller\";i:1;s:7:\"Horreur\";}', 'Edgar Wright', 'Krysty Wilson-Cairns, Edgar Wright'),
(12, 5, 'Matrix', 'matrix.jpg', 'https://www.youtube.com/embed/hI-zQlDdQIs', 'Dix-huit ans après que Neo ait aidé les machines dominant les hommes à détruire l\'Agent Smith, la saga Matrix reprend. Après Matrix Reloaded et Matrix Resurrections, Keanu Reeves et Carrie-Anne Moss (alias Trinity) sont de retour dans ce blockbuster de science-fiction réalisé par Lana Wachowski. A nouveau, réalité et monde virtuel se mélangent et mènent les héros vers des scènes d\'action et des révélations. Avec aussi Yahya Abdul-Mateen III (Candyman, ou Aquaman, dans lequel il incarne Black Manta), Neil Patrick Harris (How I met your mother, Gone girl) ou Jada Pinkett Smith, de retour en Niobe. Une suite bien accueillie globalement par les critiques.', '2022-01-17 23:29:57', '2021-12-22 00:00:00', 'a:2:{i:0;s:2:\"SF\";i:1;s:6:\"Action\";}', 'Lana Wachowsky', 'Keanu Reeves, Carrie-Anne'),
(13, 5, 'Inception', 'inception.jpg', 'https://www.youtube.com/embed/CPTIgILtna8', 'Dom Cobb est un voleur expérimenté – le meilleur qui soit dans l’art périlleux de l’extraction : sa spécialité consiste à s’approprier les secrets les plus précieux d’un individu, enfouis au plus profond de son subconscient, pendant qu’il rêve et que son esprit est particulièrement vulnérable. Très recherché pour ses talents dans l’univers trouble de l’espionnage industriel, Cobb est aussi devenu un fugitif traqué dans le monde entier qui a perdu tout ce qui lui est cher. Mais une ultime mission pourrait lui permettre de retrouver sa vie d’avant – à condition qu’il puisse accomplir l’impossible : l’inception.', '2022-01-06 23:37:27', '2020-09-12 00:00:00', 'a:2:{i:0;s:2:\"SF\";i:1;s:7:\"Horreur\";}', 'Christopher Nolan', 'Leonardo DiCaprio, Marion Cotillard, Elliot Page'),
(14, 5, 'Soul', 'soul.jpg', 'https://www.youtube.com/embed/3IZkCUGGhgY', 'Passionné de jazz et professeur de musique dans un collège, Joe Gardner a enfin l’opportunité de réaliser son rêve : jouer dans le meilleur club de jazz de New York. Mais un malencontreux faux pas le précipite dans le « Grand Avant » – un endroit fantastique où les nouvelles âmes acquièrent leur personnalité, leur caractère et leur spécificité avant d’être envoyées sur Terre.', '2022-01-17 23:40:57', '2020-12-25 00:00:00', 'a:2:{i:0;s:8:\"Comédie\";i:1;s:9:\"Animation\";}', 'Pete Docter', 'Kemp Powers'),
(15, 5, 'Demon Slayer', 'demonslayer.jpg', 'https://www.youtube.com/embed/ph5ra_LwmEs', 'Le groupe de Tanjirô a terminé son entraînement de récupération au domaine des papillons et embarque à présent en vue de sa prochaine mission à bord du train de l\'infini, d\'où quarante personnes ont disparu en peu de temps. Tanjirô et Nezuko, accompagnés de Zen\'itsu et Inosuke, s\'allient à l\'un des plus puissants épéistes de l\'armée des pourfendeurs de démons, le Pilier de la Flamme Kyôjurô Rengoku, afin de contrer le démon qui a engagé le train de l\'Infini sur une voie funeste.', '2022-01-17 23:45:09', '2021-05-19 00:00:00', 'a:2:{i:0;s:9:\"Animation\";i:1;s:6:\"Action\";}', 'Haruo Sotozaki', 'Enzo Ratsito, Christophe Lemoine, Maxime Baudoin'),
(16, 5, 'Lynx', 'lynx.jpg', 'https://www.youtube.com/embed/IMys_CPeR4s', 'Au cœur du massif jurassien, un appel étrange résonne à la fin de l\'hiver. La superbe silhouette d\'un lynx boréal se faufile parmi les hêtres et les sapins. Il appelle sa femelle. En suivant la vie de ce couple et de ses chatons, nous découvrons un univers qui nous est proche et pourtant méconnu... Une histoire authentique dont chamois, aigles, renards et hermines sont les témoins de la vie secrète du plus grand félin d\'Europe qui reste menacé... Un film pour découvrir le rôle essentiel que ce discret prédateur occupe dans nos forêts, l\'équilibre qu\'il a rétabli dans un milieu fragile mais aussi les difficultés qu\'il rencontre dans un paysage largement occupé par les humains.', '2022-01-16 23:48:44', '2022-01-19 00:00:00', 'a:2:{i:0;s:7:\"Romance\";i:1;s:12:\"Documentaire\";}', 'Laurent Geslin', 'Laurence Buchmann'),
(17, 5, 'Spider-Man', 'spiderman.jpg', 'https://www.youtube.com/embed/7w_w10HVa54', 'Après Spider-Man : Homecoming et Spider-Man : Far from Home, et ses aventures aux côtés des Avengers dans Avengers : Infinity War et Avengers : Endgame, Peter Parker revient pour sa troisième aventure solo. Et il devrait découvrir le multivers, déjà teasé dans WandaVision et Loki. Spider-Man, incarné par Tom Holland, va donc croiser quelques visages bien connus : Electro (Jamie Foxx de The Amazing Spider-Man : Le Destin d\'un héros), Doctor Octopus (Alfred Molina de Spider-Man 2), et surtout Tobey Maguire et Andrew Garfield, les précédentes versions du super-héros Marvel.', '2022-01-16 00:12:43', '2021-12-15 00:00:00', 'a:2:{i:0;s:6:\"Action\";i:1;s:11:\"Fantastique\";}', 'Jon Watts', 'Tom Holland, Zendaya, Benedict Cumberbatch');

-- --------------------------------------------------------

--
-- Structure de la table `post_user`
--

CREATE TABLE `post_user` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `post_user`
--

INSERT INTO `post_user` (`post_id`, `user_id`) VALUES
(2, 1),
(2, 5),
(2, 13),
(3, 1),
(3, 5),
(3, 13),
(4, 1),
(4, 11),
(4, 13),
(5, 1),
(5, 5),
(5, 11),
(5, 13),
(5, 18),
(8, 11),
(10, 12),
(11, 11),
(11, 13),
(13, 5),
(14, 13),
(14, 15),
(15, 11),
(16, 5),
(16, 12),
(17, 5),
(17, 11);

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` int(11) NOT NULL,
  `published_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `post_id`, `title`, `content`, `note`, `published_at`) VALUES
(7, 11, 4, 'Excellent film !', 'C\'est film est une pépite, je ne m\'y attendais pas. Que des acteurs de génies. Tellement de clins d\'œil à la réalité du monde actuel.', 5, '2022-01-18 16:39:58'),
(8, 13, 3, 'Recommandation totale !', 'Si vous allez voir ce film en espérant voir un film d\'action, vous serez probablement déçu, comme le furent une toute petite minorité dans la salle. Si vous avez compris ce que vous venez voir, alors vous visionnerez probablement le chef d\'œuvre auquel vous pensiez assister.', 5, '2022-01-18 16:54:45'),
(9, 11, 17, 'Hommage réussi !', 'Je me fiche de ce que les gens en diront, c\'est un hommage a 20 ans de films Spider-Man, j\'ai personnellement grandi avec la 1ere trilogie et ensuite avec la seconde, on ne peut être que ravi de voir à quel point l\'hommage est complet.', 5, '2022-01-19 09:19:17'),
(10, 11, 8, 'Alohomora , Accio, Petrificus totalus !', 'Que c\'est bon de réentendre ces sorts ! Et surtout, quel plaisir de replonger dans cet univers magique créé par J.K. Rowling. Pour beaucoup, la saga Harry Potter n\'est pas qu\'une série de romans, c\'est une tranche de vie.', 5, '2022-01-19 09:22:06'),
(11, 12, 16, 'Captivant et images splendides', 'En plus de nous gratifier de splendides images, \"Lynx\" nous apprend tout ce que nous ne savions pas sur ce magnifique animal qu’est le lynx : un animal très discret sans être pour autant particulièrement timide', 3, '2022-01-19 09:32:23'),
(12, 12, 15, 'Quel plaisir', 'Ça respect le manga et juste le film c\'est une dinguerie! Bref le film on la attendu en France quand même !', 4, '2022-01-19 09:34:35'),
(13, 13, 4, 'Déni cosmique', 'Admirablement joué par son tandem de stars, mais aussi par tous les autres astres qui gravitent autour, Don’t Look Up : déni cosmique réussit le pari de nous embarquer dans une satire follement ambitieuse de l’humanité 2.0.', 4, '2022-01-19 09:47:09'),
(14, 13, 14, 'Un peu déçu', 'J\'attendais beaucoup de Soul, mais je dois dire qu\'à l\'arrivée j\'ai surtout vu un film visuellement magnifique mais qui avait du mal à sortir des sentiers battus et à être thématiquement cohérent entre l\'histoire racontée et le message qu\'il veut faire passer.', 3, '2022-01-19 09:50:03'),
(15, 11, 5, 'N\'hésitez pas !', 'En ce début d\'année, Nightmare Alley est le film à ne pas rater ! Guillermo Del Toro fait son grand retour après avoir connu la consécration avec The Shape of Water. Cette fois-ci pas de \"monstre\" (du moins en apparence), mais c\'est encore excellent.', 5, '2022-01-19 09:55:13'),
(16, 15, 7, 'Emotion garantie', 'Un documentaire très intime sur les femmes de la famille Gainsbourg, porté par la tendresse des regards adultes entre les trois générations (Jane Birkin, Charlotte Gainsbourg et sa propre fille) mais aussi par la dureté des propos entendus (le film démarre tout de même par Jane qui dit à Charlotte qu\'elle n\'a jamais eu d\'affinité avec elle quand elle était petite... Ça, c\'est dit).', 4, '2022-01-19 10:00:44'),
(17, 15, 14, 'Une pépite pour tout les âges', 'Eh bien Soul est une nouvelle petite pépite de Pete Docter C\'est simple, on tient là le Pixar le plus mâture qui soit Joe Gardner est un prof de musique au collège, aspirant à une vie de jazzman. Sa vocation est la musique, et lorsqu\'il décrochera le job de ses rêves, un funeste accident l\'enverra pour l\'Aù-Delà.', 5, '2022-01-19 10:02:08'),
(18, 15, 11, 'Trop c\'est trop ...', 'Mouais, j\'avais vraiment pas aimé Baby Driver, ça c\'est un poil mieux, mais je pense qu\'Edgar Wright et son cinéma commencent à me gaver.', 2, '2022-01-19 10:08:21'),
(19, 18, 5, 'Film maîtrisé de A à Z', 'Le moins qu\'on puisse dire c\'est que ce film ne laisse pas indifférent, et c\'est à mes yeux ce qui en fait un chef d\'œuvre. G Del Toro sait vraiment créer une atmosphère particulière, froide et glauque.', 4, '2022-01-19 10:30:59'),
(20, 15, 5, 'Dérive de l\'œuvre', 'Si dans un premier temps, aux vues du titre, du synopsis et de l\'affiche, on s\'attend à un nouveau film d\'épouvante gothique comme l\'était Crimson Peak, il n\'en sera rien.', 2, '2022-01-19 11:47:34'),
(21, 11, 2, 'Magistral, sublime !', 'Des images à couper le souffle, une photographie grandiose et poétique, des acteurs transcendés, une BO envoûtante et un grand respect de l\'œuvre originale ! J\'ai adoré. Hâte de voir les suivants !', 5, '2022-01-19 12:00:03');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preferences` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `register_at` datetime NOT NULL,
  `birthday` date NOT NULL,
  `profile_picture` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:object)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `username`, `gender`, `preferences`, `register_at`, `birthday`, `profile_picture`) VALUES
(1, 'flo.eych@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$jC5Thql6.NG6TkgzAVVnhuOSjKSC/FuywHOAfqcBrGVcvcS1zLjV2', 'Florian', 'EYCHENNE', 'Flo', 'Homme', 'a:3:{i:0;s:8:\"thriller\";i:1;s:6:\"comedy\";i:2;s:5:\"drama\";}', '2022-01-11 17:08:50', '1991-12-03', 's:36:\"aa9b6d95d175011071df6f5217b20112.jpg\";'),
(5, 'clem@mail.fr', '[\"ROLE_ADMIN\"]', '$2y$13$GMgT0byK7ysfsH8RGfITHeCGm6BGlhZnYDzXPhRGcquzBcfZM4tyq', 'Clement', 'DEGAT', 'Eura', 'Homme', 'a:2:{i:0;s:5:\"scifi\";i:1;s:9:\"animation\";}', '2022-01-16 18:16:31', '1999-02-02', 's:12:\"newglass.png\";'),
(11, 'laure@mail.fr', '[]', '$2y$13$G6rBCExrxxqjHKqJnqjfje2.qLc28KPk6q8MZc/SA1uABIpzDqhn.', 'Inès', 'DEGAT', 'Laure', 'Femme', 'a:2:{i:0;s:8:\"Comédie\";i:1;s:11:\"Fantastique\";}', '2022-01-06 16:19:55', '2002-02-28', 's:8:\"ines.png\";'),
(12, 'benoit@mail.fr', '[]', '$2y$13$TkplMmsebwZGjd4ylwf5ZOqk/YEpl.4WV9kpiA2dNY2byuNNAc/Ba', 'Benoît', 'Bonnet', 'Benoit31', 'Homme', 'a:3:{i:0;s:2:\"SF\";i:1;s:5:\"Drame\";i:2;s:7:\"Horreur\";}', '2022-01-16 16:23:17', '1999-02-15', 's:36:\"3058dcc52923119268775d3da0052852.jpg\";'),
(13, 'meli@mail.fr', '[]', '$2y$13$T83XM4Y357qW2V1ODGYV4.KGBHCR.P3KG1g5eB/GPXUp9IbZWWoLu', 'Melina', 'Hochard', 'Meli', 'Femme', 'a:2:{i:0;s:8:\"Comédie\";i:1;s:8:\"Aventure\";}', '2022-01-10 16:27:00', '1993-09-25', 's:36:\"a244498377f61bfc4e6ef5cf3bad6dda.jpg\";'),
(14, 'sasuke@mail.fr', '[]', '$2y$13$rJ7Y5FXcyyhKF54gbT2CH.6/L7FZQ.npqkhyLzGJYBBUl5RzuuyAa', 'Sasuke', 'Uchiha', 'Sasuke46', 'Ne pas renseigner', 'a:3:{i:0;s:2:\"SF\";i:1;s:8:\"Aventure\";i:2;s:6:\"Action\";}', '2022-01-01 16:29:57', '1997-01-02', 's:36:\"a16d3d18cfb41105e13c69d61af6d16d.jpg\";'),
(15, 'benjamin@mail.fr', '[]', '$2y$13$2BLd5sfjLiQMk3Mso1IXnOuVJ/cfSsd8f5eHXdekKh7zeYhldq3OO', 'Benjamin', 'Andre', 'Ben', 'Homme', 'a:2:{i:0;s:8:\"Comédie\";i:1;s:7:\"Romance\";}', '2022-01-18 16:34:32', '1994-08-25', 's:36:\"de75072e82e2d0ce14ea67649041d975.jpg\";'),
(16, 'flo@mail.fr', '[]', '$2y$13$OemMuP4.lD0PnR/WybvZPO3KRFH7QXCRUMprHWWgxIehXUzSfqQLu', 'Florian', 'Marchand', 'Flo', 'Homme', 'a:2:{i:0;s:6:\"Action\";i:1;s:11:\"Fantastique\";}', '2022-01-18 16:36:55', '1991-12-30', 's:28:\"profile_picture_default.jpeg\";'),
(17, 'admin@mail.fr', '[\"ROLE_ADMIN\"]', '$2y$13$b12sQkGTxJ1U1uyrhlec1Ogqku0NLjHwEi4wVEQn67z8gXFcKR72a', 'Clement', 'Eurae', 'Eurae', 'Homme', 'a:2:{i:0;s:6:\"Action\";i:1;s:11:\"Fantastique\";}', '2022-01-19 10:15:51', '1999-02-02', 's:28:\"profile_picture_default.jpeg\";'),
(18, 'fab@mail.fr', '[]', '$2y$13$xkMIWQyU4rctZnc8peFfl.2q0dL8bw25LipGHeZ0uvhGRxbYh3q6S', 'Fabrice', 'ANDRES', 'Fab', 'Homme', 'a:2:{i:0;s:2:\"SF\";i:1;s:5:\"Drame\";}', '2022-01-19 10:25:11', '1991-11-05', 's:36:\"78e23103567a1a512726dcbed9f7c9e9.jpg\";');

-- --------------------------------------------------------

--
-- Structure de la table `user_user`
--

CREATE TABLE `user_user` (
  `user_source` int(11) NOT NULL,
  `user_target` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_user`
--

INSERT INTO `user_user` (`user_source`, `user_target`) VALUES
(5, 1),
(5, 5),
(5, 11),
(11, 13),
(11, 18),
(12, 11),
(12, 15),
(13, 11),
(13, 15),
(14, 11),
(15, 11),
(16, 11),
(16, 15),
(18, 11),
(18, 13);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5F9E962AA76ED395` (`user_id`),
  ADD KEY `IDX_5F9E962A3E2E969B` (`review_id`),
  ADD KEY `IDX_5F9E962A4B89032C` (`post_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5A8A6C8DA76ED395` (`user_id`);

--
-- Index pour la table `post_user`
--
ALTER TABLE `post_user`
  ADD PRIMARY KEY (`post_id`,`user_id`),
  ADD KEY `IDX_44C6B1424B89032C` (`post_id`),
  ADD KEY `IDX_44C6B142A76ED395` (`user_id`);

--
-- Index pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6970EB0FA76ED395` (`user_id`),
  ADD KEY `IDX_6970EB0F4B89032C` (`post_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Index pour la table `user_user`
--
ALTER TABLE `user_user`
  ADD PRIMARY KEY (`user_source`,`user_target`),
  ADD KEY `IDX_F7129A803AD8644E` (`user_source`),
  ADD KEY `IDX_F7129A80233D34C1` (`user_target`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_5F9E962A3E2E969B` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`),
  ADD CONSTRAINT `FK_5F9E962A4B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_5F9E962AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post_user`
--
ALTER TABLE `post_user`
  ADD CONSTRAINT `FK_44C6B1424B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_44C6B142A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_6970EB0F4B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_6970EB0FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user_user`
--
ALTER TABLE `user_user`
  ADD CONSTRAINT `FK_F7129A80233D34C1` FOREIGN KEY (`user_target`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F7129A803AD8644E` FOREIGN KEY (`user_source`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
