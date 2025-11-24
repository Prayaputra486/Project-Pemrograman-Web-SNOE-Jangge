-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Nov 2025 pada 14.39
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `snoe_jangge`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `blog`
--

CREATE TABLE `blog` (
  `id_blog` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `excerpt` varchar(500) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `penulis` varchar(100) DEFAULT 'SNÖE Jangge Team',
  `status` enum('published','draft') DEFAULT 'published',
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `blog`
--

INSERT INTO `blog` (`id_blog`, `judul`, `isi`, `excerpt`, `gambar`, `penulis`, `status`, `tanggal`) VALUES
(1, 'James Bond in Sölden - THE HOTTEST WINTER OF ALL TIME', 'James Bond discovered SNÖE Jangge on the Gaislachkogl mountain peak as an exclusive filming location in Tyrol. In January and February 2015 Daniel Craig alias James Bond and five hundred of his colleagues and film crew came to Sölden – the hotspot of the Alps. And it is little wonder – barely anywhere else is there a more spectacular venue.\r\n\r\nThe abundant snow and the glacier tunnel provided a noteworthy setting for the action-packed pursuits. This is something director Sam Mendes was aware of – and the valley of the three-thousand metre mountains, as Ötztal is often called, without further ado, became the backdrop for key and speedy action scenes in the blockbuster. The gourmet restaurant SNÖE Jangge at 3,048 metres altitude was not only significant as a luxurious dining area for the actor. The futuristic architecture also had a key role to play in the film – but not as a gourmet restaurant, but as a futuristic clinic, where Bond’s opposite Christoph Waltz got up to evil doings.\r\n\r\nAt more than 3,000 m above sea level, right next to our gourmet restaurant ice Q, James Bond fans can immerse themselves into the world of 007. Go on a tour through the various galleries dedicated to British secret agent ‘James Bond’. The new cinematic installation 007 ELEMENTS puts the focus primarily on SPECTRE and the scenes shot in Sölden, but also touches upon other chapters of the 24 James Bond movies.', 'James Bond’s movie Spectre was filmed at the stunning Gaislachkogl peak in Sölden, featuring SNÖE Jangge gourmet restaurant as a key location. The futuristic building, transformed into a high-tech clinic in the film, sits at 3,048 meters above sea level and offers breathtaking alpine views. Visitors can now explore 007 ELEMENTS, a cinematic exhibition showcasing scenes from Spectre and the legacy of James Bond in Tyrol.', 'https://www.iceq.at/mediatypes/headerImage/12._briefing_room_1.jpg', 'SNÖE Jangge Team - Praya Putra', 'published', '2025-11-13 07:31:24'),
(2, 'Where Snow Meets Soul: The Story Behind SNÖE Jangge', 'The Origin of an Idea\r\nThe story of SNÖE Jangge began with a vision to create a space where tranquility and taste coexist in perfect balance. Founded on the belief that dining should be a sensory journey, the restaurant embodies the philosophy of refined simplicity inspired by the Nordic winter. Every design element, from the soft lighting to the minimalist interior, reflects purity, peace, and understated sophistication.\r\n\r\nThe Architecture of Emotion\r\nStep inside SNÖE Jangge, and you’re transported into a world sculpted by snow and serenity. The interiors embrace a palette of ivory, beige, and frost-gray tones, enhanced by glass reflections and candlelight glow. Each table is thoughtfully arranged to provide intimacy and connection whether for a quiet dinner for two or a celebration among friends.\r\n\r\nThe Soul of the Experience\r\nWhat makes SNÖE Jangge truly unique lies not only in its food but in the emotions it evokes. It’s a place where conversations flow naturally, where laughter meets the clinking of crystal glasses, and where every dish feels personal. Our culinary philosophy emphasizes harmony between local and international ingredients, tradition and innovation, elegance and warmth.\r\n\r\nA Winter Dream, Reimagined\r\nSNÖE Jangge is not just a restaurant it’s a sanctuary for the senses. It’s a reminder that beauty can be found in stillness, that flavor can be poetry, and that even the coldest winter night can feel alive with warmth.', 'Inspired by the calm of winter and the allure of timeless elegance, SNÖE Jangge was born to redefine the meaning of fine dining through art, emotion, and atmosphere.', 'https://www.oetztal.com/cache-buster-0/infrastruktur/solden/ice-q-gourmetrestaurant-auf-3.048-m/117839/image-thumb__117839__nuiLightboxImage/aussen-edc7abab.ceedd067.jpg', 'SNÖE Jangge Team', 'published', '2025-11-13 07:31:24'),
(3, 'Beyond the Plate: The Art of Pairing at SNÖE Jangge', 'The Philosophy of Pairing\r\nAt SNÖE Jangge, we believe that wine is more than a complement to food — it is an extension of the dining narrative. Every bottle, every pour, and every sip is selected with intent, curated to elevate the essence of the cuisine it accompanies.\r\n\r\nCurated Harmony\r\nOur sommeliers have traveled through renowned vineyards across France, Italy, and New Zealand to bring the finest selection to your table. From the bold, silky body of Château Margaux 2015 that enriches our Venison Filet Royale, to the refreshing crispness of Cloudy Bay Sauvignon Blanc that highlights the delicacy of our Arctic Halibut — each pairing is a dance of contrasts and complements.\r\n\r\nThe Signature Experience\r\nGuests seeking a full immersion can explore our House Wine Pairing, a three-glass curated flight that embodies the philosophy of balance, warmth, and refinement. Each pairing is designed to unfold gradually — starting with subtle notes of citrus, moving into the depth of dark berries, and ending with a hint of sweetness that lingers like a winter memory.\r\n\r\nAt SNÖE Jangge, pairing is not just about matching flavors — it’s about crafting moments that resonate.', 'Discover the refined harmony between food and wine where each pairing at SNÖE Jangge enhances every flavor note in perfect balance.', 'https://www.iceq.at/mediatypes/headerImage/iceq_soelden_by_rudi_wyhlidal-0478_1.jpg', 'SNÖE Jangge Team', 'published', '2025-11-13 07:31:24'),
(4, 'Journey to SNÖE Jangge: A Fine Dining Experience Above the Clouds', 'Reaching SNÖE Jangge is an experience as remarkable as the dining itself. Situated at 3,048 meters above sea level on the Gaislachkogl Mountain, the journey begins with a panoramic gondola ride that offers stunning views of the Ötztal Alps. As the cabin ascends through layers of mist and snow-covered slopes, guests are treated to a visual symphony of white peaks and blue horizons.\r\n\r\nOnce at the top, SNÖE Jangge welcomes visitors with its futuristic glass architecture, reflecting the surrounding mountains like a crystal palace. The restaurant’s ambiance combines modern alpine elegance with world-class culinary artistry, creating an experience that transcends traditional fine dining.\r\n\r\nThe gondola ride itself symbolizes the essence of SNÖE Jangge a seamless blend of adventure, sophistication, and exclusivity. It’s not just about reaching a destination; it’s about savoring the journey, from the first step into the cable car to the final sip of champagne overlooking the clouds.\r\n\r\nWhether you\'re visiting for a romantic getaway, a cinematic experience, or simply a desire to dine above the world, SNÖE Jangge promises an unforgettable ascent into elegance.', 'To reach SNÖE Jangge at 3,048 meters above sea level, guests must embark on a breathtaking gondola ride to the Gaislachkogl peak where luxury dining meets the sky.', 'https://www.trendsplustravel.com/blog/wp-content/uploads/2017/07/live-like-james-bond-das-central-solden-10-800x533.jpg', 'SNÖE Jangge Team', 'published', '2025-11-13 09:33:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_menu`
--

CREATE TABLE `kategori_menu` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_menu`
--

INSERT INTO `kategori_menu` (`id_kategori`, `nama_kategori`, `deskripsi`, `status`) VALUES
(101, 'Main Course', 'Exquisite entrées of Wagyu, salmon, and seasonal specialties showcasing the art of winter fine dining.', 'aktif'),
(102, 'Appetizer', 'Refined starters to begin your culinary journey featuring delicate seafood, truffle bites, and light creations to awaken the senses.', 'aktif'),
(103, 'Dessert', 'Luxurious sweet finales from chocolate spheres to frozen berry mousse, crafted for elegant indulgence.', 'aktif'),
(104, 'Side Dishes', 'Perfect complements to your main dish including truffle mashed potatoes, roasted vegetables, and chef’s signature seasonal selections.', 'aktif'),
(105, 'Soup & Salad', 'A refreshing balance of warmth and crispness featuring creamy soups, winter greens, and light flavors for refined harmony.', 'aktif'),
(201, 'Drinks', 'Handcrafted cocktails and mocktails inspired by the snowy ambiance each sip blending creativity, elegance, and a touch of Arctic chill.', 'aktif'),
(202, 'Hot Drinks', 'A comforting collection of gourmet coffees, teas, and signature hot chocolates that bring warmth to the snowy ambiance.', 'aktif'),
(203, 'Wine', 'A curated wine selection from world-renowned vineyards perfectly paired to enhance the flavor of every course.', 'aktif'),
(301, 'Set Menu', 'Set menu by Snoe Jangge for 1 person.', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `meja`
--

CREATE TABLE `meja` (
  `id_meja` int(11) NOT NULL,
  `nama_meja` varchar(50) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `lokasi` enum('indoor','outdoor') NOT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `meja`
--

INSERT INTO `meja` (`id_meja`, `nama_meja`, `kapasitas`, `lokasi`, `catatan`) VALUES
(1201, 'Table 1 - Crystal', 2, 'indoor', 'By the window with natural lighting, perfect for a couple.'),
(1202, 'Table 2 - Crystal', 2, 'indoor', 'By the window with natural lighting, perfect for a couple.'),
(1203, 'Table 3 - Crystal', 2, 'indoor', 'By the window with natural lighting, perfect for a couple.'),
(1204, 'Table 4 - Crystal', 2, 'indoor', 'By the window with natural lighting, perfect for a couple.'),
(1205, 'Table 5 - Crystal', 2, 'indoor', 'By the window with natural lighting, perfect for a couple.'),
(1206, 'Table 6 - Crystal', 2, 'indoor', 'By the window with natural lighting, perfect for a couple.'),
(1207, 'Table 7 - Crystal', 2, 'indoor', 'By the window with natural lighting, perfect for a couple.'),
(2401, 'Table 1 - Classic Corner', 4, 'indoor', 'Near the brick wall, gives a warm vintage vibe.'),
(2402, 'Table 2 - Classic Corner', 4, 'indoor', 'Near the brick wall, gives a warm vintage vibe.'),
(2403, 'Table 3 - Classic Corner', 4, 'indoor', 'Near the brick wall, gives a warm vintage vibe.'),
(2404, 'Table 4 - Classic Corner', 4, 'indoor', 'Near the brick wall, gives a warm vintage vibe.'),
(3201, 'Table 1 - Garden View', 2, 'outdoor', 'Overlooking the garden, ideal for a dinner.'),
(3202, 'Table 2 - Garden View', 2, 'outdoor', 'Overlooking the garden, ideal for a dinner.'),
(3203, 'Table 3 - Garden View', 2, 'outdoor', 'Overlooking the garden, ideal for a dinner.'),
(3405, 'Table 5 - Classic Corner', 4, 'indoor', 'Near the brick wall, gives a warm vintage vibe.'),
(4401, 'Table 1 - Terrace', 4, 'outdoor', 'Outdoor covered area, cozy during the evening.'),
(4402, 'Table 2 - Terrace', 4, 'outdoor', 'Outdoor covered area, cozy during the evening.'),
(4403, 'Table 3 - Terrace', 4, 'outdoor', 'Outdoor covered area, cozy during the evening.'),
(4404, 'Table 4 - Terrace', 4, 'outdoor', 'Outdoor covered area, cozy during the evening.'),
(4405, 'Table 5 - Terrace', 4, 'outdoor', 'Outdoor covered area, cozy during the evening.'),
(5201, 'Table 1 - Candlelight', 2, 'outdoor', 'Soft breeze, relaxing outdoor vibe.'),
(5202, 'Table 2 - Candlelight', 2, 'outdoor', 'Soft breeze, relaxing outdoor vibe.'),
(5203, 'Table 3 - Candlelight', 2, 'outdoor', 'Soft breeze, relaxing outdoor vibe.'),
(5204, 'Table 4 - Candlelight', 2, 'outdoor', 'Soft breeze, relaxing outdoor vibe.'),
(5205, 'Table 5 - Candlelight', 2, 'outdoor', 'Soft breeze, relaxing outdoor vibe.'),
(6801, 'Table 1 - Harmony', 8, 'indoor', 'Spacious table suitable for small gatherings or families.'),
(6802, 'Table 2 - Harmony', 8, 'indoor', 'Spacious table suitable for small gatherings or families.'),
(7201, 'Table 1 - Chef’s Spot', 2, 'indoor', 'Located near the open kitchen, for interactive experience.'),
(7202, 'Table 2 - Chef’s Spot', 2, 'indoor', 'Located near the open kitchen, for interactive experience.'),
(7203, 'Table 3 - Chef’s Spot', 2, 'indoor', 'Located near the open kitchen, for interactive experience.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_euro` decimal(10,2) NOT NULL,
  `harga_dollar` decimal(10,2) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `id_kategori`, `nama_menu`, `deskripsi`, `harga_euro`, `harga_dollar`, `foto`, `status`) VALUES
(1, 101, 'Wagyu Tenderloin 9+', 'Served with truffle jus, potato fondant, and winter asparagus.', '85.00', '92.00', '-', 'aktif'),
(2, 101, 'Duck Breast à l’Orange', 'Glazed with orange reduction and star anise.', '68.00', '74.00', '-', 'aktif'),
(3, 101, 'Grilled Arctic Halibut', 'Lemon butter sauce and fennel confit.', '70.00', '77.00', '-', 'aktif'),
(4, 101, 'Snow Crab Risotto', 'Creamy saffron risotto topped with Alaskan crab.', '72.00', '79.00', '-', 'aktif'),
(5, 101, 'Venison Filet Royale', 'Grilled venison with juniper berry sauce.', '105.00', '114.00', '-', 'aktif'),
(6, 101, 'Arctic Lamb Rack', 'Roasted lamb rack with rosemary snow glaze.', '95.00', '103.00', '-', 'aktif'),
(7, 101, 'Glacial Salmon Fillet', 'Pan seared Norwegian salmon with lemon butter and dill.', '80.00', '87.00', '-', 'aktif'),
(8, 102, 'Nordic Oysters Royale', 'Fresh Norwegian oysters served with champagne mignonette and sea salt pearls.', '45.00', '49.00', '-', 'aktif'),
(9, 102, 'Truffle Arancini Snowball', 'Parmesan and truffle rice balls dusted with edible snow.', '38.00', '42.00', '-', 'aktif'),
(10, 102, 'Smoked Duck Breast', 'Thinly sliced smoked duck with winter berry glaze.', '40.00', '44.00', '-', 'aktif'),
(11, 102, 'Caviar on Ice', 'Premium beluga caviar served over frozen marble.', '120.00', '130.00', '-', 'aktif'),
(12, 102, 'Scallop Aurora', 'Pan-seared scallops with citrus foam and snow dust.', '48.00', '52.00', '-', 'aktif'),
(13, 102, 'White Asparagus Soup', 'Creamy soup with poached egg and truffle oil.', '35.00', '39.00', '-', 'aktif'),
(14, 102, 'Reindeer Carpaccio', 'Sliced venison carpaccio with cranberry drizzle.', '55.00', '60.00', '-', 'aktif'),
(15, 103, 'Snow Dome Mousse', 'White chocolate mousse shaped like a snow globe.', '38.00', '42.00', '-', 'aktif'),
(16, 103, 'Arctic Berry Tart', 'Tart with frozen berries and vanilla cream.', '35.00', '39.00', '-', 'aktif'),
(17, 103, 'Winter Forest Cake', 'Dark chocolate cake with mint cream snow.', '42.00', '46.00', '-', 'aktif'),
(18, 103, 'Iced Soufflé', 'Lemon soufflé topped with powdered sugar frost.', '40.00', '44.00', '-', 'aktif'),
(19, 103, 'Vanilla Bean Panna Cotta', 'Served with caramel snowflakes.', '37.00', '41.00', '-', 'aktif'),
(20, 103, 'Frosted Tiramisu', 'Espresso tiramisu with frozen mascarpone topping.', '39.00', '43.00', '-', 'aktif'),
(21, 103, 'Crystal Cheesecake', 'Blueberry cheesecake with crystalized sugar shards.', '41.00', '45.00', '-', 'aktif'),
(22, 104, 'Truffle Mashed Potato', 'Creamy potato with truffle oil.', '18.00', '20.00', '-', 'aktif'),
(23, 104, 'Grilled Asparagus', 'With garlic butter and salt flakes.', '16.00', '18.00', '-', 'aktif'),
(24, 104, 'Parmesan Fries', 'Hand-cut fries with aged parmesan.', '15.00', '16.00', '-', 'aktif'),
(25, 104, 'Roasted Winter Vegetables', 'Carrots, parsnip, and rosemary glaze.', '17.00', '19.00', '-', 'aktif'),
(26, 104, 'Saffron Rice', 'Golden rice with aromatic herbs.', '14.00', '15.00', '-', 'aktif'),
(27, 104, 'Caesar Salad', 'With anchovy dressing and parmesan crisp.', '18.00', '20.00', '-', 'aktif'),
(28, 104, 'Garlic Butter Bread', 'Baked daily with herb butter.', '12.00', '13.00', '-', 'aktif'),
(29, 105, 'Winter Truffle Soup', 'Creamy mushroom soup with truffle dust.', '30.00', '33.00', '-', 'aktif'),
(30, 105, 'Snow Caesar Salad', 'Romaine lettuce, parmesan snow, anchovy dressing.', '25.00', '27.00', '-', 'aktif'),
(31, 105, 'Arctic Lobster Bisque', 'Rich lobster soup with cream and cognac.', '40.00', '44.00', '-', 'aktif'),
(32, 105, 'Nordic Beet Salad', 'Beets, goat cheese, and honey glaze.', '28.00', '31.00', '-', 'aktif'),
(33, 105, 'Frozen Tomato Consommé', 'Chilled tomato soup served over ice.', '26.00', '29.00', '-', 'aktif'),
(34, 105, 'Crystal Green Salad', 'Mixed greens with snow dressing and citrus zest.', '24.00', '27.00', '-', 'aktif'),
(35, 105, 'Caviar Chowder', 'Potato and leek chowder topped with caviar.', '45.00', '49.00', '-', 'aktif'),
(36, 201, 'Winter Whisper', 'Vodka, coconut cream, and white chocolate.', '22.00', '24.00', '-', 'aktif'),
(37, 201, 'Arctic Martini', 'Dry gin with elderflower essence.', '20.00', '22.00', '-', 'aktif'),
(38, 201, 'Snow Bloom', 'Sparkling sake and jasmine syrup.', '21.00', '23.00', '-', 'aktif'),
(39, 201, 'Golden Frost', 'Champagne with honey and lemon zest.', '26.00', '29.00', '-', 'aktif'),
(40, 201, 'Northern Negroni', 'Spiced gin, vermouth, and orange peel.', '23.00', '25.00', '-', 'aktif'),
(41, 201, 'Iceberry Mule', 'Vodka, ginger beer, and cranberry.', '19.00', '21.00', '-', 'aktif'),
(42, 201, 'SNÖE Signature Espresso', 'Espresso, Kahlúa, and vanilla foam.', '24.00', '26.00', '-', 'aktif'),
(43, 202, 'Classic Cappuccino', 'Italian espresso with steamed milk foam.', '12.00', '13.00', '-', 'aktif'),
(44, 202, 'Winter Spice Latte', 'Cinnamon, nutmeg, and espresso fusion.', '13.00', '14.00', '-', 'aktif'),
(45, 202, 'Hot Chocolate Deluxe', 'Dark cocoa with whipped cream snow.', '14.00', '15.00', '-', 'aktif'),
(46, 202, 'Earl Grey Royal Tea', 'Served with honey and lemon zest.', '10.00', '11.00', '-', 'aktif'),
(47, 202, 'Peppermint Mocha', 'Espresso, chocolate, and mint cream.', '13.00', '14.00', '-', 'aktif'),
(48, 202, 'Vanilla Flat White', 'Smooth espresso blend with vanilla hint.', '11.00', '12.00', '-', 'aktif'),
(49, 202, 'Matcha Snow Latte', 'Japanese matcha with frosted milk.', '15.00', '16.00', '-', 'aktif'),
(50, 203, 'Château Margaux 2015', 'Bordeaux red, bold and silky.', '320.00', '350.00', '-', 'aktif'),
(51, 203, 'Dom Pérignon Vintage', 'Champagne with floral finish.', '280.00', '310.00', '-', 'aktif'),
(52, 203, 'Cloudy Bay Sauvignon', 'Crisp white wine from New Zealand.', '95.00', '105.00', '-', 'aktif'),
(53, 203, 'Penfolds Shiraz', 'Full-bodied red with spice.', '110.00', '120.00', '-', 'aktif'),
(54, 203, 'Whispering Angel Rosé', 'Elegant rosé with peach aroma.', '88.00', '98.00', '-', 'aktif'),
(55, 203, 'Ice Wine Niagara', 'Sweet dessert wine, chilled.', '130.00', '145.00', '-', 'aktif'),
(56, 203, 'House Wine Pairing', 'Chef’s curated 3-glass experience.', '75.00', '82.00', '-', 'aktif'),
(1101, 301, 'The Summit Signature', 'Snow Crab Tartlet(Fresh Alaskan crab with caviar and citrus essence),Foie Gras Snowflake(Pan-seared foie gras with berry and ice glaze),Norwegian Salmon Crustée(Seared salmon with herb crust and lemon sauce),Wagyu Tenderloin 9+(Paired with truffle grill asparagus and black garlic),Midnight Chocolate Sphere(Molten dark chocolate filled with vanilla cream)', '195.00', '225.00', '-', 'aktif'),
(1102, 301, 'The Frosted Garden', 'Beetroot Carpaccio(Drizzled with honey lemon and goat cheese snow),Truffle Soup(Creamy celery root with shaved black truffle),Grilled Zucchini Terrine(Layered with ricotta and herbs),Wild Mushroom Risotto(With white truffle oil and aged parmesan),Winter Apple Tart(Baked with cinnamon ice cream and caramel)', '173.00', '200.00', '-', 'aktif'),
(1103, 301, 'The Glacier Experience', 'Caviar de Neige(Siberian caviar with sour cream and chive oil),Lobster Bisque(Rich and velvety with cognac cream),Black Cod Miso(Glazed and baked with snow pea purée),A5 Wagyu Striploin(Accompanied by potato fondant and red wine jus),Golden Snow Soufflé(Light vanilla soufflé dusted with edible gold)', '260.00', '300.00', '-', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasi`
--

CREATE TABLE `reservasi` (
  `id_reservasi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_meja` int(11) NOT NULL,
  `tanggal_reservasi` date NOT NULL,
  `waktu_reservasi` time NOT NULL,
  `jumlah_orang` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `total_euro` decimal(10,2) NOT NULL,
  `total_dollar` decimal(10,2) NOT NULL,
  `status` enum('Scheduled','Confirmed','Completed','Cancelled') DEFAULT 'Scheduled',
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reservasi`
--

INSERT INTO `reservasi` (`id_reservasi`, `id_user`, `id_meja`, `tanggal_reservasi`, `waktu_reservasi`, `jumlah_orang`, `catatan`, `total_euro`, `total_dollar`, `status`, `tanggal_dibuat`) VALUES
(5, 1, 5201, '2025-11-13', '09:00:00', 1, 'Romantic Dinner', '1443.00', '1620.00', 'Confirmed', '2025-11-11 12:29:48'),
(6, 1, 5203, '2025-11-14', '09:00:00', 2, 'Romantic Dinner', '457.00', '526.00', 'Scheduled', '2025-11-11 13:04:34'),
(7, 1, 5203, '2025-11-14', '09:00:00', 1, '', '390.00', '445.00', 'Scheduled', '2025-11-12 06:40:25'),
(8, 1, 5202, '2025-11-15', '09:00:00', 1, 'nothing', '606.00', '700.00', 'Scheduled', '2025-11-13 09:57:31'),
(9, 1, 1206, '2025-11-21', '09:00:00', 1, '-', '455.00', '525.00', 'Scheduled', '2025-11-13 10:06:39'),
(10, 1, 1207, '2025-11-15', '09:00:00', 1, '', '520.00', '600.00', 'Scheduled', '2025-11-13 10:13:47'),
(11, 1, 5202, '2025-11-17', '09:00:00', 2, 'Romantic Dinner', '829.00', '941.00', 'Scheduled', '2025-11-13 12:34:04'),
(12, 1, 3203, '2025-12-20', '17:45:00', 2, '', '979.00', '1116.00', 'Scheduled', '2025-11-13 13:10:44'),
(13, 1, 7202, '2025-12-30', '17:45:00', 2, '', '537.00', '613.00', 'Scheduled', '2025-11-13 13:39:10'),
(18, 1, 7202, '2025-12-25', '09:00:00', 2, 'Dinner', '520.00', '600.00', 'Confirmed', '2025-11-13 15:47:44'),
(20, 5, 5203, '2025-12-25', '09:00:00', 2, '', '625.00', '715.00', 'Scheduled', '2025-11-15 13:03:35'),
(21, 6, 5201, '2025-12-25', '16:00:00', 2, 'Nothing', '632.00', '724.00', 'Confirmed', '2025-11-16 02:13:17'),
(22, 7, 3201, '2025-12-25', '16:00:00', 2, 'Romantic Dinner', '560.00', '634.00', 'Confirmed', '2025-11-16 13:14:28'),
(24, 9, 5202, '2025-12-20', '17:45:00', 2, 'Dinner', '639.00', '731.00', 'Confirmed', '2025-11-17 15:01:29'),
(25, 9, 1206, '2025-12-20', '16:00:00', 2, 'For Romantic Dinner', '520.00', '600.00', 'Confirmed', '2025-11-24 01:37:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasi_menu`
--

CREATE TABLE `reservasi_menu` (
  `id_reservasi_menu` int(11) NOT NULL,
  `id_reservasi` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 1,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reservasi_menu`
--

INSERT INTO `reservasi_menu` (`id_reservasi_menu`, `id_reservasi`, `id_menu`, `jumlah`, `catatan`) VALUES
(11, 5, 1102, 1, ''),
(12, 5, 1103, 2, ''),
(13, 5, 50, 2, ''),
(14, 5, 53, 1, ''),
(15, 6, 43, 2, ''),
(16, 6, 1102, 1, ''),
(17, 6, 1103, 1, ''),
(18, 7, 1103, 1, ''),
(19, 7, 55, 1, ''),
(20, 8, 1102, 2, ''),
(21, 8, 1103, 1, ''),
(22, 9, 1103, 1, ''),
(23, 9, 1101, 1, ''),
(24, 10, 1103, 2, ''),
(25, 11, 16, 2, NULL),
(26, 11, 37, 2, NULL),
(27, 11, 39, 1, NULL),
(28, 11, 1102, 1, NULL),
(29, 11, 1103, 1, NULL),
(30, 11, 55, 2, NULL),
(31, 12, 43, 2, NULL),
(32, 12, 1103, 2, NULL),
(33, 12, 1101, 1, NULL),
(34, 12, 55, 1, NULL),
(35, 12, 53, 1, NULL),
(36, 13, 39, 2, NULL),
(37, 13, 1101, 2, NULL),
(38, 13, 52, 1, NULL),
(43, 18, 1103, 2, NULL),
(47, 20, 21, 2, NULL),
(48, 20, 40, 1, NULL),
(49, 20, 1103, 2, NULL),
(50, 21, 43, 2, NULL),
(51, 21, 1103, 2, NULL),
(52, 21, 54, 1, NULL),
(53, 22, 37, 2, NULL),
(54, 22, 1103, 1, NULL),
(55, 22, 55, 2, NULL),
(60, 24, 21, 1, NULL),
(61, 24, 15, 1, NULL),
(62, 24, 37, 2, NULL),
(63, 24, 1103, 2, NULL),
(64, 25, 1103, 2, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `email`, `password`, `no_telp`, `role`) VALUES
(1, 'Praya Putra Wibowo', 'utraaw', 'bowopraya@gmail.com', '$2y$10$lE.UlfOfIB/JREy94K7SPuEfc/JU5gcoxN/XRlWCkXT9S5RabiVw6', '08889317261', 'user'),
(2, 'Praya Putra Wibowo', 'praya', 'prayaputra48@gmail.com', '$2y$10$lE.UlfOfIB/JREy94K7SPuEfc/JU5gcoxN/XRlWCkXT9S5RabiVw6', '08889317261', 'admin'),
(3, 'Raisha Syifa', 'raisha', 'raishasyifa@gmail.com', '$2y$10$lE.UlfOfIB/JREy94K7SPuEfc/JU5gcoxN/XRlWCkXT9S5RabiVw6', '08889317261', 'user'),
(5, 'Ria Irawati', 'Ria Irawati', 'jahitrumah01@gmail.com', '$2y$10$vfyVHSP8RxU0NrjSuFEkRO1lNsgquAxRcjkg6.nWLoDh5HgDcMN7i', '082125825876', 'user'),
(6, 'Alfian Rifky Putra Wibowo', 'Alfian', 'ptrprythrift@gmail.com', '$2y$10$fLhB19fVk14iMvkJrFDu5uChSis55f3elh3J8e3LItp.XXRL18dPG', '08889317261', 'user'),
(7, 'Moch Fachriel Adjie', 'Fachriel', 'fachrieladjie@gmail.com', '$2y$10$6CMKbBtC83ymDRAouGv6jet0oToCp9E5n2gtky6nCKeE.xzzl47uK', '08889317261', 'user'),
(9, 'Putra Wibowo', 'wibowo', 'primdernco@gmail.com', '$2y$10$XinSSJlihJXW2ctdNhDyt.bm8uNAHX.1Ev5hXLRDQkCfFzxLxKKuC', '08889317261', 'user'),
(10, 'Noven Bugijangge', 'Noven', 'yoanoven@gmail.com', '$2y$10$RIw2IoQlscu4isFuB..6FurMHGJpHxC.k1NRQQZvYCX/P.bcCznVi', '0082137054964', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id_blog`);

--
-- Indeks untuk tabel `kategori_menu`
--
ALTER TABLE `kategori_menu`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`id_meja`),
  ADD UNIQUE KEY `nama_meja` (`nama_meja`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `fk_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD KEY `fk_user` (`id_user`),
  ADD KEY `fk_meja` (`id_meja`);

--
-- Indeks untuk tabel `reservasi_menu`
--
ALTER TABLE `reservasi_menu`
  ADD PRIMARY KEY (`id_reservasi_menu`),
  ADD KEY `id_reservasi` (`id_reservasi`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `blog`
--
ALTER TABLE `blog`
  MODIFY `id_blog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kategori_menu`
--
ALTER TABLE `kategori_menu`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT untuk tabel `meja`
--
ALTER TABLE `meja`
  MODIFY `id_meja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7204;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1104;

--
-- AUTO_INCREMENT untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id_reservasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `reservasi_menu`
--
ALTER TABLE `reservasi_menu`
  MODIFY `id_reservasi_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_menu` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `fk_meja` FOREIGN KEY (`id_meja`) REFERENCES `meja` (`id_meja`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservasi_menu`
--
ALTER TABLE `reservasi_menu`
  ADD CONSTRAINT `reservasi_menu_ibfk_1` FOREIGN KEY (`id_reservasi`) REFERENCES `reservasi` (`id_reservasi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservasi_menu_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
