<!--
 ______   ______   ______  ______       __    __   __  __   
/\  ___\ /\  __ \ /\  ___\/\  __ \     /\ "-./  \ /\_\_\_\  
\ \ \__ \\ \  __ \\ \  __\\ \  __ \    \ \ \-./\ \\/_/\_\/_ 
 \ \_____\\ \_\ \_\\ \_\   \ \_\ \_\    \ \_\ \ \_\ /\_\/\_\
  \/_____/ \/_/\/_/ \/_/    \/_/\/_/     \/_/  \/_/ \/_/\/_/
 
 Desarrollado por: gafa.mx
-->
<?php
/* CODIGO PARA WP-CONFIG
if( $_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '187.188.119.69' || strpos( $_SERVER['HTTP_HOST'] ,'192.168') !== false || strpos( $_SERVER['HTTP_HOST'] ,'.ngrok.io') !== false ){
	define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'].'/siclo.com');
	define('WP_HOME',    WP_SITEURL);
	define('DESARROLLO', true);
	define('DB_HOST', '187.188.119.69');
	//define('DB_HOST', 'localhost');
}else{
	define('WP_SITEURL', 'https://siclo.com');
	define('WP_HOME',    WP_SITEURL);
	define('DESARROLLO', false);
	define('DB_HOST', 'localhost');
};*/
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title><?php if( is_home() || is_front_page() ){ bloginfo('name'); }else{ wp_title(); };?></title>
    <link rel="icon" href=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Meta SEO -->
    <!-- Meta Facebook -->
    <?php etiquetas_og();?>
    <?php 
        require_once('css/style.php');
        require_once('css/responsive.php');
    ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <?php require_once('js/js.php');?>
    <!-- Comienza WP Head -->
    <?php wp_head();?>
    <!-- Google Analytics -->
</head>
<body <?php body_class("normal negro");?>>