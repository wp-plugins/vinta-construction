<?php
/*
Plugin Name: Vinta Construction
Plugin URI: http://vasthtml.com
Description: Puts a under construction or under maintenance splash screen on your Wordpress blog. Use the options page to configure all aspecs of the page. This is a premium plugin.  
Author: Eric Hamby
Version: 1.0
Author URI: http://vasthtml.com/
Co Author: Ben
Co Author Website: http://ben.nightspirit.nl/ 
*/

$plugin_dir = basename(dirname(__FILE__));
$vintadir = get_settings('home').'/wp-content/plugins/'.$plugin_dir;
$vintahomefile = $vintadir.'/vinta-construction.php';
$vintalogo = $vintadir.'/images/help.png'; 

function vinta_admin_css() {
  if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
    include_once('css/admin_head_css_ie.php'); } else { include_once('css/admin_head_css.php');
  }
}
function vinta_get_plugin_name(){
	global $plugin_dir;
	$theme_data = implode('', file(ABSPATH."/wp-content/plugins/".$plugin_dir."/vinta-construction.php"));
	if (preg_match("|Plugin Name:(.*)|i", $theme_data, $vinta_name)) {
		$vinta_name = $vinta_name[1];
	}
	return $vinta_name;
} 
function vinta_get_version(){
	global $plugin_dir;
	$theme_data = implode('', file(ABSPATH."/wp-content/plugins/".$plugin_dir."/vinta-construction.php"));
	if (preg_match("|Version:(.*)|i", $theme_data, $vinta_version)) {
		$vinta_version = $vinta_version[1];
	}
	return $vinta_version;
} 
add_action('admin_head', 'vinta_admin_css');
require_once('vasthtml_vinta_updater.php');
add_action('admin_menu', 'vinta_info_page'); 
function vinta_info_page() {
global $vintalogo;
$mypage = add_menu_page('Vinta Construction', 'Vinta Const.', 8, 'vinta_info', 'vinta_info', $vintalogo);
}

function vinta_info() {
  echo '<div class="wrap">
  <div id="icon-themes" class="icon32"><br /></div><h2>Plugin Information</h2>
  <p>
  <table class="widefat" id="exampletbl">
  <thead>
    <tr>
	 <th>'.vinta_get_plugin_name().'</th>
      <th><span style="float:right"><small>'.vinta_get_version().'</small></span></th>
    </tr>
  </thead>
  <tr class="alternate">
    <td>Plugin Name:</td>
    <td>'.vinta_get_plugin_name().'</td>
  </tr>
  <tr class="alternate">
    <td>Plugin Version:</td>
    <td>'.vinta_get_version().'</td>
  </tr>
  <tr class="alternate">
    <td>Plugin Build:</td>
    <td>1000</td>
  </tr>
  <tr class="alternate">
    <td>Plugin Type:</td>
    <td>Premium</td>
  </tr>
  <tr class="alternate">
    <td>Rec. Wordpress Version:</td>
    <td>2.7+</td>
  </tr>
  <tr class="alternate">
    <td>Plugin Site:</td>
    <td><a href="http://vasthtml.com" target="_blank">Vast HTML</a></td>
  </tr>
  <tr class="alternate">
    <td>Author:</td>
    <td><a href="http://erichamby.com" target="_blank">Eric Hamby</a></td>
  </tr>
  <tr class="alternate">
    <td>Co Author:</td>
    <td><a href="http://ben.nightspirit.nl/ " target="_blank">Ben</a></td>
  </tr>
  <tr class="alternate">
    <td>Release Date:</td>
    <td>8/30/2009</td>
  </tr>
  <tr class="alternate">
    <td>Support Forums:</td>
    <td><a href="http://vasthtml.com/support/" target="_blank">Vast HTML Support</a></td>
  </tr>
  <tr class="alternate">
    <td>Donations:</td>
    <td><a href="http://vasthtml.com/donations/" target="_blank">Donations Page</a></td>
  </tr>
  <tr class="alternate">
    <td>FAQ:</td>
    <td><a href="http://vasthtml.com/faq/" target="_blank">FAQ Page</a></td>
  </tr>
  <tr class="alternate">
    <td colspan="2"><span class="button" style="float:left"><a href="http://vasthtml.com" target="_blank">Vast HTML</a></span> <span class="button" style="float:right"><a href="http://erichamby.com" target="_blank">Eric Hamby</a></span>
  </tr>
</table>'; ?>
<?php echo '<div id="icon-tools" class="icon32"><br /></div><h2>Plugin Updates</h2>
  <p>'; ?>
  
  
  <?php if (vinta_server_version() > $_SESSION['vinta_version']) { 
	$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://vasthtml.com/themeforms/vinta_update.php');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
	} else { 
	$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://vasthtml.com/themeforms/vinta_no_update.php');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
	} ?>
 <?php 
  	$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://vasthtml.com/themeforms/vinta_version_history.php');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
  ?>
  <?php
echo '</div>';
}

add_action('admin_menu', 'vinta_options');
function vinta_options() {
 $mypage = add_submenu_page('vinta_info', 'Vinta Construction', 'Options', 8, 'vinta_file', 'vinta_file');
  add_action( "admin_print_scripts-$mypage", 'vinta_construction_admin_head' );
}

