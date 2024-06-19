-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2024 at 06:37 PM
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
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(4, 1, 1, 'Apple (per lb)', 2, 1, 'product_apple.png'),
(5, 1, 6, 'Tomato (per lb)', 3, 1, 'product_tomato.jpg'),
(6, 1, 5, 'Broccoli', 3, 1, 'product_broccoli.jpg'),
(7, 1, 7, 'Banana', 2, 1, 'product_banana.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 1, 'thanh', 'test01@gmail.com', '9493329583', 'Hi, this is a testing message.'),
(2, 1, 'thanh', 'test01@gmail.com', '9493348372', 'test sending message'),
(3, 1, 'thanh', 'test01@gmail.com', '9493342532', 'test again');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, 1, 'thanh', '9493329583', 'test01@gmail.com', 'Cash On Delivery', 'Westminster, CA', 'Banana x 2, Beef x 1, Cabbage x 1, Mango x 1', 18, '04/28/2024', 'Completed'),
(2, 1, 'thanh', '', 'test01@gmail.com', 'credit card', '15673 Candy Lane, Garden Grove CA - 97482, United States', ', Orange (per lb) x 3, Salmon (per lb) x 3, Apple (per lb) x 1', 50, '05/30/2024', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `details`, `price`, `image`) VALUES
(1, 'Apple (per lb)', 'fruit', 'Our Honeycrisp fresh apples are bursting with flavor and are the perfect snack for any time of day! These crisp and juicy apples have a sweet yet slightly tart taste that will leave your taste buds wanting more. They&#39;re also a great source of fiber and essential vitamins, making them a healthy snack choice. Try them today and taste the difference!\r\n+ Fresh Honeycrisp Apples, Each:\r\n   * Fresh, light green and yellow background covered with a red-orange flush and a strong hint of pink\r\n   * H', 2, 'product_apple.png'),
(2, 'Orange (per lb)', 'fruit', 'Enjoy the juicy goodness of these Large Bagged Oranges. A great source of vitamin C, these oranges can be a satisfying afternoon snack, or you can use them in a variety of recipes. For breakfast, use these oranges to make a rich and creamy smoothie or serve them alongside your pancakes, sausage, and eggs. Slice these oranges and use them to add flavor to a lunchtime salad or as a garnish for your favorite cocktail. Oranges are used in many tasty desserts like ambrosia, orange bars, and zesty ora', 5, 'product_orange.png'),
(3, 'Salmon (per lb)', 'fish', 'The Wild Caught Alaska Sockeye Salmon Portions are sure to become a family favorite. It is rich in Omega-3s, packed with 25g of protein per 4 oz. (113 g) serving, and low in calories, making it the perfect heart healthy and delicious addition to your diet. Our Wild Caught Alaska Sockeye Salmon is Marine Stewardship Council (MSC) certified, ensuring that your delicious meal is responsibly sourced. Popular for its versatility, Sockeye Salmon&#39;s unique and mild, delicate flavor goes well with a ', 11, 'product_salmon.jpg'),
(4, 'Chicken', 'meat', 'Simplify meal preparation with Foster Farms Whole Chicken. Delicious and moist white and dark meat chicken pairs with any sauce or seasoning to easily star in a variety of recipes. Perfect for smoking on the grill or roasting with your favorite marinade and pairing with most family recipes -- fast, easy, delicious dishes your family will love. Our whole bird can be prepared any way you like -- roast, fry, grill, slow cook. No matter how you cook them, they deliver irresistible flavor while offer', 7, 'product_chicken.jpg'),
(5, 'Broccoli', 'vegetables', 'Marketside Broccoli Florets are packed fresh, washed, and ready to eat for your convenience. These broccoli florets have a great fresh taste and are loaded with nutrients. They are packaged in a convenient microwave safe bag that allows you to steam them in just three minutes. Try serving with ranch dressing or hummus for a tasty and healthy snack any time of the day. Enjoy them as a wholesome side or use them in all your favorite recipes. Season them with salt, pepper, and garlic and serve with', 3, 'product_broccoli.jpg'),
(6, 'Tomato (per lb)', 'vegetables', 'Slicing Tomatoes are the leader when it comes to big, yummy, fresh tomatoes. The large size, juicy tomato taste and meaty texture make these tomatoes the perfect choice for slicing up and topping your favorite burger and sandwiches. Use them to make a hearty grilled cheese and tomato sandwich that&#39;s bursting with flavor. Slice some up and pair with fresh mozzarella, basil, and balsamic vinegar for a delicious appetizer. You can even enjoy a slice topped with a sprinkle of salt and pepper for', 3, 'product_tomato.jpg'),
(7, 'Banana', 'fruit', 'Enjoy the sweet, tropical taste of Marketside Organic Bananas. Bananas are a good source of several vitamins and minerals including potassium, vitamin B6 and vitamin C and are low in sodium. Enjoy them at breakfast, lunch, dessert, or anytime you want a healthy snack. Use them to make a loaf of moist banana bread and enjoy with a hot cup of coffee in the mornings or layer them with pudding and vanilla wafer cookies for a light, sweet banana pudding that&#39;s perfect for dessert. Simply peel ope', 2, 'product_banana.jpg'),
(8, 'Beef', 'meat', 'There&#39;s nothing like cooking from scratch, especially when you start with Beef Lean Stew Meat. Our beef stew meat is fresh, lean and tender. Our beef is an excellent source of protein, vitamin B6, vitamin B12, zinc, niacin, selenium and a good source of phosphorous, riboflavin and iron. All 9 essential nutrients are naturally found in beef and are a flavorful way to give your body nutrients to help power through the day. Great for marinating or braising, our stew meat is a delicious addition', 10, 'product_beef.png'),
(9, 'Cabbage', 'vegetables', 'Get creative in the kitchen with green cabbage. Fresh green cabbage is low in calories and high in fiber and antioxidants making it a great part of any healthy diet. Best of all, cabbage can be used for many different recipes and cuisines. Cabbage can be incorporated into everything from delicious and creamy cole slaw, wraps, egg rolls, curry, kimchi and more. Green cabbage can be roasted, boiled, braised, grilled, sauted, and even blanched. The possibilities are endless when you bring home gree', 3, 'product_cabbage.jpg'),
(10, 'Tuna', 'fish', 'The Wild Caught Tuna Steaks are sure to become a favorite. It is rich in Omega-3s and packed with 27g protein per 4 oz. (112 g) serving, making it a heart healthy and delicious addition to any diet. Ready to eat in minutes, tuna is one of the most popular seafood choices around the world. It is a very versatile seafood item, and its unique and mild, delicate flavor goes well with a wide variety of seasonings. From a simple lemon and pepper recipe to more elaborated ones like butter, dill, garlic', 9, 'product_tuna.jpg'),
(11, 'Catfish', 'fish', 'These skinless fresh never frozen tilapia fillets are farm raised BAP certified, They come in a 0.8-1.2 lb tray. Having a very mild flavor, and neutral taste allows accompanying flavors to easily infuse the delicate, flaky meat. Tilapia is also low in fat and calories and provides an excellent source of protein at 23g of protein per serving. Contains Fish (Tilapia)\r\nSkinless fillets in tray\r\nFresh never frozen\r\n23g of protein per serving\r\nBAP Certified\r\nFarm Raised\r\nContains Fish (Tilapia)', 7, 'product_catfish.jpg'),
(12, 'Pork (per lb)', 'meat', 'There&#39;s nothing like cooking from scratch, especially when you start with fresh Bone-In Pork Center Cut Loin Chops. Made with quality cuts of USDA inspected pork, our fresh pork chops are juicy, flavorful and perfect for all of your favorite spice rubs and marinades. Fresh and ready to cook, our pork is an excellent source of protein and is a delicious addition to any recipe. Simply prepare with a balsamic vinaigrette and serve with seasoned rice and steamed peas for a delicious weeknight di', 3, 'product_pork.jpg'),
(13, 'Bacon', 'meat', 'Great Value Thick Sliced Hickory Smoked Pork Bacon is cured and naturally hickory smoked for rich, savory flavor. With 6 grams of protein per serving, this thick cut bacon adds delicious flavor to pastas, club sandwiches and grilled hamburgers. This hickory smoked bacon is sliced and ready to be cooked in a skillet and served. For a savory breakfast, cook and serve with eggs and toast. Includes one 16 oz (1 lb) package of thick sliced hickory smoked bacon.\r\nOne 16 oz (1 lb) package of Great Valu', 5, 'product_bacon.jpg'),
(14, 'Watermelon', 'fruit', 'Get 25+ Seeds of the Delicious and Popular Watermelon to grow. Hand packaged and shipped by CZ Grain in Iowa. Large 30-60 pound watermelons for summer parties. Grow your own fruit', 8, 'watermelon.jpg'),
(15, 'Iceberg Lettuce', 'vegetables', 'Crisphead Iceberg Lettuce (Lactuca sativa), is also known as Crisphead lettuce. Iceberg Lettuce is the one of the most popular types of crisphead lettuce, and has been a favorite for many years. Its popularity is due to its crisp, juicy texture. While not known for its impactful flavor, iceberg lettuce has a subtle, sweet taste. It is used in salads, on sandwiches, and as a garnish. Iceberg lettuce is an annual grown in zones 4-9. They prefer cooler weather, but need sunlight to grow properly. I', 4, 'cello_lettuce__20483.jpg'),
(16, 'Mango', 'fruit', 'Savor the irresistible taste of a fresh Mango. Mangoes are an excellent fruit to add to your breakfast, lunch, dinner, or dessert. For breakfast, you can chop the mango up and add it to yogurt or a smoothie for a sweet treat that&#39;s sure to get your morning started on a high note. For dessert, you could use a mango to make a refreshing sorbet or put a tropical twist on a cobbler. You can also use it to make creamy milkshakes or delicious juices that everyone is sure to enjoy. The culinary pos', 1, 'Mango.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `image`) VALUES
(1, 'thanh', 'test01@gmail.com', '8478e2bdb758f8467225ae87ed3750c2', 'user', '465-4656553_freetoedit-bts-chibi-suga-bts-chibi-cute-suga.png'),
(2, 'Admin_Martha', 'admin01@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', '3e951f490d928662eb662b4c24dcf79a.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
