CREATE TABLE IF NOT EXISTS `panels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageID` int(11) NOT NULL,
  `revision` int(11) NOT NULL,
  `rowPos` int(11) NOT NULL,
  `columnPos` int(11) NOT NULL,
  `subject` longtext NOT NULL,
  `type` varchar(255) NOT NULL,
  `classes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

INSERT INTO `panels` (`id`, `pageID`, `revision`, `rowPos`, `columnPos`, `subject`, `type`, `classes`) VALUES
(1, 0, 1, 0, 0, '\n                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer neque mauris, tristique vel condimentum sed, malesuada ac mi. Nulla pharetra rhoncus ex, sollicitudin hendrerit lacus aliquam at. Ut condimentum viverra turpis, in feugiat nunc tempor sed. Fusce vitae imperdiet quam, sed sollicitudin arcu. Praesent tempor est vel varius congue. Proin neque urna, sollicitudin et nisi sit amet, lobortis euismod mi. Proin vestibulum tortor at pellentesque condimentum. Sed suscipit facilisis enim vel gravida. Nullam ac enim condimentum dolor luctus egestas vel iaculis diam. Vivamus iaculis ut mauris et pellentesque. Nam mattis purus eget turpis ullamcorper condimentum.\n                ', 'majima_wysiwyg', 'col-panel orange white-text'),
(2, 0, 1, 0, 1, '\n                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer neque mauris, tristique vel condimentum sed, malesuada ac mi. Nulla pharetra rhoncus ex, sollicitudin hendrerit lacus aliquam at. Ut condimentum viverra turpis, in feugiat nunc tempor sed. Fusce vitae imperdiet quam, sed sollicitudin arcu. Praesent tempor est vel varius congue. Proin neque urna, sollicitudin et nisi sit amet, lobortis euismod mi. Proin vestibulum tortor at pellentesque condimentum. Sed suscipit facilisis enim vel gravida. Nullam ac enim condimentum dolor luctus egestas vel iaculis diam. Vivamus iaculis ut mauris et pellentesque. Nam mattis purus eget turpis ullamcorper condimentum.\n                ', 'majima_wysiwyg', 'col-panel red white-text'),
(3, 0, 1, 0, 2, '\n                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer neque mauris, tristique vel condimentum sed, malesuada ac mi. Nulla pharetra rhoncus ex, sollicitudin hendrerit lacus aliquam at. Ut condimentum viverra turpis, in feugiat nunc tempor sed. Fusce vitae imperdiet quam, sed sollicitudin arcu. Praesent tempor est vel varius congue. Proin neque urna, sollicitudin et nisi sit amet, lobortis euismod mi. Proin vestibulum tortor at pellentesque condimentum. Sed suscipit facilisis enim vel gravida. Nullam ac enim condimentum dolor luctus egestas vel iaculis diam. Vivamus iaculis ut mauris et pellentesque. Nam mattis purus eget turpis ullamcorper condimentum.\n                ', 'majima_wysiwyg', 'col-panel orange white-text'),
(4, 0, 1, 1, 0, '\n                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer neque mauris, tristique vel condimentum sed, malesuada ac mi. Nulla pharetra rhoncus ex, sollicitudin hendrerit lacus aliquam at. Ut condimentum viverra turpis, in feugiat nunc tempor sed. Fusce vitae imperdiet quam, sed sollicitudin arcu. Praesent tempor est vel varius congue. Proin neque urna, sollicitudin et nisi sit amet, lobortis euismod mi. Proin vestibulum tortor at pellentesque condimentum. Sed suscipit facilisis enim vel gravida. Nullam ac enim condimentum dolor luctus egestas vel iaculis diam. Vivamus iaculis ut mauris et pellentesque. Nam mattis purus eget turpis ullamcorper condimentum.\n                ', 'majima_wysiwyg', 'col-panel red white-text');