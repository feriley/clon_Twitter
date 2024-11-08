CREATE TABLE `users_crud_php`.`usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `mail` VARCHAR(45) NOT NULL,
  `pass` CHAR(60) NOT NULL,
  `createDate` DATE NULL,
  PRIMARY KEY (`id`));