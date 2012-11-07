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
		            <a href="<?php bp_group_member_domain(); ?>/profile/"><?php echo get_avatar( get_the_author_meta('ID'), 65 ); ?></a>

		            <p>
		              <strong>Tidningar</strong> <?php echo count($papers); ?> st
		              <br/>
		              <strong>Publiceringar</strong> 
		            <?php
		              $publish_count = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key LIKE 'published_%' AND post_id = '".get_the_ID()."';" );
		              echo $wpdb->num_rows ;
		            ?> st
		            </p>

		            <div class="btn-group">
		              <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
		                Rapportera publicering
		                <span class="caret"></span>
		              </a>
		              <ul class="dropdown-menu" >
		                <?php foreach ($papers as $paper) { ?>
		                  <li><a href="#" data-id="<?php the_ID(); ?>" data-paper="<?php echo $paper->slug; ?>"><i class="<?php $published = get_post_meta( get_the_ID(), 'published_'.$paper->slug, TRUE); if( !empty( $published  ) ) echo 'icon-ok'; ?>"></i> <?php echo $paper->name; ?></a></li>
		                <?php } ?>
		              </ul>
		            </div>
	          	</div>

	          	<div class="mail span9">
	            	<h4><?php the_title(); ?></h4>
	            	<?php the_content(); ?>
	          	</div>
	         
	         </div>

			<?php endwhile; endif; ?>

		<?php do_action( 'bp_after_blog_page' ); ?>

	</div><!-- .padder -->

<?php get_footer(); ?>
