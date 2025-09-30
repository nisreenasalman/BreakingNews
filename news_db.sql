-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 30 سبتمبر 2025 الساعة 19:07
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news_db`
--

-- --------------------------------------------------------

--
-- بنية الجدول `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `PostTitle` varchar(255) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `SubCategoryId` int(11) NOT NULL,
  `PostDetails` longtext NOT NULL,
  `Is_Active` tinyint(1) NOT NULL DEFAULT 1,
  `PostImage` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `posts`
--

INSERT INTO `posts` (`id`, `PostTitle`, `CategoryId`, `SubCategoryId`, `PostDetails`, `Is_Active`, `PostImage`, `user_id`, `created_at`, `updated_at`) VALUES
(20, 'كرة القدم', 2, 3, 'يسيالبابت', 0, 'post_68dbee923fe53.jpg', 4, '2025-09-30 17:52:02', '2025-09-30 18:11:13'),
(21, 'السعودية تعلن عن مشروع \"ذا لاين\" كمدينة مستقبلية خالية من الانبعاثات', 1, 1, 'أعلنت المملكة العربية السعودية، اليوم الثلاثاء، عن إطلاق مشروع \"ذا لاين\" في منطقة نيوم، وهي مدينة مستقبلية تمتد بطول 170 كم وتُعد الأولى من نوعها في العالم من حيث التصميم المستقيم والاعتماد الكامل على الطاقة النظيفة.\r\n\r\nوأوضح ولي العهد الأمير محمد بن سلمان أن المشروع يهدف إلى تقديم نموذج حضري غير مسبوق يضع الإنسان أولًا، من خلال مدينة خالية من السيارات والشوارع والانبعاثات الكربونية، وستُدار بشكل كامل بالاعتماد على الذكاء الاصطناعي.\r\n\r\nوأكد أن \"ذا لاين\" ستوفر ما يصل إلى 380 ألف فرصة عمل جديدة، وستُسهم في الناتج المحلي الإجمالي بقيمة تصل إلى 180 مليار ريال سعودي بحلول عام 2030.\r\n\r\nوأضاف أن المشروع سيُبنى على بُنية تحتية متقدمة تتيح الوصول إلى كافة الخدمات الحيوية في أقل من 5 دقائق سيرًا على الأقدام، وسيتم ربط أطراف المدينة عبر قطار فائق السرعة.', 1, 'post_68dbf30a96639.jpg', 4, '2025-09-30 18:11:06', '2025-09-30 18:11:06'),
(22, 'الجامعة العربية تدعو إلى اجتماع طارئ لمناقشة تطورات الأوضاع في غزة', 1, 2, 'دعت الجامعة العربية إلى عقد اجتماع طارئ لمجلس وزراء الخارجية العرب، وذلك لمناقشة التصعيد العسكري في قطاع غزة والجهود المبذولة لوقف إطلاق النار.\r\n\r\nوأوضح بيان صادر عن الأمانة العامة أن الاجتماع سيُعقد في مقر الجامعة بالقاهرة يوم الأحد المقبل، بناءً على طلب عدد من الدول الأعضاء، في ظل تدهور الأوضاع الإنسانية وازدياد أعداد الضحايا المدنيين.\r\n\r\nوأكد الأمين العام للجامعة، أحمد أبو الغيط، أن استمرار العمليات العسكرية يعمّق الأزمة ويهدد الاستقرار الإقليمي، داعيًا المجتمع الدولي إلى تحمل مسؤولياته و\"الضغط لوقف العدوان وحماية المدنيين\".\r\n\r\nومن المتوقع أن يصدر عن الاجتماع بيان ختامي يدعو إلى وقف فوري لإطلاق النار، واستئناف مفاوضات السلام وفقًا لمبادرة السلام العربية وقرارات الشرعية الدولية.', 1, 'post_68dbf361075cc.jpg', 4, '2025-09-30 18:12:33', '2025-09-30 18:12:33'),
(23, 'الهلال السعودي يتوّج بلقب دوري أبطال آسيا للمرة الخامسة في تاريخه', 2, 3, 'حقق نادي الهلال السعودي لقب دوري أبطال آسيا 2025، بعد فوزه المثير على نظيره الياباني أوراوا ريد دايموندز بنتيجة 2-1 في المباراة النهائية التي أقيمت على ملعب الملك فهد الدولي في الرياض.\r\n\r\nسجل هدفي الهلال كل من النجم البرازيلي نيمار دا سيلفا في الدقيقة 27، واللاعب المحلي سالم الدوسري في الدقيقة 71، في حين سجل الفريق الياباني هدفه الوحيد في الدقيقة 83.\r\n\r\nوبهذا التتويج، عزز الهلال رقمه القياسي كأكثر الأندية تتويجًا بلقب البطولة القارية، بـ 5 ألقاب، في إنجاز غير مسبوق على مستوى الأندية الآسيوية.\r\n\r\nوعقب المباراة، عبّر المدير الفني للهلال، البرتغالي خورخي جيسوس، عن فخره بأداء اللاعبين، قائلاً:\r\n\"قدمنا موسماً استثنائيًا واستحققنا هذا اللقب بجدارة. نعد جماهيرنا بالمزيد في كأس العالم للأندية.\"', 1, 'post_68dbf3d55748e.png', 4, '2025-09-30 18:14:29', '2025-09-30 18:14:29');

