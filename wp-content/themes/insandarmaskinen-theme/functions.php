<?php

/**
 * Insändarmaskinen™ scripts and styles.
 */
function insandarmaskinen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'insandarmaskinen-style', get_template_directory_uri() . '/dist/css/insandarmaskinen.css', array(), null );

	wp_enqueue_script( 'jquery-ui-autocomplete' );
	wp_enqueue_script( 'chartjs-script', get_template_directory_uri() . '/dist/js/Chart.min.js', array( 'jquery' ), '20141010', true );
	wp_enqueue_script( 'popperjs-script', get_template_directory_uri() . '/dist/js/popper.min.js', array(), '20141010', true );
	wp_enqueue_script( 'tagglejs-script', get_template_directory_uri() . '/dist/js/taggle.min.js', array(), '20141010', true );
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/dist/js/bootstrap.min.js', array( 'jquery' ), '20141010', true );
	wp_enqueue_script( 'insandarmaskinen-script', get_template_directory_uri() . '/dist/js/insandarmaskinen.js', array(), '20141010', true );

	$tidningar = get_terms( array(
		'taxonomy' => 'tidningar',
		'hide_empty' => false,
	) );
	$translation_array = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'papers' => array_map( create_function( '$o', 'return $o->name;'), $tidningar ),
	);
	wp_localize_script( 'tagglejs-script', 'insandarmaskinen', $translation_array );
}
add_action( 'wp_enqueue_scripts', 'insandarmaskinen_scripts' );

function insandarmaskinen_register_menus() {
	register_nav_menus( array(
		'top_menu' => 'Huvudmeny',
	) );
}
add_action( 'init', 'insandarmaskinen_register_menus' );

function insandarmaskinen_register_post_types() {
	$labels = array(
		'name' => _x( 'Insändare', 'Post type general name', 'insandarmaskinen' ),
		'singular_name' => _x( 'Insändare', 'Post type singular name', 'insandarmaskinen' ),
		'menu_name' => _x( 'Insändare', 'Admin Menu text', 'insandarmaskinen' ),
		'name_admin_bar' => _x( 'Insändare', 'Add New on Toolbar', 'insandarmaskinen' ),
		'add_new' => __( 'Lägg till', 'insandarmaskinen' ),
		'add_new_item' => __( 'Lägg till Insändare', 'insandarmaskinen' ),
		'new_item' => __( 'Ny Insändare', 'insandarmaskinen' ),
		'edit_item' => __( 'Ändra Insändare', 'insandarmaskinen' ),
		'view_item' => __( 'Visa Insändare', 'insandarmaskinen' ),
		'all_items' => __( 'Alla Insändare', 'insandarmaskinen' ),
		'search_items' => __( 'Sök Insändare', 'insandarmaskinen' ),
		'parent_item_colon' => __( 'Förälder', 'insandarmaskinen' ),
		'not_found' => __( 'Inga Insändare hittades.', 'insandarmaskinen' ),
		'not_found_in_trash' => __( 'Inga Insändare hittades i soporna.', 'insandarmaskinen' ),
		'featured_image' => _x( 'Ingen omslagsbild', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'insandarmaskinen' ),
		'set_featured_image' => _x( 'Sätt omslagsbild', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'insandarmaskinen' ),
		'remove_featured_image' => _x( 'Ta bort omslagsbild', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'insandarmaskinen' ),
		'use_featured_image' => _x( 'Använd som omslagsbild', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'insandarmaskinen' ),
		'archives'  => _x( 'Insändararkiv', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'insandarmaskinen' ),
		'insert_into_item' => _x( 'Lägg till i Insändare', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'insandarmaskinen' ),
		'uploaded_to_this_item' => _x( 'Ladda upp till Insändare', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'insandarmaskinen' ),
		'filter_items_list' => _x( 'Filtrera Insändare', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'insandarmaskinen' ),
		'items_list_navigation' => _x( 'Insändarnavigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'insandarmaskinen' ),
		'items_list' => _x( 'Insändare', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'insandarmaskinen' ),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'insandare',
		),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'editor', 'author' ),
	);

	register_post_type( 'insandare', $args );
}
add_action( 'init', 'insandarmaskinen_register_post_types' );


