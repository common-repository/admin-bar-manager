<?php
/*
Plugin Name: Admin Bar Manager
Plugin URI: http://www.soji.in
Description: Provides An Option To Hide Admin Bar For All/Non Admin Users
Version: 1.0
Author: Soji Jacob
Author URI: http://www.soji.in
*/
/*
	Copyright 2016
	Licensed under the GPLv2 license: http://www.gnu.org/licenses/gpl-2.0.html
*/

function soji_admin_bar_settings()
{
?>
	<style type="text/css">
		.show-admin-bar {
			display: none;
		}
	</style>
<?php
}

function adminbarmanage()
{
    $barvalue = get_option( 'admin-bar-radio' );
	if($barvalue == 1){
		add_filter( 'show_admin_bar', '__return_false' );
		add_action( 'admin_print_scripts-profile.php', 'soji_admin_bar_settings' );
	}
	else if (!current_user_can('administrator') && $barvalue == 2) {
	    add_filter( 'show_admin_bar', '__return_false' );
		add_action( 'admin_print_scripts-profile.php', 'soji_admin_bar_settings' );
		}
}


function adminbar_create_menu() {

	//create new top-level menu
	add_options_page('Admin Bar Manager', 'Admin Bar Manager', 'manage_options', 'adminbarmanager', 'adminbarpage' );

	//call register settings function
	add_action( 'admin_init', 'adminbar_register' );
}


function adminbar_register() {
	//register our settings
	
	add_settings_section("admin-bar-settings", "Main Settings", null,  "adminbarmanager");
	add_settings_field("admin-bar-radio", "Hide Admin Bar From", "adminbarsettingradio", "adminbarmanager", "admin-bar-settings");
	register_setting( "admin-bar-settings", "admin-bar-radio" );
}

function adminbarsettingradio() {
?>

        <input type="radio" name="admin-bar-radio" value="1" <?php checked(1, get_option('admin-bar-radio'), true); ?>> For All<br>
        <input type="radio" name="admin-bar-radio" value="2" <?php checked(2, get_option('admin-bar-radio'), true); ?>> Only From Non-Admins
   <?php
}

function adminbarpage() {
?>
<div class="wrap">
<h1>Hide Admin Bar</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'admin-bar-settings' ); ?>
    <?php do_settings_sections( 'adminbarmanager' ); ?>
   
    
    <?php submit_button(); ?>

</form>
</div>
<?php }


add_action('init', 'adminbarmanage');

 
add_action('admin_menu', 'adminbar_create_menu');

?>