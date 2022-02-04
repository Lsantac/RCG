-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04-Fev-2022 às 20:17
-- Versão do servidor: 10.4.20-MariaDB
-- versão do PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `redecolaborativa`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `id_part` int(11) DEFAULT NULL,
  `id_rede` int(11) DEFAULT NULL,
  `dt_inclusao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `descricao`, `status`, `id_part`, `id_rede`, `dt_inclusao`) VALUES
(1, 'Alimentos', 0, NULL, NULL, NULL),
(2, 'Vestuario', 0, NULL, NULL, NULL),
(3, 'Serviços', 0, NULL, NULL, NULL),
(4, 'Educação', 0, NULL, NULL, NULL),
(5, 'Saúde', 0, NULL, NULL, NULL),
(6, 'Permacultura', 0, NULL, NULL, NULL),
(7, 'Artes Cênicas', 0, NULL, NULL, NULL),
(8, 'Social', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `descricao` mediumtext NOT NULL,
  `local` text NOT NULL,
  `id_rede` int(11) NOT NULL,
  `data` date NOT NULL,
  `latitude` int(11) NOT NULL,
  `longitude` int(11) NOT NULL,
  `id_st_eve` int(11) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos_part`
--

CREATE TABLE `eventos_part` (
  `id` int(11) NOT NULL,
  `id_eve` int(11) NOT NULL,
  `id_part` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `markers`
--

CREATE TABLE `markers` (
  `id` int(11) NOT NULL,
  `nome_part` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` float(10,7) NOT NULL,
  `longitude` float(10,7) NOT NULL,
  `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `markers`
--

INSERT INTO `markers` (`id`, `nome_part`, `endereco`, `latitude`, `longitude`, `type`) VALUES
(978, 'Marcelo Shama', 'Rua Luiz Silveira Soares, 108 - Encantada', -28.0606689, -48.6789703, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `markers_nec`
--

CREATE TABLE `markers_nec` (
  `id` int(11) NOT NULL,
  `nome_part` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` float(10,7) NOT NULL,
  `longitude` float(10,7) NOT NULL,
  `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `markers_nec`
--

INSERT INTO `markers_nec` (`id`, `nome_part`, `endereco`, `latitude`, `longitude`, `type`, `status`) VALUES
(265, 'Ricardo Geraldo', 'R. Corumbá, 224 - Carlos Prates', -19.9150295, -43.9596977, NULL, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `markers_of`
--

CREATE TABLE `markers_of` (
  `id` int(11) NOT NULL,
  `nome_part` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` float(10,7) NOT NULL,
  `longitude` float(10,7) NOT NULL,
  `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `markers_of`
--

INSERT INTO `markers_of` (`id`, `nome_part`, `endereco`, `latitude`, `longitude`, `type`, `status`) VALUES
(1012, 'Ricardo Geraldo', 'R. Corumbá, 224 - Carlos Prates', -19.9150295, -43.9596977, NULL, 4),
(1011, 'Joao Batista', 'Rua Brasil 104', -22.7455845, -45.1327324, NULL, 3),
(1010, 'Ana Claudia ', 'Rua do Catete, 200', -22.9254646, -43.1766167, NULL, 2),
(1009, 'Amanda Pereira', 'Rua Irlanda, 20', -16.7167072, -49.3069305, NULL, 2),
(1007, 'Marcelo Shama', 'Rua Luiz Silveira Soares, 108 - Encantada', -28.0606689, -48.6789703, NULL, 3),
(1008, 'Marcos da Silva', 'Rua Santa Clara , 100 , Copacabana', -22.9703426, -43.1876640, NULL, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens_trans`
--

CREATE TABLE `mensagens_trans` (
  `id` int(11) NOT NULL,
  `id_trans` int(11) NOT NULL,
  `id_part` int(11) NOT NULL,
  `id_part_dest` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `of_nec_tr` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `mensagens_trans`
--

INSERT INTO `mensagens_trans` (`id`, `id_trans`, `id_part`, `id_part_dest`, `mensagem`, `data`, `of_nec_tr`) VALUES
(168, 58, 33, 26, 'olá Luiz', '2021-12-08 18:41:00', 'nec'),
(169, 59, 24, 26, 'Olá Luiz , é a Amanda, tudo bem?', '2021-12-08 21:08:24', 'nec'),
(170, 59, 26, 24, 'tudo bem Amanda, e voce? Tá precisando de um permacultor?', '2021-12-08 21:09:41', 'of'),
(171, 60, 26, 27, 'Oi Ana', '2021-12-09 15:52:27', 'of'),
(172, 58, 26, 33, 'oi', '2021-12-09 15:54:19', 'of'),
(173, 61, 26, 5, 'oi João', '2021-12-09 15:55:06', 'of'),
(174, 62, 26, 14, 'oi Ricardo', '2021-12-09 16:15:07', 'of'),
(175, 63, 26, 14, 'oi Ricardo, ta precisando de ator?', '2021-12-09 16:15:48', 'nec'),
(176, 58, 26, 33, 'vamos fechar então.', '2021-12-10 17:59:48', 'of'),
(177, 63, 26, 14, 'blz', '2021-12-10 18:05:05', 'nec'),
(178, 62, 26, 14, 'está por ai?', '2022-01-11 21:56:16', 'of'),
(179, 62, 14, 26, 'vamos finalizar então ok?', '2022-01-22 21:50:21', 'nec'),
(180, 64, 26, 38, 'oi Shama vamos trocar feijão por terapia quantica ?', '2022-01-28 21:29:50', 'tr'),
(181, 64, 26, 38, 'oi Shama', '2022-01-29 20:35:47', 'tr');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `moedas`
--

CREATE TABLE `moedas` (
  `id` int(11) NOT NULL,
  `desc_moeda` varchar(255) NOT NULL,
  `obs` text NOT NULL,
  `id_part` int(11) DEFAULT NULL,
  `id_rede` int(11) DEFAULT NULL,
  `dt_inclusao` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `moedas`
--

INSERT INTO `moedas` (`id`, `desc_moeda`, `obs`, `id_part`, `id_rede`, `dt_inclusao`, `status`) VALUES
(1, 'Troca', '', NULL, NULL, NULL, 0),
(2, 'Doação', '', NULL, NULL, NULL, 0),
(3, 'Moeda A', '', NULL, NULL, NULL, 0),
(4, 'Moeda B', '', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `moedas_part`
--

CREATE TABLE `moedas_part` (
  `id` int(11) NOT NULL,
  `id_part` int(11) NOT NULL,
  `id_moeda` int(11) NOT NULL,
  `id_trans` int(11) NOT NULL,
  `quant_moeda` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `moedas_part`
--

INSERT INTO `moedas_part` (`id`, `id_part`, `id_moeda`, `id_trans`, `quant_moeda`, `data`) VALUES
(5, 26, 3, 40, 50, '2021-12-03'),
(6, 14, 3, 40, -50, '2021-11-22'),
(7, 26, 3, 58, 100, '2022-01-20'),
(8, 14, 3, 63, 1, '2022-01-24'),
(9, 26, 2, 62, 1, '2022-01-22'),
(10, 14, 2, 62, -1, '2022-01-22'),
(11, 26, 3, 63, -1, '2022-01-24'),
(12, 14, 4, 63, 1, '2022-01-24'),
(13, 26, 4, 63, -1, '2022-01-24');

-- --------------------------------------------------------

--
-- Estrutura da tabela `necessidades`
--

CREATE TABLE `necessidades` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `id_unid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `necessidades`
--

INSERT INTO `necessidades` (`id`, `descricao`, `status`, `id_cat`, `id_unid`) VALUES
(1, 'Profissional de Cozinha', 1, 1, 4),
(2, 'Arquiteto', 1, 3, 4),
(3, 'Programador de Software', 1, 3, 4),
(4, 'Permacultor', 1, 3, 4),
(5, 'Professora Waldorf', 1, 4, 4),
(6, 'Ator', 1, 7, 4),
(7, 'Musico', 1, 7, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `necessidades_part`
--

CREATE TABLE `necessidades_part` (
  `id` int(11) NOT NULL,
  `id_nec` int(11) NOT NULL,
  `id_part` int(11) NOT NULL,
  `data` date NOT NULL,
  `quant` float NOT NULL,
  `obs` text NOT NULL,
  `ranking` int(11) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `necessidades_part`
--

INSERT INTO `necessidades_part` (`id`, `id_nec`, `id_part`, `data`, `quant`, `obs`, `ranking`, `imagem`, `status`) VALUES
(1, 1, 33, '2021-08-05', 5, 'Necessito de pessoas com aptidões em culinaria, chefes de cozinha, doceiras, pizzaiolos,comida árabe.', NULL, NULL, 2),
(2, 2, 26, '2021-08-16', 1, 'Bioconstrutor para fazer casas de adobe.', NULL, NULL, 1),
(3, 3, 14, '2021-08-19', 1, 'Desenvolvedor de sistemas de banco de dados.', NULL, NULL, 2),
(4, 1, 27, '2021-08-23', 1, 'Preciso de cozinheiro vegano com urgencia.', NULL, NULL, 1),
(5, 4, 24, '2021-08-23', 1, 'Preciso de um profissional de permacultura para criar um sitio ecologico para futuramente virar uma ecovila.', NULL, NULL, 2),
(6, 5, 27, '2021-09-07', 1, 'Jardineira Waldorf trabalho de manhã na escola Jardim Michaelis, Rio de Janeiro.', NULL, NULL, 0),
(7, 6, 26, '2021-09-15', 1, 'Preciso de um ator para um filme que estou fazendo sobre ecovilas.', NULL, NULL, 4),
(8, 7, 5, '2021-11-24', 5, 'Preciso de musicos para montar uma banda. Guitarrista, baterista, vocalista, tecladista e arranjador.', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ofertas`
--

CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `id_cat` int(11) NOT NULL,
  `id_unid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `ofertas`
--

INSERT INTO `ofertas` (`id`, `descricao`, `status`, `id_cat`, `id_unid`) VALUES
(1, 'Cozinheiro', 1, 1, 4),
(2, 'Professor', 1, 4, 4),
(3, 'Artesão', 1, 2, 4),
(4, 'Programador', 1, 3, 4),
(5, 'Reiki', 1, 5, 3),
(6, 'Advogada', 1, 3, 4),
(7, 'Arquiteto', 1, 3, 4),
(8, 'Babá', 1, 3, 4),
(9, 'Feijão', 1, 1, 1),
(10, 'Instrutora de Shantala', 1, 3, 3),
(11, 'Ator', 1, 7, 4),
(12, 'Companhia', 1, 8, 3),
(13, 'Terapia quantica', 1, 5, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ofertas_part`
--

CREATE TABLE `ofertas_part` (
  `id` int(11) NOT NULL,
  `id_of` int(11) NOT NULL,
  `id_part` int(11) NOT NULL,
  `data` date NOT NULL,
  `quant` float NOT NULL,
  `obs` text NOT NULL,
  `ranking` int(11) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `ofertas_part`
--

INSERT INTO `ofertas_part` (`id`, `id_of`, `id_part`, `data`, `quant`, `obs`, `ranking`, `imagem`, `status`) VALUES
(3, 4, 26, '2021-07-29', 1, 'Analista de Sistemas php', 1, '', 0),
(5, 5, 26, '2021-07-29', 1, 'Aplicação de Reiki a distancia.', 1, '', 0),
(6, 3, 26, '2021-07-27', 5, 'sapateiro', 0, NULL, 1),
(7, 2, 26, '2021-08-04', 2, 'Aulas de Pintura e artes em geral.', 0, NULL, 2),
(8, 6, 24, '2021-08-04', 1, 'Psicologia infantil', 0, NULL, 1),
(9, 7, 33, '2021-08-13', 1, 'Bioconstrutor capacitado em inumeras tecnicas como : Adobe, Pau-a-pique , Super-Adobe, Bambu, entre outros.', NULL, NULL, 0),
(10, 1, 26, '2021-08-23', 1, 'Cozinha vegetariana e vegana. Sou bom mesmo. :-)', NULL, NULL, 2),
(11, 10, 27, '2021-09-07', 1, 'Aulas de Shantala para gestantes. Horario a combinar.', NULL, NULL, 0),
(12, 11, 14, '2021-09-15', 1, 'Sou ator de Hollywood famoso e bem requisitado. Ofereço meus talentos para filmes sobre regeneração global.', NULL, NULL, 4),
(13, 12, 26, '2021-09-15', 2, 'ofereço companhia para bate papos e passeios, para quem se sentir solitário e quiser compartilhar suas experiencias de vida. Horario a combinar.', NULL, NULL, 3),
(14, 9, 26, '2021-10-01', 2, 'tenho dois kilos de feijão para doar.', NULL, NULL, 2),
(15, 7, 26, '2021-10-01', 1, 'faço casas bem legais', NULL, NULL, 2),
(16, 13, 38, '2021-10-27', 1, 'é muito bom', NULL, NULL, 2),
(17, 7, 38, '2021-10-27', 1, 'permacultor', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `participantes`
--

CREATE TABLE `participantes` (
  `id` int(11) NOT NULL,
  `nome_part` varchar(100) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `cep` varchar(20) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `latitude` float(10,7) DEFAULT NULL,
  `longitude` float(10,7) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `ranking` bigint(20) NOT NULL,
  `id_tipo_acesso` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `participantes`
--

INSERT INTO `participantes` (`id`, `nome_part`, `endereco`, `cidade`, `cep`, `estado`, `pais`, `email`, `senha`, `imagem`, `latitude`, `longitude`, `timezone`, `ranking`, `id_tipo_acesso`, `created_at`, `updated_at`) VALUES
(2, 'Ana Aparecida', 'Rua Vonluntario da Patria, 40', 'Rio de Janeiro', '22270-900', 'RJ', 'Narnia', 'ana_aparecida@gmail.com', '54321', '', -22.9499607, -43.1834526, NULL, 0, NULL, '2021-05-01 21:53:54', '2021-05-10 19:13:21'),
(3, 'Laura Abissamara', 'Praia do Flamengo 12', 'Rio de Janeiro', '22210-030', 'RJ', 'Brasil', 'laura@gmail.com', '$2y$10$ET5a6oxCnYNu0NHLV7O05uxD1lcDnBLNpsht6543Qg2l81KS9lhFq', '', -22.9248714, -43.1730957, NULL, 0, NULL, '2021-05-02 00:21:27', '2021-05-21 01:56:38'),
(5, 'Joao Batista', 'Rua Brasil 104', 'Lorena', '12608-400', 'SP', 'Brasil', 'fulano@gmail.com', '$2y$10$qr.4BFbpP.6Y8EQUSj30ruKfApb1Rog0P9KmCqOEwf478mCpM2nX2', 'Joao Batista_1637759842.jpg', -22.7455845, -45.1327324, NULL, 0, NULL, '2021-05-08 21:29:30', '2021-11-24 16:17:22'),
(6, 'Manoel Audaz', 'R. Antônio José Filho, 136 - Vila Isabel', 'Três Rios', '25811-180', 'RJ', 'Brasil', 'manoel@gmail.com', '', '', -22.1055679, -43.1898193, NULL, 0, NULL, '2021-05-15 23:14:11', '2021-05-16 00:03:15'),
(7, 'Marcelo ', 'Rua Santo Dumont, 305', 'Resende', '12500', 'RJ', 'Brasil', 'marcelo@gmail.com', '123457890', '', -22.4755020, -44.4638138, NULL, 0, NULL, '2021-05-16 00:01:56', '2021-05-25 22:16:02'),
(12, 'Joaquim Visconde', 'R. Oliveira Rocha, 28 - Jardim Botânico', 'Rio de Janeiro', '22461-070', 'RJ', 'Brasil', 'joaquim@gmail.com', '', '', -22.9616661, -43.2162437, NULL, 0, NULL, '2021-05-17 20:56:32', '2021-05-17 21:24:53'),
(14, 'Ricardo Geraldo', 'R. Corumbá, 224 - Carlos Prates', 'Belo Horizonte', '30710-280', 'MG', 'Brasil', 'Ricardo@gmail.com', '$2y$10$zHe1uQDUzY7ccT.QcWx12e0QG0GRTt/VN72Iv3IwmdgkXwk.h2Ljm', 'John Cool_1631045109.jpg', -19.9150295, -43.9596977, NULL, 0, NULL, '2021-05-26 17:24:06', '2021-09-15 17:09:50'),
(16, 'Tatiana Silva', 'Rua Almeida Godinho, Lagoa, 1000 ', 'Rio de Janeiro', '22471-140', 'RJ', 'Brasil', 'tatiana@gmail.com', '$2y$10$V.xOOrc/.AHNsNs1urUK1eJeK3gZchsWOtch/D2Q1IxS8Sur6/nta', '', -22.9663811, -43.2026558, NULL, 0, NULL, '2021-05-26 17:34:13', '2021-05-26 17:34:13'),
(22, 'Gustavo Alfredo', 'Rua Coronel Moreira Cesar 30,Icarai', 'Niteroi', '24230-060', 'RJ', 'Brasil', 'gustavo@gmail.com', '$2y$10$BLjpzKmMfZbU24VD.sRVxOV.KSDqXOKUxVD6MfkATv.uMO7o6GUSK', '', -22.9104176, -43.1069756, NULL, 0, NULL, '2021-05-28 21:50:25', '2021-05-28 21:50:25'),
(24, 'Amanda Pereira', 'Rua Irlanda, 20', 'Goiania', '68552', 'GO', 'Brasil', 'amandinha@gmail.com', '$2y$10$rOMseaROi3kuX1UQ2E1RXunH4dCls1piOvN7Cw2Y80izyjB12Rzg2', 'Amanda Pereira_1638986834.jpg', -16.7167072, -49.3069305, NULL, 0, NULL, '2021-05-29 21:54:05', '2021-12-08 21:07:14'),
(25, 'Bianca', 'Rua Pouso Alto', 'Itamonte', '37466-000', 'MG', 'Brasil', 'bianca@gmail.com', '$2y$10$i8FOjrwGkofaysz0OhBdPeOhZeX.CJjHmISuiiWzTRE6aTb2Yq6Ui', NULL, -22.2761383, -44.8721161, NULL, 0, NULL, '2021-05-29 22:01:41', '2021-05-29 22:01:41'),
(26, 'Luiz Eduardo Castro', 'Rua Luiz Menezes , 111 , Vila Paraiba', 'Guaratinguetá', '12500', 'SP', 'Brasil', 'Lsantac@gmail.com', '$2y$10$IKOmMY3J2bzpIDOm2GH5He3iAGtH/LXcVZqT/FJrjwLPQqPatts7.', 'Luiz Eduardo Santa Clara de Castro_1631715341.jpg', -22.8105164, -45.1904182, NULL, 0, 1, '2021-06-01 01:29:36', '2021-10-24 16:57:15'),
(27, 'Ana Claudia ', 'Rua do Catete, 200', 'Rio de Janeiro', '22220-000', 'RJ', 'Brasil', 'anaclaudia@gmail.com', '$2y$10$u2.FJ0y3LRAImEWGSc7xQe1a32Ac.VA1Mj4cEOKZMnd4hDdZA904a', 'Ana Claudia_1623160847.JPG', -22.9254646, -43.1766167, NULL, 0, NULL, '2021-06-02 01:11:04', '2021-06-08 17:00:47'),
(28, 'Pedro Augusto', 'Rua Augusta, 129', 'São Paulo', '01305-900', 'AM', 'Brasil', 'pedro@gmail.com', '$2y$10$Q9u6J7oANAT3BD3jBsxzWOubBNbikXvNHK4VKZ8t3eINNxMpdlP.W', '', -23.5505238, -46.6473541, NULL, 0, NULL, '2021-06-04 21:48:47', '2021-06-04 21:48:47'),
(29, 'Luiz Augusto', 'R. Maj. Carvalho, 115 - Várzea', 'Teresopolis', '25953-460', 'RJ', 'Brasil', 'augusto@gmail.com', '$2y$10$uGE7QIDlRgsk1IjlDO7iyO9U55JMUJMHrKmp3Ai2cPvsxxFVMhmmq', '', -22.4152031, -42.9689827, NULL, 0, NULL, '2021-06-04 22:46:33', '2021-06-06 01:18:19'),
(32, 'Patricia Aline', 'Av. do Canal, 14 - Centro', 'Marica', '24900-970', 'SP', 'Brasil', 'jukikuki@gmail.com', '$2y$10$ZaODjV9k8DgOLv4tGgvwHuhy1c8X0KfVgGAwxDLjA7aFZ6csE7c0K', 'Juki Kuki da floresta_1624053736.jpg', -22.9096279, -42.8179398, NULL, 0, NULL, '2021-06-19 00:59:48', '2021-06-19 01:02:16'),
(33, 'Marcos da Silva', 'Rua Santa Clara , 100 , Copacabana', 'Rio de Janeiro', '12500', 'AM', 'Brasil', 'marcos@gmail.com', '$2y$10$fyRanOdcvcJQLvTz6v8/5.pGEPRU.Q8uop92X.3L7JYDOmCQNjB7O', 'Marcos da Silva_1628865127.jpg', -22.9703426, -43.1876640, NULL, 0, NULL, '2021-08-05 16:57:21', '2021-09-01 22:28:00'),
(34, 'Paulo Lima', 'Av Cleo Bernardes', 'Santarém', '68005-970', 'PA', 'Brasil', 'paulolima@gmail.com', '$2y$10$byvBcMp6okSBzqwhLqmCeOqbW4jKgPIQrzY1DM9rqAiyt8u2jyTqm', NULL, -2.4424975, -54.7033043, NULL, 0, NULL, '2021-09-07 23:14:18', '2021-09-07 23:39:34'),
(35, 'João da Silva', 'Av Nossa Senhora de Copacabana, 1000 , Copacabana', 'Rio de Janeiro', '21000', 'RJ', 'Brasil', 'joaodasilva@gmail.com', '$2y$10$W/EMGsDS8ZFgMVaKbDH93u17qS.mngZkKWWw3V7lR.xsQYh35P89S', 'João da Silva_1635273324.jpg', -22.9770336, -43.1906853, NULL, 0, NULL, '2021-10-26 21:27:55', '2021-10-26 21:35:24'),
(38, 'Marcelo Shama', 'Rua Luiz Silveira Soares, 108 - Encantada', 'Garopaba', '88495-000', 'SC', 'Brasil', 'marceloshama@gmail.com', '$2y$10$vicG.yStiLkiMf97gCdV.OEuaq9a2AlnPjCvB0rollBVaUupfh6lW', 'Marcelo Shama_1635348782.jpg', -28.0606689, -48.6789703, NULL, 0, NULL, '2021-10-27 18:32:34', '2021-10-27 18:33:02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos`
--

CREATE TABLE `projetos` (
  `id` int(11) NOT NULL,
  `descricao` mediumtext NOT NULL,
  `id_rede` int(11) NOT NULL,
  `id_st_proj` int(11) NOT NULL,
  `dt_inic` date NOT NULL,
  `dt_fim` date NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos_part`
--

CREATE TABLE `projetos_part` (
  `id` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `id_part` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `redes`
--

CREATE TABLE `redes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` longtext NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `redes`
--

INSERT INTO `redes` (`id`, `nome`, `descricao`, `imagem`) VALUES
(2, 'PermaEco', 'Assuntos ligados a Permacultura e Ecovilas.', ''),
(5, 'AstroUfo', 'Pesquisadores sobre o tema ufologia e astronomia.', ''),
(6, 'Professores', 'Pessoas com interesse em ensinar outras pessoas sobre os misterios da vida e do universo. ', ''),
(7, 'Ufonet', 'grupo ufologico', ''),
(8, 'Xamanicos', 'Pessoas com interesse em xamanismo e medicinas da floresta.', ''),
(9, 'Antroposoficos', 'Pessoas com interesse em estudar antroposofia e assuntos ligados a Rudolf Steiner.', ''),
(10, 'Alternativos', 'Turma do Arco-Iris.', NULL),
(11, 'Daimistas', 'Turma do Santo Daime', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `redesparts`
--

CREATE TABLE `redesparts` (
  `id` int(11) NOT NULL,
  `id_rede` int(11) NOT NULL,
  `id_part` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `redesparts`
--

INSERT INTO `redesparts` (`id`, `id_rede`, `id_part`) VALUES
(1, 2, 2),
(2, 2, 3),
(8, 2, 26),
(20, 2, 27),
(3, 2, 29),
(4, 5, 29),
(15, 5, 32),
(23, 5, 33),
(10, 6, 3),
(18, 6, 27),
(5, 6, 29),
(13, 7, 29),
(22, 8, 24),
(14, 8, 26),
(19, 9, 27),
(21, 10, 26),
(17, 10, 27),
(24, 11, 26);

-- --------------------------------------------------------

--
-- Estrutura da tabela `status_eve`
--

CREATE TABLE `status_eve` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `status_proj`
--

CREATE TABLE `status_proj` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `status_trans`
--

CREATE TABLE `status_trans` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `status_trans`
--

INSERT INTO `status_trans` (`id`, `descricao`) VALUES
(5, 'Cancelada'),
(2, 'Em andamento'),
(3, 'Finalizada parcialmente'),
(4, 'Finalizada totalmente'),
(1, 'Pendente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_acessos`
--

CREATE TABLE `tipos_acessos` (
  `id` int(11) NOT NULL,
  `desc_tipo_acesso` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tipos_acessos`
--

INSERT INTO `tipos_acessos` (`id`, `desc_tipo_acesso`) VALUES
(1, 'admin'),
(2, 'participante');

-- --------------------------------------------------------

--
-- Estrutura da tabela `transacoes`
--

CREATE TABLE `transacoes` (
  `id` int(11) NOT NULL,
  `id_nec_part` int(11) NOT NULL DEFAULT 0,
  `id_of_part` int(11) NOT NULL DEFAULT 0,
  `id_of_tr_part` int(11) NOT NULL DEFAULT 0,
  `id_st_trans` int(11) NOT NULL DEFAULT 0,
  `quant_moeda` float DEFAULT 0,
  `id_moeda` int(11) DEFAULT NULL,
  `quant_of` float DEFAULT NULL,
  `quant_of_tr` float DEFAULT NULL,
  `quant_nec` float DEFAULT NULL,
  `data_inic` datetime NOT NULL,
  `data_final_nec_part` datetime DEFAULT NULL,
  `data_final_of_part` datetime DEFAULT NULL,
  `data_final_of_tr_part` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `transacoes`
--

INSERT INTO `transacoes` (`id`, `id_nec_part`, `id_of_part`, `id_of_tr_part`, `id_st_trans`, `quant_moeda`, `id_moeda`, `quant_of`, `quant_of_tr`, `quant_nec`, `data_inic`, `data_final_nec_part`, `data_final_of_part`, `data_final_of_tr_part`) VALUES
(58, 1, 14, 0, 4, 100, 3, 2, 0, 2, '2021-12-08 15:41:00', '2022-01-20 18:19:12', '2022-01-20 18:21:25', NULL),
(59, 5, 15, 0, 2, 0, NULL, 0, 0, 0, '2021-12-08 18:08:24', NULL, NULL, NULL),
(60, 4, 14, 0, 2, 0, NULL, 0, 0, 0, '2021-12-09 12:52:27', NULL, NULL, NULL),
(61, 8, 13, 0, 3, 1, 2, 2, 0, 0, '2021-12-09 12:55:06', NULL, '2022-01-25 18:32:53', NULL),
(62, 3, 15, 0, 4, 1, 2, 1, 0, 1, '2021-12-09 13:15:07', '2022-01-22 18:49:46', '2022-01-22 18:48:13', NULL),
(63, 7, 12, 0, 4, 1, 4, 1, 0, 1, '2021-12-09 13:15:48', '2022-01-24 22:50:40', '2022-01-22 18:57:11', NULL),
(64, 0, 16, 14, 3, 1, 1, 1, 2, 0, '2022-01-28 18:29:50', NULL, NULL, '2022-01-28 18:29:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `unidades`
--

INSERT INTO `unidades` (`id`, `descricao`) VALUES
(1, 'kilo'),
(2, 'litro'),
(3, 'hora'),
(4, 'un');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `email`, `senha`, `created_at`, `updated_at`) VALUES
(476, 'Lsantac@gmail.com', '$2y$10$F2wBYI629/ejoYvvp3munuYqtrK4YZ8dipILDwMB3Gah8GZ4e9RIm', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `descricao` (`descricao`),
  ADD KEY `status` (`status`),
  ADD KEY `id_part` (`id_part`),
  ADD KEY `id_rede` (`id_rede`),
  ADD KEY `dt_inclusao` (`dt_inclusao`);

--
-- Índices para tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `descricao` (`descricao`) USING HASH,
  ADD KEY `local` (`local`(768)),
  ADD KEY `id_rede` (`id_rede`),
  ADD KEY `data` (`data`),
  ADD KEY `id_st_eve` (`id_st_eve`);

--
-- Índices para tabela `eventos_part`
--
ALTER TABLE `eventos_part`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_eve_id_part` (`id_eve`,`id_part`) USING BTREE,
  ADD KEY `id_part` (`id_part`);

--
-- Índices para tabela `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `markers_nec`
--
ALTER TABLE `markers_nec`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `markers_of`
--
ALTER TABLE `markers_of`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `mensagens_trans`
--
ALTER TABLE `mensagens_trans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_trans` (`id_trans`),
  ADD KEY `data` (`data`),
  ADD KEY `id_part` (`id_part`),
  ADD KEY `of_nec_tr` (`of_nec_tr`),
  ADD KEY `id_part_dest` (`id_part_dest`) USING BTREE;

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `moedas`
--
ALTER TABLE `moedas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `desc_moeda` (`desc_moeda`),
  ADD KEY `id_part` (`id_part`),
  ADD KEY `id_rede` (`id_rede`),
  ADD KEY `dt_inclusao` (`dt_inclusao`),
  ADD KEY `status` (`status`);

--
-- Índices para tabela `moedas_part`
--
ALTER TABLE `moedas_part`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_part_2` (`id_part`,`id_moeda`,`id_trans`),
  ADD KEY `id_part` (`id_part`),
  ADD KEY `id_moeda` (`id_moeda`),
  ADD KEY `quant_moeda` (`quant_moeda`),
  ADD KEY `data` (`data`),
  ADD KEY `id_trans` (`id_trans`);

--
-- Índices para tabela `necessidades`
--
ALTER TABLE `necessidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `descricao` (`descricao`) USING BTREE,
  ADD KEY `status` (`status`),
  ADD KEY `id_cat` (`id_cat`),
  ADD KEY `id_unid` (`id_unid`);

--
-- Índices para tabela `necessidades_part`
--
ALTER TABLE `necessidades_part`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data` (`data`),
  ADD KEY `ranking` (`ranking`),
  ADD KEY `id_nec` (`id_nec`) USING BTREE,
  ADD KEY `id_part` (`id_part`) USING BTREE,
  ADD KEY `finalizada` (`status`);

--
-- Índices para tabela `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `descricao` (`descricao`) USING BTREE,
  ADD KEY `status` (`status`),
  ADD KEY `id_cat` (`id_cat`),
  ADD KEY `id_unidade` (`id_unid`);

--
-- Índices para tabela `ofertas_part`
--
ALTER TABLE `ofertas_part`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data` (`data`),
  ADD KEY `ranking` (`ranking`),
  ADD KEY `id_nec` (`id_of`) USING BTREE,
  ADD KEY `id_part` (`id_part`) USING BTREE,
  ADD KEY `finalizada` (`status`);

--
-- Índices para tabela `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE,
  ADD KEY `nome_part` (`nome_part`),
  ADD KEY `endereco` (`endereco`),
  ADD KEY `cidade` (`cidade`),
  ADD KEY `pais` (`pais`),
  ADD KEY `ranking` (`ranking`),
  ADD KEY `cep` (`cep`),
  ADD KEY `senha` (`senha`),
  ADD KEY `id_tipo_acesso` (`id_tipo_acesso`),
  ADD KEY `timezone` (`timezone`);

--
-- Índices para tabela `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `descricao` (`descricao`) USING HASH,
  ADD KEY `id_rede` (`id_rede`),
  ADD KEY `id_st_proj` (`id_st_proj`),
  ADD KEY `dt_inic` (`dt_inic`),
  ADD KEY `dt_fim` (`dt_fim`);

--
-- Índices para tabela `projetos_part`
--
ALTER TABLE `projetos_part`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_proj_id_part` (`id_proj`,`id_part`) USING BTREE,
  ADD KEY `id_part` (`id_part`);

--
-- Índices para tabela `redes`
--
ALTER TABLE `redes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_rede` (`nome`);

--
-- Índices para tabela `redesparts`
--
ALTER TABLE `redesparts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_rede_part` (`id_rede`,`id_part`) USING BTREE,
  ADD KEY `id_part` (`id_part`);

--
-- Índices para tabela `status_eve`
--
ALTER TABLE `status_eve`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `descricao` (`descricao`);

--
-- Índices para tabela `status_proj`
--
ALTER TABLE `status_proj`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `descricao` (`descricao`);

--
-- Índices para tabela `status_trans`
--
ALTER TABLE `status_trans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `descricao` (`descricao`);

--
-- Índices para tabela `tipos_acessos`
--
ALTER TABLE `tipos_acessos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `desc_tipo_acesso` (`desc_tipo_acesso`);

--
-- Índices para tabela `transacoes`
--
ALTER TABLE `transacoes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_nec_of_part` (`id_nec_part`,`id_of_part`,`id_of_tr_part`) USING BTREE,
  ADD KEY `id_st_trans` (`id_st_trans`) USING BTREE,
  ADD KEY `id_nec_part` (`id_nec_part`) USING BTREE,
  ADD KEY `id_of_part` (`id_of_part`) USING BTREE,
  ADD KEY `id_moeda` (`id_moeda`),
  ADD KEY `data_inic` (`data_inic`),
  ADD KEY `data_final_of_part` (`data_final_of_part`),
  ADD KEY `data_final_nec_part` (`data_final_nec_part`),
  ADD KEY `data_final_of_tr_part` (`data_final_of_tr_part`);

--
-- Índices para tabela `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `descricao` (`descricao`(768));

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `eventos_part`
--
ALTER TABLE `eventos_part`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=979;

--
-- AUTO_INCREMENT de tabela `markers_nec`
--
ALTER TABLE `markers_nec`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

--
-- AUTO_INCREMENT de tabela `markers_of`
--
ALTER TABLE `markers_of`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1013;

--
-- AUTO_INCREMENT de tabela `mensagens_trans`
--
ALTER TABLE `mensagens_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `moedas`
--
ALTER TABLE `moedas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `moedas_part`
--
ALTER TABLE `moedas_part`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `necessidades`
--
ALTER TABLE `necessidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `necessidades_part`
--
ALTER TABLE `necessidades_part`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `ofertas_part`
--
ALTER TABLE `ofertas_part`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `projetos_part`
--
ALTER TABLE `projetos_part`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `redes`
--
ALTER TABLE `redes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `redesparts`
--
ALTER TABLE `redesparts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `status_eve`
--
ALTER TABLE `status_eve`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `status_proj`
--
ALTER TABLE `status_proj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `status_trans`
--
ALTER TABLE `status_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tipos_acessos`
--
ALTER TABLE `tipos_acessos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `transacoes`
--
ALTER TABLE `transacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=488;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_rede`) REFERENCES `redes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `eventos_ibfk_2` FOREIGN KEY (`id_st_eve`) REFERENCES `status_eve` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `eventos_part`
--
ALTER TABLE `eventos_part`
  ADD CONSTRAINT `eventos_part_ibfk_1` FOREIGN KEY (`id_eve`) REFERENCES `eventos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `eventos_part_ibfk_2` FOREIGN KEY (`id_part`) REFERENCES `participantes` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `mensagens_trans`
--
ALTER TABLE `mensagens_trans`
  ADD CONSTRAINT `mensagens_trans_ibfk_1` FOREIGN KEY (`id_trans`) REFERENCES `transacoes` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `moedas_part`
--
ALTER TABLE `moedas_part`
  ADD CONSTRAINT `moedas_part_ibfk_1` FOREIGN KEY (`id_moeda`) REFERENCES `moedas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `moedas_part_ibfk_2` FOREIGN KEY (`id_part`) REFERENCES `participantes` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `necessidades`
--
ALTER TABLE `necessidades`
  ADD CONSTRAINT `necessidades_ibfk_1` FOREIGN KEY (`id_cat`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `necessidades_ibfk_2` FOREIGN KEY (`id_unid`) REFERENCES `unidades` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `necessidades_part`
--
ALTER TABLE `necessidades_part`
  ADD CONSTRAINT `necessidades_part_ibfk_1` FOREIGN KEY (`id_part`) REFERENCES `participantes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `necessidades_part_ibfk_2` FOREIGN KEY (`id_nec`) REFERENCES `necessidades` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ofertas`
--
ALTER TABLE `ofertas`
  ADD CONSTRAINT `ofertas_ibfk_1` FOREIGN KEY (`id_cat`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ofertas_ibfk_2` FOREIGN KEY (`id_unid`) REFERENCES `unidades` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ofertas_part`
--
ALTER TABLE `ofertas_part`
  ADD CONSTRAINT `ofertas_part_ibfk_1` FOREIGN KEY (`id_part`) REFERENCES `participantes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ofertas_part_ibfk_2` FOREIGN KEY (`id_of`) REFERENCES `ofertas` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `participantes`
--
ALTER TABLE `participantes`
  ADD CONSTRAINT `participantes_ibfk_1` FOREIGN KEY (`id_tipo_acesso`) REFERENCES `tipos_acessos` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `projetos`
--
ALTER TABLE `projetos`
  ADD CONSTRAINT `projetos_ibfk_1` FOREIGN KEY (`id_rede`) REFERENCES `redes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `projetos_ibfk_2` FOREIGN KEY (`id_st_proj`) REFERENCES `status_proj` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `projetos_part`
--
ALTER TABLE `projetos_part`
  ADD CONSTRAINT `projetos_part_ibfk_1` FOREIGN KEY (`id_part`) REFERENCES `participantes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `projetos_part_ibfk_2` FOREIGN KEY (`id_proj`) REFERENCES `projetos` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `redesparts`
--
ALTER TABLE `redesparts`
  ADD CONSTRAINT `redesparts_ibfk_1` FOREIGN KEY (`id_rede`) REFERENCES `redes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `redesparts_ibfk_2` FOREIGN KEY (`id_part`) REFERENCES `participantes` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `transacoes`
--
ALTER TABLE `transacoes`
  ADD CONSTRAINT `transacoes_ibfk_1` FOREIGN KEY (`id_st_trans`) REFERENCES `status_trans` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transacoes_ibfk_4` FOREIGN KEY (`id_moeda`) REFERENCES `moedas` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
