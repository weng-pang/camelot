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
  user_id int(11) DEFAULT NULL,
  PRIMARY KEY (id)
);

INSERT INTO settings (title, subtitle, background_image) VALUES (
    'Camelot',
    'A modern CMS written in CakePHP, to demonstrate various development practices for students in the Monash IE project.',
    'rufus-betty.png'
);

-- The password for this user is "root@example.com" (before being hashed).
INSERT INTO users (email, password, name, created, modified)
VALUES
('root@example.com', '$2y$10$g/gbftSdcZpuFYbwqYD5de4AWFuwG1pXykGo1Qc..hVZcEN/96ryG', 'Arthur', NOW(), NOW());