function insandarmaskinen_register_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name' => _x( 'Tidningar', 'taxonomy general name', 'insandarmaskinen' ),
		'singular_name' => _x( 'Tidning', 'taxonomy singular name', 'insandarmaskinen' ),
		'search_items' => __( 'Sök Tidningar', 'insandarmaskinen' ),
		'all_items' => __( 'Alla Tidningar', 'insandarmaskinen' ),
		'parent_item' => __( 'Förälder', 'insandarmaskinen' ),
		'parent_item_colon' => __( 'Förälder:', 'insandarmaskinen' ),
		'edit_item' => __( 'Ändra Tidning', 'insandarmaskinen' ),
		'update_item' => __( 'Uppdatera Tidning', 'insandarmaskinen' ),
		'add_new_item' => __( 'Lägg till Tidning', 'insandarmaskinen' ),
		'new_item_name' => __( 'Nytt Tidningsnamn', 'insandarmaskinen' ),
		'menu_name' => __( 'Tidningar', 'insandarmaskinen' ),
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'tidningar',
		),
	);

	register_taxonomy( 'tidningar', array( 'insandare' ), $args );
}
add_action( 'init', 'insandarmaskinen_register_taxonomies' );

function insandarmaskinen_taxonomy_custom_fields( $tag ) {
	$term_id = $tag->term_id;
	$term_meta = get_term_meta( $term_id, 'email', true );
	//$term_meta = get_option( "taxonomy_term_$term_id" );
	?>  
	<tr class="form-field">
		<th scope="row" valign="top">  
			<label for="presenter_id"><?php echo esc_html( __( 'E-post', 'insandarmaskinen' ) ); ?></label>  
		</th>  
		<td>  
			<input type="text" name="term_meta" id="term_meta" size="40" value="<?php echo esc_html( $term_meta ? $term_meta : '' ); ?>"><br />  
		</td>  
	</tr>  
<?php
}
add_action( 'tidningar_edit_form_fields', 'insandarmaskinen_taxonomy_custom_fields', 10, 2 );

function insandarmaskinen_save_taxonomy_custom_fields( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$term_meta = esc_html( $_POST['term_meta'] );
		update_term_meta( $term_id, 'email', $term_meta, true );
	}
}
add_action( 'edited_tidningar', 'insandarmaskinen_save_taxonomy_custom_fields', 10, 2 );

function last_month_stats() {
	global $wpdb;
	$month_array = $wpdb->get_results(
		"SELECT 
			YEAR(post_date) AS `year`,
			MONTH(post_date) AS `month`, 
	    	count(ID) as posts
		FROM 
	    	wp_posts 
		WHERE 
	    	post_type = 'insandare' AND post_status = 'publish' 
		GROUP BY 
		    YEAR(post_date), MONTH(post_date) 
		ORDER BY 
		    post_date DESC"
	);
	foreach ( $month_array as $key => $value ) {
		$month_array[ $key ]->month = date_i18n( 'F', mktime( 0, 0, 0, $value->month, 10 ) );
	}
	wp_send_json( $month_array );
}
add_action( 'wp_ajax_last_month_stats', 'last_month_stats' );
add_action( 'wp_ajax_nopriv_last_month_stats', 'last_month_stats' );

