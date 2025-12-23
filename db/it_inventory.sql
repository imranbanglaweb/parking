-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 12, 2020 at 06:43 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `it_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `table_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_id` int(11) NOT NULL,
  `operation` enum('insert','update','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'insert',
  `operated_by` int(11) NOT NULL,
  `operated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `api_password_resets`
--

DROP TABLE IF EXISTS `api_password_resets`;
CREATE TABLE IF NOT EXISTS `api_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apr_username_index` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `apps_countries`
--

DROP TABLE IF EXISTS `apps_countries`;
CREATE TABLE IF NOT EXISTS `apps_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_enName` varchar(100) NOT NULL DEFAULT '',
  `country_arName` varchar(100) NOT NULL DEFAULT '',
  `country_enNationality` varchar(100) NOT NULL DEFAULT '',
  `country_arNationality` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_enName` varchar(100) NOT NULL DEFAULT '',
  `country_arName` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `country_arNationality` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_enName`, `country_arName`, `name`, `country_arNationality`) VALUES
(1, 'AF', 'Afghanistan', 'أفغانستان', 'Afghan', 'أفغانستاني'),
(2, 'AL', 'Albania', 'ألبانيا', 'Albanian', 'ألباني'),
(3, 'AX', 'Aland Islands', 'جزر آلاند', 'Aland Islander', 'آلاندي'),
(4, 'DZ', 'Algeria', 'الجزائر', 'Algerian', 'جزائري'),
(5, 'AS', 'American Samoa', 'ساموا-الأمريكي', 'American Samoan', 'أمريكي سامواني'),
(6, 'AD', 'Andorra', 'أندورا', 'Andorran', 'أندوري'),
(7, 'AO', 'Angola', 'أنغولا', 'Angolan', 'أنقولي'),
(8, 'AI', 'Anguilla', 'أنغويلا', 'Anguillan', 'أنغويلي'),
(9, 'AQ', 'Antarctica', 'أنتاركتيكا', 'Antarctican', 'أنتاركتيكي'),
(10, 'AG', 'Antigua and Barbuda', 'أنتيغوا وبربودا', 'Antiguan', 'بربودي'),
(11, 'AR', 'Argentina', 'الأرجنتين', 'Argentinian', 'أرجنتيني'),
(12, 'AM', 'Armenia', 'أرمينيا', 'Armenian', 'أرميني'),
(13, 'AW', 'Aruba', 'أروبه', 'Aruban', 'أوروبهيني'),
(14, 'AU', 'Australia', 'أستراليا', 'Australian', 'أسترالي'),
(15, 'AT', 'Austria', 'النمسا', 'Austrian', 'نمساوي'),
(16, 'AZ', 'Azerbaijan', 'أذربيجان', 'Azerbaijani', 'أذربيجاني'),
(17, 'BS', 'Bahamas', 'الباهاماس', 'Bahamian', 'باهاميسي'),
(18, 'BH', 'Bahrain', 'البحرين', 'Bahraini', 'بحريني'),
(19, 'BD', 'Bangladesh', 'بنغلاديش', 'Bangladeshi', 'بنغلاديشي'),
(20, 'BB', 'Barbados', 'بربادوس', 'Barbadian', 'بربادوسي'),
(21, 'BY', 'Belarus', 'روسيا البيضاء', 'Belarusian', 'روسي'),
(22, 'BE', 'Belgium', 'بلجيكا', 'Belgian', 'بلجيكي'),
(23, 'BZ', 'Belize', 'بيليز', 'Belizean', 'بيليزي'),
(24, 'BJ', 'Benin', 'بنين', 'Beninese', 'بنيني'),
(25, 'BL', 'Saint Barthelemy', 'سان بارتيلمي', 'Saint Barthelmian', 'سان بارتيلمي'),
(26, 'BM', 'Bermuda', 'جزر برمودا', 'Bermudan', 'برمودي'),
(27, 'BT', 'Bhutan', 'بوتان', 'Bhutanese', 'بوتاني'),
(28, 'BO', 'Bolivia', 'بوليفيا', 'Bolivian', 'بوليفي'),
(29, 'BA', 'Bosnia and Herzegovina', 'البوسنة و الهرسك', 'Bosnian / Herzegovinian', 'بوسني/هرسكي'),
(30, 'BW', 'Botswana', 'بوتسوانا', 'Botswanan', 'بوتسواني'),
(31, 'BV', 'Bouvet Island', 'جزيرة بوفيه', 'Bouvetian', 'بوفيهي'),
(32, 'BR', 'Brazil', 'البرازيل', 'Brazilian', 'برازيلي'),
(33, 'IO', 'British Indian Ocean Territory', 'إقليم المحيط الهندي البريطاني', 'British Indian Ocean Territory', 'إقليم المحيط الهندي البريطاني'),
(34, 'BN', 'Brunei Darussalam', 'بروني', 'Bruneian', 'بروني'),
(35, 'BG', 'Bulgaria', 'بلغاريا', 'Bulgarian', 'بلغاري'),
(36, 'BF', 'Burkina Faso', 'بوركينا فاسو', 'Burkinabe', 'بوركيني'),
(37, 'BI', 'Burundi', 'بوروندي', 'Burundian', 'بورونيدي'),
(38, 'KH', 'Cambodia', 'كمبوديا', 'Cambodian', 'كمبودي'),
(39, 'CM', 'Cameroon', 'كاميرون', 'Cameroonian', 'كاميروني'),
(40, 'CA', 'Canada', 'كندا', 'Canadian', 'كندي'),
(41, 'CV', 'Cape Verde', 'الرأس الأخضر', 'Cape Verdean', 'الرأس الأخضر'),
(42, 'KY', 'Cayman Islands', 'جزر كايمان', 'Caymanian', 'كايماني'),
(43, 'CF', 'Central African Republic', 'جمهورية أفريقيا الوسطى', 'Central African', 'أفريقي'),
(44, 'TD', 'Chad', 'تشاد', 'Chadian', 'تشادي'),
(45, 'CL', 'Chile', 'شيلي', 'Chilean', 'شيلي'),
(46, 'CN', 'China', 'الصين', 'Chinese', 'صيني'),
(47, 'CX', 'Christmas Island', 'جزيرة عيد الميلاد', 'Christmas Islander', 'جزيرة عيد الميلاد'),
(48, 'CC', 'Cocos (Keeling) Islands', 'جزر كوكوس', 'Cocos Islander', 'جزر كوكوس'),
(49, 'CO', 'Colombia', 'كولومبيا', 'Colombian', 'كولومبي'),
(50, 'KM', 'Comoros', 'جزر القمر', 'Comorian', 'جزر القمر'),
(51, 'CG', 'Congo', 'الكونغو', 'Congolese', 'كونغي'),
(52, 'CK', 'Cook Islands', 'جزر كوك', 'Cook Islander', 'جزر كوك'),
(53, 'CR', 'Costa Rica', 'كوستاريكا', 'Costa Rican', 'كوستاريكي'),
(54, 'HR', 'Croatia', 'كرواتيا', 'Croatian', 'كوراتي'),
(55, 'CU', 'Cuba', 'كوبا', 'Cuban', 'كوبي'),
(56, 'CY', 'Cyprus', 'قبرص', 'Cypriot', 'قبرصي'),
(57, 'CW', 'Curaçao', 'كوراساو', 'Curacian', 'كوراساوي'),
(58, 'CZ', 'Czech Republic', 'الجمهورية التشيكية', 'Czech', 'تشيكي'),
(59, 'DK', 'Denmark', 'الدانمارك', 'Danish', 'دنماركي'),
(60, 'DJ', 'Djibouti', 'جيبوتي', 'Djiboutian', 'جيبوتي'),
(61, 'DM', 'Dominica', 'دومينيكا', 'Dominican', 'دومينيكي'),
(62, 'DO', 'Dominican Republic', 'الجمهورية الدومينيكية', 'Dominican', 'دومينيكي'),
(63, 'EC', 'Ecuador', 'إكوادور', 'Ecuadorian', 'إكوادوري'),
(64, 'EG', 'Egypt', 'مصر', 'Egyptian', 'مصري'),
(65, 'SV', 'El Salvador', 'إلسلفادور', 'Salvadoran', 'سلفادوري'),
(66, 'GQ', 'Equatorial Guinea', 'غينيا الاستوائي', 'Equatorial Guinean', 'غيني'),
(67, 'ER', 'Eritrea', 'إريتريا', 'Eritrean', 'إريتيري'),
(68, 'EE', 'Estonia', 'استونيا', 'Estonian', 'استوني'),
(69, 'ET', 'Ethiopia', 'أثيوبيا', 'Ethiopian', 'أثيوبي'),
(70, 'FK', 'Falkland Islands (Malvinas)', 'جزر فوكلاند', 'Falkland Islander', 'فوكلاندي'),
(71, 'FO', 'Faroe Islands', 'جزر فارو', 'Faroese', 'جزر فارو'),
(72, 'FJ', 'Fiji', 'فيجي', 'Fijian', 'فيجي'),
(73, 'FI', 'Finland', 'فنلندا', 'Finnish', 'فنلندي'),
(74, 'FR', 'France', 'فرنسا', 'French', 'فرنسي'),
(75, 'GF', 'French Guiana', 'غويانا الفرنسية', 'French Guianese', 'غويانا الفرنسية'),
(76, 'PF', 'French Polynesia', 'بولينيزيا الفرنسية', 'French Polynesian', 'بولينيزيي'),
(77, 'TF', 'French Southern and Antarctic Lands', 'أراض فرنسية جنوبية وأنتارتيكية', 'French', 'أراض فرنسية جنوبية وأنتارتيكية'),
(78, 'GA', 'Gabon', 'الغابون', 'Gabonese', 'غابوني'),
(79, 'GM', 'Gambia', 'غامبيا', 'Gambian', 'غامبي'),
(80, 'GE', 'Georgia', 'جيورجيا', 'Georgian', 'جيورجي'),
(81, 'DE', 'Germany', 'ألمانيا', 'German', 'ألماني'),
(82, 'GH', 'Ghana', 'غانا', 'Ghanaian', 'غاني'),
(83, 'GI', 'Gibraltar', 'جبل طارق', 'Gibraltar', 'جبل طارق'),
(84, 'GG', 'Guernsey', 'غيرنزي', 'Guernsian', 'غيرنزي'),
(85, 'GR', 'Greece', 'اليونان', 'Greek', 'يوناني'),
(86, 'GL', 'Greenland', 'جرينلاند', 'Greenlandic', 'جرينلاندي'),
(87, 'GD', 'Grenada', 'غرينادا', 'Grenadian', 'غرينادي'),
(88, 'GP', 'Guadeloupe', 'جزر جوادلوب', 'Guadeloupe', 'جزر جوادلوب'),
(89, 'GU', 'Guam', 'جوام', 'Guamanian', 'جوامي'),
(90, 'GT', 'Guatemala', 'غواتيمال', 'Guatemalan', 'غواتيمالي'),
(91, 'GN', 'Guinea', 'غينيا', 'Guinean', 'غيني'),
(92, 'GW', 'Guinea-Bissau', 'غينيا-بيساو', 'Guinea-Bissauan', 'غيني'),
(93, 'GY', 'Guyana', 'غيانا', 'Guyanese', 'غياني'),
(94, 'HT', 'Haiti', 'هايتي', 'Haitian', 'هايتي'),
(95, 'HM', 'Heard and Mc Donald Islands', 'جزيرة هيرد وجزر ماكدونالد', 'Heard and Mc Donald Islanders', 'جزيرة هيرد وجزر ماكدونالد'),
(96, 'HN', 'Honduras', 'هندوراس', 'Honduran', 'هندوراسي'),
(97, 'HK', 'Hong Kong', 'هونغ كونغ', 'Hongkongese', 'هونغ كونغي'),
(98, 'HU', 'Hungary', 'المجر', 'Hungarian', 'مجري'),
(99, 'IS', 'Iceland', 'آيسلندا', 'Icelandic', 'آيسلندي'),
(100, 'IN', 'India', 'الهند', 'Indian', 'هندي'),
(101, 'IM', 'Isle of Man', 'جزيرة مان', 'Manx', 'ماني'),
(102, 'ID', 'Indonesia', 'أندونيسيا', 'Indonesian', 'أندونيسيي'),
(103, 'IR', 'Iran', 'إيران', 'Iranian', 'إيراني'),
(104, 'IQ', 'Iraq', 'العراق', 'Iraqi', 'عراقي'),
(105, 'IE', 'Ireland', 'إيرلندا', 'Irish', 'إيرلندي'),
(106, 'IL', 'Israel', 'إسرائيل', 'Israeli', 'إسرائيلي'),
(107, 'IT', 'Italy', 'إيطاليا', 'Italian', 'إيطالي'),
(108, 'CI', 'Ivory Coast', 'ساحل العاج', 'Ivory Coastian', 'ساحل العاج'),
(109, 'JE', 'Jersey', 'جيرزي', 'Jersian', 'جيرزي'),
(110, 'JM', 'Jamaica', 'جمايكا', 'Jamaican', 'جمايكي'),
(111, 'JP', 'Japan', 'اليابان', 'Japanese', 'ياباني'),
(112, 'JO', 'Jordan', 'الأردن', 'Jordanian', 'أردني'),
(113, 'KZ', 'Kazakhstan', 'كازاخستان', 'Kazakh', 'كازاخستاني'),
(114, 'KE', 'Kenya', 'كينيا', 'Kenyan', 'كيني'),
(115, 'KI', 'Kiribati', 'كيريباتي', 'I-Kiribati', 'كيريباتي'),
(116, 'KP', 'Korea(North Korea)', 'كوريا الشمالية', 'North Korean', 'كوري'),
(117, 'KR', 'Korea(South Korea)', 'كوريا الجنوبية', 'South Korean', 'كوري'),
(118, 'XK', 'Kosovo', 'كوسوفو', 'Kosovar', 'كوسيفي'),
(119, 'KW', 'Kuwait', 'الكويت', 'Kuwaiti', 'كويتي'),
(120, 'KG', 'Kyrgyzstan', 'قيرغيزستان', 'Kyrgyzstani', 'قيرغيزستاني'),
(121, 'LA', 'Lao PDR', 'لاوس', 'Laotian', 'لاوسي'),
(122, 'LV', 'Latvia', 'لاتفيا', 'Latvian', 'لاتيفي'),
(123, 'LB', 'Lebanon', 'لبنان', 'Lebanese', 'لبناني'),
(124, 'LS', 'Lesotho', 'ليسوتو', 'Basotho', 'ليوسيتي'),
(125, 'LR', 'Liberia', 'ليبيريا', 'Liberian', 'ليبيري'),
(126, 'LY', 'Libya', 'ليبيا', 'Libyan', 'ليبي'),
(127, 'LI', 'Liechtenstein', 'ليختنشتين', 'Liechtenstein', 'ليختنشتيني'),
(128, 'LT', 'Lithuania', 'لتوانيا', 'Lithuanian', 'لتوانيي'),
(129, 'LU', 'Luxembourg', 'لوكسمبورغ', 'Luxembourger', 'لوكسمبورغي'),
(130, 'LK', 'Sri Lanka', 'سريلانكا', 'Sri Lankian', 'سريلانكي'),
(131, 'MO', 'Macau', 'ماكاو', 'Macanese', 'ماكاوي'),
(132, 'MK', 'Macedonia', 'مقدونيا', 'Macedonian', 'مقدوني'),
(133, 'MG', 'Madagascar', 'مدغشقر', 'Malagasy', 'مدغشقري'),
(134, 'MW', 'Malawi', 'مالاوي', 'Malawian', 'مالاوي'),
(135, 'MY', 'Malaysia', 'ماليزيا', 'Malaysian', 'ماليزي'),
(136, 'MV', 'Maldives', 'المالديف', 'Maldivian', 'مالديفي'),
(137, 'ML', 'Mali', 'مالي', 'Malian', 'مالي'),
(138, 'MT', 'Malta', 'مالطا', 'Maltese', 'مالطي'),
(139, 'MH', 'Marshall Islands', 'جزر مارشال', 'Marshallese', 'مارشالي'),
(140, 'MQ', 'Martinique', 'مارتينيك', 'Martiniquais', 'مارتينيكي'),
(141, 'MR', 'Mauritania', 'موريتانيا', 'Mauritanian', 'موريتانيي'),
(142, 'MU', 'Mauritius', 'موريشيوس', 'Mauritian', 'موريشيوسي'),
(143, 'YT', 'Mayotte', 'مايوت', 'Mahoran', 'مايوتي'),
(144, 'MX', 'Mexico', 'المكسيك', 'Mexican', 'مكسيكي'),
(145, 'FM', 'Micronesia', 'مايكرونيزيا', 'Micronesian', 'مايكرونيزيي'),
(146, 'MD', 'Moldova', 'مولدافيا', 'Moldovan', 'مولديفي'),
(147, 'MC', 'Monaco', 'موناكو', 'Monacan', 'مونيكي'),
(148, 'MN', 'Mongolia', 'منغوليا', 'Mongolian', 'منغولي'),
(149, 'ME', 'Montenegro', 'الجبل الأسود', 'Montenegrin', 'الجبل الأسود'),
(150, 'MS', 'Montserrat', 'مونتسيرات', 'Montserratian', 'مونتسيراتي'),
(151, 'MA', 'Morocco', 'المغرب', 'Moroccan', 'مغربي'),
(152, 'MZ', 'Mozambique', 'موزمبيق', 'Mozambican', 'موزمبيقي'),
(153, 'MM', 'Myanmar', 'ميانمار', 'Myanmarian', 'ميانماري'),
(154, 'NA', 'Namibia', 'ناميبيا', 'Namibian', 'ناميبي'),
(155, 'NR', 'Nauru', 'نورو', 'Nauruan', 'نوري'),
(156, 'NP', 'Nepal', 'نيبال', 'Nepalese', 'نيبالي'),
(157, 'NL', 'Netherlands', 'هولندا', 'Dutch', 'هولندي'),
(158, 'AN', 'Netherlands Antilles', 'جزر الأنتيل الهولندي', 'Dutch Antilier', 'هولندي'),
(159, 'NC', 'New Caledonia', 'كاليدونيا الجديدة', 'New Caledonian', 'كاليدوني'),
(160, 'NZ', 'New Zealand', 'نيوزيلندا', 'New Zealander', 'نيوزيلندي'),
(161, 'NI', 'Nicaragua', 'نيكاراجوا', 'Nicaraguan', 'نيكاراجوي'),
(162, 'NE', 'Niger', 'النيجر', 'Nigerien', 'نيجيري'),
(163, 'NG', 'Nigeria', 'نيجيريا', 'Nigerian', 'نيجيري'),
(164, 'NU', 'Niue', 'ني', 'Niuean', 'ني'),
(165, 'NF', 'Norfolk Island', 'جزيرة نورفولك', 'Norfolk Islander', 'نورفوليكي'),
(166, 'MP', 'Northern Mariana Islands', 'جزر ماريانا الشمالية', 'Northern Marianan', 'ماريني'),
(167, 'NO', 'Norway', 'النرويج', 'Norwegian', 'نرويجي'),
(168, 'OM', 'Oman', 'عمان', 'Omani', 'عماني'),
(169, 'PK', 'Pakistan', 'باكستان', 'Pakistani', 'باكستاني'),
(170, 'PW', 'Palau', 'بالاو', 'Palauan', 'بالاوي'),
(171, 'PS', 'Palestine', 'فلسطين', 'Palestinian', 'فلسطيني'),
(172, 'PA', 'Panama', 'بنما', 'Panamanian', 'بنمي'),
(173, 'PG', 'Papua New Guinea', 'بابوا غينيا الجديدة', 'Papua New Guinean', 'بابوي'),
(174, 'PY', 'Paraguay', 'باراغواي', 'Paraguayan', 'بارغاوي'),
(175, 'PE', 'Peru', 'بيرو', 'Peruvian', 'بيري'),
(176, 'PH', 'Philippines', 'الفليبين', 'Filipino', 'فلبيني'),
(177, 'PN', 'Pitcairn', 'بيتكيرن', 'Pitcairn Islander', 'بيتكيرني'),
(178, 'PL', 'Poland', 'بولونيا', 'Polish', 'بوليني'),
(179, 'PT', 'Portugal', 'البرتغال', 'Portuguese', 'برتغالي'),
(180, 'PR', 'Puerto Rico', 'بورتو ريكو', 'Puerto Rican', 'بورتي'),
(181, 'QA', 'Qatar', 'قطر', 'Qatari', 'قطري'),
(182, 'RE', 'Reunion Island', 'ريونيون', 'Reunionese', 'ريونيوني'),
(183, 'RO', 'Romania', 'رومانيا', 'Romanian', 'روماني'),
(184, 'RU', 'Russian', 'روسيا', 'Russian', 'روسي'),
(185, 'RW', 'Rwanda', 'رواندا', 'Rwandan', 'رواندا'),
(186, 'KN', 'Saint Kitts and Nevis', 'سانت كيتس ونيفس,', 'Kittitian/Nevisian', 'سانت كيتس ونيفس'),
(187, 'MF', 'Saint Martin (French part)', 'ساينت مارتن فرنسي', 'St. Martian(French)', 'ساينت مارتني فرنسي'),
(188, 'SX', 'Sint Maarten (Dutch part)', 'ساينت مارتن هولندي', 'St. Martian(Dutch)', 'ساينت مارتني هولندي'),
(189, 'LC', 'Saint Pierre and Miquelon', 'سان بيير وميكلون', 'St. Pierre and Miquelon', 'سان بيير وميكلوني'),
(190, 'VC', 'Saint Vincent and the Grenadines', 'سانت فنسنت وجزر غرينادين', 'Saint Vincent and the Grenadines', 'سانت فنسنت وجزر غرينادين'),
(191, 'WS', 'Samoa', 'ساموا', 'Samoan', 'ساموي'),
(192, 'SM', 'San Marino', 'سان مارينو', 'Sammarinese', 'ماريني'),
(193, 'ST', 'Sao Tome and Principe', 'ساو تومي وبرينسيبي', 'Sao Tomean', 'ساو تومي وبرينسيبي'),
(194, 'SA', 'Saudi Arabia', 'المملكة العربية السعودية', 'Saudi Arabian', 'سعودي'),
(195, 'SN', 'Senegal', 'السنغال', 'Senegalese', 'سنغالي'),
(196, 'RS', 'Serbia', 'صربيا', 'Serbian', 'صربي'),
(197, 'SC', 'Seychelles', 'سيشيل', 'Seychellois', 'سيشيلي'),
(198, 'SL', 'Sierra Leone', 'سيراليون', 'Sierra Leonean', 'سيراليوني'),
(199, 'SG', 'Singapore', 'سنغافورة', 'Singaporean', 'سنغافوري'),
(200, 'SK', 'Slovakia', 'سلوفاكيا', 'Slovak', 'سولفاكي'),
(201, 'SI', 'Slovenia', 'سلوفينيا', 'Slovenian', 'سولفيني'),
(202, 'SB', 'Solomon Islands', 'جزر سليمان', 'Solomon Island', 'جزر سليمان'),
(203, 'SO', 'Somalia', 'الصومال', 'Somali', 'صومالي'),
(204, 'ZA', 'South Africa', 'جنوب أفريقيا', 'South African', 'أفريقي'),
(205, 'GS', 'South Georgia and the South Sandwich', 'المنطقة القطبية الجنوبية', 'South Georgia and the South Sandwich', 'لمنطقة القطبية الجنوبية'),
(206, 'SS', 'South Sudan', 'السودان الجنوبي', 'South Sudanese', 'سوادني جنوبي'),
(207, 'ES', 'Spain', 'إسبانيا', 'Spanish', 'إسباني'),
(208, 'SH', 'Saint Helena', 'سانت هيلانة', 'St. Helenian', 'هيلاني'),
(209, 'SD', 'Sudan', 'السودان', 'Sudanese', 'سوداني'),
(210, 'SR', 'Suriname', 'سورينام', 'Surinamese', 'سورينامي'),
(211, 'SJ', 'Svalbard and Jan Mayen', 'سفالبارد ويان ماين', 'Svalbardian/Jan Mayenian', 'سفالبارد ويان ماين'),
(212, 'SZ', 'Swaziland', 'سوازيلند', 'Swazi', 'سوازيلندي'),
(213, 'SE', 'Sweden', 'السويد', 'Swedish', 'سويدي'),
(214, 'CH', 'Switzerland', 'سويسرا', 'Swiss', 'سويسري'),
(215, 'SY', 'Syria', 'سوريا', 'Syrian', 'سوري'),
(216, 'TW', 'Taiwan', 'تايوان', 'Taiwanese', 'تايواني'),
(217, 'TJ', 'Tajikistan', 'طاجيكستان', 'Tajikistani', 'طاجيكستاني'),
(218, 'TZ', 'Tanzania', 'تنزانيا', 'Tanzanian', 'تنزانيي'),
(219, 'TH', 'Thailand', 'تايلندا', 'Thai', 'تايلندي'),
(220, 'TL', 'Timor-Leste', 'تيمور الشرقية', 'Timor-Lestian', 'تيموري'),
(221, 'TG', 'Togo', 'توغو', 'Togolese', 'توغي'),
(222, 'TK', 'Tokelau', 'توكيلاو', 'Tokelaian', 'توكيلاوي'),
(223, 'TO', 'Tonga', 'تونغا', 'Tongan', 'تونغي'),
(224, 'TT', 'Trinidad and Tobago', 'ترينيداد وتوباغو', 'Trinidadian/Tobagonian', 'ترينيداد وتوباغو'),
(225, 'TN', 'Tunisia', 'تونس', 'Tunisian', 'تونسي'),
(226, 'TR', 'Turkey', 'تركيا', 'Turkish', 'تركي'),
(227, 'TM', 'Turkmenistan', 'تركمانستان', 'Turkmen', 'تركمانستاني'),
(228, 'TC', 'Turks and Caicos Islands', 'جزر توركس وكايكوس', 'Turks and Caicos Islands', 'جزر توركس وكايكوس'),
(229, 'TV', 'Tuvalu', 'توفالو', 'Tuvaluan', 'توفالي'),
(230, 'UG', 'Uganda', 'أوغندا', 'Ugandan', 'أوغندي'),
(231, 'UA', 'Ukraine', 'أوكرانيا', 'Ukrainian', 'أوكراني'),
(232, 'AE', 'United Arab Emirates', 'الإمارات العربية المتحدة', 'Emirati', 'إماراتي'),
(233, 'GB', 'United Kingdom', 'المملكة المتحدة', 'British', 'بريطاني'),
(234, 'US', 'United States', 'الولايات المتحدة', 'American', 'أمريكي'),
(235, 'UM', 'US Minor Outlying Islands', 'قائمة الولايات والمناطق الأمريكية', 'US Minor Outlying Islander', 'أمريكي'),
(236, 'UY', 'Uruguay', 'أورغواي', 'Uruguayan', 'أورغواي'),
(237, 'UZ', 'Uzbekistan', 'أوزباكستان', 'Uzbek', 'أوزباكستاني'),
(238, 'VU', 'Vanuatu', 'فانواتو', 'Vanuatuan', 'فانواتي'),
(239, 'VE', 'Venezuela', 'فنزويلا', 'Venezuelan', 'فنزويلي'),
(240, 'VN', 'Vietnam', 'فيتنام', 'Vietnamese', 'فيتنامي'),
(241, 'VI', 'Virgin Islands (U.S.)', 'الجزر العذراء الأمريكي', 'American Virgin Islander', 'أمريكي'),
(242, 'VA', 'Vatican City', 'فنزويلا', 'Vatican', 'فاتيكاني'),
(243, 'WF', 'Wallis and Futuna Islands', 'والس وفوتونا', 'Wallisian/Futunan', 'فوتوني'),
(244, 'EH', 'Western Sahara', 'الصحراء الغربية', 'Sahrawian', 'صحراوي'),
(245, 'YE', 'Yemen', 'اليمن', 'Yemeni', 'يمني'),
(246, 'ZM', 'Zambia', 'زامبيا', 'Zambian', 'زامبياني'),
(247, 'ZW', 'Zimbabwe', 'زمبابوي', 'Zimbabwean', 'زمبابوي');

