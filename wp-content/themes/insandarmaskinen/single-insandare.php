<?php get_header(); ?>

	<div class="span3">
		<?php get_sidebar(); ?>
	</div>
	<div class="span9">

		<div class="page-header">
			<h1>Insändare</h1>
		</div>

		<?php do_action( 'bp_before_blog_page' ); ?>

			<?php if (have_posts()) : while (have_posts()) : the_post();
           	$papers = wp_get_post_terms( get_the_ID(), 'paper' ); ?>
	        <div class="insandare row-fluid">
				<div class="meta span3">
		            <a href="<?php echo bp_core_get_user_domain( get_the_author_meta('ID') ); ?>profile/"><?php echo get_avatar( get_the_author_meta('ID'), 65 ); ?></a>

		            <p>
		              <strong>Publiceringar</strong> 
		            <span class="total"><?php
		              $terms = wp_get_post_terms( $post->ID, 'paper' );
		              echo count($terms);
		            ?></span> st 
		            </p>

	          	</div>

	          	<div class="mail span9">
	            	<h3><?php the_title(); ?></h3>
	            	<?php the_content(); ?>
	            	<hr/>
	            	<div class="paperlist">
		              <ul data-postid="<?php echo $post->ID; ?>">
		                <li class="label">Publiceringar:</li>
		                <?php
		                foreach ($terms as $term) {
		                  echo ' <li data-term="'.$term->term_id.'"><a class="deleteterm">X</a>'.$term->name.'</li>';
		                }
		                if(count($terms) == 0)
		                  echo ' <li>Inga ännu</li>';
		                ?>
		              </ul>
		            </div>
		            <form class="addpaper">
		              <div class="input-append">
		                <input type="hidden" class="insandare_id" value="<?php the_ID(); ?>">
		                <input type="text" name="newtag[paper]" class="paper-suggest" size="16" autocomplete="off" value="" placeholder="Tidningens namn">
		                <button class="btn paper-btn" type="button">Rapportera!</button>
		              </div>
		              <div class="fee-suggest-results"></div>
		            <form>
	          	</div>
	         
	         </div>

			<?php endwhile; endif; ?>

		<?php do_action( 'bp_after_blog_page' ); ?>

	</div><!-- .padder -->

<?php get_footer(); ?>
