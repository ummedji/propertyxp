<?php

define ('AVIATORS_SIDEBARS_ALL', 1);
define ('AVIATORS_SIDEBARS_ANY', 0);

define('THEMENAME', 'realocation');

define('PROPERY_ID',get_the_ID());

require_once get_template_directory() . '/launcher/launcher.php';
/*****************************************************************
 * Misc
 *****************************************************************/
require_once get_template_directory() . '/core/class-tgm-plugin-activation.php';
require_once get_template_directory() . '/core/aq_resizer.php';

/*****************************************************************
 * Settings
 *****************************************************************/
require_once get_template_directory() . '/core/settings/tgm.php';
require_once get_template_directory() . '/core/settings/menus.php';
require_once get_template_directory() . '/core/settings/sidebars.php';
require_once get_template_directory() . '/core/settings/scripts.php';
require_once get_template_directory() . '/core/settings/customizations.php';

/*****************************************************************
 * Utility
 *****************************************************************/
require_once get_template_directory() . '/utility/image.php';
require_once get_template_directory() . '/utility/templates.php';
require_once get_template_directory() . '/utility/comments.php';
require_once get_template_directory() . '/utility/pagination.php';
require_once get_template_directory() . '/utility/settings.php';


/**
 * Define steps for launcher
 * @param $steps
 * @return mixed
 */
function realocation_aviators_launcher_steps($steps) {

    $steps['content'] = array(
        'title' => __('Content Import', 'aviators'),
        'importer' => 'content',
        'file' => dirname(__FILE__) . '/exports/realocation_content.xml',
    );

    $steps['hydra'] = array(
        'title' => __('Hydra Import', 'aviators'),
        'importer' => 'hydra',
        'file' => dirname(__FILE__) . '/exports/hydra_export.xml',
    );

    $steps['widget'] = array(
        'title' => __('Widget Import', 'aviators'),
        'importer' => 'widget-settings',
        'file' => dirname(__FILE__) . '/exports/widget_data.json',
    );

    $steps['logic'] = array(
        'title' => __('Widget Logic Import', 'aviators'),
        'importer' => 'widget-logic',
        'file' => dirname(__FILE__) . '/exports/widget_logic.json',
    );

    $steps['theme'] = array(
        'title' => __('Theme Options', 'aviators'),
        'importer' => 'theme-options',
        'file' => dirname(__FILE__) . '/exports/theme_options.json',
    );

    return $steps;
}
add_filter('aviators_launcher_steps', 'realocation_aviators_launcher_steps');

if (!isset($content_width)) {
    $content_width = 1170;
}

function aviators_footer() {
    $instance = NULL;
    do_action('aviators_footer_map_widget', $instance);
    do_action('aviators_footer_map_detail');
}

function aviators_entry_meta() {
    if (is_sticky() && is_home() && !is_paged()) {
        echo '<span class="featured-post">' . __('Sticky', 'aviators') . '</span>';
    }

    if (!has_post_format('link') && 'post' == get_post_type()) {
        aviators_entry_date();
    }

    $tag_list = get_the_tag_list('', __(', ', 'aviators'));
    if ($tag_list) {
        echo '<span class="tags-links">' . $tag_list . '</span>';
    }

    if (in_array('category', get_object_taxonomies(get_post_type()))) {
        echo '<div class="entry-meta"><span class="cat-links">' . get_the_category_list(',') . '</span></div>';
    }

    if ('post' == get_post_type()) {
        $author_posts_url = esc_url(get_author_posts_url(get_the_author_meta('ID')));
        $author_title = esc_attr(sprintf(__('View all posts by %s', 'aviators'), get_the_author()));
        $author = get_the_author();
        print '<span class="author vcard">' . __('Posted by', 'aviators') . ' <a class="url fn n" href="' . $author_posts_url . '" title="' . $author_title . '" rel="author">' . $author . '</a></span> ' . __('on', 'aviators') . ' ' . aviators_entry_date();
    }
}

function aviators_link_pages() {
    wp_link_pages(array(
        'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'aviators') . '</span>',
        'after' => '</div>',
        'link_before' => '<span>',
        'link_after' => '</span>'
    ));
}

function aviators_comments_popup_link() {
    comments_popup_link(
        '<span class="leave-reply">' . __('Leave a comment', 'aviators') . '</span>',
        __('One comment so far', 'aviators'),
        __('View all % comments', 'aviators')
    );
}

function aviators_the_content() {
    the_content(__('Continue reading', 'aviators'));
}

function aviators_morelink_class($link, $text) {
    return str_replace(
        'more-link', 'more-link btn arrow-right btn-primary', $link
    );
}

add_action('the_content_more_link', 'aviators_morelink_class', 10, 2);