-- --------------------------------------------------------

--
-- Table structure for table `data_rows`
--

DROP TABLE IF EXISTS `data_rows`;
CREATE TABLE IF NOT EXISTS `data_rows` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `data_type_id` int(10) UNSIGNED NOT NULL,
  `field` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `browse` tinyint(1) NOT NULL DEFAULT 1,
  `read` tinyint(1) NOT NULL DEFAULT 1,
  `edit` tinyint(1) NOT NULL DEFAULT 1,
  `add` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 1,
  `search` tinyint(1) NOT NULL DEFAULT 0,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `data_rows_data_type_id_foreign` (`data_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=328 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_rows`
--

INSERT INTO `data_rows` (`id`, `data_type_id`, `field`, `type`, `display_name`, `required`, `browse`, `read`, `edit`, `add`, `delete`, `search`, `details`, `additional_details`, `order`) VALUES
(1, 1, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, 0, '{}', '{}', 1),
(2, 1, 'name', 'text', 'name', 1, 1, 1, 1, 1, 1, 0, '{}', '{}', 2),
(3, 1, 'email', 'text', 'email', 1, 1, 1, 1, 1, 1, 0, '{}', '{}', 3),
(4, 1, 'password', 'password', 'password', 1, 0, 0, 1, 1, 0, 0, '{}', '{}', 4),
(5, 1, 'remember_token', 'text', 'remember_token', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 5),
(6, 1, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 0, 0, '{}', '{}', 6),
(7, 1, 'updated_at', 'timestamp', 'Updated At', 0, 0, 1, 0, 0, 0, 0, '{}', '{}', 7),
(8, 1, 'avatar', 'image', 'avatar', 0, 1, 1, 1, 1, 1, 0, '{}', '{}', 8),
(9, 1, 'user_belongsto_role_relationship', 'relationship', 'role', 0, 1, 1, 1, 1, 0, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":\"0\",\"taggable\":\"0\"}', '{}', 10),
(10, 1, 'user_belongstomany_role_relationship', 'relationship', 'roles', 0, 0, 1, 1, 0, 0, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}', '{}', 11),
(11, 1, 'settings', 'hidden', 'settings', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 12),
(12, 2, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, 0, NULL, NULL, 1),
(13, 2, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, 0, NULL, NULL, 2),
(14, 2, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, 0, NULL, NULL, 3),
(15, 2, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, 0, NULL, NULL, 4),
(16, 3, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, 0, '{}', '{}', 1),
(17, 3, 'name', 'text', 'name', 1, 1, 1, 1, 1, 1, 0, '{}', '{}', 2),
(18, 3, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 3),
(19, 3, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 4),
(20, 3, 'display_name', 'text', 'display_name', 1, 1, 1, 1, 1, 1, 0, '{}', '{}', 5),
(21, 1, 'role_id', 'text', 'Role', 0, 1, 1, 1, 1, 1, 0, '{}', '{}', 9),
(22, 4, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, 0, '{}', '{}', 1),
(23, 4, 'title_en', 'text', 'Title En', 1, 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|min:2\",\"messages\":{\"required\":\"This :attribute field is a must.\",\"min\":\"This :attribute field minimum :min.\"}},\"frontend_validation\":{\"rules\":{\"required\":true,\"minlength\":2}}}', '{}', 2),
(24, 4, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|min:2\",\"messages\":{\"required\":\"This :attribute field is a must.\",\"min\":\"This :attribute field minimum :min.\"}},\"frontend_validation\":{\"rules\":{\"required\":true,\"minlength\":2}}}', '{}', 3),
(25, 4, 'bbs_code', 'text', 'Bbs Code', 0, 1, 1, 1, 1, 1, 1, '{}', '{}', 4),
(26, 4, 'status', 'text', 'Status', 1, 1, 1, 1, 0, 1, 1, '{\"default\":\"1\",\"options\":{\"0\":\"Inactive\",\"1\":\"Active\"}}', '{}', 5),
(27, 4, 'created_by', 'text', 'Created By', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 6),
(28, 4, 'updated_by', 'text', 'Updated By', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 7),
(29, 4, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 8),
(30, 4, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 9),
(31, 5, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, 0, '{}', '{}', 1),
(32, 5, 'loc_division_id', 'text', 'Loc Division Id', 1, 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"This :attribute field is a must.\"}},\"frontend_validation\":{\"rules\":{\"required\":true}}}', '{}', 2),
(33, 5, 'division_bbs_code', 'text', 'Division Bbs Code', 0, 1, 1, 1, 1, 1, 1, '{}', '{}', 3),
(34, 5, 'title_en', 'text', 'Title En', 1, 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|min:2\",\"messages\":{\"required\":\"This :attribute field is a must.\",\"min\":\"This :attribute field minimum :min.\"}},\"frontend_validation\":{\"rules\":{\"required\":true,\"minlength\":2}}}', '{}', 4),
(35, 5, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|min:2\",\"messages\":{\"required\":\"This :attribute field is a must.\",\"min\":\"This :attribute field minimum :min.\"}},\"frontend_validation\":{\"rules\":{\"required\":true,\"minlength\":2}}}', '{}', 5),
(36, 5, 'bbs_code', 'text', 'Bbs Code', 0, 1, 1, 1, 1, 1, 1, '{}', '{}', 6),
(37, 5, 'status', 'text', 'Status', 1, 1, 1, 1, 0, 1, 1, '{\"default\":\"1\",\"options\":{\"0\":\"Inactive\",\"1\":\"Active\"}}', '{}', 7),
(38, 5, 'created_by', 'text', 'Created By', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 8),
(39, 5, 'updated_by', 'text', 'Updated By', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 9),
(40, 5, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 10),
(41, 5, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 11),
(43, 5, 'loc_district_belongsto_loc_division_relationship', 'relationship', 'loc_divisions', 0, 1, 1, 1, 1, 1, 0, '{\"model\":\"App\\\\Models\\\\LocDivision\",\"table\":\"loc_divisions\",\"type\":\"belongsTo\",\"column\":\"loc_division_id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"activity_logs\",\"pivot\":\"0\",\"taggable\":\"0\"}', '{}', 12),
(62, 7, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, 0, '{}', '{}', 1),
(63, 7, 'loc_division_id', 'text', 'Loc Division Id', 1, 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"This :attribute field is a must.\"}},\"frontend_validation\":{\"rules\":{\"required\":true}}}', '{}', 2),
(64, 7, 'loc_district_id', 'text', 'Loc District Id', 1, 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"This :attribute field is a must.\"}},\"frontend_validation\":{\"rules\":{\"required\":true}}}', '{}', 3),
(65, 7, 'division_bbs_code', 'text', 'Division Bbs Code', 0, 1, 1, 1, 1, 1, 1, '{}', '{}', 4),
(66, 7, 'district_bbs_code', 'text', 'District Bbs Code', 0, 1, 1, 1, 1, 1, 1, '{}', '{}', 5),
(67, 7, 'title_en', 'text', 'Title En', 1, 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|min:2\",\"messages\":{\"required\":\"This :attribute field is a must.\",\"min\":\"This :attribute field minimum :min.\"}},\"frontend_validation\":{\"rules\":{\"required\":true,\"minlength\":2}}}', '{}', 6),
(68, 7, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required|min:2\",\"messages\":{\"required\":\"This :attribute field is a must.\",\"min\":\"This :attribute field minimum :min.\"}},\"frontend_validation\":{\"rules\":{\"required\":true,\"minlength\":2}}}', '{}', 7),
(69, 7, 'bbs_code', 'text', 'Bbs Code', 0, 1, 1, 1, 1, 1, 1, '{}', '{}', 8),
(70, 7, 'status', 'text', 'Status', 1, 1, 1, 1, 0, 1, 1, '{\"default\":\"Active\",\"options\":{\"0\":\"Inactive\",\"1\":\"Active\"}}', '{}', 9),
(71, 7, 'created_by', 'text', 'Created By', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 10),
(72, 7, 'updated_by', 'text', 'Updated By', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 11),
(73, 7, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 12),
(74, 7, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 13),
(75, 7, 'loc_upazila_belongsto_loc_division_relationship', 'relationship', 'loc_divisions', 0, 1, 1, 1, 1, 1, 0, '{\"model\":\"App\\\\Models\\\\LocDivision\",\"table\":\"loc_divisions\",\"type\":\"belongsTo\",\"column\":\"loc_division_id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"activity_logs\",\"pivot\":\"0\",\"taggable\":\"0\"}', '{}', 14),
(76, 7, 'loc_upazila_belongsto_loc_district_relationship', 'relationship', 'loc_districts', 0, 1, 1, 1, 1, 1, 0, '{\"model\":\"App\\\\Models\\\\LocDistrict\",\"table\":\"loc_districts\",\"type\":\"belongsTo\",\"column\":\"loc_district_id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"activity_logs\",\"pivot\":\"0\",\"taggable\":\"0\"}', '{}', 15),
(299, 6, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, 0, '{}', '{}', 1),
(300, 6, 'key', 'text', 'key', 1, 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\"},\"frontend_validation\":{\"rules\":{\"required\":true}}}', '{}', 2),
(301, 6, 'table_name', 'text', 'table_name', 0, 1, 1, 1, 1, 1, 1, '{}', '{}', 3),
(302, 6, 'is_user_defined', 'select_dropdown', 'is_user_defined', 1, 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\"},\"frontend_validation\":{\"rules\":{\"required\":true}},\"default\":1,\"options\":{\"0\":\"No\",\"1\":\"Yes\"}}', '{}', 4),
(303, 6, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, 1, '{}', '{}', 5),
(304, 6, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, 0, '{}', '{}', 6),
(305, 6, 'sub_group', 'text', 'sub_group', 0, 1, 1, 1, 1, 1, 1, '{}', '{}', 7),
(306, 6, 'sub_group_order', 'text', 'sub_group_order', 1, 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\"},\"frontend_validation\":{\"rules\":{\"required\":true}},\"default\":99}', '{}', 8),
(307, 1, 'is_superuser', 'select_dropdown', 'is_super_user', 1, 0, 1, 1, 1, 1, 1, '{\"options\":{\"0\":\"No\",\"1\":\"Yes\"}}', '{}', 2),
(308, 1, 'user_type', 'text', 'user_type', 0, 1, 1, 1, 1, 1, 1, '{}', '{}', 5),
(311, 1, 'loc_division_id', 'text', 'Loc Division Id', 0, 0, 1, 0, 0, 0, 0, '{}', '{}', 9),
(312, 1, 'loc_district_id', 'text', 'Loc District Id', 0, 0, 1, 0, 0, 0, 0, '{}', '{}', 10),
(313, 1, 'loc_upazila_id', 'text', 'Loc Upazila Id', 0, 0, 1, 0, 0, 0, 0, '{}', '{}', 11),
(314, 1, 'loc_municipality_id', 'text', 'Loc Municipality Id', 0, 0, 1, 0, 0, 0, 0, '{}', '{}', 12),
(315, 1, 'loc_union_id', 'text', 'Loc Union Id', 0, 0, 1, 0, 0, 0, 0, '{}', '{}', 13),
(316, 1, 'status', 'select_dropdown', 'status', 1, 0, 1, 1, 1, 1, 1, '{\"options\":{\"0\":\"Inactive\",\"1\":\"Active\"}}', '{}', 15),
(317, 1, 'email_verified_at', 'text', 'email_verified_at', 0, 0, 1, 0, 0, 0, 0, '{}', '{}', 16),
(318, 1, 'created_by', 'text', 'created_by', 0, 0, 1, 0, 0, 0, 0, '{}', '{}', 20),
(319, 1, 'updated_by', 'text', 'updated_by', 0, 0, 1, 0, 0, 0, 0, '{}', '{}', 21),
(320, 1, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 1, 0, 0, 0, 0, '{}', '{}', 24),
(327, 1, 'mobile', 'text', 'mobile', 1, 1, 1, 1, 1, 1, 1, '{}', '{}', 7);

-- --------------------------------------------------------

--
-- Table structure for table `data_types`
--

DROP TABLE IF EXISTS `data_types`;
CREATE TABLE IF NOT EXISTS `data_types` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT 0,
  `server_side` tinyint(1) NOT NULL DEFAULT 0,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `data_types_name_unique` (`name`),
  UNIQUE KEY `data_types_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_types`
--

INSERT INTO `data_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `details`, `created_at`, `updated_at`) VALUES
(1, 'users', 'users', 'User', 'Users', 'voyager-person', 'App\\Models\\User', 'App\\Policies\\UserPolicy', 'App\\Http\\Controllers\\Voyager\\VoyagerUserController', NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"desc\",\"default_search_key\":null,\"scope\":\"acl\"}', '2019-12-12 04:28:39', '2020-01-13 05:35:23'),
(2, 'menus', 'menus', 'Menu', 'Menus', 'voyager-list', 'App\\Models\\Menu', NULL, '', '', 1, 0, NULL, '2019-12-12 04:28:39', '2019-12-12 04:28:39'),
(3, 'roles', 'roles', 'Role', 'Roles', 'voyager-lock', 'App\\Models\\Role', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"desc\",\"default_search_key\":null,\"scope\":null}', '2019-12-12 04:28:40', '2019-12-23 05:05:49'),
(4, 'loc_divisions', 'divisions', 'Division', 'Loc Divisions', NULL, 'App\\Models\\LocDivision', NULL, 'App\\Http\\Controllers\\LocDivisionController', NULL, 1, 0, '{\"order_column\":\"id\",\"order_display_column\":\"title\",\"order_direction\":\"desc\",\"default_search_key\":\"title\",\"scope\":null}', '2019-12-15 10:24:14', '2020-01-05 17:56:28'),
(5, 'loc_districts', 'loc-districts', 'District', 'Districts', NULL, 'App\\Models\\LocDistrict', NULL, 'App\\Http\\Controllers\\LocDistrictController', NULL, 1, 0, '{\"order_column\":\"id\",\"order_display_column\":\"title_en\",\"order_direction\":\"asc\",\"default_search_key\":\"id\",\"scope\":null}', '2019-12-17 04:34:59', '2020-01-05 17:56:19'),
(6, 'permissions', 'permissions', 'Permission', 'Permissions', 'voyager-skull', 'App\\Models\\Permission', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-12-23 11:47:46', '2019-12-23 12:01:12'),
(7, 'loc_upazilas', 'loc-upazilas', 'Loc Upazila', 'Loc Upazilas', NULL, 'App\\Models\\LocUpazila', NULL, 'App\\Http\\Controllers\\LocUpazilaController', NULL, 1, 0, '{\"order_column\":\"id\",\"order_display_column\":\"title\",\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2019-12-17 06:34:27', '2020-01-05 17:56:47');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'IT Department', 'Unique group It Departments', NULL, '2020-03-07 06:42:12', '2020-03-07 06:42:12');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
CREATE TABLE IF NOT EXISTS `districts` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `division_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` double(10,3) DEFAULT NULL,
  `lon` double(10,3) DEFAULT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `districts_name_index` (`name`),
  KEY `districts_bn_name_index` (`bn_name`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `division_id`, `name`, `bn_name`, `lat`, `lon`, `url`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Comilla', 'কুমিল্লা', 23.468, 91.179, 'www.comilla.gov.bd', NULL, NULL, NULL),
(2, 1, 'Feni', 'ফেনী', 23.023, 91.384, 'www.feni.gov.bd', NULL, NULL, NULL),
(3, 1, 'Brahmanbaria', 'ব্রাহ্মণবাড়িয়া', 23.957, 91.112, 'www.brahmanbaria.gov.bd', NULL, NULL, NULL),
(4, 1, 'Rangamati', 'রাঙ্গামাটি', NULL, NULL, 'www.rangamati.gov.bd', NULL, NULL, NULL),
(5, 1, 'Noakhali', 'নোয়াখালী', 22.870, 91.099, 'www.noakhali.gov.bd', NULL, NULL, NULL),
(6, 1, 'Chandpur', 'চাঁদপুর', 23.233, 90.671, 'www.chandpur.gov.bd', NULL, NULL, NULL),
(7, 1, 'Lakshmipur', 'লক্ষ্মীপুর', 22.942, 90.841, 'www.lakshmipur.gov.bd', NULL, NULL, NULL),
(8, 1, 'Chattogram', 'চট্টগ্রাম', 22.335, 91.834, 'www.chittagong.gov.bd', NULL, NULL, NULL),
(9, 1, 'Coxsbazar', 'কক্সবাজার', NULL, NULL, 'www.coxsbazar.gov.bd', NULL, NULL, NULL),
(10, 1, 'Khagrachhari', 'খাগড়াছড়ি', 23.119, 91.985, 'www.khagrachhari.gov.bd', NULL, NULL, NULL),
(11, 1, 'Bandarban', 'বান্দরবান', 22.195, 92.218, 'www.bandarban.gov.bd', NULL, NULL, NULL),
(12, 2, 'Sirajganj', 'সিরাজগঞ্জ', 24.453, 89.701, 'www.sirajganj.gov.bd', NULL, NULL, NULL),
(13, 2, 'Pabna', 'পাবনা', 23.999, 89.234, 'www.pabna.gov.bd', NULL, NULL, NULL),
(14, 2, 'Bogura', 'বগুড়া', 24.847, 89.378, 'www.bogra.gov.bd', NULL, NULL, NULL),
(15, 2, 'Rajshahi', 'রাজশাহী', NULL, NULL, 'www.rajshahi.gov.bd', NULL, NULL, NULL),
(16, 2, 'Natore', 'নাটোর', 24.421, 89.000, 'www.natore.gov.bd', NULL, NULL, NULL),
(17, 2, 'Joypurhat', 'জয়পুরহাট', NULL, NULL, 'www.joypurhat.gov.bd', NULL, NULL, NULL),
(18, 2, 'Chapainawabganj', 'চাঁপাইনবাবগঞ্জ', 24.597, 88.278, 'www.chapainawabganj.gov.bd', NULL, NULL, NULL),
(19, 2, 'Naogaon', 'নওগাঁ', NULL, NULL, 'www.naogaon.gov.bd', NULL, NULL, NULL),
(20, 3, 'Jashore', 'যশোর', 23.166, 89.208, 'www.jessore.gov.bd', NULL, NULL, NULL),
(21, 3, 'Satkhira', 'সাতক্ষীরা', NULL, NULL, 'www.satkhira.gov.bd', NULL, NULL, NULL),
(22, 3, 'Meherpur', 'মেহেরপুর', 23.762, 88.632, 'www.meherpur.gov.bd', NULL, NULL, NULL),
(23, 3, 'Narail', 'নড়াইল', 23.173, 89.513, 'www.narail.gov.bd', NULL, NULL, NULL),
(24, 3, 'Chuadanga', 'চুয়াডাঙ্গা', 23.640, 88.842, 'www.chuadanga.gov.bd', NULL, NULL, NULL),
(25, 3, 'Kushtia', 'কুষ্টিয়া', 23.901, 89.120, 'www.kushtia.gov.bd', NULL, NULL, NULL),
(26, 3, 'Magura', 'মাগুরা', 23.487, 89.420, 'www.magura.gov.bd', NULL, NULL, NULL),
(27, 3, 'Khulna', 'খুলনা', 22.816, 89.569, 'www.khulna.gov.bd', NULL, NULL, NULL),
(28, 3, 'Bagerhat', 'বাগেরহাট', 22.652, 89.786, 'www.bagerhat.gov.bd', NULL, NULL, NULL),
(29, 3, 'Jhenaidah', 'ঝিনাইদহ', 23.545, 89.154, 'www.jhenaidah.gov.bd', NULL, NULL, NULL),
(30, 4, 'Jhalakathi', 'ঝালকাঠি', NULL, NULL, 'www.jhalakathi.gov.bd', NULL, NULL, NULL),
(31, 4, 'Patuakhali', 'পটুয়াখালী', 22.360, 90.330, 'www.patuakhali.gov.bd', NULL, NULL, NULL),
(32, 4, 'Pirojpur', 'পিরোজপুর', NULL, NULL, 'www.pirojpur.gov.bd', NULL, NULL, NULL),
(33, 4, 'Barisal', 'বরিশাল', NULL, NULL, 'www.barisal.gov.bd', NULL, NULL, NULL),
(34, 4, 'Bhola', 'ভোলা', 22.686, 90.648, 'www.bhola.gov.bd', NULL, NULL, NULL),
(35, 4, 'Barguna', 'বরগুনা', NULL, NULL, 'www.barguna.gov.bd', NULL, NULL, NULL),
(36, 5, 'Sylhet', 'সিলেট', 24.890, 91.870, 'www.sylhet.gov.bd', NULL, NULL, NULL),
(37, 5, 'Moulvibazar', 'মৌলভীবাজার', 24.483, 91.777, 'www.moulvibazar.gov.bd', NULL, NULL, NULL),
(38, 5, 'Habiganj', 'হবিগঞ্জ', 24.375, 91.416, 'www.habiganj.gov.bd', NULL, NULL, NULL),
(39, 5, 'Sunamganj', 'সুনামগঞ্জ', 25.066, 91.395, 'www.sunamganj.gov.bd', NULL, NULL, NULL),
(40, 6, 'Narsingdi', 'নরসিংদী', 23.932, 90.715, 'www.narsingdi.gov.bd', NULL, NULL, NULL),
(41, 6, 'Gazipur', 'গাজীপুর', 24.002, 90.426, 'www.gazipur.gov.bd', NULL, NULL, NULL),
(42, 6, 'Shariatpur', 'শরীয়তপুর', NULL, NULL, 'www.shariatpur.gov.bd', NULL, NULL, NULL),
(43, 6, 'Narayanganj', 'নারায়ণগঞ্জ', 23.634, 90.496, 'www.narayanganj.gov.bd', NULL, NULL, NULL),
(44, 6, 'Tangail', 'টাঙ্গাইল', NULL, NULL, 'www.tangail.gov.bd', NULL, NULL, NULL),
(45, 6, 'Kishoreganj', 'কিশোরগঞ্জ', 24.445, 90.777, 'www.kishoreganj.gov.bd', NULL, NULL, NULL),
(46, 6, 'Manikganj', 'মানিকগঞ্জ', NULL, NULL, 'www.manikganj.gov.bd', NULL, NULL, NULL),
(47, 6, 'Dhaka', 'ঢাকা', 23.712, 90.411, 'www.dhaka.gov.bd', NULL, NULL, NULL),
(48, 6, 'Munshiganj', 'মুন্সিগঞ্জ', NULL, NULL, 'www.munshiganj.gov.bd', NULL, NULL, NULL),
(49, 6, 'Rajbari', 'রাজবাড়ী', 23.757, 89.644, 'www.rajbari.gov.bd', NULL, NULL, NULL),
(50, 6, 'Madaripur', 'মাদারীপুর', 23.164, 90.190, 'www.madaripur.gov.bd', NULL, NULL, NULL),
(51, 6, 'Gopalganj', 'গোপালগঞ্জ', 23.005, 89.827, 'www.gopalganj.gov.bd', NULL, NULL, NULL),
(52, 6, 'Faridpur', 'ফরিদপুর', 23.607, 89.843, 'www.faridpur.gov.bd', NULL, NULL, NULL),
(53, 7, 'Panchagarh', 'পঞ্চগড়', 26.341, 88.554, 'www.panchagarh.gov.bd', NULL, NULL, NULL),
(54, 7, 'Dinajpur', 'দিনাজপুর', 25.622, 88.635, 'www.dinajpur.gov.bd', NULL, NULL, NULL),
(55, 7, 'Lalmonirhat', 'লালমনিরহাট', NULL, NULL, 'www.lalmonirhat.gov.bd', NULL, NULL, NULL),
(56, 7, 'Nilphamari', 'নীলফামারী', 25.932, 88.856, 'www.nilphamari.gov.bd', NULL, NULL, NULL),
(57, 7, 'Gaibandha', 'গাইবান্ধা', 25.329, 89.528, 'www.gaibandha.gov.bd', NULL, NULL, NULL),
(58, 7, 'Thakurgaon', 'ঠাকুরগাঁও', 26.034, 88.462, 'www.thakurgaon.gov.bd', NULL, NULL, NULL),
(59, 7, 'Rangpur', 'রংপুর', 25.756, 89.244, 'www.rangpur.gov.bd', NULL, NULL, NULL),
(60, 7, 'Kurigram', 'কুড়িগ্রাম', 25.805, 89.636, 'www.kurigram.gov.bd', NULL, NULL, NULL),
(61, 8, 'Sherpur', 'শেরপুর', 25.020, 90.015, 'www.sherpur.gov.bd', NULL, NULL, NULL),
(62, 8, 'Mymensingh', 'ময়মনসিংহ', NULL, NULL, 'www.mymensingh.gov.bd', NULL, NULL, NULL),
(63, 8, 'Jamalpur', 'জামালপুর', 24.938, 89.938, 'www.jamalpur.gov.bd', NULL, NULL, NULL),
(64, 8, 'Netrokona', 'নেত্রকোণা', 24.871, 90.728, 'www.netrokona.gov.bd', NULL, NULL, NULL),
(65, 4, 'Barisal City Corporation ', 'Barisal City Corporation ', NULL, NULL, NULL, NULL, NULL, NULL),
(66, 1, 'Chattogram City Corporation', 'Chattogram City Corporation', NULL, NULL, NULL, NULL, NULL, NULL),
(67, 1, 'Cumilla City Corporation (COCC)', 'Cumilla City Corporation (COCC)', NULL, NULL, NULL, NULL, NULL, NULL),
(68, 6, 'Dhaka North City Corporation (DNCC)', 'Dhaka North City Corporation (DNCC)', NULL, NULL, NULL, NULL, NULL, NULL),
(69, 6, 'Dhaka South City Corporation (DSCC)', 'Dhaka South City Corporation (DSCC)', NULL, NULL, NULL, NULL, NULL, NULL),
(70, 6, 'Gazipur City Corporation (GCC)', 'Gazipur City Corporation (GCC)', NULL, NULL, NULL, NULL, NULL, NULL),
(71, 6, 'Narayanganj City Corporation (NCC)', 'Narayanganj City Corporation (NCC)', NULL, NULL, NULL, NULL, NULL, NULL),
(72, 3, 'Khulna City Corporation (KCC)', 'Khulna City Corporation (KCC)', NULL, NULL, NULL, NULL, NULL, NULL),
(73, 8, 'Mymensingh City Corporation (MCC)', 'Mymensingh City Corporation (MCC)', NULL, NULL, NULL, NULL, NULL, NULL),
(74, 2, 'Rajshahi City Corporation (RCC)', 'Rajshahi City Corporation (RCC)', NULL, NULL, NULL, NULL, NULL, NULL),
(75, 7, 'Rangpur City Corporation (RACC)', 'Rangpur City Corporation (RACC)', NULL, NULL, NULL, NULL, NULL, NULL),
(76, 5, 'Sylhet City Corporation (SCC)', 'Sylhet City Corporation (SCC)', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
CREATE TABLE IF NOT EXISTS `divisions` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `divisions_name_index` (`name`),
  KEY `divisions_bn_name_index` (`bn_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `bn_name`, `url`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Chattagram', 'চট্টগ্রাম', 'www.chittagongdiv.gov.bd', NULL, NULL, NULL),
(2, 'Rajshahi', 'রাজশাহী', 'www.rajshahidiv.gov.bd', NULL, NULL, NULL),
(3, 'Khulna', 'খুলনা', 'www.khulnadiv.gov.bd', NULL, NULL, NULL),
(4, 'Barisal', 'বরিশাল', 'www.barisaldiv.gov.bd', NULL, NULL, NULL),
(5, 'Sylhet', 'সিলেট', 'www.sylhetdiv.gov.bd', NULL, NULL, NULL),
(6, 'Dhaka', 'ঢাকা', 'www.dhakadiv.gov.bd', NULL, NULL, NULL),
(7, 'Rangpur', 'রংপুর', 'www.rangpurdiv.gov.bd', NULL, NULL, NULL),
(8, 'Mymensingh', 'ময়মনসিংহ', 'www.mymensinghdiv.gov.bd', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loc_districts`
--

DROP TABLE IF EXISTS `loc_districts`;
CREATE TABLE IF NOT EXISTS `loc_districts` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `loc_division_id` mediumint(8) UNSIGNED NOT NULL,
  `division_bbs_code` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bbs_code` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loc_divisions`
--

DROP TABLE IF EXISTS `loc_divisions`;
CREATE TABLE IF NOT EXISTS `loc_divisions` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bbs_code` char(4) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loc_municipalities`
--

DROP TABLE IF EXISTS `loc_municipalities`;
CREATE TABLE IF NOT EXISTS `loc_municipalities` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `loc_division_id` mediumint(8) UNSIGNED NOT NULL,
  `loc_district_id` mediumint(8) UNSIGNED NOT NULL,
  `loc_upazila_id` int(10) UNSIGNED DEFAULT NULL,
  `geo_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipality_type` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loc_unions`
--

DROP TABLE IF EXISTS `loc_unions`;
CREATE TABLE IF NOT EXISTS `loc_unions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `loc_division_id` mediumint(8) UNSIGNED NOT NULL,
  `loc_district_id` mediumint(8) UNSIGNED NOT NULL,
  `loc_upazila_id` int(10) UNSIGNED NOT NULL,
  `division_bbs_code` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_bbs_code` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upazila_bbs_code` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bbs_code` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loc_upazilas`
--

DROP TABLE IF EXISTS `loc_upazilas`;
CREATE TABLE IF NOT EXISTS `loc_upazilas` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `loc_division_id` mediumint(8) UNSIGNED NOT NULL,
  `loc_district_id` mediumint(8) UNSIGNED NOT NULL,
  `division_bbs_code` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_bbs_code` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bbs_code` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2019-12-12 04:28:40', '2019-12-12 04:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_lang_key` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_items_menu_id_foreign` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `title_lang_key`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `permission_key`, `parameters`) VALUES
(1, 1, 'Dashboard', 'menu.dashboard', '', '_self', 'voyager-boat', '#000000', NULL, 1, '2019-12-12 04:28:40', '2020-01-13 04:23:43', 'voyager.dashboard', NULL, 'null'),
(3, 1, 'Users', 'menu.users', '', '_self', 'voyager-person', NULL, NULL, 4, '2019-12-12 04:28:40', '2019-12-23 11:49:07', 'voyager.users.index', NULL, NULL),
(4, 1, 'Roles', 'menu.roles', '', '_self', 'voyager-lock', NULL, NULL, 2, '2019-12-12 04:28:40', '2019-12-12 04:28:40', 'voyager.roles.index', NULL, NULL),
(5, 1, 'Tools', 'menu.tools', '', '_self', 'voyager-tools', NULL, NULL, 5, '2019-12-12 04:28:40', '2020-06-10 09:36:35', NULL, NULL, NULL),
(6, 1, 'Menu Builder', 'menu.menu_builder', '', '_self', 'voyager-list', NULL, 5, 1, '2019-12-12 04:28:40', '2019-12-17 07:26:13', 'voyager.menus.index', NULL, NULL),
(7, 1, 'Database', 'menu.database', '', '_self', 'voyager-data', NULL, 5, 2, '2019-12-12 04:28:40', '2019-12-17 07:26:13', 'voyager.database.index', NULL, NULL),
(8, 1, 'Compass', 'menu.compass', '', '_self', 'voyager-compass', NULL, 5, 3, '2019-12-12 04:28:40', '2019-12-17 07:26:13', 'voyager.compass.index', NULL, NULL),
(9, 1, 'BREAD', 'menu.bread', '', '_self', 'voyager-bread', NULL, 5, 4, '2019-12-12 04:28:40', '2019-12-17 07:26:13', 'voyager.bread.index', NULL, NULL),
(10, 1, 'Settings', 'menu.settings', '', '_self', 'voyager-settings', NULL, NULL, 6, '2019-12-12 04:28:40', '2020-06-10 09:36:35', 'voyager.settings.index', NULL, NULL),
(11, 1, 'Loc Divisions', 'menu.loc_divisions', '', '_self', 'voyager-window-list', '#000000', 31, 1, '2019-12-15 10:24:15', '2019-12-23 11:49:20', 'voyager.divisions.index', NULL, 'null'),
(12, 1, 'Districts', 'menu.districts', '', '_self', 'voyager-window-list', '#000000', 31, 2, '2019-12-17 04:35:00', '2019-12-23 11:49:29', 'voyager.loc-districts.index', NULL, 'null'),
(14, 1, 'Loc Upazilas', 'menu.loc_upazilas', '', '_self', 'voyager-window-list', '#000000', 31, 3, '2019-12-17 06:34:27', '2019-12-23 11:49:29', 'voyager.loc-upazilas.index', NULL, 'null'),
(30, 1, 'Permissions', 'menu.permissions', '', '_self', 'voyager-skull', NULL, NULL, 3, '2019-12-23 11:47:46', '2019-12-23 11:49:07', 'voyager.permissions.index', NULL, NULL),
(43, 1, 'Departments', NULL, '', '_self', 'voyager-star', '#000000', NULL, 13, '2020-03-07 06:19:34', '2020-06-23 11:19:20', 'voyager.departments.index', NULL, 'null'),
(59, 1, 'Units', NULL, '', '_self', 'voyager-boat', '#000000', NULL, 19, '2020-06-13 10:57:07', '2020-06-23 11:22:28', 'voyager.units.index', NULL, 'null');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2012_11_03_115237_create_users_table', 1),
(2, '2019_11_03_115237_create_activity_logs_table', 1),
(3, '2019_11_03_115237_create_calendars_table', 1),
(4, '2019_11_03_115237_create_data_rows_table', 1),
(5, '2019_11_03_115237_create_data_types_table', 1),
(6, '2019_11_03_115237_create_designations_table', 1),
(7, '2019_11_03_115237_create_event_types_table', 1),
(8, '2019_11_03_115237_create_menu_items_table', 1),
(9, '2019_11_03_115237_create_menus_table', 1),
(10, '2019_11_03_115237_create_pages_table', 1),
(11, '2019_11_03_115237_create_password_resets_table', 1),
(12, '2019_11_03_115237_create_permission_role_table', 1),
(13, '2019_11_03_115237_create_permissions_table', 1),
(14, '2019_11_03_115237_create_posts_table', 1),
(15, '2019_11_03_115237_create_posts_tags_table', 1),
(16, '2019_11_03_115237_create_roles_table', 1),
(17, '2019_11_03_115237_create_settings_table', 1),
(18, '2019_11_03_115237_create_sms_configs_table', 1),
(19, '2019_11_03_115237_create_sms_sending_logs_table', 1),
(20, '2019_11_03_115237_create_tags_table', 1),
(21, '2019_11_03_115237_create_translations_table', 1),
(22, '2019_11_03_115237_create_user_roles_table', 1),
(23, '2019_11_03_115237_create_users_permissions_table', 1),
(24, '2019_11_03_115237_create_users_posts_table', 1),
(31, '2019_12_11_154635_create_field_supervisors_table', 1),
(32, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(33, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(34, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(35, '2016_06_01_000004_create_oauth_clients_table', 2),
(36, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
(37, '2019_11_14_193657_add_sub_group_to_permissions_table', 3),
(38, '2019_12_10_162451_create_loc_districts_table', 3),
(39, '2019_12_10_162451_create_loc_divisions_table', 3),
(40, '2019_12_10_162451_create_loc_municipalities_table', 3),
(41, '2019_12_10_162451_create_loc_unions_table', 3),
(42, '2019_12_10_162451_create_loc_upazilas_table', 3),
(43, '2019_12_12_122910_create_api_password_resets_table', 3),
(44, '2020_01_26_111028_create_notifications_table', 3),
(45, '2020_02_04_150421_update_user_table_otp_assigned_number', 4),
(48, '2020_03_07_102309_create_requisition_logs_table', 6),
(49, '2020_03_07_121116_create_departments_table', 6),
(50, '2020_03_07_140728_update_users_table_add_department', 7),
(67, '2019_11_28_085924_create_category_table', 8),
(69, '2020_06_06_053514_create_division_table', 8),
(70, '2020_06_06_053641_create_districts_table', 8),
(75, '2020_06_08_110431_create_upazilas_table', 9),
(78, '2019_09_02_175114_create_units_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('amirul1313.diu@gmail.com', '$2y$10$1/0rirx.VzuLXa4ih91Eu.nunWQ8V5n6ZAEfBEaQ9z8/Z8jRvZ6s6', '2020-02-11 12:36:44'),
('amirul1313.diu@gmail.com', '$2y$10$1/0rirx.VzuLXa4ih91Eu.nunWQ8V5n6ZAEfBEaQ9z8/Z8jRvZ6s6', '2020-02-11 12:36:44');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_user_defined` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sub_group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_group_order` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=346 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `table_name`, `is_user_defined`, `created_at`, `updated_at`, `sub_group`, `sub_group_order`) VALUES
(1, 'browse_admin', NULL, 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(2, 'browse_bread', NULL, 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(3, 'browse_database', NULL, 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(4, 'browse_media', NULL, 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(5, 'browse_compass', NULL, 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(6, 'browse_menus', 'menus', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(7, 'read_menus', 'menus', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(8, 'edit_menus', 'menus', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(9, 'add_menus', 'menus', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(10, 'delete_menus', 'menus', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(11, 'browse_roles', 'roles', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(12, 'read_roles', 'roles', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(13, 'edit_roles', 'roles', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(14, 'add_roles', 'roles', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(15, 'delete_roles', 'roles', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(16, 'browse_users', 'users', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(17, 'read_users', 'users', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(18, 'edit_users', 'users', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(19, 'add_users', 'users', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(20, 'delete_users', 'users', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(21, 'browse_settings', 'settings', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(22, 'read_settings', 'settings', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(23, 'edit_settings', 'settings', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(24, 'add_settings', 'settings', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(25, 'delete_settings', 'settings', 0, '2019-12-12 04:28:40', '2019-12-12 04:28:40', NULL, 0),
(26, 'browse_loc_divisions', 'loc_divisions', 0, '2019-12-15 10:24:15', '2019-12-15 10:24:15', NULL, 0),
(27, 'read_loc_divisions', 'loc_divisions', 0, '2019-12-15 10:24:15', '2019-12-15 10:24:15', NULL, 0),
(28, 'edit_loc_divisions', 'loc_divisions', 0, '2019-12-15 10:24:15', '2019-12-15 10:24:15', NULL, 0),
(29, 'add_loc_divisions', 'loc_divisions', 0, '2019-12-15 10:24:15', '2019-12-15 10:24:15', NULL, 0),
(30, 'delete_loc_divisions', 'loc_divisions', 0, '2019-12-15 10:24:15', '2019-12-15 10:24:15', NULL, 0),
(31, 'restore_loc_divisions', 'loc_divisions', 0, '2019-12-15 10:24:15', '2019-12-15 10:24:15', NULL, 0),
(32, 'force_delete_loc_divisions', 'loc_divisions', 0, '2019-12-15 10:24:15', '2019-12-15 10:24:15', NULL, 0),
(33, 'bulk_delete_loc_divisions', 'loc_divisions', 0, '2019-12-15 10:24:15', '2019-12-15 10:24:15', NULL, 0),
(34, 'browse_loc_districts', 'loc_districts', 0, '2019-12-17 04:35:00', '2019-12-17 04:35:00', NULL, 0),
(35, 'read_loc_districts', 'loc_districts', 0, '2019-12-17 04:35:00', '2019-12-17 04:35:00', NULL, 0),
(36, 'edit_loc_districts', 'loc_districts', 0, '2019-12-17 04:35:00', '2019-12-17 04:35:00', NULL, 0),
(37, 'add_loc_districts', 'loc_districts', 0, '2019-12-17 04:35:00', '2019-12-17 04:35:00', NULL, 0),
(38, 'delete_loc_districts', 'loc_districts', 0, '2019-12-17 04:35:00', '2019-12-17 04:35:00', NULL, 0),
(39, 'restore_loc_districts', 'loc_districts', 0, '2019-12-17 04:35:00', '2019-12-17 04:35:00', NULL, 0),
(40, 'force_delete_loc_districts', 'loc_districts', 0, '2019-12-17 04:35:00', '2019-12-17 04:35:00', NULL, 0),
(41, 'bulk_delete_loc_districts', 'loc_districts', 0, '2019-12-17 04:35:00', '2019-12-17 04:35:00', NULL, 0),
(51, 'read_loc_upazilas', 'loc_upazilas', 0, '2019-12-17 06:34:27', '2019-12-17 06:34:27', NULL, 0),
(52, 'edit_loc_upazilas', 'loc_upazilas', 0, '2019-12-17 06:34:27', '2019-12-17 06:34:27', NULL, 0),
(53, 'add_loc_upazilas', 'loc_upazilas', 0, '2019-12-17 06:34:27', '2019-12-17 06:34:27', NULL, 0),
(54, 'delete_loc_upazilas', 'loc_upazilas', 0, '2019-12-17 06:34:27', '2019-12-17 06:34:27', NULL, 0),
(55, 'restore_loc_upazilas', 'loc_upazilas', 0, '2019-12-17 06:34:27', '2019-12-17 06:34:27', NULL, 0),
(56, 'force_delete_loc_upazilas', 'loc_upazilas', 0, '2019-12-17 06:34:27', '2019-12-17 06:34:27', NULL, 0),
(57, 'bulk_delete_loc_upazilas', 'loc_upazilas', 0, '2019-12-17 06:34:27', '2019-12-17 06:34:27', NULL, 0),
(162, 'restore_roles', 'roles', 0, '2019-12-23 05:05:49', '2019-12-23 05:05:49', NULL, 0),
(163, 'force_delete_roles', 'roles', 0, '2019-12-23 05:05:49', '2019-12-23 05:05:49', NULL, 0),
(164, 'bulk_delete_roles', 'roles', 0, '2019-12-23 05:05:49', '2019-12-23 05:05:49', NULL, 0),
(165, 'browse_permissions', 'permissions', 0, '2019-12-23 11:47:46', '2019-12-23 11:47:46', NULL, 0),
(166, 'read_permissions', 'permissions', 0, '2019-12-23 11:47:46', '2019-12-23 11:47:46', NULL, 0),
(167, 'edit_permissions', 'permissions', 0, '2019-12-23 11:47:46', '2019-12-23 11:47:46', NULL, 0),
(168, 'add_permissions', 'permissions', 0, '2019-12-23 11:47:46', '2019-12-23 11:47:46', NULL, 0),
(169, 'delete_permissions', 'permissions', 0, '2019-12-23 11:47:46', '2019-12-23 11:47:46', NULL, 0),
(170, 'restore_permissions', 'permissions', 0, '2019-12-23 11:47:46', '2019-12-23 11:47:46', NULL, 0),
(171, 'force_delete_permissions', 'permissions', 0, '2019-12-23 11:47:46', '2019-12-23 11:47:46', NULL, 0),
(172, 'bulk_delete_permissions', 'permissions', 0, '2019-12-23 11:47:46', '2019-12-23 11:47:46', NULL, 0),
(176, 'restore_users', 'users', 0, '2019-12-23 12:10:10', '2019-12-23 12:10:10', NULL, 0),
(177, 'force_delete_users', 'users', 0, '2019-12-23 12:10:10', '2019-12-23 12:10:10', NULL, 0),
(178, 'bulk_delete_users', 'users', 0, '2019-12-23 12:10:10', '2019-12-23 12:10:10', NULL, 0),
(183, 'edit_user_permissions_users', 'users', 1, '2019-12-24 04:56:11', '2020-06-10 09:08:59', NULL, 0),
(185, 'edit_status_users', 'users', 1, '2019-12-25 14:05:21', '2020-06-10 09:11:46', NULL, 0),
(186, 'edit_role_users', 'users', 1, '2019-12-25 14:05:32', '2019-12-25 14:05:32', NULL, 0),
(200, 'browse_departments', 'departments', 0, '2020-03-07 06:19:34', '2020-03-07 06:19:34', NULL, 0),
(201, 'read_departments', 'departments', 0, '2020-03-07 06:19:34', '2020-03-07 06:19:34', NULL, 0),
(202, 'edit_departments', 'departments', 0, '2020-03-07 06:19:34', '2020-03-07 06:19:34', NULL, 0),
(203, 'add_departments', 'departments', 0, '2020-03-07 06:19:34', '2020-03-07 06:19:34', NULL, 0),
(204, 'delete_departments', 'departments', 0, '2020-03-07 06:19:34', '2020-03-07 06:19:34', NULL, 0),
(205, 'restore_departments', 'departments', 0, '2020-03-07 06:19:34', '2020-03-07 06:19:34', NULL, 0),
(206, 'force_delete_departments', 'departments', 0, '2020-03-07 06:19:34', '2020-03-07 06:19:34', NULL, 0),
(207, 'bulk_delete_departments', 'departments', 0, '2020-03-07 06:19:34', '2020-03-07 06:19:34', NULL, 0),
(290, 'browse_units', 'units', 0, '2020-06-13 10:57:07', '2020-06-13 10:57:07', NULL, 0),
(291, 'read_units', 'units', 0, '2020-06-13 10:57:07', '2020-06-13 10:57:07', NULL, 0),
(292, 'edit_units', 'units', 0, '2020-06-13 10:57:07', '2020-06-13 10:57:07', NULL, 0),
(293, 'add_units', 'units', 0, '2020-06-13 10:57:07', '2020-06-13 10:57:07', NULL, 0),
(294, 'delete_units', 'units', 0, '2020-06-13 10:57:07', '2020-06-13 10:57:07', NULL, 0),
(295, 'restore_units', 'units', 0, '2020-06-13 10:57:07', '2020-06-13 10:57:07', NULL, 0),
(296, 'force_delete_units', 'units', 0, '2020-06-13 10:57:07', '2020-06-13 10:57:07', NULL, 0),
(297, 'bulk_delete_units', 'units', 0, '2020-06-13 10:57:07', '2020-06-13 10:57:07', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(165, 1),
(166, 1),
(167, 1),
(168, 1),
(169, 1),
(170, 1),
(171, 1),
(172, 1),
(183, 1),
(185, 1),
(186, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '2019-12-12 04:28:40', '2019-12-12 04:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
(1, 'site.title', 'Site Title', 'Covid-19', '', 'text', 1, 'Site'),
(2, 'site.description', 'Site Description', NULL, '', 'text', 2, 'Site'),
(3, 'site.logo', 'Site Logo', 'settings\\February2020\\Y28uGrv87MmynxEawO4E.png', '', 'image', 3, 'Site'),
(4, 'site.google_analytics_tracking_id', 'Google Analytics Tracking ID', NULL, '', 'text', 4, 'Site'),
(5, 'admin.bg_image', 'Admin Background Image', 'settings\\February2020\\T8KgwAJxnD9VmjSAxWjT.png', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Admin Title', 'UNIQUE', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Admin Description', NULL, '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Admin Loader', 'settings\\June2020\\WLTipaw6gttDrpAy5UF9.gif', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Admin Icon Image', 'settings\\August2020\\4iPSz3x1hk3vI8cO4rUm.gif', '', 'image', 4, 'Admin'),
(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', NULL, '', 'text', 1, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `translations_name_column_name_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `table_name`, `column_name`, `foreign_key`, `locale`, `value`, `created_at`, `updated_at`) VALUES
(1, 'data_types', 'display_name_singular', 1, 'bn', 'User', '2020-01-13 05:35:23', '2020-01-13 05:35:23'),
(2, 'data_types', 'display_name_plural', 1, 'bn', 'Users', '2020-01-13 05:35:23', '2020-01-13 05:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'pc', 1, NULL, '2020-06-13 11:00:42', '2020-06-13 11:00:42'),
(2, 'Lt', 1, NULL, '2020-06-13 11:00:52', '2020-06-13 11:00:52');

-- --------------------------------------------------------

--
-- Table structure for table `upazilas`
--

DROP TABLE IF EXISTS `upazilas`;
CREATE TABLE IF NOT EXISTS `upazilas` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `district_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `upazilas_name_index` (`name`),
  KEY `upazilas_bn_name_index` (`bn_name`)
) ENGINE=InnoDB AUTO_INCREMENT=618 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `upazilas`
--

INSERT INTO `upazilas` (`id`, `district_id`, `name`, `bn_name`, `url`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 34, 'Amtali', 'à¦†à¦®à¦¤à¦²à§€', NULL, NULL, '0000-00-00 00:00:00', '2016-04-06 13:48:39'),
(2, 34, 'Bamna ', 'à¦¬à¦¾à¦®à¦¨à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 34, 'Barguna Sadar ', 'à¦¬à¦°à¦—à§à¦¨à¦¾ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 34, 'Betagi ', 'à¦¬à§‡à¦¤à¦¾à¦—à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 34, 'Patharghata ', 'à¦ªà¦¾à¦¥à¦°à¦˜à¦¾à¦Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 34, 'Taltali ', 'à¦¤à¦¾à¦²à¦¤à¦²à§€', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 35, 'Muladi ', 'à¦®à§à¦²à¦¾à¦¦à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 35, 'Babuganj ', 'à¦¬à¦¾à¦¬à§à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 35, 'Agailjhara ', 'à¦†à¦—à¦¾à¦‡à¦²à¦à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 35, 'Barisal Sadar ', 'à¦¬à¦°à¦¿à¦¶à¦¾à¦² à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 35, 'Bakerganj ', 'à¦¬à¦¾à¦•à§‡à¦°à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 35, 'Banaripara ', 'à¦¬à¦¾à¦¨à¦¾à§œà¦¿à¦ªà¦¾à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 35, 'Gaurnadi ', 'à¦—à§Œà¦°à¦¨à¦¦à§€', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 35, 'Hizla ', 'à¦¹à¦¿à¦œà¦²à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 35, 'Mehendiganj ', 'à¦®à§‡à¦¹à§‡à¦¦à¦¿à¦—à¦žà§à¦œ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 35, 'Wazirpur ', 'à¦“à§Ÿà¦¾à¦œà¦¿à¦°à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 36, 'Bhola Sadar ', 'à¦­à§‹à¦²à¦¾ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 36, 'Burhanuddin ', 'à¦¬à§à¦°à¦¹à¦¾à¦¨à¦‰à¦¦à§à¦¦à¦¿à¦¨', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 36, 'Char Fasson ', 'à¦šà¦° à¦«à§à¦¯à¦¾à¦¶à¦¨', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 36, 'Daulatkhan ', 'à¦¦à§Œà¦²à¦¤à¦–à¦¾à¦¨', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 36, 'Lalmohan ', 'à¦²à¦¾à¦²à¦®à§‹à¦¹à¦¨', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 36, 'Manpura ', 'à¦®à¦¨à¦ªà§à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 36, 'Tazumuddin ', 'à¦¤à¦¾à¦œà§à¦®à§à¦¦à§à¦¦à¦¿à¦¨', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 37, 'Jhalokati Sadar ', 'à¦à¦¾à¦²à¦•à¦¾à¦ à¦¿ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 37, 'Kathalia ', 'à¦•à¦¾à¦à¦ à¦¾à¦²à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 37, 'Nalchity ', 'à¦¨à¦¾à¦²à¦šà¦¿à¦¤à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 37, 'Rajapur ', 'à¦°à¦¾à¦œà¦¾à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 38, 'Bauphal ', 'à¦¬à¦¾à¦‰à¦«à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 38, 'Dashmina ', 'à¦¦à¦¶à¦®à¦¿à¦¨à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 38, 'Galachipa ', 'à¦—à¦²à¦¾à¦šà¦¿à¦ªà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 38, 'Kalapara ', 'à¦•à¦¾à¦²à¦¾à¦ªà¦¾à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 38, 'Mirzaganj ', 'à¦®à¦¿à¦°à§à¦œà¦¾à¦—à¦žà§à¦œ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 38, 'Patuakhali Sadar ', 'à¦ªà¦Ÿà§à§Ÿà¦¾à¦–à¦¾à¦²à§€ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 38, 'Dumki ', 'à¦¡à§à¦®à¦•à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 38, 'Rangabali ', 'à¦°à¦¾à¦™à§à¦—à¦¾à¦¬à¦¾à¦²à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 39, 'Bhandaria', 'à¦­à§à¦¯à¦¾à¦¨à§à¦¡à¦¾à¦°à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 39, 'Kaukhali', 'à¦•à¦¾à¦‰à¦–à¦¾à¦²à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 39, 'Mathbaria', 'à¦®à¦¾à¦ à¦¬à¦¾à§œà¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 39, 'Nazirpur', 'à¦¨à¦¾à¦œà¦¿à¦°à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 39, 'Nesarabad', 'à¦¨à§‡à¦¸à¦¾à¦°à¦¾à¦¬à¦¾à¦¦', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 39, 'Pirojpur Sadar', 'à¦ªà¦¿à¦°à§‹à¦œà¦ªà§à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 39, 'Zianagar', 'à¦œà¦¿à§Ÿà¦¾à¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 40, 'Bandarban Sadar', 'à¦¬à¦¾à¦¨à§à¦¦à¦°à¦¬à¦¨ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 40, 'Thanchi', 'à¦¥à¦¾à¦¨à¦šà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 40, 'Lama', 'à¦²à¦¾à¦®à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 40, 'Naikhongchhari', 'à¦¨à¦¾à¦‡à¦–à¦‚à¦›à§œà¦¿ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 40, 'Ali kadam', 'à¦†à¦²à§€ à¦•à¦¦à¦®', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 40, 'Rowangchhari', 'à¦°à¦‰à§Ÿà¦¾à¦‚à¦›à§œà¦¿ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 40, 'Ruma', 'à¦°à§à¦®à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 41, 'Brahmanbaria Sadar ', 'à¦¬à§à¦°à¦¾à¦¹à§à¦®à¦£à¦¬à¦¾à§œà¦¿à§Ÿà¦¾ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 41, 'Ashuganj ', 'à¦†à¦¶à§à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, 41, 'Nasirnagar ', 'à¦¨à¦¾à¦¸à¦¿à¦° à¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, 41, 'Nabinagar ', 'à¦¨à¦¬à§€à¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 41, 'Sarail ', 'à¦¸à¦°à¦¾à¦‡à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 41, 'Shahbazpur Town', 'à¦¶à¦¾à¦¹à¦¬à¦¾à¦œà¦ªà§à¦° à¦Ÿà¦¾à¦‰à¦¨', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 41, 'Kasba ', 'à¦•à¦¸à¦¬à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, 41, 'Akhaura ', 'à¦†à¦–à¦¾à¦‰à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 41, 'Bancharampur ', 'à¦¬à¦¾à¦žà§à¦›à¦¾à¦°à¦¾à¦®à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 41, 'Bijoynagar ', 'à¦¬à¦¿à¦œà§Ÿ à¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, 42, 'Chandpur Sadar', 'à¦šà¦¾à¦à¦¦à¦ªà§à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 42, 'Faridganj', 'à¦«à¦°à¦¿à¦¦à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, 42, 'Haimchar', 'à¦¹à¦¾à¦‡à¦®à¦šà¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 42, 'Haziganj', 'à¦¹à¦¾à¦œà§€à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 42, 'Kachua', 'à¦•à¦šà§à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, 42, 'Matlab Uttar', 'à¦®à¦¤à¦²à¦¬ à¦‰à¦¤à§à¦¤à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 42, 'Matlab Dakkhin', 'à¦®à¦¤à¦²à¦¬ à¦¦à¦•à§à¦·à¦¿à¦£', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 42, 'Shahrasti', 'à¦¶à¦¾à¦¹à¦°à¦¾à¦¸à§à¦¤à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, 43, 'Anwara ', 'à¦†à¦¨à§‹à§Ÿà¦¾à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 43, 'Banshkhali ', 'à¦¬à¦¾à¦¶à¦–à¦¾à¦²à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 43, 'Boalkhali ', 'à¦¬à§‹à§Ÿà¦¾à¦²à¦–à¦¾à¦²à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 43, 'Chandanaish ', 'à¦šà¦¨à§à¦¦à¦¨à¦¾à¦‡à¦¶', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, 43, 'Fatikchhari ', 'à¦«à¦Ÿà¦¿à¦•à¦›à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 43, 'Hathazari ', 'à¦¹à¦¾à¦ à¦¹à¦¾à¦œà¦¾à¦°à§€', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(74, 43, 'Lohagara ', 'à¦²à§‹à¦¹à¦¾à¦—à¦¾à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(75, 43, 'Mirsharai ', 'à¦®à¦¿à¦°à¦¸à¦°à¦¾à¦‡', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(76, 43, 'Patiya ', 'à¦ªà¦Ÿà¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(77, 43, 'Rangunia ', 'à¦°à¦¾à¦™à§à¦—à§à¦¨à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(78, 43, 'Raozan ', 'à¦°à¦¾à¦‰à¦œà¦¾à¦¨', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(79, 43, 'Sandwip ', 'à¦¸à¦¨à§à¦¦à§à¦¬à§€à¦ª', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(80, 43, 'Satkania ', 'à¦¸à¦¾à¦¤à¦•à¦¾à¦¨à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(81, 43, 'Sitakunda ', 'à¦¸à§€à¦¤à¦¾à¦•à§à¦£à§à¦¡', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(82, 44, 'Barura ', 'à¦¬à§œà§à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(83, 44, 'Brahmanpara ', 'à¦¬à§à¦°à¦¾à¦¹à§à¦®à¦£à¦ªà¦¾à§œà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(84, 44, 'Burichong ', 'à¦¬à§à§œà¦¿à¦šà¦‚', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(85, 44, 'Chandina ', 'à¦šà¦¾à¦¨à§à¦¦à¦¿à¦¨à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(86, 44, 'Chauddagram ', 'à¦šà§Œà¦¦à§à¦¦à¦—à§à¦°à¦¾à¦®', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(87, 44, 'Daudkandi ', 'à¦¦à¦¾à¦‰à¦¦à¦•à¦¾à¦¨à§à¦¦à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(88, 44, 'Debidwar ', 'à¦¦à§‡à¦¬à§€à¦¦à§à¦¬à¦¾à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(89, 44, 'Homna ', 'à¦¹à§‹à¦®à¦¨à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(90, 44, 'Comilla Sadar ', 'à¦•à§à¦®à¦¿à¦²à§à¦²à¦¾ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(91, 44, 'Laksam ', 'à¦²à¦¾à¦•à¦¸à¦¾à¦®', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(92, 44, 'Monohorgonj ', 'à¦®à¦¨à§‹à¦¹à¦°à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(93, 44, 'Meghna ', 'à¦®à§‡à¦˜à¦¨à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(94, 44, 'Muradnagar ', 'à¦®à§à¦°à¦¾à¦¦à¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(95, 44, 'Nangalkot ', 'à¦¨à¦¾à¦™à§à¦—à¦¾à¦²à¦•à§‹à¦Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(96, 44, 'Comilla Sadar South ', 'à¦•à§à¦®à¦¿à¦²à§à¦²à¦¾ à¦¸à¦¦à¦° à¦¦à¦•à§à¦·à¦¿à¦£', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(97, 44, 'Titas ', 'à¦¤à¦¿à¦¤à¦¾à¦¸', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(98, 45, 'Chakaria ', 'à¦šà¦•à¦°à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(99, 45, 'Chakaria ', 'à¦šà¦•à¦°à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(100, 45, 'Cox\'s Bazar Sadar ', 'à¦•à¦•à§à¦¸ à¦¬à¦¾à¦œà¦¾à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(101, 45, 'Kutubdia ', 'à¦•à§à¦¤à§à¦¬à¦¦à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(102, 45, 'Maheshkhali ', 'à¦®à¦¹à§‡à¦¶à¦–à¦¾à¦²à§€', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(103, 45, 'Ramu ', 'à¦°à¦¾à¦®à§', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(104, 45, 'Teknaf ', 'à¦Ÿà§‡à¦•à¦¨à¦¾à¦«', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(105, 45, 'Ukhia ', 'à¦‰à¦–à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(106, 45, 'Pekua ', 'à¦ªà§‡à¦•à§à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(107, 46, 'Feni Sadar', 'à¦«à§‡à¦¨à§€ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(108, 46, 'Chagalnaiya', 'à¦›à¦¾à¦—à¦² à¦¨à¦¾à¦‡à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(109, 46, 'Daganbhyan', 'à¦¦à¦¾à¦—à¦¾à¦¨à¦­à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(110, 46, 'Parshuram', 'à¦ªà¦°à¦¶à§à¦°à¦¾à¦®', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(111, 46, 'Fhulgazi', 'à¦«à§à¦²à¦—à¦¾à¦œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(112, 46, 'Sonagazi', 'à¦¸à§‹à¦¨à¦¾à¦—à¦¾à¦œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(113, 47, 'Dighinala ', 'à¦¦à¦¿à¦˜à¦¿à¦¨à¦¾à¦²à¦¾ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(114, 47, 'Khagrachhari ', 'à¦–à¦¾à¦—à§œà¦¾à¦›à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(115, 47, 'Lakshmichhari ', 'à¦²à¦•à§à¦·à§à¦®à§€à¦›à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(116, 47, 'Mahalchhari ', 'à¦®à¦¹à¦²à¦›à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(117, 47, 'Manikchhari ', 'à¦®à¦¾à¦¨à¦¿à¦•à¦›à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(118, 47, 'Matiranga ', 'à¦®à¦¾à¦Ÿà¦¿à¦°à¦¾à¦™à§à¦—à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(119, 47, 'Panchhari ', 'à¦ªà¦¾à¦¨à¦›à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(120, 47, 'Ramgarh ', 'à¦°à¦¾à¦®à¦—à§œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(121, 48, 'Lakshmipur Sadar ', 'à¦²à¦•à§à¦·à§à¦®à§€à¦ªà§à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(122, 48, 'Raipur ', 'à¦°à¦¾à§Ÿà¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(123, 48, 'Ramganj ', 'à¦°à¦¾à¦®à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(124, 48, 'Ramgati ', 'à¦°à¦¾à¦®à¦—à¦¤à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(125, 48, 'Komol Nagar ', 'à¦•à¦®à¦² à¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(126, 49, 'Noakhali Sadar ', 'à¦¨à§‹à§Ÿà¦¾à¦–à¦¾à¦²à§€ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(127, 49, 'Begumganj ', 'à¦¬à§‡à¦—à¦®à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(128, 49, 'Chatkhil ', 'à¦šà¦¾à¦Ÿà¦–à¦¿à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(129, 49, 'Companyganj ', 'à¦•à§‹à¦®à§à¦ªà¦¾à¦¨à§€à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(130, 49, 'Shenbag ', 'à¦¶à§‡à¦¨à¦¬à¦¾à¦—', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(131, 49, 'Hatia ', 'à¦¹à¦¾à¦¤à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(132, 49, 'Kobirhat ', 'à¦•à¦¬à¦¿à¦°à¦¹à¦¾à¦Ÿ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(133, 49, 'Sonaimuri ', 'à¦¸à§‹à¦¨à¦¾à¦‡à¦®à§à¦°à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(134, 49, 'Suborno Char ', 'à¦¸à§à¦¬à¦°à§à¦£ à¦šà¦° ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(135, 50, 'Rangamati Sadar ', 'à¦°à¦¾à¦™à§à¦—à¦¾à¦®à¦¾à¦Ÿà¦¿ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(136, 50, 'Belaichhari ', 'à¦¬à§‡à¦²à¦¾à¦‡à¦›à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(137, 50, 'Bagaichhari ', 'à¦¬à¦¾à¦˜à¦¾à¦‡à¦›à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(138, 50, 'Barkal ', 'à¦¬à¦°à¦•à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(139, 50, 'Juraichhari ', 'à¦œà§à¦°à¦¾à¦‡à¦›à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(140, 50, 'Rajasthali ', 'à¦°à¦¾à¦œà¦¾à¦¸à§à¦¥à¦²à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(141, 50, 'Kaptai ', 'à¦•à¦¾à¦ªà§à¦¤à¦¾à¦‡', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(142, 50, 'Langadu ', 'à¦²à¦¾à¦™à§à¦—à¦¾à¦¡à§', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(143, 50, 'Nannerchar ', 'à¦¨à¦¾à¦¨à§à¦¨à§‡à¦°à¦šà¦° ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(144, 50, 'Kaukhali ', 'à¦•à¦¾à¦‰à¦–à¦¾à¦²à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(150, 2, 'Faridpur Sadar ', 'à¦«à¦°à¦¿à¦¦à¦ªà§à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(151, 2, 'Boalmari ', 'à¦¬à§‹à§Ÿà¦¾à¦²à¦®à¦¾à¦°à§€', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(152, 2, 'Alfadanga ', 'à¦†à¦²à¦«à¦¾à¦¡à¦¾à¦™à§à¦—à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(153, 2, 'Madhukhali ', 'à¦®à¦§à§à¦–à¦¾à¦²à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(154, 2, 'Bhanga ', 'à¦­à¦¾à¦™à§à¦—à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(155, 2, 'Nagarkanda ', 'à¦¨à¦—à¦°à¦•à¦¾à¦¨à§à¦¡', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(156, 2, 'Charbhadrasan ', 'à¦šà¦°à¦­à¦¦à§à¦°à¦¾à¦¸à¦¨ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(157, 2, 'Sadarpur ', 'à¦¸à¦¦à¦°à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(158, 2, 'Shaltha ', 'à¦¶à¦¾à¦²à¦¥à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(159, 3, 'Gazipur Sadar-Joydebpur', 'à¦—à¦¾à¦œà§€à¦ªà§à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(160, 3, 'Kaliakior', 'à¦•à¦¾à¦²à¦¿à§Ÿà¦¾à¦•à§ˆà¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(161, 3, 'Kapasia', 'à¦•à¦¾à¦ªà¦¾à¦¸à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(162, 3, 'Sripur', 'à¦¶à§à¦°à§€à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(163, 3, 'Kaliganj', 'à¦•à¦¾à¦²à§€à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(164, 3, 'Tongi', 'à¦Ÿà¦™à§à¦—à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(165, 4, 'Gopalganj Sadar ', 'à¦—à§‹à¦ªà¦¾à¦²à¦—à¦žà§à¦œ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(166, 4, 'Kashiani ', 'à¦•à¦¾à¦¶à¦¿à§Ÿà¦¾à¦¨à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(167, 4, 'Kotalipara ', 'à¦•à§‹à¦Ÿà¦¾à¦²à¦¿à¦ªà¦¾à§œà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(168, 4, 'Muksudpur ', 'à¦®à§à¦•à¦¸à§à¦¦à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(169, 4, 'Tungipara ', 'à¦Ÿà§à¦™à§à¦—à¦¿à¦ªà¦¾à§œà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(170, 5, 'Dewanganj ', 'à¦¦à§‡à¦“à§Ÿà¦¾à¦¨à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(171, 5, 'Baksiganj ', 'à¦¬à¦•à¦¸à¦¿à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(172, 5, 'Islampur ', 'à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(173, 5, 'Jamalpur Sadar ', 'à¦œà¦¾à¦®à¦¾à¦²à¦ªà§à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(174, 5, 'Madarganj ', 'à¦®à¦¾à¦¦à¦¾à¦°à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(175, 5, 'Melandaha ', 'à¦®à§‡à¦²à¦¾à¦¨à¦¦à¦¾à¦¹à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(176, 5, 'Sarishabari ', 'à¦¸à¦°à¦¿à¦·à¦¾à¦¬à¦¾à§œà¦¿ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(177, 5, 'Narundi Police I.C', 'à¦¨à¦¾à¦°à§à¦¨à§à¦¦à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(178, 6, 'Astagram ', 'à¦…à¦·à§à¦Ÿà¦—à§à¦°à¦¾à¦®', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(179, 6, 'Bajitpur ', 'à¦¬à¦¾à¦œà¦¿à¦¤à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(180, 6, 'Bhairab ', 'à¦­à§ˆà¦°à¦¬', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(181, 6, 'Hossainpur ', 'à¦¹à§‹à¦¸à§‡à¦¨à¦ªà§à¦° ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(182, 6, 'Itna ', 'à¦‡à¦Ÿà¦¨à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(183, 6, 'Karimganj ', 'à¦•à¦°à¦¿à¦®à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(184, 6, 'Katiadi ', 'à¦•à¦¤à¦¿à§Ÿà¦¾à¦¦à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(185, 6, 'Kishoreganj Sadar ', 'à¦•à¦¿à¦¶à§‹à¦°à¦—à¦žà§à¦œ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(186, 6, 'Kuliarchar ', 'à¦•à§à¦²à¦¿à§Ÿà¦¾à¦°à¦šà¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(187, 6, 'Mithamain ', 'à¦®à¦¿à¦ à¦¾à¦®à¦¾à¦‡à¦¨', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(188, 6, 'Nikli ', 'à¦¨à¦¿à¦•à¦²à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(189, 6, 'Pakundia ', 'à¦ªà¦¾à¦•à§à¦¨à§à¦¡à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(190, 6, 'Tarail ', 'à¦¤à¦¾à§œà¦¾à¦‡à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(191, 7, 'Madaripur Sadar', 'à¦®à¦¾à¦¦à¦¾à¦°à§€à¦ªà§à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(192, 7, 'Kalkini', 'à¦•à¦¾à¦²à¦•à¦¿à¦¨à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(193, 7, 'Rajoir', 'à¦°à¦¾à¦œà¦‡à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(194, 7, 'Shibchar', 'à¦¶à¦¿à¦¬à¦šà¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(195, 8, 'Manikganj Sadar ', 'à¦®à¦¾à¦¨à¦¿à¦•à¦—à¦žà§à¦œ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(196, 8, 'Singair ', 'à¦¸à¦¿à¦™à§à¦—à¦¾à¦‡à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(197, 8, 'Shibalaya ', 'à¦¶à¦¿à¦¬à¦¾à¦²à§Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(198, 8, 'Saturia ', 'à¦¸à¦¾à¦ à§à¦°à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(199, 8, 'Harirampur ', 'à¦¹à¦°à¦¿à¦°à¦¾à¦®à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(200, 8, 'Ghior ', 'à¦˜à¦¿à¦“à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(201, 8, 'Daulatpur ', 'à¦¦à§Œà¦²à¦¤à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(202, 9, 'Lohajang ', 'à¦²à§‹à¦¹à¦¾à¦œà¦‚', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(203, 9, 'Sreenagar ', 'à¦¶à§à¦°à§€à¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(204, 9, 'Munshiganj Sadar ', 'à¦®à§à¦¨à§à¦¸à¦¿à¦—à¦žà§à¦œ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(205, 9, 'Sirajdikhan ', 'à¦¸à¦¿à¦°à¦¾à¦œà¦¦à¦¿à¦–à¦¾à¦¨', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(206, 9, 'Tongibari ', 'à¦Ÿà¦™à§à¦—à¦¿à¦¬à¦¾à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(207, 9, 'Gazaria ', 'à¦—à¦œà¦¾à¦°à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(208, 10, 'Bhaluka', 'à¦­à¦¾à¦²à§à¦•à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(209, 10, 'Trishal', 'à¦¤à§à¦°à¦¿à¦¶à¦¾à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(210, 10, 'Haluaghat', 'à¦¹à¦¾à¦²à§à§Ÿà¦¾à¦˜à¦¾à¦Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(211, 10, 'Muktagachha', 'à¦®à§à¦•à§à¦¤à¦¾à¦—à¦¾à¦›à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(212, 10, 'Dhobaura', 'à¦§à¦¬à¦¾à¦°à§à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(213, 10, 'Fulbaria', 'à¦«à§à¦²à¦¬à¦¾à§œà¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(214, 10, 'Gaffargaon', 'à¦—à¦«à¦°à¦—à¦¾à¦à¦“', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(215, 10, 'Gauripur', 'à¦—à§Œà¦°à¦¿à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(216, 10, 'Ishwarganj', 'à¦ˆà¦¶à§à¦¬à¦°à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(217, 10, 'Mymensingh Sadar', 'à¦®à§Ÿà¦®à¦¨à¦¸à¦¿à¦‚ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(218, 10, 'Nandail', 'à¦¨à¦¨à§à¦¦à¦¾à¦‡à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(219, 10, 'Phulpur', 'à¦«à§à¦²à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(220, 11, 'Araihazar ', 'à¦†à§œà¦¾à¦‡à¦¹à¦¾à¦œà¦¾à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(221, 11, 'Sonargaon ', 'à¦¸à§‹à¦¨à¦¾à¦°à¦—à¦¾à¦à¦“', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(222, 11, 'Bandar', 'à¦¬à¦¾à¦¨à§à¦¦à¦¾à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(223, 11, 'Naryanganj Sadar ', 'à¦¨à¦¾à¦°à¦¾à§Ÿà¦¾à¦¨à¦—à¦žà§à¦œ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(224, 11, 'Rupganj ', 'à¦°à§‚à¦ªà¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(225, 11, 'Siddirgonj ', 'à¦¸à¦¿à¦¦à§à¦§à¦¿à¦°à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(226, 12, 'Belabo ', 'à¦¬à§‡à¦²à¦¾à¦¬à§‹', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(227, 12, 'Monohardi ', 'à¦®à¦¨à§‹à¦¹à¦°à¦¦à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(228, 12, 'Narsingdi Sadar ', 'à¦¨à¦°à¦¸à¦¿à¦‚à¦¦à§€ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(229, 12, 'Palash ', 'à¦ªà¦²à¦¾à¦¶', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(230, 12, 'Raipura , Narsingdi', 'à¦°à¦¾à§Ÿà¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(231, 12, 'Shibpur ', 'à¦¶à¦¿à¦¬à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(232, 13, 'Kendua Upazilla', 'à¦•à§‡à¦¨à§à¦¦à§à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(233, 13, 'Atpara Upazilla', 'à¦†à¦Ÿà¦ªà¦¾à§œà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(234, 13, 'Barhatta Upazilla', 'à¦¬à¦°à¦¹à¦¾à¦Ÿà§à¦Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(235, 13, 'Durgapur Upazilla', 'à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(236, 13, 'Kalmakanda Upazilla', 'à¦•à¦²à¦®à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(237, 13, 'Madan Upazilla', 'à¦®à¦¦à¦¨', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(238, 13, 'Mohanganj Upazilla', 'à¦®à§‹à¦¹à¦¨à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(239, 13, 'Netrakona-S Upazilla', 'à¦¨à§‡à¦¤à§à¦°à¦•à§‹à¦¨à¦¾ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(240, 13, 'Purbadhala Upazilla', 'à¦ªà§‚à¦°à§à¦¬à¦§à¦²à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(241, 13, 'Khaliajuri Upazilla', 'à¦–à¦¾à¦²à¦¿à§Ÿà¦¾à¦œà§à¦°à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(242, 14, 'Baliakandi ', 'à¦¬à¦¾à¦²à¦¿à§Ÿà¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(243, 14, 'Goalandaghat ', 'à¦—à§‹à§Ÿà¦¾à¦²à¦¨à§à¦¦ à¦˜à¦¾à¦Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(244, 14, 'Pangsha ', 'à¦ªà¦¾à¦‚à¦¶à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(245, 14, 'Kalukhali ', 'à¦•à¦¾à¦²à§à¦–à¦¾à¦²à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(246, 14, 'Rajbari Sadar ', 'à¦°à¦¾à¦œà¦¬à¦¾à§œà¦¿ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(247, 15, 'Shariatpur Sadar -Palong', 'à¦¶à¦°à§€à§Ÿà¦¤à¦ªà§à¦° à¦¸à¦¦à¦° ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(248, 15, 'Damudya ', 'à¦¦à¦¾à¦®à§à¦¦à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(249, 15, 'Naria ', 'à¦¨à§œà¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(250, 15, 'Jajira ', 'à¦œà¦¾à¦œà¦¿à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(251, 15, 'Bhedarganj ', 'à¦­à§‡à¦¦à¦¾à¦°à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(252, 15, 'Gosairhat ', 'à¦—à§‹à¦¸à¦¾à¦‡à¦° à¦¹à¦¾à¦Ÿ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(253, 16, 'Jhenaigati ', 'à¦à¦¿à¦¨à¦¾à¦‡à¦—à¦¾à¦¤à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(254, 16, 'Nakla ', 'à¦¨à¦¾à¦•à¦²à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(255, 16, 'Nalitabari ', 'à¦¨à¦¾à¦²à¦¿à¦¤à¦¾à¦¬à¦¾à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(256, 16, 'Sherpur Sadar ', 'à¦¶à§‡à¦°à¦ªà§à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(257, 16, 'Sreebardi ', 'à¦¶à§à¦°à§€à¦¬à¦°à¦¦à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(258, 17, 'Tangail Sadar ', 'à¦Ÿà¦¾à¦™à§à¦—à¦¾à¦‡à¦² à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(259, 17, 'Sakhipur ', 'à¦¸à¦–à¦¿à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(260, 17, 'Basail ', 'à¦¬à¦¸à¦¾à¦‡à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(261, 17, 'Madhupur ', 'à¦®à¦§à§à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(262, 17, 'Ghatail ', 'à¦˜à¦¾à¦Ÿà¦¾à¦‡à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(263, 17, 'Kalihati ', 'à¦•à¦¾à¦²à¦¿à¦¹à¦¾à¦¤à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(264, 17, 'Nagarpur ', 'à¦¨à¦—à¦°à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(265, 17, 'Mirzapur ', 'à¦®à¦¿à¦°à§à¦œà¦¾à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(266, 17, 'Gopalpur ', 'à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(267, 17, 'Delduar ', 'à¦¦à§‡à¦²à¦¦à§à§Ÿà¦¾à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(268, 17, 'Bhuapur ', 'à¦­à§à§Ÿà¦¾à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(269, 17, 'Dhanbari ', 'à¦§à¦¾à¦¨à¦¬à¦¾à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(270, 55, 'Bagerhat Sadar ', 'à¦¬à¦¾à¦—à§‡à¦°à¦¹à¦¾à¦Ÿ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(271, 55, 'Chitalmari ', 'à¦šà¦¿à¦¤à¦²à¦®à¦¾à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(272, 55, 'Fakirhat ', 'à¦«à¦•à¦¿à¦°à¦¹à¦¾à¦Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(273, 55, 'Kachua ', 'à¦•à¦šà§à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(274, 55, 'Mollahat ', 'à¦®à§‹à¦²à§à¦²à¦¾à¦¹à¦¾à¦Ÿ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(275, 55, 'Mongla ', 'à¦®à¦‚à¦²à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(276, 55, 'Morrelganj ', 'à¦®à¦°à§‡à¦²à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(277, 55, 'Rampal ', 'à¦°à¦¾à¦®à¦ªà¦¾à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(278, 55, 'Sarankhola ', 'à¦¸à§à¦®à¦°à¦£à¦–à§‹à¦²à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(279, 56, 'Damurhuda ', 'à¦¦à¦¾à¦®à§à¦°à¦¹à§à¦¦à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(280, 56, 'Chuadanga-S ', 'à¦šà§à§Ÿà¦¾à¦¡à¦¾à¦™à§à¦—à¦¾ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(281, 56, 'Jibannagar ', 'à¦œà§€à¦¬à¦¨ à¦¨à¦—à¦° ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(282, 56, 'Alamdanga ', 'à¦†à¦²à¦®à¦¡à¦¾à¦™à§à¦—à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(283, 57, 'Abhaynagar ', 'à¦…à¦­à§Ÿà¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(284, 57, 'Keshabpur ', 'à¦•à§‡à¦¶à¦¬à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(285, 57, 'Bagherpara ', 'à¦¬à¦¾à¦˜à§‡à¦° à¦ªà¦¾à§œà¦¾ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(286, 57, 'Jessore Sadar ', 'à¦¯à¦¶à§‹à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(287, 57, 'Chaugachha ', 'à¦šà§Œà¦—à¦¾à¦›à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(288, 57, 'Manirampur ', 'à¦®à¦¨à¦¿à¦°à¦¾à¦®à¦ªà§à¦° ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(289, 57, 'Jhikargachha ', 'à¦à¦¿à¦•à¦°à¦—à¦¾à¦›à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(290, 57, 'Sharsha ', 'à¦¸à¦¾à¦°à¦¶à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(291, 58, 'Jhenaidah Sadar ', 'à¦à¦¿à¦¨à¦¾à¦‡à¦¦à¦¹ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(292, 58, 'Maheshpur ', 'à¦®à¦¹à§‡à¦¶à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(293, 58, 'Kaliganj ', 'à¦•à¦¾à¦²à§€à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(294, 58, 'Kotchandpur ', 'à¦•à§‹à¦Ÿ à¦šà¦¾à¦à¦¦à¦ªà§à¦° ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(295, 58, 'Shailkupa ', 'à¦¶à§ˆà¦²à¦•à§à¦ªà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(296, 58, 'Harinakunda ', 'à¦¹à¦¾à§œà¦¿à¦¨à¦¾à¦•à§à¦¨à§à¦¦à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(297, 59, 'Terokhada ', 'à¦¤à§‡à¦°à§‹à¦–à¦¾à¦¦à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(298, 59, 'Batiaghata ', 'à¦¬à¦¾à¦Ÿà¦¿à§Ÿà¦¾à¦˜à¦¾à¦Ÿà¦¾ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(299, 59, 'Dacope ', 'à¦¡à¦¾à¦•à¦ªà§‡', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(300, 59, 'Dumuria ', 'à¦¡à§à¦®à§à¦°à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(301, 59, 'Dighalia ', 'à¦¦à¦¿à¦˜à¦²à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(302, 59, 'Koyra ', 'à¦•à§Ÿà§œà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(303, 59, 'Paikgachha ', 'à¦ªà¦¾à¦‡à¦•à¦—à¦¾à¦›à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(304, 59, 'Phultala ', 'à¦«à§à¦²à¦¤à¦²à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(305, 59, 'Rupsa ', 'à¦°à§‚à¦ªà¦¸à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(306, 60, 'Kushtia Sadar', 'à¦•à§à¦·à§à¦Ÿà¦¿à§Ÿà¦¾ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(307, 60, 'Kumarkhali', 'à¦•à§à¦®à¦¾à¦°à¦–à¦¾à¦²à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(308, 60, 'Daulatpur', 'à¦¦à§Œà¦²à¦¤à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(309, 60, 'Mirpur', 'à¦®à¦¿à¦°à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(310, 60, 'Bheramara', 'à¦­à§‡à¦°à¦¾à¦®à¦¾à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(311, 60, 'Khoksa', 'à¦–à§‹à¦•à¦¸à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(312, 61, 'Magura Sadar ', 'à¦®à¦¾à¦—à§à¦°à¦¾ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(313, 61, 'Mohammadpur ', 'à¦®à§‹à¦¹à¦¾à¦®à§à¦®à¦¾à¦¦à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(314, 61, 'Shalikha ', 'à¦¶à¦¾à¦²à¦¿à¦–à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(315, 61, 'Sreepur ', 'à¦¶à§à¦°à§€à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(316, 62, 'angni ', 'à¦†à¦‚à¦¨à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(317, 62, 'Mujib Nagar ', 'à¦®à§à¦œà¦¿à¦¬ à¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(318, 62, 'Meherpur-S ', 'à¦®à§‡à¦¹à§‡à¦°à¦ªà§à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(319, 63, 'Narail-S Upazilla', 'à¦¨à§œà¦¾à¦‡à¦² à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(320, 63, 'Lohagara Upazilla', 'à¦²à§‹à¦¹à¦¾à¦—à¦¾à§œà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(321, 63, 'Kalia Upazilla', 'à¦•à¦¾à¦²à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(322, 64, 'Satkhira Sadar ', 'à¦¸à¦¾à¦¤à¦•à§à¦·à§€à¦°à¦¾ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(323, 64, 'Assasuni ', 'à¦†à¦¸à¦¸à¦¾à¦¶à§à¦¨à¦¿ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(324, 64, 'Debhata ', 'à¦¦à§‡à¦­à¦¾à¦Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(325, 64, 'Tala ', 'à¦¤à¦¾à¦²à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(326, 64, 'Kalaroa ', 'à¦•à¦²à¦°à§‹à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(327, 64, 'Kaliganj ', 'à¦•à¦¾à¦²à§€à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(328, 64, 'Shyamnagar ', 'à¦¶à§à¦¯à¦¾à¦®à¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(329, 18, 'Adamdighi', 'à¦†à¦¦à¦®à¦¦à¦¿à¦˜à§€', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(330, 18, 'Bogra Sadar', 'à¦¬à¦—à§à§œà¦¾ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(331, 18, 'Sherpur', 'à¦¶à§‡à¦°à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(332, 18, 'Dhunat', 'à¦§à§à¦¨à¦Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(333, 18, 'Dhupchanchia', 'à¦¦à§à¦ªà¦šà¦¾à¦šà¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(334, 18, 'Gabtali', 'à¦—à¦¾à¦¬à¦¤à¦²à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(335, 18, 'Kahaloo', 'à¦•à¦¾à¦¹à¦¾à¦²à§', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(336, 18, 'Nandigram', 'à¦¨à¦¨à§à¦¦à¦¿à¦—à§à¦°à¦¾à¦®', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(337, 18, 'Sahajanpur', 'à¦¶à¦¾à¦¹à¦œà¦¾à¦¹à¦¾à¦¨à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(338, 18, 'Sariakandi', 'à¦¸à¦¾à¦°à¦¿à§Ÿà¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(339, 18, 'Shibganj', 'à¦¶à¦¿à¦¬à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(340, 18, 'Sonatala', 'à¦¸à§‹à¦¨à¦¾à¦¤à¦²à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(341, 19, 'Joypurhat S', 'à¦œà§Ÿà¦ªà§à¦°à¦¹à¦¾à¦Ÿ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(342, 19, 'Akkelpur', 'à¦†à¦•à§à¦•à§‡à¦²à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(343, 19, 'Kalai', 'à¦•à¦¾à¦²à¦¾à¦‡', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(344, 19, 'Khetlal', 'à¦–à§‡à¦¤à¦²à¦¾à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(345, 19, 'Panchbibi', 'à¦ªà¦¾à¦à¦šà¦¬à¦¿à¦¬à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(346, 20, 'Naogaon Sadar ', 'à¦¨à¦“à¦—à¦¾à¦ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(347, 20, 'Mohadevpur ', 'à¦®à¦¹à¦¾à¦¦à§‡à¦¬à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(348, 20, 'Manda ', 'à¦®à¦¾à¦¨à§à¦¦à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(349, 20, 'Niamatpur ', 'à¦¨à¦¿à§Ÿà¦¾à¦®à¦¤à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(350, 20, 'Atrai ', 'à¦†à¦¤à§à¦°à¦¾à¦‡', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(351, 20, 'Raninagar ', 'à¦°à¦¾à¦£à§€à¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(352, 20, 'Patnitala ', 'à¦ªà¦¤à§à¦¨à§€à¦¤à¦²à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(353, 20, 'Dhamoirhat ', 'à¦§à¦¾à¦®à¦‡à¦°à¦¹à¦¾à¦Ÿ ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(354, 20, 'Sapahar ', 'à¦¸à¦¾à¦ªà¦¾à¦¹à¦¾à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(355, 20, 'Porsha ', 'à¦ªà§‹à¦°à¦¶à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(356, 20, 'Badalgachhi ', 'à¦¬à¦¦à¦²à¦—à¦¾à¦›à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(357, 21, 'Natore Sadar ', 'à¦¨à¦¾à¦Ÿà§‹à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(358, 21, 'Baraigram ', 'à¦¬à§œà¦¾à¦‡à¦—à§à¦°à¦¾à¦®', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(359, 21, 'Bagatipara ', 'à¦¬à¦¾à¦—à¦¾à¦¤à¦¿à¦ªà¦¾à§œà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(360, 21, 'Lalpur ', 'à¦²à¦¾à¦²à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(361, 21, 'Natore Sadar ', 'à¦¨à¦¾à¦Ÿà§‹à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(362, 21, 'Baraigram ', 'à¦¬à§œà¦¾à¦‡ à¦—à§à¦°à¦¾à¦®', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(363, 22, 'Bholahat ', 'à¦­à§‹à¦²à¦¾à¦¹à¦¾à¦Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(364, 22, 'Gomastapur ', 'à¦—à§‹à¦®à¦¸à§à¦¤à¦¾à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(365, 22, 'Nachole ', 'à¦¨à¦¾à¦šà§‹à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(366, 22, 'Nawabganj Sadar ', 'à¦¨à¦¬à¦¾à¦¬à¦—à¦žà§à¦œ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(367, 22, 'Shibganj ', 'à¦¶à¦¿à¦¬à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(368, 23, 'Atgharia ', 'à¦†à¦Ÿà¦˜à¦°à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(369, 23, 'Bera ', 'à¦¬à§‡à§œà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(370, 23, 'Bhangura ', 'à¦­à¦¾à¦™à§à¦—à§à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(371, 23, 'Chatmohar ', 'à¦šà¦¾à¦Ÿà¦®à§‹à¦¹à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(372, 23, 'Faridpur ', 'à¦«à¦°à¦¿à¦¦à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(373, 23, 'Ishwardi ', 'à¦ˆà¦¶à§à¦¬à¦°à¦¦à§€', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(374, 23, 'Pabna Sadar ', 'à¦ªà¦¾à¦¬à¦¨à¦¾ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(375, 23, 'Santhia ', 'à¦¸à¦¾à¦¥à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(376, 23, 'Sujanagar ', 'à¦¸à§à¦œà¦¾à¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(377, 24, 'Bagha', 'à¦¬à¦¾à¦˜à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(378, 24, 'Bagmara', 'à¦¬à¦¾à¦—à¦®à¦¾à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(379, 24, 'Charghat', 'à¦šà¦¾à¦°à¦˜à¦¾à¦Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(380, 24, 'Durgapur', 'à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(381, 24, 'Godagari', 'à¦—à§‹à¦¦à¦¾à¦—à¦¾à¦°à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(382, 24, 'Mohanpur', 'à¦®à§‹à¦¹à¦¨à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(383, 24, 'Paba', 'à¦ªà¦¬à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(384, 24, 'Puthia', 'à¦ªà§à¦ à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(385, 24, 'Tanore', 'à¦¤à¦¾à¦¨à§‹à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(386, 25, 'Sirajganj Sadar ', 'à¦¸à¦¿à¦°à¦¾à¦œà¦—à¦žà§à¦œ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(387, 25, 'Belkuchi ', 'à¦¬à§‡à¦²à¦•à§à¦šà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(388, 25, 'Chauhali ', 'à¦šà§Œà¦¹à¦¾à¦²à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(389, 25, 'Kamarkhanda ', 'à¦•à¦¾à¦®à¦¾à¦°à¦–à¦¾à¦¨à§à¦¦à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(390, 25, 'Kazipur ', 'à¦•à¦¾à¦œà§€à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(391, 25, 'Raiganj ', 'à¦°à¦¾à§Ÿà¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(392, 25, 'Shahjadpur ', 'à¦¶à¦¾à¦¹à¦œà¦¾à¦¦à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(393, 25, 'Tarash ', 'à¦¤à¦¾à¦°à¦¾à¦¶', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(394, 25, 'Ullahpara ', 'à¦‰à¦²à§à¦²à¦¾à¦ªà¦¾à§œà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(395, 26, 'Birampur ', 'à¦¬à¦¿à¦°à¦¾à¦®à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(396, 26, 'Birganj', 'à¦¬à§€à¦°à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(397, 26, 'Biral ', 'à¦¬à¦¿à§œà¦¾à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(398, 26, 'Bochaganj ', 'à¦¬à§‹à¦šà¦¾à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(399, 26, 'Chirirbandar ', 'à¦šà¦¿à¦°à¦¿à¦°à¦¬à¦¨à§à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(400, 26, 'Phulbari ', 'à¦«à§à¦²à¦¬à¦¾à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(401, 26, 'Ghoraghat ', 'à¦˜à§‹à§œà¦¾à¦˜à¦¾à¦Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(402, 26, 'Hakimpur ', 'à¦¹à¦¾à¦•à¦¿à¦®à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(403, 26, 'Kaharole ', 'à¦•à¦¾à¦¹à¦¾à¦°à§‹à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(404, 26, 'Khansama ', 'à¦–à¦¾à¦¨à¦¸à¦¾à¦®à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(405, 26, 'Dinajpur Sadar ', 'à¦¦à¦¿à¦¨à¦¾à¦œà¦ªà§à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(406, 26, 'Nawabganj', 'à¦¨à¦¬à¦¾à¦¬à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(407, 26, 'Parbatipur ', 'à¦ªà¦¾à¦°à§à¦¬à¦¤à§€à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(408, 27, 'Fulchhari', 'à¦«à§à¦²à¦›à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(409, 27, 'Gaibandha sadar', 'à¦—à¦¾à¦‡à¦¬à¦¾à¦¨à§à¦§à¦¾ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(410, 27, 'Gobindaganj', 'à¦—à§‹à¦¬à¦¿à¦¨à§à¦¦à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(411, 27, 'Palashbari', 'à¦ªà¦²à¦¾à¦¶à¦¬à¦¾à§œà§€', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(412, 27, 'Sadullapur', 'à¦¸à¦¾à¦¦à§à¦²à§à¦¯à¦¾à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(413, 27, 'Saghata', 'à¦¸à¦¾à¦˜à¦¾à¦Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(414, 27, 'Sundarganj', 'à¦¸à§à¦¨à§à¦¦à¦°à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(415, 28, 'Kurigram Sadar', 'à¦•à§à§œà¦¿à¦—à§à¦°à¦¾à¦® à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(416, 28, 'Nageshwari', 'à¦¨à¦¾à¦—à§‡à¦¶à§à¦¬à¦°à§€', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(417, 28, 'Bhurungamari', 'à¦­à§à¦°à§à¦™à§à¦—à¦¾à¦®à¦¾à¦°à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(418, 28, 'Phulbari', 'à¦«à§à¦²à¦¬à¦¾à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(419, 28, 'Rajarhat', 'à¦°à¦¾à¦œà¦¾à¦°à¦¹à¦¾à¦Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(420, 28, 'Ulipur', 'à¦‰à¦²à¦¿à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(421, 28, 'Chilmari', 'à¦šà¦¿à¦²à¦®à¦¾à¦°à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(422, 28, 'Rowmari', 'à¦°à¦‰à¦®à¦¾à¦°à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(423, 28, 'Char Rajibpur', 'à¦šà¦° à¦°à¦¾à¦œà¦¿à¦¬à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(424, 29, 'Lalmanirhat Sadar', 'à¦²à¦¾à¦²à¦®à¦¨à¦¿à¦°à¦¹à¦¾à¦Ÿ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(425, 29, 'Aditmari', 'à¦†à¦¦à¦¿à¦¤à¦®à¦¾à¦°à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(426, 29, 'Kaliganj', 'à¦•à¦¾à¦²à§€à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(427, 29, 'Hatibandha', 'à¦¹à¦¾à¦¤à¦¿à¦¬à¦¾à¦¨à§à¦§à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(428, 29, 'Patgram', 'à¦ªà¦¾à¦Ÿà¦—à§à¦°à¦¾à¦®', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(429, 30, 'Nilphamari Sadar', 'à¦¨à§€à¦²à¦«à¦¾à¦®à¦¾à¦°à§€ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(430, 30, 'Saidpur', 'à¦¸à§ˆà§Ÿà¦¦à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(431, 30, 'Jaldhaka', 'à¦œà¦²à¦¢à¦¾à¦•à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(432, 30, 'Kishoreganj', 'à¦•à¦¿à¦¶à§‹à¦°à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(433, 30, 'Domar', 'à¦¡à§‹à¦®à¦¾à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(434, 30, 'Dimla', 'à¦¡à¦¿à¦®à¦²à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(435, 31, 'Panchagarh Sadar', 'à¦ªà¦žà§à¦šà¦—à§œ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(436, 31, 'Debiganj', 'à¦¦à§‡à¦¬à§€à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(437, 31, 'Boda', 'à¦¬à§‹à¦¦à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(438, 31, 'Atwari', 'à¦†à¦Ÿà§‹à§Ÿà¦¾à¦°à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(439, 31, 'Tetulia', 'à¦¤à§‡à¦¤à§à¦²à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(440, 32, 'Badarganj', 'à¦¬à¦¦à¦°à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(441, 32, 'Mithapukur', 'à¦®à¦¿à¦ à¦¾à¦ªà§à¦•à§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(442, 32, 'Gangachara', 'à¦—à¦™à§à¦—à¦¾à¦šà¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(443, 32, 'Kaunia', 'à¦•à¦¾à¦‰à¦¨à¦¿à§Ÿà¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(444, 32, 'Rangpur Sadar', 'à¦°à¦‚à¦ªà§à¦° à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(445, 32, 'Pirgachha', 'à¦ªà§€à¦°à¦—à¦¾à¦›à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(446, 32, 'Pirganj', 'à¦ªà§€à¦°à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(447, 32, 'Taraganj', 'à¦¤à¦¾à¦°à¦¾à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(448, 33, 'Thakurgaon Sadar ', 'à¦ à¦¾à¦•à§à¦°à¦—à¦¾à¦à¦“ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(449, 33, 'Pirganj ', 'à¦ªà§€à¦°à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(450, 33, 'Baliadangi ', 'à¦¬à¦¾à¦²à¦¿à§Ÿà¦¾à¦¡à¦¾à¦™à§à¦—à¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(451, 33, 'Haripur ', 'à¦¹à¦°à¦¿à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(452, 33, 'Ranisankail ', 'à¦°à¦¾à¦£à§€à¦¸à¦‚à¦•à¦‡à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(453, 51, 'Ajmiriganj', 'à¦†à¦œà¦®à¦¿à¦°à¦¿à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(454, 51, 'Baniachang', 'à¦¬à¦¾à¦¨à¦¿à§Ÿà¦¾à¦šà¦‚', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(455, 51, 'Bahubal', 'à¦¬à¦¾à¦¹à§à¦¬à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(456, 51, 'Chunarughat', 'à¦šà§à¦¨à¦¾à¦°à§à¦˜à¦¾à¦Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(457, 51, 'Habiganj Sadar', 'à¦¹à¦¬à¦¿à¦—à¦žà§à¦œ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(458, 51, 'Lakhai', 'à¦²à¦¾à¦•à§à¦·à¦¾à¦‡', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(459, 51, 'Madhabpur', 'à¦®à¦¾à¦§à¦¬à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(460, 51, 'Nabiganj', 'à¦¨à¦¬à§€à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(461, 51, 'Shaistagonj ', 'à¦¶à¦¾à§Ÿà§‡à¦¸à§à¦¤à¦¾à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(462, 52, 'Moulvibazar Sadar', 'à¦®à§Œà¦²à¦­à§€à¦¬à¦¾à¦œà¦¾à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(463, 52, 'Barlekha', 'à¦¬à§œà¦²à§‡à¦–à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(464, 52, 'Juri', 'à¦œà§à§œà¦¿', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `upazilas` (`id`, `district_id`, `name`, `bn_name`, `url`, `deleted_at`, `created_at`, `updated_at`) VALUES
(465, 52, 'Kamalganj', 'à¦•à¦¾à¦®à¦¾à¦²à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(466, 52, 'Kulaura', 'à¦•à§à¦²à¦¾à¦‰à¦°à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(467, 52, 'Rajnagar', 'à¦°à¦¾à¦œà¦¨à¦—à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(468, 52, 'Sreemangal', 'à¦¶à§à¦°à§€à¦®à¦™à§à¦—à¦²', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(469, 53, 'Bishwamvarpur', 'à¦¬à¦¿à¦¸à¦¶à¦®à§à¦­à¦¾à¦°à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(470, 53, 'Chhatak', 'à¦›à¦¾à¦¤à¦•', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(471, 53, 'Derai', 'à¦¦à§‡à§œà¦¾à¦‡', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(472, 53, 'Dharampasha', 'à¦§à¦°à¦®à¦ªà¦¾à¦¶à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(473, 53, 'Dowarabazar', 'à¦¦à§‹à§Ÿà¦¾à¦°à¦¾à¦¬à¦¾à¦œà¦¾à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(474, 53, 'Jagannathpur', 'à¦œà¦—à¦¨à§à¦¨à¦¾à¦¥à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(475, 53, 'Jamalganj', 'à¦œà¦¾à¦®à¦¾à¦²à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(476, 53, 'Sulla', 'à¦¸à§à¦²à§à¦²à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(477, 53, 'Sunamganj Sadar', 'à¦¸à§à¦¨à¦¾à¦®à¦—à¦žà§à¦œ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(478, 53, 'Shanthiganj', 'à¦¶à¦¾à¦¨à§à¦¤à¦¿à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(479, 53, 'Tahirpur', 'à¦¤à¦¾à¦¹à¦¿à¦°à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(480, 54, 'Sylhet Sadar', 'à¦¸à¦¿à¦²à§‡à¦Ÿ à¦¸à¦¦à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(481, 54, 'Beanibazar', 'à¦¬à§‡à§Ÿà¦¾à¦¨à¦¿à¦¬à¦¾à¦œà¦¾à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(482, 54, 'Bishwanath', 'à¦¬à¦¿à¦¶à§à¦¬à¦¨à¦¾à¦¥', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(483, 54, 'Dakshin Surma ', 'à¦¦à¦•à§à¦·à¦¿à¦£ à¦¸à§à¦°à¦®à¦¾', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(484, 54, 'Balaganj', 'à¦¬à¦¾à¦²à¦¾à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(485, 54, 'Companiganj', 'à¦•à§‹à¦®à§à¦ªà¦¾à¦¨à¦¿à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(486, 54, 'Fenchuganj', 'à¦«à§‡à¦žà§à¦šà§à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(487, 54, 'Golapganj', 'à¦—à§‹à¦²à¦¾à¦ªà¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(488, 54, 'Gowainghat', 'à¦—à§‹à§Ÿà¦¾à¦‡à¦¨à¦˜à¦¾à¦Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(489, 54, 'Jaintiapur', 'à¦œà§Ÿà¦¨à§à¦¤à¦ªà§à¦°', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(490, 54, 'Kanaighat', 'à¦•à¦¾à¦¨à¦¾à¦‡à¦˜à¦¾à¦Ÿ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(491, 54, 'Zakiganj', 'à¦œà¦¾à¦•à¦¿à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(492, 54, 'Nobigonj', 'à¦¨à¦¬à§€à¦—à¦žà§à¦œ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(493, 1, 'Adabor', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(494, 1, 'Airport', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(495, 1, 'Badda', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(496, 1, 'Banani', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(497, 1, 'Bangshal', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(498, 1, 'Bhashantek', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(499, 1, 'Cantonment', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(500, 1, 'Chackbazar', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(501, 1, 'Darussalam', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(502, 1, 'Daskhinkhan', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(503, 1, 'Demra', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(504, 1, 'Dhamrai', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(505, 1, 'Dhanmondi', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(506, 1, 'Dohar', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(507, 1, 'Gandaria', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(508, 1, 'Gulshan', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(509, 1, 'Hazaribag', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(510, 1, 'Jatrabari', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(511, 1, 'Kafrul', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(512, 1, 'Kalabagan', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(513, 1, 'Kamrangirchar', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(514, 1, 'Keraniganj', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(515, 1, 'Khilgaon', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(516, 1, 'Khilkhet', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(517, 1, 'Kotwali', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(518, 1, 'Lalbag', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(519, 1, 'Mirpur Model', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(520, 1, 'Mohammadpur', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(521, 1, 'Motijheel', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(522, 1, 'Mugda', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(523, 1, 'Nawabganj', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(524, 1, 'New Market', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(525, 1, 'Pallabi', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(526, 1, 'Paltan', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(527, 1, 'Ramna', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(528, 1, 'Rampura', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(529, 1, 'Rupnagar', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(530, 1, 'Sabujbag', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(531, 1, 'Savar', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(532, 1, 'Shah Ali', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(533, 1, 'Shahbag', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(534, 1, 'Shahjahanpur', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(535, 1, 'Sherebanglanagar', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(536, 1, 'Shyampur', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(537, 1, 'Sutrapur', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(538, 1, 'Tejgaon', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(539, 1, 'Tejgaon I/A', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(540, 1, 'Turag', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(541, 1, 'Uttara', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(542, 1, 'Uttara West', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(543, 1, 'Uttarkhan', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(544, 1, 'Vatara', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(545, 1, 'Wari', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(546, 1, 'Others', '', NULL, NULL, '2016-04-06 18:00:33', '0000-00-00 00:00:00'),
(547, 35, 'Airport', 'à¦à§Ÿà¦¾à¦°à¦ªà§‹à¦°à§à¦Ÿ', NULL, NULL, '2016-04-06 18:23:08', '0000-00-00 00:00:00'),
(548, 35, 'Kawnia', 'à¦•à¦¾à¦‰à¦¨à¦¿à§Ÿà¦¾', NULL, NULL, '2016-04-06 18:24:40', '0000-00-00 00:00:00'),
(549, 35, 'Bondor', 'à¦¬à¦¨à§à¦¦à¦°', NULL, NULL, '2016-04-06 18:27:19', '0000-00-00 00:00:00'),
(550, 35, 'Others', 'à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯', NULL, NULL, '2016-04-06 18:28:14', '0000-00-00 00:00:00'),
(551, 24, 'Boalia', 'à¦¬à§‹à¦¯à¦¼à¦¾à¦²à¦¿à¦¯à¦¼à¦¾', NULL, NULL, '2016-04-06 18:32:13', '0000-00-00 00:00:00'),
(552, 24, 'Motihar', 'à¦®à¦¤à¦¿à¦¹à¦¾à¦°', NULL, NULL, '2016-04-06 18:33:00', '0000-00-00 00:00:00'),
(553, 24, 'Shahmokhdum', 'à¦¶à¦¾à¦¹à§ à¦®à¦•à¦–à¦¦à§à¦® ', NULL, NULL, '2016-04-06 18:36:15', '0000-00-00 00:00:00'),
(554, 24, 'Rajpara', 'à¦°à¦¾à¦œà¦ªà¦¾à¦°à¦¾ ', NULL, NULL, '2016-04-06 18:38:32', '0000-00-00 00:00:00'),
(555, 24, 'Others', 'à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯', NULL, NULL, '2016-04-06 18:39:09', '0000-00-00 00:00:00'),
(556, 43, 'Akborsha', 'Akborsha', NULL, NULL, '2016-04-06 18:57:01', '0000-00-00 00:00:00'),
(557, 43, 'Baijid bostami', 'à¦¬à¦¾à¦‡à¦œà¦¿à¦¦ à¦¬à§‹à¦¸à§à¦¤à¦¾à¦®à§€', NULL, NULL, '2016-04-06 19:09:38', '0000-00-00 00:00:00'),
(558, 43, 'Bakolia', 'à¦¬à¦¾à¦•à§‹à¦²à¦¿à§Ÿà¦¾', NULL, NULL, '2016-04-06 19:10:52', '0000-00-00 00:00:00'),
(559, 43, 'Bandar', 'à¦¬à¦¨à§à¦¦à¦°', NULL, NULL, '2016-04-06 19:11:53', '0000-00-00 00:00:00'),
(560, 43, 'Chandgaon', 'à¦šà¦¾à¦à¦¦à¦—à¦¾à¦“', NULL, NULL, '2016-04-06 19:12:34', '0000-00-00 00:00:00'),
(561, 43, 'Chokbazar', 'à¦šà¦•à¦¬à¦¾à¦œà¦¾à¦°', NULL, NULL, '2016-04-06 19:13:10', '0000-00-00 00:00:00'),
(562, 43, 'Doublemooring', 'à¦¡à¦¾à¦¬à¦² à¦®à§à¦°à¦¿à¦‚', NULL, NULL, '2016-04-06 19:14:10', '0000-00-00 00:00:00'),
(563, 43, 'EPZ', 'à¦‡à¦ªà¦¿à¦œà§‡à¦¡', NULL, NULL, '2016-04-06 19:14:55', '0000-00-00 00:00:00'),
(564, 43, 'Hali Shohor', 'à¦¹à¦²à§€ à¦¶à¦¹à¦°', NULL, NULL, '2016-04-06 19:15:54', '0000-00-00 00:00:00'),
(565, 43, 'Kornafuli', 'à¦•à¦°à§à¦£à¦«à§à¦²à¦¿', NULL, NULL, '2016-04-06 19:16:29', '0000-00-00 00:00:00'),
(566, 43, 'Kotwali', 'à¦•à§‹à¦¤à§‹à¦¯à¦¼à¦¾à¦²à§€', NULL, NULL, '2016-04-06 19:17:08', '0000-00-00 00:00:00'),
(567, 43, 'Kulshi', 'à¦•à§à¦²à¦¶à¦¿', NULL, NULL, '2016-04-06 19:18:09', '0000-00-00 00:00:00'),
(568, 43, 'Pahartali', 'à¦ªà¦¾à¦¹à¦¾à¦¡à¦¼à¦¤à¦²à§€', NULL, NULL, '2016-04-06 19:19:26', '0000-00-00 00:00:00'),
(569, 43, 'Panchlaish', 'à¦ªà¦¾à¦à¦šà¦²à¦¾à¦‡à¦¶', NULL, NULL, '2016-04-06 19:20:24', '0000-00-00 00:00:00'),
(570, 43, 'Potenga', 'à¦ªà¦¤à§‡à¦™à§à¦—à¦¾', NULL, NULL, '2016-04-06 19:21:20', '0000-00-00 00:00:00'),
(571, 43, 'Shodhorgat', 'à¦¸à¦¦à¦°à¦˜à¦¾à¦Ÿ', NULL, NULL, '2016-04-06 19:22:19', '0000-00-00 00:00:00'),
(572, 43, 'Others', 'à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯', NULL, NULL, '2016-04-06 19:22:51', '0000-00-00 00:00:00'),
(573, 44, 'Others', 'à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯', NULL, NULL, '2016-04-06 19:37:59', '0000-00-00 00:00:00'),
(574, 59, 'Aranghata', 'à¦†à¦¡à¦¼à¦¾à¦‚à¦˜à¦¾à¦Ÿà¦¾', NULL, NULL, '2016-04-06 20:30:50', '0000-00-00 00:00:00'),
(575, 59, 'Daulatpur', 'à¦¦à§Œà¦²à¦¤à¦ªà§à¦°', NULL, NULL, '2016-04-06 20:32:12', '0000-00-00 00:00:00'),
(576, 59, 'Harintana', 'à¦¹à¦¾à¦°à¦¿à¦¨à§à¦¤à¦¾à¦¨à¦¾ ', NULL, NULL, '2016-04-06 20:34:06', '0000-00-00 00:00:00'),
(577, 59, 'Horintana', 'à¦¹à¦°à¦¿à¦£à¦¤à¦¾à¦¨à¦¾ ', NULL, NULL, '2016-04-06 20:35:11', '0000-00-00 00:00:00'),
(578, 59, 'Khalishpur', 'à¦–à¦¾à¦²à¦¿à¦¶à¦ªà§à¦°', NULL, NULL, '2016-04-06 20:35:56', '0000-00-00 00:00:00'),
(579, 59, 'Khanjahan Ali', 'à¦–à¦¾à¦¨à¦œà¦¾à¦¹à¦¾à¦¨ à¦†à¦²à§€', NULL, NULL, '2016-04-06 20:37:14', '0000-00-00 00:00:00'),
(580, 59, 'Khulna Sadar', 'à¦–à§à¦²à¦¨à¦¾ à¦¸à¦¦à¦°', NULL, NULL, '2016-04-06 20:37:58', '0000-00-00 00:00:00'),
(581, 59, 'Labanchora', 'à¦²à¦¾à¦¬à¦¾à¦¨à¦›à§‹à¦°à¦¾', NULL, NULL, '2016-04-06 20:39:23', '0000-00-00 00:00:00'),
(582, 59, 'Sonadanga', 'à¦¸à§‹à¦¨à¦¾à¦¡à¦¾à¦™à§à¦—à¦¾', NULL, NULL, '2016-04-06 20:40:22', '0000-00-00 00:00:00'),
(583, 59, 'Others', 'à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯', NULL, NULL, '2016-04-06 20:42:14', '0000-00-00 00:00:00'),
(584, 2, 'Others', 'à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯', NULL, NULL, '2016-04-06 20:43:56', '0000-00-00 00:00:00'),
(585, 4, 'Others', 'à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯', NULL, NULL, '2016-04-06 20:45:07', '0000-00-00 00:00:00'),
(586, 5, 'Others', 'à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯', NULL, NULL, '2016-04-06 20:46:18', '0000-00-00 00:00:00'),
(587, 54, 'Airport', 'à¦¬à¦¿à¦®à¦¾à¦¨à¦¬à¦¨à§à¦¦à¦°', NULL, NULL, '2016-04-06 20:54:47', '0000-00-00 00:00:00'),
(588, 54, 'Hazrat Shah Paran', 'à¦¹à¦¯à¦°à¦¤ à¦¶à¦¾à¦¹ à¦ªà¦°à¦¾à¦£', NULL, NULL, '2016-04-06 20:57:13', '0000-00-00 00:00:00'),
(589, 54, 'Jalalabad', 'à¦œà¦¾à¦²à¦¾à¦²à¦¾à¦¬à¦¾à¦¦', NULL, NULL, '2016-04-06 20:58:15', '0000-00-00 00:00:00'),
(590, 54, 'Kowtali', 'à¦•à§‹à¦¤à§‹à¦¯à¦¼à¦¾à¦²à§€', NULL, NULL, '2016-04-06 20:59:27', '0000-00-00 00:00:00'),
(591, 54, 'Moglabazar', 'à¦®à§‹à¦—à¦²à¦¾à¦¬à¦¾à¦œà¦¾à¦°', NULL, NULL, '2016-04-06 21:00:58', '0000-00-00 00:00:00'),
(592, 54, 'Osmani Nagar', 'à¦“à¦¸à¦®à¦¾à¦¨à§€ à¦¨à¦—à¦°', NULL, NULL, '2016-04-06 21:01:36', '0000-00-00 00:00:00'),
(593, 54, 'South Surma', 'à¦¦à¦•à§à¦·à¦¿à¦£ à¦¸à§à¦°à¦®à¦¾', NULL, NULL, '2016-04-06 21:02:16', '0000-00-00 00:00:00'),
(594, 54, 'Others', 'à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯', NULL, NULL, '2016-04-06 21:03:07', '0000-00-00 00:00:00'),
(595, 47, 'Mohakhali', '', NULL, NULL, NULL, NULL),
(596, 47, 'Bashundhara', '', NULL, NULL, NULL, NULL),
(597, 47, 'Old town', '', NULL, NULL, NULL, NULL),
(598, 47, 'Baridhara', '', NULL, NULL, NULL, NULL),
(599, 47, 'Demra', '', NULL, NULL, NULL, NULL),
(600, 47, 'Matuail', '', NULL, NULL, NULL, NULL),
(601, 47, 'Shamoly', '', NULL, NULL, NULL, NULL),
(602, 47, 'Fakirapul', '', NULL, NULL, NULL, NULL),
(603, 47, 'Paltan', '', NULL, NULL, NULL, NULL),
(604, 47, 'Gulistan', '', NULL, NULL, NULL, NULL),
(605, 47, 'Sadarghat', '', NULL, NULL, NULL, NULL),
(606, 47, 'Lalbagh', '', NULL, NULL, NULL, NULL),
(607, 47, 'Bashabo', '', NULL, NULL, NULL, NULL),
(608, 47, 'Mogbazar', '', NULL, NULL, NULL, NULL),
(609, 47, 'Shantinagar', '', NULL, NULL, NULL, NULL),
(610, 47, 'Farmgate', '', NULL, NULL, NULL, NULL),
(611, 47, 'Khamarbari', '', NULL, NULL, NULL, NULL),
(612, 47, 'Shewrapara', '', NULL, NULL, NULL, NULL),
(613, 47, 'Kazipara', '', NULL, NULL, NULL, NULL),
(614, 47, 'Kakrail', '', NULL, NULL, NULL, NULL),
(615, 47, 'Agargaon', '', NULL, NULL, NULL, NULL),
(616, 47, 'Kamlapur', '', NULL, NULL, NULL, NULL),
(617, 47, 'Maniknagor', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_superuser` tinyint(1) NOT NULL DEFAULT 0,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` enum('super_admin','admin','normal_user') COLLATE utf8mb4_unicode_ci DEFAULT 'normal_user',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `loc_division_id` int(11) DEFAULT NULL,
  `loc_district_id` int(11) DEFAULT NULL,
  `loc_upazila_id` int(11) DEFAULT NULL,
  `loc_municipality_id` int(11) DEFAULT NULL,
  `loc_union_id` int(11) DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>Active, 0=>Inactive, 99=>Deleted',
  `is_verifier` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `department_id` smallint(5) UNSIGNED NOT NULL,
  `assigned_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `is_superuser`, `role_id`, `name`, `user_type`, `email`, `mobile`, `loc_division_id`, `loc_district_id`, `loc_upazila_id`, `loc_municipality_id`, `loc_union_id`, `avatar`, `status`, `is_verifier`, `department_id`, `assigned_number`, `otp`, `email_verified_at`, `password`, `remember_token`, `settings`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Super Admin', 'super_admin', 'super@admin.com', '01708800996', NULL, NULL, NULL, NULL, NULL, 'users/1584264545.png', 1, '0', 2, '', '', NULL, '$2y$10$JxViEtxH1S7ctFF2hFX97urnHVj249wuEfayJJd0eYx8c2dr9XvLe', 'Gk7SSaIsDX0cGVBz7CY9moRImv16lJ9RhEz4cWyLfvD7POSGazY455hBXfXO', NULL, NULL, 1, '2019-12-12 04:32:37', '2020-03-15 09:29:05', NULL),
(66, 0, 1, 'MD. Amirul Islam', 'admin', 'amirul@gmail.com', '01533550962', NULL, NULL, NULL, NULL, NULL, 'users/1594139606.png', 1, '1', 2, '', '', NULL, '$2y$10$FxFUPzaYHh8m/DBPmnIoHOar4w87U2kPdsaWEAp/vCjrm9fn./DUC', 'HyvTWbpsnTDKdMNV3VfakY3hVyKxccC83qFWXgdqzcLTT5VCTK6J5PIb5Hfk', NULL, NULL, NULL, '2020-03-11 10:35:00', '2020-07-08 05:33:26', NULL),
(67, 0, 1, 'Imran', 'admin', 'imran@uniquegroupbd.com', '01578685427', NULL, NULL, NULL, NULL, NULL, 'users/1584264521.png', 1, '1', 2, '', '', NULL, '$2y$10$4dC4F4RtRmm/zGH9KOW7YeSc4zN3WofxDaPGqhMy2Crh0qfXL5v.u', NULL, NULL, NULL, NULL, '2020-03-12 08:26:24', '2020-03-15 09:28:41', NULL),
(71, 0, 6, 'A. M. Moniruzzaman Rubel', 'admin', 'rubel@uniquegroupbd.com', '01713178876', NULL, NULL, NULL, NULL, NULL, 'users/1593277108.jpg', 1, '0', 2, '', '', NULL, '$2y$10$N7CBS3z4TP5/Lj38174SwuwoJYF9t3PmPVS1JxpxORSCCoDk4EMjq', '5ycEUkJszGHQR0aWlAsdBO8Sd99bQPaU41feLDnc8AAYDsqmlJmWOLgr0gbi', NULL, NULL, NULL, '2020-06-24 03:54:20', '2020-07-07 20:21:35', NULL),
(72, 0, 10, 'Dr. Md. Monirul Islam', 'normal_user', 'monirbtge@gmail.com', '01719020958', NULL, NULL, NULL, NULL, NULL, 'users/1592970950.png', 1, '0', 2, '', '', NULL, '$2y$10$XAUd7pprbhutqYR7vpCupuE6iLb4KrjLMZYcnXw/Hw4IpBh3l2a2a', 'ysnBZD0t7i5nFwA08QhQr2iAsks48rN9NvgNUYIzimfUnxrEdwYUMVFOkTA9', NULL, NULL, NULL, '2020-06-24 03:55:50', '2020-06-24 03:55:50', NULL),
(73, 0, 10, 'Md. Arifur Rahman', 'normal_user', 'ibnsinapcrlab@gmail.com', '01817643833', NULL, NULL, NULL, NULL, NULL, 'users/1594015300.jpg', 1, '0', 2, '', '', NULL, '$2y$10$ZvV2aIryTg7UATZ8xQ/z8.qayFynrJKbW/hXYvjauTXWvfegthOP6', 'K4yVxmQ8xUvDVDuAH8NKklpAhgyKdCfVTblgx0Vi4DklckKIXfC9BxckvKvd', NULL, NULL, NULL, '2020-06-24 03:56:52', '2020-07-06 19:01:40', NULL),
(74, 0, 10, 'Shakil Ahmed Kanon', 'normal_user', 'shakilahmedkanon9@gmail.com', '01789091209', NULL, NULL, NULL, NULL, NULL, 'users/1592971068.png', 1, '0', 2, '', '', NULL, '$2y$10$NEMcpnocD8TFFj9nfYLsueLTbEdNi1ivNVQiDGkSyKTvwxJITWXLG', NULL, NULL, NULL, NULL, '2020-06-24 03:57:48', '2020-06-24 03:57:48', NULL),
(75, 0, 10, 'Md. Jahurul Islam', 'normal_user', 'jahurulislam4883@yahoo.com', '01533141072', NULL, NULL, NULL, NULL, NULL, 'users/1593248050.jpg', 1, '0', 2, '', '', NULL, '$2y$10$trUmEEDc4i2caQxwYRyCa.iQOR6ByM6nBM610sbnORC7snafohMce', 'vCOyjWjUpgaBy3vvyak8zmHSE7lXN5ekFC2PuexR76hfxruHVBESZYhfpiaI', NULL, NULL, NULL, '2020-06-24 03:58:31', '2020-08-06 17:24:14', NULL),
(76, 0, 10, 'Md. Hazzaz Bin Motin', 'normal_user', 'hazzazbinmotin4883@gmail.com', '01710519632', NULL, NULL, NULL, NULL, NULL, 'users/1592971172.png', 1, '0', 2, '', '', NULL, '$2y$10$cz1FUBV9TBkN756L6ugzp.vRxscyi0/R0Sug6ZqXy5tBMT6Lvmdf.', 'JiH8hDUueZELsUrIgSVtq6artDaqxbPwliKVrH4APQ6LKh8m09aPquCmSpGX', NULL, NULL, NULL, '2020-06-24 03:59:32', '2020-06-24 03:59:32', NULL),
(77, 0, 10, 'Md. Shoykot Jahan', 'normal_user', 'shoykot1996@gmail.com', '01934052910', NULL, NULL, NULL, NULL, NULL, 'users/1595315551.jpg', 1, '0', 2, '', '', NULL, '$2y$10$dCr2CKpX3nrVpS3o7bs4BOXdpHe8Qp.681ElsUYMwaXQ2gPGium.W', NULL, NULL, NULL, NULL, '2020-06-24 04:00:25', '2020-07-21 20:12:31', NULL),
(78, 0, 7, 'Hajera Akter', 'normal_user', 'hajerazara683718@gmail.com', '01856236778', NULL, NULL, NULL, NULL, NULL, 'users/1592971381.png', 1, '0', 2, '', '', NULL, '$2y$10$7Tc4Gdr2wneS/g1v/NnUF.TCe0OVQ3PofH/KJLTTVurtwSW0jGHrW', 'RqjD5Cl6huE45aBEPWBNGIvsmaJzkhMhtrRpPYJcQNW04eochlzWXP8vm8T9', NULL, NULL, NULL, '2020-06-24 04:03:01', '2020-06-27 19:24:18', NULL),
(79, 0, 7, 'Ripon Hossain', 'normal_user', 'mdriponkhan224@gmail.com', '01621024373', NULL, NULL, NULL, NULL, NULL, 'users/1592971423.png', 1, '0', 2, '', '', NULL, '$2y$10$jTT.pC1jOdZXYwT5MZPoAu.WV.XFRVAFgyYXoxUpx4wIrF8W2A6WG', NULL, NULL, NULL, NULL, '2020-06-24 04:03:43', '2020-06-24 04:03:43', NULL),
(80, 0, 7, 'Md. Salim Reza', 'normal_user', 'selimrezapau@gmail.com', '01645373205', NULL, NULL, NULL, NULL, NULL, 'users/1592971469.png', 1, '0', 2, '', '', NULL, '$2y$10$P/tSBJvq2BBOvxyC8SwJ6eYrAwQWHurAdLePYvQBubnKfLJ/N8Ql.', NULL, NULL, NULL, NULL, '2020-06-24 04:04:29', '2020-06-24 04:04:29', NULL),
(81, 0, 7, 'Md. Babul Miah', 'normal_user', 'mdbabulmiah123@gmail.com', '01708889649', NULL, NULL, NULL, NULL, NULL, 'users/1594204840.jpg', 1, '0', 2, '', '', NULL, '$2y$10$GVlVGDc.IytLtQ117nN18OmrL.eYwrCdpv2fNLGNTxF1u4n4VsVre', '2NrA3wUwpJu3f3TQ67YGsU1FeY0FOpGohr5sRVTloxM6N8G994AE4NAuMFfG', NULL, NULL, NULL, '2020-06-24 04:05:37', '2020-07-08 23:40:40', NULL),
(82, 0, 7, 'Rukon Uddin Khan', 'normal_user', 'rukon.uddin044@gmail.com', '01740436576', NULL, NULL, NULL, NULL, NULL, 'users/1592971575.png', 1, '0', 2, '', '', NULL, '$2y$10$CMUeorRYpBMQ/1SdcbzeweamiQ1tN.GWL0TFh8WvIq7pJt1DPm/C2', NULL, NULL, NULL, NULL, '2020-06-24 04:06:15', '2020-06-25 04:08:54', NULL),
(83, 0, 7, 'Rita Akhtar', 'normal_user', 'ritaakhtar@gmail.com', '01722782443', NULL, NULL, NULL, NULL, NULL, 'users/1592971637.png', 1, '0', 2, '', '', NULL, '$2y$10$PWIWk72/vPpqQQFUp75C4.JXvZ4UeHCvUoP0d46rFeso9hIKWNTse', NULL, NULL, NULL, NULL, '2020-06-24 04:07:17', '2020-06-24 04:07:17', NULL),
(84, 0, 9, 'Farzana Lina', 'normal_user', 'lina_dhaka01@yahoo.com', '01959410791', NULL, NULL, NULL, NULL, NULL, 'users/1592971756.png', 1, '0', 2, '', '', NULL, '$2y$10$WgrPuDM.J64KIFTTHgpw9OQMs91dJxgn5QU1CbHCdgt6SBulVniqy', 'rOyxI5H5crCHff9HMenu2wKU0bx5mWOZutv1zDxORJ5cv5tO6OeDuJQuGHl4', NULL, NULL, NULL, '2020-06-24 04:09:16', '2020-06-24 04:14:46', NULL),
(85, 0, 9, 'Abu Shaleh', 'normal_user', 'shaleh.ug.bd@gmail.com', '01708800988', NULL, NULL, NULL, NULL, NULL, 'users/1592971857.png', 1, '0', 2, '', '', NULL, '$2y$10$6SRDJE0ZCLu9GFEX0z4gwOlTzc7PYqP7fWaUTD4vvz78kuD3UtlUe', NULL, NULL, NULL, NULL, '2020-06-24 04:10:57', '2020-06-25 04:16:52', NULL),
(86, 0, 11, 'Shakh Sadi', 'normal_user', 'shadi.gcl@gmail.com', '01919596468', NULL, NULL, NULL, NULL, NULL, 'users/1593330425.JPG', 1, '0', 2, '', '', NULL, '$2y$10$3w806g2UEGgqrgq6uvl4ie4aDjfK.ltgX5JMRFSqg9ry3kNdlv.N6', 'ucm8LbroIgmN7oPwRwhLZDcbzU7bvthqQMyiCMlRVpSNb2PepxCeZQjy4TyJ', NULL, NULL, NULL, '2020-06-24 04:15:58', '2020-07-10 02:40:07', NULL),
(87, 0, 9, 'Anamul Haque', 'normal_user', 'anamul.uniquegroup@gmail.com', '01712444722', NULL, NULL, NULL, NULL, NULL, 'users/1592972217.png', 1, '0', 2, '', '', NULL, '$2y$10$3PNDQHlp.2ZjiMp1TxLYheNzYVnff9OpzjTWhlgPO2.HpaxuLmgZ2', NULL, NULL, NULL, NULL, '2020-06-24 04:16:57', '2020-06-24 04:16:57', NULL),
(88, 0, 8, 'Md Ashraful Kabir', 'normal_user', 'mashraful.kabir10@gmail.com', '01823569943', NULL, NULL, NULL, NULL, NULL, 'users/1592972311.png', 1, '0', 2, '', '', NULL, '$2y$10$UmzaXH5YhStKuRYtycWVsucPXsIHFks1x51Lfo/PUC6p15byMiw4m', NULL, NULL, NULL, NULL, '2020-06-24 04:18:31', '2020-06-24 04:18:31', NULL),
(89, 0, 8, 'Md Kaisar Rahman', 'normal_user', 'kaisar@uniueeastern.com', '01708800928', NULL, NULL, NULL, NULL, NULL, 'users/1592972360.png', 1, '0', 2, '', '', NULL, '$2y$10$3eASf9YKfadjkV8H/IqWYOIf6xElxKqAyJ/oKIiZMI6usCB0MXKS2', 'zX18zD4P8vHmAw7IR3gj4aJezbgpw96DvKxhnL7KIZZ49WP9tXfIKG6l4xR2', NULL, NULL, NULL, '2020-06-24 04:19:20', '2020-06-24 04:19:20', NULL),
(90, 0, 8, 'Md Rasel Ahmed', 'normal_user', 'rasel@uniqueeastern.com', '01708800927', NULL, NULL, NULL, NULL, NULL, 'users/1592972405.png', 1, '0', 2, '', '', NULL, '$2y$10$KavDYP61dMI7rFciDDG7YuChgpEAzTQXxxgnm2Ldg8wSY3wXN/gPe', NULL, NULL, NULL, NULL, '2020-06-24 04:20:05', '2020-06-24 04:20:05', NULL),
(91, 0, 8, 'Md Shahadat Hossain', 'normal_user', 'shahadat@uniqueeastern.com', '01708800736', NULL, NULL, NULL, NULL, NULL, 'users/1593058703.png', 1, '0', 2, '', '', NULL, '$2y$10$YI/DECCzlsmMm./woItg5eNHzywUgWo1/bD2H8nhtVEA2AxXRD4ie', NULL, NULL, NULL, NULL, '2020-06-25 04:18:23', '2020-07-15 22:21:41', NULL),
(92, 0, 6, 'Md. Sayeedur Rahman', 'admin', 'sayeed@uniqueeastern.com', '01708800767', NULL, NULL, NULL, NULL, NULL, 'users/1593240648.png', 1, '0', 2, '', '', NULL, '$2y$10$KPc/VFTS0jhEwTTYaCI1Ie851TLmjOJkgSHk5ZzVmukV9QkTDzS..', 'onnQ1e4x8LB2B5Onph7lqGQ8MFaKRcHvzyv4q9vWSNJ1od4YahYuuUAOniP4', NULL, NULL, NULL, '2020-06-27 19:50:48', '2020-07-13 21:22:47', NULL),
(93, 0, 9, 'Osman', 'normal_user', 'osman@uniqueeastern.com', '01769501497', NULL, NULL, NULL, NULL, NULL, 'users/1593833001.jpg', 1, '0', 2, '', '', NULL, '$2y$10$Yt.bsCR/.hZeeEbqdvlvuuZgQa457BMLIsB1To5dv306CI9mYXzEa', 'bSwz1y8HXgWDt1Ozt1fmPoF5U6o6lrfsvYs377luszkrjuXY2zr31oYQ0rnz', NULL, NULL, NULL, '2020-06-28 04:37:20', '2020-07-04 16:23:21', NULL),
(94, 0, 9, 'MD IFTEKHARUL ISLAM', 'normal_user', 'iftekharulislam@uniquegroupbd.com', '01771128861', NULL, NULL, NULL, NULL, NULL, 'users/1594058724.png', 1, '0', 2, '', '', NULL, '$2y$10$scgA4UIusbqTuApABa5knOIEtGJkwanWbeb49Y4gqjsDSB1TGLBYu', 'Covbsyo6qzHFWMUsbdRq5ysoZTPI8XJOFl1FipxtIMvgM80lTLAgXWIi2u9z', NULL, NULL, NULL, '2020-06-29 06:18:26', '2020-07-07 07:05:24', NULL),
(95, 0, 9, 'Md.Mominul Haque', 'normal_user', 'mominul@uniquegroupbd.com', '01713379470', NULL, NULL, NULL, NULL, NULL, 'users/1594058704.png', 1, '0', 2, '', '', NULL, '$2y$10$t2XHbFvL.eMRpy.0KPM67OAwKt7ljyy6zdyoky8/jR88g6Z5ZedFy', 'UhNlKBjyYG8suYgcyKIYlxO94Kk9Qz2LJEr8Ovu15RukKiA9iHYe8ts0rZhB', NULL, NULL, NULL, '2020-06-29 06:21:28', '2020-07-07 07:05:04', NULL),
(96, 0, 7, 'Abdus Salam', 'normal_user', 'salamnirob200091@gmail', '01760385235', NULL, NULL, NULL, NULL, NULL, 'users/1593502395.png', 1, '0', 2, '', '', NULL, '$2y$10$JewTNm0rvaTiymVRsjt3w.o2jN52s06TKNiAhN90DD9sxF5jmYsZm', NULL, NULL, NULL, NULL, '2020-06-30 20:33:15', '2020-06-30 20:33:15', NULL),
(97, 0, 9, 'Fahmida Alam', 'normal_user', 'fahmida@gulshanclinicbd.org', '01708800899', NULL, NULL, NULL, NULL, NULL, 'users/1594058534.jpg', 1, '0', 2, '', '', NULL, '$2y$10$pxl4M3ynLIcjfbxNwWLxlOD6MEXUZ/rudQQVNa6/navWWsAA53NRm', NULL, NULL, NULL, NULL, '2020-06-30 23:10:01', '2020-07-07 07:02:14', NULL),
(98, 0, 9, 'Rasmin Ara', 'normal_user', 'rashminarapopi@gmail.com', '01717160044', NULL, NULL, NULL, NULL, NULL, 'users/1594058692.jpg', 1, '0', 2, '', '', NULL, '$2y$10$nEc7a8cc0yzkOW9q/LUJaut1VaYbHQJaMZfYrklotU5HwGmVW3GVy', 'O8DS5cglie87M1PKR10hxzBHcJRHlPE9biU9Rcr7ByMWOsmqqhooUUuPIENG', NULL, NULL, NULL, '2020-07-03 01:26:10', '2020-07-07 07:04:52', NULL),
(99, 0, 7, 'Jannatul Ferdous', 'normal_user', 'airinanjum1121@gmail.com', '01786073158', NULL, NULL, NULL, NULL, NULL, 'users/1593756680.jpg', 1, '0', 2, '', '', NULL, '$2y$10$e0cazlssOa1TvmciPm7nZeka6ImZ5NDKn6qQKEawBwKpJ7O1Gb8c.', NULL, NULL, NULL, NULL, '2020-07-03 19:10:23', '2020-07-03 19:11:20', NULL),
(100, 0, 6, 'Salah Uddin', 'admin', 'salahuddin@uniquegroupbd.com', '01708800785', NULL, NULL, NULL, NULL, NULL, 'users/1593930081.png', 1, '0', 2, '', '', NULL, '$2y$10$MyamvHvLa6RwvO.zK.aGQeIwVv4p8HFmWqEGvjvwfRFa04Zu4WufK', 'TtvDSxIQOMmf3MtgR4jy9RNgfpLGrm4bthgDsp8RjELFr4MQ0YIK6uWSad37', NULL, NULL, NULL, '2020-07-05 19:21:21', '2020-07-05 19:21:21', NULL),
(101, 0, 7, 'Shapla Khatun', 'normal_user', 'shaplaaboni286@gmail.com', '01784351903', NULL, NULL, NULL, NULL, NULL, 'users/1594362832.jpg', 1, '0', 2, '', '', NULL, '$2y$10$fSQWET7BRFWOehTE2DqRDuzgfTNR9Y6oSzqdZfTymzVXOj1oqK4.2', NULL, NULL, NULL, NULL, '2020-07-10 19:33:52', '2020-07-10 19:33:52', NULL),
(102, 0, 7, 'Meheraj Hosen', 'normal_user', 'meheraj.rafi@gmail.com', '01521318819', NULL, NULL, NULL, NULL, NULL, 'users/1595244894.jpg', 1, '0', 2, '', '', NULL, '$2y$10$2sKUu43iZRdsphIbQ9peHuDiOHsuUjGQ4tRU1GO8KB9SQUZFBDzH.', NULL, NULL, NULL, NULL, '2020-07-12 23:05:05', '2020-07-21 00:34:54', NULL),
(103, 0, 7, 'Aliraj Kanon', 'normal_user', 'alirajkanon035@gmail.com', '01743230670', NULL, NULL, NULL, NULL, NULL, 'users/1595245726.png', 1, '0', 2, '', '', NULL, '$2y$10$45.UX5/G16CgwUQCMbqrGu/LMGcD9org9Iu6RR1iQclflPERZM9m.', NULL, NULL, NULL, NULL, '2020-07-21 00:48:47', '2020-07-21 01:00:13', NULL),
(104, 0, 7, 'Sajal Chandra Biswash', 'normal_user', 'sajalbiwash91@gmail.com', '01742399781', NULL, NULL, NULL, NULL, NULL, 'users/1595851689.jpg', 1, '0', 2, '', '', NULL, '$2y$10$UDhlLxKzr/UFS2KTDZOvEOxiP2/xcxSpeEt9Fl/nUIu6ne/93tDdG', NULL, NULL, NULL, NULL, '2020-07-27 04:05:25', '2020-07-28 01:08:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions`
--

DROP TABLE IF EXISTS `users_permissions`;
CREATE TABLE IF NOT EXISTS `users_permissions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_permissions_user_id_index` (`user_id`),
  KEY `users_permissions_permission_id_index` (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_permissions`
--

INSERT INTO `users_permissions` (`id`, `user_id`, `permission_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 26, 0, '2019-12-19 10:57:17', '2019-12-22 13:02:28'),
(2, 3, 27, 0, '2019-12-19 10:57:17', '2019-12-22 13:02:28'),
(3, 3, 28, 0, '2019-12-19 10:57:17', '2019-12-22 13:02:28'),
(4, 3, 29, 0, '2019-12-19 10:57:17', '2019-12-22 13:02:28'),
(5, 3, 30, 0, '2019-12-19 10:57:17', '2019-12-22 13:02:28'),
(6, 3, 31, 0, '2019-12-19 10:57:17', '2019-12-22 13:02:28'),
(7, 3, 32, 0, '2019-12-19 10:57:17', '2019-12-22 13:02:28'),
(8, 3, 33, 0, '2019-12-19 10:57:17', '2019-12-22 13:02:28'),
(9, 3, 34, 0, '2019-12-19 10:57:21', '2019-12-22 13:02:30'),
(10, 3, 35, 0, '2019-12-19 10:57:21', '2019-12-22 13:02:30'),
(11, 3, 36, 0, '2019-12-19 10:57:21', '2019-12-22 13:02:30'),
(12, 3, 37, 0, '2019-12-19 10:57:21', '2019-12-22 13:02:30'),
(13, 3, 38, 0, '2019-12-19 10:57:21', '2019-12-22 13:02:30'),
(14, 3, 39, 0, '2019-12-19 10:57:21', '2019-12-22 13:02:30'),
(15, 3, 40, 0, '2019-12-19 10:57:21', '2019-12-22 13:02:30'),
(16, 3, 41, 0, '2019-12-19 10:57:21', '2019-12-22 13:02:30'),
(17, 3, 42, 0, '2019-12-19 10:57:26', '2019-12-22 13:02:45'),
(18, 3, 43, 0, '2019-12-19 10:57:26', '2019-12-22 13:02:45'),
(19, 3, 44, 0, '2019-12-19 10:57:26', '2019-12-22 13:02:45'),
(20, 3, 45, 0, '2019-12-19 10:57:26', '2019-12-22 13:02:45'),
(21, 3, 46, 0, '2019-12-19 10:57:26', '2019-12-22 13:02:45'),
(22, 3, 47, 0, '2019-12-19 10:57:26', '2019-12-22 13:02:45'),
(23, 3, 48, 0, '2019-12-19 10:57:26', '2019-12-22 13:02:45'),
(24, 3, 49, 0, '2019-12-19 10:57:26', '2019-12-22 13:02:45'),
(25, 3, 50, 0, '2019-12-19 10:57:30', '2019-12-22 13:02:49'),
(26, 3, 51, 0, '2019-12-19 10:57:30', '2019-12-22 13:02:49'),
(27, 3, 52, 0, '2019-12-19 10:57:30', '2019-12-22 13:02:49'),
(28, 3, 53, 0, '2019-12-19 10:57:30', '2019-12-22 13:02:49'),
(29, 3, 54, 0, '2019-12-19 10:57:30', '2019-12-22 13:02:49'),
(30, 3, 55, 0, '2019-12-19 10:57:30', '2019-12-22 13:02:49'),
(31, 3, 56, 0, '2019-12-19 10:57:30', '2019-12-22 13:02:49'),
(32, 3, 57, 0, '2019-12-19 10:57:30', '2019-12-22 13:02:49'),
(33, 3, 58, 1, '2019-12-19 10:57:33', '2019-12-23 06:06:52'),
(34, 3, 59, 1, '2019-12-19 10:57:33', '2019-12-23 06:06:52'),
(35, 3, 60, 1, '2019-12-19 10:57:33', '2019-12-23 06:06:52'),
(36, 3, 61, 1, '2019-12-19 10:57:33', '2019-12-23 06:06:52'),
(37, 3, 62, 1, '2019-12-19 10:57:33', '2019-12-23 06:06:52'),
(38, 3, 63, 1, '2019-12-19 10:57:33', '2019-12-23 06:06:52'),
(39, 3, 64, 1, '2019-12-19 10:57:33', '2019-12-23 06:06:52'),
(40, 3, 65, 1, '2019-12-19 10:57:33', '2019-12-23 06:06:52'),
(41, 3, 74, 0, '2019-12-19 10:57:38', '2019-12-23 06:06:55'),
(42, 3, 75, 0, '2019-12-19 10:57:38', '2019-12-23 06:06:55'),
(43, 3, 76, 0, '2019-12-19 10:57:38', '2019-12-23 06:06:55'),
(44, 3, 77, 0, '2019-12-19 10:57:38', '2019-12-23 06:06:55'),
(45, 3, 78, 0, '2019-12-19 10:57:38', '2019-12-23 06:06:55'),
(46, 3, 79, 0, '2019-12-19 10:57:38', '2019-12-23 06:06:55'),
(47, 3, 80, 0, '2019-12-19 10:57:38', '2019-12-23 06:06:55'),
(48, 3, 81, 0, '2019-12-19 10:57:38', '2019-12-23 06:06:55'),
(49, 3, 82, 0, '2019-12-19 10:57:43', '2019-12-22 13:03:05'),
(50, 3, 83, 0, '2019-12-19 10:57:43', '2019-12-22 13:03:05'),
(51, 3, 84, 0, '2019-12-19 10:57:43', '2019-12-22 13:03:05'),
(52, 3, 85, 0, '2019-12-19 10:57:43', '2019-12-22 13:03:05'),
(53, 3, 86, 0, '2019-12-19 10:57:43', '2019-12-22 13:03:05'),
(54, 3, 87, 0, '2019-12-19 10:57:43', '2019-12-22 13:03:05'),
(55, 3, 88, 0, '2019-12-19 10:57:43', '2019-12-22 13:03:05'),
(56, 3, 89, 0, '2019-12-19 10:57:43', '2019-12-22 13:03:05'),
(57, 3, 90, 1, '2019-12-19 10:57:48', '2019-12-19 10:57:48'),
(58, 3, 91, 1, '2019-12-19 10:57:48', '2019-12-19 10:57:48'),
(59, 3, 92, 1, '2019-12-19 10:57:48', '2019-12-19 10:57:48'),
(60, 3, 93, 1, '2019-12-19 10:57:48', '2019-12-19 10:57:48'),
(61, 3, 94, 1, '2019-12-19 10:57:48', '2019-12-19 10:57:48'),
(62, 3, 95, 1, '2019-12-19 10:57:48', '2019-12-19 10:57:48'),
(63, 3, 96, 1, '2019-12-19 10:57:48', '2019-12-19 10:57:48'),
(64, 3, 97, 1, '2019-12-19 10:57:48', '2019-12-19 10:57:48'),
(65, 3, 98, 1, '2019-12-19 10:57:52', '2019-12-19 10:57:52'),
(66, 3, 99, 1, '2019-12-19 10:57:52', '2019-12-19 10:57:52'),
(67, 3, 100, 1, '2019-12-19 10:57:52', '2019-12-19 10:57:52'),
(68, 3, 101, 1, '2019-12-19 10:57:52', '2019-12-19 10:57:52'),
(69, 3, 102, 1, '2019-12-19 10:57:52', '2019-12-19 10:57:52'),
(70, 3, 103, 1, '2019-12-19 10:57:52', '2019-12-19 10:57:52'),
(71, 3, 104, 1, '2019-12-19 10:57:52', '2019-12-19 10:57:52'),
(72, 3, 105, 1, '2019-12-19 10:57:52', '2019-12-19 10:57:52'),
(73, 3, 106, 0, '2019-12-19 10:57:56', '2019-12-22 13:03:14'),
(74, 3, 107, 0, '2019-12-19 10:57:56', '2019-12-22 13:03:14'),
(75, 3, 108, 0, '2019-12-19 10:57:56', '2019-12-22 13:03:14'),
(76, 3, 109, 0, '2019-12-19 10:57:56', '2019-12-22 13:03:14'),
(77, 3, 110, 0, '2019-12-19 10:57:56', '2019-12-22 13:03:14'),
(78, 3, 111, 0, '2019-12-19 10:57:56', '2019-12-22 13:03:14'),
(79, 3, 112, 0, '2019-12-19 10:57:56', '2019-12-22 13:03:14'),
(80, 3, 113, 0, '2019-12-19 10:57:56', '2019-12-22 13:03:14'),
(81, 3, 114, 1, '2019-12-19 10:58:03', '2019-12-19 10:58:03'),
(82, 3, 115, 1, '2019-12-19 10:58:03', '2019-12-19 10:58:03'),
(83, 3, 116, 1, '2019-12-19 10:58:03', '2019-12-19 10:58:03'),
(84, 3, 117, 1, '2019-12-19 10:58:03', '2019-12-19 10:58:03'),
(85, 3, 118, 1, '2019-12-19 10:58:03', '2019-12-19 10:58:03'),
(86, 3, 119, 1, '2019-12-19 10:58:03', '2019-12-19 10:58:03'),
(87, 3, 120, 1, '2019-12-19 10:58:03', '2019-12-19 10:58:03'),
(88, 3, 121, 1, '2019-12-19 10:58:03', '2019-12-19 10:58:03'),
(89, 3, 1, 1, '2019-12-19 10:58:46', '2019-12-19 10:58:46'),
(90, 13, 6, 0, '2020-01-02 10:25:03', '2020-01-02 10:25:03'),
(91, 13, 7, 0, '2020-01-02 10:25:03', '2020-01-02 10:25:03'),
(92, 13, 8, 0, '2020-01-02 10:25:03', '2020-01-02 10:25:03'),
(93, 13, 9, 0, '2020-01-02 10:25:03', '2020-01-02 10:25:03'),
(94, 13, 10, 0, '2020-01-02 10:25:03', '2020-01-02 10:25:03'),
(95, 13, 11, 0, '2020-01-02 10:25:11', '2020-01-02 10:25:11'),
(96, 13, 12, 1, '2020-01-02 10:25:14', '2020-01-05 14:51:02'),
(97, 13, 13, 0, '2020-01-02 10:25:17', '2020-01-02 10:25:17'),
(98, 13, 14, 0, '2020-01-02 10:25:20', '2020-01-02 10:25:20'),
(99, 13, 15, 0, '2020-01-02 10:25:23', '2020-01-02 10:25:23'),
(100, 13, 20, 0, '2020-01-02 10:25:38', '2020-01-02 10:25:38'),
(101, 13, 26, 0, '2020-01-02 10:25:48', '2020-01-02 10:25:48'),
(102, 13, 27, 0, '2020-01-02 10:25:48', '2020-01-02 10:25:48'),
(103, 13, 28, 0, '2020-01-02 10:25:48', '2020-01-02 10:25:48'),
(104, 13, 29, 0, '2020-01-02 10:25:48', '2020-01-02 10:25:48'),
(105, 13, 30, 0, '2020-01-02 10:25:48', '2020-01-02 10:25:48'),
(106, 13, 31, 0, '2020-01-02 10:25:48', '2020-01-02 10:25:48'),
(107, 13, 32, 0, '2020-01-02 10:25:48', '2020-01-02 10:25:48'),
(108, 13, 33, 0, '2020-01-02 10:25:48', '2020-01-02 10:25:48'),
(109, 13, 34, 0, '2020-01-02 10:25:52', '2020-01-02 10:25:52'),
(110, 13, 35, 0, '2020-01-02 10:25:52', '2020-01-02 10:25:52'),
(111, 13, 36, 0, '2020-01-02 10:25:52', '2020-01-02 10:25:52'),
(112, 13, 37, 0, '2020-01-02 10:25:52', '2020-01-02 10:25:52'),
(113, 13, 38, 0, '2020-01-02 10:25:52', '2020-01-02 10:25:52'),
(114, 13, 39, 0, '2020-01-02 10:25:52', '2020-01-02 10:25:52'),
(115, 13, 40, 0, '2020-01-02 10:25:52', '2020-01-02 10:25:52'),
(116, 13, 41, 0, '2020-01-02 10:25:52', '2020-01-02 10:25:52'),
(117, 13, 50, 0, '2020-01-02 10:25:58', '2020-01-02 10:25:58'),
(118, 13, 51, 0, '2020-01-02 10:25:58', '2020-01-02 10:25:58'),
(119, 13, 52, 0, '2020-01-02 10:25:58', '2020-01-02 10:25:58'),
(120, 13, 53, 0, '2020-01-02 10:25:58', '2020-01-02 10:25:58'),
(121, 13, 54, 0, '2020-01-02 10:25:58', '2020-01-02 10:25:58'),
(122, 13, 55, 0, '2020-01-02 10:25:58', '2020-01-02 10:25:58'),
(123, 13, 56, 0, '2020-01-02 10:25:58', '2020-01-02 10:25:58'),
(124, 13, 57, 0, '2020-01-02 10:25:58', '2020-01-02 10:25:58'),
(125, 13, 165, 0, '2020-01-02 10:26:20', '2020-01-02 10:26:20'),
(126, 13, 166, 0, '2020-01-02 10:26:20', '2020-01-02 10:26:20'),
(127, 13, 167, 0, '2020-01-02 10:26:20', '2020-01-02 10:26:20'),
(128, 13, 168, 0, '2020-01-02 10:26:20', '2020-01-02 10:26:20'),
(129, 13, 169, 0, '2020-01-02 10:26:20', '2020-01-02 10:26:20'),
(130, 13, 170, 0, '2020-01-02 10:26:20', '2020-01-02 10:26:20'),
(131, 13, 171, 0, '2020-01-02 10:26:20', '2020-01-02 10:26:20'),
(132, 13, 172, 0, '2020-01-02 10:26:20', '2020-01-02 10:26:20'),
(133, 13, 2, 0, '2020-01-02 10:26:30', '2020-01-02 10:26:30'),
(134, 13, 3, 0, '2020-01-02 10:26:34', '2020-01-02 10:26:34'),
(135, 13, 4, 0, '2020-01-02 10:26:40', '2020-01-02 10:26:40'),
(136, 13, 5, 0, '2020-01-02 10:26:43', '2020-01-02 10:26:43');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `user_roles_user_id_index` (`user_id`),
  KEY `user_roles_role_id_index` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(2, 3),
(17, 3),
(18, 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
