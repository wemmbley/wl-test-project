<?php
namespace HivePress\Forms;

use HivePress\Helpers as hp;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Hello_World extends Form {
	public function __construct( $args = [] ) {
		$args = hp\merge_arrays(
			[

				// Set the form parameters.
				'action'  => hivepress()->router->get_url( 'hello_world_form_submit' ),
				'method'  => 'POST',
				'message' => esc_html__( 'New name saved!', 'saved' ),
				'reset'   => true,

				// Set the field parameters.
				'fields'  => [
					'name' => [
						'label'    => esc_html__( 'Name', 'name' ),
						'type'     => 'text',
						'required' => true,
						'_order'   => 123,
					],
				],

				// Set the button parameters.
				'button'  => [
					'value' => esc_html__( 'Save', 'button_submit' ),
				],

			],
			$args
		);

		parent::__construct( $args );
	}
}
