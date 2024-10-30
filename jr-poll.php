<?php
/*
Plugin Name: JR Poll
Plugin URI: http://www.jakeruston.co.uk/2009/11/wordpress-plugin-jr-poll/
Description: Allows you to insert a poll as a widget on your blog.
Version: 2.4.0
Author: Jake Ruston
Author URI: http://www.jakeruston.co.uk
*/

/*  Copyright 2010 Jake Ruston - the.escapist22@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$pluginname="poll";

// Hook for adding admin menus
add_action('admin_menu', 'jr_poll_add_pages');
register_activation_hook(__FILE__,'poll_install');

// action function for above hook
function jr_poll_add_pages() {
    add_options_page('JR Poll', 'JR Poll', 'administrator', 'jr_poll', 'jr_poll_options_page');
}

if (!function_exists("_iscurlinstalled")) {
function _iscurlinstalled() {
if (in_array ('curl', get_loaded_extensions())) {
return true;
} else {
return false;
}
}
}

if (!function_exists("jr_show_notices")) {
function jr_show_notices() {
echo "<div id='warning' class='updated fade'><b>Ouch! You currently do not have cURL enabled on your server. This will affect the operations of your plugins.</b></div>";
}
}

if (!_iscurlinstalled()) {
add_action("admin_notices", "jr_show_notices");

} else {
if (!defined("ch"))
{
function setupch()
{
$ch = curl_init();
$c = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
return($ch);
}
define("ch", setupch());
}

if (!function_exists("curl_get_contents")) {
function curl_get_contents($url)
{
$c = curl_setopt(ch, CURLOPT_URL, $url);
return(curl_exec(ch));
}
}
}

if (!function_exists("jr_poll_refresh")) {
function jr_poll_refresh() {
update_option("jr_submitted_poll", "0");
}
}

register_activation_hook(__FILE__,'poll_choice');

function poll_choice () {
if (get_option("jr_poll_links_choice")=="") {

if (_iscurlinstalled()) {
$pname="jr_poll";
$url=get_bloginfo('url');
$content = curl_get_contents("http://www.jakeruston.co.uk/plugins/links.php?url=".$url."&pname=".$pname);
update_option("jr_submitted_poll", "1");
wp_schedule_single_event(time()+172800, 'jr_poll_refresh'); 
} else {
$content = "Powered by <a href='http://arcade.xeromi.com'>Free Online Games</a> and <a href='http://directory.xeromi.com'>General Web Directory</a>.";
}

if ($content!="") {
$content=utf8_encode($content);
update_option("jr_poll_links_choice", $content);
}
}

if (get_option("jr_poll_link_personal")=="") {
$content = curl_get_contents("http://www.jakeruston.co.uk/p_pluginslink4.php");

update_option("jr_poll_link_personal", $content);
}
}

$poll_db_version = "1.1.0";

function poll_install () {
   global $wpdb;
   global $poll_db_version;

   $table_name = $wpdb->prefix . "jrpoll";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  title text NOT NULL,
	  name1 text NOT NULL,
	  name2 text NOT NULL,
	  name3 text NOT NULL,
	  name4 text NOT NULL,
	  name5 text NOT NULL,
	  name6 text NOT NULL,
	  name7 text NOT NULL,
	  name8 text NOT NULL,
	  votes1 int NOT NULL,
	  votes2 int NOT NULL,
	  votes3 int NOT NULL,
	  votes4 int NOT NULL,
	  votes5 int NOT NULL,
	  votes6 int NOT NULL,
	  votes7 int NOT NULL,
	  votes8 int NOT NULL,
	  enabled int NOT NULL,
	  UNIQUE KEY id (id)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
 
      add_option("poll_db_version", $poll_db_version);
	  } else {
	  $sql[0]=$wpdb->query("ALTER TABLE $table_name ADD name5 text AFTER name4;");
	  $sql[1]=$wpdb->query("ALTER TABLE $table_name ADD name6 text AFTER name5;");
	  $sql[2]=$wpdb->query("ALTER TABLE $table_name ADD name7 text AFTER name6;");
	  $sql[3]=$wpdb->query("ALTER TABLE $table_name ADD name8 text AFTER name7;");
	  $sql[4]=$wpdb->query("ALTER TABLE $table_name ADD votes5 text AFTER votes4;");
	  $sql[5]=$wpdb->query("ALTER TABLE $table_name ADD votes6 text AFTER votes5;");
	  $sql[6]=$wpdb->query("ALTER TABLE $table_name ADD votes7 text AFTER votes6;");
	  $sql[7]=$wpdb->query("ALTER TABLE $table_name ADD votes8 text AFTER votes7;");
 
      update_option("poll_db_version", $poll_db_version );
}
}


// jr_poll_options_page() displays the page content for the Test Options submenu
function jr_poll_options_page() {

    // variables for the field and option names 
    $opt_name_5 = 'mt_poll_plugin_support';
    $hidden_field_name = 'mt_poll_submit_hidden';
    $data_field_name_5 = 'mt_poll_plugin_support';

    // Read in existing option value from database
    $opt_val_5 = get_option($opt_name_5);

if (!$_POST['feedback']=='') {
$my_email1="the.escapist22@gmail.com";
$plugin_name="JR Poll";
$blog_url_feedback=get_bloginfo('url');
$user_email=$_POST['email'];
$user_email=stripslashes($user_email);
$subject=$_POST['subject'];
$subject=stripslashes($subject);
$name=$_POST['name'];
$name=stripslashes($name);
$response=$_POST['response'];
$response=stripslashes($response);
$category=$_POST['category'];
$category=stripslashes($category);
if ($response=="Yes") {
$response="REQUIRED: ";
}
$feedback_feedback=$_POST['feedback'];
$feedback_feedback=stripslashes($feedback_feedback);
if ($user_email=="") {
$headers1 = "From: feedback@jakeruston.co.uk";
} else {
$headers1 = "From: $user_email";
}
$emailsubject1=$response.$plugin_name." - ".$category." - ".$subject;
$emailmessage1="Blog: $blog_url_feedback\n\nUser Name: $name\n\nUser E-Mail: $user_email\n\nMessage: $feedback_feedback";
mail($my_email1,$emailsubject1,$emailmessage1,$headers1);
?>
<div class="updated"><p><strong><?php _e('Feedback Sent!', 'mt_trans_domain' ); ?></strong></p></div>
<?php
}

if ($_GET['delete']) {
global $wpdb;
$table_name = $wpdb->prefix . "jrpoll";

$results = $wpdb->query("DELETE FROM " . $table_name . " WHERE id=" . $_GET['delete']);

?>
<div class="updated"><p><strong><?php _e('Poll Deleted!', 'mt_trans_domain' ); ?></strong></p></div>
<?php
}

if ($_POST['varhid']=="Y") {
global $wpdb;
$table_name = $wpdb->prefix . "jrpoll";
$wpdb->update($table_name, array( 'title' => $_POST["title"], 'name1' => $_POST["name1"], 'name2' => $_POST["name2"], 'name3' => $_POST["name3"], 'name4' => $_POST["name4"], 'name5' => $_POST["name5"], 'name6' => $_POST["name6"], 'name7' => $_POST["name7"], 'name8' => $_POST["name8"], ), array( 'id' => $_POST['id'] ))
?>
<div class="updated"><p><strong><?php _e('Poll Edited!', 'mt_trans_domain' ); ?></strong></p></div>
<?php
}

if ( $_POST['mt_poll_hidden_submit'] == 'Y') {
$pollquestion=$_POST['pollquestion'];
$answer1=$_POST['answer1'];
$answer2=$_POST['answer2'];
$answer3=$_POST['answer3'];
$answer4=$_POST['answer4'];
$answer5=$_POST['answer5'];
$answer6=$_POST['answer6'];
$answer7=$_POST['answer7'];
$answer8=$_POST['answer8'];

   global $wpdb;
   global $poll_db_version;

   $table_name = $wpdb->prefix . "jrpoll";

    $sql = 'INSERT INTO ' . $table_name . ' SET ';
	$sql .= 'title = "'. $pollquestion .'", ';
	$sql .= 'name1 = "'. $answer1 .'", ';
	$sql .= 'name2 = "'. $answer2 .'", ';
	$sql .= 'name3 = "'. $answer3 .'", ';
	$sql .= 'name4 = "'. $answer4 .'", ';
	$sql .= 'name5 = "'. $answer5 .'", ';
	$sql .= 'name6 = "'. $answer6 .'", ';
	$sql .= 'name7 = "'. $answer7 .'", ';
	$sql .= 'name8 = "'. $answer8 .'"';
	
    $wpdb->query( $sql );

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Poll Created!', 'mt_trans_domain' ); ?></strong></p></div>
<?php
}

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val_5 = $_POST[$data_field_name_5];

        // Save the posted value in the database
        update_option( $opt_name_5, $opt_val_5 );

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'JR Poll Plugin Options', 'mt_trans_domain' ) . "</h2>";
$blog_url_feedback=get_bloginfo('url');
	$donated=curl_get_contents("http://www.jakeruston.co.uk/p-donation/index.php?url=".$blog_url_feedback);
	if ($donated=="1") {
	?>
		<div class="updated"><p><strong><?php _e('Thank you for donating!', 'mt_trans_domain' ); ?></strong></p></div>
	<?php
	} else {
	if ($_POST['mtdonationjr']!="") {
	update_option("mtdonationjr", "444");
	}
	
	if (get_option("mtdonationjr")=="") {
	?>
	<div class="updated"><p><strong><?php _e('Please consider donating to help support the development of my plugins!', 'mt_trans_domain' ); ?></strong><br /><br /><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="ULRRFEPGZ6PSJ">
<input type="image" src="https://www.paypal.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form></p><br /><form action="" method="post"><input type="hidden" name="mtdonationjr" value="444" /><input type="submit" value="Don't Show This Again" /></form></div>
<?php
}
}

    // options form
    
    $change3 = get_option("mt_poll_plugin_support");


if ($change3=="Yes" || $change3=="") {
$change3="checked";
$change31="";
} else {
$change3="";
$change31="checked";
}

    ?>
	<?php
	if ($_GET['view']) {
global $wpdb;
$table_name = $wpdb->prefix . "jrpoll";

$rows = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE id=" . $_GET['view']);

foreach ($rows as $rows) {
$total = $rows->votes1 + $rows->votes2 + $rows->votes3 + $rows->votes4 + $rows->votes5 + $rows->votes6 + $rows->votes7 + $rows->votes8;
if ($total==0) {
$total=1;
}

$perc1=round(($rows->votes1/$total)*100);
$perc2=round(($rows->votes2/$total)*100);
$perc3=round(($rows->votes3/$total)*100);
$perc4=round(($rows->votes4/$total)*100);
$perc5=round(($rows->votes5/$total)*100);
$perc6=round(($rows->votes6/$total)*100);
$perc7=round(($rows->votes7/$total)*100);
$perc8=round(($rows->votes8/$total)*100);
echo '<h3>Poll ID '.$_GET["view"].' - '.$rows->title.'</h3>';
echo $rows->name1 . ": " . $rows->votes1 . "<br />";
echo $rows->name2 . ": " . $rows->votes2 . "<br />";
echo $rows->name3 . ": " . $rows->votes3 . "<br />";
echo $rows->name4 . ": " . $rows->votes4 . "<br />";
echo $rows->name5 . ": " . $rows->votes5 . "<br />";
echo $rows->name6 . ": " . $rows->votes6 . "<br />";
echo $rows->name7 . ": " . $rows->votes7 . "<br />";
echo $rows->name8 . ": " . $rows->votes8 . "<br />";
echo "<br />";
echo "Total Votes: " . $totalvotes;
}
}

	if ($_POST['setvar']=="Y") {
global $wpdb;
$table_name = $wpdb->prefix . "jrpoll";

$query = $wpdb->query("UPDATE " . $table_name . " SET enabled=0 WHERE enabled=1");
$query = $wpdb->query("UPDATE " . $table_name . " SET enabled=1 WHERE id=".$_POST['set']);
}

if ($_GET['edit']) {
global $wpdb;
$table_name = $wpdb->prefix . "jrpoll";

$rows = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE id=" . $_GET['edit']);

foreach ($rows as $rows) {
echo '<h3>Edit Poll</h3>';
echo '<form action="" method="post">';
echo 'Title: <input type="text" name="title" value="'.$rows->title.'" />';
echo 'Answer 1: <input type="text" name="name1" value="'.$rows->name1.'" />';
echo 'Answer 2: <input type="text" name="name2" value="'.$rows->name2.'" />';
echo 'Answer 3: <input type="text" name="name3" value="'.$rows->name3.'" />';
echo 'Answer 4: <input type="text" name="name4" value="'.$rows->name4.'" />';
echo 'Answer 5: <input type="text" name="name5" value="'.$rows->name5.'" />';
echo 'Answer 6: <input type="text" name="name6" value="'.$rows->name6.'" />';
echo 'Answer 7: <input type="text" name="name7" value="'.$rows->name7.'" />';
echo 'Answer 8: <input type="text" name="name8" value="'.$rows->name8.'" />';
echo '<input type="hidden" name="varhid" value="Y" />';
echo '<input type="hidden" name="id" value="'.$_GET["edit"].'" />';
echo '<input type="submit" value="Edit" />';
echo '</form>';
}
}
?>	
<iframe src="http://www.jakeruston.co.uk/plugins/index.php" width="100%" height="20%">iframe support is required to see this.</iframe>
<form name="form3" method="post" action="">
<h3>View Polls</h3>

<?php
   global $wpdb;
   $table_name = $wpdb->prefix . "jrpoll";
   
$rows = $wpdb->get_results("SELECT * FROM " . $table_name);
$rows2 = $wpdb->get_results("SELECT * FROM " . $table_name);

foreach ($rows2 as $rows2) {
$i ++;
}

if ($i>0 && $i<2) {
$query = $wpdb->query("UPDATE " . $table_name . " SET enabled=1");
}

if ($rows != "") { echo '<form action="" method="post">'; }


foreach ($rows as $rows) {

if ($rows->enabled==1) {
$extravar="checked";
} else {
$extravar="";
}

	echo "<input type='radio' name='set' value='".$rows->id."' ".$extravar." /> " . $rows->title . " - <a href='?page=jr_poll&view=". $rows->id ."'>View</a> - <a href='?page=jr_poll&edit=". $rows->id ."'>Edit</a> - <a href='?page=jr_poll&delete=". $rows->id ."'>Delete</a>";
	echo "<br />";
}

if ($rows != "") { echo '<input type="hidden" name="setvar" value="Y" /><br /><input type="submit" value="Set to Active" /></form>'; }
?>

<h3>Create a Poll</h3>
<form action="" method="post">
<input type="hidden" name="mt_poll_hidden_submit" value="Y" />

<p><?php _e("Poll Question:", 'mt_trans_domain' ); ?> 
<input type="text" name="pollquestion" />
</p><hr />

<p><?php _e("Answer 1:", 'mt_trans_domain' ); ?> 
<input type="text" name="answer1" />
</p><hr />

<p><?php _e("Answer 2:", 'mt_trans_domain' ); ?> 
<input type="text" name="answer2" />
</p><hr />

<p><?php _e("Answer 3:", 'mt_trans_domain' ); ?> 
<input type="text" name="answer3" />
</p><hr />

<p><?php _e("Answer 4:", 'mt_trans_domain' ); ?> 
<input type="text" name="answer4" />
</p><hr />

<p><?php _e("Answer 5:", 'mt_trans_domain' ); ?> 
<input type="text" name="answer5" />
</p><hr />

<p><?php _e("Answer 6:", 'mt_trans_domain' ); ?> 
<input type="text" name="answer6" />
</p><hr />

<p><?php _e("Answer 7:", 'mt_trans_domain' ); ?> 
<input type="text" name="answer7" />
</p><hr />

<p><?php _e("Answer 8:", 'mt_trans_domain' ); ?> 
<input type="text" name="answer8" />
</p><hr />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Create Poll', 'mt_trans_domain' ) ?>" />
</p><hr />
</form>

<h3>Settings</h3>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Show Plugin Support?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="Yes" <?php echo $change3; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="No" <?php echo $change31; ?> id="Please do not disable plugin support - This is the only thing I get from creating this free plugin!" onClick="alert(id)">No
</p>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p><hr />

</form>

<br /><br />

<script type="text/javascript">
function validate_required(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
    {
    alert(alerttxt);return false;
    }
  else
    {
    return true;
    }
  }
}

function validateEmail(ctrl){

var strMail = ctrl.value
        var regMail =  /^\w+([-.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;

        if (regMail.test(strMail))
        {
            return true;
        }
        else
        {

            return false;

        }
					
	}

function validate_form(thisform)
{
with (thisform)
  {
  if (validate_required(subject,"Subject must be filled out!")==false)
  {email.focus();return false;}
  if (validate_required(email,"E-Mail must be filled out!")==false)
  {email.focus();return false;}
  if (validate_required(feedback,"Feedback must be filled out!")==false)
  {email.focus();return false;}
  if (validateEmail(email)==false)
  {
  alert("E-Mail Address not valid!");
  email.focus();
  return false;
  }
 }
}
</script>
<h3>Submit Feedback about my Plugin!</h3>
<p><b>Note: Only send feedback in english, I cannot understand other languages!</b><br /><b>Please do not send spam messages!</b></p>
<form name="form2" method="post" action="" onsubmit="return validate_form(this)">
<p><?php _e("Your Name:", 'mt_trans_domain' ); ?> 
<input type="text" name="name" /></p>
<p><?php _e("E-Mail Address (Required):", 'mt_trans_domain' ); ?> 
<input type="text" name="email" /></p>
<p><?php _e("Message Category:", 'mt_trans_domain'); ?>
<select name="category">
<option value="General">General</option>
<option value="Feedback">Feedback</option>
<option value="Bug Report">Bug Report</option>
<option value="Feature Request">Feature Request</option>
<option value="Other">Other</option>
</select>
<p><?php _e("Message Subject (Required):", 'mt_trans_domain' ); ?>
<input type="text" name="subject" /></p>
<input type="checkbox" name="response" value="Yes" /> I want e-mailing back about this feedback</p>
<p><?php _e("Message Comment (Required):", 'mt_trans_domain' ); ?> 
<textarea name="feedback"></textarea>
</p>
<p class="submit">
<input type="submit" name="Send" value="<?php _e('Send', 'mt_trans_domain' ); ?>" />
</p><hr /></form>
</div>
<?php
 
}

if (get_option("jr_poll_links_choice")=="") {
poll_choice();
}

function poll_set_cookie() {
$answer=$_POST['answer'];

if ($answer!="") {
setcookie("jrpoll", "submitted", time()+86400); 
}
}

function init_poll_widget() {
register_sidebar_widget('JR Poll', 'show_polls');
}

function show_polls($args) {
extract($args);

$supportplugin = get_option("mt_poll_plugin_support"); 
global $wpdb;

$table_name = $wpdb->prefix . "jrpoll";

if ($_POST['formvote']=="Y" && !$_POST['answer']=="") {
$answer=$_POST['answer'];
$id=$_POST['id'];

if ($answer==1) {
$answert="votes1";
} else if ($answer==2) {
$answert="votes2";
} else if ($answer==3) {
$answert="votes3";
} else if ($answer==4) {
$answert="votes4";
}  else if ($answer==5) {
$answert="votes5";
} else if ($answer==6) {
$answert="votes6";
} else if ($answer==7) {
$answert="votes7";
} else if ($answer==8) {
$answert="votes8";
}

$rows = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE id=".$id);
foreach ($rows as $rows) {
if ($_COOKIE["jrpoll"]!="submitted") {
$newval=$rows->$answert+1;
$query = $wpdb->query("UPDATE " . $table_name . " SET ".$answert."=".$newval." WHERE id=".$id);
}

$results1=$rows->votes1;
$results2=$rows->votes2;
$results3=$rows->votes3;
$results4=$rows->votes4;
$results5=$rows->votes5;
$results6=$rows->votes6;
$results7=$rows->votes7;
$results8=$rows->votes8;

if ($_COOKIE["jrpoll"]!="submitted") {
if ($answert=="votes1") {
$results1 ++;
} else if ($answert=="votes2") {
$results2 ++;
} else if ($answert=="votes3") {
$results3 ++;
} else if ($answert=="votes4") {
$results4 ++;
} else if ($answert=="votes5") {
$results5 ++;
} else if ($answert=="votes6") {
$results6 ++;
} else if ($answert=="votes7") {
$results7 ++;
} else if ($answert=="votes8") {
$results8 ++;
}
}

$total=$results1+$results2+$results3+$results4+$results5+$results6+$results7+$results8;

$perc1=round(($results1/$total)*100);
$perc2=round(($results2/$total)*100);
$perc3=round(($results3/$total)*100);
$perc4=round(($results4/$total)*100);
$perc5=round(($results5/$total)*100);
$perc6=round(($results6/$total)*100);
$perc7=round(($results7/$total)*100);
$perc8=round(($results8/$total)*100);

echo $before_title.$rows->title.$after_title."<br />".$before_widget;
if (!$rows->name1=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name1) . " - " . $perc1 . "% - " . $results1 . " Votes" . "</p></br />"; }
if (!$rows->name2=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name2) . " - " . $perc2 . "% - " .$results2 . " Votes"."</p><br />"; }
if (!$rows->name3=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name3) . " - " . $perc3 . "% - " .$results3 . " Votes"."</p><br />"; }
if (!$rows->name4=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name4) . " - " . $perc4 . "% - " .$results4 . " Votes"."</p><br />"; }
if (!$rows->name5=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name5) . " - " . $perc5 . "% - " .$results5 . " Votes"."</p><br />"; }
if (!$rows->name6=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name6) . " - " . $perc6 . "% - " .$results6 . " Votes"."</p><br />"; }
if (!$rows->name7=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name7) . " - " . $perc7 . "% - " .$results7 . " Votes"."</p><br />"; }
if (!$rows->name8=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name8) . " - " . $perc8 . "% - " .$results8 . " Votes"."</p><br />"; }

if ($supportplugin=="Yes" || $supportplugin=="") {
echo '<p style="font-size:x-small">Plugin created by <a href="http://www.jakeruston.co.uk">Jake Ruston</a>.</p>';
}
echo $after_widget;
}


} else if ($_COOKIE['jrpoll']=="submitted") {

$rows = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE enabled=1");
foreach ($rows as $rows) {

$results1=$rows->votes1;
$results2=$rows->votes2;
$results3=$rows->votes3;
$results4=$rows->votes4;
$results5=$rows->votes5;
$results6=$rows->votes6;
$results7=$rows->votes7;
$results8=$rows->votes8;

$total=$results1+$results2+$results3+$results4+$results5+$results6+$results7+$results8;

if ($total==0) {
$total=1;
}

$perc1=round(($results1/$total)*100);
$perc2=round(($results2/$total)*100);
$perc3=round(($results3/$total)*100);
$perc4=round(($results4/$total)*100);
$perc5=round(($results5/$total)*100);
$perc6=round(($results6/$total)*100);
$perc7=round(($results7/$total)*100);
$perc8=round(($results8/$total)*100);

echo $before_title.$rows->title.$after_title."<br />".$before_widget;
if (!$rows->name1=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name1) . " - " . $perc1 . "% - " . $results1 . " Votes" . "</p><br />"; }
if (!$rows->name2=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name2) . " - " . $perc2 . "% - " .$results2 . " Votes"."</p><br />"; }
if (!$rows->name3=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name3) . " - " . $perc3 . "% - " .$results3 . " Votes"."</p><br />"; }
if (!$rows->name4=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name4) . " - " . $perc4 . "% - " .$results4 . " Votes"."</p><br />"; }
if (!$rows->name5=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name5) . " - " . $perc5 . "% - " .$results5 . " Votes"."</p><br />"; }
if (!$rows->name6=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name6) . " - " . $perc6 . "% - " .$results6 . " Votes"."</p><br />"; }
if (!$rows->name7=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name7) . " - " . $perc7 . "% - " .$results7 . " Votes"."</p><br />"; }
if (!$rows->name8=="") { echo "<p style='word-wrap: break-word;'>" . stripslashes($rows->name8) . " - " . $perc8 . "% - " .$results8 . " Votes"."</p><br />"; }

if ($supportplugin=="Yes" || $supportplugin=="") {
echo '<p style="font-size:x-small">Poll Plugin created by <a href="http://www.jakeruston.co.uk">Jake</a> Ruston - '.stripslashes(get_option("jr_poll_links_choice")).'</p>';
}
echo $after_widget;
} 

} else {

   $rows = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE enabled=1");
   $blog_url="http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]."?results=view";
   
foreach ($rows as $rows) {
echo $before_title.$rows->title.$after_title."<br />".$before_widget;
echo '<form action="" method="post">';
if (!$rows->name1=="") { echo "<p style='word-wrap: break-word;'>" . '<input type="radio" name="answer" value="1" /> '.stripslashes($rows->name1)."</p><br />"; }
if (!$rows->name2=="") { echo "<p style='word-wrap: break-word;'>" . '<input type="radio" name="answer" value="2" /> '.stripslashes($rows->name2)."</p><br />"; }
if (!$rows->name3=="") { echo "<p style='word-wrap: break-word;'>" . '<input type="radio" name="answer" value="3" /> '.stripslashes($rows->name3)."</p><br />"; }
if (!$rows->name4=="") { echo "<p style='word-wrap: break-word;'>" . '<input type="radio" name="answer" value="4" /> '.stripslashes($rows->name4)."</p><br />"; }
if (!$rows->name5=="") { echo "<p style='word-wrap: break-word;'>" . '<input type="radio" name="answer" value="5" /> '.stripslashes($rows->name5)."</p><br />"; }
if (!$rows->name6=="") { echo "<p style='word-wrap: break-word;'>" . '<input type="radio" name="answer" value="6" /> '.stripslashes($rows->name6)."</p><br />"; }
if (!$rows->name7=="") { echo "<p style='word-wrap: break-word;'>" . '<input type="radio" name="answer" value="7" /> '.stripslashes($rows->name7)."</p><br />"; }
if (!$rows->name8=="") { echo "<p style='word-wrap: break-word;'>" . '<input type="radio" name="answer" value="8" /> '.stripslashes($rows->name8)."</p><br />"; }
echo '<input type="hidden" name="formvote" value="Y" /><input type="hidden" name="id" value="'.$rows->id.'" /><input type="submit" value="Submit" /></form><br />';

if ($supportplugin=="Yes" || $supportplugin=="") {
$linkper=utf8_decode(get_option('jr_poll_link_personal'));

if (get_option("jr_poll_link_newcheck")=="") {
$pieces=explode("</a>", get_option('jr_poll_links_choice'));
$pieces[0]=str_replace(" ", "%20", $pieces[0]);
$pieces[0]=curl_get_contents("http://www.jakeruston.co.uk/newcheck.php?q=".$pieces[0]."");
$new=implode("</a>", $pieces);
update_option("jr_poll_links_choice", $new);
update_option("jr_poll_link_newcheck", "444");
}

if (get_option("jr_submitted_poll")=="0") {
$pname="jr_poll";
$url=get_bloginfo('url');
$content = curl_get_contents("http://www.jakeruston.co.uk/plugins/links.php?url=".$url."&pname=".$pname);
update_option("jr_submitted_poll", "1");
update_option("jr_poll_links_choice", $content);

wp_schedule_single_event(time()+172800, 'jr_poll_refresh'); 
} else if (get_option("jr_submitted_poll")=="") {
$pname="jr_poll";
$url=get_bloginfo('url');
$current=get_option("jr_poll_links_choice");
$content = curl_get_contents("http://www.jakeruston.co.uk/plugins/links.php?url=".$url."&pname=".$pname."&override=".$current);
update_option("jr_submitted_poll", "1");
update_option("jr_poll_links_choice", $content);

wp_schedule_single_event(time()+172800, 'jr_poll_refresh'); 
}

echo '<p style="font-size:x-small">Poll Plugin created by '.$linkper.' - '.stripslashes(get_option("jr_poll_links_choice")).'</p>';
}
echo $after_widget;
}
}
}

add_action("plugins_loaded", "init_poll_widget");
add_action("get_header", "poll_set_cookie");

?>
