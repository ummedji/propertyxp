<?php
/*
Plugin Name: Custom Share Buttons with Floating Sidebar
Plugin URI: http://www.mrwebsolution.in/
Description: It's a very simple plugin for add to social share buttons on your site and you can publish buttons floating sidebar. Even you can edit share buttons if you wish
Author: MR Web Solution
Author URI: http://raghunathgurjar.wordpress.com
Version: 2.6
*/

/*  Copyright 2015  custom-share-buttons-with-floating-sidebar  (email : raghunath.0087@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Admin "Custom Share Buttons with Floating Sidebar" Menu Item
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_action('admin_menu','csbwf_sidebar_menu');
if(!function_exists('csbwf_sidebar_menu')){
function csbwf_sidebar_menu(){

	add_options_page('Custom Share Buttons With Floating Sidebar','Custom Share Buttons With Floating Sidebar','manage_options','csbwfs-settings','csbwf_sidebar_admin_option_page');

}
}

//Define Action for register "Custom Share Buttons with Floating Sidebar" Options
add_action('admin_init','csbwf_sidebar_init');

if(!function_exists('csbwf_sidebar_init')):
//Register "Custom Share Buttons with Floating Sidebar" options
function csbwf_sidebar_init(){

	register_setting('csbwf_sidebar_options','csbwfs_active');
	register_setting('csbwf_sidebar_options','csbwfs_position');
	register_setting('csbwf_sidebar_options','csbwfs_btn_position');
	register_setting('csbwf_sidebar_options','csbwfs_btn_text');
	register_setting('csbwf_sidebar_options','csbwfs_fb_image');
	register_setting('csbwf_sidebar_options','csbwfs_tw_image');
	register_setting('csbwf_sidebar_options','csbwfs_li_image');	
	register_setting('csbwf_sidebar_options','csbwfs_re_image');	
	register_setting('csbwf_sidebar_options','csbwfs_st_image');	
	register_setting('csbwf_sidebar_options','csbwfs_mail_image');	
	register_setting('csbwf_sidebar_options','csbwfs_gp_image');	
	register_setting('csbwf_sidebar_options','csbwfs_pin_image');
	register_setting('csbwf_sidebar_options','csbwfs_yt_image');	
	register_setting('csbwf_sidebar_options','csbwfs_fb_bg');
	register_setting('csbwf_sidebar_options','csbwfs_tw_bg');
	register_setting('csbwf_sidebar_options','csbwfs_li_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_mail_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_gp_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_pin_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_re_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_st_bg');
	register_setting('csbwf_sidebar_options','csbwfs_yt_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_fpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_tpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_gpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_ppublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_ytpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_republishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_stpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_ytPath');	
	register_setting('csbwf_sidebar_options','csbwfs_lpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_mpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_mailMessage');
	register_setting('csbwf_sidebar_options','csbwfs_top_margin');
	register_setting('csbwf_sidebar_options','csbwfs_delayTimeBtn');
	register_setting('csbwf_sidebar_options','csbwfs_btn_display');
	/** Image Alt */
	register_setting('csbwf_sidebar_options','csbwfs_fb_title');
	register_setting('csbwf_sidebar_options','csbwfs_tw_title');
	register_setting('csbwf_sidebar_options','csbwfs_li_title');
	register_setting('csbwf_sidebar_options','csbwfs_pin_title');
	register_setting('csbwf_sidebar_options','csbwfs_gp_title');
	register_setting('csbwf_sidebar_options','csbwfs_mail_title');
	register_setting('csbwf_sidebar_options','csbwfs_yt_title');
	register_setting('csbwf_sidebar_options','csbwfs_re_title');
	register_setting('csbwf_sidebar_options','csbwfs_st_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_fb_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_tw_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_li_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_pin_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_gp_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_mail_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_yt_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_re_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_st_title');
	register_setting('csbwf_sidebar_options','csbwfs_auto_hide');
	//Options for post/pages
	register_setting('csbwf_sidebar_options','csbwfs_buttons_active');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_home');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_post');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_page');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_archive');
	register_setting('csbwf_sidebar_options','csbwfs_hide_home');
	register_setting('csbwf_sidebar_options','csbwfs_page_fb_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_tw_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_li_image');	
	register_setting('csbwf_sidebar_options','csbwfs_page_mail_image');	
	register_setting('csbwf_sidebar_options','csbwfs_page_gp_image');	
	register_setting('csbwf_sidebar_options','csbwfs_page_pin_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_re_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_st_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_yt_image');
	/** message content */	
	register_setting('csbwf_sidebar_options','csbwfs_show_btn');	
	register_setting('csbwf_sidebar_options','csbwfs_hide_btn');	
	register_setting('csbwf_sidebar_options','csbwfs_share_msg');
	register_setting('csbwf_sidebar_options','csbwfs_rmSHBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_featuredshrimg');	
	register_setting('csbwf_sidebar_options','csbwfs_defaultfeaturedshrimg');
	register_setting('csbwf_sidebar_options','csbwfs_deactive_for_mob');	
	
} 

