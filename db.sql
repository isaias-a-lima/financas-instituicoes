CREATE DATABASE `financas_instituicoes` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;

use financas_instituicoes;

CREATE TABLE `usuarios` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `rg` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `datacadastro` date NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `idusuario_UNIQUE` (`idusuario`),
  UNIQUE KEY `rg_UNIQUE` (`rg`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `usersecurity1` (
  `idusuario` int NOT NULL,
  `senha` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idusuario`),
  CONSTRAINT `fk_usuarios_usersecurity1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `instituicoes` (
  `idinstituicao` int NOT NULL AUTO_INCREMENT,
  `cnpj` varchar(20) COLLATE utf8_bin NOT NULL,
  `nome` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `emailcontab` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `datacadastro` date NOT NULL,
  `idusuarioresp` int NOT NULL,
  PRIMARY KEY (`idinstituicao`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `cnpj_UNIQUE` (`cnpj`),
  KEY `fk_usuarios_instituicoes_idx` (`idusuarioresp`),
  CONSTRAINT `fk_usuarios_instituicoes` FOREIGN KEY (`idusuarioresp`) REFERENCES `usuarios` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `usuarios_instituicoes` (
  `idusuario` int NOT NULL,
  `idinstituicao` int NOT NULL,
  PRIMARY KEY (`idusuario`,`idinstituicao`),
  KEY `fk_instituicoes_join_idx` (`idinstituicao`),
  CONSTRAINT `fk_instituicoes_join` FOREIGN KEY (`idinstituicao`) REFERENCES `instituicoes` (`idinstituicao`),
  CONSTRAINT `fk_usuarios_join` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
