<?php
function wbq_add_post_type() {
  $labels = array(
    'name' => __('Single Quiz', 'fs'),
    'singular_name' => __('Quiz', 'fs'),
    'add_new' => __('Add New Quiz', 'fs'),
    'add_new_item' => __('Add New Quiz', 'fs'),
    'edit_item' => __('Edit Quiz', 'fs'),
    'new_item' => __('New Quiz', 'fs'),
    'all_items' => __('All Quizzes', 'fs'),
    'view_item' => __('View Quiz', 'fs'),
    'search_items' => __('Search Quiz', 'fs'),
    'not_found' =>  __('No Quizzes found', 'fs'),
    'not_found_in_trash' => __('No Quizzes found in Trash', 'fs'), 
    'parent_item_colon' => '',
    'menu_name' => __('BuzzQuiz', 'fs')

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'quiz' ),
	'menu_icon' => plugins_url('/images/logo.png', __FILE__ ), 
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'thumbnail', 'author' /*, 'custom-fields', 'editor'  */)
  ); 
  register_post_type('quiz', $args);
}
add_action( 'init', 'wbq_add_post_type' );
?>