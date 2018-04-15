<?php
global $colores,$tamanos;

if( isset( $_POST['ajax_gafa'] ) ){
	require_once('procesos/ajax.php');
};
/*COLORES*/
define( 'GRIS',	'silver' );
define( 'NEGRO','black' );
define( 'BLANCO','white' );

$colores = array(
	'gris'	=> GRIS,
	'negro'	=> NEGRO,
	'blanco'=> BLANCO,
);

$tamanos = array(
	'normal'	=> '12px',
);
/*CLASES*/
require_once('classes/inicio.php');


function compatible( $string = '' ){
	$c = array(
		'',
		'-moz-',
		'-ms-',
		'-o-',
		'-webkit-',
	);
	foreach( $c as $x ){
		echo $x.$string;
	};
};
/*FUNCIONES CON POSTS*/
if( !function_exists('crear') ){
	function crear( $post_type = false, $usuario = false, $fecha = false ){
		if( !$post_type ){ return; };
		if( !$usuario ){
			global $current_user;
			$usuario = $current_user->ID;
		};
		$post_nuevo = array(
			'post_title'	=> '',
			'post_status'	=> 'publish',
			'post_author'	=> $usuario,
			'post_type'		=> $post_type,
		);
		if( $fecha ){
			$post_nuevo['post_date'] = $fecha;
		};
		
		return  wp_insert_post( $post_nuevo );
	};
};
if( !function_exists('actualizar_nombre') ){
	function actualizar_nombre( $id_post = false, $nombre = false ){
		if( !$id_post || !$nombre ){ return; };
		return  wp_update_post(array(
			'post_title'	=> $nombre,
			'ID'			=> $id_post,
		));
	};
};
if( !function_exists('actualizar_status') ){
	function actualizar_status( $id_post = false, $post_status = false ){
		if( !$id_post || !$post_status ){ return; };
		return  wp_update_post(array(
			'post_status'	=> $post_status,
			'ID'			=> $id_post,
		));
	};
};
if( !function_exists('actualizar_fecha') ){
	function actualizar_fecha( $id_post = false, $fecha = false ){
		if( !$id_post || !$fecha ){ return; };
		return  wp_update_post(array(
			'post_date'		=> $fecha,
			'ID'			=> $id_post,
		));
	};
};
if( !function_exists('actualizar_contenido') ){
	function actualizar_contenido( $id_post = false, $txt = false ){
		if( !$id_post || !$txt ){ return; };
		return  wp_update_post(array(
			'post_content'		=> $txt,
			'ID'			=> $id_post,
		));
	};
};
if( !function_exists('eliminar') ){
	function eliminar( $id_post = false ){
		if( !$id_post ){ return; };
		return  wp_delete_post( $id_post, true );
	};
};


?>