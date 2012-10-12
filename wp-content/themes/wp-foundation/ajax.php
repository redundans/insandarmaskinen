<?php

require('../../../wp-config.php');
$wp->init();
$wp->parse_request();
$wp->query_posts();
$wp->register_globals();

switch ( $_POST['func'] ) {
    case 'saveReports':
    	$reported = $_POST['reported'];
    	$post_id = $_POST['post_id'];
    	update_post_meta( $post_id, 'letter_reported', $reported);
        echo json_encode( array('error' => 0) );
        break;
}
?>