--
-- القوادح `posts`
--
DELIMITER $$
CREATE TRIGGER `trg_posts_bi_check_category` BEFORE INSERT ON `posts` FOR EACH ROW BEGIN
  DECLARE sc_cat_id INT;
  SELECT CategoryId INTO sc_cat_id
  FROM tblsubcategory WHERE SubCategoryId = NEW.SubCategoryId;
  IF sc_cat_id IS NULL THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'SubCategoryId غير موجود';
  END IF;
  IF NEW.CategoryId <> sc_cat_id THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'CategoryId لا يطابق CategoryId للـ SubCategory';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_posts_bu_check_category` BEFORE UPDATE ON `posts` FOR EACH ROW BEGIN
  DECLARE sc_cat_id INT;
  SELECT CategoryId INTO sc_cat_id
  FROM tblsubcategory WHERE SubCategoryId = NEW.SubCategoryId;
  IF sc_cat_id IS NULL THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'SubCategoryId غير موجود';
  END IF;
  IF NEW.CategoryId <> sc_cat_id THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'CategoryId لا يطابق CategoryId للـ SubCategory';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- بنية الجدول `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL,
  `Description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `Description`) VALUES
(1, 'سياسة', 'أخبار السياسة'),
(2, 'رياضة', 'أخبار الرياضة'),
(3, 'تقنية', 'أخبار التقنية');

-- --------------------------------------------------------

--
-- بنية الجدول `tblsubcategory`
--

CREATE TABLE `tblsubcategory` (
  `SubCategoryId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Subcategory` varchar(100) NOT NULL,
  `SubCatDescription` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `tblsubcategory`
--

INSERT INTO `tblsubcategory` (`SubCategoryId`, `CategoryId`, `Subcategory`, `SubCatDescription`) VALUES
(1, 1, 'محلي', 'السياسة المحلية'),
(2, 1, 'دولي', 'السياسة الدولية'),
(3, 2, 'كرة قدم', 'أخبار كرة القدم'),
(4, 2, 'تنس', 'أخبار التنس'),
(5, 3, 'ذكاء اصطناعي', 'AI');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'a', 'admin@gmail.com', '$2y$10$wpidRXBz1lZP8pj/WQqbjOhtL9Qa/8vYZZgEdDaj/iVJktkSqKMMq', '2025-09-22 12:59:08'),
(2, 'a', 'a@gmail.com', '$2y$10$anwUKeVCyMJQWoli5qqGmuQw6qX7CCUl5P3lVZ3Tpdzdu5erOOX9K', '2025-09-22 13:00:56'),
(3, 'نسرينا سلمان', 'nisreena@gmail.com', '$2y$10$b8b97wjsD13RV8KiXkWKe.N5yy1mqipuUJlpfnUDrSpxLj9isJDUm', '2025-09-30 17:16:03'),
(4, 'نسرينا', 'nisreenaa@gmail.com', '$2y$10$DCRY7BUFDWzlBnXWEIUQWuWjBweX4L97X0rp2ZB8kYu0g6OpNOy3m', '2025-09-30 17:40:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_posttitle` (`PostTitle`),
  ADD KEY `idx_category` (`CategoryId`),
  ADD KEY `idx_subcategory` (`SubCategoryId`),
  ADD KEY `idx_posts_active_cat_sub` (`Is_Active`,`CategoryId`,`SubCategoryId`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_categoryname` (`CategoryName`);

--
-- Indexes for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  ADD PRIMARY KEY (`SubCategoryId`),
  ADD UNIQUE KEY `uq_category_subcategory` (`CategoryId`,`Subcategory`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  MODIFY `SubCategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_category` FOREIGN KEY (`CategoryId`) REFERENCES `tblcategory` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_posts_subcategory` FOREIGN KEY (`SubCategoryId`) REFERENCES `tblsubcategory` (`SubCategoryId`) ON UPDATE CASCADE;

--
-- قيود الجداول `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  ADD CONSTRAINT `fk_subcat_category` FOREIGN KEY (`CategoryId`) REFERENCES `tblcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
