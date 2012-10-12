<?php

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
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://code.jquery.com/jquery-latest.js');
    wp_enqueue_script( 'jquery' );
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
    'hierarchical' => false,
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