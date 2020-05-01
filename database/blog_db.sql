CREATE TABLE IF NOT EXISTS `user` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(32) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `registered` DATETIME NOT NULL,
  `is_admin` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX (`email`),
  UNIQUE INDEX (`user_name`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT DEFAULT NULL,
  `title` VARCHAR(45) NOT NULL,
  `header` TEXT NULL DEFAULT NULL,
  `content` TEXT NULL DEFAULT NULL,
  `publish` DATETIME NULL DEFAULT NULL,
  `updated` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  INDEX (`user_id`),
  FOREIGN KEY (`user_id`)
    REFERENCES  `user`(`user_id`)
    ON DELETE SET NULL ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT,
  `post_id` INT NOT NULL,
  `text` VARCHAR(1000) NOT NULL,
  `posted` DATETIME NOT NULL,
  `is_valid` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  INDEX (`user_id`),
  INDEX (`post_id`),
  CONSTRAINT `fk_comment_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES  `user`(`user_id`)
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_comment_post1`
    FOREIGN KEY (`post_id`)
    REFERENCES  `post`(`post_id`)
    ON DELETE CASCADE ON UPDATE CASCADE)
ENGINE = InnoDB;