function set_publication() {
	$post_id = intval( $_POST['post_id'] );
	$name = $_POST['name'];
	$term = get_term_by( 'name', $name, 'tidningar', OBJECT, raw );
	$result = wp_set_post_terms( $post_id, $term->term_id, 'tidningar', true );
	if ( is_wp_error( $result ) ) {
		wp_send_json_error();
	} else {
		$user = wp_get_current_user();
		bp_activity_add( array(
			'action' => '<a href="' . bp_core_get_user_domain( $user->ID ) . '">' . $user->display_name . '</a> har rapporterat en insändare som publicerad.',
			'component' => 'insandarmaskinen',
			'type' => 'insandare_published',
			'primary_link' => get_permalink( $post_id ),
			'user_id' => $user->ID,
			'item_id' => $post_id,
		) );

		wp_send_json( array(
			'result' => $result,
		) );
	}
	wp_die();
}
add_action( 'wp_ajax_set_publication', 'set_publication' );
add_action( 'wp_ajax_nopriv_set_publication', 'set_publication' );

function delete_publication() {
	$post_id = intval( $_POST['post_id'] );
	$name = $_POST['name'];
	$term = get_term_by( 'name', $name, 'tidningar', OBJECT, raw );
	$result = wp_remove_object_terms( $post_id, $term->term_id, 'tidningar' );

	if ( is_wp_error( $result ) ) {
		wp_send_json_error();
	} else {
		wp_send_json( array(
			'result' => $result,
		) );
	}
	wp_die();
}
add_action( 'wp_ajax_delete_publication', 'delete_publication' );
add_action( 'wp_ajax_nopriv_delete_publication', 'delete_publication' );

function schedule_mails() {
	parse_str( $_POST['form_data'], $form_data );

	$post_data = array(
		'post_title' => $form_data['subject'],
		'post_content' => $form_data['content'],
		'post_type' => 'insandare',
		'post_author' => get_current_user_id(),
	);
	$result = wp_insert_post( $post_data, true );

	if ( ! is_wp_error( $result ) ) {
		update_post_meta( $result, 'insandare_from', $form_data['from'] );
		update_post_meta( $result, 'insandare_papers', $form_data['papers'] );

		$args = array();
		$result = wp_schedule_single_event( time() + 360, 'send_scheduled_mail', array( $result ) );

		if ( null === $result ) {
			wp_send_json( array(
				'error' => false,
			) );
			wp_die();
		}
	}
	wp_send_json( array(
		'error' => true,
	) );
	wp_die();
}
add_action( 'wp_ajax_schedule_mails', 'schedule_mails' );
add_action( 'wp_ajax_nopriv_schedule_mails', 'schedule_mails' );

function send_scheduled_mail( $post_id ) {
	$post = get_post( $post_id );
	$from = get_post_meta( $post_id, 'insandare_from', true );
	$papers = array_shift( get_post_meta( $post_id, 'insandare_papers' ) );
	$user = get_userdata( $post->post_author );

	$error = false;
	foreach ( $papers as $paper ) {
		$term = get_term_by( 'slug', $paper, 'tidningar', OBJECT );
		$to = get_term_meta( $term->term_id, 'email', true );
		$contact = xprofile_get_field_data( 2, $post->post_author );

		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
		);
		$subject = $post->post_title;
		$headers[] = 'From: ' . $user->display_name . ' <' . $user->user_email . '>';
		$message = apply_filters( 'the_content', $post->post_content ) . '<p>' . $from . '</p><p>' . nl2br( $contact ) . '</p>';

		$result = wp_mail( $to, $subject, $message, $headers );
		if ( false === $result ) {
			$error = true;
		}
	}
	if ( false === $error ) {
		wp_update_post( array(
			'ID' => $post->ID,
			'post_status' => 'publish',
		) );
		bp_activity_add( array(
			'action' => '<a href="' . bp_core_get_user_domain( $user->ID ) . '">' . $user->display_name . '</a> har skrivit en ny <a href="' . get_permalink( $post->ID ) . '">insändare</a>.',
			'component' => 'insandarmaskinen',
			'type' => 'new_insandare',
			'primary_link' => get_permalink( $post->ID ),
			'user_id' => $user->ID,
			'item_id' => $post->ID,
		) );
	}
}
add_action( 'send_scheduled_mail','send_scheduled_mail' );

