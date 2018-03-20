<?php

// change here 
define("path_actual_user", "..");
define("path_actual_admin", "../admin");
if(dirname($_SERVER['PHP_SELF']) != "/"){
	//$folder = dirname($_SERVER['PHP_SELF']) . '/';
}

	$root = ( !empty( $_SERVER['HTTPS'] ) ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] ;
define('ROOT_PATH', $root);
//$predefined_time='09:45';
//$before_birth = 4;	//this is for birth date

/*for selecting the settings values*/	
$select = "SELECT setting_value FROM tbl_setting WHERE setting_name='general_setting' ";
$rec = mysql_query($select);
$row = mysql_fetch_array($rec);
$setting = unserialize($row['setting_value']);

$all_user_ids = array( '25' ); //exclude users to display Hafleave and Fullleave flag in report page based on time settings from admin side


//Define Capabilities for user on pages
global $capabilities;
$capabilities	= array(
							'home' 		=> array( 'add_user' ),
							'request' 	=> array( 'full' ),
							'report' 	=> array( 'full' ),
							'holiday' 	=> array( 'add_holiday' ),
							'tagline' 	=> array( 'full' ),
							'leave_bal' => array( 'add_leave' ),
							'user_bal' 	=> array( 'full' ),
							'settings' 	=> array( 'add_salary_slip', 'view_salary' ),
						);
?>
