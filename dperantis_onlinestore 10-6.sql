-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 08:16 PM
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
-- Database: `dperantis_onlinestore`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `AdminUsername` varchar(50) DEFAULT NULL,
  `AdminPass` varchar(50) DEFAULT NULL,
  `AdminName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminUsername`, `AdminPass`, `AdminName`) VALUES
(1, 'aadam', '11111', 'Adam Hakimi'),
(2, 'farid007', '50efc57834495f6b1e5f7b6270a15e1786720cc3', 'farid kamil');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `CustID` int(11) DEFAULT NULL,
  `ProdID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartID`, `CustID`, `ProdID`, `Quantity`) VALUES
(25, 4, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustID` int(11) NOT NULL,
  `CustUsername` varchar(50) DEFAULT NULL,
  `CustPass` varchar(50) DEFAULT NULL,
  `CustEmail` varchar(100) DEFAULT NULL,
  `CustName` varchar(100) DEFAULT NULL,
  `CustAddress` varchar(255) DEFAULT NULL,
  `CustPhoneNo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustID`, `CustUsername`, `CustPass`, `CustEmail`, `CustName`, `CustAddress`, `CustPhoneNo`) VALUES
(2, 'aadaamn', '92f6073b3fcbc0dd635c0494d4c0313e5544ecdd', 'aadam.hkimi@gmail.com', 'Adam Hakimi', '5984, Jln Kerdas 4, Kg Kerdas, Gombak, 53100 Kuala Lumpur', '0176055782'),
(3, 'assiralama', '50efc57834495f6b1e5f7b6270a15e1786720cc3', 'amal@gmail.com', NULL, NULL, NULL),
(4, 'eddie', '50efc57834495f6b1e5f7b6270a15e1786720cc3', 'adxm.hkimi@gmail.com', '', '', ''),
(5, 'faisal7908', '50efc57834495f6b1e5f7b6270a15e1786720cc3', 'fantasyadam10@gmail.com', 'Faisal Alif', '773, Jalan Sikamat, Kg Kepala Batas, 44100 Penang', '013219389');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `DeliveryID` int(11) NOT NULL,
  `TrackingCode` varchar(50) DEFAULT NULL,
  `CourierName` varchar(100) DEFAULT NULL,
  `OrderID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`DeliveryID`, `TrackingCode`, `CourierName`, `OrderID`) VALUES
(1, '31231231231', 'J & T Express', 8),
(2, '31231231236', 'NinjaVan', 15),
(3, NULL, NULL, 16),
(4, '5234134253425', 'Pos Laju', 17),
(5, NULL, NULL, 18),
(6, NULL, NULL, 19),
(7, NULL, NULL, 20),
(8, NULL, NULL, 21),
(9, NULL, NULL, 22),
(10, NULL, NULL, 23),
(11, NULL, NULL, 24),
(12, NULL, NULL, 25),
(13, NULL, NULL, 26);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `OrderID` int(11) NOT NULL,
  `OrderDate` date DEFAULT NULL,
  `CustID` int(11) DEFAULT NULL,
  `TotalProd` int(11) DEFAULT NULL,
  `TotalAmount` decimal(10,2) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`OrderID`, `OrderDate`, `CustID`, `TotalProd`, `TotalAmount`, `Status`) VALUES
