<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();

    echo get_the_post_thumbnail( get_the_ID(), [ 400, 400 ] ) . '<br>';

    echo 'Brand: ' . get_meta_field( get_the_ID(), 'brand' ) . '<br>';
    echo 'Country: ' . get_meta_field( get_the_ID(), 'country_manufacturer' ) . '<br>';
    echo 'Color: ' . get_post_meta( get_the_ID(), 'wl_color', true ) . '<br>';
    echo 'Power: ' . get_post_meta( get_the_ID(), 'wl_power', true ) . '<br>';
    echo 'Fuel: ' . get_post_meta( get_the_ID(), 'wl_fuel', true ) . '<br>';
    echo 'Price: ' . get_post_meta( get_the_ID(), 'wl_price', true ) . '<br>';

	get_template_part( 'template-parts/content/content-single' );

	if ( is_attachment() ) {
		// Parent post navigation.
		the_post_navigation(
			array(
				/* translators: %s: Parent post link. */
				'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentytwentyone' ), '%title' ),
			)
		);
	}

	// If comments are open or there is at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}

	$twentytwentyone_next_label     = esc_html__( 'Next post', 'twentytwentyone' );
	$twentytwentyone_previous_label = esc_html__( 'Previous post', 'twentytwentyone' );

	the_post_navigation(
		array(
			'next_text' => '<p class="meta-nav">' . $twentytwentyone_next_label . '</p><p class="post-title">%title</p>',
			'prev_text' => '<p class="meta-nav">' . $twentytwentyone_previous_label . '</p><p class="post-title">%title</p>',
		)
	);
endwhile; // End of the loop.

get_footer();
