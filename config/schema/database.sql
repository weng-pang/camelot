CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    name varchar(255) NOT NULL,
    mobile_phone VARCHAR(30) DEFAULT '',
    role int(11) NOT NULL DEFAULT '0',
    created DATETIME,
    modified DATETIME
);

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(191) NOT NULL,
    body TEXT,
    published BOOLEAN DEFAULT FALSE,
    created DATETIME,
    modified DATETIME,
    archived BOOLEAN DEFAULT FALSE,
    UNIQUE KEY (slug),
    FOREIGN KEY user_key (user_id) REFERENCES users(id)
) CHARSET=utf8mb4;

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(191),
    created DATETIME,
    modified DATETIME,
    UNIQUE KEY (title)
) CHARSET=utf8mb4;

CREATE TABLE articles_tags (
    article_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (article_id, tag_id),
    FOREIGN KEY tag_key(tag_id) REFERENCES tags(id),
    FOREIGN KEY article_key(article_id) REFERENCES articles(id)
);

CREATE TABLE article_views (
  id INT AUTO_INCREMENT NOT NULL,
  user_id INT NOT NULL,
  article_id INT NOT NULL,
  created DATETIME,
  modified DATETIME,
  PRIMARY KEY (id),
  FOREIGN KEY article_view_user_key(user_id) REFERENCES users(id),
  FOREIGN KEY article_view_article_key(article_id) REFERENCES articles(id)
);

CREATE TABLE settings (
  id INT AUTO_INCREMENT NOT NULL,
  title VARCHAR(255) NOT NULL,
  subtitle VARCHAR(255),
  is_demo_site INT NOT NULL default 0,
  background_image varchar(255) NULL,
  PRIMARY KEY (id)
);

CREATE TABLE enquiries (
  id int(11) NOT NULL AUTO_INCREMENT,
  subject varchar(65) NOT NULL,
  body varchar(255) NOT NULL,
  created datetime NOT NULL,
  temp_email varchar(255) DEFAULT NULL,
  closed BOOLEAN DEFAULT FALSE,
  user_id int(11) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `products` (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(65) DEFAULT NULL,
  description text,
  image varchar(255) DEFAULT NULL,
  price decimal(10,2) NOT NULL,
  sale_price decimal(10,2) DEFAULT NULL,
  on_sale tinyint(1) NOT NULL,
  created datetime DEFAULT NULL,
  modified datetime DEFAULT NULL,
  archived tinyint(1) DEFAULT '0',
  stock int(11) NOT NULL,
  featured tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);

INSERT INTO settings (title, subtitle, background_image) VALUES (
    'Camelot',
    'A modern CMS written in CakePHP, to demonstrate various development practices for students in the Monash IE project.',
    'rufus-betty.png'
);

-- The password for this user is "root@example.com" (before being hashed).
INSERT INTO users (email, password, name, created, modified, role)
VALUES
('root@example.com', '$2y$10$g/gbftSdcZpuFYbwqYD5de4AWFuwG1pXykGo1Qc..hVZcEN/96ryG', 'Arthur', NOW(), NOW(), 3);

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `sale_price`, `on_sale`, `created`, `modified`, `archived`, `stock`, `featured`) VALUES
  (1, 'Aluminium Chestplate', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p class=\"MsoNormal\"><span style=\"font-size: 12pt; line-height: 107%; font-family: Arial, sans-serif; color: #4f5f6f; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">A chestplate is a device worn over the torso to protect it from injury, as an item of religious significance, or as an item of status. A breastplate is sometimes worn by mythological beings as a distinctive item of clothing.</span></p>\r\n</body>\r\n</html>', 'https://i.imgur.com/hia3Kca.jpg', '400.00', '300.00', 0, '2018-06-30 08:42:27', '2018-06-30 12:53:36', 0, 10, 0),
  (2, 'Steel Shortsword', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p class=\"MsoNormal\"><span style=\"font-size: 12pt; line-height: 107%; font-family: Arial, sans-serif; color: #4f5f6f; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Cold Steel&rsquo;s interpretation of this sword features a double-edged blade that is hand forged out of Carbon steel and hand polished and sharpened to perfection. The wooden handle is covered in leather and is supported by a simple, elegant guard at one end and a 5 lobed pommel at the other. The Viking Sword is supplied with a leather wrapped wooden scabbard that is reinforced with a polished steel chape and throat.</span></p>\r\n</body>\r\n</html>', 'https://i.imgur.com/PvTIUc9.jpg', '250.00', '200.00', 0, '2018-06-30 08:57:08', '2018-06-30 12:53:55', 0, 10, 0),
  (3, 'Steel Helmet', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p><span style=\"font-size: 12pt; line-height: 107%; font-family: Arial, sans-serif; color: #4f5f6f; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Polished 18 gauge mild steel with a butted ring chainmail aventail to protect the back of the neck.This&nbsp;helmet is full-size and fully wearable. It features a&nbsp;fully adjustable interior lining made from high quality 100 percent genuine leather to ensure a comfortable fit.</span><span style=\"text-align: -webkit-center;\"><span style=\"font-size: 12.0pt; line-height: 107%; font-family: \'Arial\',sans-serif; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; color: #4f5f6f; background: #F2ECE3; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA;\">&nbsp;</span></span><span style=\"text-align: -webkit-center;\"><span style=\"font-size: 12pt; line-height: 107%; font-family: Arial, sans-serif; color: #4f5f6f; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">A grooved rim encircles the helmet and the design allows for easy breathing and visibility.</span></span></p>\r\n</body>\r\n</html>', 'https://i.imgur.com/lUAj6lu.jpg', '250.00', '200.00', 0, '2018-06-30 12:37:20', '2018-06-30 12:56:17', 0, 10, 0);

