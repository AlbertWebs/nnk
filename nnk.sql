-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2025 at 04:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nnk`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `image_path`, `description`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'WhatsApp Image 2025-11-20 at 12.07.03_ed0de750.jpg', 'gallery/1763734006_692071f6af5de.jpg', NULL, 1, '2025-11-21 11:06:46', '2025-11-21 11:06:46');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Lion', 'Lian', '2025-11-21 11:30:53', '2025-11-21 11:30:53'),
(3, 'Members', 'Members', '2025-11-21 11:47:40', '2025-11-21 11:47:40');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`id`, `group_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(2, 3, 2, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(3, 3, 3, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(4, 3, 4, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(5, 3, 5, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(6, 3, 6, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(7, 3, 7, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(8, 3, 8, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(9, 3, 9, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(10, 3, 10, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(11, 3, 11, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(12, 3, 12, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(13, 3, 13, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(14, 3, 14, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(15, 3, 15, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(16, 3, 16, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(17, 3, 17, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(18, 3, 18, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(19, 3, 19, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(20, 3, 20, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(21, 3, 21, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(22, 3, 22, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(23, 3, 23, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(24, 3, 24, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(25, 3, 25, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(26, 3, 26, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(27, 3, 27, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(28, 3, 28, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(29, 3, 29, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(30, 3, 30, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(31, 3, 31, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(32, 3, 32, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(33, 3, 33, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(34, 3, 34, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(35, 3, 35, '2025-11-21 11:55:11', '2025-11-21 11:55:11'),
(36, 3, 36, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(37, 3, 37, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(38, 3, 38, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(39, 3, 39, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(40, 3, 40, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(41, 3, 41, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(42, 3, 42, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(43, 3, 43, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(44, 3, 44, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(45, 3, 45, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(46, 3, 46, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(47, 3, 47, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(48, 3, 48, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(49, 3, 49, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(50, 3, 50, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(51, 3, 51, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(52, 3, 52, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(53, 3, 53, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(54, 3, 54, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(55, 3, 55, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(56, 3, 56, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(57, 3, 57, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(58, 3, 58, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(59, 3, 59, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(60, 3, 60, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(61, 3, 61, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(62, 3, 62, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(63, 3, 63, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(64, 3, 64, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(65, 3, 65, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(66, 3, 66, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(67, 3, 67, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(68, 3, 68, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(69, 3, 69, '2025-11-21 11:55:12', '2025-11-21 11:55:12'),
(70, 3, 70, '2025-11-21 11:55:12', '2025-11-21 11:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_15_090903_create_services_table', 2),
(5, '2025_11_21_131914_create_galleries_table', 3),
(6, '2025_11_21_141127_create_groups_table', 4),
(7, '2025_11_21_141134_create_group_members_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta` text DEFAULT NULL,
  `slung` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `meta`, `slung`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Welfare Fund', 'Access supportive and timely financial aid through NNK Staff Sacco\'s Welfare Fund—created to assist members during unforeseen life events and emergencies.', 'welfare-fund', '<div class=\"service-description\">\n    <h1>Welfare Fund – Supporting Members When It Matters Most</h1>\n    <div class=\"lead\">\n        At <strong>NNK Staff Sacco Limited</strong>, we believe that true financial empowerment goes beyond savings and loans — it’s also about standing with our members during life’s most challenging moments. The <strong>Welfare Fund</strong> is a specially designated support initiative created to assist members who are facing difficult circumstances such as bereavement, critical illness, hospitalization, or other unforeseen emergencies.\n\n        <br><br>\n\n        This fund reflects our deep commitment to the values of unity, compassion, and mutual aid. It serves as a financial cushion, helping members handle sensitive situations with dignity and reduced stress. By offering quick and structured relief during emergencies, the Welfare Fund enhances the Sacco’s role as not just a financial partner but also a caring community.\n\n        <br><br>\n\n        Eligibility for the Welfare Fund is open to all active members in good standing, and disbursement is done in accordance with our by-laws and established welfare guidelines. Contributions to the Welfare Fund are collective, ensuring that every member plays a part in uplifting others — a true demonstration of the cooperative spirit.\n\n        <br><br>\n\n        Whether it\'s providing support during a family loss, assisting with funeral expenses, or helping a member recover from a personal crisis, the Welfare Fund is here to ensure that you are never alone when life takes an unexpected turn.\n\n        <br><br>\n\n        <strong>Need help during a difficult time?</strong> Contact us to learn more about how the Welfare Fund works, your eligibility, and how to apply for support when it’s needed most.\n    </div>\n</div>\n', 'labour-welfare-fund-benefits.png', '2025-07-15 06:13:22', '2025-07-15 06:13:22'),
(2, 'Normal /Development Loan', 'Access flexible and affordable credit through NNK Sacco’s Normal /Development Loan—ideal for home improvement, business growth, and personal development.', 'normal-development-loan', '<div class=\"service-description\">\n    <h1>Normal /Development Loan – Empowering Member Growth Through Affordable Credit</h1>\n    <div class=\"lead\">\n        At <strong>NNK Staff Sacco Limited</strong>, we are committed to supporting our members\' personal and professional growth through accessible, member-driven lending solutions. Our <strong>Normal /Development Loan</strong> is designed to provide flexible financing for a wide range of needs — from home improvements and business expansion to personal development goals such as education or asset acquisition.\n\n        <br><br>\n\n        This loan product is structured to offer competitive interest rates, reasonable repayment periods, and a straightforward application process. Whether you\'re planning to renovate your home, invest in a long-term project, or start a side business, our Normal /Development Loan is tailored to support your ambitions with dependable and structured financial assistance.\n\n        <br><br>\n\n        Members are eligible for this loan based on their savings history and ability to repay, in accordance with our lending policy. Loan approvals are handled transparently and professionally, ensuring fairness and financial stability for both the borrower and the Sacco.\n\n        <br><br>\n\n        As a Sacco founded on cooperative principles, we believe in providing financial tools that foster empowerment, independence, and sustainable development. The Normal /Development Loan is a reflection of this vision — giving our members the financial strength to build a better future for themselves and their families.\n\n        <br><br>\n\n        <strong>Ready to take the next step?</strong> Apply today and unlock affordable credit that works for you, not against you.\n    </div>\n</div>', 'dev-loan-bg.jpg', '2025-07-15 06:13:22', '2025-07-15 06:13:22'),
(3, 'Refinancing Loan', 'Simplify your debt with NNK Sacco’s Refinancing Loan — designed to consolidate existing loans into one affordable and flexible repayment plan.', 'refinancing-loan', '<div class=\"service-description\">\n    <h1>Refinancing Loan – A Fresh Start for Your Financial Journey</h1>\n    <div class=\"lead\">\n        Managing multiple loans or dealing with high repayment burdens can be overwhelming. At <strong>NNK Staff Sacco Limited</strong>, we offer the <strong>Refinancing Loan</strong> as a strategic solution to help our members consolidate existing loans or restructure their current debt into more manageable and affordable terms.\n\n        <br><br>\n\n        Our Refinancing Loan is designed to ease financial pressure by giving members the opportunity to merge outstanding loan balances — either within the Sacco or from other institutions — into a single, flexible repayment plan. This allows you to regain control of your finances, improve your cash flow, and focus on building a healthier financial future.\n\n        <br><br>\n\n        With competitive interest rates, extended repayment periods, and member-friendly terms, this loan product is ideal for those seeking a fresh financial start without the burden of juggling multiple obligations. Whether you\'re seeking lower monthly payments or better loan conditions, our refinancing option is tailored to align with your goals.\n\n        <br><br>\n\n        Eligibility is based on your current Sacco standing, repayment ability, and the nature of the loans you wish to consolidate. All applications are reviewed fairly and transparently by our credit team, ensuring that you receive advice and support that serves your best interests.\n\n        <br><br>\n\n        <strong>Looking to simplify your repayments?</strong> Contact us today to explore our Refinancing Loan and take the next step toward financial clarity and peace of mind.\n    </div>\n</div>\n', 'Mortgage-Refinance.jpg', '2025-07-15 06:13:22', '2025-07-15 06:13:22'),
(4, 'School Fees Loan', 'Get quick and affordable education financing with NNK Sacco’s School Fees Loan. Designed to support members with tuition, books, and related academic expenses across all education levels.', 'school-fees-loan', '<div class=\"service-description\">\n    <h1>School Fees Loan – Making Education Accessible for Every Member</h1>\n    <div class=\"lead\">\n        At <strong>NNK Staff Sacco Limited</strong>, we believe that access to education should never be limited by financial constraints. That’s why we offer the <strong>School Fees Loan</strong>, a reliable and affordable solution for members seeking support with academic expenses. Whether it’s for primary, secondary, tertiary, or professional learning institutions, our School Fees Loan is tailored to ensure that your children, dependents, or even yourself can continue with education uninterrupted.\n\n        <br><br>\n\n        This loan product covers tuition fees, exam registration, books, uniforms, and other related academic costs. We understand that the back-to-school season can be financially demanding, and emergencies can arise even during the school term. With this in mind, our School Fees Loan provides fast disbursement, competitive interest rates, and flexible repayment terms to ease the burden on your finances.\n\n        <br><br>\n\n        The loan is accessible to all active Sacco members who demonstrate consistent saving behavior and a good loan repayment history. By offering timely financial aid, we enable our members to plan ahead and secure the educational future of their loved ones without resorting to high-interest commercial credit.\n\n        <br><br>\n\n        As a Sacco committed to empowerment through service, we are proud to support lifelong learning and academic progress. The School Fees Loan is more than just a financial product — it is an investment in human potential, community development, and a brighter tomorrow.\n\n        <br><br>\n\n        <strong>Don’t let tuition hold you back.</strong> Apply today and let NNK Sacco walk with you on the journey to quality education and a better future.\n    </div>\n</div>\n', 'iStock-1252883373.jpg', '2025-07-15 06:13:22', '2025-07-15 06:13:22'),
(5, 'Emergency Loan', 'Handle urgent situations with ease using NNK Sacco’s Emergency Loan. Fast, flexible, and reliable financial assistance when you need it most.', 'emergency-loan', '<div class=\"service-description\">\n    <h1>Emergency Loan – Quick Relief When You Need It Most</h1>\n    <div class=\"lead\">\n        Life can change in an instant, and unexpected emergencies often bring financial pressure at the worst possible time. At <strong>NNK Staff Sacco Limited</strong>, we’re here to help our members navigate those moments with dignity and ease through our <strong>Emergency Loan</strong> facility. Whether it\'s an urgent medical bill, a family crisis, travel need, or another unplanned situation, our Emergency Loan provides fast, dependable financial assistance exactly when it’s needed.\n\n        <br><br>\n\n        The Emergency Loan is tailored for speed and simplicity. Our streamlined application and approval process ensure that funds are disbursed promptly — often within the same day — so that you can focus on resolving the matter at hand, not stressing about how to pay for it. Members can apply based on their current savings and repayment ability, and we remain committed to offering affordable interest rates and flexible repayment timelines.\n\n        <br><br>\n\n        As a Sacco rooted in the spirit of mutual support and community, we recognize the importance of acting swiftly when our members are in distress. Our Emergency Loan reflects that commitment — delivering compassionate financial relief with minimal paperwork and maximum understanding.\n\n        <br><br>\n\n        <strong>Facing an urgent financial situation?</strong> Reach out to us today and let NNK Sacco’s Emergency Loan help you get back on your feet — because we’re always here when you need us most.\n    </div>\n</div>\n', 'EmergencyLoan-21-1-2020.jpg', '2025-07-15 06:13:22', '2025-07-15 06:13:22'),
(6, 'Holiday Loan', 'Enjoy stress-free holidays with NNK Sacco’s Holiday Loan. Quick, affordable loans to help you travel, celebrate, and create unforgettable memories.', 'holiday-loan', '<div class=\"service-description\">\n    <h1>Holiday Loan – Make Every Moment Count</h1>\n    <div class=\"lead\">\n        At <strong>NNK Staff Sacco Limited</strong>, we believe that rest, relaxation, and time with family are essential to your overall well-being. Our <strong>Holiday Loan</strong> is designed to help members plan and enjoy their holidays without financial strain. Whether you\'re preparing for end-of-year travel, festive celebrations, a family getaway, or simply want to unwind, this loan makes it possible to enjoy life’s special moments stress-free.\n\n        <br><br>\n\n        With convenient application steps, affordable interest rates, and flexible repayment terms, the Holiday Loan gives you the freedom to plan ahead or respond to spontaneous travel opportunities. Whether it\'s accommodation, transport, gifts, or seasonal expenses — we\'ve got you covered.\n\n        <br><br>\n\n        All active Sacco members with a good savings record and responsible loan history are eligible to apply. The approval process is fast, ensuring you don’t miss out on limited-time travel deals or seasonal events.\n\n        <br><br>\n\n        At NNK Sacco, we understand that life isn\'t just about working — it’s also about creating memories that matter. The Holiday Loan is our way of helping you strike that balance, by making your dream getaway or family celebration a reality.\n\n        <br><br>\n\n        <strong>Ready to make your next holiday unforgettable?</strong> Apply today and let NNK Staff Sacco support your journey to joyful, memorable experiences.\n    </div>\n</div>\n', 'beach-holiday-summer-sun-favim-com-1927437.jpg', '2025-07-15 06:13:22', '2025-07-15 06:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3wLRx4XnGhkEjl3YLYUBMv8KBLfdTjRrLuTxh1k6', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWhBUDBBMjF3dmJsUEZDcUlwSElKdGVIUXZidXlMRU9oMzVWN3dobiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jb250YWN0LXVzIjt9fQ==', 1753167934),
('5J0LFxqBqojmuFd7jBk8h9F34pKx5AIbquNSPRaC', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGRJSXR2NWt5UHVnVmN0SGtvVW5oNGVhbkpJWjVYaFU3T1BZUGlPWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hYm91dC11cyI7fX0=', 1753101630),
('iEbwo69p7WKHafPUw81gpGyAzDohgIstvpW3ZQ2a', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibXc2ZjZnNDladHJ0V1NoNXVjZ1FQcXROVTBEQ0NKdnk0bnNVUHp3MCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fX0=', 1752656582);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'member',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@nnkstaffsacco.com', 'admin', NULL, '$2y$12$5kN3jC9T90Lqb1oTkQhDsuaQe3fPEBpYn4Y4X0ZZgEwouuEhTH.MC', '2fZipPWVoqkQQPnalamW3bSDSUaCyUzBkHu2Ut0eKcGFef7j5blFBZPXv2AT', '2025-07-14 07:47:50', '2025-07-14 07:47:50'),
(2, 'Loan Officer', 'officer@nnkstaffsacco.com', 'officer', NULL, '$2y$12$8y2jo.NH7iKiInd54z3Jferb9hR3OnsvCMUqWRR2/EAnsm3zYblay', NULL, '2025-07-14 07:47:50', '2025-07-14 07:47:50'),
(3, 'Member User', 'member@nnkstaffsacco.com', 'member', NULL, '$2y$12$tImWbOGEKTPEhGJ2cmwn6e5.JsNRANqjQOR6cwdAY6YjSoOtNT/Eu', NULL, '2025-07-14 07:47:50', '2025-07-14 07:47:50'),
(4, 'Ambrosenjeru', 'ambrosenjeru@gmail.com', 'member', NULL, '$2y$12$tg6R9M/c0Nvt4qR7mTbdfesURFpnRYbMFYq24ry830DjM97vDcWTe', NULL, '2025-11-21 11:35:41', '2025-11-21 11:35:41'),
(5, 'Anjeru', 'anjeru@tripleoklaw.com', 'member', NULL, '$2y$12$ayT9TyZB4731PwG8ys4VVeWYG1F2Qm46yeCfCmavRoy.Ot6nOed0i', NULL, '2025-11-21 11:35:42', '2025-11-21 11:35:42'),
(6, 'Akadzo', 'akadzo@tripleoklaw.com', 'member', NULL, '$2y$12$NWrJ/zTSQ5.0U7D26g3.UuKsKC813CH8/crcpktZfIz6/hIqv2Foi', NULL, '2025-11-21 11:35:43', '2025-11-21 11:35:43'),
(7, 'Wacekeannie', 'wacekeannie@citibus.co.ke', 'member', NULL, '$2y$12$zNxDVqhPds0EnFAraGKjDuNP0BeGaQAeYi2jDMqjRjfaHzKWzKjaq', NULL, '2025-11-21 11:35:43', '2025-11-21 11:35:43'),
(8, 'Ndiranguann', 'ndiranguann93@yahoo.com', 'member', NULL, '$2y$12$2WGQzV.Hk9UR2bw5DmEEiuAlR7wxlfk/2V8NudR7afhRZpWynUSA2', NULL, '2025-11-21 11:35:44', '2025-11-21 11:35:44'),
(9, 'Kitongas', 'kitongas325@gmail.com', 'member', NULL, '$2y$12$y4P2iAi5HAfvtKdwWGzsLO.r38nwJLbiHiMtIupsnufNFRxWsNNYa', NULL, '2025-11-21 11:35:44', '2025-11-21 11:35:44'),
(10, 'Bngunzi', 'bngunzi@ngunziandassociates.co.ke', 'member', NULL, '$2y$12$cLWx1iz9lQXK7ayoJ17TaOYg3oprgWNmn7CPyBCOYwZOexOHvZ.zu', NULL, '2025-11-21 11:35:45', '2025-11-21 11:35:45'),
(11, 'Bethu', 'bethu69@gmail.com', 'member', NULL, '$2y$12$pHf4p6tzgKAj96lICU82n.wDBb.S6TYQxvUNgDiPp8cPvETaO0BNu', NULL, '2025-11-21 11:35:45', '2025-11-21 11:35:45'),
(12, 'Clarajaluha', 'clarajaluha41@gmail.com', 'member', NULL, '$2y$12$IVOuRWuAVf.OSyKogW30cevqj49Q7q5mDMvvjFDUQv0kvG1TuNZqe', NULL, '2025-11-21 11:35:46', '2025-11-21 11:35:46'),
(13, 'Charlesnjagi', 'charlesnjagi@yahoo.com', 'member', NULL, '$2y$12$pQknwdkwuJKvmShkkKjKpe4AN7jWgTLvRvOgww/mK2za3cI4NL076', NULL, '2025-11-21 11:35:47', '2025-11-21 11:35:47'),
(14, 'Echelagat', 'echelagat@tripleoklaw.com', 'member', NULL, '$2y$12$BGQ3PwXQwMWMNp.taq1mMetcNCANdIUOWW7DXt1kJmCelQtl2yf3u', NULL, '2025-11-21 11:35:48', '2025-11-21 11:35:48'),
(15, 'Consolatawanjirukariuki', 'consolatawanjirukariuki@gmail.com', 'member', NULL, '$2y$12$iZ9VaDPB9tHnaa1DDRm6F.w2h2fuLQIghdqj1U1jjduedx2W1Cy2.', NULL, '2025-11-21 11:35:48', '2025-11-21 11:35:48'),
(16, 'Cnyaruiru', 'cnyaruiru@gmail.com', 'member', NULL, '$2y$12$PHAPPtyXn7s3xmxDsvhl6.nTOHdcLZvZ0wRRCgXMQ32YvyyBPZoZu', NULL, '2025-11-21 11:35:49', '2025-11-21 11:35:49'),
(17, 'Cecil Kuyo', 'cecil_kuyo@yahoo.com', 'member', NULL, '$2y$12$UWLqEgkEx/kNnnZUTnm4VOVEDcSWt7KJahM5w.aMHXfxvKjb6s5wG', NULL, '2025-11-21 11:35:49', '2025-11-21 11:35:49'),
(18, 'Adalodaniel', 'adalodaniel28@gmail.com', 'member', NULL, '$2y$12$KbVCYUaMT7MkeUyjXskFbuizHsIDSY6tJ0ZB6z8AO4spIN0AYLPp2', NULL, '2025-11-21 11:35:50', '2025-11-21 11:35:50'),
(19, 'Dlumwaji', 'dlumwaji@tripleoklaw.com', 'member', NULL, '$2y$12$.SFZN057PkIconhWwqqrxOVAIP7vpWY26NnwiPTo3vmOh8CdlPZqi', NULL, '2025-11-21 11:35:51', '2025-11-21 11:35:51'),
(20, 'Jdondi', 'jdondi@tripleoklaw.com', 'member', NULL, '$2y$12$gKK67jf.S.W68y69VH5Q.Os0Gjbgoto14o6IOVYYK9bSuHcyQN8mu', NULL, '2025-11-21 11:35:53', '2025-11-21 11:35:53'),
(21, 'Estherkitonga', 'estherkitonga7013@gmail.com', 'member', NULL, '$2y$12$fP.qBcm6dq977bpXVJfTkO38ViMbFU1HmDIwfWI0Y2fPTDWIkaYma', NULL, '2025-11-21 11:35:53', '2025-11-21 11:35:53'),
(22, 'Emureithi', 'emureithi@tripleoklaw.com', 'member', NULL, '$2y$12$NPMnrqHM8khrh35bb47bmuiJzUnPitJVatpkhXNAKNaBvmPFkeQp2', NULL, '2025-11-21 11:35:54', '2025-11-21 11:35:54'),
(23, 'Eodhiambo', 'eodhiambo@tripleoklaw.com', 'member', NULL, '$2y$12$MsNX3ctnq6x/hnGFkigJouK.f7E5V7oGQWCtcI3aI24UA6vckI.G2', NULL, '2025-11-21 11:35:55', '2025-11-21 11:35:55'),
(24, 'E Murua', 'e_murua@yahoo.com', 'member', NULL, '$2y$12$N.BGXBZG/os5UIubHYJhc.rOvbTFo.Pin6H7heHgR8ITBpp7.4f2i', NULL, '2025-11-21 11:35:55', '2025-11-21 11:35:55'),
(25, 'Fmunyao', 'fmunyao@tripleoklaw.com', 'member', NULL, '$2y$12$xu7U9FUudcj.4IIch9q98.EtdyxCtM9sk3woHfQ4SuU10MQHPqSw6', NULL, '2025-11-21 11:35:56', '2025-11-21 11:35:56'),
(26, 'Fwandera', 'fwandera@tripleoklaw.com', 'member', NULL, '$2y$12$uPleJsqTwqVMWyyZftWyE.brArrGuH7HIm4AgRKBW36BeYkun0qzK', NULL, '2025-11-21 11:35:56', '2025-11-21 11:35:56'),
(27, 'Gacherujane', 'gacherujane2016@gmail.com', 'member', NULL, '$2y$12$MWzefrUXpmPASr5/KGBZ3.dHqBM4F7Dp0II2p67X7gAjF1KprE7yK', NULL, '2025-11-21 11:35:57', '2025-11-21 11:35:57'),
(28, 'Gatheruwangui', 'gatheruwangui230@gmail.com', 'member', NULL, '$2y$12$6VvUYxE/3RBcTZdiez2ihOJSk9uKJApbEeUEUR5QPuq5mc/vPyTrC', NULL, '2025-11-21 11:35:57', '2025-11-21 11:35:57'),
(29, 'Gachukiawanyoike', 'gachukiawanyoike@gmail.com', 'member', NULL, '$2y$12$Oma1mSC6i795U6TlPOFivO1hD03sFTBYk/IdHersb7ZTzlB0Z7xaW', NULL, '2025-11-21 11:35:58', '2025-11-21 11:35:58'),
(30, 'Ikiche', 'ikiche@tripleoklaw.com', 'member', NULL, '$2y$12$z1xxSK34VmkQCrVAD4KjFeYaY8e6lPNN9d3NiuFAO.bvvt80DW43K', NULL, '2025-11-21 11:35:58', '2025-11-21 11:35:58'),
(31, 'Jkabue', 'jkabue@tripleoklaw.com', 'member', NULL, '$2y$12$haTSD3ZDTlQ4qRmLM9Mw6.GwiJv0yvQdoyQZdcjaluqOMXncbJRK.', NULL, '2025-11-21 11:35:59', '2025-11-21 11:35:59'),
(32, 'Jim Manyonge', 'jim.manyonge@gmail.com', 'member', NULL, '$2y$12$d58qLHken6hpx/NiDLKG4e9FU7DZIDX2sBc7La45Db07idTCcZVb2', NULL, '2025-11-21 11:35:59', '2025-11-21 11:35:59'),
(33, 'Jochieng', 'jochieng@tripleoklaw.com', 'member', NULL, '$2y$12$NLxvkYPpXl0fJZjDRwFDQeb1y5v6qDdC1TNhKvs.Mv6.znc4/BjS.', NULL, '2025-11-21 11:36:00', '2025-11-21 11:36:00'),
(34, 'Kamathuku', 'kamathuku@gmail.com', 'member', NULL, '$2y$12$Hyt40cDe46q66fZUAgxKF.hIweCUzaC35r9ZMaJRUlwN9QqUe9xMu', NULL, '2025-11-21 11:36:01', '2025-11-21 11:36:01'),
(35, 'Jenipher Musambai', 'jenipher.musambai@gmail.com', 'member', NULL, '$2y$12$1cNFxeh8axg3N60gU0BtUOIA2c2pxTKraBt39FvRgufWrjoodIUza', NULL, '2025-11-21 11:36:01', '2025-11-21 11:36:01'),
(36, 'Tonyango', 'tonyango@tripleoklaw.com', 'member', NULL, '$2y$12$ceSAFLhAjoPqHP/tJ/HWwOnzRT3FFuY098G.WvoZM8YIAUHpcZpce', NULL, '2025-11-21 11:36:02', '2025-11-21 11:36:02'),
(37, 'Jkibet', 'jkibet@tripleoklaw.com', 'member', NULL, '$2y$12$if5jxttk3rGL9QhiVn9xEuOj2MzWvPs7tOf2sjxzU091cTcCiWhnK', NULL, '2025-11-21 11:36:02', '2025-11-21 11:36:02'),
(38, 'Jnjeri', 'jnjeri@tripleoklaw.com', 'member', NULL, '$2y$12$AhwPk.4DJMVFHqZKC2j3kOxHdUFFxpKKA5psNoAm64UGAelCJZavG', NULL, '2025-11-21 11:36:03', '2025-11-21 11:36:03'),
(39, 'Jmbeya', 'jmbeya@tripleoklaw.com', 'member', NULL, '$2y$12$Jn1GmtTY2sR/gVnJ6PyAI.esJCzFGqsHYzCe8aa.KihAr0qdfyD1a', NULL, '2025-11-21 11:36:03', '2025-11-21 11:36:03'),
(40, 'Kimtuku', 'kimtuku@gmail.com', 'member', NULL, '$2y$12$zoKmm/bWPNmOJKyuNz26ZuDmCAIEIIBNbLqFIziksYAFlrLYbltUC', NULL, '2025-11-21 11:36:04', '2025-11-21 11:36:04'),
(41, 'Kibanyakamaulaw', 'kibanyakamaulaw@gmail.com', 'member', NULL, '$2y$12$mn5SPm1Ol0XtqhOUaP8DR.IrbJKDqYMgDoTu3ZN5ljGVKi9l5MPHG', NULL, '2025-11-21 11:36:04', '2025-11-21 11:36:04'),
(42, 'Pkihato', 'pkihato@tripleoklaw.com', 'member', NULL, '$2y$12$oR0SW/bbpABCd4w4gQrTB.Q.x4bqk3zCAP6.u/UWSXGWRVsTI3plm', NULL, '2025-11-21 11:36:05', '2025-11-21 11:36:05'),
(43, 'Lndungu', 'lndungu@nnkadvocates.co.ke', 'member', NULL, '$2y$12$S4cni0IE1FJ9M5LvhOTuae33Zoi6oiFVyqS0jbOlevsl.kFeN7TYS', NULL, '2025-11-21 11:36:05', '2025-11-21 11:36:05'),
(44, 'Lmwangangi', 'lmwangangi@tripleoklaw.com', 'member', NULL, '$2y$12$J5YKtE7rtnQpGRvqyXUHe.6GmtkR/hzrUaMLp/0nB0weKYXikN3.G', NULL, '2025-11-21 11:36:06', '2025-11-21 11:36:06'),
(45, 'Marysheila', 'marysheila@tripleoklaw.com', 'member', NULL, '$2y$12$GVwHDWGeTL.lIJBino4oWO4uuVc8BEnwULQWIOtuhZ.O7N21Pjnby', NULL, '2025-11-21 11:36:06', '2025-11-21 11:36:06'),
(46, 'Ymukua', 'ymukua@gmail.com', 'member', NULL, '$2y$12$DBedYLuysLkefMj/m5tlDuT7Ngj25i.UQZ.s8gOm/wB/C18433X5O', NULL, '2025-11-21 11:36:07', '2025-11-21 11:36:07'),
(47, 'Modhiambo', 'modhiambo@tripleoklaw.com', 'member', NULL, '$2y$12$rX97W5hWOcodo5kBSkUtCeu2Na9Tla5N/q8pufbtRJNLCGGOk4hrq', NULL, '2025-11-21 11:36:07', '2025-11-21 11:36:07'),
(48, 'Mwaura Rachel', 'mwaura_rachel@yahoo.com', 'member', NULL, '$2y$12$Zm79HtBSVBK5m41DSpIk6uNyDhOZYxtJR8OXPr0kXz4IK.JYQrxkO', NULL, '2025-11-21 11:36:08', '2025-11-21 11:36:08'),
(49, 'Morris Oduor', 'morris.oduor@gmail.com', 'member', NULL, '$2y$12$pPgWQfDRmodEYdZxWfY5Ze36Wq3H0yckTTQkS3SLQze6W8umENlMq', NULL, '2025-11-21 11:36:08', '2025-11-21 11:36:08'),
(50, 'Mercynjokiguku', 'mercynjokiguku@yahoo.com', 'member', NULL, '$2y$12$eJifG.OOoq8ce90gdqzveOjl7QVcD3Y5YnC3UEZd8aWv/IZxgAasm', NULL, '2025-11-21 11:36:09', '2025-11-21 11:36:09'),
(51, 'Maggretaz', 'maggretaz@gmail.com', 'member', NULL, '$2y$12$bvW/aHk2ERbHFm7TAJAl5e57QaJYbqKL3jzfSZ/ZwrB6ir074YVZe', NULL, '2025-11-21 11:36:09', '2025-11-21 11:36:09'),
(52, 'Mnduku', 'mnduku@tripleoklaw.com', 'member', NULL, '$2y$12$X2n8SarZAibxy/BxxPZmhOuPCWsAPv47Ph4FsUa25CpqZIN99Wh7.', NULL, '2025-11-21 11:36:10', '2025-11-21 11:36:10'),
(53, 'Nicmachar', 'nicmachar@gmail.com', 'member', NULL, '$2y$12$4ZhtVd0HMA4ipBmXYlZmT.tgdZkOKBM4HW6mRkRmaa7t73bYiyZgO', NULL, '2025-11-21 11:36:10', '2025-11-21 11:36:10'),
(54, 'Rose Knjoki', 'rose.knjoki@gmail.com', 'member', NULL, '$2y$12$Qj8bqIrfG8/aGWAowz1gXO03L2txjSNG0WxKmyW2R7a0G5ydAiv1q', NULL, '2025-11-21 11:36:11', '2025-11-21 11:36:11'),
(55, 'Nwetunga', 'nwetunga@gmail.com', 'member', NULL, '$2y$12$PZNvOD60zAuPh.66sSNdUu/pBL41OxpkYghJV0HVJkCbsoyM8HYny', NULL, '2025-11-21 11:36:11', '2025-11-21 11:36:11'),
(56, 'Wojore', 'wojore@tripleoklaw.com', 'member', NULL, '$2y$12$hQmhUhXWKImOoo1LgqUHaOu1BSmvo9TzUWACzuR6ZqLgfAVSO6IRW', NULL, '2025-11-21 11:36:12', '2025-11-21 11:36:12'),
(57, 'Paulinejk', 'paulinejk@gmail.com', 'member', NULL, '$2y$12$3Qc6Ytu.ZRLxLVqW5d39i.lZBqdWY0MIDhogpOyIXNs7YME7V7eki', NULL, '2025-11-21 11:36:13', '2025-11-21 11:36:13'),
(58, 'Ruthmaina', 'ruthmaina82@yahoo.com', 'member', NULL, '$2y$12$RBOEIeNo/o7uFiyHlYly6.Pv78ffqJENSvDFVLpIkhsVd3NRx47qW', NULL, '2025-11-21 11:36:14', '2025-11-21 11:36:14'),
(59, 'Rosekiama', 'rosekiama911@gmail.com', 'member', NULL, '$2y$12$Dd9WWj7ZIM/wmnQzT80o/evXnGlgXnDLF38IeqIiUACqpoVKDmnNq', NULL, '2025-11-21 11:36:14', '2025-11-21 11:36:14'),
(60, 'Simonmusembeisyengo', 'simonmusembeisyengo@gmail.com', 'member', NULL, '$2y$12$BkAzu14L0IIyDE8UuTaituY3WQyWVTIJdlsVKsjGvLPxLaAUicWKS', NULL, '2025-11-21 11:36:15', '2025-11-21 11:36:15'),
(61, 'Syengolito', 'syengolito@gmail.com', 'member', NULL, '$2y$12$qMh11yYsmhu3MYAQO7ztBuFrK0.k4RGl6jllEqFlfyKAbh0xig/ny', NULL, '2025-11-21 11:36:16', '2025-11-21 11:36:16'),
(62, 'Winisimz', 'winisimz@gmail.com', 'member', NULL, '$2y$12$mdzhG05zvWlJOwHCrR5TdO0F8vJKz/kC7uolg8RFDjNH3dUPsjqse', NULL, '2025-11-21 11:36:17', '2025-11-21 11:36:17'),
(63, 'Wmuiggz', 'wmuiggz2014@gmail.com', 'member', NULL, '$2y$12$SWXnuJxPdEluy0ZrwvjVruJ0rm06AeQvrs0ACcvv.iwldL/SzZsem', NULL, '2025-11-21 11:36:17', '2025-11-21 11:36:17'),
(64, 'Mwambua', 'mwambua@tripleoklaw.com', 'member', NULL, '$2y$12$RkQjx5OZRx1Bl5OixHqI5ugtMg8zvDYo4NOP7wxlXKaiV.2yByp1G', NULL, '2025-11-21 11:36:18', '2025-11-21 11:36:18'),
(65, 'Munuthiwanjiku', 'munuthiwanjiku@gmail.com', 'member', NULL, '$2y$12$fBQLajNtQLAM6.jAseAi9uATGMoJ0F53I1bWP5UDBlPpReaLbgEWC', NULL, '2025-11-21 11:36:19', '2025-11-21 11:36:19'),
(66, 'Wacekeannie', 'wacekeannie@gmail.com', 'member', NULL, '$2y$12$uQ3jEeqNljKxyGqgsQJeM.QGFGj8fKbnnhVSUhl3QhQij409lXvzy', NULL, '2025-11-21 11:36:21', '2025-11-21 11:36:21'),
(67, 'Duncanmuchani', 'duncanmuchani779@gmail.com', 'member', NULL, '$2y$12$S/OrTxbEx8FsmoYDej9ag.pddCV6iVsbI9MVu5pExzDpH6O2f7gui', NULL, '2025-11-21 11:36:22', '2025-11-21 11:36:22'),
(68, 'Mmngunzi', 'mmngunzi@yahoo.com', 'member', NULL, '$2y$12$c9WIazuNa32HeIyawe1QBe7ypRzSG9wgfsrPmBW1onuLZ.NEWbxyO', NULL, '2025-11-21 11:36:22', '2025-11-21 11:36:22'),
(69, 'Winnerangelica', 'winnerangelica@gmail.com', 'member', NULL, '$2y$12$TofEzkS1kyILONfLKbjmheeJdkNsMHPlewnTnghg8C22Dudb62.V6', NULL, '2025-11-21 11:36:23', '2025-11-21 11:36:23'),
(70, 'Kimanthimwabuli', 'kimanthimwabuli@gmail.com', 'member', NULL, '$2y$12$t2CNxIi38LDTCtHkXsr5Uera/l6zztbkax5RXvbC2mBIl9G6.U.i.', NULL, '2025-11-21 11:36:24', '2025-11-21 11:36:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_user_id_foreign` (`user_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `groups_name_unique` (`name`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_members_group_id_user_id_unique` (`group_id`,`user_id`),
  ADD KEY `group_members_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slung_unique` (`slung`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_members_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
