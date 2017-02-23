<?php
/**
 * Template Name: Send Newsletter
 */
?>
<?php
global $wpdb;

$multiple_recipients = $_POST["user_lead"];
$newsletter_id = $_POST["newsletter"];

$query = "SELECT * from  wp_wysija_email where email_id = ".$newsletter_id;
$results = $wpdb->get_results($query, OBJECT );

$headers = array('Content-Type: text/html; charset=UTF-8','From: WebcluesAdmin <webclues.admn@gmail.com');
$subj = $results[0]->subject;
$body = $results[0]->body;
$res = wp_mail( $multiple_recipients, $subj, $body,$headers );
echo $res;
die;
exit;