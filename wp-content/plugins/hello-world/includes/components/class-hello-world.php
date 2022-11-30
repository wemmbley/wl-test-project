<?php
namespace HivePress\Components;

use HivePress\Helpers as hp;
use HivePress\Models;
use HivePress\Emails;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Component class.
 */
final class Hello_World extends Component {

	/**
	 * Class constructor.
	 *
	 * @param array $args Component arguments.
	 */
	public function __construct( $args = [] ) {

		// A new menu item to the user account menu
		add_filter(
			'hivepress/v1/menus/user_account',
			function( $menu ) {
				$menu['items']['custom_item'] = [
					'label'  => 'Hello World',
					'url'    => '/hello-world',
					'_order' => 0,
				];
		
				return $menu;
			}
		);

		// A new button to the listing page sidebar
		add_filter(
			'hivepress/v1/templates/listing_view_page',
			function( $template ) {
				$template['blocks']['page_container']['blocks']['page_columns']['blocks']['page_sidebar']['blocks'][] = [
					'type' => 'content',
					'content' => '<button class="hp-menu__item hp-menu__item--listing-submit button button--secondary"> <a href="/hello-world">Hello World</a> </button>',
				];

				return $template;
			}
		);

		parent::__construct( $args );

	}

}