add_filter('wp_mail_content_type', function( $content_type ) {
	return 'text/html';
});

function most_published_author() {
	$args = array(
		'posts_per_page' => -1,
		'offset' => 0,
		'orderby' => 'date',
		'order' => 'ASC',
		'post_type' => 'insandare',
		'post_status' => 'publish',
		'date_query' => array(
			'column' => 'post_date_gmt',
			'after'  => date( 'Y-n-j', strtotime( 'first day of previous month' ) ),
			'before'  => date( 'Y-n-j', strtotime( 'first day of this month' ) ),
		),
	);

	$the_query = new WP_Query( $args );
	// The Loop
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$published = wp_get_post_terms( $the_query->post->ID, 'tidningar' );
			$result[ $the_query->post->post_author ]['posted']++;
			$result[ $the_query->post->post_author ]['published'] = $result[ $the_query->post->post_author ]['published'] + count( $published );
			$result[ $the_query->post->post_author ]['post_author'] = $the_query->post->post_author;
			$result[ $the_query->post->post_author ]['post_author_name'] = get_the_author_meta( 'display_name', $the_query->post->post_author );
			$result[ $the_query->post->post_author ]['post_author_link'] = bp_core_get_user_domain( $the_query->post->post_author );
			$result[ $the_query->post->post_author ]['last_action'] = 'Senast aktiv för ' . human_time_diff( strtotime( bp_get_user_last_activity( $the_query->post->post_author ) ), current_time('timestamp') ) . ' sedan';
		}
		wp_reset_postdata();
	}
	usort( $result, 'sort_by_published' );
	$result = array_slice( $result, 0, 5 );
	return $result;
}

function sort_by_published( $a, $b ) {
	return $b['published'] - $a['published'];
}

function get_activity_type( $activity_id ) {
	global $wpdb;
	$type = $wpdb->get_row( $wpdb->prepare( "SELECT type FROM wp_bp_activity WHERE id = %d",  $activity_id ));
	return $type->type;
}

function insandarmaskinen_add_tabs() {
	global $bp;
	bp_core_new_nav_item( array(
		'name'                  => 'Insändare',
		'slug'                  => 'insandare',
		'parent_url'            => $bp->displayed_user->domain,
		'parent_slug'           => $bp->profile->slug,
		'default_subnav_slug'   => 'insandare',
		'screen_function'       => 'insandarmaskinen_insandare_screen',
		'position'              => 19,
	));
	bp_core_new_nav_item( array(
		'name'                  => 'Logga ut',
		'slug'                  => 'logout',
		'parent_url'            => $bp->displayed_user->domain,
		'parent_slug'           => $bp->profile->slug,
		'default_subnav_slug'   => 'insandare',
		'screen_function'       => 'insandarmaskinen_insandare_logout',
		'position'              => 99,
	));
}
add_action( 'bp_setup_nav', 'insandarmaskinen_add_tabs', 100 );