endif;

if(!function_exists('csbwfs_add_settings_link')):
// Add settings link to plugin list page in admin
        function csbwfs_add_settings_link( $links ) {
            $settings_link = '<a href="options-general.php?page=csbwfs-settings">' . __( 'Settings', 'csbwfs' ) . '</a>';
            array_unshift( $links, $settings_link );
            return $links;
        }
endif;
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'csbwfs_add_settings_link' );


if (isset($_GET['page']) && $_GET['page'] == 'csbwfs-settings') {
if(!function_exists('add_csbwfs_admin_style_script')):
function add_csbwfs_admin_style_script()
{
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('csbwfs-image-upload', plugins_url('/js/csbwfs.js',__FILE__ ), array('jquery','media-upload','thickbox','wp-color-picker'));
    wp_enqueue_script('csbwfs-image-upload');
    
}	
endif;

function csbwfs_admin_styles() {
wp_register_style( 'csbwf_admin_style', plugins_url( 'css/admin-csbwfs.css',__FILE__ ) );
wp_enqueue_style( 'csbwf_admin_style' );
wp_enqueue_style( 'wp-color-picker' ); 
wp_enqueue_style('thickbox');
}

// better use get_current_screen(); or the global $current_screen

    add_action('admin_print_styles', 'csbwfs_admin_styles');
    add_action('admin_footer','add_csbwfs_admin_style_script');
}

