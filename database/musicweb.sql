CREATE DATABASE IF NOT EXISTS musicweb CHARACTER set utf8mb4 collate utf8mb4_general_ci;

USE musicweb;

CREATE TABLE IF NOT EXISTS `albums` (
`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `artworkPath` varchar(500) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=8 ;
--
-- Table structure for table `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=6 ;
--
-- Table structure for table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=11 ;
--
-- Table structure for table `Songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `album` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `duration` varchar(8) NOT NULL,
  `src` varchar(500) NOT NULL,
  `albumOrder` int(11) NOT NULL,
  `plays` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=32 ;
--
-- 資料表結構 `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `mID` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '會員編號',
  `mUsername` varchar(50) NOT NULL COMMENT '會員帳號',
  `mPwd` varchar(50) NOT NULL COMMENT '會員密碼',
  `mEmail` varchar(50) NOT NULL COMMENT '會員信箱',
  `mSignUpDate` date  NULL COMMENT '會員註冊日',
  `mProfilePic` varchar(50)  NULL COMMENT '會員照片',
  `mNickname` varchar(50) NOT NULL COMMENT '會員暱稱',
  `mIntro` varchar(500)  NULL COMMENT '會員介紹'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表結構 `playlists`
--

CREATE TABLE IF NOT EXISTS `playlists` (
  `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
  `name` varchar(50)  COMMENT '歌單名稱',
  `owner` varchar(50)  COMMENT '擁有者',
  `dateCreate` datetime  COMMENT '建立時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------

--
-- 資料表結構 `playlistsongs`
--

CREATE TABLE IF NOT EXISTS `playlistsongs` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `playlistId` int(11) NOT NULL,
  `songId` int(11) NOT NULL,
  `playlistOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



TRUNCATE `artists`;
TRUNCATE `albums`;
TRUNCATE `genres`;
TRUNCATE `songs`;
TRUNCATE `members`;
TRUNCATE `playlists`;
TRUNCATE `playlistsongs`;



--
-- Dumping data for table `albums`
--

INSERT INTO `albums` ( `title`, `artist`, `genre`, `artworkPath`) VALUES
( 'Bacon and Eggs', 2, 4, 'assets/images/artwork/clearday.jpg'),
( 'Pizza head', 5, 10, 'assets/images/artwork/energy.jpg'),
( 'Summer Hits', 3, 1, 'assets/images/artwork/goinghigher.jpg'),
( 'The movie soundtrack', 2, 9, 'assets/images/artwork/funkyelement.jpg'),
( 'Best of the Worst', 1, 3, 'assets/images/artwork/popdance.jpg'),
( 'Hello World', 3, 6, 'assets/images/artwork/ukulele.jpg'),
( 'Best beats', 4, 7, 'assets/images/artwork/sweet.jpg');

-- --------------------------------------------------------

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` ( `name`) VALUES
( 'Mickey Mouse'),
( 'Goofy'),
('Bart Simpson'),
( 'Homer'),
( 'Bruce Lee');

-- --------------------------------------------------------


--
-- Dumping data for table `genres`
--

INSERT INTO `genres` ( `name`) VALUES
('Rock'),
( 'Pop'),
( 'Hip-hop'),
( 'Rap'),
( 'R & B'),
( 'Classical'),
( 'Techno'),
( 'Jazz'),
( 'Folk'),
( 'Country');

-- --------------------------------------------------------


--
-- Dumping data for table `Songs`
--
INSERT INTO `songs` ( `title`, `artist`, `album`, `genre`, `duration`, `src`, `albumOrder`, `plays`) VALUES
( 'Acoustic Breeze', 1, 5, 8, '2:37', 'assets/music/bensound-acousticbreeze.mp3', 1, 0),
( 'A new beginning', 1, 5, 1, '2:35', 'assets/music/bensound-anewbeginning.mp3', 2, 0),
( 'Better Days', 1, 5, 2, '2:33', 'assets/music/bensound-betterdays.mp3', 3, 0),
( 'Buddy', 1, 5, 3, '2:02', 'assets/music/bensound-buddy.mp3', 4, 0),
( 'Clear Day', 1, 5, 4, '1:29', 'assets/music/bensound-clearday.mp3', 5, 0),
('Going Higher', 2, 1, 1, '4:04', 'assets/music/bensound-goinghigher.mp3', 1, 0),
( 'Funny Song', 2, 4, 2, '3:07', 'assets/music/bensound-funnysong.mp3', 2, 0),
('Funky Element', 2, 1, 3, '3:08', 'assets/music/bensound-funkyelement.mp3', 2, 0),
( 'Extreme Action', 2, 1, 4, '8:03', 'assets/music/bensound-extremeaction.mp3', 3, 0),
('Epic', 2, 4, 5, '2:58', 'assets/music/bensound-epic.mp3', 3, 0),
('Energy', 2, 1, 6, '2:59', 'assets/music/bensound-energy.mp3', 4, 0),
( 'Dubstep', 2, 1, 7, '2:03', 'assets/music/bensound-dubstep.mp3', 5, 0),
( 'Happiness', 3, 6, 8, '4:21', 'assets/music/bensound-happiness.mp3', 5, 0),
( 'Happy Rock', 3, 6, 9, '1:45', 'assets/music/bensound-happyrock.mp3', 4, 0),
( 'Jazzy Frenchy', 3, 6, 10, '1:44', 'assets/music/bensound-jazzyfrenchy.mp3', 3, 0),
( 'Little Idea', 3, 6, 1, '2:49', 'assets/music/bensound-littleidea.mp3', 2, 0),
( 'Memories', 3, 6, 2, '3:50', 'assets/music/bensound-memories.mp3', 1, 0),
( 'Moose', 4, 7, 1, '2:43', 'assets/music/bensound-moose.mp3', 5, 0),
('November', 4, 7, 2, '3:32', 'assets/music/bensound-november.mp3', 4, 0),
( 'Of Elias Dream', 4, 7, 3, '4:58', 'assets/music/bensound-ofeliasdream.mp3', 3, 0),
( 'Pop Dance', 4, 7, 2, '2:42', 'assets/music/bensound-popdance.mp3', 2, 0),
( 'Retro Soul', 4, 7, 5, '3:36', 'assets/music/bensound-retrosoul.mp3', 1, 0),
( 'Sad Day', 5, 2, 1, '2:28', 'assets/music/bensound-sadday.mp3', 1, 0),
( 'Sci-fi', 5, 2, 2, '4:44', 'assets/music/bensound-scifi.mp3', 2, 0),
( 'Slow Motion', 5, 2, 3, '3:26', 'assets/music/bensound-slowmotion.mp3', 3, 0),
( 'Sunny', 5, 2, 4, '2:20', 'assets/music/bensound-sunny.mp3', 4, 0),
( 'Sweet', 5, 2, 5, '5:07', 'assets/music/bensound-sweet.mp3', 5, 0),
( 'Tenderness ', 3, 3, 7, '2:03', 'assets/music/bensound-tenderness.mp3', 4, 0),
( 'The Lounge', 3, 3, 8, '4:16', 'assets/music/bensound-thelounge.mp3 ', 3, 0),
( 'Ukulele', 3, 3, 9, '2:26', 'assets/music/bensound-ukulele.mp3 ', 2, 0),
('Tomorrow', 3, 3, 1, '4:54', 'assets/music/bensound-tomorrow.mp3 ', 1, 0);



INSERT INTO `members`(`mUsername`,`mPwd`,`mEmail`,`mSignUpDate`,`mNickname`)VALUES
 ('admintest',md5('admintest'),'admintest@admin.con',NOW(),'utf8mb4 teＳＴ ❤✧😀😀　');

INSERT INTO `playlists`(`name`,`owner`,`dateCreate`)VALUES
 ('utf8mb4 teＳＴ ❤✧😀😀　','admintest',NOW()),
 ('utf8mb4 teＳＴ ❤✧😀😀❤✧😀😀　　','admintest',NOW()),
 ('utf8mb4 teＳＴ ❤✧😀😀　❤✧😀😀　❤✧😀😀　','admintest',NOW());

 INSERT INTO `playlistsongs`(`playlistId`,`songId`,`playlistOrder`)VALUES
('1','15','1'),
('1','25','2');