function insandarmaskinen_insandare_screen() {
	add_action( 'bp_template_content', 'insandarmaskinen_insandare_screen_content' );
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function insandarmaskinen_insandare_logout() {
	wp_redirect( str_replace( '&amp;', '&', wp_logout_url( home_url( '/login/' ) ) ) );
}
function insandarmaskinen_insandare_screen_content() {
	get_template_part( 'templates/loop', 'insandare' );
}

function custom_rewrite_basic() {
	add_rewrite_rule('medlemmar/ingela/insandare/page/([0-9]{1,})/?', 'index.php?pagename=insandarguide&paged=$matches[2]', 'top');
}
add_action('init', 'custom_rewrite_basic');

function the_publications() {
	$terms = get_the_terms( get_the_id(), 'tidningar' );
	if ( $terms ) {
		$publications = wp_list_pluck( $terms, 'name' );
		echo wp_json_encode( $publications );
	}
}

function the_publications_count() {
	echo esc_html( get_publications_count() );
}

function get_publications_count() {
	$terms = get_the_terms( get_the_id(), 'tidningar' );
	if ( $terms ) {
		return count( $terms );
	} else {
		return 0;
	}
}


function clean_users() {
	$args = [
		'date_query' => [
			[ 'before'  => '2017-06-01', 'inclusive' => true ],
		],
	];

	$user_query = new WP_User_Query( $args );
	if ( ! empty( $user_query->get_results() ) ) {
		foreach ( $user_query->get_results() as $user ) {
			if( strtotime('-6 month') >= strtotime( bp_get_user_last_activity( $user->ID ) ) ) {
				wp_update_user( array(
					'ID' => $user->ID,
					'role' => 'inactive',
				));
			}
		}
	}}
//add_action( 'init', 'clean_users', 100 );

function the_medals( $user_id ) {
	$reported_publications = get_user_meta( $user_id, 'reported_publications', true );
	if ( $reported_publications && $reported_publications['medal'] ) {
		echo '<img class="medal" src="' . get_template_directory_uri() . '/dist/assets/images/medals/like.svg" alt="Superrapportör!" />';
	}
	$user_publications = get_user_meta( $user_id, 'user_publications', true );
	if ( $user_publications && $user_publications['medal'] ) {
		echo '<img class="medal" src="' . get_template_directory_uri() . '/dist/assets/images/medals/003-medal-3.svg" alt="Superskribent!" />';
	}
	$reported_post_publications = get_user_meta( $user_id, 'reported_post_publications', true );
	if ( $reported_post_publications && $reported_post_publications['medal'] ) {
		echo '<img class="medal" src="' . get_template_directory_uri() . '/dist/assets/images/medals/trophy.svg" alt="Superpublicist!" />';
	}
}

if ( ! wp_next_scheduled( 'insandarmaskinen_daily_updates' ) ) {
  wp_schedule_event( time(), 'daily', 'insandarmaskinen_daily_updates' );
}
add_action( 'insandarmaskinen_daily_updates', 'insandarmaskinen_update_medals' );
function insandarmaskinen_update_medals() {
	$users = get_users( array(
		'role__in' => array( 'subscriber', 'administrator' ),
	) );
	foreach ( $users as $user ) {
		update_user_reported_publications( $user );
		update_user_publications( $user );
		update_post_reported_publications( $user );
	}
}

function update_user_publications( $user ) {
	global $wpdb;
	$user_publications = get_user_meta( $user->ID, 'user_publications', true );
	$date = date( 'Y-m-d', strtotime( '-6 months' ) );
	$publications = 0;

	$the_query = new WP_Query( array(
		'author' => $user->ID,
		'posts_per_page' => -1,
		'offset' => 0,
		'orderby' => 'date',
		'order' => 'ASC',
		'post_type' => 'insandare',
		'post_status' => 'publish',
		'date_query' => array(
			'column' => 'post_date_gmt',
			'after'  => '180 days ago',
		),
	) );

	$user_publications_medal = $wpdb->get_results( "SELECT * FROM wp_bp_activity WHERE user_id = $user->ID && component = 'insandarmaskinen' && type = 'user_publications_medal' && date_recorded > '$date'", ARRAY_A );

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$publications++;
		}
		wp_reset_postdata();
	}

	if ( count( $user_publications_medal ) === 0 && $publications >= 10 ) {
		bp_activity_add( array(
			'action' => '<a href="' . bp_core_get_user_domain( $user->ID ) . '">' . $user->display_name . '</a> har blivit Superskribent då hen skickat över 10 insändare det senaste halvåret.',
			'component' => 'insandarmaskinen',
			'type' => 'user_publications_medal',
			'user_id' => $user->ID,
		) );
	}

	update_user_meta( $user->ID, 'user_publications', array(
		'count' => $publications,
		'medal' => ( $publications >= 10 ? true : false ),
	) );
}

