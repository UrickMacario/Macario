<?php
/*FUNCIONES EXCLUSIVAS DE AJAX*/

if( !function_exists('annadir_newsletter') )
{
    function add_newsletter( $mail = false ){
        return NewsletterHelper::Add($mail);
    }
}