/** Display the Options form for CSBWFS */
if(!function_exists('csbwf_sidebar_admin_option_page')):
function csbwf_sidebar_admin_option_page(){ ?>

	<div style="width: 80%; padding: 10px; margin: 10px;"> 

	<h1>Custom Share Buttons With Floating Sidebar Settings</h1>
<!-- Start Options Form -->

	<form action="options.php" method="post" id="csbwf-sidebar-admin-form">
		
	<div id="csbwf-tab-menu"><a id="csbwfs-general" class="csbwf-tab-links active" >General</a> <a  id="csbwfs-sidebar" class="csbwf-tab-links">Floating Sidebar</a> <a  id="csbwfs-share-buttons" class="csbwf-tab-links">Social Share Buttons</a> <a  id="csbwfs-support" class="csbwf-tab-links">Support</a> <a  id="csbwfs-pro" class="csbwf-tab-links">GO PRO</a> </div>

	<div class="csbwfs-setting">
	<!-- General Setting -->	
	<div class="first csbwfs-tab" id="div-csbwfs-general">
	<h2>General Settings</h2>
    <p><input type="checkbox" id="csbwfs_active" name="csbwfs_active" value='1' <?php if(get_option('csbwfs_active')!=''){ echo ' checked="checked"'; }?>/> <b><?php _e('Enable Sidebar');?> </b></p>

	<p><h3><strong><?php _e('Social Share Button Publish Options:','csbwfs');?></strong></h3></p>
	<p><input type="checkbox" id="publish1" value="yes" name="csbwfs_fpublishBtn" <?php if(get_option('csbwfs_fpublishBtn')=='yes'){echo 'checked="checked"';}?>/><b>Facebook Button</b></p>
				<p><input type="checkbox" id="publish2" name="csbwfs_tpublishBtn" value="yes" <?php if(get_option('csbwfs_tpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Twitter Button</b></p>
				<p><input type="checkbox" id="publish3" name="csbwfs_gpublishBtn" value="yes" <?php if(get_option('csbwfs_gpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Google Button</b></p>
				<p><input type="checkbox" id="publish4" name="csbwfs_lpublishBtn" value="yes" <?php if(get_option('csbwfs_lpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Linkedin Button</b></p>
				<p><input type="checkbox" id="publish6" name="csbwfs_ppublishBtn" value="yes" <?php if(get_option('csbwfs_ppublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Pinterest Button</b></p>
				<p><input type="checkbox" id="publish7" name="csbwfs_republishBtn" value="yes" <?php if(get_option('csbwfs_republishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Reddit Button</b></p>
				<p><input type="checkbox" id="publish8" name="csbwfs_stpublishBtn" value="yes" <?php if(get_option('csbwfs_stpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Stumbleupon Button</b></p>
				<p><input type="checkbox" id="publish5" name="csbwfs_mpublishBtn" value="yes" <?php if(get_option('csbwfs_mpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Mailbox Button</b></p>
				<?php if(get_option('csbwfs_mpublishBtn')=='yes'){?> 
				<p id="mailmsg"><input type="text" name="csbwfs_mailMessage" id="csbwfs_mailMessage" value="<?php echo get_option('csbwfs_mailMessage');?>" placeholder="raghunath.0087@gmail.com" size="40" class="regular-text ltr"><br>Note:add the mail message like this format <b>your@email.com?subject=Your Subject</b></p>
				<?php } ?>
				<p><input type="checkbox" id="ytBtns" name="csbwfs_ytpublishBtn" value="yes" <?php if(get_option('csbwfs_ytpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Youtube Button</b></p>
				<?php if(get_option('csbwfs_ytpublishBtn')=='yes'){?> 
				<p id="ytpath"><input type="text" name="csbwfs_ytPath" id="csbwfs_ytPath" value="<?php echo get_option('csbwfs_ytPath');?>" placeholder="http://www.youtube.com" size="40" class="regular-text ltr"><br>add youtube channel url</p>
				<?php } ?>
			

			<p><label><h3 ><strong><?php _e('Define your custom message:','csbwfs');?></strong></h3></label></p>
			<p><label><?php _e('Show:');?></label><input type="text" id="csbwfs_show_btn" name="csbwfs_show_btn" value="<?php echo get_option('csbwfs_show_btn'); ?>" placeholder="Show Buttons" size="40"/></p>
			<p><label><?php _e('Hide:');?></label><input type="text" id="csbwfs_hide_btn" name="csbwfs_hide_btn" value="<?php echo get_option('csbwfs_hide_btn'); ?>" placeholder="Hide Buttons" size="40"/></p>
			<p><label><?php _e('Message:');?></label><input type="textbox" id="csbwfs_share_msg" name="csbwfs_share_msg" value="<?php echo get_option('csbwfs_share_msg'); ?>" placeholder="Share This With Your Friends" size="40"/></p>
	        <p><h3><strong><?php _e('Pinterest Share Image Setting :'); ?></strong></h3></p>
			<p><?php _e('Default Image :');?><input type="textbox" id="csbwfs_defaultfeaturedshrimg" name="csbwfs_defaultfeaturedshrimg" value="<?php echo get_option('csbwfs_defaultfeaturedshrimg'); ?>" placeholder="" size="55"/></p>
			<p><input type="checkbox" id="featuredshrimg" name="csbwfs_featuredshrimg" value="yes" <?php if(get_option('csbwfs_featuredshrimg')=='yes'){echo 'checked="checked"';}?>/> <?php _e('Make post/page featured image as pinterest share image');?></p>
	</div>
	<!-- Floating Sidebar -->
	<div class="csbwfs-tab" id="div-csbwfs-sidebar">
	<h2>Floating Sidebar Settings</h2>
	<table>
			<tr>
				<th nowrap><?php echo 'Siderbar Position:';?></th>
				<td>
				<select id="csbwfs_position" name="csbwfs_position" >
				<option value="left" <?php if(get_option('csbwfs_position')=='left'){echo 'selected="selected"';}?>>Left</option>
				<option value="right" <?php if(get_option('csbwfs_position')=='right'){echo 'selected="selected"';}?>>Right</option>
				<option value="bottom" <?php if(get_option('csbwfs_position')=='bottom'){echo 'selected="selected"';}?>>Bottom</option>
				</select>
				</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><input type="checkbox" id="csbwfs_rmSHBtn" name="csbwfs_rmSHBtn" value="yes" <?php if(get_option('csbwfs_rmSHBtn')=='yes'){echo 'checked="checked"';}?>/> <strong><?php _e('Remove Show/Hide Button:','csbwfs');?></strong></td>
			</tr>
			<tr><th nowrap valign="top"><?php echo 'Delay Time: '; ?></th><td><input type="text" name="csbwfs_delayTimeBtn" id="csbwfs_delayTimeBtn" value="<?php echo get_option('csbwfs_delayTimeBtn')?get_option('csbwfs_delayTimeBtn'):0;?>"  size="40" class="regular-text ltr"><br><i>Publish share buttons after given time(millisecond)</i></td></tr>
				<tr>
				<th>&nbsp;</th>
				<td><input type="checkbox" id="csbwfs_deactive_for_mob" name="csbwfs_deactive_for_mob" value="yes" <?php if(get_option('csbwfs_deactive_for_mob')=='yes'){echo 'checked="checked"';}?>/><?php _e('Disable Sidebar For Mobile','csbwfs');?></td>
			</tr>
			<tr><th></th>
				<td><input type="checkbox" id="csbwfs_auto_hide" name="csbwfs_auto_hide" value="yes" <?php if(get_option('csbwfs_auto_hide')=='yes'){echo 'checked="checked"';}?>/><?php _e('Auto Hide Sidebar On Page Load','csbwfs');?></td>
			</tr>
			<tr><th>&nbsp;</th><td><input type="checkbox" id="csbwfs_hide_home" value="yes" name="csbwfs_hide_home" <?php if(get_option('csbwfs_hide_home')!='yes'){echo '';}else{echo 'checked="checked"';}?>/>Hide Sidebar On Home Page</td></tr>
			<tr><td colspan="2"><strong><h4>Social Share Button Images 32X32 (Optional) :</h4></strong></td></tr>
			<tr><td colspan="2" align="right"><input type="button" id="csbwfs_resetpage" value="Reset"></td></tr>
			<tr>
			<th><?php echo 'Facebook:';?></th>
			<td class="csbwfsButtonsImg" id="csbwfsButtonsFbImg">
	       <input type="text" id="csbwfs_fb_image" name="csbwfs_fb_image" value="<?php echo get_option('csbwfs_fb_image'); ?>" placeholder="Insert facebook button image path" size="30" class="inputButtonid"/> <input id="csbwfs_fb_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_fb_bg" data-default-color="#305891" class="color-field" name="csbwfs_fb_bg" value="<?php echo get_option('csbwfs_fb_bg'); ?>" size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_fb_title"  name="csbwfs_fb_title" value="<?php echo get_option('csbwfs_fb_title'); ?>" placeholder="Share on facebook" size="20" class="csbwfs_title"/>
			</td>
			</tr>
			<tr><th><?php echo 'Twitter:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsTwImg">		
				<input type="text" id="csbwfs_tw_image" name="csbwfs_tw_image" value="<?php echo get_option('csbwfs_tw_image'); ?>" placeholder="Insert twitter button image path" size="30" class="inputButtonid"/><input id="csbwfs_tw_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_tw_bg" name="csbwfs_tw_bg" value="<?php echo get_option('csbwfs_tw_bg'); ?>" data-default-color="#2ca8d2" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_tw_title"  name="csbwfs_tw_title" value="<?php echo get_option('csbwfs_tw_title'); ?>" placeholder="Share on twitter" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Linkedin:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsLiImg">
				<input type="text" id="csbwfs_li_image" name="csbwfs_li_image" value="<?php echo get_option('csbwfs_li_image'); ?>" placeholder="Insert Linkedin button image path" class="inputButtonid" size="30" class="buttonimg"/><input id="csbwfs_li_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_li_bg" name="csbwfs_li_bg" value="<?php echo get_option('csbwfs_li_bg'); ?>" data-default-color="#dd4c39" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_li_title"  name="csbwfs_li_title" value="<?php echo get_option('csbwfs_li_title'); ?>" placeholder="Share on Linkedin" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr><th><?php echo 'Pintrest:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsPiImg">			
				<input type="text" id="csbwfs_pin_image" name="csbwfs_pin_image" value="<?php echo get_option('csbwfs_pin_image'); ?>" class="inputButtonid" placeholder="Insert pinterest button image path" size="30" class="buttonimg"/><input id="csbwfs_pin_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_pin_bg" name="csbwfs_pin_bg" value="<?php echo get_option('csbwfs_pin_bg'); ?>" data-default-color="#ca2027" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_pin_title"  name="csbwfs_pin_title" value="<?php echo get_option('csbwfs_pin_title'); ?>" placeholder="Share on pintrest" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr><th><?php echo 'Google Plus:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsGoImg">
				<input type="text" id="csbwfs_gp_image" name="csbwfs_gp_image" value="<?php echo get_option('csbwfs_gp_image'); ?>" placeholder="Insert google button image path" size="30" class="inputButtonid"/><input id="csbwfs_gp_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_gp_image" name="csbwfs_gp_bg" value="<?php echo get_option('csbwfs_gp_bg'); ?>" data-default-color="#dd4c39" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_gp_title"  name="csbwfs_gp_title" value="<?php echo get_option('csbwfs_gp_title'); ?>" placeholder="Share on google" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr><th><?php echo 'Reddit:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsReImg">
				<input type="text" id="csbwfs_re_image" name="csbwfs_re_image" value="<?php echo get_option('csbwfs_re_image'); ?>" placeholder="Insert reddit button image path" size="30" class="inputButtonid"/><input id="csbwfs_re_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_re_bg" name="csbwfs_re_bg" value="<?php echo get_option('csbwfs_re_bg'); ?>" data-default-color="#ff1a00" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_re_title"  name="csbwfs_re_title" value="<?php echo get_option('csbwfs_re_title'); ?>" placeholder="Share on reddit" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr><th><?php echo 'Stumbleupon:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsStImg">
				<input type="text" id="csbwfs_st_image" name="csbwfs_st_image" value="<?php echo get_option('csbwfs_st_image'); ?>" placeholder="Insert stumbleupon button image path" size="30" class="inputButtonid"/><input id="csbwfs_st_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_st_bg" name="csbwfs_st_bg" value="<?php echo get_option('csbwfs_st_bg'); ?>" data-default-color="#eb4924" class="color-field"  size="20"/>
				&nbsp;&nbsp;<input type="text" id="csbwfs_st_title"  name="csbwfs_st_title" value="<?php echo get_option('csbwfs_st_title'); ?>" placeholder="Share on stumbleupon" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr><th><?php echo 'Mail:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsMaImg">
				<input type="text" id="csbwfs_mail_image" name="csbwfs_mail_image" value="<?php echo get_option('csbwfs_mail_image'); ?>" placeholder="Insert mail button image path" size="30" class="inputButtonid"/><input id="csbwfs_mail_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_mail_bg" name="csbwfs_mail_bg" value="<?php echo get_option('csbwfs_mail_bg'); ?>" data-default-color="#738a8d" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_mail_title"  name="csbwfs_mail_title" value="<?php echo get_option('csbwfs_mail_title'); ?>" placeholder="Send contact request" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr><th><?php echo 'Youtube:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsYtImg">
				<input type="text" id="csbwfs_yt_image" name="csbwfs_yt_image" value="<?php echo get_option('csbwfs_yt_image'); ?>" placeholder="Insert youtube button image path" size="30" class="inputButtonid"/><input id="csbwfs_yt_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_yt_bg" name="csbwfs_yt_bg" value="<?php echo get_option('csbwfs_yt_bg'); ?>" data-default-color="#ffffff" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_yt_title"  name="csbwfs_yt_title" value="<?php echo get_option('csbwfs_yt_title'); ?>" placeholder="Youtube" size="20" class="csbwfs_title"/>
				</td>
			</tr>		
			<tr><td colspan="2"><h3><strong>Style(Optional):</strong></h3></td></tr>
			
			<tr>
				<th><?php echo 'Top Margin:';?></th>
				<td>
			
				<input type="textbox" id="csbwfs_top_margin" name="csbwfs_top_margin" value="<?php echo get_option('csbwfs_top_margin'); ?>" placeholder="10% OR 10px" size="10"/>
				</td>
			</tr>
	</table>
	</div>
	<!-- Share Buttons -->
	<div class="csbwfs-tab" id="div-csbwfs-share-buttons">
	<h2>Social Share Buttons Settings</h2>
	<table>
		    <td><?php _e('Enable:','csbwfs');?></td>
				<td colspan="2">
					<input type="checkbox" id="csbwfs_buttons_active" name="csbwfs_buttons_active" value='1' <?php if(get_option('csbwfs_buttons_active')!=''){ echo ' checked="checked"'; }?>/>
				</td>
		    </tr>
			<tr>
				<th nowrap><?php echo 'Share Button Position:';?></th>
				<td>
				<select id="csbwfs_btn_position" name="csbwfs_btn_position" >
				<option value="left" <?php if(get_option('csbwfs_btn_position')=='left'){echo 'selected="selected"';}?>>Left</option>
				<option value="right" <?php if(get_option('csbwfs_btn_position')=='right'){echo 'selected="selected"';}?>>Right</option>
				</select>
				</td>
			</tr>
			<tr>
				<th nowrap><?php echo 'Display Buttons On ';?></th>
				<td>
				<select id="csbwfs_btn_display" name="csbwfs_btn_display" >
				<option value="below" <?php selected(get_option('csbwfs_btn_display'),'below');?>>Bottom Of The Content</option>
				<option value="above" <?php selected(get_option('csbwfs_btn_display'),'above');?>>Top Of The Content</option>
				</select>
				</td>
			</tr>
			<tr>
				<th nowrap><?php echo 'Share Button Text:';?></th>
				<td>
				<input type="textbox" id="csbwfs_btn_text" name="csbwfs_btn_text" value="<?php echo get_option('csbwfs_btn_text'); ?>" placeholder="Share This!" size="20"/>
				<i>(Leave blank if you want hide button)</i></td>
			</tr>
			<tr><td colspan="2"><strong>Show Share Buttons On :</strong> Home <input type="checkbox" id="csbwfs_page_hide_home" value="yes" name="csbwfs_page_hide_home" <?php if(get_option('csbwfs_page_hide_home')!='yes'){echo '';}else{echo 'checked="checked"';}?>/> Page <input type="checkbox" id="csbwfs_page_hide_page" value="yes" name="csbwfs_page_hide_page" <?php if(get_option('csbwfs_page_hide_page')!='yes'){echo '';}else { echo 'checked="checked"';}?>/> Post <input type="checkbox" id="csbwfs_page_hide_post" value="yes" name="csbwfs_page_hide_post" <?php if(get_option('csbwfs_page_hide_post')!='yes'){echo '';}else{echo 'checked="checked"';}?>/> Category/Archive <input type="checkbox" id="csbwfs_page_hide_archive" value="yes" name="csbwfs_page_hide_archive" <?php if(get_option('csbwfs_page_hide_archive')!='yes'){echo '';}else{echo 'checked="checked"';}?>/> <br>
			</td></tr>
			
			<tr><td colspan="2"><strong><h4>Social Share Button Images 32X32 (Optional) :</h4></strong></td></tr>
			<tr><td colspan="2" align="right"><input type="button" id="csbwfsresetpage" value="RESET"></td></tr>
			<tr><th><?php echo 'Facebook:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsFbImg2"><input type="text" id="csbwfs_page_fb_image" name="csbwfs_page_fb_image" value="<?php echo get_option('csbwfs_page_fb_image'); ?>" placeholder="Insert facebook button image path" size="40"  class="inputButtonid"/>
                <input id="csbwfs_fb_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_fb_title"  name="csbwfs_page_fb_title" value="<?php echo get_option('csbwfs_page_fb_title'); ?>" placeholder="Alt Text" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Twitter:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsTwImg2">
				<input type="text" id="csbwfs_page_tw_image" name="csbwfs_page_tw_image" value="<?php echo get_option('csbwfs_page_tw_image'); ?>" placeholder="Insert twitter button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_tw_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_tw_title"  name="csbwfs_page_tw_title" value="<?php echo get_option('csbwfs_page_tw_title'); ?>" placeholder="Alt Text" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr><th><?php echo 'Linkedin:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsLiImg2"><input type="text" id="csbwfs_page_li_image" name="csbwfs_page_li_image" value="<?php echo get_option('csbwfs_page_li_image'); ?>" placeholder="Insert Linkedin button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_li_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_li_title"  name="csbwfs_page_li_title" value="<?php echo get_option('csbwfs_page_li_title'); ?>" placeholder="Alt Text" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Pintrest:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsPiImg2"><input type="text" id="csbwfs_page_pin_image" name="csbwfs_page_pin_image" value="<?php echo get_option('csbwfs_page_pin_image'); ?>" placeholder="Insert pinterest button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_pi_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_pin_title"  name="csbwfs_page_pin_title" value="<?php echo get_option('csbwfs_page_pin_title'); ?>" placeholder="Alt Text" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Google Plus:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsGpImg2">
				<input type="text" id="csbwfs_page_gp_image" name="csbwfs_page_gp_image" value="<?php echo get_option('csbwfs_page_gp_image'); ?>" placeholder="Insert google button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_gp_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_gp_title"  name="csbwfs_page_gp_title" value="<?php echo get_option('csbwfs_page_gp_title'); ?>" placeholder="Alt Text" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Reddit:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsReImg2">
				<input type="text" id="csbwfs_page_re_image" name="csbwfs_page_re_image" value="<?php echo get_option('csbwfs_page_re_image'); ?>" placeholder="Insert reddit button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_re_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_re_title"  name="csbwfs_page_re_title" value="<?php echo get_option('csbwfs_page_re_title'); ?>" placeholder="Alt Text" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Stumbleupon:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsStImg2">
				<input type="text" id="csbwfs_page_st_image" name="csbwfs_page_st_image" value="<?php echo get_option('csbwfs_page_st_image'); ?>" placeholder="Insert stumbleupon button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_st_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_st_title"  name="csbwfs_page_st_title" value="<?php echo get_option('csbwfs_page_st_title'); ?>" placeholder="Alt Text" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Mail:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsMlImg2">
				<input type="text" id="csbwfs_page_mail_image" name="csbwfs_page_mail_image" value="<?php echo get_option('csbwfs_page_mail_image'); ?>" placeholder="Insert mail button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_ml_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_mail_title"  name="csbwfs_page_mail_title" value="<?php echo get_option('csbwfs_page_mail_title'); ?>" placeholder="Alt Text" size="20" class="csbwfs_title"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Youtube:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsYtImg2">
				<input type="text" id="csbwfs_page_yt_image" name="csbwfs_page_yt_image" value="<?php echo get_option('csbwfs_page_yt_image'); ?>" placeholder="Insert youtube button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_yt_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_yt_title"  name="csbwfs_page_yt_title" value="<?php echo get_option('csbwfs_page_yt_title'); ?>" placeholder="Alt Text" size="20" class="csbwfs_title"/>
				</td>
			</tr>
	</table>
	
	</div>
	<!-- Support -->
	<div class="last author csbwfs-tab" id="div-csbwfs-support">
	
	<h2>Plugin Support</h2>
	
	<p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZEMSYQUZRUK6A" target="_blank" style="font-size: 17px; font-weight: bold;"><img src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" title="Donate for this plugin"></a></p>
	
	<p><strong>Plugin Author:</strong><br><img src="<?php echo  plugins_url( 'images/raghu.jpg' , __FILE__ );?>" width="75" height="75"><br><a href="http://raghunathgurjar.wordpress.com" target="_blank">Raghunath Gurjar</a></p>
	<p><a href="mailto:raghunath.0087@gmail.com" target="_blank" class="contact-author">Contact Author</a></p>
	<p><strong>My Other Plugins:</strong><br>
	<ol>
		<li><a href="https://wordpress.org/plugins/protect-wp-admin/" target="_blank">Protect WP-Admin</a></li>
		<li><a href="https://wordpress.org/plugins/wp-testimonial/" target="_blank">WP Testimonial</a></li>
		<li><a href="https://wordpress.org/plugins/cf7-advance-security" target="_blank">Contact Form 7 Advance Security WP-Admin</a></li>
		<li><a href="https://wordpress.org/plugins/wc-sales-count-manager/" target="_blank">WooCommerce Sales Count Manager</a></li>
		<li><a href="https://wordpress.org/plugins/wp-social-buttons/" target="_blank">WP Social Buttons</a></li>
		<li><a href="https://wordpress.org/plugins/wp-youtube-gallery/" target="_blank">WP Youtube Gallery</a></li>
		<li><a href="https://wordpress.org/plugins/wp-easy-recipe/" target="_blank">WP Easy Recipe</a></li>
		<li><a href="https://wordpress.org/plugins/tweets-slider/" target="_blank">Tweets Slider</a></li>
		<li><a href="https://wordpress.org/plugins/rg-responsive-gallery/" target="_blank">RG Responsive Slider</a></li>
		</ol>
	</div>
<!-- GO PRO -->
	<div class="last author csbwfs-tab" id="div-csbwfs-pro">
	
	<h2>GO PRO</h2>
	<p><a href="https://rgaddons.wordpress.com/custom-share-buttons-with-floating-sidebar-pro/" target="_blank" class="contact-author">Go Pro</a></p>
	<p>We have released an add-on for Custom Share Buttons With Floating Sidebar which not only demonstrates the flexibility of CSBWFS, but also adds some important features:</p>
		<ol>
		<li>Responsive Floating Sidebar</li>
		<li>Hide Floating Sidebar On Home/Post/Page/Category and on Custom Post Type</li>
		<li>An Option for Show/Hide sidebar on any specific page/post/product</li>
		<li>Show Social Share Buttons On Home/Post/Page/Category and on Custom Post Type</li>
		<li>An Option for Show/Hide social share buttons on any specific page/post/product</li>
		<li>An Option for Show/Hide sidebar on any custom post type</li>
		<li>Responsive Lightbox Contact Form (for Mail Icon)</li>
		<li>An option for add to any custom shortcode into lightbox</li>
		<li>Advance feature for choose to pinterest share image</li>
		<li>An option for add to OG tags content(title,image,description)</li>
		<li>An option for set automatically horizontal sidebar position for mobile</li>
		<li>An option for add to social site official page URL for all social buttons</li>
		<li>Extra Buttons (Google Translate,Instagram,Whatsapp,Digg,Yummly,Vk, Buffer, Line, Skype, RSS, Print, G-Mail, Blogger, Tumbler,Delicious,Weibo, Telegram &amp; SMS )</li>
		<li>An option for define to twitter username in thier share window.</li>
		<li>An option for display to number of share(Facebook,Linkedin,StumbleUpon,Google Plus,Pinterest and Reddit)</li>
		<li>An options for change to any button image, title, background colour and url (You can use any button as your own custom button)</li>
		<li>An options to define sorting order for all buttons</li>
		<li>10 extra custom floating sidebar buttons with extra options (i.e you can define your own custom size for these buttons)</li>
		<li>An option for show to sum of total share count for all buttons</li>
		<li>An option for remove mouse hover animation effect for all social buttons</li>
		<li>Faster support</li>
		</ol>
 <p><a href="https://rgaddons.wordpress.com/custom-share-buttons-with-floating-sidebar-pro/" target="_blank" class="contact-author">Go Pro</a></p>
 <p> <a href="mailto:raghunath.0087@gmail.com" target="_blank" class="contact-author">Contact To Author</a></p>
  
	</div>
	
	</div>
	<span class="submit-btn"><?php echo get_submit_button('Save Settings','button-primary','submit','','');?></span>
		
    <?php settings_fields('csbwf_sidebar_options'); ?>
	
	</form>

<!-- End Options Form -->
	</div>

<?php
}
endif;

require dirname(__FILE__).'/csbwfs-class.php';
	
/* 

*Delete the options during disable the plugins 

*/

if( function_exists('register_uninstall_hook') )

	register_uninstall_hook(__FILE__,'csbwf_sidebar_uninstall');   

//Delete all Custom Tweets options after delete the plugin from admin
function csbwf_sidebar_uninstall(){
	delete_option('csbwfs_active');
	delete_option('csbbuttons_active');
	delete_option('csbwfs_position');
	delete_option('csbwfs_btn_position');
	delete_option('csbwfs_btn_text');
	delete_option('csbwfs_fb_image');
	delete_option('csbwfs_tw_image');
	delete_option('csbwfs_li_image');
	delete_option('csbwfs_re_image');
	delete_option('csbwfs_st_image');
	delete_option('csbwfs_mail_image');
	delete_option('csbwfs_gp_image');
	delete_option('csbwfs_pin_image');
	delete_option('csbwfs_yt_image');
	delete_option('csbwfs_re_image');
	delete_option('csbwfs_st_image');	
	delete_option('csbwfs_ytPath');
	delete_option('csbwfs_fb_bg');
	delete_option('csbwfs_tw_bg');
	delete_option('csbwfs_li_bg');
	delete_option('csbwfs_mail_bg');
	delete_option('csbwfs_gp_bg');
	delete_option('csbwfs_pin_bg');	
	delete_option('csbwfs_yt_bg');
	delete_option('csbwfs_fpublishBtn');
	delete_option('csbwfs_tpublishBtn');
	delete_option('csbwfs_gpublishBtn');	
	delete_option('csbwfs_ppublishBtn');	
	delete_option('csbwfs_lpublishBtn');	
	delete_option('csbwfs_mpublishBtn');	
	delete_option('csbwfs_republishBtn');	
	delete_option('csbwfs_stpublishBtn');
	delete_option('csbwfs_ytpublishBtn');	
	delete_option('csbwfs_mailMessage');
	delete_option('csbwfs_top_margin');
	delete_option('csbwfs_page_hide_home');
	delete_option('csbwfs_page_hide_post');
	delete_option('csbwfs_page_hide_page');
	delete_option('csbwfs_fb_title');
	delete_option('csbwfs_tw_title');
	delete_option('csbwfs_li_title');
	delete_option('csbwfs_pin_title');
	delete_option('csbwfs_gp_title');
	delete_option('csbwfs_mail_title');
	delete_option('csbwfs_yt_title');
	delete_option('csbwfs_re_title');
	delete_option('csbwfs_st_title');
	delete_option('csbwfs_page_fb_image');
	delete_option('csbwfs_page_tw_image');
	delete_option('csbwfs_page_li_image');	
	delete_option('csbwfs_page_re_image');	
	delete_option('csbwfs_page_st_image');	
	delete_option('csbwfs_page_mail_image');	
	delete_option('csbwfs_page_gp_image');	
	delete_option('csbwfs_page_pin_image');		
	delete_option('csbwfs_page_yt_image');	
	delete_option('csbwfs_rmSHBtn');
	delete_option('csbwfs_featuredshrimg');	
	delete_option('csbwfs_defaultfeaturedshrimg');
	delete_option('csbwfs_deactive_for_mob');	
	
}
?>
