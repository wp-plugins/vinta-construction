<?php
if(!function_exists('vinta_construction_page')): 
function wet_maintenance_header($status_header, $header, $text, $protocol) {
	if ( !is_user_logged_in() ) {
		return "$protocol 503 Service Unavailable";
	}
}
endif;
$progress_class = "pr" . $vinta_update_progress;
if(!function_exists('vinta_construction_content')): 
function vinta_construction_content() {
	global $vintadir;
	if (!current_user_can('level_10')) {
	 ?>
     <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="description" content="<?php bloginfo('description'); ?>" />
<title>
<?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('url'); ?>/wp-content/plugins/vinta-construction/css/style.css" type="text/css" />
<link rel="stylesheet" href="<?php bloginfo('url'); ?>/wp-content/plugins/vinta-construction/css/jquery.countdown.css" type="text/css" />
<!--[if IE 6]><link href="<?php bloginfo('url'); ?>/wp-content/plugins/vinta-construction/css/ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
<script type="text/javascript" src="<?php bloginfo('url'); ?>/wp-content/plugins/vinta-construction/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('url'); ?>/wp-content/plugins/vinta-construction/js/jquery.countdown.min.js"></script>
<script type="text/javascript">
	$(function () {
		var liftoffTime = new Date(
								   <?php echo ($custom_text = get_option('')); ?>,
								   <?php echo ($custom_text = get_option('')); ?> - 1,
								   <?php echo ($custom_text = get_option('')); ?>,
								   <?php echo ($custom_text = get_option('')); ?>,
								   <?php echo ($custom_text = get_option('')); ?>
								  );
		$('#counter').countdown({until: liftoffTime, 
		    layout: '{dn} {dl}, {hn} {hl}, {mn} {ml}, {sn} {sl}'});
	});
	</script>
</head>
<!-- Vinta Construction plugin by: http://vasthtml.com -->
<body>
<div id="wrapper">
  <div id="logo">
  <img src="<?php echo ($custom_logo = get_option(''))!='' ? $custom_logo : $vintadir.'/images/logo.png'; ?>" alt="<?php bloginfo('name'); ?>" />
  </div>
  <div id="content_top">
    <h1>
<?php echo ($vasthtml_option = get_option(''))!='' ? $vasthtml_option : "this website is under construction"; ?></h1>
    <h5><?php echo ($vasthtml_option = get_option(''))!='' ? $vasthtml_option : "estimated time remaining before official launch"; ?></h5>
    <!-- Counter script is injected into the h1 tag -->
    <h1 class="countdown" id="counter"></h1>
  </div>
  <div id="content_bottom">
    <div id="progress">
      <!-- Progress Information - #1 -->
      <h2>Nearly <?php echo ($custom_text = get_option('')); ?>% Done!</h2>
      <h5><?php echo ($vasthtml_option = get_option(''))!='' ? $vasthtml_option : "We will be done hopefully very soon. Keep a good watch for us to open."; ?>
      </h5>
    </div>
    <div id="progress_div"></div>
    <!-- Progress Icon - #2 -->
    <div id="progress_slider"><?php echo (get_option('')); ?></div>
    <div id="progress_position">
      <div id="progress_bar_bg">
        <!-- Edit Percentage Below - #3 -->
        <div id="progress_bar" class="pr<?php echo ($custom_text = get_option('')); ?>">
          <div id="progress_left">&nbsp;</div>
          <div id="progress_right">&nbsp;</div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html> 

<?php 
		die($page);
	}
}
endif; 

if(!function_exists('vinta_construction_feed')): 
function vinta_construction_feed() {
	if ( !is_user_logged_in() ) {
		die('<?xml version="1.0" encoding="UTF-8"?>'.
			'<status>Service unavailable</status>');
	}
}
endif;

if(!function_exists('vinta_add_feed_actions')): 
function vinta_add_feed_actions() {
	$feeds = array ('rdf', 'rss', 'rss2', 'atom');
	foreach ($feeds as $feed) {
		add_action('do_feed_'.$feed, 'vinta_construction_feed', 1, 1);		
	}
}
endif;

if (function_exists('add_filter') ):
add_filter('status_header', 'wet_maintenance_header', 10, 4);
add_action('get_header', 'vinta_construction_content');
vinta_add_feed_actions();
else:
// Prevent direct invocation by user agents.
die('Get off my lawn!');
endif;
?>