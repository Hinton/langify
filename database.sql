CREATE TABLE IF NOT EXISTS `translate_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` longtext NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `translate_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `translate_languages` (`id`, `file`, `name`) VALUES
(1, 'en', 'English'),
(2, 'sv', 'Swedish');


CREATE TABLE IF NOT EXISTS `translate_strings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translate_language_id` int(11) NOT NULL,
  `translate_key_id` int(11) NOT NULL,
  `string` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;