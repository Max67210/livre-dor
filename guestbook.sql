CREATE TABLE IF NOT EXISTS guestbook
(
id INT(7) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
pseudo VARCHAR(20) NOT NULL,
message TEXT NOT NULL,
note TINYINT(2) NOT NULL DEFAULT 5,
creation DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'
);