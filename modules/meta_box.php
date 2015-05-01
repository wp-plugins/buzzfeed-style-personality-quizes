<?php 
		

add_action( 'add_meta_boxes', 'wbq_add_custom_box' );
function wbq_add_custom_box() {
	global $current_user;
		add_meta_box( 
			'wbq_quiz_editor',
			__( 'Edit Quiz', 'wl' ),
			'wbq_quiz_editor',
			'quiz' , 'advanced', 'high'
		);

		
		
		
}
function wbq_quiz_editor(){
	global $post;
	global $current_user;
	wp_nonce_field( plugin_basename( __FILE__ ), 'label_noncename' );
	
	
	// single block data
	$single_block = '
	<style>
	#normal-sortables{
		display:none;
	}
	</style>
	
		<li class="single_result">
				<div class="q_close" >X</div>
				<input class="q_name q_b_10 w_100"  value="" placeholder="Result title" />
				<input class="small_plc_url img_url" type="hidden" />
				<div class="q_image q_b_10 upl_button" >
					<div class="small_plc">Click To Add Result Image</div>
					
				</div>
				<textarea class="q_text q_b_10 high_100 w_100" value="" placeholder="Result text" ></textarea>
			</li>
	';
	
	// single answer
	$single_answer = '
	<li class="a_single_a">
		<div class="as_close" >X</div>
		<input class="a_small_plc_url img_url" type="hidden" />
		<div class="a_small_image q_b_10 upl_button hide" >
			<div class="small_plc">Click To Add Answer Image</div>					
		</div>
	
		<input class="a_single_text w_100" placeholder="Enter Text" />
		<hr/>
		
		<h5>Associate results</h5>
		<div class="s_res_block">
		s_res_block
		</div>
	</li>
	';
	
	/// single question
	$single_question = '
			<li class="single_question">
				<div class="a_close" >X</div>
				<div class="a_number">
					<div class="a_num_val">1</div>
				</div>
				<input class="big_plc_url img_url" type="hidden" />
				<div class="a_image q_b_10 upl_button">
					<div class="big_plc">Click to add image</div>
					
				</div>	
	
				<label>Question Title</label>
				<input class="a_question q_b_10 w_100" value="" placeholder="Please, enter question text"  >	
				
				
				
				<input class="a_question_type q_b_10" value="text" type="hidden"  >					
				

				<div class="alert alert-warning button_inside"> 
					<div class="text_block">Answers Type To Use</div>
					<button type="button" class="btn btn-warning use_images" >Images</button>
					<button type="button" class="btn btn-warning use_text hide" >Text</button>
					<button type="button" class="btn btn-success add_answer"  >Add Answer</button>
				</div>
				
					
				
				<ul class="a_block sortable">	
				</ul>
							
			</li>
	';
	
	if( get_post_meta( $post->ID, 'obj_str', true ) ){
	$json_res = json_decode( get_post_meta( $post->ID, 'obj_str', true ) );
	
	//var_Dump( $json_res );
	
	echo '
	<div class="tw-bs">
		
		
		
		<div class="hide result_cliche">
			'.$single_block.'
		</div>
		<div class="hide answer_cliche">
			'.$single_answer.'
		</div>
		<div class="hide question_cliche">
			'.$single_question.'
		</div>
		
	<div class="single_block">
		<div class="alert alert-info button_inside"> 
			<div class="text_block">Quiz Shortcode</div>
			<input type="text" value="[quiz_test id=\''.$post->ID.'\']" />
		</div>	
	</div>
	
	<div class="single_block">	

		<div class="alert alert-info button_inside"> 
			<div class="text_block">Quiz Description</div>
		</div>	
			
		<!--
		<input placeholder="Quiz Title" name="test_name" id="test_name" class="  q_b_10" value="'.get_post_meta( $post->ID, 'test_name', true ).'"  /> -->
		<textarea placeholder="Test Description" name="test_description" class="  q_b_10" id="test_description" >'.esc_html( get_post_meta( $post->ID, 'test_description', true ) ).'</textarea>
	</div>
		
		
	<div class="single_block">	
		<div class="alert alert-info button_inside"> 
			<div class="text_block">Quiz Results</div>
			<input type="button" class="btn btn-success add_result" value="Add Result" />
		</div>	
		
		<ul class="q_block">
			
			';
			
		if( count($json_res) > 0 )
		foreach( $json_res as $single ){
			if( $single->result ){
				echo '
				<li class="single_result">
					<div class="q_close" >X</div>
					<input class="q_name q_b_10 w_100"  value="'.esc_html( $single->result->title ).'" placeholder="Result title" />
					<input class="small_plc_url img_url" value="'.$single->result->url.'" type="hidden" />
					<div class="q_image q_b_10 upl_button" >';
					if( $single->result->url ){
						echo '<img src="'.$single->result->url.'" />';
					}else{
						echo '<div class="small_plc">Click To Add Result Image</div>';
					}						
					echo '	
					</div>
					<textarea class="q_text q_b_10 high_100 w_100"  placeholder="Result text" >'.esc_html( $single->result->q_text ).'</textarea>
				</li>
				';
			}
		}
		echo '
		</ul>
	</div>	
	
	
	
	<div class="single_block">
		<div class="alert alert-info button_inside"> 
			<div class="text_block">Questions Block</div>
			<input type="button" class="btn btn-success add_question" value="Add Question" />
		</div>	
	
	
		<ul class="a_block_big sortable">';
		$cnt = 1;
		if( count($json_res) > 0 )
		foreach( $json_res as $single ){
			if( $single->question ){
				echo '
				<li class="single_question">
					<div class="a_close" >X</div>
					<div class="a_number">
						<div class="a_num_val">'.$cnt.'</div>
					</div>
					<input class="big_plc_url img_url" value="'.$single->question->url.'" type="hidden" />
					<div class="a_image q_b_10 upl_button">';
						if( $single->question->url ){
							echo '<img src="'.$single->question->url.'" />';
						}else{
							echo '<div class="big_plc">Click to add image</div>';
						}
					
					echo '
						
						
					</div>		

					<label>Question Title</label>
					<input class="a_question q_b_10 w_100" value="'.esc_html( $single->question->question ).'" placeholder="Please, enter question text"  >	
					
					
					<input class="a_question_type q_b_10" value="'.$single->question->type.'"  type="hidden" >					
	
					<div class="alert alert-warning button_inside"> 
						<div class="text_block">Answers type</div>
						<button type="button" class="btn btn-warning use_images '.( $single->question->type == 'image' ? ' hide ' : '' ).' " >Images</button>
						<button type="button" class="btn btn-warning use_text '.( $single->question->type == 'text' ? ' hide ' : '' ).'" >Text</button>
						<button type="button" class="btn btn-success add_answer"  >Add Answer</button>
					</div>
	
						
					
					<ul class="a_block sortable">';
					
					if( count($single->question->answers_blocks) > 0 )
					foreach( $single->question->answers_blocks as $single_block ){
						$ar = array();
						
						if( count($single_block->answers) > 0 )
						foreach( $single_block->answers as $single_answ  ){
							$ar[] = $single_answ->value;
						}
						
						
						echo '
						<li class="a_single_a" data-values="'.implode ( '|', $ar ).'">
							<div class="as_close" >X</div>	
							<input class="a_small_plc_url img_url" type="hidden" value="'.esc_html($single_block->answ_img).'" />
							<div class="a_small_image q_b_10 upl_button '.( $single->question->type == 'text' ? ' hide ' : '' ).' " >
								'.( $single_block->answ_img ? '<img src="'.$single_block->answ_img.'" />' : '<div class="small_plc">Click To Add</div>' ).'
													
							</div>
							
							<input class="a_single_text w_100" value="'.esc_html( $single_block->answ_title ).'" placeholder="Enter Text" />
							<hr/>
					
							<h5>Associate results</h5>
							<div class="s_res_block">
							';
							//var_dump( $single_answ );
							
							if( count($single_block->answers) > 0 )
							foreach( $single_block->answers as $single_answ  ){
								//var_dump( $single_answ->value );
								echo '
								<div class="answ_digit_row  q_b_10"> 
									<div class="answ_txt">'.esc_html( $single_answ->answ_txt ).'</div>
									<select class="num_picker">
									<option value="0" '.( $single_answ->value == '0' ? ' selected ' : '' ).' >0
									<option value="1"'.( $single_answ->value == '1' ? ' selected ' : '' ).' >1
									<option value="2"'.( $single_answ->value == '2' ? ' selected ' : '' ).' >2
									';
								echo '
									</select>
								</div>
								';
							}
						echo '
							</div>
						</li>
						';
					}
					echo '
					</ul>
								
				</li>
				';
				$cnt++;
			}
			
		}
		echo '
		</ul>
		
		<div class="alert alert-info button_inside"> 
			<div class="text_block">Questions Block</div>
			<input type="button" class="btn btn-success add_question" value="Add Question" />
		</div>	
		
		
	</div>	
		
	</div>
	';
	
	}else{
	echo '
	<div class="tw-bs">
		
		
		
		<div class="hide result_cliche">
			'.$single_block.'
		</div>
		<div class="hide answer_cliche">
			'.$single_answer.'
		</div>
		<div class="hide question_cliche">
			'.$single_question.'
		</div>
		
	<div class="single_block">
		<div class="alert alert-info button_inside"> 
			<div class="text_block">Quiz Info</div>
		</div>
		<!--
		<input name="test_name" id="test_name" class="  q_b_10" value="'.get_post_meta( $post->ID, 'test_name', true ).'" placeholder="Quiz Title" /> -->
		<textarea name="test_description" class="  q_b_10" id="test_description" placeholder="Quiz Description">'.esc_html( get_post_meta( $post->ID, 'test_description', true ) ).'</textarea>
	</div>
		
		
	<div class="single_block">		
		<div class="alert alert-info button_inside"> 
			<div class="text_block">Quiz Results List</div>
			<input type="button" class="btn btn-success add_result" value="Add Result" />
		</div>
		
		<ul class="q_block">
			'.$single_block.'
		</ul>				
	</div>	
	
	<div class="single_block">
		<div class="alert alert-info button_inside"> 
			<div class="text_block">Questions Block</div>
			<input type="button" class="btn btn-success add_question" value="Add Question" />
		</div>
		
		<ul class="a_block_big sortable">
			'.$single_question.'
		</ul>
		
		<div class="alert alert-info button_inside"> 
			<div class="text_block">Questions Block</div>
			<input type="button" class="btn btn-success add_question" value="Add Question" />
		</div>
		
	</div>	
	
	
</div>
	
	';
	}
	echo '<input type="hidden" name="obj_str" value=\''.esc_html( get_post_meta( $post->ID, 'obj_str', true ) ).'\' class="obj_str" />';
}


add_action( 'save_post', 'wst_save_postdata' );
function wst_save_postdata( $post_id ) {
global $current_user; 
 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;
  if ( !wp_verify_nonce( $_POST['label_noncename'], plugin_basename( __FILE__ ) ) )
      return;
  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }
  /// User editotions
  if( get_post_type( $post_id ) == 'quiz' ){
	update_post_meta( $post_id, 'obj_str', $_POST['obj_str'] );
	update_post_meta( $post_id, 'test_name', $_POST['test_name'] );
	update_post_meta( $post_id, 'test_description', $_POST['test_description'] );
	
  }
		
  
  
}

?>