function aviators_entry_date($echo = FALSE) {
    $format_prefix = (has_post_format('chat') || has_post_format('status')) ? __('%1$s on %2$s', '1: post format name. 2: date', 'aviators') : '%2$s';

    $date = sprintf('<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
        esc_url(get_permalink()),
        esc_attr(sprintf(__('Permalink to %s', 'aviators'), the_title_attribute('echo=0'))),
        esc_attr(get_the_date('c')),
        esc_html(sprintf($format_prefix, get_post_format_string(get_post_format()), get_the_date()))
    );

    if ($echo) {
        echo $date;
    }

    return $date;
}

/**
 * Settings page link
 * @param $post_type
 * @param $page_id
 */
function aviators_configure_page_link($post_type, $page_id) {
    // @todo access check
    if (!current_user_can('edit_pages')) {
        return;
    }
    $path = aviators_settings_get_settings_path($post_type, $page_id);

    $output = '<span class="edit-link"><a href=' . $path . '>';
    $output .= '<i class="fa fa-cog"></i>' . __("Configure", 'aviators');
    $output .= '</a></span>';

    print $output;
}

/**
 * Edit post link
 */
function aviators_edit_post_link($post_id = 0) {
    edit_post_link(__('<i class="fa fa-pencil"></i> Edit', 'aviators'), '<span class="edit-link">', '</span>', $post_id);
}

/**
 * Better excerpt read more link
 */
add_filter('excerpt_more', 'aviators_excerpt_more');
function aviators_excerpt_more($more) {
    return '<div class="read-more-wrapper"><a class="btn btn-primary" href="' . get_permalink(get_the_ID()) . '">' . __('Read More', 'aviators') . ' </a></div>';
}

function twentyten_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Additional theme setup functions
 */
add_action('after_setup_theme', 'aviators_theme_setup');
function aviators_theme_setup() {
    load_theme_textdomain('aviators', get_template_directory() . '/languages');
    add_editor_style();

    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    // add_theme_support('custom-header');
    // add_theme_support('custom-background');

    add_filter('widget_text', 'do_shortcode');

    if (current_user_can('subscriber')) {
        remove_action('wp_footer', 'wp_admin_bar_render', 1000);
        add_filter('body_class', 'aviators_remove_admin_bar_for_subscriber');
    }
}

function aviators_remove_admin_bar_for_subscriber($classes) {
    $result = array();

    foreach ($classes as $class) {
        if ($class != 'admin-bar') {
            $result[] = $class;
        }
    }

    return $result;
}

/**
 * Helper function for content loop to know if there it is next post in loop
 */
function more_posts() {
    global $wp_query;
    return $wp_query->current_post + 1 < $wp_query->post_count;
}

/**
 * Nice formatted title tag value
 */
add_filter('wp_title', 'aviators_wp_title', 10, 2);
function aviators_wp_title($title, $sep) {
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }


    // Add the site name.
    $title .= get_bloginfo('name');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep " . sprintf(__('Page %s', 'nuczv'), max($paged, $page));
    }

    return strip_tags(html_entity_decode($title));
}

/**
 * Switch body's wide/boxed layout class
 */
add_filter('body_class', 'aviators_body_class');
function aviators_body_class($classes = '') {
    $classes[] = get_theme_mod('general_layout', 'layout-wid');
    $classes[] = get_theme_mod('footer_variant', 'footer-dark');
    $classes[] = get_theme_mod('header_variant', 'header-dark');
    $classes[] = get_theme_mod('background_pattern', 'cloth-alike');
    $classes[] = get_theme_mod('map_navigation_variant', 'map-navigation-dark');

    return $classes;
}

/**
 * Disable admin's bar top margin
 */
add_action('get_header', 'aviators_disable_admin_bar_top_margin');
function aviators_disable_admin_bar_top_margin() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}

function aviators_add_message($message, $type = 'success') {
    $_SESSION['aviators']['messages'][] = array(
        'message' => $message,
        'type' => $type,
    );

}

function aviators_flush_messages() {
    unset($_SESSION['aviators']['messages']);
}

function aviators_render_messages() {
    $output = "";

    if (!defined('HYDRA_THEME_MODE')) {
        return;
    }

    $messages = hydra_get_messages();
    if ($messages) {
        foreach ($messages as $message) {
            $_SESSION['aviators']['messages'][] = array(
                'message' => $message['text'],
                'type' => $message['type'],
            );
        }
    }

    if (isset($_SESSION['aviators']['messages'])) {
        if (count($_SESSION['aviators']['messages'])) {
            foreach ($_SESSION['aviators']['messages'] as $message) {
                $output .= "<div class=\"alert alert-" . $message['type'] . "\">" . $message['message'] . "</div>";
            }
        }
    }

    aviators_flush_messages();

    return $output;
}


/**
 * Determine if all or at least one sidebar is/are active
 * Used to determine if render on not to render grouped section of sidebars - like footer
 * @param $sidebars
 * @param int $condition
 * @return bool
 */
