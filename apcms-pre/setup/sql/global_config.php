<?php
@ob_flush();



$query1 = "DROP TABLE IF EXISTS `".$_SESSION['form']['prefix']."global_config`";
$db->unbuffered_query($query1);


$query2 = "CREATE TABLE IF NOT EXISTS `".$_SESSION['form']['prefix']."global_config` (
  `title` varchar(128) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `sesslifetime` int(6) NOT NULL,
  `emailfrom` varchar(128) NOT NULL,
  `emailadress` varchar(128) NOT NULL
) DEFAULT CHARSET=utf8";
$db->unbuffered_query($query2);


$query3 = "INSERT INTO `".$_SESSION['form']['prefix']."global_config` (`title`, `subtitle`, `description`, `sesslifetime`, `emailfrom`, `emailadress`) VALUES ('My Page', 'My personal page', 'This is my personal page which I\'ve created to be online.', 3600, 'My Page', 'email@example.com')";
$db->unbuffered_query($query3);




















@ob_flush();
?>