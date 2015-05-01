jQuery(document).ready(function($){



	// add item RESULT
	$('.add_result').click(function(){
		
		// check limits
		var tp_pnt = $(this).parents('.single_block');
		if( $('.q_block .single_result', tp_pnt).length >= 2 ){
			return true;
		}
		
		
		$('.q_block').append( $('.result_cliche').html() );
		post_process_results();
	})
	// title edited
	$('.q_name').live('change', function(){ 
		post_process_results();
	})
	
	// close block
	$('.q_close').live('click', function(){
		var pnt = $(this).parent('.single_result').fadeOut(500, function(){
			pnt.replaceWith('');
			post_process_results();
			});
		
	});
	// close question
	$('.a_close').live('click', function(){
		var pnt = $(this).parent('.single_question').fadeOut(500, function(){
			pnt.replaceWith('');
		});
		post_process_results();
	})
	//close answer
	$('.as_close').live('click', function(){
		var pnt = $(this).parent('.a_single_a').fadeOut(500, function(){
			pnt.replaceWith('');
		});
		post_process_results();
	})
  
	// add_answer
	$('.add_answer').live('click', function(){
		var rows_txt = '';		
		$('.q_block .single_result').each(function(){
			rows_txt = rows_txt + 
			'<div class="answ_digit_row  q_b_10"> \
				<div class="answ_txt">'+$('.q_name', this).val()+'</div> \
				<select class="num_picker">\
					<option value="0" >0\
					<option value="1" >1\
					<option value="2" >2\
				</select>\
			</div>'
			;
		})
		var pnt = $(this).parents('.single_question');
		console.log( pnt );
		
		var cliche_block = $( '.answer_cliche' );		
		$('.s_res_block', cliche_block ).html( rows_txt );		
		$('.a_block', pnt).append( cliche_block.html() );
		
		var top_pointer = $(this).parents('.single_question');
		if( $( '.a_question_type', top_pointer ).val() == 'image' ){
			$('.a_small_image', top_pointer).removeClass('hide');
		}
		
	})
  
  // add question
  $('.add_question').click(function(){
	
	// check limits
		var tp_pnt = $(this).parents('.single_block');
		if( $('.a_block_big .single_question', tp_pnt).length >= 5 ){
			return true;
		}
	
	var cliche = $('.question_cliche');	
	$( ".a_num_val" , cliche).html( $('.a_block_big .single_question').length + 1 );
	
	$('.a_block_big').append( cliche.html() );
	var pnt = $('.a_block_big .single_question:last-child');
	$( '.add_answer', pnt ).click();
	$( '.add_answer', pnt ).click();	
	
	
	
  })
  
  // process value picker
  $('.num_picker').live('change', function(){
		var pnt = $(this).parents('.a_single_a');		
		var arr = [];
		$( '.num_picker', pnt ).each(function(){
			arr.push( $(this).val() )
		})
		//pnt.data('values1', arr.join('|') );
		pnt.attr( 'data-values', arr.join('|') );
		
  })
  
  
  // post process results things
  function post_process_results(){
		var rows_txt = '';		
		$('.q_block .single_result').each(function(){
			rows_txt = rows_txt + 
			'<div class="answ_digit_row  q_b_10"> \
				<div class="answ_txt">'+$('.q_name', this).val()+'</div> \
				<select class="num_picker">\
					<option value="0" >0\
					<option value="1" >1\
					<option value="2" >2\
				</select>\
			</div>'
			;
		})
		$('.s_res_block').each(function(){
			$(this).html( rows_txt );
		})
		// apply values to select boxes
		$('.a_single_a').each(function(){
			if( $(this).attr('data-values') ){
				var cur_array = $(this).attr('data-values').split('|');
				var cnt = 0;
				$( ".num_picker", this).each(function() {
					if( cur_array[cnt] ){
						$(this).val( cur_array[cnt] );
					}
					cnt++;				
				});
			}
		})
  
  }
  
  // process
  $('#publish, #save-post').click(function(e){
	//e.preventDefault();
	var  json_obj = [];
	$('.q_block .single_result').each(function(){
		json_obj.push({result:{ title: $( '.q_name', this ).val(), url: $( '.small_plc_url', this ).val(), q_text: $( '.q_text', this ).val() } });
	})
	$('.a_block_big .single_question').each(function(){
		var json_answer = [];
		$( '.a_single_a', this).each(function(){
			var json_val = [];
			
			$( '.num_picker' , this ).each(function(){
				var pnt_in = $(this).parent('.answ_digit_row')
				json_val.push({answ_txt: $( '.answ_txt', pnt_in).html() , value: $(this).val() });
			})
		
			json_answer.push({ answ_img: $( '.a_small_plc_url', this ).val(), answ_title: $( '.a_single_text', this ).val(), a_checkbox_text: $( '.a_checkbox_text', this ).val(),  answers: json_val  });
		})
		console.log( $( '.big_plc_url', this ).val() );
		json_obj.push({question:{ url: $( '.big_plc_url', this ).val(), type: $( '.a_question_type', this ).val(), question: $( '.a_question', this ).val(), video:$( '.a_video', this ).val(), answers_blocks: json_answer } });
	})
	
//e.preventDefault();
	$('.obj_str').val( JSON.stringify( json_obj ) );
  })
 
 
 
 // use add images
 $('.use_images').live('click', function(){	
	var pnt = $(this).parents('.single_question');
	$('.a_question_type', pnt).val( 'image' );
	$(this).addClass('hide');
	$('.use_text', pnt).removeClass( 'hide' );	
	$('.a_small_image', pnt).removeClass('hide');
	
 })
 
  // use add text
 $('.use_text').live('click', function(){
	var pnt = $(this).parents('.single_question');
	$('.a_question_type', pnt).val( 'text' );
	$(this).addClass('hide');
	$('.use_images', pnt).removeClass( 'hide' );
	$('.a_small_image', pnt).addClass('hide');
 })
  
  
  // image upload processing
  // Uploading files
var file_frame;
 var pointer;
  jQuery('.upl_button').live('click', function( event ){
	pointer = $(this);
 
    event.preventDefault();
 
    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      file_frame.open();
      return;
    }
 
    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery( this ).data( 'uploader_title' ),
      button: {
        text: jQuery( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });
 
    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
		pointer.html('<img src="'+attachment.url+'" />');
		var top = pointer.parent('li');
		$( '.img_url:eq(0)' , top ).val( attachment.url );
      // Do something with attachment.id and/or attachment.url here
    });
 
    // Finally, open the modal
    file_frame.open();
  });
  
}); // main jquery container
