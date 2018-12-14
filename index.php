<?php

/*
Plugin Name: Members and Email
Plugin URI: https://github.com/dchavours
Description: Acquire users email, then prompt them deeper into becoming a member.
Version: 1.0
Author: Dennis Z. Chavours
Author URI: https://github.com/dchavours

*/

if(!defined('ABSPATH')){
  exit;
}


// Load the script file
require_once(plugin_dir_path(__FILE__) .'/includes/membersemail-scripts.php');


// Register Widget
function register_membersemail(){
  register_widget('Youtube_Subs_Widget');
}





// Creating the menu structure for the backend.
// Includes callback function
add_action("admin_menu", "addMenu");

// add_menu_page = $page_title, $menu_title, $capability, $menu_slug, $function ='', $icon_url='', $position
// callable for add_menu_page =

function addMenu()
{
  add_menu_page   ("Members and Email", "Members / Email", 4, "members-email-1", "MeMenu" );
  add_submenu_page("members-email-1", "Email List", "Email", 4, "members-email-sub-1", "MeMenuSub1");
  add_submenu_page("members-email-1", "Tracking", "Tracking Scripts", 4, "tracking-scripts-1", "MeMenuSub2");


}

function MeMenu()
{
echo "Email List Page" ;


}
//inside the database we are going to call it 'membersemail_header_scripts'
// update_option creates a new option if one doesn't already exists.
function MeMenuSub1()
{

require 'admin/audience.php';

echo $meTable8;




}

function MeMenuSub2(){

  if (array_key_exists('submit_scripts_update', $_POST))
  {
    update_option('membersemail_header_scripts', $_POST['header_scripts']);
    update_option('membersemail_footer_scripts', $_POST['footer_scripts']);
    ?>
<!-- This div is going to create a notification that update has been accomplished -->
    <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><bold> Settings have been updated. </bold>    </div>
    <?php
}

   $header_scripts = get_option('membersemail_header_scripts', 'none');
   $footer_scripts = get_option('membersemail_footer_scripts', 'none');


  ?>
    <!-- Update the options once they submit the page.  -->
 <form method="post" action="">

      <label for="header_scripts">Header Scripts</label>
      <textarea name="header_scripts" class="large-text"><?php print $header_scripts ?> </textarea>
      <label for="footer_scripts">Footer Scripts</label>
      <textarea name="footer_scripts" class="large-text"><?php print $footer_scripts  ?> </textarea>
      <input type="submit" name="submit_scripts_update" class="button button-primary" value="UPDATE SCRIPTS" >
 </form>


 <?php



}










/*
The following two functions are doing the following:
The header and the wp_head added any scripts that are put into the header box
or the footer box. To every page on the Wordpress site.

*/

function membersemail_display_header_scripts()
{
    $header_scripts = get_option('membersemail_header_scripts', 'none');
    print $header_scripts;
}
add_action('wp_head', 'membersemail_display_header_scripts');


function membersemail_display_footer_scripts()
{
  $footer_scripts = get_option('membersemail_footer_scripts', 'none');
  print $footer_scripts;
}
add_action('wp_footer', 'membersemail_display_footer_scripts');


// the variable, string is being extended.
function membersemail_form()
{
    $content = '';
    $content .= '<form method="post" action="http://localhost/wordpress/thank-you/">';

    $content .= '<input type="text" name="full_name" placeholder="Your Full Name"/>';
    $content .= '<br />';

    $content .= '<input type="text" name="email_address" placeholder="Enter Email Address"/>';
    $content .= '<br />';



    $content .= '<input type="submit" name="membersemail_submit_form" value="SUBMIT" >';


    $content .= '</form>';
    return $content;
}
//what/s called on the content side to display the page.
//names should be unique
add_shortcode('membersemailform','membersemail_form');




// capture this information then recieve it through email
// Eventaully be able to see the information from the admin side of wordpress
// Submit inputs to wp_form_submit into the phpMyAdmin.
function membersemail_form_capture()
{
    global $post,$wpdb;
    if(array_key_exists('membersemail_submit_form', $_POST))
    {
        $to = "dchavours@gmail.com";
        $subject = "Data Inputs - me";
        $body = '';

        $body .= 'Name: '. $_POST['full_name'] . '<br />';
        $body .= 'Email: '. $_POST['email_address'] . '<br />';

        wp_mail($to,$subject, $body);

        remove_filter('wp_mail_content_type','set_html_content_type');

        /* add the submission to the database using the table we created */
        $insertData = $wpdb->get_results(" INSERT INTO ".$wpdb->prefix."form_submit (data) VALUES ('".$body."')");


    }

}
add_action('wp_head','membersemail_form_capture');






/*

// Turn the background black, effect.

add_action('wp_enqueue_scripts','plugin_css');

function plugin_css (){

  wp_enqueue_style('MyPluginStyles', plugins_url('/style.css', __FILE__));

}


// Scripts, Java Calling
add_action('wp_enqueue_scripts', 'plugin_scripts');

function plugin_scripts(){
    wp_enqueue_scripts('CalllingTheJS', plugins_url('/scripts.js', __FILE__), array('jquery'), false, true );
}


// stores the HTML to myForm; includes heredocs; $store_me_html is equal to the subsequent HTML.

function store_myForm_01 (){

$store_me_html = <<<EOT


 <div class="form-popup" id="myForm">
      <form action="/action_page.php" class="form-container">
        <h1>Login</h1>

        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" required>

        <button type="submit" class="btn">Login</button>
        <button type="submit" class="btn cancel" onclick="closeForm()">Close</button>
      </form>


</div>
EOT;

}
*/

?>