function vinta_construction_admin_head() {
	global $vintadir;
	wp_enqueue_script('loadjs', $vintadir . '/js/jquery.js');
	wp_enqueue_script('loadjsone', $vintadir . '/js/jquery.checkbox.min.js');
	wp_enqueue_script('loadjstwo', $vintadir . '/js/jsslideone.js');
}

function vinta_file() {
	global $vintadir;
  echo '<div class="wrap">'; ?>
  <form method="post" action="options.php">
 <?php echo '<div id="icon-plugins" class="icon32"><br /></div>
  <h2>'.vinta_get_plugin_name().'</h2>'; ?>   
  <div style="background:#fff9db; border:2px solid #ffe8c4; padding:5px; color:#000;">
  This is a premium plugin. Please visit <a href="http://vasthtml.com/js/vinta-construction-plugin/">Vast HTML</a> to purchase this great Wordpress plugin.
  </div>
 <?php  echo '<p>
  <table class="widefat">
    <thead>
      <tr>
        <th width="250px">Activate & Deactive</th>
		<th></th>
      </tr>
    </thead>'; ?>
<?php echo ' <tr class="alternate">
			<td>Splash Page</td>
			<td>'; ?>
		<input value="true" type="checkbox"<?php checked("true", get_option("")); ?> disabled/>
       <?php echo '<br />This will turn the splash page on or off.'; ?>
<?php echo '</td></tr>'; ?>
  
<?php echo '<tr><td>&nbsp;</td><td>';  ?>
	<span style="float:right"><input type="submit" class="button" value="Save Options" disabled/></span>
<?php echo '</td></tr>'; ?>
		<?php echo '</table></p>'; ?>
        
        
        
       <?php  echo '<div id="icon-options-general" class="icon32"><br /></div>
  <h2>'.vinta_get_plugin_name().' Options</h2>'; ?>  
 <?php  echo '<p>
  <table class="widefat">
    <thead>
      <tr>
        <th width="250px">Plugin Options</th>
		<th></th>
      </tr>
    </thead>'; ?>

<?php echo '<tr class="alternate">
			<td>Logo Image URL</td>
			<td>'; ?>
		<input id="admin_form" value="<?php echo get_option(''); ?>" type="text" />
        <?php echo '<br />If the logo image in on above then you can enter your own logo url here. <br />Leave blank for default.';  ?>
<?php echo '</td></tr>'; ?>

<?php echo '<tr class="alternate">
			<td>Logo Preview</td>
			<td>'; ?>
<img src="<?php echo ($custom_logo = get_option('vinta_logo_url'))!='' ? $custom_logo : $vintadir.'/images/logo.png'; ?>" alt="<?php bloginfo('name'); ?>" />
<?php echo '</td></tr>'; ?>


<?php echo ' <tr class="alternate">
			<td>Header Text</td>
			<td>'; ?>
		<input id="admin_form" value="<?php echo get_option(''); ?>" type="text" />
         <?php echo '<br />Set the text of the header. Leave blank for default.'; ?>
<?php echo '</td></tr>'; ?>

<?php echo ' <tr class="alternate">
			<td>Estimated Time Text</td>
			<td>'; ?>
		<input id="admin_form" value="<?php echo get_option(''); ?>" type="text" />
         <?php echo '<br />Set the text of the header. Leave blank for default.'; ?>
<?php echo '</td></tr>'; ?>

<?php echo ' <tr class="alternate">
			<td>Set Time</td>
			<td>'; ?>
		<input id="admin_form_small" value="<?php echo get_option(''); ?>" type="text"/> this is for the year.<br />
        <input id="admin_form_small" value="<?php echo get_option(''); ?>" type="text"/> This is for the month. (1-12)<br />
        <input id="admin_form_small" value="<?php echo get_option(''); ?>" type="text"/> this is for the day.<br />
        <input id="admin_form_small" value="<?php echo get_option(''); ?>" type="text"/> This is for the hour. (1-24)<br />
        <input id="admin_form_small" value="<?php echo get_option(''); ?>" type="text"/> This is for the minute.
<?php echo '</td></tr>'; ?>

<?php echo ' <tr class="alternate">
			<td>Set The Percentages</td>
			<td>'; ?>
<select name='vinta_update_progress'>
<?php
for ($x=0; $x<=100; $x=$x+10) {
        echo "<option value=".$x;
        if ($x == $vinta_update_progress) { echo " selected"; }
        echo ">".$x."%</option>";
}
?></select>
         <?php echo '<br />Set the percentage of your progress.'; ?>
<?php echo '</td></tr>'; ?>

<?php echo ' <tr class="alternate">
			<td>Progress News Text</td>
			<td>'; ?>
		<input id="admin_form" value="<?php echo get_option(''); ?>" type="text" />
         <?php echo '<br />Leave some information about your progress. Leave blank for default.'; ?>
<?php echo '</td></tr>'; ?>

  
<?php echo '<tr><td>&nbsp;</td><td>';  ?>
	<span style="float:right"><input type="submit" class="button" value="Save Options" disabled/></span>
<?php echo '</td></tr>'; ?>
		<?php echo '</table></p>'; ?>
</form>       
<?php echo ' </div>'; 
} ?>
<?php if ( get_option('vinta_activate') ) : ?>
<?php require_once('vinta-page.php'); ?>
<?php endif; ?>