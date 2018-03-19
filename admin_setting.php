<?php 

//test best way to add
//ini_set('error_reporting', E_ALL);
//error_reporting(E_ALL);
session_start();
include("../include/connection.php");
include("../include/sitepanel.php");
include("../include/function.php");
session_redirect();

if(check_access('policies'))
{
	$sess_idno=$_SESSION['sess_idno_admin'];
	
	$user_type        = "SELECT userinfo_chk_admin_Flag FROM tbl_userinfo WHERE userinfo_Idno='".$sess_idno."'";
	$user_type_query  = mysql_query($user_type);				
	$check_user		  = mysql_fetch_array($user_type_query);
	
	$poplicy_value =serialize($_POST['policy']);
		
	if(isset($_POST['admin_setting']) && !empty($_POST['admin_setting']) && $_POST['admin_setting']=='Save')
	{
	
		$serializesetting = serialize($_POST['general_setting']);
		$update = "UPDATE tbl_setting SET setting_name='general_setting' ,setting_value='".$serializesetting."' WHERE setting_name='general_setting' ";
		$rec = mysql_query($update);
	
		if($rec)
		{
			$msg = "Settings Saved Successfully";
		}
	
	} ## End if loop
	
	// Change by purvi on 19 feb 2012 for policy page.
	if(isset($_POST['policy_page']) && !empty($_POST['policy_page']) && $_POST['policy_page']=='Save'){
		
		$serializesetting = serialize( $_POST['policy_setting'] );
		
		$update_policy_setting = "UPDATE tbl_setting SET setting_name='policy_setting' ,setting_value='".$serializesetting."' WHERE setting_name='policy_setting' ";
		
		$rec_policy_setting = mysql_query($update_policy_setting);
		
			if( $rec_policy_setting )
			{
				$msg = "Settings Saved Successfully";
			}
		
	}
	
	if(isset($_POST['leave_page']) && !empty($_POST['leave_page']) && $_POST['leave_page']=='Save'){ 
		
		$serializesetting = serialize( $_POST['leave_setting'] );
		
		$update_policy_setting = "UPDATE tbl_setting SET setting_name='leave_setting' ,setting_value='".$serializesetting."' WHERE setting_name='leave_setting' ";
	
		$rec_policy_setting = mysql_query($update_policy_setting);
		
			if( $rec_policy_setting )
			{
				$msg = "Settings Saved Successfully";
			}
		
	}
	
	//Aceess Setting
	if(isset($_POST['access_save']) && !empty($_POST['access_save']) && $_POST['access_save']=='Save')
	{
		$serializesetting = serialize($_POST['access_setting']);
		
		$update = "UPDATE tbl_setting SET setting_name='access_setting' ,setting_value='".$serializesetting."' WHERE setting_name='access_setting' ";
		$rec = mysql_query($update);
	
		if($rec)
		{
			$msg = "Settings Saved Successfully";
		}
	
	}	
	
	//PM Aceess Setting
	if(isset($_POST['pm_access_save']) && !empty($_POST['pm_access_save']) && $_POST['pm_access_save']=='Save')
	{
		//count total records of the field setting_name is 'pm_access_setting' 
		$setting_value    	= "SELECT setting_value FROM tbl_setting where setting_name = 'pm_access_setting' ";
		$count				= mysql_query($setting_value);
		$pm_access_setting  = mysql_num_rows( $count );
		
		$serializesetting = serialize($_POST['pm_access_setting']);
		if( $pm_access_setting == 1 ) {
			$update = "UPDATE tbl_setting SET setting_name='pm_access_setting' ,setting_value='".$serializesetting."' WHERE setting_name='pm_access_setting' ";
			$rec = mysql_query($update);
		
			if($rec)
			{
				$msg = "Settings Saved Successfully";
			}
		}
		else {
			
			$insert = "INSERT INTO tbl_setting ( setting_name, setting_value ) VALUES( 'pm_access_setting' ,'".$serializesetting."' )";
			$rec = mysql_query($insert) or die(mysql_error());
		}
	}
	
	
	$select_policy_setting = "SELECT setting_value FROM tbl_setting WHERE setting_name='policy_setting' ";
	$rec_policy_setting = mysql_query($select_policy_setting);
	$row_policy_setting = mysql_fetch_array($rec_policy_setting);
	$policy_setting = unserialize( $row_policy_setting['setting_value'] );
	
	$select_leave_setting = "SELECT setting_value FROM tbl_setting WHERE setting_name='leave_setting' ";
	$rec_leave_setting = mysql_query($select_leave_setting);
	$row_leave_setting = mysql_fetch_array($rec_leave_setting);
	$leave_setting = unserialize( $row_leave_setting['setting_value'] );
	
	// End changes.
	
	/*for selecting the settings values*/	
	$select = "SELECT setting_value FROM tbl_setting WHERE setting_name='general_setting' ";
	$rec = mysql_query($select);
	$row = mysql_fetch_array($rec);
	$setting = unserialize($row['setting_value']);
	
	
	//fetch access setting
	$select_access_setting = "SELECT setting_value FROM tbl_setting WHERE setting_name='access_setting' ";
	$rec_access_setting = mysql_query($select_access_setting);
	$row_access_setting = mysql_fetch_array($rec_access_setting);
	$access_setting     = unserialize($row_access_setting['setting_value']);

	//fetch PM access setting
	$select_pm_access_setting = "SELECT setting_value FROM tbl_setting WHERE setting_name='pm_access_setting' ";
	$rec_pm_access_setting = mysql_query($select_pm_access_setting);
	$row_pm_access_setting = mysql_fetch_array($rec_pm_access_setting);
	$pm_access_setting     = unserialize($row_pm_access_setting['setting_value']);
	
	
	
	/*For default holidays value*/
	if(empty($setting['holiday_before_day'])) {
		$setting['holiday_before_day'] = 5;
	}

	/*if(empty($setting['holiday1_before_day'])) {
		$setting['holiday1_before_day'] = 5;
	}*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Attendance :: Setting page</title>
	
	<!--css starts here-->
	<link href="../include/style.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo path_actual_user ?>/include/ui-lightness/jquery-ui-1.8.21.custom.css" type="text/css" rel="stylesheet" />
	<!--css ends here-->
	
	<!--js starts here-->
	<script language="javascript" type="text/javascript" src="../includejs/common-js-functions.js"></script>
	<script language="javascript" type="text/javascript" src="../includejs/ajax.js"></script>
	<script language="javascript" type="text/javascript" src="../includejs/jquery-1.8.3.js"></script>
	<script language="javascript" type="text/javascript" src="../includejs/jquery-ui-1.9.2.custom.js"></script>
	<script language="javascript" type="text/javascript" src="../includejs/tabs.js"></script>
	<script type="text/javascript" src="<?php echo path_actual_user ?>/include/ckeditor/ckeditor.js"></script>
	<!--js ends here-->
	
</head>

<body>

<?php
top();
top_menu();
?>

<div id="main-content">
	<div id="middle-portion1">
		<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="navlink">You are here: <a href="admin_welcome.php">Attendance Home</a>&nbsp;&nbsp;<strong>&raquo;</strong>&nbsp;&nbsp;
					Setting page
					</td>
				</tr>
				
				<tr>
					<td><div class="subheader"><h1> &raquo; Setting Page</h1></div></td>
				</tr>
				
				<tr>
					<td class="spacer"></td>
				</tr>
				
  			</table>
	
	
	<?php if(isset($msg)) {
		echo '<div id="sub_id">';
		echo '<div id="setting_div_msg">';
		echo '<span class="ico_success"> '.$msg;
		echo '<input style="float:right;" type="button" class="submitbutton" name="hide" value="Hide" onclick="return hidethis(\'sub_id\')"></span>';	
		echo '</div></div>';
	}
	?>
	
	<?php
	if(isset($_POST['access_save']) && !empty($_POST['access_save']) && $_POST['access_save']=='Save')
	{
		echo '<script>
				$(document).ready(function(){
					$("#tabs li:first-child").removeClass("active");
					$("#tabs li:nth-child(4)").addClass("active");
					$("#tabs-1").css("display","none");
					$("#tabs-4").css("display","block");
				});
			  </script>';
	}
	if(isset($_POST['pm_access_save']) && !empty($_POST['pm_access_save']) && $_POST['pm_access_save']=='Save')
	{
		echo '<script>
				$(document).ready(function(){
					$("#tabs li:first-child").removeClass("active");
					$("#tabs li:nth-child(5)").addClass("active");
					$("#tabs-1").css("display","none");
					$("#tabs-5").css("display","block");
				});
			  </script>';
	}
	
	if(isset($_POST['policy_page']) && !empty($_POST['policy_page']) && $_POST['policy_page']=='Save')
	{
		echo '<script>
				$(document).ready(function(){
					$("#tabs li:first-child").removeClass("active");
					$("#tabs li:nth-child(2)").addClass("active");
					$("#tabs-1").css("display","none");
					$("#tabs-2").css("display","block");
				});
			  </script>';
	}
	
	if(isset($_POST['leave_page']) && !empty($_POST['leave_page']) && $_POST['leave_page']=='Save')
	{
		echo '<script>
				$(document).ready(function(){
					$("#tabs li:first-child").removeClass("active");
					$("#tabs li:nth-child(3)").addClass("active");
					$("#tabs-1").css("display","none");
					$("#tabs-3").css("display","block");
				});
			  </script>';
	}
	?>
	
</div>
<!-- Tabs -->
	<div id="tabs_container">
		<ul id="tabs">
	        <?php if( $check_user['userinfo_chk_admin_Flag'] == 1 ) {?><li><a href="#tabs-1">General Settings</a></li>
	        <li><a href="#tabs-2">Policies</a></li>
	        <li><a href="#tabs-3">Leave Bifurgation</a></li>
	        <li><a href="#tabs-4">Semi Admin Access Settings</a></li>
	        <li><a href="#tabs-5">PM Access Settings</a></li>
	        <?php } else { ?>
	        <li><a href="#tabs-2">Policies</a></li>
	        <li><a href="#tabs-3">Leave Bifurgation</a></li>
	        <?php } ?>
	    </ul>
    </div><!--tabs_container-->
    
<div id="tabs_content_container">
<?php if( $check_user['userinfo_chk_admin_Flag'] == 1 ) {?>
	    <div id="tabs-1" class="tab_content">
	        
	    		<!--general setting start-->
	    		<form name="addsetting" id="addsetting" method="post">
				
				<table width="100%" cellspacing="0" cellpadding="6" class="table">
				
					<tr class="default2">
						<td class="field2" width="22%">Display Morning Tea</td>
						<td><input type="radio" name="general_setting[disp_m_tea]" value="1" <?php if(isset($setting['disp_m_tea']) && $setting['disp_m_tea']=='1') echo "checked" ?> > Show <input type="radio" name="general_setting[disp_m_tea]" value="0" <?php if(isset($setting['disp_m_tea']) && $setting['disp_m_tea']=='0') echo "checked"; elseif (!isset($setting['disp_m_tea'])) echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Display Lunch</td>
						<td><input type="radio" name="general_setting[disp_lunch]" value="1" <?php if(isset($setting['disp_lunch']) && $setting['disp_lunch']=='1') echo "checked"; ?> > Show <input type="radio" name="general_setting[disp_lunch]" value="0" <?php if(isset($setting['disp_lunch']) && $setting['disp_lunch']=='0') echo "checked"; elseif (!isset($setting['disp_lunch'])) echo "checked"; ?> > Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Display Afternoon Tea</td>
						<td><input type="radio" name="general_setting[disp_a_tea]" value="1" <?php if(isset($setting['disp_a_tea']) && $setting['disp_a_tea']=='1') echo "checked"; ?> > Show <input type="radio" name="general_setting[disp_a_tea]" value="0" <?php if(isset($setting['disp_a_tea']) && $setting['disp_a_tea']=='0') echo "checked"; elseif(!isset($setting['disp_a_tea'])) echo "checked"; ?> > Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Display Other Break</td>
						<td><input type="radio" name="general_setting[disp_otherbreak]" value="1" <?php if(isset($setting['disp_otherbreak']) && $setting['disp_otherbreak']=='1') echo "checked"; ?> > Show <input type="radio" name="general_setting[disp_otherbreak]" value="0" <?php if(isset($setting['disp_otherbreak']) && $setting['disp_otherbreak']=='0') echo "checked"; elseif(!isset($setting['disp_otherbreak'])) echo "checked"; ?> > Hide </td>
					</tr>
					
					<tr>
						<td class="field2" width="22%">Holidays Before Days</td>
						<td><input type="text" size="16" name="general_setting[holiday_before_day]" value="<?php echo $setting['holiday_before_day']; ?>" /></td>
					</tr>
					<!-- <tr>
						<td class="field2" width="22%">Holidays1 Before Days</td>
						<td><input type="text" size="16" name="general_setting[holiday_before_day1]" value="<?php //echo $setting['holiday_before_day1']; ?>" /></td>
					</tr> -->
					
					<tr>
						<td class="field2" width="22%">Late Reason Time</td>
						<td><input type="text" size="16" name="general_setting[late_reason_time]" value="<?php echo $setting['late_reason_time']; ?>" />
							<span style="color:#505050">(Note : Supported 24 hours format, i.e. 13:30:00. Blank and 00:00:00 consider as Null)</span>
						</td>
					</tr>
					<tr>
						<td class="field2" width="22%">Before Birthday</td>
						<td><input type="text" size="16" name="general_setting[before_birthday]" value="<?php echo $setting['before_birthday']; ?>" /></td>
					</tr>
					<tr class="default2">
						<td class="field2" width="22%">Display Half/Full Day Leave</td>
						<td><input type="radio" name="general_setting[disp_leave]" value="1" <?php if(isset($setting['disp_leave']) && $setting['disp_leave']=='1') echo "checked" ?> > Show <input type="radio" name="general_setting[disp_leave]" value="0" <?php if(isset($setting['disp_leave']) && $setting['disp_leave']=='0') echo "checked"; elseif (!isset($setting['disp_leave'])) echo "checked"; ?>> Hide </td>
					</tr>
					<tr>
						<td class="field2" width="22%">Half Day Leave Hour</td>
						<td><input type="text" size="16" name="general_setting[half_leave_hour]" value="<?php echo $setting['half_leave_hour']; ?>" />
							<span style="color:#505050">(Note : Supported HH:MM format.)</span>
						</td>
					</tr>
					<tr>
						<td class="field2" width="22%">Full Day Leave Hour</td>
						<td><input type="text" size="16" name="general_setting[full_leave_hour]" value="<?php echo $setting['full_leave_hour']; ?>" />
							<span style="color:#505050">(Note : Supported HH:MM format.)</span>
						</td>
					</tr>
					<tr>
						<td class="field2" width="22%">ESIC No</td>
						<td><input type="text" size="16" name="general_setting[company_esic_no]" value="<?php echo $setting['company_esic_no']; ?>" />
							<span style="color:#505050"></span>
						</td>
					</tr>
					<tr>
						<td class="field2" width="22%">PF No</td>
						<td><input type="text" size="16" name="general_setting[company_pf_no]" value="<?php echo $setting['company_pf_no']; ?>" />
							<span style="color:#505050"></span>
						</td>
					</tr>

					<!-- Added by Worldweb - Kaushik -->
					<tr>
						<td class="field2" width="22%">Display Leave Request Page</td>
						<td><input type="radio" name="general_setting[leave_request]" value="1" <?php if(isset($setting['leave_request']) && $setting['leave_request']=='1') echo "checked" ?> > Show <input type="radio" name="general_setting[leave_request]" value="0" <?php if(isset($setting['leave_request']) && $setting['leave_request']=='0') echo "checked"; elseif (!isset($setting['leave_request'])) echo "checked"; ?>> Hide </td>
					</tr>
					<!-- Added by Worldweb - Kaushik -->

					<!-- Added by Worldweb - Vasant -->
					<tr>
						<td class="field2" width="23%">Display Leave Calendar Page</td>
						<td><input type="radio" name="general_setting[leave_calendar]" value="1" <?php if(isset($setting['leave_calendar']) && $setting['leave_calendar']=='1') echo "checked" ?> > Show <input type="radio" name="general_setting[leave_calendar]" value="0" <?php if(isset($setting['leave_calendar']) && $setting['leave_calendar']=='0') echo "checked"; elseif (!isset($setting['leave_calendar'])) echo "checked"; ?>> Hide </td>
					</tr>
					<!-- End by Worldweb - Vasant -->

					<!-- Added by Worldweb - Bipin -->
					<tr>
						<td class="field2" width="22%">Display Holiday Page</td>
						<td><input type="radio" name="general_setting[leave_holiday]" value="1" <?php if(isset($setting['leave_holiday']) && $setting['leave_holiday']=='1') echo "checked"; ?> > Show <input type="radio" name="general_setting[leave_holiday]" value="0" <?php if(isset($setting['leave_holiday']) && $setting['leave_holiday']=='0') echo "checked"; elseif (!isset($setting['leave_holiday'])) echo "checked"; ?> > Hide </td>
					</tr>

					<!-- <tr>
						<td class="field2" width="22%">Display Holiday1 Page</td>
						<td><input type="radio" name="general_setting[leave_holiday1]" value="1" <?php //if(isset($setting['leave_holiday1']) && $setting['leave_holiday1']=='1') echo "checked"; ?> > Show <input type="radio" name="general_setting[leave_holiday1]" value="0" <?php //if(isset($setting['leave_holiday1']) && $setting['leave_holiday1']=='0') echo "checked"; elseif (!isset($setting['leave_holiday1'])) echo "checked"; ?> > Hide </td>
					</tr> -->
					<!-- End by Worldweb - Bipin -->

					<!-- added by hetal-->
					<tr>
						<td colspan="3" style="padding-left: 30px;"><h2>User Leave Detail</h2></td>
					</tr>
					<tr>
						<td class="field2" width="22%">From Email</td>
						<td><input type="text" size="50" name="general_setting[admin_from_email]" value="<?php echo $setting['admin_from_email']; ?>" /></td>
						
					</tr>
					<tr>
						<td class="field2" width="22%">From Name</td>
						<td><input type="text" size="16" name="general_setting[admin_from_name]" value="<?php echo $setting['admin_from_name']; ?>" /></td>
						
					</tr>
					<tr>
						<td class="field2" width="22%">To Email</td>
						<td><input type="text" size="50" name="general_setting[admin_to_email]" value="<?php echo $setting['admin_to_email']; ?>" />
						<span>Multiple email ids with comma(,) separated</span>
						</td>
						
					</tr>
					<tr>
						<td class="field2" width="22%" style="vertical-align: top">Subject</td>
						<td><input type="text" size="50" name="general_setting[email_subject]" value="<?php echo $setting['email_subject']; ?>" /><br/>
						<span>[from_date] - displays From Leave Start date.</span><br>
						<span>[to_date] - displays To Leave end date.</span><br>
						</td>
					</tr>
					<tr>
						<td class="field2" width="22%">Days</td>
						<td>
						<select name="general_setting[email_day]">              
							<option value="1" <?php if ($setting['email_day'] == "1") echo "selected='selected'"; 
							?> >1</option>
							<option value="2" <?php if ($setting['email_day'] == "2") echo "selected='selected'"; 
							?> >2</option>
							<option value="3" <?php if ($setting['email_day'] == "3") echo "selected='selected'"; 
							?> >3</option>
							<option value="4" <?php if ($setting['email_day'] == "4") echo "selected='selected'"; 
							?> >4</option>
						</select>
						</td>

					</tr>

					<tr>
						<td class="field2" width="22%">Cron URL</td>
						<td><?php echo ROOT_PATH ?>/user_leave_details.php</td>
						
					</tr>
					<!-- <tr>
						<td class="field2" width="22%">Cron URL</td>
						<td>http://dev.worldweb.com/attendance/user_leave_details.php</td>
					</tr> -->
					
					
					<tr>
						<td colspan="3" style="padding-left: 30px;"><h2>User Increment Detail</h2></td>
					</tr>
					<tr>
						<td class="field2" width="22%">From Email</td>
						<td><input type="text" size="50" name="general_setting[admin_inc_from_email]" value="<?php echo $setting['admin_inc_from_email']; ?>" /></td>
						
					</tr>
					<tr>
						<td class="field2" width="22%">From Name</td>
						<td><input type="text" size="16" name="general_setting[admin_inc_from_name]" value="<?php echo $setting['admin_inc_from_name']; ?>" /></td>
						
					</tr>
					<tr>
						<td class="field2" width="22%">To Email</td>
						<td><input type="text" size="50" name="general_setting[admin_inc_to_email]" value="<?php echo $setting['admin_inc_to_email']; ?>" />
						<span>Multiple email ids with comma(,) separated</span>
						</td>
						
					</tr>
					<tr>
						<td class="field2" width="22%" style="vertical-align: top">Subject</td>
						<td><input type="text" size="50" name="general_setting[email_inc_subject]" value="<?php echo $setting['email_inc_subject']; ?>" /><br/>
						<span>[due_month] - displays due month.</span>
						</td>
					</tr>
					<tr>
						<td class="field2" width="22%">Cron URL</td>
						<td><?php echo ROOT_PATH ?>/user_increment_detail.php</td>
					</tr>
					<!-- <tr>
						<td class="field2" width="22%">Cron URL</td>
						<td>http://dev.worldweb.com/attendance/user_increment_detail.php</td>
					</tr> -->
					
					<tr class="default2">
						<td></td>
						<td><input type="submit" value="Save" class="submitbutton" name="admin_setting" />
					    	<input type="reset" value="Reset" class="submitbutton" name="cancel"   />
					    </td>
					</tr>
					
				</table>
				
				</form>
	    		<!--general setting end-->
	    </div> <!-- end tabs-1 -->
<?php }?>    
	    <div id="tabs-2" class="tab_content">
	    	<form name="addpolicy" id="addpolicy" method="post">
				
				<table width="100%" cellspacing="0" cellpadding="6" class="table">
					
					<tr class="default2">
						<td class="field2" width="10%" valign="top">Title</td>
						<td><input type="text" name="policy_setting[title]" value="<?php if ( isset( $policy_setting['title'] ) && $policy_setting['title'] != "" ) { echo $policy_setting['title']; } ?>"></td>
					</tr>
					<tr class="default2">
						<td class="field2" width="10%" valign="top">Content</td>
						<td><textarea class="ckeditor" name="policy_setting[content]"><?php if ( isset( $policy_setting['content'] ) && $policy_setting['content'] != "" ) { echo $policy_setting['content']; } ?></textarea></td>
					</tr>
				  	<tr class="default2">
						<td></td>
						<td><input type="submit" value="Save" class="submitbutton" name="policy_page" />
					    </td>
					</tr>			
				</table>
			</form>  	 		  
	    </div>
	    
	    <div id="tabs-3" class="tab_content">
	    	<form name="addleave" id="addleave" method="post">
				
				<table width="100%" cellspacing="0" cellpadding="6" class="table">
					
					<tr class="default2">
						<td class="field2" width="10%" valign="top">Title</td>
						<td><input type="text" name="leave_setting[title]" value="<?php if ( isset( $leave_setting['title'] ) && $leave_setting['title'] != "" ) { echo $leave_setting['title']; } ?>"></td>
					</tr>
					<tr class="default2">
						<td class="field2" width="10%" valign="top">Content</td>
						<td><textarea class="ckeditor" name="leave_setting[content]"><?php if ( isset( $leave_setting['content'] ) && $leave_setting['content'] != "" ) { echo $leave_setting['content']; } ?></textarea></td>
					</tr>
				  	<tr class="default2">
						<td></td>
						<td><input type="submit" value="Save" class="submitbutton" name="leave_page" />
					    </td>
					</tr>			
				</table>
			</form>  	 		  
	    </div>
	    
<?php if( $check_user['userinfo_chk_admin_Flag'] == 1 ) {?>
	    <div id="tabs-4" class="tab_content">
	        
	    		<!--general setting start-->
	    		<form name="addaccess" id="addaccess" method="post">
				
				<table width="100%" cellspacing="0" cellpadding="6" class="table">
					
					<tr>
						<td class="field2" width="22%"><span class="access_title">Page Access</span></td>
						<td></td>
					</tr>
				
					<tr class="default2">
						<td class="field2" width="22%">Home</td>
						<td><input type="radio" name="access_setting[home]" value="1" <?php if(isset($access_setting['home']) && $access_setting['home']=='1') echo "checked"; elseif (!isset($access_setting['home'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[home]" value="0" <?php if(isset($access_setting['home']) && $access_setting['home']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Bond Policy</td>
						<td><input type="radio" name="access_setting[bond_policy]" value="1" <?php if(isset($access_setting['bond_policy']) && $access_setting['bond_policy']=='1') echo "checked"; elseif (!isset($access_setting['bond_policy'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[bond_policy]" value="0" <?php if(isset($access_setting['home']) && $access_setting['bond_policy']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Requests</td>
						<td><input type="radio" name="access_setting[requests]" value="1" <?php if(isset($access_setting['requests']) && $access_setting['requests']=='1') echo "checked"; elseif (!isset($access_setting['requests'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[requests]" value="0" <?php if(isset($access_setting['requests']) && $access_setting['requests']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Reports</td>
						<td><input type="radio" name="access_setting[reports]" value="1" <?php if(isset($access_setting['reports']) && $access_setting['reports']=='1') echo "checked"; elseif (!isset($access_setting['reports'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[reports]" value="0" <?php if(isset($access_setting['reports']) && $access_setting['reports']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Announcements</td>
						<td><input type="radio" name="access_setting[announcements]" value="1" <?php if(isset($access_setting['announcements']) && $access_setting['announcements']=='1') echo "checked"; elseif (!isset($access_setting['announcements'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[announcements]" value="0" <?php if(isset($access_setting['announcements']) && $access_setting['announcements']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Holidays</td>
						<td><input type="radio" name="access_setting[holidays]" value="1" <?php if(isset($access_setting['holidays']) && $access_setting['holidays']=='1') echo "checked";  elseif (!isset($access_setting['holidays'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[holidays]" value="0" <?php if(isset($access_setting['holidays']) && $access_setting['holidays']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					<tr class="default2">
						<td class="field2" width="22%">Increment</td>
						<td><input type="radio" name="access_setting[increment]" value="1" <?php if(isset($access_setting['increment']) && $access_setting['increment']=='1') echo "checked";  elseif (!isset($access_setting['increment'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[increment]" value="0" <?php if(isset($access_setting['increment']) && $access_setting['increment']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Taglines</td>
						<td><input type="radio" name="access_setting[taglines]" value="1" <?php if(isset($access_setting['taglines']) && $access_setting['taglines']=='1') echo "checked"; elseif (!isset($access_setting['taglines'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[taglines]" value="0" <?php if(isset($access_setting['taglines']) && $access_setting['taglines']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Manage User</td>
						<td><input type="radio" name="access_setting[manage_user]" value="1" <?php if(isset($access_setting['manage_user']) && $access_setting['manage_user']=='1') echo "checked"; elseif (!isset($access_setting['manage_user'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[manage_user]" value="0" <?php if(isset($access_setting['manage_user']) && $access_setting['manage_user']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Leave Balance</td>
						<td><input type="radio" name="access_setting[leave_balance]" value="1" <?php if(isset($access_setting['leave_balance']) && $access_setting['leave_balance']=='1') echo "checked"; elseif (!isset($access_setting['leave_balance'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[leave_balance]" value="0" <?php if(isset($access_setting['leave_balance']) && $access_setting['leave_balance']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">User Balance</td>
						<td><input type="radio" name="access_setting[user_balance]" value="1" <?php if(isset($access_setting['user_balance']) && $access_setting['user_balance']=='1') echo "checked"; elseif (!isset($access_setting['user_balance'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[user_balance]" value="0" <?php if(isset($access_setting['user_balance']) && $access_setting['user_balance']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					<!-- Added By Bipin -->
					<tr class="default2">
						<td class="field2" width="22%">Leave Request</td>
						<td><input type="radio" name="access_setting[leave_request]" value="1" <?php if(isset($access_setting['leave_request']) && $access_setting['leave_request']=='1') echo "checked"; elseif (!isset($access_setting['leave_request'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[leave_request]" value="0" <?php if(isset($access_setting['leave_request']) && $access_setting['leave_request']=='0') echo "checked"; ?>> Hide </td>
					</tr>

					<tr class="default2">
						<td class="field2" width="22%">Leave Calendar</td>
						<td><input type="radio" name="access_setting[leave_calendar]" value="1" <?php if(isset($access_setting['leave_calendar']) && $access_setting['leave_calendar']=='1') echo "checked"; elseif (!isset($access_setting['leave_calendar'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[leave_calendar]" value="0" <?php if(isset($access_setting['leave_calendar']) && $access_setting['leave_calendar']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					<!-- Ended By Bipin -->					
					<tr class="default2">
						<td class="field2" width="22%">Manage Salary</td>
						<td><input type="radio" name="access_setting[manage_salary]" value="1" <?php if(isset($access_setting['manage_salary']) && $access_setting['manage_salary']=='1') echo "checked"; elseif (!isset($access_setting['manage_salary'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[manage_salary]" value="0" <?php if(isset($access_setting['manage_salary']) && $access_setting['manage_salary']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">View Salary</td>
						<td><input type="radio" name="access_setting[view_salary]" value="1" <?php if(isset($access_setting['view_salary']) && $access_setting['view_salary']=='1') echo "checked"; elseif (!isset($access_setting['view_salary'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[view_salary]" value="0" <?php if(isset($access_setting['view_salary']) && $access_setting['view_salary']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Reset Password</td>
						<td><input type="radio" name="access_setting[reset_password]" value="1" <?php if(isset($access_setting['reset_password']) && $access_setting['reset_password']=='1') echo "checked"; elseif (!isset($access_setting['reset_password'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[reset_password]" value="0" <?php if(isset($access_setting['reset_password']) && $access_setting['reset_password']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Policies</td>
						<td><input type="radio" name="access_setting[policies]" value="1" <?php if(isset($access_setting['policies']) && $access_setting['policies']=='1') echo "checked"; elseif (!isset($access_setting['policies'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[policies]" value="0" <?php if(isset($access_setting['policies']) && $access_setting['policies']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Import/Export</td>
						<td><input type="radio" name="access_setting[import_export]" value="1" <?php if(isset($access_setting['import_export']) && $access_setting['import_export']=='1') echo "checked"; elseif (!isset($access_setting['import_export'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[import_export]" value="0" <?php if(isset($access_setting['import_export']) && $access_setting['import_export']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default3"></tr>
					
					<tr>
						<td class="field2" width="22%"><span class="access_title">Edit Access</span></td>
						<td></td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Home</td>
						<td><input type="radio" name="access_setting[edit_home]" value="1" <?php if(isset($access_setting['edit_home']) && $access_setting['edit_home']=='1') echo "checked"; elseif (!isset($access_setting['edit_home'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[edit_home]" value="0" <?php if(isset($access_setting['edit_home']) && $access_setting['edit_home']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					<tr class="default2">
						<td class="field2" width="22%">Announcements</td>
						<td><input type="radio" name="access_setting[edit_announcements]" value="1" <?php if(isset($access_setting['edit_announcements']) && $access_setting['edit_announcements']=='1') echo "checked"; elseif (!isset($access_setting['edit_announcements'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[edit_announcements]" value="0" <?php if(isset($access_setting['edit_announcements']) && $access_setting['edit_announcements']=='0') echo "checked"; ?>> Hide </td>
					</tr>

					<tr class="default2">
						<td class="field2" width="22%">Holidays</td>
						<td><input type="radio" name="access_setting[edit_holidays]" value="1" <?php if(isset($access_setting['edit_holidays']) && $access_setting['edit_holidays']=='1') echo "checked"; elseif (!isset($access_setting['edit_holidays'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[edit_holidays]" value="0" <?php if(isset($access_setting['edit_holidays']) && $access_setting['edit_holidays']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					<tr class="default2">
						<td class="field2" width="22%">Increment</td>
						<td><input type="radio" name="access_setting[edit_increment]" value="1" <?php if(isset($access_setting['edit_increment']) && $access_setting['edit_increment']=='1') echo "checked"; elseif (!isset($access_setting['edit_increment'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[edit_increment]" value="0" <?php if(isset($access_setting['edit_increment']) && $access_setting['edit_increment']=='0') echo "checked"; ?>> Hide </td>
					</tr>

					<tr class="default2">
						<td class="field2" width="22%">Leave Balance</td>
						<td><input type="radio" name="access_setting[edit_leave_balance]" value="1" <?php if(isset($access_setting['edit_leave_balance']) && $access_setting['edit_leave_balance']=='1') echo "checked"; elseif (!isset($access_setting['edit_leave_balance'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[edit_leave_balance]" value="0" <?php if(isset($access_setting['edit_leave_balance']) && $access_setting['edit_leave_balance']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Manage Salary</td>
						<td><input type="radio" name="access_setting[edit_manage_salary]" value="1" <?php if(isset($access_setting['edit_manage_salary']) && $access_setting['edit_manage_salary']=='1') echo "checked"; elseif (!isset($access_setting['edit_manage_salary'])) echo "checked"; ?> > Show <input type="radio" name="access_setting[edit_manage_salary]" value="0" <?php if(isset($access_setting['edit_manage_salary']) && $access_setting['edit_manage_salary']=='0') echo "checked"; ?>> Hide </td>
					</tr>

					<tr class="default2">
						<td></td>
						<td><input type="submit" value="Save" class="submitbutton" name="access_save" />
					    	<input type="reset" value="Reset" class="submitbutton" name="cancel"   />
					    </td>
					</tr>
					
				</table>
				
				</form>
	    		<!--Access setting end-->
	    </div> <!-- end tabs-4 -->
<?php } ?>
<?php if( $check_user['userinfo_chk_admin_Flag'] == 1 ) {?>
	    <div id="tabs-5" class="tab_content">
	        
	    		<!--general setting start-->
	    		<form name="addaccess" id="addaccess" method="post">
				
				<table width="100%" cellspacing="0" cellpadding="6" class="table">
					
					<tr>
						<td class="field2" width="22%"><span class="access_title">Page Access</span></td>
						<td></td>
					</tr>
				
					<tr class="default2">
						<td class="field2" width="22%">Home</td>
						<td><input type="radio" name="pm_access_setting[home]" value="1" <?php if(isset($pm_access_setting['home']) && $pm_access_setting['home']=='1') echo "checked"; elseif (!isset($pm_access_setting['home'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[home]" value="0" <?php if(isset($pm_access_setting['home']) && $pm_access_setting['home']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Bond Policy</td>
						<td><input type="radio" name="pm_access_setting[bond_policy]" value="1" <?php if(isset($pm_access_setting['bond_policy']) && $pm_access_setting['bond_policy']=='1') echo "checked"; elseif (!isset($pm_access_setting['bond_policy'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[bond_policy]" value="0" <?php if(isset($pm_access_setting['home']) && $pm_access_setting['bond_policy']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Requests</td>
						<td><input type="radio" name="pm_access_setting[requests]" value="1" <?php if(isset($pm_access_setting['requests']) && $pm_access_setting['requests']=='1') echo "checked"; elseif (!isset($pm_access_setting['requests'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[requests]" value="0" <?php if(isset($pm_access_setting['requests']) && $pm_access_setting['requests']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Reports</td>
						<td><input type="radio" name="pm_access_setting[reports]" value="1" <?php if(isset($pm_access_setting['reports']) && $pm_access_setting['reports']=='1') echo "checked"; elseif (!isset($pm_access_setting['reports'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[reports]" value="0" <?php if(isset($pm_access_setting['reports']) && $pm_access_setting['reports']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Announcements</td>
						<td><input type="radio" name="pm_access_setting[announcements]" value="1" <?php if(isset($pm_access_setting['announcements']) && $pm_access_setting['announcements']=='1') echo "checked"; elseif (!isset($pm_access_setting['announcements'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[announcements]" value="0" <?php if(isset($pm_access_setting['announcements']) && $pm_access_setting['announcements']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Holidays</td>
						<td><input type="radio" name="pm_access_setting[holidays]" value="1" <?php if(isset($pm_access_setting['holidays']) && $pm_access_setting['holidays']=='1') echo "checked";  elseif (!isset($pm_access_setting['holidays'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[holidays]" value="0" <?php if(isset($pm_access_setting['holidays']) && $pm_access_setting['holidays']=='0') echo "checked"; ?>> Hide </td>
					</tr>

					<tr class="default2">
						<td class="field2" width="22%">Increment</td>
						<td><input type="radio" name="pm_access_setting[increment]" value="1" <?php if(isset($pm_access_setting['increment']) && $pm_access_setting['increment']=='1') echo "checked";  elseif (!isset($pm_access_setting['increment'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[increment]" value="0" <?php if(isset($pm_access_setting['increment']) && $pm_access_setting['increment']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Taglines</td>
						<td><input type="radio" name="pm_access_setting[taglines]" value="1" <?php if(isset($pm_access_setting['taglines']) && $pm_access_setting['taglines']=='1') echo "checked"; elseif (!isset($pm_access_setting['taglines'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[taglines]" value="0" <?php if(isset($pm_access_setting['taglines']) && $pm_access_setting['taglines']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Manage User</td>
						<td><input type="radio" name="pm_access_setting[manage_user]" value="1" <?php if(isset($pm_access_setting['manage_user']) && $pm_access_setting['manage_user']=='1') echo "checked"; elseif (!isset($pm_access_setting['manage_user'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[manage_user]" value="0" <?php if(isset($pm_access_setting['manage_user']) && $pm_access_setting['manage_user']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Leave Balance</td>
						<td><input type="radio" name="pm_access_setting[leave_balance]" value="1" <?php if(isset($pm_access_setting['leave_balance']) && $pm_access_setting['leave_balance']=='1') echo "checked"; elseif (!isset($pm_access_setting['leave_balance'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[leave_balance]" value="0" <?php if(isset($pm_access_setting['leave_balance']) && $pm_access_setting['leave_balance']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">User Balance</td>
						<td><input type="radio" name="pm_access_setting[user_balance]" value="1" <?php if(isset($pm_access_setting['user_balance']) && $pm_access_setting['user_balance']=='1') echo "checked"; elseif (!isset($pm_access_setting['user_balance'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[user_balance]" value="0" <?php if(isset($pm_access_setting['user_balance']) && $pm_access_setting['user_balance']=='0') echo "checked"; ?>> Hide </td>
					</tr>

					<!-- Added By WorldWeb Bipin -->
					<tr class="default2">
						<td class="field2" width="22%">Leave Request</td>
						<td><input type="radio" name="pm_access_setting[leave_request]" value="1" <?php if(isset($pm_access_setting['leave_request']) && $pm_access_setting['leave_request']=='1') echo "checked"; elseif (!isset($pm_access_setting['leave_request'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[leave_request]" value="0" <?php if(isset($pm_access_setting['leave_request']) && $pm_access_setting['leave_request']=='0') echo "checked"; ?>> Hide </td>
					</tr>

					<tr class="default2">
						<td class="field2" width="22%">Leave Calendar</td>
						<td><input type="radio" name="pm_access_setting[leave_calendar]" value="1" <?php if(isset($pm_access_setting['leave_calendar']) && $pm_access_setting['leave_calendar']=='1') echo "checked"; elseif (!isset($pm_access_setting['leave_calendar'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[leave_calendar]" value="0" <?php if(isset($pm_access_setting['leave_calendar']) && $pm_access_setting['leave_calendar']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					<!-- Eended By WorldWeb Bipin -->
					
					<tr class="default2">
						<td class="field2" width="22%">Manage Salary</td>
						<td><input type="radio" name="pm_access_setting[manage_salary]" value="1" <?php if(isset($pm_access_setting['manage_salary']) && $pm_access_setting['manage_salary']=='1') echo "checked"; elseif (!isset($pm_access_setting['manage_salary'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[manage_salary]" value="0" <?php if(isset($pm_access_setting['manage_salary']) && $pm_access_setting['manage_salary']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">View Salary</td>
						<td><input type="radio" name="pm_access_setting[view_salary]" value="1" <?php if(isset($pm_access_setting['view_salary']) && $pm_access_setting['view_salary']=='1') echo "checked"; elseif (!isset($pm_access_setting['view_salary'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[view_salary]" value="0" <?php if(isset($pm_access_setting['view_salary']) && $pm_access_setting['view_salary']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Reset Password</td>
						<td><input type="radio" name="pm_access_setting[reset_password]" value="1" <?php if(isset($pm_access_setting['reset_password']) && $pm_access_setting['reset_password']=='1') echo "checked"; elseif (!isset($pm_access_setting['reset_password'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[reset_password]" value="0" <?php if(isset($pm_access_setting['reset_password']) && $pm_access_setting['reset_password']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Policies</td>
						<td><input type="radio" name="pm_access_setting[policies]" value="1" <?php if(isset($pm_access_setting['policies']) && $pm_access_setting['policies']=='1') echo "checked"; elseif (!isset($pm_access_setting['policies'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[policies]" value="0" <?php if(isset($pm_access_setting['policies']) && $pm_access_setting['policies']=='0') echo "checked"; ?>> Hide </td>
					</tr>
										
					<tr class="default2">
						<td class="field2" width="22%">Import/Export</td>
						<td><input type="radio" name="pm_access_setting[import_export]" value="1" <?php if(isset($pm_access_setting['import_export']) && $pm_access_setting['import_export']=='1') echo "checked"; elseif (!isset($pm_access_setting['import_export'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[import_export]" value="0" <?php if(isset($pm_access_setting['import_export']) && $pm_access_setting['import_export']=='0') echo "checked"; ?>> Hide </td>
					</tr>

					<tr class="default3"></tr>
					
					<tr>
						<td class="field2" width="22%"><span class="access_title">Edit Access</span></td>
						<td></td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Home</td>
						<td><input type="radio" name="pm_access_setting[edit_home]" value="1" <?php if(isset($pm_access_setting['edit_home']) && $pm_access_setting['edit_home']=='1') echo "checked"; elseif (!isset($pm_access_setting['edit_home'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[edit_home]" value="0" <?php if(isset($pm_access_setting['edit_home']) && $pm_access_setting['edit_home']=='0') echo "checked"; ?>> Hide </td>
					</tr>

					<tr class="default2">
						<td class="field2" width="22%">Announcements</td>
						<td><input type="radio" name="pm_access_setting[edit_announcements]" value="1" <?php if(isset($pm_access_setting['edit_announcements']) && $pm_access_setting['edit_announcements']=='1') echo "checked"; elseif (!isset($pm_access_setting['edit_announcements'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[edit_announcements]" value="0" <?php if(isset($pm_access_setting['edit_announcements']) && $pm_access_setting['edit_announcements']=='0') echo "checked"; ?>> Hide </td>
					</tr>

					<tr class="default2">
						<td class="field2" width="22%">Holidays</td>
						<td><input type="radio" name="pm_access_setting[edit_holidays]" value="1" <?php if(isset($pm_access_setting['edit_holidays']) && $pm_access_setting['edit_holidays']=='1') echo "checked"; elseif (!isset($pm_access_setting['edit_holidays'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[edit_holidays]" value="0" <?php if(isset($pm_access_setting['edit_holidays']) && $pm_access_setting['edit_holidays']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					<tr class="default2">
						<td class="field2" width="22%">Increment</td>
						<td><input type="radio" name="pm_access_setting[edit_increment]" value="1" <?php if(isset($pm_access_setting['edit_increment']) && $pm_access_setting['edit_increment']=='1') echo "checked"; elseif (!isset($pm_access_setting['edit_increment'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[edit_increment]" value="0" <?php if(isset($pm_access_setting['edit_increment']) && $pm_access_setting['edit_increment']=='0') echo "checked"; ?>> Hide </td>
					</tr>

					<tr class="default2">
						<td class="field2" width="22%">Leave Balance</td>
						<td><input type="radio" name="pm_access_setting[edit_leave_balance]" value="1" <?php if(isset($pm_access_setting['edit_leave_balance']) && $pm_access_setting['edit_leave_balance']=='1') echo "checked"; elseif (!isset($pm_access_setting['edit_leave_balance'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[edit_leave_balance]" value="0" <?php if(isset($pm_access_setting['edit_leave_balance']) && $pm_access_setting['edit_leave_balance']=='0') echo "checked"; ?>> Hide </td>
					</tr>
					
					<tr class="default2">
						<td class="field2" width="22%">Manage Salary</td>
						<td><input type="radio" name="pm_access_setting[edit_manage_salary]" value="1" <?php if(isset($pm_access_setting['edit_manage_salary']) && $pm_access_setting['edit_manage_salary']=='1') echo "checked"; elseif (!isset($pm_access_setting['edit_manage_salary'])) echo "checked"; ?> > Show <input type="radio" name="pm_access_setting[edit_manage_salary]" value="0" <?php if(isset($pm_access_setting['edit_manage_salary']) && $pm_access_setting['edit_manage_salary']=='0') echo "checked"; ?>> Hide </td>
					</tr>

					<tr class="default2">
						<td></td>
						<td><input type="submit" value="Save" class="submitbutton" name="pm_access_save" />
					    	<input type="reset" value="Reset" class="submitbutton" name="cancel"   />
					    </td>
					</tr>
					
				</table>
				
				</form>
	    		<!--Access setting end-->
	    </div> <!-- end tabs-5 -->
<?php } ?>
	</div><!--tabs_content_container-->
<!-- Tabs -->
		
	</div><!--middle-portion1-->
</div><!--main-content-->

<?php 
 right();
 footer();
 connection_close(); 
?>

</body>
</html>

<?php
}
else
{
	invalid_access();
}
?>
