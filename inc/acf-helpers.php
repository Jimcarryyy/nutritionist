<?php
/**
 * ACF Free helpers for Nutritionist theme.
 *
 * @package nutritionist_theme
 */

/**
 * Ensure the Site Settings page exists; return its ID.
 *
 * @return int
 */
function nutritionist_theme_ensure_site_settings_page() {
	$cached = (int) get_option( 'nutritionist_theme_settings_page_id', 0 );
	if ( $cached && get_post( $cached ) ) {
		return $cached;
	}

	$page = get_page_by_path( 'site-settings' );
	if ( $page instanceof WP_Post ) {
		update_option( 'nutritionist_theme_settings_page_id', (int) $page->ID );
		return (int) $page->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => 'Site Settings',
			'post_name'    => 'site-settings',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '<!-- Nutritionist theme global settings. Do not delete. -->',
			'meta_input'   => array(
				'_wp_page_template' => 'default',
			),
		),
		true
	);

	if ( is_wp_error( $page_id ) || ! $page_id ) {
		return 0;
	}

	update_option( 'nutritionist_theme_settings_page_id', (int) $page_id );
	return (int) $page_id;
}
add_action( 'after_switch_theme', 'nutritionist_theme_ensure_site_settings_page' );
add_action( 'init', 'nutritionist_theme_ensure_site_settings_page', 5 );

/**
 * Site Settings page ID.
 *
 * @return int
 */
function nutritionist_theme_get_settings_page_id() {
	return nutritionist_theme_ensure_site_settings_page();
}

/**
 * Redirect Site Settings on the front end for non-editors.
 */
function nutritionist_theme_protect_settings_page() {
	if ( is_admin() || ! is_page( 'site-settings' ) ) {
		return;
	}
	if ( current_user_can( 'edit_pages' ) ) {
		return;
	}
	wp_safe_redirect( home_url( '/' ) );
	exit;
}
add_action( 'template_redirect', 'nutritionist_theme_protect_settings_page' );

/**
 * Get an ACF field with fallback. Empty strings/arrays/null use default.
 *
 * @param string $key     Field name.
 * @param mixed  $default Default value.
 * @param mixed  $post_id Post ID / 'option' / etc. Null = current.
 * @return mixed
 */
function nutritionist_theme_get_field( $key, $default = '', $post_id = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$value = null === $post_id ? get_field( $key ) : get_field( $key, $post_id );

	if ( null === $value || false === $value || '' === $value ) {
		return $default;
	}

	if ( is_array( $value ) && empty( $value ) ) {
		return $default;
	}

	return $value;
}

/**
 * Get a Site Settings field.
 *
 * @param string $key     Field name.
 * @param mixed  $default Default.
 * @return mixed
 */
function nutritionist_theme_get_setting( $key, $default = '' ) {
	$settings_id = nutritionist_theme_get_settings_page_id();
	if ( ! $settings_id ) {
		return $default;
	}
	return nutritionist_theme_get_field( $key, $default, $settings_id );
}

/**
 * Resolve theme-relative path, absolute URL, or ACF image to a src URL.
 *
 * @param mixed  $value         ACF image, URL, or relative path under assets/images/.
 * @param string $fallback_path Relative theme image path.
 * @return string
 */
function nutritionist_theme_media_src( $value, $fallback_path = '' ) {
	if ( is_array( $value ) || is_numeric( $value ) ) {
		return nutritionist_theme_acf_image_url( $value, $fallback_path );
	}
	if ( is_string( $value ) && '' !== $value ) {
		if ( 0 === strpos( $value, 'http' ) || 0 === strpos( $value, '//' ) ) {
			return $value;
		}
		return nutritionist_theme_image_url( $value );
	}
	return $fallback_path ? nutritionist_theme_image_url( $fallback_path ) : '';
}

/**
 * Resolve ACF image field (array/ID/URL) to URL string.
 *
 * @param mixed  $image   ACF image value.
 * @param string $default Default URL or relative theme image path.
 * @param string $size    Image size.
 * @return string
 */
