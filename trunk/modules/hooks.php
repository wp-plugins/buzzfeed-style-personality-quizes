<?php 
add_action('the_content', 'wl_process_content');
function wl_process_content( $content ){
	global $post;
	
	if( get_post_type($post->ID) == 'quiz' ){
		$content = wbq_generate_quiz( $post->ID );
	}
	
	return $content;
}
add_Action( 'wp_head', 'filter_head' );
function filter_head(){
	$config = get_option('wst_options'); 	
	echo '<meta property="fb:app_id" content="'.$config['fb_api'].'" />';
}

// removing default non used functionality
add_filter( 'post_row_actions', 'remove_row_actions', 10, 2 );
function remove_row_actions( $actions, $post )
{
  global $current_screen;
	if( $current_screen->post_type != 'new_quiz' ) return $actions;
	unset( $actions['edit'] );
	unset( $actions['inline hide-if-no-js'] );
	return $actions;
}
?>