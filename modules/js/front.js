jQuery(document).ready( function($){

	var is_completed = 0;
	// click block
	$('.single_answer').click( function(){
		if( is_completed == 0 ){
		// drop settings
		var pnt = $(this).parent('.question_container');
		$( '.single_answer', pnt ).removeClass('checked_block');		
		$( '.block_checkbox', pnt ).attr( 'checked', false );
	
	// add new one	
		if( $( '.block_checkbox', this ).attr( 'checked' ) ){
			$( '.block_checkbox', this ).attr( 'checked', false );
			$(this).removeClass('checked_block');
			
		}else{
			$( '.block_checkbox', this ).attr( 'checked', 'checked' );
			$(this).addClass('checked_block');
			var parent_point = $(this).parents('.single_question');
			
			console.log( parent_point.next() );
			
			if( parent_point.next().hasClass('single_question')  ){
				$('html, body').animate({
					scrollTop: parent_point.next().offset().top - 50
				}, 1000);
			}
			
			//var next_el = $('.parent_point').next('.single_question');
			//console.log( next_el.html() );
			//$( next_el ).css('background', '#ff0');
			
		}
		
		$( '.single_answer', pnt ).each(function(){
			if( $(this).hasClass('checked_block')  ){
				$(this).removeClass('op_05');
			}else{
				$(this).addClass('op_05');
			}
		})
		
		
		check_test_complete();
		}
	})
	$('.block_checkbox').click( function(e){
		if( is_completed == 0 ){
			$(this).parent('.single_answer').click();
		}else{
			e.preventDefault();
		}
	})
	
	/*
	$('.single_question .btn').click(function(){
		
		var top_pnt = $(this).parents('.single_question');
		$('.btn', top_pnt).removeClass('btn-danger');
		$('.btn', top_pnt).addClass('btn-success');

		$(this).addClass('btn-danger');
		$(this).removeClass('btn-success');
		
		// move next
		var this_step = parseInt( $(this).attr('data-step') );
		this_step++;
		$('.pag_'+this_step).click();
		check_test_complete();
	})
	*/
	// check if test is complete
	function check_test_complete(){
		var counter = 0;
		$('.single_question').each(function(){
			
			var id = $(this).attr('data-num');
			var slide_pnt = $('.slide_'+id);
			$( '.checked_block', slide_pnt).each(function(){
		
				if( $(this).hasClass('checked_block') == true ){
					counter++;
				}
			})
		})
		
		if( $('.single_question').length == counter ){
			//$('.check_res').fadeIn();
			$('.check_results').click();
				$('html, body').animate({
					scrollTop: $('.results_block').offset().top - 50
				}, 1000);	
		}
	}
	
	// check results
	$('.check_results').click(function(){	
		var this_arr = new Array();
		var counter = 1;
		var res = new Array();
		var cnt;
		$('.quiz_container .checked_block').each(function(){
			cnt = $(this).attr('data-values').split('|').length;
			this_arr = $(this).attr('data-values').split('|') ; //.split('|')
			if( counter == 1 ){
				for ( var i = 0; i < cnt; i++ ) {
					res[i] = parseInt( this_arr[i] );
				}
			}else{
				for ( var i = 0; i < cnt; i++ ) {
					res[i] = parseInt( res[i] ) + parseInt( this_arr[i] );
				}
			}
			counter++;
		})

		var maxValueInArray = Math.max.apply(Math, res  );

		var out = 0;
		for ( var i = 0; i < cnt; i++ ) {
			if( res[i] == maxValueInArray && out == 0 ){
				var num = i+1;
				$('.result_'+num).fadeIn();
				$('.top_adsense, .bottom_adsense').removeClass('hide');
				out = 1;
				is_completed = 1;
			}
		}		
	})
	
	//patch height
	$('.single_question .question_container').each(function(){
		if( $( '.image_type', this).length > 0 ){
		if( $(' .check_row .check_text', this).length == 2 || $(' .check_row .check_text', this).length == 4 ){			
			for( $k=0; $k <=4; $k=$k+2){
			var height = [];
			
			var ind1 = $k;
			var ind2 = $k+1;
			var ind3 = $k+2;

			if( $(' .check_row .check_text:eq('+ind1+')', this).height() )
				height.push( $(' .check_row .check_text:eq('+ind1+')', this).height() );
			
			if( $(' .check_row .check_text:eq('+ind2+')', this).height() )
				height.push( $(' .check_row .check_text:eq('+ind2+')', this).height() );


			var max_of_array = Math.max.apply(Math, height);

			$('.check_row .check_text:eq('+ind1+')', this).css('height', max_of_array );
			$(' .check_row .check_text:eq('+ind2+')', this).css('height', max_of_array );

		}	
	
		}else{
		for( $k=0; $k <=9; $k=$k+3){
			var height = [];
			
			var ind1 = $k;
			var ind2 = $k+1;
			var ind3 = $k+2;

			if( $(' .check_row .check_text:eq('+ind1+')', this).height() )
				height.push( $(' .check_row .check_text:eq('+ind1+')', this).height() );
			
			if( $(' .check_row .check_text:eq('+ind2+')', this).height() )
				height.push( $(' .check_row .check_text:eq('+ind2+')', this).height() );
			
			if( $(' .check_row .check_text:eq('+ind3+')', this).height() )
			height.push( $(' .check_row .check_text:eq('+ind3+')', this).height() );

			var max_of_array = Math.max.apply(Math, height);

			$('.check_row .check_text:eq('+ind1+')', this).css('height', max_of_array );
			$(' .check_row .check_text:eq('+ind2+')', this).css('height', max_of_array );
			$(' .check_row .check_text:eq('+ind3+')', this).css('height', max_of_array );
		}	
			
		
			
		}
		
		}
		
	})
	
}) // global end