(5, '2024-06-01', 2, 1, 1.00, 'Delivered'),
(6, '2024-06-01', 2, 2, 3100.00, 'Delivered'),
(8, '2024-06-02', 2, 5, 2903.00, 'In Transit'),
(15, '2024-06-02', 2, 2, 1701.00, 'Delivered'),
(16, '2024-06-02', 2, 1, 1.00, 'Delivered'),
(17, '2024-06-03', 2, 2, 1401.00, 'Packing'),
(18, '2024-06-05', 2, 3, 4100.00, 'In Transit'),
(19, '2024-06-08', 2, 5, 10800.00, 'Packing'),
(20, '2024-06-07', 2, 1, 1.00, 'Packing'),
(21, '2024-06-03', 2, 1, 2400.00, 'Paid'),
(22, '2024-06-03', 2, 2, 4100.00, 'Paid'),
(23, '2024-06-04', 2, 1, 1.00, 'Paid'),
(24, '2024-06-04', 2, 4, 7700.00, 'Paid'),
(25, '2024-06-09', 2, 1, 3400.00, 'Paid'),
(26, '2024-06-09', 5, 1, 1400.00, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE `orderitem` (
  `OrderItemID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `ProdID` int(11) DEFAULT NULL,
  `PricePerItem` decimal(10,2) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `TotalPrice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitem`
--

INSERT INTO `orderitem` (`OrderItemID`, `OrderID`, `ProdID`, `PricePerItem`, `Quantity`, `TotalPrice`) VALUES
(2, 5, 10, 1.00, 1, 1.00),
(3, 6, 3, 1700.00, 1, 1700.00),
(4, 6, 6, 1400.00, 1, 1400.00),
(5, 8, 4, 2400.00, 1, 2400.00),
(6, 8, 10, 1.00, 3, 3.00),
(7, 8, 7, 500.00, 1, 500.00),
(8, 15, 10, 1.00, 1, 1.00),
(9, 15, 3, 1700.00, 1, 1700.00),
(10, 16, 10, 1.00, 1, 1.00),
(11, 17, 6, 1400.00, 1, 1400.00),
(12, 17, 10, 1.00, 1, 1.00),
(13, 18, 2, 1200.00, 2, 2400.00),
(14, 18, 3, 1700.00, 1, 1700.00),
(15, 19, 4, 2400.00, 2, 4800.00),
(16, 19, 5, 3400.00, 1, 3400.00),
(17, 19, 6, 1400.00, 1, 1400.00),
(18, 19, 2, 1200.00, 1, 1200.00),
(19, 20, 10, 1.00, 1, 1.00),
(20, 21, 4, 2400.00, 1, 2400.00),
(21, 22, 3, 1700.00, 1, 1700.00),
(22, 22, 4, 2400.00, 1, 2400.00),
(23, 23, 10, 1.00, 1, 1.00),
(24, 24, 3, 1700.00, 1, 1700.00),
(25, 24, 6, 1400.00, 1, 1400.00),
(26, 24, 5, 3400.00, 1, 3400.00),
(27, 24, 2, 1200.00, 1, 1200.00),
(28, 25, 5, 3400.00, 1, 3400.00),
(29, 26, 6, 1400.00, 1, 1400.00);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PayID` varchar(255) NOT NULL,
  `PayDate` date DEFAULT NULL,
  `AmountPaid` decimal(10,2) DEFAULT NULL,
  `OrderID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PayID`, `PayDate`, `AmountPaid`, `OrderID`) VALUES
('1aa6b0wc', '2024-06-01', 1.00, 5),
('2k58rt6c', '2024-06-03', 1.00, 20),
('2rg4h6jz', '2024-06-01', 3100.00, 6),
('5ei35zwl', '2024-06-02', 2903.00, 8),
('5nx9ym5y', '2024-06-03', 4100.00, 22),
('7i8zdgsw', '2024-06-03', 1401.00, 17),
('8xqoatrd', '2024-06-02', 1701.00, 15),
('f3gtf5tl', '2024-06-04', 7700.00, 24),
('fz8d2j0u', '2024-06-04', 1.00, 23),
('is4dgiqx', '2024-06-09', 1400.00, 26),
('ltgv6z91', '2024-06-03', 4100.00, 18),
('lutqbrqo', '2024-06-02', 1.00, 16),
('qv3685c6', '2024-06-03', 2400.00, 21),
('u7hu0qbp', '2024-06-09', 3400.00, 25),
('xb9ahfj6', '2024-06-03', 10800.00, 19);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProdID` int(11) NOT NULL,
  `ProdName` varchar(100) DEFAULT NULL,
  `ProdPrice` decimal(10,2) DEFAULT NULL,
  `ProdDesc` text DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProdID`, `ProdName`, `ProdPrice`, `ProdDesc`, `Image`, `CategoryID`) VALUES
