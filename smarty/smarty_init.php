<?php
// load Smarty library
require_once('Smarty.class.php');
$smarty = new Smarty;
$smarty->left_delimiter = '{{';
$smarty->right_delimiter = '}}';
$smarty->template_dir = 'C:/xampp/htdocs/shopping/smarty/templates';
$smarty->config_dir = 'C:/xampp/htdocs/shopping/smarty/config';
$smarty->cache_dir = 'C:/xampp/smarty/cache';
$smarty->compile_dir = 'C:/xampp/smarty/templates_c';


// $smarty->template_dir = 'D:/install2/XAMPP/htdocs/shopping/smarty/templates';
// $smarty->config_dir = 'D:/install2/XAMPP/htdocs/shopping/smarty/config';
// $smarty->cache_dir = 'D:/install2/XAMPP/smarty/cache';
// $smarty->compile_dir = 'D:/install2/XAMPP/smarty/templates_c';