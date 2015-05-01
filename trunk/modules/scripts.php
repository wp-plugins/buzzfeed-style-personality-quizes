<?php 

add_action('wp_print_scripts', 'wbq_add_script_fn');
function wbq_add_script_fn(){
	wp_enqueue_style('wbq_bootsrap_css', plugins_url('/inc/assets/css/boot-cont.css', __FILE__ ) ) ;	
	if(is_admin()){	
		wp_enqueue_media(); 
		wp_enqueue_script('wbq_admin_js', plugins_url('/js/admin.js', __FILE__ ), array('jquery' ), '1.0' ) ;
		wp_enqueue_style('wbq_admin_css', plugins_url('/css/admin.css', __FILE__ ) ) ;	
	}else{
		wp_enqueue_style('wbqawesome.min.css', plugins_url('/inc/font-awesome-4.1.0/css/font-awesome.min.css', __FILE__ ) ) ;			
		wp_enqueue_script('wbq_front_js', plugins_url('/js/front.js', __FILE__ ), array('jquery'), '1.0' ) ;
		wp_enqueue_style('wbq_front_css', plugins_url('/css/front.css', __FILE__ ) ) ;	
	}
}
?>