(2, 'Apple Iphone 11', 1200.00, '-512GB The iPhone 11 comes with a 6.7-inch LTPO Super Retina XDR OLED display, an Apple A17 Pro chipset, and a triple rear camera setup with a 48 MP main camera.', 'iphone11.png', 1),
(3, 'Apple Iphone 12', 1700.00, '-512GB The iPhone 12 comes with a 6.7-inch LTPO Super Retina XDR OLED display, an Apple A17 Pro chipset, and a triple rear camera setup with a 48 MP main camera.', 'iphone12.jpg', 1),
(4, 'Apple Iphone 13', 2400.00, 'As part of our efforts to reach carbon neutrality by 2030, iPhone 14 and iPhone 14 Plus do not include a power adapter or EarPods. Included in the box is a USB‑C to Lightning Cable that supports fast charging and is compatible with USB‑C power adapters and computer ports.\r\n\r\nWe encourage you to re‑use your current USB‑A to Lightning cables, power adapters and headphones that are compatible with these iPhone models. But if you need any new Apple power adapters or headphones, they are available for purchase.', 'iphone13.png', 1),
(5, 'Apple Iphone 14', 3400.00, '-512GB The iPhone 14 comes with a 6.7-inch LTPO Super Retina XDR OLED display, an Apple A17 Pro chipset, and a triple rear camera setup with a 48 MP main camera.', 'iphone14.jpg', 1),
(6, 'Apple Airpods Max', 1400.00, '', 'applemax.jpg', 2),
(7, 'Apple Airpods Pro', 500.00, '', 'airpodspro.jpg', 2),
(10, 'Test Product', 1.00, 'Experience the brilliance of the iPhone with its stunning Retina display, available in a variety of vibrant colors. Enjoy cutting-edge technology, sleek design, and exceptional performance in the palm of your hand. Elevate your mobile experience today!\r\n', 'applewatch.jpg', 1),
(43, 'Samsung Galaxy S24 Ultra ', 6799.00, '-512GB The Samsung Galaxy S24 Ultra features a 6.8-inch Dynamic LTPO AMOLED 2X display, a Qualcomm SM8650-AC Snapdragon 8 Gen 3 chipset, and a quad-camera setup with a 200 MP main camera. ', 'samsungs24ultra.jpg', 1),
(44, 'Samsung Galaxy A55  ', 1999.00, '-256GB The Samsung Galaxy A55 has a 6.6-inch Super AMOLED display, an Exynos 1480 chipset, and a triple rear camera setup with a 50 MP main camera.', 'samsunggalaxya55.jpg', 1),
(45, 'Xiaomi 13T Pr0', 2499.00, '-512GB The Xiaomi 13T Pro is equipped with a 6.67-inch display, a MediaTek Dimensity 9200 Plus chipset, and a triple rear camera setup with a 48 MP main camera.', 'xiaomi13tpro.jpg', 1),
(46, 'HUAWEI Pura 70 Pro', 4899.00, '-512GB The HUAWEI Pura 70 Pro features a 6.8-inch display, a Kirin 9010 chipset, and a triple rear camera setup with a 50 MP main camera.', 'huaweipura70pro.jpg', 1),
(47, 'Iphone 15 pro max', 7499.00, '-512GB The iPhone 15 Pro Max comes with a 6.7-inch LTPO Super Retina XDR OLED display, an Apple A17 Pro chipset, and a triple rear camera setup with a 48 MP main camera.', 'iphone15promax.jpg', 1),
(48, 'Sony WH-1000XM4 Wireless Noise Cancelling Headphones', 1049.00, 'Premium noise cancelling headphones with up to 30-hour battery life.', 'sonyWH-1000XM4.jpg', 2),
(49, 'Sony WH-1000XM5 Wireless Noise Cancelling Headphones', 1449.00, 'High-quality headphones with improved noise canceling and smart features.', 'sonyWH-1000XM5.jpg', 2),
(50, 'Creative Pebble Modern 2.0 USB Desktop Speakers', 84.00, 'Sleek 2.0 speakers with a 45° elevated sound stage.', 'creativepebblespeaker.jpg', 2),
(51, 'Logitech G560 Speaker', 699.00, '2.1 speaker system with full-spectrum LIGHTSYNC RGB.', 'logitechg560.jpg', 2),
(52, 'HyperX Cloud Alpha S 7.1 Surround Sound USB Gaming Headset', 539.00, 'Gaming headset with HyperX virtual 7.1 surround sound.', 'HyperXCloudAlpha(1).jpg', 2),
(53, 'Logitech G435 Wireless Gaming Headset', 268.00, 'Lightweight wireless gaming headset with low-latency Bluetooth connectivity.', 'LogitechG435headphone.jpg', 2),
(54, 'ASUS Vivobook S 16 OLED', 4599.00, '- Windows 11 Home - ASUS recommends Windows 11 Home for business\nThin and light: 1.39 cm, 1.5 kg\nUp to AMD Ryzen™ 9 8945HS processor\nDedicated Copilot key for more AI exploration\nLong-lasting 75 Wh battery\n16” 3.2K 120 Hz OLED HDR display\nSing-zone RGB backlit keyboard\nUp to 1 TB SSD, up to 32 GB memory', 'asusvivobooks16oled.jpg', 3),
(55, 'ROG Zephyrus G14 (2024)', 8299.00, 'Windows 11 Home\r\nAMD Ryzen™ 9 8945HS Processor 4GHz (24MB Cache, up to 5.2 GHz, 8 cores, 16 Threads); AMD Ryzen™ AI up to 39 TOPs\r\nNVIDIA® GeForce RTX™ 4050 Laptop GPU\r\nROG Boost: 2105MHz* at 90W (2055MHz Boost Clock+50MHz OC, 65W+25W Dynamic Boost)\r\n6GB GDDR6\r\nXDNA 16TOPs\r\nROG Nebula Display, 3K (2880 x 1800) OLED 16:10 aspect ratio, DCI-P3:\r\n100%\r\n8GB*2 LPDDR5X 6400 on board(Rated speed of RAM module.\r\n1TB PCIe® 4.0 NVMe™ M.2 SSD\r\n1080P FHD IR Camera for Windows Hello\r\nSmart Amp Technology\r\nDolby Atmos', 'ROGZephyrusG14.jpg', 3),
(56, 'Acer Aspire 3 Intel', 3299.00, 'Intel® Core™ i7-1255U processor Deca-core 1.70 GHz\r\nIntel® Iris® Xe Graphics shared memory\r\n39.6 cm (15.6\") Full HD (1920 x 1080) 16:9 60 Hz\r\n16 GB, DDR4 SDRAM\r\n512 GB SSD', 'aceraspire3.jpg', 3),
(57, 'Lenovo Ideapad Slim 3', 1899.91, 'Up to AMD Ryzen 7 7730U Processor\r\nUp to Windows 11 Pro\r\nIntegrated AMD Radeon™ Graphics\r\nUp to 16GB LPDDR4	\r\nUp to 1TB M.2 PCle SSD', 'lenovoideapadslim3.jpg', 3),
(58, 'HP Slim Desktop PC', 3799.00, '13th Generation Intel® Core™ i7 processor\r\nWindows 11 Home Single Language in S mode\r\nIntel® ADL H670\r\n8 GB DDR4-3200 MHz RAM\r\n512 GB PCIe® NVMe™ M.2 SSD Hard drive', 'hpslimdesktoppc.jpg', 3),
(59, 'ROG Strix G16 (2024)', 6488.00, 'Windows 11 Home      \r\nIntel® Core™ i9 Processor 14900HX \r\nRTX™ 4060 140W TGP \r\n16GB DDR5-5600 MHz \r\n1TB PCIe® 4.0 NVMe™ M.2 SSD \r\n16-inch FHD+ 16:10 \r\nIPS-Level \r\nsRGB 100% \r\n165Hz \r\nG-Sync', 'ROGStrixG16(2024).jpg', 3),
(60, 'Legion Tower 5i (26L, Gen 8)', 5479.26, '14th Generation Intel® Core™ i5-14400F Processor \nWindows 11 Home Single Language 64\nNVIDIA® GeForce RTX™ 4060 8GB GDDR6\n8 GB DDR5-5600MHz (UDIMM)\n512 GB SSD M.2 2280 PCIe Gen4 Performance TLC', 'legiontower5i.jpg', 3),
(61, 'HP 150 Wireless Mouse', 41.00, 'Ambidextrous design fits either hand\r\nClutter free with a 2.4 GHz wireless connection via simple dongle\r\nThree buttons in one mouse\r\nWith a 1600 DPI optical sensor\r\nWith 1 Year Limited Warranty', 'hp150mouse.jpg', 4),
(62, 'Armaggeddon MBA 61R', 139.00, 'Dual Mode Connectivity | Bluetooth and Wired\r\nHot Swappable Modular Mechanical Switches\r\nAutomatically Sleep Mode\r\nPair and Switch Between 3 Different device\r\nN-Key Rollover\r\nErgonomics Design\r\nType C Connector\r\nOutemu Blue Switches\r\nOn/Off Switch\r\n16.8 Million RGB Lightning Effects\r\n18 Different Pre-Set Backlight EFX', 'armaggeddonmba61r.jpg', 4),
(63, 'Armaggeddon Falcon III Gaming Mouse', 89.00, '10000 CPI 3325 Avago Sensor\r\nOmron Japanese Switches\r\n16.8 Million RGB Colours\r\nFaster Recoil\r\n6 + 2 Microable Button\r\nProgrammable RGB Lights with endless Posibility\r\nIR LED Sensor\r\nHigh Perdormance Tracking Speed : Up to 100 IPS', 'armaggeddonfalcon3gamingmouse.jpg', 4),
(64, 'Logitech G102 Gaming Mouse', 73.00, 'LIGHTSYNC RGB\r\nGaming-grade sensor\r\n6 programmable buttons\r\nOptimized Button Tensioning\r\nUSB data format: 16 bits/axis\r\nUSB report rate: 1000Hz (1ms)', 'logitechg102gamingmouse.jpg', 4),
(65, 'HP HyperX Alloy Core RGB - Gaming Keyboard', 239.00, 'Signature light bar with smooth, stylish RGB effects\n5 Zones multi-color customization option\nQuiet, responsive keys with anti-ghosting functionality\nSpill resistant keyboard with a durable frame\nKeyboard lock mode\nWith 2 Year Warranty', 'hphyperxkeyboard.jpg', 4),
(66, 'Lenovo Essential FHD Webcam', 153.90, 'The Lenovo FHD Webcam is powered by a Full HD 1080P 2 Megapixel CMOS camera that allows your friends, family, and colleagues to see you as clear as day, even when they are worlds away. With full stereo dual-mics that are perfect for conferencing or long-distance video calls, they’ll be able to hear you loud and clear, every time.', 'lenovoessentialfhdwebcam.jpg', 4),
(67, 'Logitech HD Pro Webcam C920', 266.00, 'The C920 delivers crisp Full HD video with a 1080p/30fps and 720p/30fps resolution. It has a 3-megapixel sensor, autofocus, and a full HD glass lens. With a 78° field of view and HD auto light correction, it ensures high-quality visuals. The stereo mics have a range of up to 1 meter, providing clear sound. The camera also includes a tripod-ready universal mounting clip for laptops, LCDs, or monitors.', 'logitechhdwebcamc920.jpg', 4),
(68, 'UGREEN Nylon USB C Cable Double 90', 15.00, '- 0.5 meter Rapid charge up to 100W(Fast Charging), right-angle USB C connector, data transfer speed up to 480Mbps, durable nylon braided material.', 'UGREENNylonUSBCCableDouble90.jpg', 5),
(69, 'UGREEN MFi PD 60W USB C To Lightning ', 44.00, '-1.5 meter Rapid charge up to 3A, Apple MFi certified, compatible with Lightning devices, made of soft silicone and durable high-density nylon.', 'UGREENMFiPD60WUSBCToLightning.jpg', 5),
(70, 'UGREEN Ethernet Cable CAT7', 20.00, '- 20 meter Supports bandwidth up to 600MHz, transmits data at speed up to 10Gbps, made of 4 shielded twisted pairs (STP) of copper wires.', 'UGREENEthernetCableCAT7.jpg', 5),
(71, 'CASETify Iphone 15 pro max Bounce Case MagSafe Compatible', 365.00, 'Designed for iPhone 15 Pro Max, compatible with Apple’s MagSafe charger, made from eco-conscious material, available in various colors.', 'casetifyiphone15promax.jpg', 5),
(72, 'Samsung Galaxy S24 Ultra Silicone Case', 109.00, 'Designed for Samsung Galaxy S24 Ultra, made of 100% pure copper wire and gold-plated connectors, fits snugly around your Galaxy S24 Ultra.', 'SamsungGalaxyS24UltraSiliconeCase.jpg', 5),
(73, 'Remax RP-U22 2.4A Dual USB Port Adapter', 13.00, 'Dual USB ports, supports a charging speed of 2.4 Amperes in each USB port.', 'RemaxAdapter.jpg', 5);

