			</div> <!-- #container -->	
		</div> <!-- #row -->

		<?php do_action( 'bp_after_container' ); ?>
		<?php do_action( 'bp_before_footer'   ); ?>

		<div id="footer" class="container">
			<?php if ( is_active_sidebar( 'first-footer-widget-area' ) || is_active_sidebar( 'second-footer-widget-area' ) || is_active_sidebar( 'third-footer-widget-area' ) || is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
				<div id="footer-widgets">
					<?php get_sidebar( 'footer' ); ?>
				</div>
			<?php endif; ?>

			<?php do_action( 'bp_footer' ); ?>

		</div><!-- #footer -->

		<?php do_action( 'bp_after_footer' ); ?>

		<?php wp_footer(); ?>
		
    	<script src="<?php echo get_bloginfo('stylesheet_directory'); ?>/js/bootstrap.min.js"></script>
    	<script type="text/javascript">
    	jQuery('document').ready( function($) {
        	$('.paper-suggest').suggest("<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=ajax-tag-search&tax=paper", {
        		multiple 	: true, 
        		multipleSep	: ",", 
        		resultsClass: 'paper-suggest-results',
				selectClass : 'paper-suggest-over',
				matchClass 	: 'paper-suggest-match'
			});
			$('.paper-btn').click( function() {
				var post_id = $(this).siblings('.insandare_id').val();
				var paperlist = $(this).parents('.insandare').find('.paperlist ul');
				var papers = $(this).prev('.paper-suggest').val();
				var paper_suggest = $(this).prev('.paper-suggest');
				var total = $(this).closest('.insandare').find('.total');
				$.ajax({
					type: "POST",
					url: ajaxurl,
					data: {action: "report_paper", post_id : post_id, papers: papers },
					success: function(data){
						if( data.error == 1){
							alert(data.message);
							$(paper_suggest).val('');
							return;
						}
						$(total).html(data.total);
						$(paperlist).html('');
						$.each( data.terms, function( key, value ){
							$(paperlist).append('<li data-term="'+key+'"><a class="deleteterm">X</a>'+value+'</li>');
						});
						$(paper_suggest).val('');
					},
					dataType: "json"
				});
			});
			$('.insandare').on('click', '.deleteterm', function() {
				var post_id = $(this).parents('ul').data('postid');
				var paperlist = $(this).parents('.insandare').find('.paperlist ul');
				var term = $(this).parents('li').data('term');
				var total = $(this).closest('.insandare').find('.total');
				$.ajax({
					type: "POST",
					url: ajaxurl,
					data: {action: "delete_reported_paper", post_id : post_id, term: term },
					success: function(data){
						$(total).html(data.total);
						$(paperlist).html('');
						$.each( data.terms, function( key, value ){
							$(paperlist).append('<li data-term="'+key+'"><a class="deleteterm">X</a>'+value+'</li>');
						});
					},
					dataType: "json"
				});
			});
		});
 		</script>
	</body>

</html>