function nutritionist_theme_acf_image_url( $image, $default = '', $size = 'full' ) {
	$url = '';

	if ( is_array( $image ) ) {
		if ( ! empty( $image['sizes'][ $size ] ) ) {
			$url = $image['sizes'][ $size ];
		} elseif ( ! empty( $image['url'] ) ) {
			$url = $image['url'];
		} elseif ( ! empty( $image['ID'] ) ) {
			$url = wp_get_attachment_image_url( (int) $image['ID'], $size );
		}
	} elseif ( is_numeric( $image ) ) {
		$url = wp_get_attachment_image_url( (int) $image, $size );
	} elseif ( is_string( $image ) && '' !== $image ) {
		$url = $image;
	}

	if ( $url ) {
		return $url;
	}

	if ( $default && 0 !== strpos( $default, 'http' ) && 0 !== strpos( $default, '//' ) ) {
		return nutritionist_theme_image_url( $default );
	}

	return $default;
}

/**
 * Split textarea lines into a clean string array.
 *
 * @param string $text Textarea value.
 * @return string[]
 */
function nutritionist_theme_lines_to_array( $text ) {
	if ( ! is_string( $text ) || '' === trim( $text ) ) {
		return array();
	}
	$lines = preg_split( '/\r\n|\r|\n/', $text );
	$out   = array();
	foreach ( $lines as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$out[] = $line;
		}
	}
	return $out;
}

/**
 * Parse comparison rows: Feature|Basic|Premium|Ultimate
 *
 * @param string $text Textarea.
 * @return array<int, array{label:string, cells:string[]}>
 */
function nutritionist_theme_parse_compare_rows( $text ) {
	$rows = array();
	foreach ( nutritionist_theme_lines_to_array( $text ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line ) );
		if ( count( $parts ) < 2 ) {
			continue;
		}
		$label = array_shift( $parts );
		$cells = array();
		foreach ( $parts as $cell ) {
			$normalized = strtolower( $cell );
			$yes         = in_array( $normalized, array( '1', 'true', 'yes', 'y', 'check', 'included' ), true )
				|| '✓' === $cell
				|| '✔' === $cell;
			$cells[] = $yes;
		}
		$rows[] = array_merge( array( $label ), $cells );
	}
	return $rows;
}

/**
 * Front page ID for home field reads.
 *
 * @return int
 */
function nutritionist_theme_get_front_page_id() {
	$page_id = (int) get_option( 'page_on_front' );
	return $page_id > 0 ? $page_id : 0;
}

/**
 * Collect numbered ACF group slots into a list; fallback if all empty.
 *
 * @param string   $prefix   Field key prefix without number (e.g. feature).
 * @param int      $count    Slot count.
 * @param callable $map      fn( array $group, int $i ): ?array — return null to skip.
 * @param array    $fallback Default list.
 * @param mixed    $post_id  Post ID.
 * @return array
 */
function nutritionist_theme_collect_groups( $prefix, $count, $map, $fallback = array(), $post_id = null ) {
	$items = array();
	for ( $i = 1; $i <= $count; $i++ ) {
		$group = nutritionist_theme_get_field( $prefix . '_' . $i, null, $post_id );
		if ( ! is_array( $group ) || empty( array_filter( $group ) ) ) {
			continue;
		}
		$mapped = call_user_func( $map, $group, $i );
		if ( null !== $mapped ) {
			$items[] = $mapped;
		}
	}
	return $items ? $items : $fallback;
}

/**
 * ACF location OR: page ID by slug and/or page template.
 *
 * @param string $slug     Page slug.
 * @param string $template Template file e.g. page-about.php.
 * @return array
 */
