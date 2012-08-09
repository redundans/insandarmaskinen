<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a seperate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/


// let's create the function for the custom type
function custom_post_insandare() { 
	// creating (registering) the custom type 
	register_post_type( 'letter', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Letters to the editor', 'post type general name'), /* This is the Title of the Group */
			'singular_name' => __('Letter to the editor', 'post type singular name'), /* This is the individual type */
			'add_new' => __('Add New', 'custom post type item'), /* The add new menu item */
			'add_new_item' => __('Add New letter'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit letter'), /* Edit Display Title */
			'new_item' => __('New letter'), /* New Display Title */
			'view_item' => __('View letter'), /* View Display Title */
			'search_items' => __('Search letters'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is letters to the editor' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'capability_type' => 'post',
			'hierarchical' => false,
			'has_archive' => true,
			'rewrite' => array('slug' => 'insandare'),
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'revisions')
	 	) /* end of options */
	); /* end of register post type */
	
	/* this ads your post categories to your custom post type */
	register_taxonomy_for_object_type('category', 'letter');
	/* this ads your post tags to your custom post type */
	//register_taxonomy_for_object_type('post_tag', 'letter');
	
} 

// adding the function to the Wordpress init
add_action( 'init', 'custom_post_insandare');

add_action('category_add_form_fields', 'category_metabox_add', 10, 1);
add_action('category_edit_form_fields', 'category_metabox_edit', 10, 1);	
 
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

add_action('created_category', 'save_category_metadata', 10, 1);	
add_action('edited_category', 'save_category_metadata', 10, 1);
 
function save_category_metadata($term_id)
{
    if (isset($_POST['email'])) 
		update_term_meta( $term_id, 'email', $_POST['email']);         			
}

?>