function aviators_active_sidebars($sidebars, $condition = AVIATORS_SIDEBARS_ALL) {
    if (is_string($sidebars)) {
        $sidebars = array($sidebars);
    }

    // not valid data provided
    if (!is_array($sidebars) && !count($sidebars)) {
        return FALSE;
    }

    if ($condition == AVIATORS_SIDEBARS_ALL) {
        foreach ($sidebars as $sidebar) {
            if (!is_active_sidebar($sidebar)) {
                return FALSE;
            }
        }
        return TRUE;
    }

    if ($condition == AVIATORS_SIDEBARS_ANY) {
        foreach ($sidebars as $sidebar) {
            if (is_active_sidebar($sidebar)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}

/**
 * Hydra callback to route rendering of various post types nad post display types
 * @param $meta
 * @param $delta
 * @param $settings
 * @param $item
 * @return string
 */
function aviators_post_reference_item_render($view, $meta, $delta, $settings, $item) {
    $dbModel = new HydraFieldViewModel();
    $field = $view->loadField();

    $args = array(
        'post_type' => $field->attributes['post_type'],
        'post__in' => $item['value'],
        'posts_per_page' => '5',
    );

    query_posts($args);
    ob_start();
    echo "<div class=row>";

    if ( have_posts() ) {
        while (have_posts()) {
            echo "<div class=col-sm-4>";
            the_post();
            aviators_get_content_template($field->attributes['post_type'], $settings['display_type']);
            echo "</div>";
        }
    }
    echo "</div>";
    echo aviators_pagination();
    wp_reset_query();

    $output = ob_get_clean();



    return $output;
}

add_filter('hydra_post_reference_item_render', 'aviators_post_reference_item_render', 10, 5);


/**
 * Gets array of allowed pages for settings
 *
 * Not all page templates can have settings attached
 *
 * @param $supported_pages
 * @return array
 */
function aviators_property_theme_supported_pages($supported_pages) {
    $pages = get_posts(array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-properties.php',
        'numberposts' => -1
    ));

    if (!count($pages)) {
        return array();
    }

    foreach ($pages as $page) {
        $supported_pages[$page->ID] = $page->post_title;
    }

    return $supported_pages;
}

add_filter('aviators_property_supported_page_type', 'aviators_property_theme_supported_pages');

/**
 * Gets array of allowed pages for settings
 *
 * Not all page templates can have settings attached
 *
 * @param $supported_pages
 * @return array
 */
function aviators_package_theme_supported_pages($supported_pages) {
    $pages = get_posts(array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-packages.php',
    ));

    if (!count($pages)) {
        return array();
    }


    foreach ($pages as $page) {
        $supported_pages[$page->ID] = $page->post_title;
    }

    return $supported_pages;
}

add_filter('aviators_package_supported_page_type', 'aviators_package_theme_supported_pages');


/**
 *
 */
function aviators_allow_upload() {
	
    $contributor = get_role('subscriber');
    $contributor->add_cap('upload_files');
	
}
add_action('init','aviators_allow_upload');


add_action('pre_get_posts','aviators_restrict_media_library');
function aviators_restrict_media_library( $wp_query_obj )
{
    global $current_user, $pagenow;

    if( !is_a( $current_user, 'WP_User') ) {
        return;
    }

    if( 'upload.php' != $pagenow && 'media-upload.php' != $pagenow && 'admin-ajax.php' != $pagenow) {
        return;
    }

    if( !current_user_can('delete_pages') ) {
        if($wp_query_obj->query['post_type'] == 'attachment') {
            $wp_query_obj->set('author', $current_user->id );
        }
    }
}

function realocation_php_version_check() {

    if(version_compare(phpversion(), '5.3.1', '<')) {
        $output = '';
        $output .= '<div class="error">';
        $output .= '<p>';
        $output .= __( 'You require at least PHP 5.3 or higher in order to run Realocation. <strong>Upgrade your PHP before continuing with installation.</strong>', 'aviators' );
        $output .= '</p>';
        $output .= '</div>';

        echo $output;
    }
}
add_action( 'admin_notices', 'realocation_php_version_check' );

function print_menu_shortcode($atts, $content = null) {
	extract(shortcode_atts(array( 'name' => null, ), $atts));
	return wp_nav_menu( array(
                    'theme_location' => 'main',
                    'fallback_cb' => false,
                    'menu_class' => 'nav nav-pills',
                    'container_class' => '',
                ) );
}
add_shortcode('custom_menu', 'print_menu_shortcode');




add_filter('wp_nav_menu_items','add_todaysdate_in_menu', 10, 2);
function add_todaysdate_in_menu( $items, $args ) {
	if( $args->theme_location == 'authenticated')  {

	$current_user = wp_get_current_user();
	$items .=  '<li>Hello, <a style="display:inline-block" href="'.get_bloginfo('url').'/wp-admin/profile.php">' . $current_user->display_name .  '</a></li>';
	$items .=  '<li>' . '<a href="'.wp_logout_url().'" title="Logout">Logout</a>' .  '</li>';
	}
	return $items;
}


function remove_menus(){
	if ( !current_user_can('manage_options') ) {

		remove_menu_page( 'index.php' );                  //Dashboard
		remove_menu_page( 'edit.php' );                   //Posts
		remove_menu_page( 'upload.php' );                 //Media
		remove_menu_page( 'edit.php?post_type=page' );    //Pages
		remove_menu_page( 'edit-comments.php' );          //Comments
		remove_menu_page( 'themes.php' );                 //Appearance
		remove_menu_page( 'plugins.php' );                //Plugins
		remove_menu_page( 'users.php' );                  //Users
		remove_menu_page( 'tools.php' );                  //Tools
		remove_menu_page( 'options-general.php' );        //Settings*/
		remove_menu_page( 'wpcf7' ); 
		remove_menu_page( 'tribe_events' );
		remove_menu_page( 'edit.php?post_type=tribe_events' );		
		remove_menu_page( 'edit.php?post_type=law-news' );        
		remove_menu_page( 'edit.php?post_type=announcements' );
		remove_menu_page( 'edit.php?post_type=banners' );
	
	}

}
add_action( 'admin_menu', 'remove_menus' );


function wps_admin_bar() {
if ( !current_user_can('manage_options') ) {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
	//$wp_admin_bar->remove_menu('about');
	//$wp_admin_bar->remove_menu('wporg');
	$wp_admin_bar->remove_menu('documentation');
	$wp_admin_bar->remove_menu('support-forums');
	$wp_admin_bar->remove_menu('feedback');
	//$wp_admin_bar->remove_menu('view-site');
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('new');
	$wp_admin_bar->remove_menu('updates');
	$wp_admin_bar->remove_menu('new-content');
	//$wp_admin_bar->remove_menu('my-account');
	//$wp_admin_bar->remove_menu('site-name');
	$wp_admin_bar->remove_menu('my-directory');
	//$wp_admin_bar->remove_menu('my-profile');
	$wp_admin_bar->remove_menu('tribe-events');
	$wp_admin_bar->remove_menu('wpseo-menu');
	
	
	// 	$wp_admin_bar->remove_menu('new-theme');
	//remove_menu_page('edit.php?post_type=email');
	// 	$wp_admin_bar->add_menu( array( 'parent' => $id, 'title' => __( '<strong>Log Out</strong>' , 'href' => wp_logout_url() ) ;
	$wp_admin_bar->remove_menu('search');
	//$wp_admin_bar->remove_menu('edit-profile');
	//$wp_admin_bar->remove_menu('user-info');
	//$wp_admin_bar->remove_menu('logout');
	}
}
add_action( 'wp_before_admin_bar_render', 'wps_admin_bar') ;

add_filter( 'contextual_help', 'mycontext_remove_help', 999, 3 );
  function mycontext_remove_help($old_help, $screen_id, $screen){
    $screen->remove_help_tabs();
    return $old_help;
}

function change_footer_admin () {  
  echo 'Powered by <a href="http://www.propertyxp.com">PropertyXP</a>';  
}  
  
add_filter('admin_footer_text', 'change_footer_admin');




add_action("wp_ajax_search_location_by_city", "search_location_by_city");
add_action("wp_ajax_nopriv_search_location_by_city", "search_location_by_city");


function search_location_by_city() {

	$locations = get_terms('locations', array('parent' => $_REQUEST["state_id"], 'hide_empty' => false));

	$html  = '';
	foreach ($locations as $location) {

		$html  .= '<option value="'.$location->term_id.'">';
		$html  .= $location->name;
		$html  .= '</option>';
	}
	echo $html;
	die();

}

/*function wp_ajax_nopriv_search_location_by_city() {

    $locations = get_terms('locations', array('parent' => $_REQUEST["state_id"], 'hide_empty' => false));

    $html  = '';
    foreach ($locations as $location) {

        $html  .= '<option value="'.$location->term_id.'">';
        $html  .= $location->name;
        $html  .= '</option>';
    }
    echo $html;
    die();

}*/

add_action("wp_ajax_get_property_average_value", "get_property_average_value");
add_action("wp_ajax_nopriv_get_property_average_value", "get_property_average_value");

function get_property_average_value(){
	$state_id = $_REQUEST["state_id"];
	$city_id = $_REQUEST["city_id"];
	
	$city_name = get_term_by('id', $city_id, 'locations');
	//print_r($city_name->slug);

   // echo $city_name;
   // die;

	$args = array(
				'post_type' => 'property', 
				'posts_per_page' => -1 , 
				'post_status' => 'publish' , 
				'location' => $city_name->slug ,
							
			);
	
	$loops = new WP_Query($args);

	$total_prize_arr = array();
	while ($loops->have_posts()) : $loops->the_post();
	
	//$total_prize_ar = get_post_meta( get_the_ID());
	//$total_prize_arr[] = hydra_render_field(get_the_ID(), 'price', 'detail');
	
	$total_prize_arr[] = str_replace(" ","",strip_tags(hydra_render_field(get_the_ID(), 'price', 'detail')));
	
	endwhile;

	$total_prize_arr = array_filter($total_prize_arr);

	$total_value =  array_sum($total_prize_arr);
	$num_valu_in_array = count($total_prize_arr);
	
	$result = floatval ($total_value/$num_valu_in_array);
	$result = sprintf ("%.2f", $result);
	
	//print_r($loops);
	echo $result;
	die();
	
}
#################CUSTOM CODE######################
/*
 * FOR GETTING LOGIN USER POSTS PROPERTIES ONLY
 */

add_action('pre_get_posts', 'filter_posts_list');
function filter_posts_list($query)
{
    //$pagenow holds the name of the current page being viewed
     global $pagenow;
 
    //$current_user uses the get_currentuserinfo() method to get the currently logged in user's data
     global $current_user;
     get_currentuserinfo();
     
     //Shouldn't happen for the admin, but for any role with the edit_posts capability and only on the posts list page, that is edit.php
      if(!current_user_can('administrator') && current_user_can('edit_posts') && ('edit.php' == $pagenow)){
        //global $query's set() method for setting the author as the current user's id
        $query->set('author', $current_user->ID);
        }
}

/*
 * HIDE COUNT WORDPRESS ADMIN PANEL POST COUNTS ON THE BASICS OF USER LOGIN
 */

function jquery_remove_counts()
{
	?>
	<script type="text/javascript">
	jQuery(function(){
            <?php
             global $current_user;
             get_currentuserinfo();
    
             if(!current_user_can('administrator')){
                  ?>
		jQuery("li.all").remove();
             <?php   } ?>
		jQuery("li.publish").remove();
		jQuery("li.trash").remove();
        jQuery("li.draft").remove();
		

	});
	</script>
	<?php
}
add_action('admin_footer', 'jquery_remove_counts');

/*
 * FOR SENDING NEWS LETTER TO LEADS
 */
add_action('admin_footer', 'jquery_send_newsletter');

function jquery_send_newsletter(){
   ?> 
    <script type="text/javascript">
	jQuery(function(){
           
		jQuery("button.send_newsletter").on("click",function(){
                    jQuery("div.error_message").empty();
                    var user_lead_array = [];
                    jQuery('input[name="user_leads_checkbox"]:checked').each(function() {
                        user_lead_array.push(this.value);
                     });
                     
                     var selected_newsletter = jQuery("input[name=newsletter_radio]:checked").val();
                     var error = 0;
                     var error_array = [];
                     if(user_lead_array.length === 0){
                          error = 1;
                          error_array.push("Please Select some leads to send Newsletter.");
                     }
                     
                     if(selected_newsletter == "undefined" || selected_newsletter == null || selected_newsletter == ""){ 
                          error = 1;
                          error_array.push("Please Select Newsletter to Send."); 
                     }
                     
                     if(error_array.length === 0){
                         
                         // CALL AJAX TO SEND NEWS LETTER
                         var url = "<?php echo site_url(); ?>";
                         jQuery.post(url+"/send-newsletter",{user_lead : user_lead_array,newsletter:selected_newsletter},function(response){
                             
                             jQuery("div.error_message").append("<span style='color:green;'>Newsletter Send Successfully.</span></br></br>");
                             
                         });
                     }
                     else{
                         
                         // PLEASE SELECT PROPER ERROR DATA
                        
                         jQuery.each( error_array, function( key, value ) {
                            jQuery("div.error_message").append("<span style='color:red;'>"+value+"</span></br></br>");
                         });
                         
                     }
                    
                });
                
                jQuery("a#select_all_leads").on("click",function(){ 
                    jQuery('input[name="user_leads_checkbox"]').prop('checked', true);
                });
                
                jQuery("a#deselect_all_leads").on("click",function(){ 
                    jQuery('input[name="user_leads_checkbox"]').prop('checked', false);
                });
                
                
                
                jQuery("body").find("div.error-msg").remove();
                
	});
	</script>
    <?php
}

/*
 * SHOW ADD NEW PROPERTY ONLY FOR ADDING ONE PROPERTY FOR AUTHOR TYPE USER.
 */

add_action('admin_footer', 'filter_add_posts_singletime');
function filter_add_posts_singletime($query)
{
    //$pagenow holds the name of the current page being viewed
     global $pagenow;
 
    //$current_user uses the get_currentuserinfo() method to get the currently logged in user's data
     global $current_user;
     get_currentuserinfo();
     
     //Shouldn't happen for the admin, but for any role with the edit_posts capability and only on the posts list page, that is edit.php
      if(!current_user_can('administrator') && current_user_can('edit_posts')){
        //global $query's set() method for setting the author as the current user's id
        //$query->set('author', $current_user->ID);
          
    $user_ID = get_current_user_id();
    $args = array(
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_type'        => 'property',
	'author'	   => $user_ID,
    'post_status'      => 'publish',
	'suppress_filters' => true 
	);      
    $posts_array = get_posts( $args ); 
   
	 
          
          $posts_array = get_posts( $args ); 
          if(count($posts_array) >= 1){
            ?>
          <script type="text/javascript">      
	
	jQuery(document).ready(function(){
           
           if(jQuery("div.wrap h2").find("a.add-new-h2").text() == "Add New Property"){
              jQuery("div.wrap h2 a.add-new-h2").remove();
           }
              jQuery("li#menu-posts-property ul.wp-submenu-wrap li:nth-child(3)").remove();
              
           
        });  
          </script>
       <?php 
          }
        }
        
       ?> 
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
         <script type="text/javascript">      
	
	jQuery(document).ready(function(){
           
           <?php
          /* if($_REQUEST["post_type"] == "property" || (isset($_REQUEST["post"]) && $_REQUEST["action"] == "edit")){ */
		  $property_id = get_post_type($_GET['post']);
			if(trim($property_id) == 'property' || $_REQUEST["post_type"] == "property") {
				if(!isset($_GET['taxonomy'])) {
           ?>
           jQuery(document).ready(function(){
			//Rent Option customization
			jQuery(function() {
			jQuery('#hydra-hf-property-newpossession-items-0-value').datepicker( {
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'MM yy',
			onClose: function(dateText, inst) { 
				var month = jQuery("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = jQuery("#ui-datepicker-div .ui-datepicker-year :selected").val();
				jQuery(this).datepicker('setDate', new Date(year, month, 1));
			}
			});
			});

		   jQuery('#post').append('<input type="submit" value="Save" name="save" class="button button-primary button-large metabox_submit">');
			jQuery('.metabox_submit').click(function(e) {
			e.preventDefault();
			jQuery('#publish').click();
			});
		  jQuery('#hydra-hf-property-contract-type-items-0-value').change(function(){
			  var contracttype = jQuery("#hydra-hf-property-contract-type-items-0-value option[value='"+this.value+"']").text();
			  if(jQuery.trim(contracttype) == 'Rent')
			  {
				jQuery('#hf-property-available').show();
			  }
			  else
			  {
				 jQuery("#hydra-hf-property-available-items-0-date").val('');
				 jQuery('#hf-property-available').hide();
			  }
		  });
			  
			 jQuery('#hf-property-available').hide();
			 //jQuery('#hf-property-navailbale').hide();
			  jQuery( "fieldset" ).addSelectAll(
			   'hf_property_2_bedroom_apartment_amenities');
			  jQuery( "fieldset" ).addSelectAll('hf_property_3_bedroom_apartment_amenities');
			  jQuery( "fieldset" ).addSelectAll('hf_property_4_bedroom_apartment_amenities');
			  jQuery( "fieldset" ).addSelectAll('hf_property_amenities');
			  jQuery('.select_all_entity').click(function() {
				if(this.checked) {
				jQuery('[name="'+this.id+'"]').find('input[type=checkbox]').each(function(){
					jQuery(this).prop('checked', true);
				});
				}
				else{
					jQuery('[name="'+this.id+'"]').find('input[type=checkbox]').each(function(){
					jQuery(this).prop('checked', false);
				});
				}
			  });
		   });
		  
			(function($){
				$.fn.addSelectAll = function( nameAttr ) {
				
						 jQuery( "[name="+nameAttr+"]" ).find('h3 > legend').append('<span style="float:right;">Select All <input type="checkbox" class="select_all_entity" id="'+nameAttr+'"></span>');
						 jQuery( "[name="+nameAttr+"]" ).find('h3 > legend').css('width','100%');
					};
				
				}(jQuery));	
           jQuery("body").find("label").each(function() {
                var data = jQuery(this).text();
                data = data.replace('*', '').trim();
                
                 if(jQuery.trim(data.toLowerCase()) in tooltipMessage){
                  var key = jQuery.trim(data.toLowerCase());
                  var tooltip_new_data = tooltipMessage[key];
					jQuery("label").addClass('labelclass');
					jQuery( "label" ).find( ":checkbox" ).each(function(){   
					jQuery(this).parent().removeClass('labelclass');
					});
				 jQuery(this).attr({
                    title: tooltip_new_data
                  });
              }
              
           });
           
           jQuery("body").find(".hndle span").each(function() {
                var data = jQuery(this).text();
                data = data.replace('*', '').trim();
               
                 if(jQuery.trim(data.toLowerCase()) in tooltipMessage){
                  var key = jQuery.trim(data.toLowerCase());
                  var tooltip_new_data = tooltipMessage[key];
                  
                  jQuery(this).attr({
                    title: tooltip_new_data
                  });
              }
                
           });
           
           jQuery("body").find(".wrap h2").each(function() {
                var data = jQuery(this).text();
                data = data.replace('*', '').trim();
                
                 if(jQuery.trim(data.toLowerCase()) in tooltipMessage){
                  var key = jQuery.trim(data.toLowerCase());
                  var tooltip_new_data = tooltipMessage[key];
                  
                  jQuery(this).attr({
                    title: tooltip_new_data
                  });
              }
                
           });
           <?php
           }
			}
           if($_REQUEST["page"] == "CF7DBPluginSubmissions"){
           ?>
           jQuery("body").find("#displayform").each(function() {
              
                  var tooltip_new_data = tooltipMessage["displayform"];
                  
                  jQuery(this).attr({
                    title: tooltip_new_data
                  });
               
           });
           <?php } ?>
           jQuery(document).tooltip();
           
        });  
        
          </script> 
        
<?php		
}
	
/*##############ADD TOOLTIP CODE START#############*/

add_action( 'admin_footer', 'custom_admin_pointers_footer' );
function custom_admin_pointers_footer() {
?>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
if(isset($_REQUEST['post']))   
{
$post_type = get_post_type($_REQUEST['post']);	
	if($post_type == 'property')
	{ ?>
	<link rel="stylesheet" href="<?php echo bloginfo('url').'/wp-content/themes/realocation/assets/css/customtooltip.css'; ?>">
	<script src="<?php echo bloginfo('url').'/wp-content/themes/realocation/assets/js/tooltipconstant.js'; ?>"></script>
	<script src="<?php echo bloginfo('url').'/wp-content/themes/realocation/assets/js/customtooltip.js'; ?>"></script>
	<?php }
}
?>
<?php if(isset($_REQUEST['post_type']) && $_REQUEST['post_type'] == 'property') { ?>
  <link rel="stylesheet" href="<?php echo bloginfo('url').'/wp-content/themes/realocation/assets/css/customtooltip.css'; ?>">
  <script src="<?php echo bloginfo('url').'/wp-content/themes/realocation/assets/js/tooltipconstant.js'; ?>"></script>
  <script src="<?php echo bloginfo('url').'/wp-content/themes/realocation/assets/js/customtooltip.js'; ?>"></script>
	<?php } ?>
	
<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'CF7DBPluginSubmissions') { ?>
  <link rel="stylesheet" href="<?php echo bloginfo('url').'/wp-content/themes/realocation/assets/css/customtooltip.css'; ?>">
  <script src="<?php echo bloginfo('url').'/wp-content/themes/realocation/assets/js/tooltipconstant.js'; ?>"></script>
  <script src="<?php echo bloginfo('url').'/wp-content/themes/realocation/assets/js/customtooltip.js'; ?>"></script>
	<?php } ?>
<?php 
}
/*##############ADD TOOLTIP CODE END#############*/

/*##############REMOVE CONTACT FORM FROM ADMIN MENU FOR AUTHOR #############*/

add_action('admin_menu', 'remove_menus_data');

function remove_menus_data () {
    
    global $menu;
	$restricted = array(__('Contact'),__('Media'));
         global $current_user;
             get_currentuserinfo();
    
             if(!current_user_can('administrator')){
                end ($menu);
                while (prev($menu)){
                        $value = explode(' ',$menu[key($menu)][0]);
                        if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
                }
             }
    
}

/*##############ADDING PHONE NUMBER VALIDATION FOR PHONE NUMBER#############*/

/*
Validate Numbers in Contact Form 7
This is for 10 digit numbers
*/

function is_number( $result, $tag ) {
$type = $tag['type'];
$name = $tag['name'];

if ($name == 'phone' || $name == 'fax') { // Validation applies to these textfield names. Add more with || inbetween
$stripped = preg_replace( '/\D/', '', $_POST[$name] );
$_POST[$name] = $stripped;
if( strlen( $_POST[$name] ) != 10 ) { // Number string must equal this
$result['valid'] = false;
$result['reason'][$name] = $_POST[$name] = 'Please enter a 10 digit phone number.';
}
}
return $result;
}

add_filter( 'wpcf7_validate_text', 'is_number', 10, 2 );
add_filter( 'wpcf7_validate_text*', 'is_number', 10, 2 );


function my_assets() {
	wp_enqueue_script( 'frontend-custom-js', get_stylesheet_directory_uri() . '/js/frontend-custom.js', array( 'jquery' ) );
}

add_action( 'wp_enqueue_scripts', 'my_assets' );

//change menu sequence in builder panel
function custom_menu_order($menu_ord) {
    if (!$menu_ord) return true;
    return array(
		'edit.php?post_type=property', // Pages
		'CF7DBPluginSubmissions', // Pages
    );
}
function edit_admin_menus() {
    global $menu;
    global $submenu;
	$menu[47][0] = 'Manage Property';
	if(!current_user_can('administrator')){
    remove_menu_page('edit.php?post_type=agent');
	add_action('admin_footer', 'remove_average_price');
	}
}
add_action( 'admin_menu', 'edit_admin_menus' );
function remove_average_price()
{ ?>
<script>
jQuery(document).ready(function(){
	jQuery('.separator').each(function(){jQuery(this).parent().remove();});
	jQuery( "[name='hf_property_monthly_average_price']" ).remove();
});
</script> 	
<?php }
/*if(!current_user_can('administrator'))
{*/
add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
add_filter('menu_order', 'custom_menu_order');
//}
function RemoveAddMediaButtonsForNonAdmins()
{
	
   // if ( !current_user_can( 'manage_options' ) ) {
        remove_action( 'media_buttons', 'media_buttons' );
  //  }
}

/*if(isset($_GET['post_type']) && $_GET['post_type'] == 'property')
{	
add_action('admin_head', 'RemoveAddMediaButtonsForNonAdmins');
}*/
	
$property_id = get_post_type($_GET['post']);
	if(trim($property_id) == 'property' || $_REQUEST["post_type"] == "property")
	{
	add_action('admin_head', 'RemoveAddMediaButtonsForNonAdmins');
	
	}


add_action('do_meta_boxes', 'wpse33063_move_meta_box');
function wpse33063_move_meta_box()
{
    remove_meta_box( 'postimagediv', 'property', 'side' );
    add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', 'property', 'side', 'high');
}
function getHydravalue($id, $field)
{
	if(!empty($field))
	{
		print hydra_render_field(get_the_ID(), $field);
	}
}
add_action('wp_getHydravalue','getHydravalue',5,2);

function count_digit($number) {
  return strlen($number);
}
function divider($number_of_digits) {
  $tens="1";
  while(($number_of_digits-1)>0)
  {
    $tens.="0";
    $number_of_digits--;
  }
  return $tens;
}

function getHydrametaTerm($post_id, $meta_key)
{
	global $wpdb;
	$property = get_post_meta($post_id,$meta_key,true);
	if(!empty($property))
	{
	$propertyunseri = maybe_unserialize($property);
	$amenities = implode('","',$propertyunseri['items'][0]['value']);
	$data = $wpdb->get_results('SELECT name FROM wp_terms WHERE term_id IN ("'.$amenities.'")');
	$fdata = array();
	foreach($data as $val)
	{
		$fdata[] = $val->name;
	}
	return $fdata;
	}
	else{
		return '';
	}
	
}
function getHydrameta($post_id, $meta_key, $image='')
{
	$property = get_post_meta($post_id,$meta_key,true);
	if(!empty($property))
	{
	$propertyunseri = maybe_unserialize($property);
	
	if($image != '')
	{
	return $propertyunseri['items'][0][$image];	
	}
	else{
	return $propertyunseri['items'][0]['value'];
	}	
	
	}
	else{
	return '';	
	}
}
add_action('admin_footer', 'add_title_to_editor');
function add_title_to_editor() {
    global $post;
    if (get_post_type($post) == 'property') : ?>
        <script> jQuery('<h2>Add Property Description</h2>').insertBefore('#wp-content-editor-tools'); 
		jQuery('<h2>Add Property Name</h2>').insertBefore('#titlediv'); </script>
    <? endif;
}

function showMap($post_id)
{
	$month = ['hf_property_jan','hf_property_feb','hf_property_mar','hf_property_apr','hf_property_may','hf_property_june','hf_property_july','hf_property_aug','hf_property_sep','hf_property_oct','hf_property_nov','hf_property_dec'];
	$a = 0;
	foreach($month as $m)
	{
		if(getHydrameta($post_id,$m)=='')
		{
			
		}
		else
		{
		$a++;
		break;
		} 
	}
	if($a == 0)
	{
	return false;	
	}    
	else
	{
	return true;		
	}
}

add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

function myEndSession() {
    session_destroy();
}

/*function add_jquery_data() {
    global $parent_file;

  //  echo plugin_dir_url( __FILE__ );die;

    if ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'property' && $parent_file == 'edit.php') {

       // wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . '/myscript.js' );
        wp_enqueue_script( 'my_custom_script', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js' );
        wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ).'/js/admin_common.js' );

    }
}*/

function my_enqueue() {
    global $parent_file;
    //echo "dfd";die;

    //wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . '/myscript.js' );
    wp_enqueue_script( 'my_custom_script', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js' );
    wp_enqueue_script( 'my_custom_common_script', site_url().'/wp-content/themes/realocation/js/admin_common.js' );

}
add_filter('admin_enqueue_scripts', 'my_enqueue');