<?php
/*
Plugin Name: Wordpress BuzzFeed Style Quizz Lite
Plugin URI: http://voodoopress.net/wordpress-buzzfeed-style-quiz-plugin/
Description: With this  plugin you can create any number of BuzzFeed style Quizzes.
Version: 1.3
Author: Evgen "EvgenDob" Dobrzhanskiy
Author URI: http://voodoopress.net/
Stable tag: 1.3
*/

include('modules/meta_box.php');
include('modules/shortcodes.php');
include('modules/functions.php');
include('modules/hooks.php');
include('modules/cpt.php');
include('modules/scripts.php');

register_activation_hook( __FILE__, 'wbq_activate' );
function wbq_activate() {
}

register_activation_hook( __FILE__, 'wbq_add_post_type' );
register_activation_hook( __FILE__, 'flush_rewrite_rules' );
?>