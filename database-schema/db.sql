CREATE TABLE `quote` (
  `quote_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `quote_data_criacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quote_conteudo` varchar(255) NOT NULL,
  `quote_conteudo_ofensivo` int(1) NOT NULL DEFAULT '0',
  `quote_usuario_conteudo_ofensivo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`quote_id`),
  KEY `fk_quote_1_idx` (`usuario_id`),
  KEY `fk_quote_2_idx` (`quote_usuario_conteudo_ofensivo_id`),
  CONSTRAINT `fk_quote_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_quote_2` FOREIGN KEY (`quote_usuario_conteudo_ofensivo_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `quote_reacao` (
  `quote_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `reacao_id` int(11) NOT NULL,
  `quote_reacao_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`quote_id`,`usuario_id`),
  KEY `fk_quote_reacao_2_idx` (`usuario_id`),
  KEY `fk_quote_reacao_3_idx` (`reacao_id`),
  CONSTRAINT `fk_quote_reacao_1` FOREIGN KEY (`quote_id`) REFERENCES `quote` (`quote_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_quote_reacao_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_quote_reacao_3` FOREIGN KEY (`reacao_id`) REFERENCES `reacao` (`reacao_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reacao` (
  `reacao_id` int(11) NOT NULL AUTO_INCREMENT,
  `reacao_descricao` varchar(32) NOT NULL,
  `reacao_icon` varchar(32) NOT NULL,
  PRIMARY KEY (`reacao_id`),
  UNIQUE KEY `reacao_descricao_UNIQUE` (`reacao_descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `reacao` WRITE;
INSERT INTO `reacao` VALUES (1,'Gostei','up'),(2,'Não gostei','down');
UNLOCK TABLES;

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_nome` varchar(128) NOT NULL,
  `usuario_email` varchar(128) NOT NULL,
  `usuario_senha` varchar(128) NOT NULL,
  `usuario_ativo` int(1) NOT NULL DEFAULT '1',
  `usuario_sobre` varchar(255) DEFAULT NULL,
  `token` text,
  `refresh_token` text,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario_email_UNIQUE` (`usuario_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

