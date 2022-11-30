<?php
namespace HivePress\Controllers;

use HivePress\Helpers as hp;
use HivePress\Models;
use HivePress\Blocks;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Controller class.
 */
final class Hello_World extends Controller {

	/**
	 * Class constructor.
	 *
	 * @param array $args Controller arguments.
	 */
	public function __construct( $args = [] ) {
		$args = hp\merge_arrays(
			[
				'routes' => [
					// WEB routes
					'hello_world_page' => [
                        'title'     => esc_html__( 'Hello World', 'hello-world' ),
                        'path'      => '/hello-world',
                        'action'    => [ $this, 'render_hello_world_page' ],
                        'paginated' => true,
                    ],

					// REST routes
					'hello_world_form_submit' => [
						'path' => '/hello-world-submit',
						'action' => [ $this, 'hello_world_form_submit' ],
						'method' => 'POST',
						'rest' => true,
					],
				],
			],
			$args
		);

		parent::__construct( $args );
	}

	/**
	 * Submitted Hello World form.
	 * Here we renaming username.
	 * 
	 * @return WP_Rest_Response
	 */
	public function hello_world_form_submit() {

		// Check authentication.
		if ( ! is_user_logged_in() ) {
			return hp\rest_error( 401 );
		}

		// Get user
		$user = new \HivePress\Models\User;
		$current_user = $user::query()->get_by_id( get_current_user_ID() );

		if ( empty( $current_user ) ) {
			return hp\rest_response( 404 );
		}

		// Set new username
		if ( $current_user->get_first_name() !== 'Hello World' ) {
			$current_user->set_first_name( 'Hello World' )->save();

			return hp\rest_response( 200, [ 'name' => $current_user->get_first_name() ] );			
		} 
	
		$current_user->set_first_name( 'John Doe' )->save();

		return hp\rest_response( 200, [ 'name' => $current_user->get_first_name() ] );	

	}

	/**
	 * Renders hello world page.
	 *
	 * @return string
	 */
	public function render_hello_world_page() {
		
		// Get user registeration hours from now
		$user_data = get_userdata( get_current_user_ID() );
		$registered_date = $user_data->user_registered;
		$registered_hours_from_now = date( "H", strtotime( $registered_date ) - gettimeofday()['sec'] );

		// Check authentication and register hours.
		if ( ! is_user_logged_in() && $registered_hours_from_now < 1) {
			wp_redirect(get_bloginfo('url')); exit;
		}

		// Render page template.
		return ( new Blocks\Template(
			[
				'template' => 'hello_world_page',
			]
		) )->render();

	}

}