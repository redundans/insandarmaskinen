<?php 

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
           $papers = wp_get_post_terms( get_the_ID(), 'paper' );
      ?>
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
              $(document).ready(function() {
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