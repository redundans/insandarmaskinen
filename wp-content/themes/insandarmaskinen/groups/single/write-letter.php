<?php

  function sendMail( $post_id, $title, $content, $signature ) {
    global $bp;
    $user_email = $bp->loggedin_user->userdata->user_email;
    $user_name = $bp->loggedin_user->userdata->user_nicename;
    $papers = wp_get_post_terms( $post_id, 'paper' );
    $contact = bp_get_profile_field_data( array('user_id'=>$bp->loggedin_user->id,'field'=>2 ));
    $user_nicename = bp_get_profile_field_data( array('user_id'=>$bp->loggedin_user->id,'field'=>1 ));

    foreach ( $papers as $paper ) {
      $to      = get_term_meta($paper->term_id, 'email', true);
      $subject = $title;
      $message = $content . "\n\n" . $signature . "\n\n ----- \n\n" . $contact;

      $headers[] = 'From: ' . $user_nicename . ' <'.$user_email.'>';

      $mail = wp_mail( $to, $subject, $message, $headers );

      if($mail) {
        error_log( 'Sent mail from insändarmaskinen to '. $to);
      } else {
        $error = 'Ett problem uppstog med någon av mailutskickan du försökte göra. Var god rapportera buggen i forumet';
      }
    }

    if( empty($contact) )
        $error = 'Din kontaktinformation är tom. Många redaktioner publicerar inte insändare om ingen kontaktuppgift till avsändaren finns med.';
    return $error;
  }

  if( $_POST['action'] == 'send' ) {
    
    global $current_user;
    global $bp;

    $title = $_POST['inputHeader'];
    $content = $_POST['inputMessage'];
    $papers = $_POST['inpitPapers'];
    $signature = $_POST['inputSender'];

    $post = array(
      'post_author'    => $current_user->ID,
      'post_content'   => $content,
      'post_status'    => 'publish',
      'post_title'     => $title,
      'post_type'      => 'insandare',
    ); 

    $post_id = wp_insert_post( $post );

    //$out = wp_set_object_terms( $post_id, $papers, 'paper' );

    if( !empty( $post_id ) ):
      $activity_id = bp_activity_add( array( 
        'user_id' => $bp->loggedin_user->id, 
        'action'=> sprintf("%s har skrivit en ny <a href='%s'>insändare</a>.", bp_core_get_userlink( $bp->loggedin_user->id ), get_permalink( $post_id ) ),
        'content' => false, 
        'primary_link' => bp_core_get_userlink( $bp->loggedin_user->id ),
        'component_name' => 'groups',
        'component_action' =>"report_published",
        'item_id' => $bp->groups->current_group->id,
        'secondary_item_id' => false,
        'recorded_time' => gmdate( "Y-m-d H:i:s" ),
        'hide_sitewide' => false
      ) );
      sendMail( $post_id, $title, $content, $signature );
    endif;
?>
      <div class="page-header">
          <h1>Din insändare är skickad!</h1>
      </div>
      <a href="<?php echo get_permalink($post_id); ?>">Klicka för att komma till din insändare <i class="icon-arrow-right"></i></a>
<?php
  } else {
?>

<?php if ( bp_loggedin_user_id() ) : ?>

			<div class="page-header">
				  <h1>Skriv en insändare</h1>
			</div>

			<form class="form-vertical" method="post">

        <input type="hidden" id="action" name="action" value="send">

				<input type="text" id="inputHeader" name="inputHeader" placeholder="Skriv din rubrik här">

    		<textarea class="span9" rows="5" id="inputMessage" name="inputMessage" placeholder="Skriv din insändare här"></textarea>
    		
        <input type="text" id="inputSender" name="inputSender" placeholder="Skriv din signatur här">
        <span class="help-inline">Även dina kontaktuppgifter kommer skickas med</span>
    		<br/>

        <div class="page-header">
          <h1>Välj tidningar</h1>
        </div>

        <div class="row-fluid" style="margin-bottom:1em;">
          <div class="accordion" id="papers">
          <?php
            $papers = get_terms('paper', 'parent=0&orderby=name&hide_empty=0');
            foreach ($papers as $paper) {
            ?>
            <div class="accordion-group">
              <div class="accordion-heading">
                <label class="checkbox"><input type="checkbox" class="parent">
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#<?php echo $paper->slug; ?>" href="#<?php echo $paper->slug; ?>">
                    <?php echo $paper->name; ?>
                  </a>
                </label>
              </div>
              <div id="<?php echo $paper->slug; ?>" class="accordion-body collapse in">
                <div class="accordion-inner">
                <?php
                  $children = get_terms( 'paper', 'orderby=name&hide_empty=0&child_of='.$paper->term_id );
                  foreach( $children as $child ){
                    ?>
                    <label class="checkbox inline span3">
                      <input type="checkbox" name="inpitPapers[]" class="child" value="<?php echo $child->slug; ?>"> <?php echo $child->name; ?>
                    </label>
                    <?php
                  }
                ?>
                
                </div>
              </div>
            </div>
            <?php 
            }
          ?>
            <script>
              jQuery(document).ready( function($) {
                $(".collapse").collapse();

                $('.parent').change(function() {
                  var parent = $(this);
                  var isChecked = $(parent).attr('checked')?true:false;
                  $(parent).closest('.accordion-group').find('input.child').each( function(e){
                    if( isChecked )
                      $(this).attr('checked', 'checked');
                    else
                      $(this).removeAttr('checked');
                  });
                });
              });
            </script>
          </div>
        </div>        

        <hr/>
        <button type="submit" class="btn btn-primary">Skicka</button>
			</form>

<?php endif;
  }
?>