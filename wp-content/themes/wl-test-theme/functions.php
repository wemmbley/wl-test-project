<?php 

add_theme_support( 'custom-logo' );

/**
 * Custom Post Types.
 */
function add_custom_post_types() {

    // Cars
	register_post_type('cars',
		array(
			'labels'      => array(
				'name'          => __('Cars'),
				'singular_name' => __('Car'),
			),
			'public'      => true,
			'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
		)
	);

}
add_action('init', 'add_custom_post_types');



/**
 * Custom Taxonomies.
 */
function add_custom_taxonomies() {

    // Brand
    register_taxonomy('brand', 'cars', array(
      'hierarchical' => false,
      'labels' => array(
        'name' => _x( 'Brands', 'taxonomy general name' ),
        'singular_name' => _x( 'Brand', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Brands' ),
        'all_items' => __( 'All Brands' ),
        'parent_item' => __( 'Parent Brand' ),
        'parent_item_colon' => __( 'Parent Brand:' ),
        'edit_item' => __( 'Edit Brand' ),
        'update_item' => __( 'Update Brand' ),
        'add_new_item' => __( 'Add New Brand' ),
        'new_item_name' => __( 'New Brand Name' ),
        'menu_name' => __( 'Brands' ),
      ),
      'rewrite' => array(
        'slug' => 'brands',
        'with_front' => false,
        'hierarchical' => true 
      ),
    ));

    // Country manufacturer
    register_taxonomy('country_manufacturer', 'cars', array(
        'hierarchical' => false,
        'labels' => array(
          'name' => _x( 'Countries', 'taxonomy general name' ),
          'singular_name' => _x( 'Country', 'taxonomy singular name' ),
          'search_items' =>  __( 'Search Country' ),
          'all_items' => __( 'All Countries' ),
          'parent_item' => __( 'Parent Country' ),
          'parent_item_colon' => __( 'Parent Country:' ),
          'edit_item' => __( 'Edit Country' ),
          'update_item' => __( 'Update Country' ),
          'add_new_item' => __( 'Add New Country' ),
          'new_item_name' => __( 'New Country Name' ),
          'menu_name' => __( 'Countries' ),
        ),
        'rewrite' => array(
          'slug' => 'country_manufacturer',
          'with_front' => false,
          'hierarchical' => true 
        ),
    ));

}
add_action( 'init', 'add_custom_taxonomies', 0 );


/**
 * Register meta boxes.
 */
function add_custom_meta_boxes() {

    add_meta_box( 'wl_cars_metabox', __( 'Additional params' ), function(){

        render_meta_form( function( ) {
            get_post_type_view('color');
            get_post_type_view('fuel');
            get_post_type_view('power');
            get_post_type_view('price');
        });

    }, 'cars' );

}
add_action( 'add_meta_boxes', 'add_custom_meta_boxes' );



/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function save_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    $fields = [
        'wl_color',
        'wl_fuel',
        'wl_power',
        'wl_price',
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
        }
     }
}
add_action( 'save_post', 'save_meta_box' );



/**
* Custom Customizer.
*/
function add_custom_customizer( $wp_customize ) {

    $wp_customize->add_setting( 'phone_number' );
    $wp_customize->add_control( 'phone_number', array(
        'label' => __( 'Phone number' ),
        'section' => 'title_tagline',
        'settings' => 'phone_number',
    ) );

}
add_action('customize_register', 'add_custom_customizer');



/**
 * Custom shortcodes.
 */
function shortcode_last_ten_cars() {

    $cars = [];
    $args = array(
        'post_type'         => 'cars',
        'order'             => 'ASC',
        'posts_per_page'    => 10,
        'post_status'       => 'publish',
    );              

    $loop = new WP_Query( $args );

    if($loop->have_posts() ) {

        echo '<ul>';

        while ( $loop->have_posts() ) {
            $loop->the_post();

            echo '<li>';
            echo get_the_post_thumbnail( get_the_ID(), [ 50, 50 ] );
            echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
            echo '</li>';

        } 

        echo '</ul>';

        wp_reset_postdata();  
    }

}

function shortcode_init(){
	add_shortcode( 'last_ten_cars', 'shortcode_last_ten_cars' );
}
add_action('init', 'shortcode_init');



/**
 * Custom functions.
 */
function get_post_type_view( $name ) {
    return require_once get_stylesheet_directory() . '/lib/view/post_type_cars/' . $name . '.php';
}

function render_meta_form( closure $func ) {
    echo '<form method="POST">';
    $func();
    echo '</form>';
}

function get_meta_field( $post_ID, $name ) {
    $field = get_the_terms( $post_ID, $name );

    if ( isset( $field[0] ) && is_object( $field[0] ) ) {
        return $field[0]->name;
    } else {
        return 'undefined';
    }
}