<?php 
add_shortcode( 'quiz_test', 'wbq_shortcode_handler' );
function wbq_shortcode_handler( $atts, $content = null ) {
	return wbq_generate_quiz( $atts['id'] );
}

?>