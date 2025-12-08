-- Schema for ECAP application (inferred from code)
-- Run: mysql -u root -p < schema.sql

CREATE DATABASE IF NOT EXISTS `ECAP` CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
USE `ECAP`;

-- Categories / types
CREATE TABLE IF NOT EXISTS `itemtypes` (
  `no` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `inactive_status` TINYINT(1) NOT NULL DEFAULT 0,
  `short_discription` TEXT,
  `discription` TEXT,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Items
CREATE TABLE IF NOT EXISTS `items` (
  `no` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `short_dis` TEXT,
  `long_dis` TEXT,
  `type` INT UNSIGNED NULL,
  `inactive_status` TINYINT(1) NOT NULL DEFAULT 0,
  `content` TEXT,
  `benefits` TEXT,
  `trademark` VARCHAR(255),
  `price` DECIMAL(10,2) DEFAULT 0.00,
  `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`no`),
  KEY `idx_type` (`type`),
  CONSTRAINT `fk_items_type` FOREIGN KEY (`type`) REFERENCES `itemtypes`(`no`) ON DELETE SET NULL ON UPDATE CASCADE
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Item images
CREATE TABLE IF NOT EXISTS `itemimages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` VARCHAR(1024) NOT NULL,
  `itemno` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_itemno` (`itemno`),
  CONSTRAINT `fk_itemimages_itemno` FOREIGN KEY (`itemno`) REFERENCES `items`(`no`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Users (note: code expects to lookup by `no` column when authenticating users)
CREATE TABLE IF NOT EXISTS `users` (
  `no` VARCHAR(255) NOT NULL,
  `pass` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255),
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admin users table (used by `adm_m` model)
CREATE TABLE IF NOT EXISTS `adm_u` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `adm_e` VARCHAR(255) NOT NULL,
  `adm_p` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_adm_e` (`adm_e`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Optional sample seed data (edit passwords accordingly)
-- NOTE: Passwords must be hashed with PHP's password_hash() before inserting.

INSERT INTO `itemtypes` (`name`, `short_discription`, `discription`) VALUES
('Default', 'Default short description', 'Default full description');

INSERT INTO `items` (`name`, `short_dis`, `long_dis`, `type`, `content`, `benefits`, `trademark`, `price`) VALUES
('Sample Item', 'Short description', 'Long description', 1, 'Contents', 'Benefits', 'Brand', 1999.00);

INSERT INTO `itemimages` (`image`, `itemno`) VALUES
('./images/products/sample1.jpg', 1);

-- Admin: create using a hashed password. Example (run the PHP snippet below to generate a bcrypt hash):
-- <?php echo password_hash('your-admin-password', PASSWORD_DEFAULT); ?>
-- Then insert the result into the SQL below replacing <BCRYPT_HASH>:
-- INSERT INTO `adm_u` (`adm_e`, `adm_p`, `name`) VALUES ('admin@example.com', '<BCRYPT_HASH>', 'Site Admin');

COMMIT;
