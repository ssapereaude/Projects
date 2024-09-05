-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 07:16 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `mysterybox`
--

CREATE TABLE `mysterybox` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mysterybox`
--

INSERT INTO `mysterybox` (`id`, `username`, `amount`, `date`) VALUES
(10, 'legend', 2, '2024-04-24'),
(11, 'filip24', 2, '2024-04-24'),
(12, 'zihantheman', 5, '2024-04-24'),
(13, 'zihantheman', 25, '2024-04-24'),
(14, 'legend24', 2, '2024-04-29'),
(15, 'legend24', 2, '2024-04-29'),
(16, 'legend24', 10, '2024-04-29');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `balanceUP` double DEFAULT NULL,
  `isSuccessfull` tinyint(4) DEFAULT NULL
) ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`paymentID`, `username`, `timestamp`, `balanceUP`, `isSuccessfull`) VALUES
('cs_test_a130HleHMZLVXzk0s9hDjiZvS91ruznUuwreFZi9RE060Rc7pIFHTw6P4k', 'legend24', '2024-04-29 14:05:41', 30, 1),
('cs_test_a1eAGGE9fwSoGHnF8ikQmdAocGVFZ0Lzf7pszUcBva59Y8rzL0wnQ5mueo', 'legend24', '2024-04-29 14:22:36', 30, 1),
('cs_test_a1ejf5furLQ811U0TPg2XfxdLDUgKJqbWDfh0OiSwtUIkZjGVaKWw8XSIZ', 'legend', '2024-04-24 10:44:38', 20, 1),
('cs_test_a1T9wywWHhZnot194GH0aAmqCbRSU0nEyc9k5mIWJfZ3bCqzuFjdL40YO8', 'josie', '2024-04-24 10:59:58', 30, 1),
('cs_test_a1X9iFDwt707wkH77VP0BMlfvLZc3E00HJqdrfodwaUMnbWB8OpKAYBu94', 'legend24', '2024-04-29 14:22:00', 15, 1),
('cs_test_a1xF9GIA8jMVE8ej8LVAVcybImFjR5i4QpYtTzGGpbqwGwaOARUgDUPwYV', 'zihantheman', '2024-04-24 10:53:03', 20, 1),
('cs_test_a1YFPYnymFZHpOLZ5LtHfSF0vjz9UTU6dO9jMTKdbPfUwgOUYAaAHXkjoR', 'filip24', '2024-04-24 10:49:31', 50, 1),
('cs_test_a1z4bxNaTAa760GJYh9h38lnNk1YDqC7Ynm2dR9wuxCLwk1SFSfYVfeOo0', 'legend', '2024-04-24 10:42:38', 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `game` varchar(30) NOT NULL,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bet` double NOT NULL,
  `multiplier` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `game`, `username`, `timestamp`, `bet`, `multiplier`) VALUES
(19, 'mines', 'legend', '2024-04-24 10:43:49', 8, 0),
(20, 'mines', 'legend', '2024-04-24 10:43:52', 8, 0),
(21, 'mines', 'legend', '2024-04-24 10:43:57', 8, 0),
(22, 'mines', 'legend', '2024-04-24 10:44:03', 8, 1.1),
(23, 'mines', 'legend', '2024-04-24 10:44:10', 8, 0),
(24, 'mines', 'filip24', '2024-04-24 10:50:42', 10, 1.1576250000000001),
(25, 'mines', 'filip24', '2024-04-24 10:50:51', 8, 0),
(26, 'mines', 'filip24', '2024-04-24 10:51:15', 8, 1.04060401),
(27, 'mines', 'zihantheman', '2024-04-24 10:54:28', 5, 0),
(28, 'mines', 'zihantheman', '2024-04-24 10:54:41', 5, 1),
(29, 'mines', 'zihantheman', '2024-04-24 10:55:36', 10, 1.1380932804332895),
(30, 'mines', 'zihantheman', '2024-04-24 10:56:12', 10, 1.1380932804332895),
(31, 'mines', 'zihantheman', '2024-04-24 10:56:35', 10, 0),
(32, 'mines', 'zihantheman', '2024-04-24 10:56:47', 10, 1.0303010000000001),
(35, 'mines', 'legend24', '2024-04-29 14:07:28', 8, 0),
(36, 'mines', 'legend24', '2024-04-29 14:07:40', 8, 1.1576250000000001),
(37, 'mines', 'legend24', '2024-04-29 14:21:19', 25, 1.2100000000000002),
(38, 'mines', 'legend24', '2024-04-29 14:21:28', 10, 0),
(39, 'mines', 'legend24', '2024-04-29 14:21:37', 8, 4),
(40, 'mines', 'legend24', '2024-04-29 14:21:52', 25, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `token` varchar(50) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` double DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joined` date DEFAULT current_timestamp(),
  `nextMysteryBox` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `balance`, `email`, `password`, `joined`, `nextMysteryBox`) VALUES
('filip24', 65.9, 'my@gmail.com', '$2b$10$2zJuPgZHjfKWkLspm5/0luUTuzLSrrbWjxYKZva05vPrEXwsor9KK', '2024-04-24', '2024-04-25'),
('josie', 50, 'josie@gmail.com', '$2b$10$/xawxA4LzgHZcRx8a4AS9eqUxnzN/.DnC.aiw2UdHCGj7tvN9t4Wu', '2024-04-24', '2024-04-24'),
('legend', 25.8, 'filip@gmail.com', '$2b$10$ZNxIcntiDVDKSL64A51n2.XkD26i6cO49tqIakqowtYWreft4gLLa', '2024-04-24', '2024-04-25'),
('legend24', 96.50999999999999, 'legend@gmail.com', '$2b$10$gpwhMphzfwtu5Q8Td0H7Fu22G7Mmhja9jPs5aiVu1NYcDLnT1g9/C', '2024-04-29', '2024-04-30'),
('zihantheman', 58.06, 'zihan@gmail.com', '$2b$10$6k3dHMQhxEEmZFfQv8yM/.H37WEhElU2y3VoikgUxpffPu2DZUgSC', '2024-04-24', '2024-04-25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mysterybox`
--
ALTER TABLE `mysterybox`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mysterybox_ibfk_1` (`username`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `payments_ibfk_1` (`username`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `results_ibfk_1` (`username`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token`),
  ADD KEY `tokens_ibfk_1` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mysterybox`
--
ALTER TABLE `mysterybox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mysterybox`
--
ALTER TABLE `mysterybox`
  ADD CONSTRAINT `mysterybox_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
