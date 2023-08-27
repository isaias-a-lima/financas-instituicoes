/*CREATE DATABASE `financas_instituicoes` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;*/

/*use financas_instituicoes;*/

CREATE TABLE `usuarios` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `rg` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8_bin NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_bin NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_bin NOT NULL,
  `datacadastro` date NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `idusuario_UNIQUE` (`idusuario`),
  UNIQUE KEY `rg_UNIQUE` (`rg`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;


CREATE TABLE `usersecurity1` (
  `idusuario` int NOT NULL,
  `senha` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idusuario`),
  CONSTRAINT `fk_usuarios_usersecurity1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `instituicoes` (
  `idinstituicao` int NOT NULL AUTO_INCREMENT,
  `cnpj` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8_bin NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_bin NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_bin NOT NULL,
  `emailcontab` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_bin DEFAULT NULL,
  `datacadastro` date NOT NULL,
  `idusuarioresp` int NOT NULL,
  PRIMARY KEY (`idinstituicao`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `cnpj_UNIQUE` (`cnpj`),
  KEY `fk_usuarios_instituicoes_idx` (`idusuarioresp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;


CREATE TABLE `usuarios_instituicoes` (
  `idusuario` int NOT NULL,
  `idinstituicao` bigint NOT NULL,
  `funcao` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idusuario`,`idinstituicao`),
  KEY `fk_instituicoes_join_idx` (`idinstituicao`),
  CONSTRAINT `fk_usuarios_join` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;


CREATE TABLE `categorias` (
  `idcategoria` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) COLLATE utf8_bin NOT NULL,
  `tipo` char(1) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;



CREATE TABLE `entradas` (
  `identrada` int NOT NULL AUTO_INCREMENT,
  `idinstituicao` int NOT NULL,
  `idusuario` int NOT NULL,
  `idcategoria` int DEFAULT NULL,
  `dataentrada` date NOT NULL,
  `descricao` varchar(255) COLLATE utf8_bin NOT NULL,
  `valor` decimal(7,2) NOT NULL,
  PRIMARY KEY (`identrada`),
  KEY `fk_instituicoes_entradas_idx` (`idinstituicao`),
  KEY `fk_usuarios_entradas_idx` (`idusuario`),
  KEY `fk_categorias_entradas_idx` (`idcategoria`),
  CONSTRAINT `fk_categorias_entradas` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`) ON DELETE RESTRICT,
  CONSTRAINT `fk_instituicoes_entradas` FOREIGN KEY (`idinstituicao`) REFERENCES `instituicoes` (`idinstituicao`) ON DELETE RESTRICT,
  CONSTRAINT `fk_usuarios_entradas` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

CREATE TABLE `historico_reset_senha` (
  `idhistorico` int NOT NULL AUTO_INCREMENT,
  `idusuario` int NOT NULL,
  `chave` varchar(255) COLLATE utf8_bin NOT NULL,
  `datasolicitacao` date NOT NULL,
  `dataexpiracao` date NOT NULL,
  `localizacao` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`idhistorico`),
  KEY `fk_usuarios__historico_reset_idx` (`idusuario`),
  CONSTRAINT `fk_usuarios__historico_reset` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

CREATE TABLE `fechamentos` (
  `idfechamento` bigint NOT NULL AUTO_INCREMENT,
  `idinstituicao` int NOT NULL,
  `dataInicio` date NOT NULL,
  `dataFim` date NOT NULL,
  `saldoInicial` decimal(10,2) NOT NULL,
  `entradas` decimal(10,2) NOT NULL,
  `saidas` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idfechamento`),
  KEY `fk_fechamentos_instituicoes_idx` (`idinstituicao`),
  CONSTRAINT `fk_fechamentos_instituicoes` FOREIGN KEY (`idinstituicao`) REFERENCES `instituicoes` (`idinstituicao`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

CREATE TABLE `saidas` (
  `idsaida` bigint NOT NULL AUTO_INCREMENT,
  `idinstituicao` int NOT NULL,
  `idusuario` int NOT NULL,
  `idcategoria` int NOT NULL,
  `datasaida` date NOT NULL,
  `descricao` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `valor` decimal(7,2) NOT NULL,
  `numdoc` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`idsaida`),
  KEY `fk_saidas_instituicoes_idx` (`idinstituicao`),
  KEY `fk_saidas_usuarios_idx` (`idusuario`),
  KEY `fk_saidas_categorias_idx` (`idcategoria`),
  CONSTRAINT `fk_saidas_categorias` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`) ON DELETE RESTRICT,
  CONSTRAINT `fk_saidas_instituicoes` FOREIGN KEY (`idinstituicao`) REFERENCES `instituicoes` (`idinstituicao`) ON DELETE RESTRICT,
  CONSTRAINT `fk_saidas_usuarios` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;