-- --------------------------------------------------------

--
-- Table structure for table `productcategory`
--

CREATE TABLE `productcategory` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productcategory`
--

INSERT INTO `productcategory` (`CategoryID`, `CategoryName`) VALUES
(1, 'smartphone'),
(2, 'audio'),
(3, 'PC/LAPTOP'),
(4, 'Computer Accessories'),
(5, 'Others');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `CustID` (`CustID`),
  ADD KEY `ProdID` (`ProdID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustID`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`DeliveryID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CustID` (`CustID`);

--
-- Indexes for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`OrderItemID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProdID` (`ProdID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PayID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProdID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `productcategory`
--
ALTER TABLE `productcategory`
  ADD PRIMARY KEY (`CategoryID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `DeliveryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orderitem`
--
ALTER TABLE `orderitem`
  MODIFY `OrderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProdID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `productcategory`
--
ALTER TABLE `productcategory`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`CustID`) REFERENCES `customer` (`CustID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`ProdID`) REFERENCES `product` (`ProdID`);

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`CustID`) REFERENCES `customer` (`CustID`);

--
-- Constraints for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `orderitem_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`),
  ADD CONSTRAINT `orderitem_ibfk_2` FOREIGN KEY (`ProdID`) REFERENCES `product` (`ProdID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `productcategory` (`CategoryID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
