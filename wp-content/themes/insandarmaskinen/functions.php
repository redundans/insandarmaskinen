<?php

add_filter( 'show_admin_bar', '__return_false' );

if ( !function_exists( 'bp_dtheme_enqueue_styles' ) ) :
function bp_dtheme_enqueue_styles() {
 
    // You should bump this version when changes are made to bust cache
    $version = '20121109';
 
        // Register stylesheet of bp-dusk child theme
    wp_register_style( 'insandarmaskinen', get_stylesheet_directory_uri() . '/style.css', array(), $version );
 
    // Enqueue stylesheet of bp-dusk chid theme
    wp_enqueue_style( 'insandarmaskinen' );
}
add_action( 'wp_enqueue_scripts', 'bp_dtheme_enqueue_styles' );
endif;

function my_scripts_method() {
    //wp_deregister_script( 'jquery' );
    wp_register_script( 'chart', get_stylesheet_directory_uri().'/js/Chart.min.js');
    wp_enqueue_script( 'chart' );
    wp_enqueue_script( 'suggest' );
    wp_enqueue_style( 'suggest' );
}    
 
add_action('wp_enqueue_scripts', 'my_scripts_method');

add_action( 'init', 'create_post_type' );
function create_post_type() {
    register_post_type( 'insandare',
        array(
            'labels' => array(
                'name' => __( 'Insändare' ),
                'singular_name' => __( 'Insändare' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'insandare'),
        )
    );
    flush_rewrite_rules( false );
}

add_action( 'init', 'create_papers_taxonomies', 0 );

//create two taxonomies, genres and writers for the post type "book"
function create_papers_taxonomies() 
{
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Tidningar', 'taxonomy general name' ),
    'singular_name' => _x( 'Tidning', 'taxonomy singular name' ),
    'search_items' =>  __( 'Sök tidningar' ),
    'all_items' => __( 'Alla tidningar' ),
    'parent_item' => __( 'Tidningsförälder' ),
    'parent_item_colon' => __( 'Tidningsförälder:' ),
    'edit_item' => __( 'Ändra tindning' ), 
    'update_item' => __( 'Uppdatera tidning' ),
    'add_new_item' => __( 'Lägg till tidning' ),
    'new_item_name' => __( 'Nytt tidningsnamn' ),
    'menu_name' => __( 'Tidningar' ),
);    

register_taxonomy('paper',array('insandare'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'paper' ),
  ));
}


if( ! function_exists( 'add_insandare_nav' ) ) {
    function add_insandare_nav() {
        global $bp;
        global $current_user;
        bp_core_remove_nav_item( 'blogs');
        bp_core_new_subnav_item( 
            array( 
                'name' => 'Statistik', 
                'slug' => 'statistik', 
                'parent_slug' => $bp->groups->current_group->slug, 
                'parent_url' => bp_get_group_permalink( $bp->groups->current_group ), 
                'position' => 11, 
                'item_css_id' => 'statistik',
                'screen_function' => statistics_screen,
                'user_has_access' => 1
            ) 
        );
        bp_core_new_subnav_item( 
            array( 
                'name' => 'Skriv en insändare', 
                'slug' => 'skriv-en-insandare', 
                'parent_slug' => $bp->groups->current_group->slug, 
                'parent_url' => bp_get_group_permalink( $bp->groups->current_group ), 
                'position' => 11, 
                'item_css_id' => 'skriv-en-insandare',
                'screen_function' => write_letter_screen,
                'user_has_access' => 1
            ) 
        );
        bp_core_new_subnav_item( 
            array( 
                'name' => 'Läs insändare', 
                'slug' => 'las-insandare', 
                'parent_slug' => $bp->groups->current_group->slug, 
                'parent_url' => bp_get_group_permalink( $bp->groups->current_group ), 
                'position' => 12, 
                'item_css_id' => 'las-insandare',
                'screen_function' => read_letter_screen,
                'user_has_access' => 1
            ) 
        );
    }
}
add_action( 'bp_setup_nav', 'add_insandare_nav', 1000 );

if( ! function_exists( 'statistics_screen' ) ) {
    function statistics_screen() {
        add_action( 'bp_template_content', 'statistics_screen_show' );
            bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'groups/single/plugins' ) );
    }
}

if( ! function_exists( 'statistics_screen_show' ) ) {
    function statistics_screen_show() {
        locate_template( array( 'groups/single/statistics.php' ), true );
    }
}

if( ! function_exists( 'write_letter_screen' ) ) {
    function write_letter_screen() {
        add_action( 'bp_template_content', 'write_letter_screen_show' );
            bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'groups/single/plugins' ) );
    }
}

if( ! function_exists( 'write_letter_screen_show' ) ) {
    function write_letter_screen_show() {
        locate_template( array( 'groups/single/write-letter.php' ), true );
    }
}


