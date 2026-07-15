<?php
/**
 * One-time WordPress setup for Nutritionist theme pages & menus.
 *
 * Run from site root:
 *   php wp-content/themes/nutritionist_theme/bin/setup-site.php
 *
 * @package nutritionist_theme
 */

if ( 'cli' !== php_sapi_name() ) {
	fwrite( STDERR, "Run this script from the command line only.\n" );
	exit( 1 );
}

$wp_load = dirname( __DIR__, 4 ) . '/wp-load.php';
if ( ! file_exists( $wp_load ) ) {
	fwrite( STDERR, "Could not find wp-load.php at {$wp_load}\n" );
	exit( 1 );
}

require $wp_load;

if ( ! function_exists( 'wp_insert_post' ) ) {
	fwrite( STDERR, "WordPress failed to load.\n" );
	exit( 1 );
}

echo "Activating theme...\n";
switch_theme( 'nutritionist_theme' );

update_option( 'blogname', 'Nutritionist' );
update_option( 'blogdescription', 'Personalized Nutrition Coaching' );
update_option( 'show_on_front', 'page' );

$pages = array(
	'home'    => 'Home',
	'about'   => 'About',
	'team'    => 'Team',
	'process' => 'Process',
	'pricing' => 'Pricing',
	'blog'    => 'Blog',
	'contact' => 'Contact',
);

$page_ids = array();

foreach ( $pages as $slug => $title ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		$page_ids[ $slug ] = (int) $existing->ID;
		echo "Page exists: {$title} (#{$existing->ID})\n";
		continue;
	}

	$id = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		),
		true
	);

	if ( is_wp_error( $id ) ) {
		fwrite( STDERR, "Failed to create {$title}: " . $id->get_error_message() . "\n" );
		continue;
	}

	$page_ids[ $slug ] = (int) $id;
	echo "Created page: {$title} (#{$id})\n";
}

if ( ! empty( $page_ids['home'] ) ) {
	update_option( 'page_on_front', $page_ids['home'] );
	echo "Set front page to Home (#{$page_ids['home']})\n";
}

// Keep posts page unset for now; Blog page uses page template later.
if ( ! empty( $page_ids['blog'] ) ) {
	// Optional: could set page_for_posts — leave empty so /blog/ is a normal page until Blog template is built.
	update_option( 'page_for_posts', 0 );
}

/**
 * Create or rebuild a nav menu.
 *
 * @param string $menu_name Menu name.
 * @param string $location  Theme location.
 * @param array  $items     Array of slug => label.
 * @param array  $page_ids  Created page IDs.
 */
function nutritionist_theme_setup_menu( $menu_name, $location, $items, $page_ids ) {
	$menu = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
		echo "Created menu: {$menu_name}\n";
	} else {
		$menu_id = (int) $menu->term_id;
		$existing_items = wp_get_nav_menu_items( $menu_id );
		if ( $existing_items ) {
			foreach ( $existing_items as $item ) {
				wp_delete_post( $item->ID, true );
			}
		}
		echo "Rebuilt menu: {$menu_name}\n";
	}

	$order = 1;
	foreach ( $items as $slug => $label ) {
		$args = array(
			'menu-item-title'  => $label,
			'menu-item-status' => 'publish',
			'menu-item-type'   => 'custom',
			'menu-item-url'    => ( 'home' === $slug ) ? home_url( '/' ) : home_url( '/' . $slug . '/' ),
			'menu-item-position' => $order,
		);

		if ( ! empty( $page_ids[ $slug ] ) && 'home' !== $slug ) {
			$args = array(
				'menu-item-title'     => $label,
				'menu-item-status'    => 'publish',
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $page_ids[ $slug ],
				'menu-item-position'  => $order,
			);
		}

		wp_update_nav_menu_item( $menu_id, 0, $args );
		++$order;
	}

	$locations              = get_theme_mod( 'nav_menu_locations', array() );
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

nutritionist_theme_setup_menu(
	'Primary Menu',
	'menu-1',
	array(
		'home'    => 'Home',
		'about'   => 'About',
		'team'    => 'Team',
		'process' => 'Process',
		'pricing' => 'Pricing',
		'blog'    => 'Blog',
	),
	$page_ids
);

nutritionist_theme_setup_menu(
	'Footer Menu',
	'footer',
	array(
		'home'    => 'Home',
		'about'   => 'About',
		'team'    => 'Team',
		'process' => 'Process',
		'pricing' => 'Pricing',
		'blog'    => 'Blog',
		'contact' => 'Contact',
	),
	$page_ids
);

flush_rewrite_rules();

echo "\nSetup complete.\n";
echo 'Site URL: ' . home_url( '/' ) . "\n";
echo "Front page template: front-page.php will load for Home.\n";