function update_post_reported_publications( $user ) {
	global $wpdb;

	$reported_publications = get_user_meta( $user->ID, 'reported_post_publications', true );

	$the_query = new WP_Query( array(
		'author' => $user->ID,
		'posts_per_page' => -1,
		'offset' => 0,
		'orderby' => 'date',
		'order' => 'ASC',
		'post_type' => 'insandare',
		'post_status' => 'publish',
		'date_query' => array(
			'column' => 'post_date_gmt',
			'after'  => '30 days ago',
		),
	) );
	update_user_meta( $user->ID, 'reported_post_publications', array(
		'count' => 0,
		'medal' => false,
	) );
	$reported_post_publications_medal = $wpdb->get_results( "SELECT * FROM wp_bp_activity WHERE user_id = $user->ID && component = 'insandarmaskinen' && type = 'reported_post_publications_medal' && date_recorded > '$date'", ARRAY_A );

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$count = get_publications_count();

			if ( $count >= 10 ) {
				update_post_meta( get_the_id(), 'reported_post_publications', $count, true );
				update_user_meta( $user->ID, 'reported_post_publications', array(
					'count' => $count,
					'medal' => true,
				) );
				if ( count( $reported_post_publications_medal ) === 0 ) {
					bp_activity_add( array(
						'action' => '<a href="' . bp_core_get_user_domain( $user->ID ) . '">' . $user->display_name . '</a> har blivit Superpublicist denna månad.',
						'component' => 'insandarmaskinen',
						'type' => 'reported_post_publications_medal',
						'user_id' => $user->ID,
					) );
				}
			}
		}
		wp_reset_postdata();
	}
}

function update_user_reported_publications( $user ) {
	global $wpdb;

	$reported_publications = get_user_meta( $user->ID, 'reported_publications', true );
	$date = date( 'Y-m-d', strtotime( '-1 months' ) );

	$insandare_published = $wpdb->get_results( "SELECT * FROM wp_bp_activity WHERE user_id = $user->ID && component = 'insandarmaskinen' && type = 'insandare_published' && date_recorded > '$date'", ARRAY_A );
	$reported_publications_medal = $wpdb->get_results( "SELECT * FROM wp_bp_activity WHERE user_id = $user->ID && component = 'insandarmaskinen' && type = 'reported_publications_medal' && date_recorded > '$date'", ARRAY_A );

	if( count( $reported_publications_medal ) === 0 && count( $insandare_published ) >= 10 ) {
		bp_activity_add( array(
			'action' => '<a href="' . bp_core_get_user_domain( $user->ID ) . '">' . $user->display_name . '</a> har blivit Superrapportör denna månad.',
			'component' => 'insandarmaskinen',
			'type' => 'reported_publications_medal',
			'user_id' => $user->ID,
		) );
	}

	update_user_meta( $user->ID, 'reported_publications', array(
		'count' => count( $insandare_published ),
		'medal' => ( count( $insandare_published ) >= 10 ? true : false ),
	) );
}

function insandarmaskinen_template_include( $original_template ) {
	global $post;
	if ( 'registrera' === $post->post_name ) {
		$new_template = get_template_directory() . '/templates/template-register.php';
		return $new_template;
	}
	return $original_template;
}
add_filter( 'template_include', 'insandarmaskinen_template_include' );

function insandarmaskinen_remove_rich_text( $field_id = null ) {
	if ( ! $field_id ) {
		$field_id = bp_get_the_profile_field_id( '3' );
	}
	$field = xprofile_get_field( $field_id );
	if ( $field ) {
		$enabled = false;
	}
}
add_filter( 'bp_xprofile_is_richtext_enabled_for_field', 'insandarmaskinen_remove_rich_text' );

function insandarmaskinen_force_login() {
	if ( ! is_user_logged_in() && ( ! is_page( 'login' ) &&  ! is_page( 'registrera' ) ) ) {
		wp_redirect( home_url( '/login/' ) );
		exit;
	}
}
add_action( 'wp', 'insandarmaskinen_force_login' );