// show the stuff from mysoft when clicking on medlemsregistret
if( ! function_exists( 'read_letter_screen' ) ) {
    function read_letter_screen() {
        add_action( 'bp_template_content', 'read_letter_screen_show' );
            bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'groups/single/plugins' ) );
    }
}

if( ! function_exists( 'read_letter_screen_show' ) ) {
    function read_letter_screen_show() {
        locate_template( array( 'groups/single/read-letter.php' ), true );
    }
}

register_nav_menu( 'user', 'User menu' );

add_action('paper_add_form_fields', 'category_metabox_add', 10, 1);
add_action('paper_edit_form_fields', 'category_metabox_edit', 10, 1);    
 
function category_metabox_add($tag) { ?>
    <div class="form-field">
        <label for="email"><?php _e('Email') ?></label>
        <input name="email" id="email" type="text" value="" size="40" aria-required="true" />
    </div>
<?php }     
 
function category_metabox_edit($tag) { ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="email"><?php _e('Email'); ?></label>
        </th>
        <td>
            <input name="email" id="email" type="text" value="<?php echo get_term_meta($tag->term_id, 'email', true); ?>" size="40" aria-required="true" />
        </td>
    </tr>
<?php }

add_action('created_paper', 'save_category_metadata', 10, 1);    
add_action('edited_paper', 'save_category_metadata', 10, 1);
 
function save_category_metadata($term_id)
{
    if (isset($_POST['email'])) 
        update_term_meta( $term_id, 'email', $_POST['email']);                  
}

add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');

function new_mail_from($old) {
    global $bp;
    $user_email = $bp->loggedin_user->userdata->user_email;
    return $user_email;
}

function new_mail_from_name($old) {
    global $bp;
    $user_name = bp_get_profile_field_data( array('user_id'=>$bp->loggedin_user->id,'field'=>1 ));
    return $user_name;
}


function ray_bp_autocomplete_list($friends, $filter, $limit) {
    global $wpdb, $bp;
    error_log('kör ray_bp_autocomplete_list');

    $filter = like_escape( $wpdb->escape( $filter ) );
    $page = 1;

    if ( $limit && $page )
        $pag_sql = $wpdb->prepare( " LIMIT %d, %d", intval( ( $page - 1 ) * $limit), intval( $limit ) );

    // filter the user_ids based on the search criteria.
    if ( function_exists('xprofile_install') ) {
        $sql = "SELECT DISTINCT user_id FROM {$bp->profile->table_name_data} WHERE value LIKE '$filter%%' {$pag_sql}";
        $total_sql = "SELECT COUNT(DISTINCT user_id) FROM {$bp->profile->table_name_data} WHERE value LIKE '$filter%%'";
    } else {
        $sql = "SELECT DISTINCT user_id FROM " . CUSTOM_USER_META_TABLE . " WHERE meta_key = 'nickname' AND meta_value LIKE '$filter%%' {$pag_sql}";
        $total_sql = "SELECT COUNT(DISTINCT user_id) FROM " . CUSTOM_USER_META_TABLE . " WHERE meta_key = 'nickname' AND meta_value LIKE '$filter%%'";
    }

    $filtered_ids = $wpdb->get_col($sql);
    $total_ids = $wpdb->get_var($total_sql);

    if ( !$filtered_ids )
        return false;

    return array( 'friends' => $filtered_ids, 'total' => (int)$total_ids );
}
add_filter( 'bp_friends_autocomplete_list', 'ray_bp_autocomplete_list', 1, 3 );


add_action( 'wp_ajax_messages_autocomplete_results', 'insandarmaskinen_ajax_messages_autocomplete_results' );
add_action( 'wp_ajax_nopriv_messages_autocomplete_results', 'insandarmaskinen_ajax_messages_autocomplete_results' );

function insandarmaskinen_ajax_messages_autocomplete_results() {
    global $bp;

    $pag_page = 1;
    $limit    = $_GET['limit'] ? $_GET['limit'] : apply_filters( 'bp_autocomplete_max_results', 10 );
    
    $users = BP_Core_User::search_users( $_GET['q'], $limit, $pag_page );

    if ( ! empty( $users['users'] ) ) {
        $user_ids = array();
        foreach( $users['users'] as $user ) {
            if ( $user->id != bp_loggedin_user_id() )
                $user_ids[] = $user->id;
        }

        $user_ids = apply_filters( 'bp_core_autocomplete_ids', $user_ids, $_GET['q'], $limit );
    }

    if ( ! empty( $user_ids ) ) {
        foreach ( $user_ids as $user_id ) {
            $ud = get_userdata( $user_id );
            if ( ! $ud )
                continue;

            if ( bp_is_username_compatibility_mode() )
                $username = $ud->user_login;
            else
                $username = $ud->user_nicename;

            // Note that the final line break acts as a delimiter for the
            // autocomplete javascript and thus should not be removed
            echo '<span id="link-' . $username . '" href="' . bp_core_get_user_domain( $user_id ) . '"></span>' . bp_core_fetch_avatar( array( 'item_id' => $user_id, 'type' => 'thumb', 'width' => 15, 'height' => 15, 'alt' => $ud->display_name ) ) . ' &nbsp;' . bp_core_get_user_displayname( $user_id ) . ' (' . $username . ')' . "\n";
        }
    }

    exit;
}


