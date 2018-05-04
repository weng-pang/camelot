CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    mobile_phone INTEGER,
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

INSERT INTO users (email, password, created, modified)
VALUES
('root@example.com', '$2y$10$g/gbftSdcZpuFYbwqYD5de4AWFuwG1pXykGo1Qc..hVZcEN/96ryG', NOW(), NOW());

INSERT INTO articles (user_id, title, slug, body, published, created, modified)
VALUES
(1, 'First Post', 'first-post', 'This is the first post.', 1, now(), now()),
(1, 'Second Post', 'second-post', 'This is the second post.', 1, now(), now()),
(1, 'Third Post', 'third-post', 'This is the third post.', 1, now(), now()),
(1, 'Fourth Post', 'fourth-post', 'This is the fourth post.', 1, now(), now()),
(1, 'Fifth Post', 'fifth-post', 'This is the fifth post.', 1, now(), now()),
(1, 'Sixth Post', 'sixth-post', 'This is the sixth post.', 1, now(), now());

