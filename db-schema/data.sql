-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 08, 2013 at 07:30 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `job_portal`
--

--
-- Dumping data for table `job_admin`
--
-- in use (#1033 - Incorrect information in file: '.\job_portal\job_admin.frm')

--
-- Dumping data for table `job_bookmark`
--

INSERT INTO `job_bookmark` (`bookmark_id`, `user_id`, `selected_id`, `created_on`, `status`) VALUES
(5, 22, 18, '2012-05-06 20:35:40', 1),
(2, 1, 7, '2012-05-06 19:46:47', 1),
(3, 1, 18, '2012-05-06 19:46:53', 1),
(4, 1, 16, '2012-05-06 19:47:00', 1),
(6, 22, 14, '2012-05-06 20:35:43', 1),
(7, 22, 11, '2012-05-06 20:35:50', 1),
(8, 22, 16, '2012-05-06 20:35:59', 1),
(9, 22, 15, '2012-05-06 20:36:01', 1),
(10, 2, 17, '2012-05-06 20:54:50', 1),
(14, 23, 1, '2012-05-11 17:00:40', 1),
(16, 23, 17, '2012-05-11 17:09:09', 1),
(19, 25, 26, '2012-05-14 15:06:16', 1),
(20, 26, 25, '2012-05-14 15:10:07', 1),
(21, 29, 23, '2012-05-20 13:11:53', 1),
(22, 2, 27, '2012-05-31 12:38:07', 1),
(23, 23, 32, '2012-06-01 17:01:39', 1),
(24, 45, 46, '2012-06-04 22:23:14', 1),
(25, 3, 1, '2012-06-05 20:16:58', 1),
(26, 29, 53, '2012-06-10 20:36:47', 1),
(52, 1, 3, '2013-08-03 23:54:29', 1),
(28, 2, 55, '2012-06-18 15:44:31', 1),
(29, 45, 23, '2012-06-21 13:42:24', 1),
(30, 23, 56, '2012-06-21 19:32:22', 1),
(31, 1, 29, '2012-07-04 13:44:54', 1),
(32, 63, 3, '2012-07-25 00:14:39', 1),
(33, 63, 56, '2012-07-25 00:16:29', 1),
(34, 23, 63, '2012-07-30 18:04:14', 1),
(36, 2, 63, '2013-06-29 19:09:33', 1);

--
-- Dumping data for table `job_credit_balance`
--

INSERT INTO `job_credit_balance` (`credit_balance_id`, `user_id`, `TRANSACTION_FOR_user_id`, `status`, `created_on`, `type`, `balance`) VALUES
(1, 1, 2, 1, '2012-05-06 03:01:23', 'earned', 45.00),
(2, 2, 3, 1, '2012-05-06 03:11:21', 'earned', 3000.00),
(3, 3, 4, 1, '2012-05-06 03:18:04', 'earned', 5000.00),
(4, 4, 5, 1, '2012-05-06 03:18:19', 'earned', 6000.00),
(5, 6, 7, 1, '2012-05-06 03:18:47', 'earned', 3200.00),
(6, 7, 2, 1, '2012-05-06 03:18:59', 'earned', 8900.00),
(7, 1, 2, 1, '2012-06-11 13:27:57', 'earned', 3000.00),
(8, 3, 2, 1, '2012-06-11 14:16:01', 'earned', 4500.00),
(9, 3, 1, 1, '2012-06-11 14:17:28', 'earned', 4900.00),
(10, 27, 2, 1, '2012-06-22 18:10:09', 'earned', 5000.00),
(11, 2, 27, 1, '2012-06-22 18:10:09', 'spend', 5000.00),
(12, 1, 3, 1, '2013-07-31 20:49:27', 'earned', 4500.00),
(13, 3, 1, 1, '2013-07-31 20:49:27', 'spend', 4500.00);

--
-- Dumping data for table `job_feedback`
--

INSERT INTO `job_feedback` (`feedback_id`, `project_id`, `owner_user_id`, `owner_feedback_rate`, `owner_comment`, `owner_post_date`, `bidder_user_id`, `bidder_feedback_rate`, `bidder_comment`, `bidder_post_date`, `status`) VALUES
(1, 3, 2, '3', 'This is a testimonial from project owner side. my name is shyamku07.', '2012-06-07 10:11:07', 3, '4', 'This is a testimonial from bidder side. my name is safikul.', '2012-06-07 10:10:02', 2),
(2, 19, 23, '5', 'ererere er er er er erer ere', '2012-06-10 10:20:58', 29, '5', 'best project ever', '2012-06-10 10:21:36', 2),
(3, 20, 23, '4', 'wrwere', '2012-06-10 10:26:39', 29, '3', 'wewew', '2012-06-10 10:26:53', 2),
(4, 21, 23, '5', 'erere', '2012-06-10 10:30:07', 29, '3', 'ere', '2012-06-10 10:29:34', 2),
(5, 22, 23, '4', 'ererer er er e', '2012-06-10 10:33:11', 29, '4', 'erere', '2012-06-10 10:32:50', 2),
(6, 25, 29, '4', 'ererer er e', '2012-06-10 10:45:12', 23, '4', '23232', '2012-06-10 10:46:08', 2),
(7, 5, 2, '4', 'The Olympic Games (French: les Jeux olympiques) is a major international event featuring summer and winter sports, in which thousands of athletes participate in a variety of competitions.', '2012-06-11 04:11:07', 3, '', '', '0000-00-00 00:00:00', 1),
(8, 2, 2, '4', 'The Olympic Movement consists of international sports federations (IFs), National Olympic Committees (NOCs), and organizing committees for each specific Olympic Games.', '2012-06-11 04:11:38', 1, '', '', '0000-00-00 00:00:00', 1),
(9, 4, 2, '3', 'As the decision-making body, the IOC is responsible for choosing the host city for each Olympic Games.', '2012-06-11 04:16:37', 3, '', '', '0000-00-00 00:00:00', 1),
(10, 26, 29, '5', 'erere re er er e', '2012-06-11 04:17:07', 23, '5', 'rrtrtr', '2012-08-06 11:27:00', 2),
(11, 12, 1, '4', 'The host city is responsible for organizing and funding a celebration of the Games consistent with the Olympic Charter.', '2012-06-11 04:18:06', 3, '', '', '0000-00-00 00:00:00', 1);

--
-- Dumping data for table `job_invited`
--

INSERT INTO `job_invited` (`invited_id`, `project_id`, `user_id`, `created_on`, `status`) VALUES
(1, 3, 22, '2012-06-07 19:33:30', 1),
(2, 6, 12, '2012-06-07 19:47:38', 1),
(3, 9, 28, '2012-06-07 19:51:56', 1),
(4, 9, 5, '2012-06-07 19:52:02', 1),
(5, 19, 30, '2012-06-10 20:15:24', 1),
(6, 19, 28, '2012-06-10 20:15:29', 1),
(7, 19, 24, '2012-06-10 20:15:33', 1),
(8, 19, 29, '2012-06-10 20:15:39', 1),
(9, 31, 23, '2012-06-13 11:38:02', 1),
(10, 37, 46, '2012-06-18 21:45:34', 1),
(11, 37, 59, '2012-06-18 21:45:38', 1),
(12, 37, 18, '2012-06-18 21:45:42', 1),
(13, 37, 26, '2012-06-18 21:45:47', 1),
(14, 37, 7, '2012-06-18 21:45:49', 1),
(15, 37, 31, '2012-06-18 21:45:54', 1),
(16, 37, 24, '2012-06-18 21:45:59', 1),
(17, 37, 41, '2012-06-18 21:46:02', 1),
(18, 37, 29, '2012-06-18 21:46:05', 1),
(19, 37, 44, '2012-06-18 21:46:09', 1),
(20, 37, 37, '2012-06-18 21:46:13', 1),
(21, 37, 45, '2012-06-18 21:46:16', 1),
(22, 37, 27, '2012-06-18 21:46:20', 1),
(23, 37, 3, '2012-06-18 21:46:23', 1),
(24, 37, 16, '2012-06-18 21:46:30', 1),
(25, 37, 30, '2012-06-18 21:46:33', 1),
(26, 37, 55, '2012-06-18 21:46:37', 1),
(27, 37, 17, '2012-06-18 21:46:40', 1),
(28, 37, 1, '2012-06-18 21:46:43', 1),
(29, 37, 58, '2012-06-18 21:46:47', 1),
(30, 38, 18, '2012-06-21 13:32:34', 1),
(31, 38, 40, '2012-06-21 13:32:37', 1),
(32, 39, 58, '2012-06-21 19:33:48', 1),
(33, 39, 8, '2012-06-21 19:33:52', 1),
(34, 40, 29, '2012-06-23 12:25:34', 1),
(35, 40, 15, '2012-06-23 12:26:20', 1),
(36, 40, 33, '2012-06-23 12:26:26', 1),
(37, 41, 14, '2012-07-19 21:54:25', 1),
(38, 43, 12, '2012-08-06 21:08:54', 1),
(39, 49, 59, '2013-08-24 11:37:36', 1);

--
-- Dumping data for table `job_membership`
--

INSERT INTO `job_membership` (`membership_id`, `membership`, `subscription_interval`, `status`, `created_on`, `is_premium`, `is_default`, `membership_cost`) VALUES
(1, 'Membership upgrade', 12, 1, '2012-06-11 19:42:54', 0, 0, 200.00),
(2, 'premium', 0, 1, '2012-06-07 16:34:49', 1, 0, 200.00);

--
-- Dumping data for table `job_message`
--

INSERT INTO `job_message` (`message_id`, `project_id`, `SENDER_user_id`, `RECEIVER_user_id`, `subject`, `message`, `status`, `RECEIVER_read`, `parent_message_id`, `created_on`) VALUES
(1, 5, 3, 2, 'Dhaka university', 'I am a bidder.', 2, 0, 0, '2012-06-07 19:44:52'),
(2, 4, 3, 2, 'khulna university', 'Another French artist, Émile Cohl, began drawing cartoon strips and created a film in 1908 called Fantasmagorie. The film largely consisted of a stick figure moving about and encountering all manner of morphing objects, such as a wine bottle that transforms into a flower.', 2, 0, 0, '2012-06-07 19:54:31'),
(3, 3, 3, 2, 'Public', 'Following the successes of Blackton and Cohl, many other artists began experimenting with animation. One such artist was Winsor McCay, a successful newspaper cartoonist, who created detailed animations that required a team of artists and painstaking attention for detail. ', 2, 1, 0, '2012-06-08 16:12:48'),
(4, 9, 1, 3, 'Animation', 'Various forms of football can be identified in history, often as popular peasant games. Contemporary codes of football can be traced back to the codification of these games at English public schools in the eighteenth and nineteenth century.[2][3] The influence and power of the British Empire allowed these rules of football to spread', 2, 0, 0, '2012-06-07 20:06:25'),
(5, 9, 2, 3, 'Animation', 'Hi, Various forms of football can be identified in history, often as popular peasant games. Contemporary codes of football can be traced back to the codification of these games at English public schools in the eighteenth and nineteenth century.[2][3] The influence and power of the British Empire allowed these rules of football to spread', 2, 0, 0, '2012-06-07 20:07:37'),
(6, 3, 2, 3, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/3/">click here</a> to see details.', 1, 1, 0, '2012-06-07 20:08:38'),
(7, 3, 3, 2, NULL, 'Your assign project has accepted bysafiqul.To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/3/">click here</a>', 1, 1, 0, '2012-06-08 16:12:48'),
(8, 3, 3, 2, '3lance / safiqul has written a testimonial on the project Public', '<div style=''width:90%;height:100%;margin:0 auto;font-size:16px;''>\n    <p>Dear shyamku07,</p>\n    <p>safiqul written a testimonial for you on the project Public. <a href="http://www.webzonetechno.com/job-portal/project/my_feedback/1/0" target="_blank">Click here</a> to view the details of the testimonial written on you.</p>\n    <p>If you have any queries to using this website, feel free to drop us an email at technical@3lance.sg.</p>\n    <p>We look forward to seeing a lot more of you soon!</p>\n    <br /><br />\n    Thank you, <br />\n    Team 3lance <br /> \n</div>', 1, 1, 0, '2012-06-08 16:12:48'),
(9, 3, 2, 3, '3lance / shyamku07 has written a testimonial on the project Public', '<div style=''width:90%;height:100%;margin:0 auto;font-size:16px;''>\n    <p>Dear safiqul,</p>\n    <p>shyamku07 written a testimonial for you on the project Public. <a href="http://www.webzonetechno.com/job-portal/project/my_feedback/1/0" target="_blank">Click here</a> to view the details of the testimonial written on you.</p>\n    <p>If you have any queries to using this website, feel free to drop us an email at technical@3lance.sg.</p>\n    <p>We look forward to seeing a lot more of you soon!</p>\n    <br /><br />\n    Thank you, <br />\n    Team 3lance <br /> \n</div>', 1, 0, 0, '2012-06-07 20:11:08'),
(10, 13, 3, 1, 'Google plus', 'The early forms of football played in England, sometimes referred to as "mob football", would be played between neighbouring towns and villages, involving an unlimited number of players on opposing teams who would clash en masse,[24] struggling to move an item, such as inflated animal''s bladder[25] to particular geographical points, such as their opponents'' church, with play taking place in the open space between neighbouring parishes.[26] The game was played primarily during significant religious festivals, such as Shrovetide, Christmas, or Easter,[25] and Shrovetide games have survived into the modern era in a number of English towns (see below).', 2, 0, 0, '2012-06-07 20:13:14'),
(11, 12, 3, 1, 'Twitter follow', 'There are a number of references to traditional, ancient, or prehistoric ball games, played by indigenous peoples in many different parts of the world. For example, in 1586, men from a ship commanded by an English explorer named John Davis, went ashore to play a form of football with Inuit (Eskimo) people in Greenland.[19] There are later accounts of an Inuit game played on ice, called Aqsaqtuk. Each match began with two teams facing each other in parallel lines, before attempting to kick the ball through each other team''s line and then at a goal. In 1610,', 2, 0, 0, '2012-06-07 20:13:49'),
(12, 11, 3, 1, 'Web design', 'The first detailed description of what was almost certainly football in England was given by William FitzStephen in about 1174–1183. He described the activities of London youths during the annual festival of Shrove Tuesday:', 2, 1, 0, '2012-06-07 20:29:30'),
(13, 11, 1, 3, NULL, 'Various forms of football can be identified in history, often as popular peasant games. Contemporary codes of football can be traced back to the codification of these games at English public schools in the eighteenth and nineteenth century.[2][3] The influence and power of the British Empire allowed these rules of football to spread.', 1, 0, 0, '2012-06-07 20:30:02'),
(14, 9, 29, 3, 'Animation', 'erereeret et ete t', 2, 0, 0, '2012-06-07 21:02:58'),
(15, 9, 29, 3, NULL, 'rerere', 1, 0, 0, '2012-06-07 21:03:25'),
(16, 14, 53, 1, 'Facebook vote', 'hi there', 2, 0, 0, '2012-06-08 09:26:48'),
(17, 7, 2, 3, 'Cricket', 'The Sundarbans National Park is a National Park, Tiger Reserve, and a Biosphere Reserve located in the Sundarbans delta in the Indian state of West Bengal. Sundarbans South, East and West are three protected forests in Bangladesh. This region is densely covered by mangrove forests, and is one of the largest reserves for the Bengal tiger.', 2, 0, 0, '2012-06-08 10:52:29'),
(18, 8, 2, 3, 'Football', 'The Sundarbans National Park is a National Park, Tiger Reserve, and a Biosphere Reserve located in the Sundarbans delta in the Indian state of West Bengal. Sundarbans South, East and West are three protected forests in Bangladesh. This region is densely covered by mangrove forests, and is one of the largest reserves for the Bengal tiger.', 2, 0, 0, '2012-06-08 10:53:31'),
(19, 10, 2, 3, 'New Animation ', 'The Sundarbans National Park is a National Park, Tiger Reserve, and a Biosphere Reserve located in the Sundarbans delta in the Indian state of West Bengal. Sundarbans South, East and West are three protected forests in Bangladesh. This region is densely covered by mangrove forests, and is one of the largest reserves for the Bengal tiger.', 2, 0, 0, '2012-06-08 10:55:26'),
(20, 6, 2, 3, 'BUET', 'The Sundarbans National Park is a National Park, Tiger Reserve, and a Biosphere Reserve located in the Sundarbans delta in the Indian state of West Bengal. Sundarbans South, East and West are three protected forests in Bangladesh. This region is densely covered by mangrove forests, and is one of the largest reserves for the Bengal tiger.', 2, 0, 0, '2012-06-08 10:56:24'),
(21, 13, 2, 1, 'Google plus', 'The Sundarbans National Park is a National Park, Tiger Reserve, and a Biosphere Reserve located in the Sundarbans delta in the Indian state of West Bengal. Sundarbans South, East and West are three protected forests in Bangladesh. This region is densely covered by mangrove forests, and is one of the largest reserves for the Bengal tiger.', 2, 0, 0, '2012-06-08 15:09:54'),
(22, 15, 2, 1, 'New Football', 'The Sundarbans National Park is a National Park, Tiger Reserve, and a Biosphere Reserve located in the Sundarbans delta in the Indian state of West Bengal. Sundarbans South, East and West are three protected forests in Bangladesh. This region is densely covered by mangrove forests, and is one of the largest reserves for the Bengal tiger.', 2, 0, 0, '2012-06-08 15:43:28'),
(23, 14, 2, 1, 'Facebook vote', 'The Sundarbans National Park is a National Park, Tiger Reserve, and a Biosphere Reserve located in the Sundarbans delta in the Indian state of West Bengal. Sundarbans South, East and West are three protected forests in Bangladesh. This region is densely covered by mangrove forests, and is one of the largest reserves for the Bengal tiger.', 2, 1, 0, '2012-06-09 17:14:16'),
(24, 10, 1, 3, 'New Animation ', 'Georges Méliès was a creator of special-effect films; he was generally one of the first people to use animation with his technique. He discovered a technique by accident which was to stop the camera rolling to change something in the scene, and then continue rolling the film. This idea was later known as stop-motion animation. Méliès discovered this technique accidentally when his camera broke down while shooting a bus driving by.', 2, 0, 0, '2012-06-08 18:44:18'),
(25, 5, 1, 2, 'Dhaka university', 'Georges Méliès was a creator of special-effect films; he was generally one of the first people to use animation with his technique. He discovered a technique by accident which was to stop the camera rolling to change something in the scene, and then continue rolling the film. This idea was later known as stop-motion animation. Méliès discovered this technique accidentally when his camera broke down while shooting a bus driving by', 2, 1, 0, '2012-06-11 12:10:27'),
(26, 7, 1, 3, 'Cricket', 'Georges Méliès was a creator of special-effect films; he was generally one of the first people to use animation with his technique. He discovered a technique by accident which was to stop the camera rolling to change something in the scene, and then continue rolling the film. This idea was later known as stop-motion animation. Méliès discovered this technique accidentally when his camera broke down while shooting a bus driving by', 2, 0, 0, '2012-06-08 18:45:14'),
(27, 4, 1, 2, 'khulna university', 'Georges Méliès was a creator of special-effect films; he was generally one of the first people to use animation with his technique. He discovered a technique by accident which was to stop the camera rolling to change something in the scene, and then continue rolling the film. This idea was later known as stop-motion animation. Méliès discovered this technique accidentally when his camera broke down while shooting a bus driving by', 2, 1, 0, '2012-06-09 13:24:58'),
(28, 6, 1, 3, 'BUET', 'Georges Méliès was a creator of special-effect films; he was generally one of the first people to use animation with his technique. He discovered a technique by accident which was to stop the camera rolling to change something in the scene, and then continue rolling the film. This idea was later known as stop-motion animation. Méliès discovered this technique accidentally when his camera broke down while shooting a bus driving by', 2, 0, 0, '2012-06-08 18:46:19'),
(29, 2, 1, 2, 'Freedom', 'Georges Méliès was a creator of special-effect films; he was generally one of the first people to use animation with his technique. He discovered a technique by accident which was to stop the camera rolling to change something in the scene, and then continue rolling the film. This idea was later known as stop-motion animation. Méliès discovered this technique accidentally when his camera broke down while shooting a bus driving by', 2, 0, 0, '2012-06-08 18:46:58'),
(30, 5, 4, 2, 'Dhaka university', 'mahmudhas bidded $4000 for your project Dhaka university, to be done in 9 days. They have also said \nThe Sundarbans National Park is a National Park, Tiger Reserve, and a Biosphere Reserve located in the Sundarbans delta in the Indian state of West Bengal. Sundarbans South, East and West are three protected forests in Bangladesh. This region is densely covered by mangrove forests, and is one of the largest reserves for the Bengal tiger.', 2, 1, 0, '2012-06-09 12:53:29'),
(31, 14, 1, 2, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/14/">click here</a> to see details.', 1, 1, 0, '2012-06-09 17:11:06'),
(32, 13, 1, 2, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/13/">click here</a> to see details.', 1, 1, 0, '2012-06-09 19:40:03'),
(33, 14, 2, 1, NULL, 'Your assign project has accepted byshyamku07.To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/14/">click here</a>', 1, 1, 0, '2012-06-09 17:14:16'),
(34, 14, 2, 53, NULL, 'Unfortunately, your bid has not choosen byshyamku07. To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/14/">click here</a>', 1, 0, 0, '2012-06-09 17:14:01'),
(35, 9, 29, 3, NULL, 'erere', 1, 0, 0, '2012-06-10 20:13:41'),
(36, 19, 29, 23, 'project', 'skylark2 has bidded $11 for your project project, to be done in 12 days. They have also said, \nerere erere', 2, 1, 0, '2012-06-10 20:17:48'),
(37, 19, 23, 29, NULL, 'etere', 1, 1, 0, '2012-06-10 20:18:08'),
(38, 19, 29, 23, NULL, 'erere', 1, 1, 0, '2012-06-10 20:18:22'),
(39, 19, 23, 29, NULL, 'erere', 1, 1, 0, '2012-06-10 20:21:46'),
(40, 19, 23, 29, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/19/">click here</a> to see details.', 1, 1, 0, '2012-06-10 20:21:46'),
(41, 19, 29, 23, NULL, 'Your assign project has accepted by skylark2.To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/19/">click here</a>', 1, 1, 0, '2012-06-10 20:21:10'),
(42, 19, 23, 29, '3lance / blackboxes has written a testimonial on the project project', '3lance / blackboxes has written a testimonial on the project project', 1, 1, 0, '2012-06-10 20:21:46'),
(43, 19, 29, 23, '3lance / skylark2 has written a testimonial on the project project', '3lance / skylark2 has written a testimonial on the project project', 1, 0, 0, '2012-06-10 20:21:36'),
(44, 20, 29, 23, 'project 2', 'skylark2 has bidded $12323 for your project project 2, to be done in 23 days. They have also said, \n23', 2, 0, 0, '2012-06-10 20:24:11'),
(45, 20, 23, 29, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/20/">click here</a> to see details.', 1, 0, 0, '2012-06-10 20:24:49'),
(46, 20, 29, 23, NULL, 'Your assign project has accepted by skylark2.To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/20/">click here</a>', 1, 0, 0, '2012-06-10 20:26:21'),
(47, 20, 23, 29, '3lance / blackboxes has written a testimonial on the project project 2', '3lance / blackboxes has written a testimonial on the project project 2', 1, 0, 0, '2012-06-10 20:26:39'),
(48, 20, 29, 23, '3lance / skylark2 has written a testimonial on the project project 2', '3lance / skylark2 has written a testimonial on the project project 2', 1, 0, 0, '2012-06-10 20:26:53'),
(49, 21, 29, 23, 'project 3', 'skylark2 has bidded $23232 for your project project 3, to be done in 23232 days. They have also said, \n232', 2, 0, 0, '2012-06-10 20:28:44'),
(50, 21, 23, 29, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/21/">click here</a> to see details.', 1, 0, 0, '2012-06-10 20:28:58'),
(51, 21, 29, 23, NULL, 'Your assign project has accepted by skylark2.To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/21/">click here</a>', 1, 0, 0, '2012-06-10 20:29:13'),
(52, 21, 29, 23, '3lance / skylark2 has written a testimonial on the project project 3', '3lance / skylark2 has written a testimonial on the project project 3', 1, 0, 0, '2012-06-10 20:29:34'),
(53, 21, 23, 29, '3lance / blackboxes has written a testimonial on the project project 3', '3lance / blackboxes has written a testimonial on the project project 3', 1, 0, 0, '2012-06-10 20:30:08'),
(54, 22, 29, 23, 'project 4', 'skylark2 has bidded $11 for your project project 4, to be done in 1 days. They have also said, \n2232', 2, 1, 0, '2012-06-21 19:36:14'),
(55, 22, 23, 29, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/22/">click here</a> to see details.', 1, 0, 0, '2012-06-10 20:32:20'),
(56, 22, 29, 23, NULL, 'Your assign project has accepted by skylark2.To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/22/">click here</a>', 1, 1, 0, '2012-06-21 19:36:14'),
(57, 22, 29, 23, '3lance / skylark2 has written a testimonial on the project project 4', '3lance / skylark2 has written a testimonial on the project project 4', 1, 1, 0, '2012-06-21 19:36:14'),
(58, 22, 23, 29, '3lance / blackboxes has written a testimonial on the project project 4', '3lance / blackboxes has written a testimonial on the project project 4', 1, 0, 0, '2012-06-10 20:33:11'),
(59, 25, 23, 29, 'project 6', 'blackboxes has bidded $122 for your project project 6, to be done in 23 days. They have also said, \n23', 2, 0, 0, '2012-06-10 20:44:21'),
(60, 25, 29, 23, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/25/">click here</a> to see details.', 1, 1, 0, '2012-06-21 13:43:42'),
(61, 25, 23, 29, NULL, 'Your assign project has accepted by blackboxes.To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/25/">click here</a>', 1, 0, 0, '2012-06-10 20:44:54'),
(62, 25, 29, 23, '3lance / skylark2 has written a testimonial on the project project 6', '3lance / skylark2 has written a testimonial on the project project 6', 1, 1, 0, '2012-06-21 13:43:42'),
(63, 25, 23, 29, '3lance / blackboxes has written a testimonial on the project project 6', '3lance / blackboxes has written a testimonial on the project project 6', 1, 0, 0, '2012-06-10 20:46:10'),
(64, 26, 23, 29, 'project 7', 'blackboxes has bidded $122 for your project project 7, to be done in 3 days. They have also said, \nproject 7', 2, 1, 0, '2012-06-10 20:50:50'),
(65, 26, 23, 29, NULL, 'erere', 1, 1, 0, '2012-06-10 20:50:50'),
(66, 26, 29, 23, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/26/">click here</a> to see details.', 1, 1, 0, '2012-06-10 20:50:15'),
(67, 26, 23, 29, NULL, 'Your assign project has accepted by blackboxes.To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/26/">click here</a>', 1, 1, 0, '2012-06-10 20:50:50'),
(68, 5, 2, 3, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/5/">click here</a> to see details.', 1, 1, 0, '2012-06-11 13:18:43'),
(69, 4, 2, 3, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/4/">click here</a> to see details.', 1, 1, 0, '2012-06-23 12:32:06'),
(70, 2, 2, 1, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/2/">click here</a> to see details.', 1, 1, 0, '2012-06-11 13:27:44'),
(71, 2, 1, 2, NULL, 'Your assign project has accepted by mainul.To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/2/">click here</a>', 1, 0, 0, '2012-06-11 13:27:57'),
(72, 5, 2, 3, '3lance / shyamku07 has written a testimonial on the project Dhaka university', '3lance / shyamku07 has written a testimonial on the project Dhaka university', 1, 0, 0, '2012-06-11 14:11:11'),
(73, 2, 2, 1, '3lance / shyamku07 has written a testimonial on the project Freedom', '3lance / shyamku07 has written a testimonial on the project Freedom', 1, 0, 0, '2012-06-11 14:11:38'),
(74, 4, 3, 2, NULL, 'Your assign project has accepted by safiqul.To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/4/">click here</a>', 1, 0, 0, '2012-06-11 14:16:01'),
(75, 4, 3, 1, NULL, 'Unfortunately, your bid has not choosen bysafiqul. To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/4/">click here</a>', 1, 0, 0, '2012-06-11 14:16:02'),
(76, 4, 2, 3, '3lance / shyamku07 has written a testimonial on the project khulna university', '3lance / shyamku07 has written a testimonial on the project khulna university', 1, 1, 0, '2012-06-23 12:32:06'),
(77, 12, 1, 3, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/12/">click here</a> to see details.', 1, 1, 0, '2012-06-11 14:17:18'),
(78, 26, 29, 23, '3lance / skylark2 has written a testimonial on the project project 7', '3lance / skylark2 has written a testimonial on the project project 7', 1, 1, 0, '2012-06-11 17:49:20'),
(79, 12, 3, 1, NULL, 'Your assign project has accepted by safiqul.To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/12/">click here</a>', 1, 0, 0, '2012-06-11 14:17:28'),
(80, 12, 1, 3, '3lance / mainul has written a testimonial on the project Twitter follow', '3lance / mainul has written a testimonial on the project Twitter follow', 1, 0, 0, '2012-06-11 14:18:09'),
(81, 26, 23, 29, NULL, 'erererere', 1, 0, 0, '2012-06-11 17:49:30'),
(82, 26, 23, 29, NULL, 'erere', 1, 0, 0, '2012-06-13 20:44:20'),
(83, 37, 60, 59, '001a 001a 001a ', '002 has bidded $2123 for your project 001a 001a 001a , to be done in 4 days. They have also said, \n001a 001a 001a 001a 001a 001a 001a ', 2, 1, 0, '2012-06-18 21:48:14'),
(84, 37, 59, 60, NULL, 'dfdfdfdfd', 1, 1, 0, '2012-06-18 21:50:44'),
(85, 28, 60, 3, 'Sundarbon1', '002 has bidded $1234 for your project Sundarbon1, to be done in 4 days. They have also said, \nthursday1thursday1thursday1thursday1thursday1', 2, 0, 0, '2012-06-21 13:36:31'),
(86, 38, 60, 45, 'thursday1', '002 has bidded $123 for your project thursday1, to be done in 23 days. They have also said, \nthursday1thursday1thursday1thursday1thursday1', 2, 0, 0, '2012-06-21 13:37:00'),
(87, 38, 23, 45, 'thursday1', 'blackboxes has bidded $12 for your project thursday1, to be done in 12 days. They have also said, \n1213124', 2, 0, 0, '2012-06-21 13:44:13'),
(88, 6, 23, 3, 'BUET', 'blackboxes has bidded $1233 for your project BUET, to be done in 3 days. They have also said, \n33', 2, 0, 0, '2012-06-21 13:44:46'),
(89, 36, 23, 2, 'Job portal', 'blackboxes has bidded $1234 for your project Job portal, to be done in 1234 days. They have also said, \n1234', 2, 0, 0, '2012-06-21 13:45:17'),
(90, 35, 27, 2, 'Managing Hospital', 'rana has bidded $1000 for your project Managing Hospital, to be done in 5 days. They have also said, \nThe Sundarban forest lies in the vast delta on the Bay of Bengal formed by the super confluence of the Padma, Brahmaputra and Meghna rivers across southern Bangladesh. The seasonally flooded Sundarbans freshwater swamp forests lie inland from the mangrove forests on the coastal fringe. The forest covers 10,000 km2. of which about 6,000 are in Bangladesh.[', 2, 0, 0, '2012-06-22 18:00:17'),
(91, 29, 27, 2, 'Football games', 'rana has bidded $5000 for your project Football games, to be done in 2 days. They have also said, \nThe Sundarban forest lies in the vast delta on the Bay of Bengal formed by the super confluence of the Padma, Brahmaputra and Meghna rivers across southern Bangladesh. The seasonally flooded Sundarbans freshwater swamp forests lie inland from the mangrove forests on the coastal fringe. The forest covers 10,000 km2. of which about 6,000 are in Bangladesh.[', 2, 0, 0, '2012-06-22 18:06:57'),
(92, 29, 2, 27, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/29/">click here</a> to see details.', 1, 1, 0, '2012-06-22 18:08:43'),
(93, 29, 27, 2, NULL, 'Your assign project has accepted by rana.To show details please <a href="http://www.webzonetechno.com/job-portal/project/project_details/29/">click here</a>', 1, 0, 0, '2012-06-22 18:10:09'),
(94, 36, 27, 2, 'Job portal', 'rana has bidded $5000 for your project Job portal, to be done in 3 days. They have also said, \nThe Sundarban forest lies in the vast delta on the Bay of Bengal formed by the super confluence of the Padma, Brahmaputra and Meghna rivers across southern Bangladesh. The seasonally flooded Sundarbans freshwater swamp forests lie inland from the mangrove forests on the coastal fringe. The forest covers 10,000 km2. of which about 6,000 are in Bangladesh.[', 2, 1, 0, '2012-06-23 11:42:40'),
(95, 36, 2, 27, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/36/">click here</a> to see details.', 1, 0, 0, '2012-06-22 18:52:57'),
(96, 17, 63, 1, 'Twitter account', 'butterandbutter has bidded $3000 for your project Twitter account, to be done in 4 days. They have also said, \nwining bit\n', 2, 0, 0, '2012-07-10 21:01:35'),
(97, 41, 63, 23, 'project 6', 'butterandbutter has bidded $1100 for your project project 6, to be done in 1 days. They have also said, \ntest test', 2, 0, 0, '2012-07-25 00:11:03'),
(98, 42, 45, 63, 'Testtest', 'test1 has bidded $1233 for your project Testtest, to be done in 3 days. They have also said, \nproject 6project 6project 6project 6project 6', 2, 0, 0, '2012-08-06 21:12:28'),
(99, 42, 23, 63, 'Testtest', 'blackboxes has bidded $11 for your project Testtest, to be done in 3 days. They have also said, \nerere', 2, 0, 0, '2012-08-06 21:25:20'),
(100, 41, 23, 63, NULL, 'A project has been assigned to you. Please <a href="http://www.webzonetechno.com/job-portal/project/project_details/41/">click here</a> to see details.', 1, 0, 0, '2012-08-06 21:26:13'),
(101, 26, 23, 29, '3lance / blackboxes has written a testimonial on the project project 7', '3lance / blackboxes has written a testimonial on the project project 7', 1, 0, 0, '2012-08-06 21:27:01'),
(102, 9, 29, 1, NULL, 'A project has been assigned to you. Please <a href="/project/project_details9/">click here</a> to see details.', 1, 0, 0, '2013-08-13 23:44:32'),
(103, 9, 29, 1, NULL, 'A project has been assigned to you. Please <a href="/project/project_details/9/">click here</a> to see details.', 1, 0, 0, '2013-08-13 23:44:32'),
(104, 9, 3, 1, NULL, 'A project has been assigned to you. Please <a href="/project/project_details/9/">click here</a> to see details.', 1, 1, 0, '2013-08-11 23:19:31'),
(105, 9, 3, 1, NULL, 'A project has been assigned to you. Please <a href="/project/project_details/9/">click here</a> to see details.', 1, 1, 0, '2013-08-11 23:19:31'),
(106, 9, 3, 1, NULL, 'A project has been assigned to you. Please <a href="/project/project_details/9/">click here</a> to see details.', 1, 1, 0, '2013-08-11 23:19:31'),
(107, 9, 3, 1, NULL, 'A project has been assigned to you. Please <a href="/project/project_details/9/">click here</a> to see details.', 1, 1, 0, '2013-08-11 23:19:31'),
(108, 9, 3, 1, NULL, 'A project has been assigned to you. Please <a href="/project/project_details/9/">click here</a> to see details.', 1, 1, 0, '2013-08-11 23:19:31'),
(109, 9, 1, 3, NULL, 'Your assign project has accepted by shoeb.To show details please <a href="/project/project_details/9/">click here</a>', 1, 0, 0, '2013-08-01 00:49:27'),
(110, 9, 3, 1, NULL, 'A project has been assigned to you. Please <a href="/project/project_details/9/">click here</a> to see details.', 1, 1, 0, '2013-08-11 23:19:31'),
(111, 9, 1, 3, NULL, 'testing 001', 1, 0, 0, '2013-08-13 21:29:10'),
(112, 9, 1, 3, NULL, 'testing 002', 1, 0, 0, '2013-08-13 21:35:08'),
(117, 9, 1, 3, NULL, '3lance / 1 has written a testimonial on the project Animation', 1, 0, 0, '2013-08-17 21:31:35'),
(116, 9, 1, 3, NULL, '3lance / 1 has written a testimonial on the project Animation', 1, 0, 0, '2013-08-17 21:04:17');

--
-- Dumping data for table `job_payment_record`
--

INSERT INTO `job_payment_record` (`payment_record_id`, `user_id`, `membership_id`, `cost`, `status`, `created_on`, `txn_id`) VALUES
(1, 14, 2, 10, 0, '2012-05-04 05:54:57', '1VA03275E2903744X'),
(2, 18, 2, 10, 0, '2012-05-04 06:28:05', '85T07349M63178111'),
(3, 17, 2, 10, 0, '2012-05-04 06:28:29', '7TU10450WJ817373T'),
(4, 34, 2, 10, 0, '2012-05-31 09:33:07', '064284872P0545022'),
(7, 2, 1, 5, 0, '2012-06-08 03:04:40', '8U193104997794449'),
(8, 2, 1, 5, 0, '2012-06-08 05:42:29', '9HB66814NV264570N'),
(9, 2, 1, 5, 0, '2012-06-08 08:16:40', '4WF24751YL068815M'),
(10, 29, 1, 5, 1, '2012-06-10 10:41:44', '25302599AE266925A'),
(11, 3, 1, 200, 1, '2012-06-11 09:41:04', '2AV11575JT7014921'),
(12, 57, 1, 200, 1, '2012-06-13 03:48:36', '2RL52050V0329804R'),
(13, 57, 1, 200, 1, '2012-06-13 03:49:31', '6MG664401B192394K'),
(14, 57, 1, 200, 1, '2012-06-13 04:01:37', '52554618PT546712X'),
(15, 57, 1, 200, 1, '2012-06-13 04:05:58', '5JP641783Y993010X'),
(16, 57, 1, 200, 1, '2012-06-13 04:12:44', '5CA19130GT763600X');

--
-- Dumping data for table `job_portfolio`
--

INSERT INTO `job_portfolio` (`portfolio_id`, `user_id`, `client_name`, `portfolio_title`, `project_url`, `project_description`, `portfolio_image`, `status`, `created_on`, `updated_on`) VALUES
(2, 1, 'Jonathan', 'My first portfolio', 'www.kaajbd.com', 'There is no description yet.', 'Chrysanthemum61.jpg', 1, '2012-07-04 13:52:13', '0000-00-00 00:00:00'),
(3, 1, 'Cathrine', 'My second project', 'www.secondproject.com', 'There is no description yet.', 'Tu-lips16.jpg', 1, '2012-07-04 13:53:24', '0000-00-00 00:00:00'),
(4, 1, 'Jaquline', 'My third project', 'www.thirdproject.com', 'There is no description yet.', 'Penguins65.jpg', 1, '2012-07-04 13:54:10', '0000-00-00 00:00:00'),
(5, 1, 'Addie', 'My fourth project', 'www.fourthproject.com', 'Fourth project description.', 'Koala.jpg', 1, '2012-07-04 13:55:05', '0000-00-00 00:00:00'),
(6, 1, 'Gilchrist', 'My fifth project', 'www.fifthproject.com', 'Fifth project description.', 'Jellyfish.jpg', 1, '2012-07-04 13:55:56', '0000-00-00 00:00:00'),
(7, 23, 'erer', 'eerer', 'www.we.com', 'ererere', 'post.jpg', 1, '2012-07-04 15:57:49', '0000-00-00 00:00:00'),
(8, 23, 'erer', 'eerer', 'www.we.com', 'hjhgjjh', 'banner_1.jpg', 1, '2012-07-04 17:52:17', '0000-00-00 00:00:00'),
(9, 63, 'nil', 'project 1', 'www.test.com', 'rtestest', 'Butter-Logo.jpg', 1, '2012-07-25 00:23:17', '0000-00-00 00:00:00'),
(10, 63, 'qweqw', 'test2', 'www.eee.com', 'qweqwd', 'Butter-Logo71.jpg', 1, '2012-07-25 00:24:49', '0000-00-00 00:00:00'),
(12, 1, 'Karel 003', 'My Portfolio 003', 'http://abc3.com', 'This is first 003', 'invite38.PNG', 1, '2013-08-24 15:37:23', '2013-08-24 15:59:30');

--
-- Dumping data for table `job_primary_category`
--

INSERT INTO `job_primary_category` (`primary_category_id`, `category_title`, `category_description`, `status`, `created_on`) VALUES
(3, '   Content ', 'Content Writing Projects', 1, '2012-05-30 13:59:42'),
(1, 'Web Design ', 'Web Design Projects', 1, '2012-05-30 13:40:17'),
(4, 'Cricket ', 'cricket games', 1, '2012-05-30 13:59:29'),
(7, 'University', 'University related', 1, '2012-05-30 13:41:20'),
(8, 'Web Projects', 'Web Projects', 1, '2012-05-30 13:54:19'),
(9, 'Search', 'Search Projects', 1, '2012-05-30 13:59:14'),
(10, ' Graphic', ' Graphic', 1, '2012-05-30 13:59:01'),
(11, 'Animation ', 'Animation', 1, '2012-05-30 13:58:47'),
(12, ' Illustration', ' Illustration\n', 1, '2012-05-30 13:58:34'),
(13, 'Corporate ', 'Corporate Branding Projects', 1, '2012-05-30 13:57:23'),
(2, 'Football', 'Football', 1, '2012-06-07 20:26:42');

--
-- Dumping data for table `job_project`
--

INSERT INTO `job_project` (`project_id`, `user_id`, `assigned_user_id`, `project_category_id`, `project_title`, `project_description`, `cost`, `CurrencyCode`, `additional_remarks`, `meet_up_required`, `milestone_payments`, `require_portfolio`, `status`, `created_on`, `bid_ending_date`, `project_status`, `archive_status`) VALUES
(1, 2, 0, 11, 'Sundarbon', 'The history of the area can be traced back to 200–300 AD. A ruin of a city built by Chand Sadagar has been found in the Baghmara Forest Block. During the Mughal period, the Mughal Kings leased the forests of the Sundarbans to nearby residents. Many criminals took refuge in the Sundarbans from the advancing armies of Emperor Akbar. Many have been known to be attacked by Tigers[2] Many of the buildings which were built by them later fell to hands of Portuguese pirates, salt smugglers and dacoits in the 17th century. Evidence of the fact can be traced from the ruins at Netidhopani and other places scattered all over Sundarbans', 5000.00, 'SGD', 'none', 0, 0, 1, 1, '2012-06-07 19:30:39', '2012-06-29 10:00:00', 'opened', 0),
(2, 2, 1, 7, 'Freedom', 'In 1911, it was described as a tract of waste country which had never been surveyed, nor had the census been extended to it. It then stretched for about 165 miles (266 km) from the mouth of the Hugli to the mouth of the Meghna river and was bordered inland by the three settled districts of the 24 Parganas, Khulna and Bakerganj. The total area (including water) was estimated at 6,526 square miles (16,902 km2). It was a water-logged jungle, in which tigers and other wild beasts abounded. Attempts at reclamation had not been very successful. The Sundarbans was everywhere intersected by river channels and creeks, some of which afforded water communication throughout the Bengal region both for steamers and for native boats.', 3400.00, 'SGD', '', 0, 0, 1, 1, '2012-06-11 13:27:57', '2012-06-30 10:00:00', 'closed', 0),
(3, 2, 3, 3, 'Public', 'The Sundarban forest lies in the vast delta on the Bay of Bengal formed by the super confluence of the Padma, Brahmaputra and Meghna rivers across southern Bangladesh. The seasonally flooded Sundarbans freshwater swamp forests lie inland from the mangrove forests on the coastal fringe. The forest covers 10,000 km2. of which about 6,000 are in Bangladesh.[7] It became inscribed as a UNESCO world heritage site in 1997. The Sundarbans is estimated to be about 4,110 km², of which about 1,700 km² is occupied by waterbodies in the forms of river, canals and creeks of width varying from a few meters to several kilometers.', 4000.00, 'SGD', 'none', 0, 1, 1, 1, '2012-06-07 20:11:07', '2012-06-12 10:00:00', 'closed', 1),
(4, 2, 3, 7, 'khulna university', 'Khulna University was established at 1991. There are 5 schools and 21 disciplines under these schools. The most promising characteristic of this university is that it is free from student politics. No session jam in academic activities. A big number of professors, associate professors and assisstant professors are working as faculty member of various disciplines. Many national and international research projects are on going. Student accommodation facility is very well. There are two halls for male students and one hall for female students. Library and laboratory facility is also of high quality. Students and stuffs are provided with transport facility. Overall student quality of this university is very satisfying. Graduates of this university are working all over the world with a lot of fame.', 5000.00, 'SGD', 'yes', 0, 1, 1, 1, '2012-06-11 14:16:01', '2012-06-29 10:00:00', 'closed', 0),
(5, 2, 3, 7, 'Dhaka university', 'The University of Dhaka is the oldest university in Bangladesh. It is a multi-disciplinary research university and is among the top universities in the region. Established on July 21, 1921, as per the Government of India Act, 1920, it was modelled on the Universities in England and soon gained prominence. Students and teachers of this university have played a major part in shaping the history of Bangladesh.\n\nFrom its beginning, the University of Dhaka has been a place for many great scholars and scientists. From 1926 to 1945 the renowned physicist Satyendranath Bose served as a professor. It was during this period that he published his famous papers in collaboration with Albert Einstein, most notably defining Bose-Einstein condensate. After independence from the British Empire in 1947 it gained prominence as the leading university in East Pakistan.', 4500.00, 'SGD', 'yes', 1, 0, 1, 1, '2012-06-11 13:19:08', '2012-06-19 10:00:00', 'closed', 0),
(6, 3, 0, 7, 'BUET', 'In 2008, the University of Dhaka has made into the list of ', 4500.00, 'SGD', 'none', 1, 1, 0, 1, '2012-06-07 19:47:31', '2012-06-19 10:00:00', 'opened', 0),
(7, 3, 0, 4, 'Cricket', 'In 2008, the University of Dhaka has made into the list of ', 5000.00, 'SGD', '', 0, 1, 0, 1, '2012-06-11 13:46:33', '2012-06-09 10:00:00', 'expired', 0),
(8, 3, 0, 11, 'Football', 'Football refers to a number of sports that involve, to varying degrees, kicking a ball with the foot to score a goal. The most popular of these sports worldwide is association football, more commonly known as just "football" or "soccer". Unqualified, the word football applies to whichever form of football is the most popular in the regional context in which the word appears.', 5000.00, 'SGD', '', 1, 0, 0, 1, '2012-06-07 19:59:15', '2012-06-21 10:00:00', 'opened', 0),
(9, 3, 1, 11, 'Animation', 'Animation is the rapid display of a sequence of images of 2-D or 3-D artwork or model positions to create an illusion of movement. The effect is an optical illusion of motion due to the phenomenon of persistence of vision, and can be created and demonstrated in several ways. The most common method of presenting animation is as a motion picture or video program, although there are other methods.', 5000.00, 'SGD', '', 0, 0, 0, 1, '2013-08-17 21:33:01', '2012-06-19 10:00:00', 'frozen', 0),
(10, 3, 0, 11, 'New Animation ', 'Georges Méliès was a creator of special-effect films; he was generally one of the first people to use animation with his technique. He discovered a technique by accident which was to stop the camera rolling to change something in the scene, and then continue rolling the film. This idea was later known as stop-motion animation. Méliès discovered this technique accidentally when his camera broke down while shooting a bus driving by. When he had fixed the camera, a hearse happened to be passing by just as Méliès restarted rolling the film, his end result was that he had managed to make a bus transform into a hearse. This was just one of the great contributors to animation in the early years.', 5000.00, 'SGD', '', 0, 1, 0, 1, '2012-06-07 19:53:51', '2012-06-20 10:00:00', 'opened', 0),
(11, 1, 0, 1, 'Web design', 'Various forms of football can be identified in history, often as popular peasant games. Contemporary codes of football can be traced back to the codification of these games at English public schools in the eighteenth and nineteenth century.[2][3] The influence and power of the British Empire allowed these rules of football to spread, including to areas of British influence outside of the directly controlled Empire,[4] though by the end of the nineteenth century, distinct regional codes were already developing: Gaelic Football, for example, deliberately incorporated the rules of local traditional football games in order to maintain their heritage.[5] In 1888, The Football League was founded in England, becoming the first of many professional football competitions. In the twentieth century, the various codes of football have become amongst the most popular team sports in the world.', 3000.00, 'SGD', 'none', 0, 0, 1, 1, '2012-06-07 20:02:12', '2012-06-13 10:00:00', 'opened', 0),
(12, 1, 3, 13, 'Twitter follow', 'There are a number of references to traditional, ancient, or prehistoric ball games, played by indigenous peoples in many different parts of the world. For example, in 1586, men from a ship commanded by an English explorer named John Davis, went ashore to play a form of football with Inuit (Eskimo) people in Greenland.[19] There are later accounts of an Inuit game played on ice, called Aqsaqtuk. Each match began with two teams facing each other in parallel lines, before attempting to kick the ball through each other team''s line and then at a goal. In 1610, William Strachey, a colonist at Jamestown, Virginia recorded a game played by Native Americans, called Pahsaheman.[citation needed] On the Australian continent several tribes of indigenous people played kicking and catching games with stuffed balls which have been generalised by historians.', 5000.00, 'SGD', 'e.g. Extra information required.', 0, 0, 1, 1, '2013-08-17 11:58:39', '2012-06-18 10:00:00', 'closed', 0),
(13, 1, 0, 3, 'Google plus', 'The early forms of football played in England, sometimes referred to as ', 4000.00, 'SGD', 'e.g. Extra information required.', 0, 1, 0, 1, '2012-06-09 17:12:07', '2012-06-30 10:00:00', 'frozen', 0),
(14, 1, 2, 8, 'Facebook vote', '    After lunch all the youth of the city go out into the fields to take part in a ball game. The students of each school have their own ball; the workers from each city craft are also carrying their balls. Older citizens, fathers, and wealthy citizens come on horseback to watch their juniors competing, and to relive their own youth vicariously: you can see their inner passions aroused as they watch the action and get caught up in the fun being had by the carefree adolescents.[27] ', 2000.00, 'SGD', 'e.g. Extra information required.', 0, 0, 1, 1, '2013-08-17 16:38:26', '2012-06-22 10:00:00', 'closed', 1),
(15, 1, 0, 2, 'New Football', 'Football refers to a number of sports that involve, to varying degrees, kicking a ball with the foot to score a goal. The most popular of these sports worldwide is association football, more commonly known as just ', 4500.00, 'SGD', 'e.g. Extra information required.', 0, 0, 0, 1, '2012-06-07 20:28:35', '2012-06-13 10:00:00', 'opened', 0),
(16, 2, 0, 2, 'Facebook account', 'The Sundarbans National Park is a National Park, Tiger Reserve, and a Biosphere Reserve located in the Sundarbans delta in the Indian state of West Bengal. Sundarbans South, East and West are three protected forests in Bangladesh. This region is densely covered by mangrove forests, and is one of the largest reserves for the Bengal tiger.', 4000.00, 'SGD', '', 0, 0, 0, 1, '2012-06-08 19:27:45', '2012-06-29 10:00:00', 'opened', 0),
(17, 1, 0, 7, 'Twitter account', 'The first Forest Management Division to have jurisdiction over the Sundarbans was established in 1869. In 1875 a large portion of the mangrove forests was declared as reserved forests in 1875–76 under the Forest Act, 1865 (Act VIII of 1865). The remaining portions of the forests were declared a reserve forest the following year and the forest, which was so far administered by the civil administration district, was placed under the control of the Forest Department. A Forest Division, which is the basic forest management and administration unit, was created in 1879 with the headquarter in Khulna, Bangladesh. The first management plan was written for the period 1893–98.', 4600.00, 'SGD', 'yes', 0, 1, 1, 1, '2012-06-09 19:48:58', '2012-06-20 10:00:00', 'opened', 0),
(18, 1, 0, 1, 'Web design', 'The first Forest Management Division to have jurisdiction over the Sundarbans was established in 1869. In 1875 a large portion of the mangrove forests was declared as reserved forests in 1875–76 under the Forest Act, 1865 (Act VIII of 1865). The remaining portions of the forests were declared a reserve forest the following year and the forest, which was so far administered by the civil administration district, was placed under the control of the Forest Department. A Forest Division, which is the basic forest management and administration unit, was created in 1879 with the headquarter in Khulna, Bangladesh. The first management plan was written for the period 1893–98.', 3500.00, 'SGD', 'yes', 1, 0, 1, 1, '2012-06-09 19:50:04', '2012-06-22 10:00:00', 'opened', 0),
(19, 23, 29, 1, 'project', 'project', 12.00, 'SGD', 'project', 1, 1, 1, 1, '2012-06-10 20:21:36', '2012-06-10 10:00:00', 'closed', 1),
(20, 23, 29, 3, 'project 2', 'project 2', 12333.00, 'SGD', 'project 2', 1, 1, 0, 1, '2012-06-10 20:26:53', '2012-06-10 10:00:00', 'closed', 1),
(21, 23, 29, 1, 'project 3', 'project 3', 2333333.00, 'SGD', 'project 3', 1, 0, 0, 1, '2012-06-10 20:30:07', '2012-06-10 10:00:00', 'closed', 1),
(22, 23, 29, 1, 'project 4', 'project 4', 12.00, 'SGD', 'project 4', 1, 0, 0, 1, '2012-06-10 20:33:11', '2012-06-10 10:00:00', 'closed', 1),
(23, 23, 0, 7, 'project 5', 'project 5', 12132.00, 'SGD', 'project 5', 1, 1, 0, 1, '2012-06-11 13:46:33', '2012-06-10 10:00:00', 'expired', 0),
(24, 0, 0, 7, 'project 5', 'project 5', 12132.00, 'SGD', 'project 5', 1, 1, 0, 1, '2012-06-10 20:38:12', '2012-06-10 10:00:00', 'opened', 0),
(25, 29, 23, 1, 'project 6', 'project 6', 1222.00, 'SGD', 'project 6', 0, 0, 0, 1, '2012-06-10 20:46:08', '2012-06-10 10:00:00', 'closed', 1),
(26, 29, 23, 2, 'project 7', 'project 7', 123.00, 'SGD', 'project 7', 1, 0, 0, 1, '2012-08-06 21:27:00', '2012-06-10 10:00:00', 'closed', 1),
(27, 2, 0, 12, 'Olympic ', 'The Olympic Games (French: les Jeux olympiques) (JO),[1] is a major international event featuring summer and winter sports, in which thousands of athletes participate in a variety of competitions. The Olympic Games have come to be regarded as the world’s foremost sports competition where more than 200 nations participate.[2] The Games are currently held every two years, with Summer and Winter Olympic Games alternating, although they occur every four years within their respective seasonal games. ', 5000.00, 'SGD', '', 0, 1, 0, 1, '2012-06-11 20:03:26', '2012-06-08 10:00:00', 'expired', 0),
(28, 3, 0, 8, 'Sundarbon1', 'The first Forest Management Division to have jurisdiction over the Sundarbans was established in 1869. In 1875 a large portion of the mangrove forests was declared as reserved forests in 1875–76 under the Forest Act, 1865 (Act VIII of 1865). The remaining portions of the forests were declared a reserve forest the following year and the forest, which was so far administered by the civil administration district, was placed under the control of the Forest Department. A Forest Division, which is the basic forest management and administration unit, was created in 1879 with the headquarter in Khulna, Bangladesh. The first management plan was written for the period 1893–98.', 5000.00, 'SGD', '', 0, 0, 1, 1, '2012-06-12 14:01:54', '2012-06-29 10:00:00', 'opened', 0),
(29, 2, 27, 2, 'Football games', '0', 5000.00, 'SGD', '', 1, 0, 1, 1, '2012-06-22 18:10:09', '2012-06-29 10:00:00', 'closed', 0),
(30, 2, 0, 4, 'Assian cricket', 'Various forms of football can be identified in history, often as popular peasant games. Contemporary codes of football can be traced back to the codification of these games at English public schools in the eighteenth and nineteenth century.[2][3] The influence and power of the British Empire allowed these rules of football to spread, including to areas of British influence outside of the directly controlled Empire,[4] though by the end of the nineteenth century, distinct regional codes were already developing: Gaelic Football, for example, deliberately incorporated the rules of local traditional football games in order to maintain their heritage.[5] In 1888, The Football League was founded in England, becoming the first of many professional football competitions. In the twentieth century, the various codes of football have become amongst the most popular team sports in the world.', 3400.00, 'SGD', '', 0, 1, 1, 1, '2012-06-13 11:05:45', '2012-07-27 10:00:00', 'opened', 0),
(31, 27, 0, 2, 'American football', 'Various forms of football can be identified in history, often as popular peasant games. Contemporary codes of football can be traced back to the codification of these games at English public schools in the eighteenth and nineteenth century.[2][3] The influence and power of the British Empire allowed these rules of football to spread, including to areas of British influence outside of the directly controlled Empire,[4] though by the end of the nineteenth century, distinct regional codes were already developing: Gaelic Football, for example, deliberately incorporated the rules of local traditional football games in order to maintain their heritage.[5] In 1888, The Football League was founded in England, becoming the first of many professional football competitions. In the twentieth century, the various codes of football have become amongst the most popular team sports in the world', 4000.00, 'SGD', '', 1, 0, 1, 1, '2012-06-13 11:37:57', '2015-06-10 10:00:00', 'opened', 0),
(32, 2, 0, 3, 'Assian games', 'The Olympic Games (French: les Jeux olympiques) (JO),[1] is a major international event featuring summer and winter sports, in which thousands of athletes participate in a variety of competitions. The Olympic Games have come to be regarded as the world’s foremost sports competition where more than 200 nations participate.[2] The Games are currently held every two years, with Summer and Winter Olympic Games alternating, although they occur every four years within their respective seasonal games. Originally, the ancient Olympic Games were held in Olympia, Greece, from the 8th century BC to the 4th century AD. Baron Pierre de Coubertin founded the International Olympic Committee (IOC) in 1894. The IOC has since become the governing body of the Olympic Movement, whose structure and actions are defined by the Olympic Charter.', 4500.00, 'SGD', '', 0, 1, 1, 1, '2012-06-13 19:55:34', '2012-09-20 10:00:00', 'opened', 0),
(33, 2, 0, 2, 'games', 'The evolution of the Olympic Movement during the 20th and 21st centuries has resulted in several changes to the Olympic Games. Some of these adjustments include the creation of the Winter Games for ice and winter sports, the Paralympic Games for athletes with a physical disability, and the Youth Olympic Games for teenage athletes. The IOC has had to adapt to the varying economic, political, and technological realities of the 20th century. As a result, the Olympics shifted away from pure amateurism, as envisioned by Coubertin, to allow participation of professional athletes. The growing importance of the mass media created the issue of corporate sponsorship and commercialization of the Games. World Wars led to the cancellation of the 1916, 1940, and 1944 Games. Large boycotts during the Cold War limited participation in the 1980 and 1984 Games.', 4300.00, 'SGD', '', 0, 1, 1, 1, '2012-06-13 19:56:34', '2012-08-30 10:00:00', 'opened', 0),
(34, 2, 0, 8, 'twitter follower1', 'The Olympic Movement consists of international sports federations (IFs), National Olympic Committees (NOCs), and organizing committees for each specific Olympic Games. As the decision-making body, the IOC is responsible for choosing the host city for each Olympic Games. The host city is responsible for organizing and funding a celebration of the Games consistent with the Olympic Charter. The Olympic program, consisting of the sports to be contested at the Games, is also determined by the IOC. The celebration of the Games encompasses many rituals and symbols, such as the Olympic flag and torch, as well as the opening and closing ceremonies. Over 13,000 athletes compete at the Summer and Winter Olympics in 33 different sports and nearly 400 events. The first, second, and third place finishers in each event receive Olympic medals: gold, silver, and bronze, respectively.', 2300.00, 'SGD', '', 0, 0, 1, 1, '2012-06-13 19:57:44', '2012-11-30 11:00:00', 'opened', 0),
(35, 2, 0, 11, 'Managing Hospital', 'The Games have grown in scale to the point that nearly every nation is represented. Such growth has created numerous challenges, including boycotts, doping, bribery of officials, and terrorism. Every two years, the Olympics and its media exposure provide unknown athletes with the chance to attain national, and in particular cases, international fame. The Games also constitute a major opportunity for the host city and country to showcase itself to the world.', 1000.00, 'SGD', '', 0, 1, 1, 1, '2012-06-13 19:58:27', '2012-12-29 11:00:00', 'opened', 0),
(36, 2, 0, 1, 'Job portal', 'The Ancient Olympic Games were a series of competitions held between representatives of several city-states and kingdoms from Ancient Greece, which featured mainly athletic but also combat and chariot racing events. During the Olympic games all struggles against the participating city-states were postponed until the games were finished.[3] The origin of these Olympics is shrouded in mystery and legend.[4] One of the most popular myths identifies Heracles and his father Zeus as the progenitors of the Games.[5][6][7] According to legend, it was Heracles who first called the Games ', 5600.00, 'SGD', '', 0, 0, 1, 1, '2012-06-22 18:52:57', '2012-12-26 11:00:00', 'frozen', 0),
(37, 59, 0, 2, '001a 001a 001a ', '001a 001a 001a 001a 001a 001a 001a 001a 001a 001a 001a 001a 001a 001a 001a 001a 001a 001a 001a 001a 001a 001a ', 12345.00, 'SGD', '001a ', 1, 1, 1, 1, '2012-06-18 21:45:27', '2012-06-18 10:00:00', 'opened', 0),
(38, 45, 0, 2, 'thursday1', 'thursday1thursday1thursday1thursday1', 123.00, 'SGD', 'thursday1', 1, 1, 1, 1, '2012-06-21 13:32:25', '2012-06-21 10:00:00', 'opened', 0),
(39, 23, 0, 2, 'wewew', 'ewewew', 1212.00, 'SGD', '12121', 1, 1, 0, 1, '2012-06-21 19:33:45', '2012-06-28 10:00:00', 'opened', 0),
(40, 14, 0, 9, 'Sundarbons news', 'The Sundarbans National Park is a National Park, Tiger Reserve, and a Biosphere Reserve located in the Sundarbans delta in the Indian state of West Bengal. Sundarbans South, East and West are three protected forests in Bangladesh. This region is densely covered by mangrove forests, and is one of the largest reserves for the Bengal tiger.', 5000.00, 'SGD', 'must ', 0, 0, 1, 1, '2012-06-23 12:25:16', '2012-06-29 10:00:00', 'opened', 0),
(41, 23, 0, 1, 'project 6', 'erere', 1212.00, 'SGD', '001a ', 1, 1, 1, 1, '2012-08-06 21:26:13', '2012-07-24 10:00:00', 'frozen', 0),
(42, 63, 0, 1, 'Testtest', 'testtest', 5000.00, 'SGD', '', 1, 1, 1, 1, '2012-07-25 00:09:13', '2012-07-04 10:00:00', 'opened', 0),
(43, 45, 0, 1, 'project 6', 'project 6 project 6 project 6', 1233.00, 'SGD', 'project 6', 1, 1, 1, 1, '2012-08-06 21:08:31', '2012-08-23 10:00:00', 'opened', 0),
(51, 1, 0, 0, 'project001', 'This is my 001 project for test purpose', 100.00, 'SGD', 'Additional', 1, 1, 1, 1, '2013-08-22 19:02:57', '2013-08-16 00:00:00', 'opened', 0),
(50, 1, 0, 0, 'project001', 'This is my 001 project for test purpose', 100.00, 'SGD', 'Additional', 1, 1, 1, 1, '2013-08-22 19:02:57', '2013-08-16 00:00:00', 'opened', 0),
(49, 1, 0, 0, 'project001', 'This is my 001 project for test purpose', 100.00, 'SGD', 'Additional', 1, 1, 1, 1, '2013-08-22 19:02:57', '2013-08-16 00:00:00', 'opened', 0);

--
-- Dumping data for table `job_project_attachment`
--

INSERT INTO `job_project_attachment` (`project_attachment_id`, `project_id`, `attachment`, `status`, `created_on`) VALUES
(1, 20, 'login.png', 1, '2012-06-10 20:23:04'),
(2, 30, 'campers.jpg', 1, '2012-06-13 11:05:45'),
(3, 31, 'cars.jpg', 1, '2012-06-13 11:37:57'),
(4, 36, 'campers67.jpg', 1, '2012-06-13 19:59:40'),
(5, 37, 'giftin-logo copy.png', 1, '2012-06-18 21:45:27'),
(13, 51, 'qualify54.png', 1, '2013-08-22 23:10:46'),
(12, 50, 'qualify54.png', 1, '2013-08-22 23:07:27'),
(11, 49, 'qualify54.png', 1, '2013-08-22 23:03:48');

--
-- Dumping data for table `job_project_bid`
--

INSERT INTO `job_project_bid` (`project_bid_id`, `project_id`, `BIDDER_user_id`, `bid_amount`, `CurrencyCode`, `time_period`, `status`, `created_on`, `is_assigned`, `accept_decline`) VALUES
(1, 5, 3, 3400.00, '', 5, 1, '2012-06-11 13:19:08', 1, '1'),
(2, 4, 3, 4500.00, '', 5, 1, '2012-06-11 14:16:01', 1, '1'),
(3, 3, 3, 3400.00, '', 10, 1, '2012-06-07 20:08:52', 1, '1'),
(4, 9, 1, 4500.00, '', 4, 1, '2013-08-01 00:38:51', 1, '1'),
(5, 9, 2, 5000.00, '', 4, 1, '2012-06-07 20:07:37', 0, ''),
(6, 13, 3, 2300.00, '', 6, 1, '2012-06-07 20:13:14', 0, ''),
(7, 12, 3, 4900.00, '', 8, 1, '2012-06-11 14:17:28', 1, '1'),
(8, 11, 3, 2300.00, '', 7, 1, '2012-06-07 20:14:31', 0, ''),
(9, 9, 29, 2333.00, '', 6, 1, '2012-06-07 21:02:58', 0, ''),
(10, 14, 53, 122.00, '', 8, 1, '2012-06-08 09:26:48', 0, ''),
(11, 7, 2, 4500.00, '', 5, 1, '2012-06-08 10:52:29', 0, ''),
(12, 8, 2, 2300.00, '', 6, 1, '2012-06-08 10:53:31', 0, ''),
(13, 10, 2, 4300.00, '', 8, 1, '2012-06-08 10:55:26', 0, ''),
(14, 6, 2, 3200.00, '', 3, 1, '2012-06-08 10:56:24', 0, ''),
(15, 13, 2, 3400.00, '', 7, 1, '2012-06-09 17:12:07', 1, ''),
(16, 15, 2, 4000.00, '', 7, 1, '2012-06-08 15:43:28', 0, ''),
(17, 14, 2, 1400.00, '', 6, 1, '2012-06-09 17:14:00', 1, '1'),
(18, 10, 1, 4900.00, '', 4, 1, '2012-06-08 18:44:18', 0, ''),
(19, 5, 1, 4400.00, '', 5, 1, '2012-06-08 18:44:49', 0, ''),
(20, 7, 1, 3400.00, '', 8, 1, '2012-06-08 18:45:14', 0, ''),
(21, 4, 1, 3400.00, '', 12, 1, '2012-06-08 18:45:49', 0, ''),
(22, 6, 1, 4400.00, '', 12, 1, '2012-06-08 18:46:19', 0, ''),
(23, 2, 1, 3000.00, '', 3, 1, '2012-06-11 13:27:57', 1, '1'),
(24, 5, 4, 4000.00, '', 9, 1, '2012-06-09 12:53:06', 0, ''),
(25, 19, 29, 11.00, '', 12, 1, '2012-06-10 20:20:11', 1, '1'),
(26, 20, 29, 12323.00, '', 23, 1, '2012-06-10 20:26:21', 1, '1'),
(27, 21, 29, 23232.00, '', 23232, 1, '2012-06-10 20:29:13', 1, '1'),
(28, 22, 29, 11.00, '', 1, 1, '2012-06-10 20:32:34', 1, '1'),
(29, 25, 23, 122.00, '', 23, 1, '2012-06-10 20:44:54', 1, '1'),
(30, 26, 23, 122.00, '', 3, 1, '2012-06-10 20:50:23', 1, '1'),
(31, 37, 60, 2123.00, '', 4, 1, '2012-06-18 21:48:00', 0, ''),
(32, 28, 60, 1234.00, '', 4, 1, '2012-06-21 13:36:31', 0, ''),
(33, 38, 60, 123.00, '', 23, 1, '2012-06-21 13:37:00', 0, ''),
(34, 38, 23, 12.00, '', 12, 1, '2012-06-21 13:44:13', 0, ''),
(35, 6, 23, 1233.00, '', 3, 1, '2012-06-21 13:44:46', 0, ''),
(36, 36, 23, 1234.00, '', 1234, 1, '2012-06-21 13:45:17', 0, ''),
(37, 35, 27, 1000.00, '', 5, 1, '2012-06-22 18:00:16', 0, ''),
(38, 29, 27, 5000.00, '', 2, 1, '2012-06-22 18:10:09', 1, '1'),
(39, 36, 27, 5000.00, '', 3, 1, '2012-06-22 18:52:57', 1, ''),
(40, 17, 63, 3000.00, '', 4, 1, '2013-07-27 12:10:52', 1, ''),
(41, 41, 63, 1100.00, '', 1, 1, '2012-08-06 21:26:13', 1, ''),
(42, 42, 45, 1233.00, '', 3, 1, '2013-07-27 10:36:33', 1, ''),
(43, 42, 23, 11.00, '', 3, 1, '2013-07-27 10:36:43', 1, '');

--
-- Dumping data for table `job_project_bid_attach`
--

INSERT INTO `job_project_bid_attach` (`project_bid_attach_id`, `project_id`, `BIDDER_user_id`, `attachment`, `status`, `created_on`) VALUES
(1, 9, 29, 'brands.gif', 1, '2012-06-07 21:02:58'),
(2, 14, 53, 'Screen Shot 2012-04-10 at 10.59.19 PM.png', 1, '2012-06-08 09:26:48'),
(3, 19, 29, 'sensing_by_garrit.jpg', 1, '2012-06-10 20:17:28'),
(4, 20, 29, '523502_10151790634790117_14247407_n.jpg', 1, '2012-06-10 20:24:11'),
(5, 26, 23, 'awesomeness1600120031.jpg', 1, '2012-06-10 20:49:29'),
(6, 37, 60, 'truMarine_logo3.gif', 1, '2012-06-18 21:48:00');

--
-- Dumping data for table `job_project_requirment`
--


--
-- Dumping data for table `job_temporary_project`
--

INSERT INTO `job_temporary_project` (`project_id`, `user_id`, `assigned_user_id`, `project_category_id`, `project_title`, `project_description`, `cost`, `CurrencyCode`, `additional_remarks`, `meet_up_required`, `milestone_payments`, `require_portfolio`, `status`, `created_on`, `bid_ending_date`, `project_status`, `archive_status`) VALUES
(1, 1, 0, 0, 'asdasd asda', 'fghfgh fghfgh', 45345.00, 'USD', 'fgdgf', 1, 1, 1, 1, '2013-08-20 09:28:27', '2013-08-23 00:00:00', 'opened', 0),
(2, 1, 0, 0, 'gfdfgdf', 'asdsad sdfsdf', 4353.00, 'USD', 'fgdg', 1, 1, 1, 1, '2013-08-20 09:41:20', '2013-08-23 00:00:00', 'opened', 0),
(3, 1, 0, 0, 'gfdgdfgdfg', 'sdfsdfsd sfsdfsdf', 555.00, 'USD', 'gdgdfgdg', 1, 1, 1, 1, '2013-08-20 10:05:00', '2013-08-24 00:00:00', 'opened', 0),
(4, 1, 0, 0, 'dfgdfgdfg', 'dfgdfgfdg dfgdfgdfg', 555.00, 'USD', 'fghfh', 1, 0, 1, 1, '2013-08-20 10:06:52', '2013-08-31 00:00:00', 'opened', 0),
(5, 1, 0, 0, 'proj002', 'asdasd asdasd adasd', 450.00, 'USD', 'fsdfsf dfsdfsf', 1, 1, 0, 1, '2013-08-22 08:55:35', '2013-08-15 00:00:00', 'opened', 0),
(6, 1, 0, 0, 'proj003', 'sdfsdf sfdsdf sfsdf', 450.00, 'USD', 'dsfsdfsdf', 1, 1, 1, 1, '2013-08-22 09:35:42', '2013-08-22 00:00:00', 'opened', 0),
(7, 1, 0, 0, 'project001', 'This is my 001 project for test purpose', 100.00, 'SGD', 'Additional', 1, 1, 1, 1, '2013-08-22 19:02:57', '2013-08-16 00:00:00', 'opened', 0),
(8, 1, 0, 1, 'project002', 'Test project 002', 350.00, 'USD', 'no', 1, 0, 1, 1, '2013-09-04 19:17:22', '2013-08-15 00:00:00', 'opened', 0),
(9, 1, 0, 1, 'project002', 'Test project 002', 350.00, 'USD', 'no', 1, 0, 1, 1, '2013-09-04 19:18:20', '2013-08-15 00:00:00', 'opened', 0),
(10, 1, 0, 1, 'project002', 'Test project 002', 350.00, 'USD', 'no', 1, 0, 1, 1, '2013-09-04 19:21:12', '2013-08-15 00:00:00', 'opened', 0);

--
-- Dumping data for table `job_temporary_project_attachment`
--

INSERT INTO `job_temporary_project_attachment` (`project_attachment_id`, `project_id`, `attachment`, `status`, `created_on`) VALUES
(1, 1, 'qualify29.png', 1, '2013-08-20 13:25:05'),
(2, 1, 'qualify24.png', 1, '2013-08-20 13:28:27'),
(3, 2, 'qualify83.png', 1, '2013-08-20 13:41:20'),
(4, 3, 'qualify27.png', 1, '2013-08-20 14:05:00'),
(5, 4, 'qualify14.png', 1, '2013-08-20 14:06:52'),
(6, 5, 'qualify57.png', 1, '2013-08-22 12:55:35'),
(7, 6, 'qualify19.png', 1, '2013-08-22 13:35:42'),
(8, 7, 'qualify54.png', 1, '2013-08-22 23:02:57'),
(9, 8, 'SPM - 15 points or above33.PNG', 1, '2013-09-04 23:17:22'),
(10, 9, 'SPM - 15 points or above33.PNG', 1, '2013-09-04 23:18:20'),
(11, 10, 'SPM - 15 points or above33.PNG', 1, '2013-09-04 23:21:13');

--
-- Dumping data for table `job_testimonials`
--

INSERT INTO `job_testimonials` (`testimonials_id`, `project_id`, `client_id`, `user_id`, `testimonials`, `status`, `created_on`) VALUES
(3, 0, 3, 1, 'Thank you very much for your cooperation. Hope we will work together in the near future. One', 1, '2012-05-05 22:41:48'),
(4, 0, 2, 1, 'Thank you very much for your cooperation. Hope we will work together in the near future. Two', 1, '2012-05-05 22:41:57'),
(5, 0, 4, 1, 'Thank you very much for your cooperation. Hope we will work together in the near future. Three', 1, '2012-05-05 22:42:04'),
(6, 0, 2, 1, 'Thank you very much for your cooperation. Hope we will work together in the near future. Four', 1, '2012-05-05 22:42:10');

--
-- Dumping data for table `job_user`
--

INSERT INTO `job_user` (`user_id`, `username`, `full_name`, `profile_image`, `cover_image`, `email`, `country`, `state`, `city`, `contact_no`, `primary_category_id`, `company`, `NRIC_ROC_number`, `membership_id`, `password`, `last_login`, `created_on`, `status`, `activation_code`, `forget_password`, `type`, `is_featured`, `is_premium`, `subscription_start_date`, `subscr_id`, `user_fb_id`, `twitter_uid`, `twitter_username`, `twitter_screen_name`) VALUES
(1, 'mainul', 'Mainul Islam', 'invite31.PNG', 'Hydrangeas.jpg', 'abc@def.com', 'BD', NULL, 'Dhaka', '123456789', 2, 'Webzone', '123456780', 2, 'e10adc3949ba59abbe56e057f20f883e', '2013-09-07 20:33:36', '2012-04-27 10:54:35', 1, NULL, 'MTIzNDU2', 'contractor', 1, 1, NULL, '', NULL, NULL, NULL, NULL),
(2, 'shyamku07', 'shyam 123', 'flower75.jpg', '', 'shyamku07@gmail.com', 'BD', '', 'Dhaka', '01746754774', 7, 'webzone', '11', 2, 'e10adc3949ba59abbe56e057f20f883e', '2013-07-01 02:43:01', '2012-04-27 11:29:10', 1, NULL, 'MTIzNDU2', 'contractor', 1, 0, '0000-00-00 00:00:00', '', NULL, NULL, NULL, NULL),
(3, 'safiqul', 'Safiqul Islam', '989364.jpg', '', 'shyambd07@gmail.com', 'US', 'Arkansas', 'Arkansas', '1234', 1, 'KZ', '1234', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-06-23 02:17:42', '2012-04-27 11:09:52', 1, NULL, 'MTIzNDU2', 'contractor', 1, 1, NULL, '', NULL, NULL, NULL, NULL),
(4, 'mahmud', 'Mahmudul Hasan', '1335539539_Blue hills.jpg', '', 'mahmudul@gmail.com', 'BD', '', 'Dhaka', '1234', 2, 'Self', '1234', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-06-09 02:50:36', '2012-04-27 11:12:19', 1, NULL, 'MTIzNDU2', 'contractor', 1, 0, NULL, '', NULL, NULL, NULL, NULL),
(5, 'Shyambd07', 'Shyam ghosh', '1335622272_9893.jpg', '', 'shyambd07@gmail.com', 'BD', '', 'Dhaka', '2234545345', 1, 'webzone', '2332', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-06-07 03:14:42', '0000-00-00 00:00:00', 1, NULL, 'MTIzNDU2', 'contractor', 1, 0, NULL, '', NULL, NULL, NULL, NULL),
(7, 'mahmudul', 'Mahmudul Hasan', '1335947052_Sunset.jpg', '', 'mahmud@gmail.com', 'BD', '', 'Gazipur', '111', 2, '111', '111', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-06-06 01:05:42', '0000-00-00 00:00:00', 1, NULL, 'MTIzNDU2', 'contractor', 1, 1, NULL, '', NULL, NULL, NULL, NULL),
(8, 'ziaul', 'Ziaul Islam', '1335947015_Water lilies.jpg', '', 'ziaul@gmail.com', 'BD', '', 'Dhaka', '111', 4, '111', '111', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-05-11 06:00:45', '0000-00-00 00:00:00', 1, NULL, 'MTIzNDU2', 'contractor', 1, 1, NULL, '', NULL, NULL, NULL, NULL),
(9, 'matheus', 'Matheus', '1335947116_Winter.jpg', '', 'matheus@gmail.com', 'AZ', '', 'Azerbaijan', '11', 2, '1', '1', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-06-06 01:47:57', '0000-00-00 00:00:00', 1, NULL, 'MTIzNDU2', 'contractor', 1, 1, NULL, '', NULL, NULL, NULL, NULL),
(10, 'zakaria', 'Zakaria', '1335946925_Winter.jpg', '', 'zakaria@gmail.com', 'AL', '', 'Albania', '111', 2, '111', '111', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-06-06 01:54:33', '0000-00-00 00:00:00', 1, NULL, 'MTIzNDU2', 'contractor', 1, 1, NULL, '', NULL, NULL, NULL, NULL),
(11, 'mozammel', 'Mozammel Haque', '1335946971_Blue hills.jpg', '', 'mozammel@gmail.com', 'AQ', '', 'Antarctica', '11', 2, '11', '1111', 0, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL, 'MTIzNDU2', 'contractor', 1, 1, NULL, '', NULL, NULL, NULL, NULL),
(12, 'Zaman vai', 'dsdsds', '1335968821_flower.jpg', '', 'zaman@localhost.com', 'US', 'Kansas', 'ssas', '4354534534', 3, 'webzone', '43445', 0, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL, 'MTIzNDU2', 'contractor', 1, 0, NULL, '', NULL, NULL, NULL, NULL),
(14, 'zaman', 'kamrul zaman', 'Penguins.jpg', '', 'kamrulzuiu@gmail.com', 'BD', '', 'Dhaka', '12345678', 4, 'webzone', '123456789', 2, 'e10adc3949ba59abbe56e057f20f883e', '2012-06-23 02:21:38', '2012-05-04 05:54:13', 1, NULL, 'MTIzNDU2', 'contractor', 1, 1, '2012-05-04 05:54:57', '', NULL, NULL, NULL, NULL),
(15, 'akmmi', 'Mainul Islam', '1336125254_Winter.jpg', '', 'akmmi2@yahoo.com', 'AM', '', 'Armenia', '1', 3, '111', '111', 0, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL, 'MTIzNDU2', 'contractor', 1, 0, NULL, '', NULL, NULL, NULL, NULL),
(16, 'mainul_1', 'Mainul One', '', '', 'mainul_one@gmail.com', 'US', 'Arizona', 'Arizona', '11', 3, '111', '111', 2, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-05-04 05:56:49', 1, NULL, 'MTIzNDU2', 'contractor', 1, 0, NULL, '', NULL, NULL, NULL, NULL),
(17, 'mainul_two', 'Mainul Two', 'flower63.jpg', '', 'mainul_two@gmail.com', 'BD', '', 'Dhaka', '123456', 2, 'Webzone', '123456', 2, 'e10adc3949ba59abbe56e057f20f883e', '2012-05-17 10:06:55', '2012-05-04 06:22:34', 1, NULL, 'MTIzNDU2', 'contractor', 1, 1, '2012-05-04 06:28:29', '', NULL, NULL, NULL, NULL),
(18, 'ttttt', 'kamrul zaman', '', '', 'riyadh@discountat.co', 'CA', 'New Brunswick', 'zaman', '12345678', 3, 'webzone', '123456789', 2, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-05-04 06:27:24', 1, NULL, 'MTIzNDU2', 'contractor', 1, 0, '2012-05-04 06:28:05', '', NULL, NULL, NULL, NULL),
(23, 'blackboxes', 'Chris Lim', '543334_10150957492481131_610661130_12283933_1842910591_n.jpg', '283671_10151035930891131_1424871979_n.jpeg', 'boxesblack@gmail.com', 'SG', '', 'Singapore', '91090929', 3, 'Skylark Consultants', 'nric', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-08-06 11:24:28', '2012-05-07 01:14:09', 1, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(22, 'mainulx', 'Mainul Twitter', '1336314730_Water lilies.jpg', '', 'mainulx@gmail.com', NULL, NULL, NULL, '1111', 1, '', '', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-05-06 10:34:30', '2012-05-06 10:31:33', 1, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, 570747424, 'Mainul Islam', NULL),
(31, 'Anishur', 'Anisur Rahaman', '', '', 'anisur@gmail.com', 'BD', '', 'Dhaka', '01746754774', 3, 'Webzone Technology', '3432FD', 2, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-05-31 08:47:56', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(25, 'actsofsinners', 'Chris Lim', '', '', 'actsofsinners@yahoo.com', 'SG', '', 'Singapore', '91090929', 1, 'Skylark Consultants', '2323232', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-05-14 05:51:08', '2012-05-14 04:50:00', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(26, 'model', 'model', '', '', 'chris@skylark.com.sg', 'SG', '', 'model', 'model', 1, 'model', 'model', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-05-14 05:51:38', '2012-05-14 05:03:33', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(27, 'rana', 'rana', 'bird4382.jpg', '', 'rana@gmail.com', 'AW', '', 'e.g. London', '3434343', 3, 'e.g. 3lance Holdings Pte Ltd', 'e.g. S801234D', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-06-22 07:16:06', '2012-05-17 08:22:05', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(28, 'skylark', 'skylark', 'product_thumb.jpg', '', 'chris@avantgarden.com.sg', 'SG', '', 'Singapore', '91090929', 1, 'Skylark Consultants', '12121', 2, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-05-20 02:57:06', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(29, 'skylark2', 'skylark2', 'product_thumb15.jpg', '', 'chrissie.lim@facebook.com', 'SG', NULL, 'Singapore', '91090929', 3, 'Skylark Consultants', '12121', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-06-11 04:15:19', '2012-05-20 02:58:42', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(30, 'chrislim', 'chris lim', 'meat.jpg', '', 'chris.lim@skylark.com.sg', 'SG', '', 'singapore', '91090929', 1, 'Skylark Consultants', 'S8214938D', 0, 'e10adc3949ba59abbe56e057f20f883e', '2012-06-01 23:14:13', '2012-05-30 01:27:50', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(32, 'dipto', 'dipto ', 'show-some-love-glitter-pictures-017.jpg', '', 'dipto@gmail.com', 'BM', '', 'Dhaka', '01746754774', 1, 'Webzone Technology', '353FG', 2, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-05-31 09:20:06', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(33, 'Saikat', 'Saikat', '', '', 'Saikat@gmail.com', 'BY', '', 'Dkaha', '435345', 1, 'wee', '43', 2, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-05-31 09:24:16', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(34, 'Aminul', 'Aminul', 'Tulips.jpg', '', 'Aminul@gmil.com', 'CA', 'Alberta', 'Alberta', '5456443', 9, 'derty', '224DF', 2, 'e10adc3949ba59abbe56e057f20f883e', '2012-05-31 09:57:55', '2012-05-31 09:30:41', 0, NULL, 'MTIzNDU2', 'contractor', 0, 1, '2012-05-31 09:33:07', '', NULL, NULL, NULL, NULL),
(35, 'Faisal', 'Faisal', '989381.jpg', '', 'shyamku071@gmail.com', 'AW', '', 'Dhaka', '23542341', 1, 'webzone', '11', 0, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-06-01 07:38:57', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(36, 'yyyyyyyyy', 'uuuuu', '', '', 'iiiiii@yahoo.som', 'AR', '', 'wwwww', 'ttttt', 1, 'tttt', 'hhhhh', 2, '25d55ad283aa400af464c76d713c07ad', '0000-00-00 00:00:00', '2012-06-02 09:11:53', 0, NULL, 'MTIzNDU2Nzg=', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(37, 'dfgsdgd', 'dfgsdfg', '', '', 'dfgsdfgs@yahoo.com', 'CA', 'New Brunswick', 'dfgvdfgvsd', 'rfgaer', 4, 'gasdr', 'rdfgae', 2, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-06-02 09:18:08', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(38, 'ffff', 'gggg', '', '', 'kamiu@gmail.com', 'GB', '', 'rrrr', '333', 1, 'rr', 'fff', 2, '25d55ad283aa400af464c76d713c07ad', '0000-00-00 00:00:00', '2012-06-02 09:49:19', 0, NULL, 'MTIzNDU2Nzg=', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(39, 'yyyyyyuu', 'hhh', '', '', 'add@mail.com', 'AW', '', 'affff@mail.com', '555555', 9, '555555', 'ttttt', 2, '25d55ad283aa400af464c76d713c07ad', '0000-00-00 00:00:00', '2012-06-04 01:55:47', 0, NULL, 'MTIzNDU2Nzg=', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(40, 'ttt', 'yyy', '', '', 'yyyd@mail.com', 'AR', '', 'yyya@mail.com', 'ffgsrf', 3, 'dfgvsdfgs', 'sdfsfs', 2, '25d55ad283aa400af464c76d713c07ad', '0000-00-00 00:00:00', '2012-06-04 02:08:21', 0, NULL, 'MTIzNDU2Nzg=', 'contractor', 0, 1, '2013-06-03 06:08:57', 'I-DULPA2VWP7KM', NULL, NULL, NULL, NULL),
(41, 'cghdfghs', 'rfhsrt', '', '', 'kayhtyhtzuiu@gmail.com', 'US', 'Arizona', 'ftghrtghrta@mail.com', 'rertferferwre', 3, 'sdcfsdfce', 'sdfcsaedfwe', 2, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-06-04 02:16:57', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(42, 'Shohag', 'Shohag', '', '', 'Shohag@gmail.com', 'AT', '', 'Dhaka', '01746754774', 3, 'webzone', '32321', 0, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-06-04 02:17:00', 0, NULL, 'MTIzNDU2', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(43, 'tttttteeee', 'ttttt', '', '', 'tttta@mail.com', 'US', 'Arkansas', 'yyyya@mail.com', 'ttttt', 7, '555555', 'dddd', 2, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-06-04 02:46:24', 0, NULL, 'MTIzNDU2', 'contractor', 0, 1, '2012-06-04 02:47:28', '', NULL, NULL, NULL, NULL),
(44, 'Dipu', 'Dipu', '989370.jpg', '', 'Dipu@gmail.com', 'BT', '', 'Dhaka', '0190740323432', 7, 'webzone', 'errdf4FD', 2, 'e10adc3949ba59abbe56e057f20f883e', '2012-06-04 09:53:07', '2012-06-04 07:45:00', 0, NULL, 'MTIzNDU2', 'contractor', 0, 1, '2012-06-04 07:46:43', '', NULL, NULL, NULL, NULL),
(45, 'test1', 'test1', 'awesomeness16001200.jpg', '', 'test1@webfeature.sg', 'SG', '', 'Singapore', '91090929', 3, 'webfeature', 's9212323', 2, '803efb3144081b2142a1b62fdaad6831', '2012-08-06 11:00:56', '2012-06-04 11:33:24', 0, NULL, 'bGVvbmhhcnQ=', 'contractor', 0, 0, '0000-00-00 00:00:00', '', NULL, NULL, NULL, NULL),
(46, 'test2', 'test2', 'SYMBIOSIS_2_0_by_elpinoy32.jpg', '', 'test2@webfeature.sg', 'SG', '', 'singapore', '2323', 1, 'test2', 'test2', 0, '803efb3144081b2142a1b62fdaad6831', '2012-06-04 11:57:00', '2012-06-04 11:56:22', 0, NULL, 'bGVvbmhhcnQ=', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(54, 'rasel07', 'Rasel', 'Tulips49.jpg', '', 'rasel07@gmail.com', 'AW', '', 'Dhaka', '01746754774', 1, '', '', 2, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-06-08 01:20:30', 0, NULL, 'MTIzNDU2', 'contractor', 0, 1, '2012-06-08 01:22:27', '', NULL, NULL, NULL, NULL),
(53, 'nonoriri', 'your mum', '', '', 'tsubasa1983@gmail.com', 'AQ', '', '', '99912345', 2, 'fail corp', '', 2, '2fc01ec765ec0cb3dcc559126de20b30', '2012-06-07 23:25:51', '2012-06-07 23:23:57', 0, NULL, 'c3F1YXJl', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(55, 'Josim', 'Josim uddin', '989317.jpg', '', 'jasim@gmail.com', 'AU', '', 'Dhaka', '01746754774', 3, '', '', 2, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2012-06-11 09:07:46', 0, NULL, 'MTIzNDU2', 'contractor', 0, 1, '2012-06-11 09:10:39', '', NULL, NULL, NULL, NULL),
(56, 'Arafat', 'arafat hossain', '', '', 'arafat@gmail.com', 'US', 'Alabama', 'dhaka', '34423423', 1, 'Webzone', '123456DS', 2, '14e1b600b1fd579f47433b88e8d85291', '0000-00-00 00:00:00', '2012-06-12 05:52:55', 0, NULL, 'ZTEwYWRjMzk0OWJhNTlhYmJlNTZlMDU3ZjIwZjg4M2U=', 'contractor', 0, 1, '2012-06-12 05:55:02', '', NULL, NULL, NULL, NULL),
(57, 'kanok', 'kanok', '', '', 'kanokcseku@gmail.com', 'BD', '', 'Dhaka', '34423423', 1, 'Webzone Technology', '4fdffd', 2, '14e1b600b1fd579f47433b88e8d85291', '2012-06-13 03:16:52', '2012-06-13 03:07:55', 0, NULL, 'ZTEwYWRjMzk0OWJhNTlhYmJlNTZlMDU3ZjIwZjg4M2U=', 'contractor', 0, 0, '0000-00-00 00:00:00', '', NULL, NULL, NULL, NULL),
(58, 'jun18', 'jun18', 'giftin-logo copy.png', '', 'jun18@webfeature.sg', 'SG', '', 'Singapore', '91090929', 1, 'jun18', 'jun18', 2, '1dcaeb94a24932ce1a380a0596a92a29', '0000-00-00 00:00:00', '2012-06-18 11:26:53', 0, NULL, 'ODAzZWZiMzE0NDA4MWIyMTQyYTFiNjJmZGFhZDY4MzE=', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(59, '001', '001', 'chaithai01.jpg', '', '001@webfeature.sg', 'SG', '', '001', '001', 3, '001', '001', 0, '1dcaeb94a24932ce1a380a0596a92a29', '2012-06-21 03:21:10', '2012-06-18 11:34:04', 0, NULL, 'ODAzZWZiMzE0NDA4MWIyMTQyYTFiNjJmZGFhZDY4MzE=', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(60, '002', '002', 'lifebanner1-01.jpg', '', '002@webfeature.sg', 'SG', '', 'Singapore', '91090929', 1, '002', '002', 0, '1dcaeb94a24932ce1a380a0596a92a29', '2012-06-21 03:24:24', '2012-06-18 11:34:58', 1, NULL, 'ODAzZWZiMzE0NDA4MWIyMTQyYTFiNjJmZGFhZDY4MzE=', 'contractor', 0, 1, NULL, '', NULL, NULL, NULL, NULL),
(61, 'moonpapa', 'Daniel Wilson', '', '', 'realdanwilson@gmail.com', 'GB', '', 'Leeds', '07546742665', 8, '', '', 0, '94174996b6d8f17696cd599746e3b1fb', '2012-07-02 02:49:46', '2012-07-02 02:49:23', 0, NULL, 'ZmEyNzVkMDA5ZTU3YWViOWJhZjA2ZTc2YWE0YjI1NjU=', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(62, 'Kamruz Zaman', NULL, NULL, '', 'kamrulzuiu@gmail.com', NULL, NULL, NULL, '', 0, '', '', 0, '', '2012-07-04 05:45:15', '2012-07-04 05:45:15', 1, NULL, NULL, 'contractor', 0, 0, NULL, '', 1458472007, NULL, NULL, NULL),
(63, 'butterandbutter', 'JJ', 'thumb0173.jpg', 'img_1726sm.jpg', 'jjtan83@gmail.com', 'SG', '', 'singapore', '81349491', 11, '', '', 0, '82af72c417601af20ce6c3189c75e16d', '2012-07-25 10:40:57', '2012-07-10 10:54:12', 0, NULL, 'NjU5OTVjOGZkMGQwMmFjM2UxYzE5Nzk5YThiOGFkOTk=', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(64, 'shoeb240', 'Shoeb Abdullah', '', '', 'shoeb240@gmail.com', 'BD', '', 'Dhaka', '01714074106', 8, 'eBizz', '', 0, '14e1b600b1fd579f47433b88e8d85291', '2013-07-27 10:31:40', '2013-07-22 18:35:44', 0, NULL, 'ZTEwYWRjMzk0OWJhNTlhYmJlNTZlMDU3ZjIwZjg4M2U=', 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(65, 'shoeb001', 'Sohel Mahmud', '', '', 'shoeb001@gmail.com', 'BD', 'Chittagong', 'Ctg', '123456', 1, 'eBizzSol', 'S123456', 0, '123456', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, NULL, NULL, 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL),
(66, 'shoeb002', 'Sohel Ahmed', '', '', 'shoeb002@gmail.com', 'BD', 'Chittagong', 'Dhk', '123456', 8, 'Blueliner', 'S123456', 0, 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, NULL, NULL, 'contractor', 0, 0, NULL, '', NULL, NULL, NULL, NULL);