function nutritionist_theme_acf_page_locations( $slug, $template = '' ) {
	$locations = array();
	$page      = get_page_by_path( $slug );
	if ( $page instanceof WP_Post ) {
		$locations[] = array(
			array(
				'param'    => 'page',
				'operator' => '==',
				'value'    => (string) $page->ID,
			),
		);
	}
	if ( $template ) {
		$locations[] = array(
			array(
				'param'    => 'page_template',
				'operator' => '==',
				'value'    => $template,
			),
		);
	}
	if ( ! $locations ) {
		$locations[] = array(
			array(
				'param'    => 'page_template',
				'operator' => '==',
				'value'    => $template ? $template : 'default',
			),
		);
	}
	return $locations;
}

/**
 * Build a simple text field definition.
 *
 * @param string $key   Key.
 * @param string $label Label.
 * @param array  $args  Extra.
 * @return array
 */
function nutritionist_theme_acf_text( $key, $label, $args = array() ) {
	return array_merge(
		array(
			'key'   => 'field_nt_' . $key,
			'label' => $label,
			'name'  => $key,
			'type'  => 'text',
		),
		$args
	);
}

/**
 * Build a textarea field definition.
 *
 * @param string $key   Key.
 * @param string $label Label.
 * @param array  $args  Extra.
 * @return array
 */
function nutritionist_theme_acf_textarea( $key, $label, $args = array() ) {
	return array_merge(
		array(
			'key'   => 'field_nt_' . $key,
			'label' => $label,
			'name'  => $key,
			'type'  => 'textarea',
			'rows'  => 3,
		),
		$args
	);
}

/**
 * Build an image field definition.
 *
 * @param string $key   Key.
 * @param string $label Label.
 * @param array  $args  Extra.
 * @return array
 */
function nutritionist_theme_acf_image( $key, $label, $args = array() ) {
	return array_merge(
		array(
			'key'           => 'field_nt_' . $key,
			'label'         => $label,
			'name'          => $key,
			'type'          => 'image',
			'return_format' => 'array',
			'preview_size'  => 'medium',
			'library'       => 'all',
		),
		$args
	);
}

/**
 * Build a URL field definition.
 *
 * @param string $key   Key.
 * @param string $label Label.
 * @param array  $args  Extra.
 * @return array
 */
function nutritionist_theme_acf_url( $key, $label, $args = array() ) {
	return array_merge(
		array(
			'key'   => 'field_nt_' . $key,
			'label' => $label,
			'name'  => $key,
			'type'  => 'url',
		),
		$args
	);
}

/**
 * Build a tab field.
 *
 * @param string $key   Key.
 * @param string $label Label.
 * @return array
 */
function nutritionist_theme_acf_tab( $key, $label ) {
	return array(
		'key'   => 'field_nt_' . $key,
		'label' => $label,
		'name'  => '',
		'type'  => 'tab',
		'placement' => 'top',
	);
}

/**
 * Build a group field with sub fields.
 *
 * @param string $key   Key.
 * @param string $label Label.
 * @param array  $subs  Sub fields (name/label/type...).
 * @return array
 */
function nutritionist_theme_acf_group( $key, $label, $subs ) {
	$sub_fields = array();
	foreach ( $subs as $sub ) {
		$name = $sub['name'];
		$type = isset( $sub['type'] ) ? $sub['type'] : 'text';
		$def  = array(
			'key'   => 'field_nt_' . $key . '_' . $name,
			'label' => $sub['label'],
			'name'  => $name,
			'type'  => $type,
		);
		if ( 'image' === $type ) {
			$def['return_format'] = 'array';
			$def['preview_size']  = 'medium';
		}
		if ( 'textarea' === $type ) {
			$def['rows'] = isset( $sub['rows'] ) ? $sub['rows'] : 3;
		}
		if ( isset( $sub['instructions'] ) ) {
			$def['instructions'] = $sub['instructions'];
		}
		$sub_fields[] = $def;
	}

	return array(
		'key'        => 'field_nt_' . $key,
		'label'      => $label,
		'name'       => $key,
		'type'       => 'group',
		'layout'     => 'block',
		'sub_fields' => $sub_fields,
	);
}
