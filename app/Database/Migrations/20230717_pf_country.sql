-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20221120.420485a41b
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 17, 2023 at 11:22 AM
-- Server version: 8.0.33-0ubuntu0.22.04.2
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peerfleet`
--

-- --------------------------------------------------------

--
-- Table structure for table `pf_country`
--

CREATE TABLE `pf_country` (
  `id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `country_code` int NOT NULL,
  `region` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sub_region_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sub_region` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pf_country`
--

INSERT INTO `pf_country` (`id`, `name`, `country_code`, `region`, `sub_region_id`, `sub_region`, `deleted`) VALUES
('AD', 'Andorra', 20, 'Europe', 'southern-europe', 'Southern Europe', 0),
('AE', 'United Arab Emirates', 784, 'Asia', 'western-asia', 'Western Asia', 0),
('AF', 'Afghanistan', 4, 'Asia', 'southern-asia', 'Southern Asia', 0),
('AG', 'Antigua and Barbuda', 28, 'Americas', 'caribbean', 'Caribbean', 0),
('AI', 'Anguilla', 660, 'Americas', 'caribbean', 'Caribbean', 0),
('AL', 'Albania', 8, 'Europe', 'southern-europe', 'Southern Europe', 0),
('AM', 'Armenia', 51, 'Asia', 'western-asia', 'Western Asia', 0),
('AO', 'Angola', 24, 'Africa', 'central-africa', 'Central Africa', 0),
('AQ', 'Antarctica', 10, '', '', '', 0),
('AR', 'Argentina', 32, 'Americas', 'south-america', 'South America', 0),
('AS', 'American Samoa', 16, 'Oceania', '', 'Polynesia', 0),
('AT', 'Austria', 40, 'Europe', 'western-europe', 'Western Europe', 0),
('AU', 'Australia', 36, 'Oceania', 'australia-and-new-zealand', 'Australia and New Zealand', 0),
('AW', 'Aruba', 533, 'Americas', 'caribbean', 'Caribbean', 0),
('AX', 'Åland Islands', 248, 'Europe', 'northern-europe', 'Northern Europe', 0),
('AZ', 'Azerbaijan', 31, 'Asia', 'western-asia', 'Western Asia', 0),
('BA', 'Bosnia and Herzegovina', 70, 'Europe', 'southern-europe', 'Southern Europe', 0),
('BB', 'Barbados', 52, 'Americas', 'caribbean', 'Caribbean', 0),
('BD', 'Bangladesh', 50, 'Asia', 'southern-asia', 'Southern Asia', 0),
('BE', 'Belgium', 56, 'Europe', 'western-europe', 'Western Europe', 0),
('BF', 'Burkina Faso', 854, 'Africa', 'western-africa', 'Western Africa', 0),
('BG', 'Bulgaria', 100, 'Europe', 'eastern-europe', 'Eastern Europe', 0),
('BH', 'Bahrain', 48, 'Asia', 'western-asia', 'Western Asia', 0),
('BI', 'Burundi', 108, 'Africa', 'central-africa', 'Central Africa', 0),
('BJ', 'Benin', 204, 'Africa', 'western-africa', 'Western Africa', 0),
('BL', 'Saint Barthélemy', 652, 'Americas', 'caribbean', 'Caribbean', 0),
('BM', 'Bermuda', 60, 'Americas', 'northern-america', 'Northern America', 0),
('BN', 'Brunei Darussalam', 96, 'Asia', 'south-eastern-asia', 'South-eastern Asia', 0),
('BO', 'Bolivia (Plurinational State of)', 68, 'Americas', 'south-america', 'South America', 0),
('BQ', 'Bonaire, Sint Eustatius and Saba', 535, 'Americas', 'caribbean', 'Caribbean', 0),
('BR', 'Brazil', 76, 'Americas', 'south-america', 'South America', 0),
('BS', 'Bahamas', 44, 'Americas', 'caribbean', 'Caribbean', 0),
('BT', 'Bhutan', 64, 'Asia', 'southern-asia', 'Southern Asia', 0),
('BV', 'Bouvet Island', 74, 'Americas', 'caribbean', 'Caribbean', 0),
('BW', 'Botswana', 72, 'Africa', 'southern-africa', 'Southern Africa', 0),
('BY', 'Belarus', 112, 'Europe', 'eastern-europe', 'Eastern Europe', 0),
('BZ', 'Belize', 84, 'Americas', 'central-america', 'Central America', 0),
('CA', 'Canada', 124, 'Americas', 'northern-america', 'Northern America', 0),
('CC', 'Cocos (Keeling) Islands', 166, 'Oceania', 'australia-and-new-zealand', 'Australia and New Zealand', 0),
('CD', 'DR Congo', 180, 'Africa', 'central-africa', 'Central Africa', 0),
('CF', 'Central African Republic', 140, 'Africa', 'central-africa', 'Central Africa', 0),
('CG', 'Congo', 178, 'Africa', 'central-africa', 'Central Africa', 0),
('CH', 'Switzerland', 756, 'Europe', 'western-europe', 'Western Europe', 0),
('CI', 'Ivory Coast', 384, 'Africa', 'western-africa', 'Western Africa', 0),
('CK', 'Cook Islands', 184, 'Oceania', '', 'Polynesia', 0),
('CL', 'Chile', 152, 'Americas', 'south-america', 'South America', 0),
('CM', 'Cameroon', 120, 'Africa', 'central-africa', 'Central Africa', 0),
('CN', 'China', 156, 'Asia', 'eastern-asia', 'Eastern Asia', 0),
('CO', 'Colombia', 170, 'Americas', 'south-america', 'South America', 0),
('CR', 'Costa Rica', 188, 'Americas', 'central-america', 'Central America', 0),
('CU', 'Cuba', 192, 'Americas', 'caribbean', 'Caribbean', 0),
('CV', 'Cabo Verde', 132, 'Africa', 'western-africa', 'Western Africa', 0),
('CW', 'Curaçao', 531, 'Americas', 'caribbean', 'Caribbean', 0),
('CX', 'Christmas Island', 162, 'Oceania', 'australia-and-new-zealand', 'Australia and New Zealand', 0),
('CY', 'Cyprus', 196, 'Asia', 'western-asia', 'Western Asia', 0),
('CZ', 'Czechia', 203, 'Europe', 'eastern-europe', 'Eastern Europe', 0),
('DE', 'Germany', 276, 'Europe', 'western-europe', 'Western Europe', 0),
('DJ', 'Djibouti', 262, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('DK', 'Denmark', 208, 'Europe', 'northern-europe', 'Northern Europe', 0),
('DM', 'Dominica', 212, 'Americas', 'caribbean', 'Caribbean', 0),
('DO', 'Dominican Republic', 214, 'Americas', 'caribbean', 'Caribbean', 0),
('DZ', 'Algeria', 12, 'Africa', 'northern-africa', 'Northern Africa', 0),
('EC', 'Ecuador', 218, 'Americas', 'south-america', 'South America', 0),
('EE', 'Estonia', 233, 'Europe', 'northern-europe', 'Northern Europe', 0),
('EG', 'Egypt', 818, 'Africa', 'northern-africa', 'Northern Africa', 0),
('EH', 'Western Sahara', 732, 'Africa', '', 'Northern Africa', 0),
('ER', 'Eritrea', 232, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('ES', 'Spain', 724, 'Europe', 'southern-europe', 'Southern Europe', 0),
('ET', 'Ethiopia', 231, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('FI', 'Finland', 246, 'Europe', 'northern-europe', 'Northern Europe', 0),
('FJ', 'Fiji', 242, 'Oceania', 'melanesia', 'Melanesia', 0),
('FK', 'Falkland Islands (Malvinas)', 238, 'Americas', 'south-america', 'South America', 0),
('FM', 'Micronesia (Federated States of)', 583, 'Oceania', 'micronesia', 'Micronesia', 0),
('FO', 'Faroe Islands', 234, 'Europe', 'northern-europe', 'Northern Europe', 0),
('FR', 'France', 250, 'Europe', 'western-europe', 'Western Europe', 0),
('GA', 'Gabon', 266, 'Africa', 'central-africa', 'Central Africa', 0),
('GB', 'United Kingdom', 826, 'Europe', 'northern-europe', 'Northern Europe', 0),
('GD', 'Grenada', 308, 'Americas', 'caribbean', 'Caribbean', 0),
('GE', 'Georgia', 268, 'Asia', 'western-asia', 'Western Asia', 0),
('GF', 'French Guiana', 254, 'Americas', 'south-america', 'South America', 0),
('GG', 'Guernsey', 831, 'Europe', 'northern-europe', 'Northern Europe', 0),
('GH', 'Ghana', 288, 'Africa', 'western-africa', 'Western Africa', 0),
('GI', 'Gibraltar', 292, 'Europe', 'southern-europe', 'Southern Europe', 0),
('GL', 'Greenland', 304, 'Americas', 'northern-america', 'Northern America', 0),
('GM', 'Gambia', 270, 'Africa', 'western-africa', 'Western Africa', 0),
('GN', 'Guinea', 324, 'Africa', 'western-africa', 'Western Africa', 0),
('GP', 'Guadeloupe', 312, 'Americas', 'caribbean', 'Caribbean', 0),
('GQ', 'Equatorial Guinea', 226, 'Africa', 'central-africa', 'Central Africa', 0),
('GR', 'Greece', 300, 'Europe', 'southern-europe', 'Southern Europe', 0),
('GS', 'South Georgia and the South Sandwich Islands', 239, 'Americas', 'south-america', 'South America', 0),
('GT', 'Guatemala', 320, 'Americas', 'central-america', 'Central America', 0),
('GU', 'Guam', 316, 'Oceania', 'micronesia', 'Micronesia', 0),
('GW', 'Guinea-Bissau', 624, 'Africa', 'western-africa', 'Western Africa', 0),
('GY', 'Guyana', 328, 'Americas', 'south-america', 'South America', 0),
('HK', 'Hong Kong', 344, 'Asia', 'eastern-asia', 'Eastern Asia', 0),
('HM', 'Heard Island and McDonald Islands', 334, 'Oceania', 'australia-and-new-zealand', 'Australia and New Zealand', 0),
('HN', 'Honduras', 340, 'Americas', 'central-america', 'Central America', 0),
('HR', 'Croatia', 191, 'Europe', 'southern-europe', 'Southern Europe', 0),
('HT', 'Haiti', 332, 'Americas', 'caribbean', 'Caribbean', 0),
('HU', 'Hungary', 348, 'Europe', 'eastern-europe', 'Eastern Europe', 0),
('ID', 'Indonesia', 360, 'Asia', 'south-eastern-asia', 'South-eastern Asia', 0),
('IE', 'Ireland', 372, 'Europe', 'northern-europe', 'Northern Europe', 0),
('IL', 'Israel', 376, 'Asia', 'western-asia', 'Western Asia', 0),
('IM', 'Isle of Man', 833, 'Europe', 'northern-europe', 'Northern Europe', 0),
('IN', 'India', 356, 'Asia', 'southern-asia', 'Southern Asia', 0),
('IO', 'British Indian Ocean Territory', 86, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('IQ', 'Iraq', 368, 'Asia', 'western-asia', 'Western Asia', 0),
('IR', 'Iran', 364, 'Asia', 'southern-asia', 'Southern Asia', 0),
('IS', 'Iceland', 352, 'Europe', 'northern-europe', 'Northern Europe', 0),
('IT', 'Italy', 380, 'Europe', 'southern-europe', 'Southern Europe', 0),
('JE', 'Jersey', 832, 'Europe', 'northern-europe', 'Northern Europe', 0),
('JM', 'Jamaica', 388, 'Americas', 'caribbean', 'Caribbean', 0),
('JO', 'Jordan', 400, 'Asia', 'western-asia', 'Western Asia', 0),
('JP', 'Japan', 392, 'Asia', 'eastern-asia', 'Eastern Asia', 0),
('KE', 'Kenya', 404, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('KG', 'Kyrgyzstan', 417, 'Asia', 'central-asia', 'Central Asia', 0),
('KH', 'Cambodia', 116, 'Asia', 'south-eastern-asia', 'South-eastern Asia', 0),
('KI', 'Kiribati', 296, 'Oceania', 'micronesia', 'Micronesia', 0),
('KM', 'Comoros', 174, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('KN', 'Saint Kitts and Nevis', 659, 'Americas', 'caribbean', 'Caribbean', 0),
('KP', 'North Korea', 408, 'Asia', 'eastern-asia', 'Eastern Asia', 0),
('KR', 'South Korea', 410, 'Asia', 'eastern-asia', 'Eastern Asia', 0),
('KW', 'Kuwait', 414, 'Asia', 'western-asia', 'Western Asia', 0),
('KY', 'Cayman Islands', 136, 'Americas', 'caribbean', 'Caribbean', 0),
('KZ', 'Kazakhstan', 398, 'Asia', 'central-asia', 'Central Asia', 0),
('LA', 'Laos', 418, 'Asia', 'south-eastern-asia', 'South-eastern Asia', 0),
('LB', 'Lebanon', 422, 'Asia', 'western-asia', 'Western Asia', 0),
('LC', 'Saint Lucia', 662, 'Americas', 'caribbean', 'Caribbean', 0),
('LI', 'Liechtenstein', 438, 'Europe', 'western-europe', 'Western Europe', 0),
('LK', 'Sri Lanka', 144, 'Asia', 'southern-asia', 'Southern Asia', 0),
('LR', 'Liberia', 430, 'Africa', 'western-africa', 'Western Africa', 0),
('LS', 'Lesotho', 426, 'Africa', 'southern-africa', 'Southern Africa', 0),
('LT', 'Lithuania', 440, 'Europe', 'northern-europe', 'Northern Europe', 0),
('LU', 'Luxembourg', 442, 'Europe', 'western-europe', 'Western Europe', 0),
('LV', 'Latvia', 428, 'Europe', 'northern-europe', 'Northern Europe', 0),
('LY', 'Libya', 434, 'Africa', 'northern-africa', 'Northern Africa', 0),
('MA', 'Morocco', 504, 'Africa', 'northern-africa', 'Northern Africa', 0),
('MC', 'Monaco', 492, 'Europe', 'western-europe', 'Western Europe', 0),
('MD', 'Moldova', 498, 'Europe', 'eastern-europe', 'Eastern Europe', 0),
('ME', 'Montenegro', 499, 'Europe', 'southern-europe', 'Southern Europe', 0),
('MF', 'Saint Martin (French part)', 663, 'Americas', 'caribbean', 'Caribbean', 0),
('MG', 'Madagascar', 450, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('MH', 'Marshall Islands', 584, 'Oceania', 'micronesia', 'Micronesia', 0),
('MK', 'North Macedonia', 807, 'Europe', 'southern-europe', 'Southern Europe', 0),
('ML', 'Mali', 466, 'Africa', 'western-africa', 'Western Africa', 0),
('MM', 'Myanmar', 104, 'Asia', 'south-eastern-asia', 'South-eastern Asia', 0),
('MN', 'Mongolia', 496, 'Asia', 'eastern-asia', 'Eastern Asia', 0),
('MO', 'Macao', 446, 'Asia', 'eastern-asia', 'Eastern Asia', 0),
('MP', 'Northern Mariana Islands', 580, 'Oceania', 'micronesia', 'Micronesia', 0),
('MQ', 'Martinique', 474, 'Americas', 'caribbean', 'Caribbean', 0),
('MR', 'Mauritania', 478, 'Africa', 'western-africa', 'Western Africa', 0),
('MS', 'Montserrat', 500, 'Americas', 'caribbean', 'Caribbean', 0),
('MT', 'Malta', 470, 'Europe', 'southern-europe', 'Southern Europe', 0),
('MU', 'Mauritius', 480, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('MV', 'Maldives', 462, 'Asia', 'southern-asia', 'Southern Asia', 0),
('MW', 'Malawi', 454, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('MX', 'Mexico', 484, 'Americas', 'central-america', 'Central America', 0),
('MY', 'Malaysia', 458, 'Asia', 'south-eastern-asia', 'South-eastern Asia', 0),
('MZ', 'Mozambique', 508, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('NA', 'Namibia', 516, 'Africa', 'southern-africa', 'Southern Africa', 0),
('NC', 'New Caledonia', 540, 'Oceania', 'melanesia', 'Melanesia', 0),
('NE', 'Niger', 562, 'Africa', 'western-africa', 'Western Africa', 0),
('NF', 'Norfolk Island', 574, 'Oceania', 'australia-and-new-zealand', 'Australia and New Zealand', 0),
('NG', 'Nigeria', 566, 'Africa', 'western-africa', 'Western Africa', 0),
('NI', 'Nicaragua', 558, 'Americas', 'central-america', 'Central America', 0),
('NL', 'Netherlands', 528, 'Europe', 'western-europe', 'Western Europe', 0),
('NO', 'Norway', 578, 'Europe', 'northern-europe', 'Northern Europe', 0),
('NP', 'Nepal', 524, 'Asia', 'southern-asia', 'Southern Asia', 0),
('NR', 'Nauru', 520, 'Oceania', 'micronesia', 'Micronesia', 0),
('NU', 'Niue', 570, 'Oceania', '', 'Polynesia', 0),
('NZ', 'New Zealand', 554, 'Oceania', 'australia-and-new-zealand', 'Australia and New Zealand', 0),
('OM', 'Oman', 512, 'Asia', 'western-asia', 'Western Asia', 0),
('PA', 'Panama', 591, 'Americas', 'central-america', 'Central America', 0),
('PE', 'Peru', 604, 'Americas', 'south-america', 'South America', 0),
('PF', 'French Polynesia', 258, 'Oceania', '', 'Polynesia', 0),
('PG', 'Papua New Guinea', 598, 'Oceania', 'melanesia', 'Melanesia', 0),
('PH', 'Philippines', 608, 'Asia', 'south-eastern-asia', 'South-eastern Asia', 0),
('PK', 'Pakistan', 586, 'Asia', 'southern-asia', 'Southern Asia', 0),
('PL', 'Poland', 616, 'Europe', 'eastern-europe', 'Eastern Europe', 0),
('PM', 'Saint Pierre and Miquelon', 666, 'Americas', 'northern-america', 'Northern America', 0),
('PN', 'Pitcairn', 612, 'Oceania', '', 'Polynesia', 0),
('PR', 'Puerto Rico', 630, 'Americas', 'caribbean', 'Caribbean', 0),
('PS', 'Palestine, State of', 275, 'Asia', 'western-asia', 'Western Asia', 0),
('PT', 'Portugal', 620, 'Europe', 'southern-europe', 'Southern Europe', 0),
('PW', 'Palau', 585, 'Oceania', 'micronesia', 'Micronesia', 0),
('PY', 'Paraguay', 600, 'Americas', 'south-america', 'South America', 0),
('QA', 'Qatar', 634, 'Asia', 'western-asia', 'Western Asia', 0),
('RE', 'Réunion', 638, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('RO', 'Romania', 642, 'Europe', 'eastern-europe', 'Eastern Europe', 0),
('RS', 'Serbia', 688, 'Europe', 'southern-europe', 'Southern Europe', 0),
('RU', 'Russian Federation', 643, 'Europe', 'eastern-europe', 'Eastern Europe', 0),
('RW', 'Rwanda', 646, 'Africa', 'central-africa', 'Central Africa', 0),
('SA', 'Saudi Arabia', 682, 'Asia', 'western-asia', 'Western Asia', 0),
('SB', 'Solomon Islands', 90, 'Oceania', 'melanesia', 'Melanesia', 0),
('SC', 'Seychelles', 690, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('SD', 'Sudan', 729, 'Africa', 'northern-africa', 'Northern Africa', 0),
('SE', 'Sweden', 752, 'Europe', 'northern-europe', 'Northern Europe', 0),
('SG', 'Singapore', 702, 'Asia', 'south-eastern-asia', 'South-eastern Asia', 0),
('SH', 'Saint Helena, Ascension and Tristan da Cunha', 654, 'Africa', 'western-africa', 'Western Africa', 0),
('SI', 'Slovenia', 705, 'Europe', 'southern-europe', 'Southern Europe', 0),
('SJ', 'Svalbard and Jan Mayen', 744, 'Europe', 'northern-europe', 'Northern Europe', 0),
('SK', 'Slovakia', 703, 'Europe', 'eastern-europe', 'Eastern Europe', 0),
('SL', 'Sierra Leone', 694, 'Africa', 'western-africa', 'Western Africa', 0),
('SM', 'San Marino', 674, 'Europe', 'southern-europe', 'Southern Europe', 0),
('SN', 'Senegal', 686, 'Africa', 'western-africa', 'Western Africa', 0),
('SO', 'Somalia', 706, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('SR', 'Suriname', 740, 'Americas', 'south-america', 'South America', 0),
('SS', 'South Sudan', 728, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('ST', 'Sao Tome and Principe', 678, 'Africa', 'central-africa', 'Central Africa', 0),
('SV', 'El Salvador', 222, 'Americas', 'central-america', 'Central America', 0),
('SX', 'Sint Maarten (Dutch part)', 534, 'Americas', 'caribbean', 'Caribbean', 0),
('SY', 'Syrian Arab Republic', 760, 'Asia', 'western-asia', 'Western Asia', 0),
('SZ', 'Eswatini', 748, 'Africa', 'southern-africa', 'Southern Africa', 0),
('TC', 'Turks and Caicos Islands', 796, 'Americas', 'caribbean', 'Caribbean', 0),
('TD', 'Chad', 148, 'Africa', 'central-africa', 'Central Africa', 0),
('TF', 'French Southern Territories', 260, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('TG', 'Togo', 768, 'Africa', 'western-africa', 'Western Africa', 0),
('TH', 'Thailand', 764, 'Asia', 'south-eastern-asia', 'South-eastern Asia', 0),
('TJ', 'Tajikistan', 762, 'Asia', 'central-asia', 'Central Asia', 0),
('TK', 'Tokelau', 772, 'Oceania', '', 'Polynesia', 0),
('TL', 'Timor-Leste', 626, 'Asia', 'south-eastern-asia', 'South-eastern Asia', 0),
('TM', 'Turkmenistan', 795, 'Asia', 'central-asia', 'Central Asia', 0),
('TN', 'Tunisia', 788, 'Africa', 'northern-africa', 'Northern Africa', 0),
('TO', 'Tonga', 776, 'Oceania', '', 'Polynesia', 0),
('TR', 'Turkey', 792, 'Asia', 'western-asia', 'Western Asia', 0),
('TT', 'Trinidad and Tobago', 780, 'Americas', 'caribbean', 'Caribbean', 0),
('TV', 'Tuvalu', 798, 'Oceania', '', 'Polynesia', 0),
('TW', 'Taiwan, China', 158, 'Asia', 'eastern-asia', 'Eastern Asia', 0),
('TZ', 'Tanzania', 834, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('UA', 'Ukraine', 804, 'Europe', 'eastern-europe', 'Eastern Europe', 0),
('UG', 'Uganda', 800, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('UM', 'United States Minor Outlying Islands', 581, 'Oceania', 'micronesia', 'Micronesia', 0),
('US', 'United States', 840, 'Americas', 'northern-america', 'Northern America', 0),
('UY', 'Uruguay', 858, 'Americas', 'south-america', 'South America', 0),
('UZ', 'Uzbekistan', 860, 'Asia', 'central-asia', 'Central Asia', 0),
('VA', 'Holy See', 336, 'Europe', 'southern-europe', 'Southern Europe', 0),
('VC', 'Saint Vincent and the Grenadines', 670, 'Americas', 'caribbean', 'Caribbean', 0),
('VE', 'Venezuela', 862, 'Americas', 'south-america', 'South America', 0),
('VG', 'Virgin Islands (British)', 92, 'Americas', 'caribbean', 'Caribbean', 0),
('VI', 'Virgin Islands (U.S.)', 850, 'Americas', 'caribbean', 'Caribbean', 0),
('VN', 'Viet Nam', 704, 'Asia', 'south-eastern-asia', 'South-eastern Asia', 0),
('VU', 'Vanuatu', 548, 'Oceania', 'melanesia', 'Melanesia', 0),
('WF', 'Wallis and Futuna', 876, 'Oceania', '', 'Polynesia', 0),
('WS', 'Samoa', 882, 'Oceania', '', 'Polynesia', 0),
('YE', 'Yemen', 887, 'Asia', 'western-asia', 'Western Asia', 0),
('YT', 'Mayotte', 175, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('ZA', 'South Africa', 710, 'Africa', 'southern-africa', 'Southern Africa', 0),
('ZM', 'Zambia', 894, 'Africa', 'eastern-africa', 'Eastern Africa', 0),
('ZW', 'Zimbabwe', 716, 'Africa', 'eastern-africa', 'Eastern Africa', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pf_country`
--
ALTER TABLE `pf_country`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