add_action("wp_ajax_report_paper", "report_paper");
add_action("wp_ajax_nopriv_report_paper", "report_paper");

function report_paper() {
    global $wpdb;
    global $bp;
    $post_id = $_REQUEST["post_id"];
    $papers = $_REQUEST["papers"];
    $papers = explode(',', $papers);
    $terms = array();
    $current_user = wp_get_current_user();
    $userlink = bp_core_get_userlink( $current_user->ID );

    foreach ($papers as $paper) {
        if( !empty($paper) ):
            $term = get_term_by('name', $paper, 'paper');
            $terms[] = $term->term_id;
        endif;
    }

    if( $terms[0] == NULL ):
        echo json_encode( array( 'error' => 1, 'message' => 'Ledsen, vi kunde inte hitta någon tidning med det namnet. Saknar du denna tidning på Insändarmaskinen™ så meddela en administratör i användarforumet så lägger hen till den.' ) );
        die();
    else:
        $activity_id = bp_activity_add( array( 
            'user_id' => $bp->loggedin_user->id, 
            'action'=> sprintf("%s har rapporterat en <a href='%s'>insändare</a> som publicerad.", bp_core_get_userlink( $bp->loggedin_user->id ), get_permalink( $post_id ) ),
            'content' => false, 
            'primary_link' => bp_core_get_userlink( $bp->loggedin_user->id ),
            'component_name' => 'groups',
            'component_action' =>"report_published",
            'item_id' => $bp->groups->current_group->id,
            'secondary_item_id' => false,
            'recorded_time' => gmdate( "Y-m-d H:i:s" ),
            'hide_sitewide' => false
        ));

        wp_set_post_terms( $post_id, $terms, 'paper', TRUE );

        $term_objects = wp_get_post_terms( $post_id, 'paper' );
        $terms = array();
        foreach ($term_objects as $term) {
            $terms[$term->term_id] = $term->name;
        }

        echo json_encode( array( 'total' => count($terms), 'terms' => $terms ) );
        die();
    endif;
}

add_action("wp_ajax_delete_reported_paper", "delete_reported_paper");
add_action("wp_ajax_nopriv_delete_reported_paper", "delete_reported_paper");

function delete_reported_paper() {
    global $wpdb;
    $post_id = $_REQUEST["post_id"];
    $term = $_REQUEST["term"];
    $terms = array();

    $term_objects = wp_get_post_terms( $post_id, 'paper' );
    
    wp_delete_object_term_relationships( $post_id, 'paper' );

    foreach ($term_objects as $term_object) {
        if( $term != $term_object->term_id):
            $terms[] = $term_object->term_id;
        endif;
    }

    wp_set_post_terms( $post_id, $terms, 'paper', TRUE );

    $term_objects = wp_get_post_terms( $post_id, 'paper' );

    $terms = array();
    foreach ($term_objects as $term) {
        $terms[$term->term_id] = $term->name;
    }

    echo json_encode( array( 'total' => count($terms), 'terms' => $terms ) );
    die();
}

add_action('wp_ajax_tajax-tag-search', 'add_autosuggest_20links_callback');
add_action('wp_ajax_nopriv_tajax-tag-search', 'add_autosuggest_20links_callback');
function add_autosuggest_20links_callback(){
    global $wpdb;
    if ( isset( $_GET['tax'] ) ) {
        $taxonomy = sanitize_key( $_GET['tax'] );
        $tax = get_taxonomy( $taxonomy );
        if ( ! $tax )
            die();
    } else {
        die();
    }
    $s = stripslashes( $_GET['q'] );
    if ( false !== strpos( $s, ',' ) ) {
        $s = explode( ',', $s );
        $s = $s[count( $s ) - 1];
    }
    $s = trim( $s );
    if ( strlen( $s ) < 2 )
        die; // require 2 chars for matching
    $results = $wpdb->get_col( $wpdb->prepare( "SELECT t.name FROM $wpdb->term_taxonomy AS tt INNER JOIN $wpdb->terms AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = %s AND t.name LIKE (%s)", $taxonomy, '%' . like_escape( $s ) . '%' ) );
    echo join( $results, "\n" );
}