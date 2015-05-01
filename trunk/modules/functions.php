<?php 
function wbq_generate_quiz( $id ){
global $post;

$config = get_option('wbq_options');  
	$json_res = json_decode( get_post_meta( $id, 'obj_str', true ) );
	$out .= '<div class="tw-bs">';	
	$out .='
		<!-- <div class="quiz_title">'.get_post_meta( $id, 'test_name', true ).'</div> -->`
		<div class="quiz_descr">'.nl2br( get_post_meta( $id, 'test_description', true ) ).'</div>
		';
	$out .= '	
		<div class="quiz_container">
	';
	$in_cnt = 1;

	if( count($json_res) )
	foreach( $json_res as $single ){
		if( $single->question ){
			if( $in_cnt == 1 ){
				$active = ' active_tpl ';
			}else{
				$active = ' ';
			}
			
			
			
			$out .= '
			<div class="single_question slide_'.$in_cnt.' '.$active.'" data-num="'.$in_cnt.'" >
			
				<div class="qestion_text">'.$in_cnt.'. '.esc_html($single->question->question).'</div>
				'.( $single->question->url ? '<img src="'.$single->question->url.'" />' : '' ) ;	

				$out .= '
				<div class="question_container">
					';
					$cnt = 1;
				
				if( count($single->question->answers_blocks) > 0 )
					foreach( $single->question->answers_blocks as $single_question){
						
						
							$ar = array();
							if( count($single_question->answers) > 0 )
							foreach( $single_question->answers as $single_answ  ){
								$ar[] = $single_answ->value;
							}
					
						
						
						$num_el = 95 / count( $single->question->answers_blocks );
					$rnd = rand(1000, 9999);
						
						if( $single->question->type == 'image' ){
						$patch_css = '';
						if( count( $single->question->answers_blocks ) == 2 || count( $single->question->answers_blocks ) == 4 ){
							if( $cnt == 2 || $cnt == 4 ){
								$patch_css = ' style="margin-right:0px" ';
							}
						}else{
							if( $cnt == 3 || $cnt == 6 || $cnt == 9 ){
								$patch_css = ' style="margin-right:0px" ';
							}
						}
						
						
						$out .= '
			
						<div '.$patch_css.' class="single_answer '.( count($single->question->answers_blocks) == 2 || count($single->question->answers_blocks) == 4 ? ' parniy_block ' : '' ).' image_type answ_'.$cnt.'" data-step="'.$in_cnt.'" data-values="'.implode ( '|', $ar ).'" > 
							<div class="inner_text" '.( $single->question->type == 'image' ? 'style=\'background: url("'.$single_question->answ_img.'") no-repeat; background-size: cover; background-position: 50% 50%;\'' : '' ).'  >	
				
							</div>
						<div class="check_row">	
							<div class="bot_check squaredOne">
								<input type="checkbox" class="block_checkbox" id="squaredOne'.$rnd.'" />
								<label for="squaredOne'.$rnd.'"></label>
								
							</div>
							<div class="pull-left check_text">
								'.esc_html($single_question->answ_title).'
							</div>
						</div>
						
						</div>
						
						';
						}
						
						if( $single->question->type == 'text' ){
						$out .= '
					
						<div class="single_answer text_type answ_'.$cnt.' media-body" data-step="'.$in_cnt.'" data-values="'.implode ( '|', $ar ).'" > 
							
							<div class="bot_check squaredOne pull-left">
								<input type="checkbox" class="block_checkbox" id="squaredOne'.$rnd.'" />
								<label for="squaredOne'.$rnd.'"></label>
							</div>
							
							<div class="in_t  pull-left">
							'.esc_html($single_question->answ_title).'
							</div>
						
						</div>
						
						';
						}
						
						$cnt++;
					}
				$out .= '
				</div>			
			</div>';
			$in_cnt++;
		}
	
	}
	$out .= '</div><!-- quiz container -->';
	
	$out .= '
	<div class="check_res">
		<button type="button" class="btn btn-success check_results">Check Results</button>
	</div>
	
	<div class="results_block ">';
	$res_cnt = 1;
	if( count($json_res) )
	foreach( $json_res as $single ){
		if( $single->result ){
			$out .= '
			<div class="single_result result_'.$res_cnt.'">				
				<div class="text_data"	>
					<div class="quest_res">'.esc_html(get_post( $id )->post_title).'</div>
					
					<div class="res_title">'.esc_html($single->result->title).'</div>
					
					<div class="res_cont">				
							<img src="'.esc_html( $single->result->url ).'" />					
					</div>
					<div class="res_descr">
						'.$single->result->q_text.'
					</div>
					
									
				</div>	
			</div>
			';
			$res_cnt++;
		}			
	}
	$out .= '
	</div>
	
	';
	
	$out .= '</div>
	
	
	
	<style>
	
	</style>
	';
	return $out;
}	
?>