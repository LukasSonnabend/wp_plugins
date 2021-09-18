<?php
/**
 *  Functions and definitions for auxin framework
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2021
 * @link       http://averta.net
 */

/*-----------------------------------------------------------------------------------*/
/*  Add your custom functions here -  We recommend you to use "code-snippets" plugin instead
/*  https://wordpress.org/plugins/code-snippets/
/*-----------------------------------------------------------------------------------*/


// your code here

  function myprefix_enqueue_scripts() {
        wp_enqueue_script( 
            'custom-script',
            get_stylesheet_directory_uri() . '/js/custom.js'
        );
           
        global $current_user;
        get_currentuserinfo();
        
        unset($current_user->{"user_login"});
        unset($current_user->{"user_pass"});
        unset($current_user->{"user_url"});
        unset($current_user->{"user_status"});
        
        $email = $current_user->user_email; 
        
        wp_localize_script( 'custom-script', 'php_data', array(
                'data' => __($current_user->data)
            )
        );
  }
  
  add_action('wp_enqueue_scripts', 'myprefix_enqueue_scripts');

/*-----------------------------------------------------------------------------------*/
/*  Init theme framework
/*-----------------------------------------------------------------------------------*/
require( 'auxin/auxin-include/auxin.php' );
/*-----------------------------------------------------------------------------------*/
