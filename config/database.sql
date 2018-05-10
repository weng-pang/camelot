CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    mobile_phone VARCHAR(30) NOT NULL DEFAULT '',
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
  PRIMARY KEY (id)
);

INSERT INTO settings (title, subtitle) VALUES ('Camelot', 'A modern CMS written in CakePHP, do demonstrate various development practices.');

-- The password for this user is "root@example.com" (before being hashed).
INSERT INTO users (email, password, created, modified)
VALUES
('root@example.com', '$2y$10$g/gbftSdcZpuFYbwqYD5de4AWFuwG1pXykGo1Qc..hVZcEN/96ryG', NOW(), NOW());

INSERT INTO articles (user_id, title, slug, body, published, created, modified)
VALUES
(1, 'Welcome to Camelot', 'welcome', 'Camelot is a custom CMS written using CakePHP. The idea is to show how various different functionality can be implemented in a modern PHP website using the CakePHP framework. Initially, it is a basic blog site, but over time it will grow as more features are added. The source code can be viewed at https://git.infotech.monash.edu/UGIE/cms.', 1, now(), now()),
(1, 'Viewing the source code of Camelot', 'viewing-source', 'As this website is built to illustrate certain coding practices, it is important to be able to check out the source code of the website. This includes not only the PHP code (Controllers, Models, etc), but also the view code (Views, Layouts). On any page, you should be able to view links to the relevant Controller, Action, View, and Template for that page. This is true both for the public website, and also the administrator dashaboard. In addition to this, the entire source code is available at https://git.infotech.monash.edu/UGIE/cms.', 1, now(), now()),
(1, 'Logging in to the Admin Dashboard', 'admin-dashboard', 'Anyone can log into the administrator dashboard for this website. This site is currently configured to be in "demo mode", a mode I invented which allows anyone to log in and play around with the administrator dashboard. To do this, click the "Login" button in the top right of any page. As it is in demo mode, it is already prefilled with a username + password that you can use to log in. Any content you add will periodically get deleted as the website database is cleared and reinstalled.', 1, now(), now()),
(1, 'Fourth Post', 'fourth-post', 'This is the fourth post.', 1, now(), now()),
(1, 'Fifth Post', 'fifth-post', 'This is the fifth post.', 1, now(), now()),
(1, 'Sixth Post', 'sixth-post', 'This is the sixth post.', 1, now(), now());

-- Insert some dummy data about people viewing articles, so that we can see appropriate charts in the admin dashboard,
-- and it will also be able to show the most popular articles.
INSERT INTO article_views (user_id, article_id, created, modified)
VALUES
(1, 1, now(), now()),
(1, 1, now() - INTERVAL 1 DAY, now()),
(1, 1, now() - INTERVAL 1 DAY, now()),
(1, 1, now() - INTERVAL 2 DAY, now()),
(1, 1, now() - INTERVAL 2 DAY, now()),
(1, 2, now() - INTERVAL 2 DAY, now()),
(1, 2, now() - INTERVAL 4 DAY, now()),
(1, 2, now() - INTERVAL 4 DAY, now()),
(1, 2, now() - INTERVAL 4 DAY, now()),
(1, 2, now() - INTERVAL 4 DAY, now()),
(1, 2, now() - INTERVAL 4 DAY, now()),
(1, 2, now() - INTERVAL 5 DAY, now()),
(1, 2, now() - INTERVAL 5 DAY, now()),
(1, 2, now() - INTERVAL 5 DAY, now()),
(1, 2, now(), now()),
(1, 3, now(), now()),
(1, 3, now() - INTERVAL 1 DAY, now()),
(1, 3, now() - INTERVAL 6 DAY, now()),
(1, 3, now() - INTERVAL 6 DAY, now()),
(1, 3, now() - INTERVAL 6 DAY, now()),
(1, 3, now() - INTERVAL 6 DAY, now()),
(1, 3, now() - INTERVAL 6 DAY, now()),
(1, 3, now() - INTERVAL 10 DAY, now()),
(1, 3, now() - INTERVAL 10 DAY, now()),
(1, 3, now() - INTERVAL 10 DAY, now()),
(1, 3, now() - INTERVAL 10 DAY, now());