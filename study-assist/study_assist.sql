-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 30, 2025 at 09:06 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `study_assist`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_history`
--

DROP TABLE IF EXISTS `chat_history`;
CREATE TABLE IF NOT EXISTS `chat_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `user_message` text NOT NULL,
  `bot_response` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chat_history`
--

INSERT INTO `chat_history` (`id`, `user_id`, `user_message`, `bot_response`, `created_at`) VALUES
(4, 2, 'Mugabe', '<strong>Robert Mugabe</strong>:<br/>Robert Gabriel Mugabe (; Shona: [muɡaɓe]; 21 February 1924 – 6 September 2019) was a Zimbabwean revolutionary and politician who served as Prime Minister of Zimbabwe from 1980 to 1987 and then as President from 1987 to 2017. He served as Leader of the Zimbabwe African National Union (ZANU) from 1975 to 1980 and led its successor political party, the ZANU – Patriotic Front (ZANU–PF), from 1980 to 2017. Ideologically an African nationalist, during the 1970s and 1980s he identified as a Marxist–Leninist, and as a socialist during the 1990s and the remainder of his career.\nMugabe was born to a poor Shona family in Kutama, Southern Rhodesia. Educated at Kutama College and the University of Fort Hare in South Africa, he then worked as a schoolteacher in Southern Rhodesia, Northern Rhodesia, and Ghana. Angered by white minority rule of his homeland within the British Empire, Mugabe embraced Marxism and joined African nationalists calling for an independent state controlled by the black majority. After making antigovernmental comments, he was convicted of sedition and imprisoned between 1964 and 1974. On release, he fled to Mozambique, established his leadership of ZANU, and oversaw its role in the Rhodesian Bush War, fighting Ian Smith\'s predominantly white government. He reluctantly participated in peace talks in the United Kingdom that resulted in the Lancaster House Agreement, putting an end to the war. In the 1980 general election, Mugabe led ZANU-PF to victory, becoming Prime Minister when the country, now renamed Zimbabwe, gained internationally recognized independence later that year. Mugabe\'s administration expanded healthcare and education and—despite his professed desire for a socialist society—adhered largely to mainstream economic policies.\nMugabe\'s calls for racial reconciliation failed to stem growing white emigration, while relations with Joshua Nkomo\'s Zimbabwe African People\'s Union (ZAPU) also deteriorated. In the Gukurahundi of 1982–1987, Mugabe\'s 5th Brigade crushed ZAPU-linked opposition in Matabeleland in a campaign that killed at least 20,000 people, mostly Ndebele civilians. Internationally, he sent troops into the Second Congo War and chaired the Non-Aligned Movement (1986–1989), the Organisation of African Unity (1997–1998), and the African Union (2015–2016). Pursuing decolonisation, Mugabe emphasized the redistribution of land controlled by white farmers to landless blacks, initially on a \"willing seller–willing buyer\" basis. Frustrated at the slow rate of redistribution, from 2000 he encouraged black Zimbabweans to violently seize white-owned farms. Food production was severely impacted, leading to famine, economic decline, and foreign sanctions. Opposition to Mugabe grew, but he was re-elected in 2002, 2008, and 2013 through campaigns dominated by violence, electoral fraud, and nationalistic appeals to his rural Shona voter base. In 2017, members of his party ousted him in a coup, replacing him with former vice president Emmerson Mnangagwa.\nHaving dominated Zimbabwe\'s politics for nearly four decades, Mugabe was a controversial figure. He was praised as a revolutionary hero of the African liberation struggle who helped free Zimbabwe from British colonialism, imperialism, and white minority rule. Critics accused Mugabe of being a dictator responsible for economic mismanagement and widespread corruption and human rights abuses, including anti-white racism, crimes against humanity, and genocide.<br/><a href=\"https://en.wikipedia.org/wiki/Robert%20Mugabe\" target=\"_blank\" style=\"color:blue;\">Read more on Wikipedia</a>', '2025-05-22 12:17:32'),
(3, 2, 'World War 1', '<strong>World War I</strong>:<br/>World War I or the First World War (28 July 1914 – 11 November 1918), also known as the Great War, was a global conflict between two coalitions: the Allies (or Entente) and the Central Powers. Fighting took place mainly in Europe and the Middle East, as well as in parts of Africa and the Asia-Pacific, and in Europe was characterised by trench warfare; the widespread use of artillery, machine guns, and chemical weapons (gas); and the introductions of tanks and aircraft. World War I was one of the deadliest conflicts in history, resulting in an estimated 10 million military dead and more than 20 million wounded, plus some 10 million civilian dead from causes including genocide. The movement of large numbers of people was a major factor in the deadly Spanish flu pandemic.\nThe causes of World War I included the rise of Germany and decline of the Ottoman Empire, which disturbed the long-standing balance of power in Europe, and rising economic competition between nations driven by industrialisation and imperialism. Growing tensions between the great powers and in the Balkans reached a breaking point on 28 June 1914, when Gavrilo Princip, a Bosnian Serb, assassinated the heir to the Austro-Hungarian throne. Austria-Hungary blamed Serbia, and declared war on 28 July. After Russia mobilised in Serbia\'s defence, Germany declared war on Russia and France, who had an alliance. The United Kingdom entered after Germany invaded Belgium, and the Ottomans joined the Central Powers in November. Germany\'s strategy in 1914 was to quickly defeat France then transfer its forces to the east, but its advance was halted in September, and by the end of the year the Western Front consisted of a near-continuous line of trenches from the English Channel to Switzerland. The Eastern Front was more dynamic, but neither side gained a decisive advantage, despite costly offensives. Italy, Bulgaria, Romania, Greece and others joined in from 1915 onward.\nMajor battles, including at Verdun, the Somme, and Passchendaele, failed to break the stalemate on the Western Front. In April 1917, the United States joined the Allies after Germany resumed unrestricted submarine warfare against Atlantic shipping. Later that year, the Bolsheviks seized power in Russia in the October Revolution; Soviet Russia signed an armistice with the Central Powers in December, followed by a separate peace in March 1918. That month, Germany launched a spring offensive in the west, which despite initial successes left the German Army exhausted and demoralised. The Allied Hundred Days Offensive beginning in August 1918 caused a collapse of the German front line. Following the Vardar Offensive, Bulgaria signed an armistice in late September. By early November, the Ottoman Empire and Austria-Hungary had each signed armistices with the Allies, leaving Germany isolated. Facing a revolution at home, Kaiser Wilhelm II abdicated on 9 November, and the war ended with the Armistice of 11 November 1918.\nThe Paris Peace Conference of 1919–1920 imposed settlements on the defeated powers, most notably the Treaty of Versailles, by which Germany lost significant territories, was disarmed, and was required to pay large war reparations to the Allies. The dissolution of the Russian, German, Austro-Hungarian, and Ottoman Empires redrew national boundaries and resulted in the creation of new independent states, including Poland, Finland, the Baltic states, Czechoslovakia, and Yugoslavia. The League of Nations was established to maintain world peace, but its failure to manage instability during the interwar period contributed to the outbreak of World War II in 1939.<br/><a href=\"https://en.wikipedia.org/wiki/World%20War%20I\" target=\"_blank\" style=\"color:blue;\">Read more on Wikipedia</a>', '2025-05-20 20:06:09'),
(5, 3, 'sherman', '<strong>Sherman</strong>:<br/>Sherman most commonly refers to:\n\nSherman (name), including a list of people and fictional characters with the given name or surname\nWilliam Tecumseh Sherman (1820–1891), American Civil War General\nM4 Sherman, a World War II American tank\nSherman may also refer to:<br/><a href=\"https://en.wikipedia.org/wiki/Sherman\" target=\"_blank\" style=\"color:blue;\">Read more on Wikipedia</a>', '2025-05-22 13:30:05'),
(6, 2, 'marvin gay', '<strong>Marvin Gay Sr.</strong>:<br/>Marvin Pentz Gay Sr. (October 1, 1914 – October 10, 1998) was an American Pentecostal minister. He was the father of recording artists Marvin Gaye and Frankie Gaye and gained notoriety after shooting and killing his son Marvin on April 1, 1984, following an argument at their home.<br/><a href=\"https://en.wikipedia.org/wiki/Marvin%20Gay%20Sr.\" target=\"_blank\" style=\"color:blue;\">Read more on Wikipedia</a>', '2025-05-29 10:59:27');

-- --------------------------------------------------------

--
-- Table structure for table `daily_progress`
--

DROP TABLE IF EXISTS `daily_progress`;
CREATE TABLE IF NOT EXISTS `daily_progress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `hours_goal` int DEFAULT '0',
  `hours_completed` int DEFAULT '0',
  `days_streak` int DEFAULT '0',
  `last_study_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `daily_progress`
--

INSERT INTO `daily_progress` (`id`, `user_id`, `date`, `hours_goal`, `hours_completed`, `days_streak`, `last_study_date`) VALUES
(1, 2, '2025-05-20', 0, 0, 0, NULL),
(2, 1, '2025-05-20', 0, 0, 0, NULL),
(3, 2, '2025-05-22', 0, 0, 0, NULL),
(4, 3, '2025-05-22', 0, 0, 0, NULL),
(5, 2, '2025-05-23', 0, 0, 0, NULL),
(6, 2, '2025-05-29', 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

DROP TABLE IF EXISTS `goals`;
CREATE TABLE IF NOT EXISTS `goals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `goal_type` varchar(50) DEFAULT NULL,
  `target_value` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

