<?php 

/*
if($_GET['update']==1):
  $newterms = array();
  $myrows = $wpdb->get_results( "SELECT post_id, meta_key FROM $wpdb->postmeta WHERE meta_key LiKE 'published_%'" );
  foreach ( $myrows as $row ) 
  {
    $paper = substr($row->meta_key, 10);
    if($paper!=''):
      $paper = get_term_by( 'slug', $paper, 'paper', OBJECT, raw );
      $newterms[ $row->post_id ][] = $paper->term_id;
    endif;
  }
  query_posts( array( 'posts_per_page' => -1, 'post_type'=> 'insandare' ) );
  // The Loop
  while ( have_posts() ) : the_post();
      $post_id = get_the_ID();
      wp_delete_object_term_relationships( $post_id, 'paper' );
      wp_set_post_terms( $post_id, $newterms[$post_id], 'paper', TRUE );
  endwhile;
  // Reset Query
  wp_reset_query();
  foreach ($newterms as $post_id => $terms) {
    
  }
endif;
*/

if ( $_POST['action'] == 'add' ){
  require('../../../../../wp-config.php');
  global $bp;
  $wp->init();
  $wp->parse_request();
  $wp->query_posts();
  $wp->register_globals();
  $paper_name = get_term_by('slug', $_POST['paper'], 'paper');
  $activity_id = bp_activity_add( array( 
    'user_id' => $bp->loggedin_user->id, 
    'action'=> sprintf("%s har rapporterat en <a href='%s'>insändare</a> som publicerad i %s",bp_core_get_userlink( $bp->loggedin_user->id ), get_permalink( $_POST['post_id'] ), $paper_name->name),
    'content' => false, 
    'primary_link' => bp_core_get_userlink( $bp->loggedin_user->id ),
    'component_name' => 'groups',
    'component_action' =>"report_published",
    'item_id' => $_POST['group'],
    'secondary_item_id' => false,
    'recorded_time' => gmdate( "Y-m-d H:i:s" ),
    'hide_sitewide' => false
  ) );
  echo 'lägger till!';
  update_post_meta( $_POST['post_id'], 'published_'.$_POST['paper'], TRUE );
} elseif ( $_POST['action'] == 'remove' ){
  require('../../../../../wp-config.php');
  $wp->init();
  $wp->parse_request();
  $wp->query_posts();
  $wp->register_globals();
  delete_post_meta( $_POST['post_id'], 'published_'.$_POST['paper'] );
  echo 'tar bort!';
} else {

  $paged = (get_query_var('paged')) ? (int) get_query_var('paged') : 1;
  $page_link = '/grupper/insandarmaskinen/las-insandare/';

  if ( bp_loggedin_user_id() ) : 
?>

			<div class="page-header">
				<h1>Läs insändare</h1>
			</div>

      <?php 
        $events_query = new WP_Query('post_type=insandare&paged='.$paged);
        while ($events_query->have_posts()) : $events_query->the_post();
      ?>
        <div class="insandare row-fluid">
          <div class="meta span3">
            <a href="<?php global $bp; echo $bp->loggedin_user->domain; ?>profile/"><?php echo get_avatar( get_the_author_meta('ID'), 65 ); ?></a>

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
                if(count($terms))
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
      <?php
        endwhile; 
      ?>
      <?php $start_count = ($paged >= 3 ? $paged-2 : 1); ?>
      <div class="pagination pagination-centered">
        <ul>
          <li class="<?php if($paged==1) echo 'disabled'; ?>"><a href="<?php echo $page_link ?>page/<?php echo $paged - 1; ?>">Prev</a></li>
          <?php while($start_count <= 6) {
            $class = ( $start_count == $paged ? 'active' : '' );
            echo '<li class="'.$class.'"><a href="'.$page_link.'page/'.$start_count.'">'.$start_count.'</a></li>';
            $start_count++;
          } ?>
          <li><a href="<?php echo $page_link ?>page/<?php echo $paged + 1; ?>">Next</a></li>
        </ul>
      </div>

<?php 
  endif;
?>
            <script>
              jQuery(document).ready(function($) {
                $('.dropdown-menu a').click( function(e){
                  var icon = $(this).find('i');
                  var update_action = 'add';
                  var paper = $(this).data('paper');
                  console.log(paper);
                  if( $(icon).hasClass('icon-ok') ){
                    $(this).find('i').removeClass('icon-ok');
                    update_action = 'remove';
                  } else {
                    $(this).find('i').addClass('icon-ok');
                  }
                  $.post('/wp-content/themes/insandarmaskinen/groups/single/read-letter.php', { action: update_action, post_id: $(this).data('id'), paper: paper, group: <?php global $bp; echo $bp->groups->current_group->id; ?> }, function(data) {
                    console.log(data);
                  });
                });
              });
            </script>
<?php
}
?>