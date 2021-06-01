<?php 


require_once 'custom-class-walker-nav-menu.php';
require_once 'custom-class-walker-nav-menu-back.php';

//var_dump(get_nav_menu_locations());

add_option( 'awesome_menu', '', '', 'yes' );
function wp_nav_menu_populate_missing_theme_location( $args ) {
    $m = get_option("awesome_menu");
    if ( ! isset( $args['theme_location'] ) || $args['theme_location'] == $m ) {
        $args['walker'] = new WP_Bootstrap_Navwalker;
    }
    return $args;
}
add_filter( 'wp_nav_menu_args', 'wp_nav_menu_populate_missing_theme_location' );

 
// Add a new top level menu link to the ACP
function mfp_Add_My_Admin_Link()
{
 add_menu_page(
 'Awesome Menu', // Title of the page
 'Awesome Menu', // Text to show on the menu link
 'manage_options', // Capability requirement to see the link
 //'display_text'
 plugin_dir_path(__FILE__) . '/admin-control.php' // The 'slug' - file to display when clicking the link
 );
}
add_action( 'admin_menu', 'mfp_Add_My_Admin_Link' );
		 

function get_woo_categories(){
    $orderby = 'name';
    $order = 'asc';
    $hide_empty = false ;
    $cat_args = array(
        'orderby'    => $orderby,
        'order'      => $order,
        'hide_empty' => $hide_empty,
    );
    $args = array(
        'number'     => $number,
        'orderby'    => $orderby,
        'order'      => $order,
        'hide_empty' => $hide_empty,
        'include'    => $ids
    );

    $product_categories = get_terms( 'product_cat', $args );

    // since wordpress 4.5.0
    $args = array(
        'taxonomy'   => "product_cat",
        'number'     => $number,
        'orderby'    => $orderby,
        'order'      => $order,
        'hide_empty' => $hide_empty,
        'include'    => $ids
    );
    $product_categories = get_terms($args);
   return $product_categories;
}
function get_loop_prod($cat, $cant){
    $loop = new WP_Query( array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $cant,
        'tax_query' => array( array(
            'taxonomy'         => 'product_cat',
            'terms'            => $cat, // A slug term
            // 'include_children' => false // or true (optional)
        )),
        'orderby' => 'rand'
    ) );
    if($loop->have_posts()){
        return $loop;
    }
}
/*
 * Saves new field to postmeta for navigation
 */
add_action('wp_update_nav_menu_item', 'custom_nav_update',9999999999, 3);
function custom_nav_update($menu_id, $menu_item_db_id, $args ) {
    if ( is_array($_REQUEST['menu-item-custom']) ) {
        $custom_value = $_REQUEST['menu-item-custom'][$menu_item_db_id];
        $custom_value2 = $_REQUEST['menu-item-custom2'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, '_menu_item_custom', $custom_value );
        update_post_meta( $menu_item_db_id, '_menu_item_custom2', $custom_value2 );
    }
}

/*
 * Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Edit_Custom
 */
add_filter( 'wp_setup_nav_menu_item','custom_nav_item' );
function custom_nav_item($menu_item) {
    $menu_item->custom = get_post_meta( $menu_item->ID, '_menu_item_custom', true );
    $menu_item->custom2 = get_post_meta( $menu_item->ID, '_menu_item_custom2', true );
    return $menu_item;
}


add_filter( 'wp_edit_nav_menu_walker', 'custom_nav_edit_walker',9999999999,3 );
function custom_nav_edit_walker($walker,$menu_id) {
    return 'Walker_Nav_Menu_Edit_Custom';
}