DROP TABLE IF EXISTS `nodes`;
CREATE TABLE IF NOT EXISTS `nodes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `x` int NOT NULL,
  `y` int NOT NULL,
  `width` int NOT NULL,
  `height` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nodes`
--

INSERT INTO `nodes` (`id`, `text`, `x`, `y`, `width`, `height`) VALUES
(18, 'Nodeuuuuuu', 782, 38, 120, 60);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course` varchar(255) NOT NULL,
  `schedule_type` enum('daily','weekly') NOT NULL,
  `day` varchar(20) DEFAULT NULL,
  `time_slot` varchar(20) DEFAULT NULL,
  `user_id` int NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `course`, `schedule_type`, `day`, `time_slot`, `user_id`, `completed`) VALUES
(120, 'math', 'weekly', 'Tuesday', '12:00 - 13:00', 2, 1),
(119, 'math', 'weekly', 'Monday', '08:00 - 09:00', 2, 0),
(121, 'math', 'weekly', 'Wednesday', '18:00 - 19:00', 2, 0),
(122, 'math', 'weekly', 'Thursday', '08:00 - 09:00', 2, 0),
(123, 'math', 'weekly', 'Friday', '12:00 - 13:00', 2, 0),
(124, 'math', 'weekly', 'Saturday', '18:00 - 19:00', 2, 0),
(125, 'math', 'weekly', 'Sunday', '08:00 - 09:00', 2, 0),
(126, 'bio', 'weekly', 'Monday', '12:00 - 13:00', 2, 0),
(127, 'bio', 'weekly', 'Tuesday', '18:00 - 19:00', 2, 1),
(128, 'bio', 'weekly', 'Wednesday', '08:00 - 09:00', 2, 0),
(129, 'bio', 'weekly', 'Thursday', '12:00 - 13:00', 2, 0),
(130, 'bio', 'weekly', 'Friday', '18:00 - 19:00', 2, 0),
(131, 'bio', 'weekly', 'Saturday', '08:00 - 09:00', 2, 0),
(132, 'bio', 'weekly', 'Sunday', '12:00 - 13:00', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `study_sessions`
--

DROP TABLE IF EXISTS `study_sessions`;
CREATE TABLE IF NOT EXISTS `study_sessions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `session_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `duration_minutes` int NOT NULL,
  `completed` tinyint(1) DEFAULT '0',
  `notes` text,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `created_at`) VALUES
(1, 'tadiashley2003@gmail.com', '$2y$10$E9KihSVBNSYTKhN2drvgCuCl4blY4zc.95Kl5XWh5ua593EtCwZXO', '2025-05-19 01:39:47'),
(2, 'ash@k.com', '$2y$10$afJLMzxJDl/WILl2Lqwc..ixr30CS.m9q2e.Zl0f.8UscMsNMZWEO', '2025-05-19 18:56:48'),
(3, 'tash@g.com', '$2y$10$A1hamvR/Ntm/MQutyJSI6O4VBuMv31E29IWAJhBHDsyH2aY46v20O', '2025-05-22 13:02:05');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
