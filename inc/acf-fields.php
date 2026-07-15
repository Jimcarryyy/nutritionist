<?php
/**
 * Local ACF Free field groups for Nutritionist theme.
 *
 * @package nutritionist_theme
 */

/**
 * Register all field groups.
 */
function nutritionist_theme_register_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	nutritionist_theme_ensure_site_settings_page();

	// —— Site Settings ——
	$settings_id = nutritionist_theme_get_settings_page_id();
	acf_add_local_field_group(
		array(
			'key'                   => 'group_nt_site_settings',
			'title'                 => 'Site Settings',
			'fields'                => array(
				nutritionist_theme_acf_tab( 'tab_announce', 'Announcement' ),
				nutritionist_theme_acf_text( 'announcement_text', 'Announcement text' ),
				nutritionist_theme_acf_url( 'announcement_url', 'Announcement link (optional)' ),
				nutritionist_theme_acf_tab( 'tab_footer', 'Footer contact' ),
				nutritionist_theme_acf_text( 'footer_email', 'Email' ),
				nutritionist_theme_acf_text( 'footer_phone', 'Phone' ),
				nutritionist_theme_acf_text( 'footer_location', 'Location' ),
				nutritionist_theme_acf_tab( 'tab_social', 'Social & map' ),
				nutritionist_theme_acf_url( 'social_facebook', 'Facebook URL' ),
				nutritionist_theme_acf_url( 'social_twitter', 'Twitter / X URL' ),
				nutritionist_theme_acf_url( 'social_linkedin', 'LinkedIn URL' ),
				nutritionist_theme_acf_textarea(
					'map_embed_url',
					'Default Google Maps embed URL',
					array(
						'instructions' => 'Used when Contact page map URL is empty.',
						'rows'         => 2,
					)
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page',
						'operator' => '==',
						'value'    => (string) $settings_id,
					),
				),
			),
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);

	// —— Front Page ——
	$feature_fields = array(
		nutritionist_theme_acf_tab( 'home_tab_hero', 'Hero' ),
		nutritionist_theme_acf_text( 'home_hero_eyebrow', 'Eyebrow (supports plain text; heart added in template if empty style)' ),
		nutritionist_theme_acf_text( 'home_hero_title', 'Title' ),
		nutritionist_theme_acf_textarea( 'home_hero_text', 'Body text', array( 'rows' => 4 ) ),
		nutritionist_theme_acf_text( 'home_hero_cta_primary_label', 'Primary CTA label' ),
		nutritionist_theme_acf_url( 'home_hero_cta_primary_url', 'Primary CTA URL' ),
		nutritionist_theme_acf_text( 'home_hero_cta_secondary_label', 'Secondary CTA label' ),
		nutritionist_theme_acf_url( 'home_hero_cta_secondary_url', 'Secondary CTA URL' ),
		nutritionist_theme_acf_text( 'home_hero_customers', 'Customers line (e.g. 430+)' ),
		nutritionist_theme_acf_text( 'home_hero_customers_label', 'Customers label' ),
		nutritionist_theme_acf_image( 'home_hero_image', 'Hero image' ),
		nutritionist_theme_acf_tab( 'home_tab_features', 'Features' ),
		nutritionist_theme_acf_text( 'home_features_title', 'Section title' ),
		nutritionist_theme_acf_textarea( 'home_features_intro', 'Section intro' ),
	);
	for ( $i = 1; $i <= 6; $i++ ) {
		$feature_fields[] = nutritionist_theme_acf_group(
			'home_feature_' . $i,
			'Feature ' . $i,
			array(
				array( 'name' => 'icon', 'label' => 'Font Awesome icon class (e.g. fa-leaf)', 'type' => 'text' ),
				array( 'name' => 'title', 'label' => 'Title', 'type' => 'text' ),
				array( 'name' => 'text', 'label' => 'Text', 'type' => 'textarea' ),
			)
		);
	}
	$feature_fields[] = nutritionist_theme_acf_tab( 'home_tab_blogs', 'Blogs teaser' );
	$feature_fields[] = nutritionist_theme_acf_text( 'home_blogs_title', 'Section title' );
	$feature_fields[] = nutritionist_theme_acf_textarea( 'home_blogs_intro', 'Section intro' );
	for ( $i = 1; $i <= 4; $i++ ) {
		$feature_fields[] = nutritionist_theme_acf_group(
			'home_blog_' . $i,
			'Blog card ' . $i,
			array(
				array( 'name' => 'image', 'label' => 'Image', 'type' => 'image' ),
				array( 'name' => 'category', 'label' => 'Category', 'type' => 'text' ),
				array( 'name' => 'title', 'label' => 'Title', 'type' => 'text' ),
				array( 'name' => 'excerpt', 'label' => 'Excerpt', 'type' => 'textarea' ),
				array( 'name' => 'author', 'label' => 'Author', 'type' => 'text' ),
				array( 'name' => 'date', 'label' => 'Date', 'type' => 'text' ),
				array( 'name' => 'avatar', 'label' => 'Author avatar', 'type' => 'image' ),
				array( 'name' => 'link', 'label' => 'Link URL', 'type' => 'url' ),
			)
		);
	}
	$feature_fields[] = nutritionist_theme_acf_tab( 'home_tab_testimonials', 'Testimonials' );
	$feature_fields[] = nutritionist_theme_acf_text( 'home_testimonials_title', 'Section title' );
	$feature_fields[] = nutritionist_theme_acf_textarea( 'home_testimonials_intro', 'Section intro' );
	for ( $i = 1; $i <= 3; $i++ ) {
		$feature_fields[] = nutritionist_theme_acf_group(
			'home_testimonial_' . $i,
			'Testimonial ' . $i,
			array(
				array( 'name' => 'quote', 'label' => 'Quote', 'type' => 'textarea' ),
				array( 'name' => 'name', 'label' => 'Name', 'type' => 'text' ),
				array( 'name' => 'avatar', 'label' => 'Avatar', 'type' => 'image' ),
			)
		);
	}
	$feature_fields[] = nutritionist_theme_acf_tab( 'home_tab_pricing', 'Pricing teaser' );
	$feature_fields[] = nutritionist_theme_acf_text( 'home_pricing_title', 'Section title' );
	$feature_fields[] = nutritionist_theme_acf_textarea( 'home_pricing_intro', 'Section intro' );
	for ( $i = 1; $i <= 3; $i++ ) {
		$feature_fields[] = nutritionist_theme_acf_group(
			'home_plan_' . $i,
			'Plan ' . $i,
			array(
				array( 'name' => 'name', 'label' => 'Name', 'type' => 'text' ),
				array( 'name' => 'price', 'label' => 'Monthly price (number)', 'type' => 'text' ),
				array( 'name' => 'description', 'label' => 'Description', 'type' => 'textarea' ),
				array( 'name' => 'cta_label', 'label' => 'CTA label', 'type' => 'text' ),
				array( 'name' => 'cta_url', 'label' => 'CTA URL', 'type' => 'url' ),
			)
		);
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_nt_front_page',
			'title'    => 'Front Page Content',
			'fields'   => $feature_fields,
			'location' => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
			'active'   => true,
		)
	);

	// —— About ——
	$about_fields = array(
		nutritionist_theme_acf_tab( 'about_tab_hero', 'Hero' ),
		nutritionist_theme_acf_text( 'about_hero_title', 'Title' ),
		nutritionist_theme_acf_textarea( 'about_hero_p1', 'Paragraph 1' ),
		nutritionist_theme_acf_textarea( 'about_hero_p2', 'Paragraph 2' ),
		nutritionist_theme_acf_image( 'about_hero_grid', 'Hero grid image' ),
		nutritionist_theme_acf_tab( 'about_tab_story', 'Our Story' ),
		nutritionist_theme_acf_text( 'about_story_title', 'Section title' ),
		nutritionist_theme_acf_textarea( 'about_story_intro', 'Section intro' ),
	);
	for ( $i = 1; $i <= 10; $i++ ) {
		$about_fields[] = nutritionist_theme_acf_group(
			'about_story_' . $i,
			'Story ' . $i,
			array(
				array( 'name' => 'image', 'label' => 'Image', 'type' => 'image' ),
				array( 'name' => 'title', 'label' => 'Title', 'type' => 'text' ),
				array( 'name' => 'text', 'label' => 'Text', 'type' => 'textarea' ),
				array( 'name' => 'date', 'label' => 'Date', 'type' => 'text' ),
			)
		);
	}
	$about_fields[] = nutritionist_theme_acf_tab( 'about_tab_achieve', 'Achievements' );
	$about_fields[] = nutritionist_theme_acf_text( 'about_achieve_title', 'Section title' );
	$about_fields[] = nutritionist_theme_acf_textarea( 'about_achieve_intro', 'Section intro' );
	for ( $i = 1; $i <= 4; $i++ ) {
		$about_fields[] = nutritionist_theme_acf_group(
			'about_achieve_' . $i,
			'Achievement ' . $i,
			array(
				array( 'name' => 'icon', 'label' => 'Font Awesome icon class', 'type' => 'text' ),
				array( 'name' => 'title', 'label' => 'Title', 'type' => 'text' ),
				array( 'name' => 'text', 'label' => 'Text', 'type' => 'textarea' ),
			)
		);
	}
	$about_fields[] = nutritionist_theme_acf_tab( 'about_tab_cta', 'CTA' );
	$about_fields[] = nutritionist_theme_acf_text( 'about_cta_title', 'CTA title' );
	$about_fields[] = nutritionist_theme_acf_textarea( 'about_cta_text', 'CTA text' );
	$about_fields[] = nutritionist_theme_acf_text( 'about_cta_label', 'Button label' );
	$about_fields[] = nutritionist_theme_acf_url( 'about_cta_url', 'Button URL' );

	acf_add_local_field_group(
		array(
			'key'      => 'group_nt_about',
			'title'    => 'About Page',
			'fields'   => $about_fields,
			'location' => nutritionist_theme_acf_page_locations( 'about', 'page-about.php' ),
			'active'   => true,
		)
	);

	// —— Team ——
	$team_fields = array(
		nutritionist_theme_acf_tab( 'team_tab_hero', 'Hero' ),
		nutritionist_theme_acf_text( 'team_hero_title', 'Title' ),
		nutritionist_theme_acf_textarea( 'team_hero_text', 'Text' ),
	);
	$depts = array(
		'management'    => 'Management Team',
		'nutritionists' => 'Nutritionists and Dietitians',
		'support'       => 'Customer Support',
		'marketing'     => 'Marketing and Communications',
		'technology'    => 'Technology and Development',
	);
	foreach ( $depts as $slug => $label ) {
		$team_fields[] = nutritionist_theme_acf_tab( 'team_tab_' . $slug, $label );
		$team_fields[] = nutritionist_theme_acf_text( 'team_' . $slug . '_label', 'Tab label' );
		for ( $i = 1; $i <= 4; $i++ ) {
			$team_fields[] = nutritionist_theme_acf_group(
				'team_' . $slug . '_' . $i,
				'Member ' . $i,
				array(
					array( 'name' => 'image', 'label' => 'Photo', 'type' => 'image' ),
					array( 'name' => 'name', 'label' => 'Name', 'type' => 'text' ),
					array( 'name' => 'role', 'label' => 'Role', 'type' => 'text' ),
				)
			);
		}
	}
	$team_fields[] = nutritionist_theme_acf_tab( 'team_tab_cta', 'Join CTA' );
	$team_fields[] = nutritionist_theme_acf_text( 'team_cta_title', 'CTA title' );
	$team_fields[] = nutritionist_theme_acf_textarea( 'team_cta_text', 'CTA text' );
	$team_fields[] = nutritionist_theme_acf_text( 'team_cta_label', 'Button label' );
	$team_fields[] = nutritionist_theme_acf_url( 'team_cta_url', 'Button URL' );

	acf_add_local_field_group(
		array(
			'key'      => 'group_nt_team',
			'title'    => 'Team Page',
			'fields'   => $team_fields,
			'location' => nutritionist_theme_acf_page_locations( 'team', 'page-team.php' ),
			'active'   => true,
		)
	);

	// —— Process ——
	$process_fields = array(
		nutritionist_theme_acf_tab( 'process_tab_hero', 'Hero' ),
		nutritionist_theme_acf_text( 'process_hero_title', 'Title' ),
		nutritionist_theme_acf_textarea( 'process_hero_text', 'Text' ),
		nutritionist_theme_acf_tab( 'process_tab_steps', 'How It Works' ),
		nutritionist_theme_acf_text( 'process_steps_title', 'Section title' ),
		nutritionist_theme_acf_textarea( 'process_steps_intro', 'Section intro' ),
	);
	for ( $i = 1; $i <= 10; $i++ ) {
		$process_fields[] = nutritionist_theme_acf_group(
			'process_step_' . $i,
			'Step ' . $i,
			array(
				array( 'name' => 'icon', 'label' => 'Font Awesome icon class', 'type' => 'text' ),
				array( 'name' => 'title', 'label' => 'Title', 'type' => 'text' ),
				array( 'name' => 'text', 'label' => 'Text', 'type' => 'textarea' ),
			)
		);
	}
	$process_fields[] = nutritionist_theme_acf_tab( 'process_tab_cta', 'CTA' );
	$process_fields[] = nutritionist_theme_acf_text( 'process_cta_title', 'CTA title' );
	$process_fields[] = nutritionist_theme_acf_textarea( 'process_cta_text', 'CTA text' );
	$process_fields[] = nutritionist_theme_acf_text( 'process_cta_label', 'Button label' );
	$process_fields[] = nutritionist_theme_acf_url( 'process_cta_url', 'Button URL' );

	acf_add_local_field_group(
		array(
			'key'      => 'group_nt_process',
			'title'    => 'Process Page',
			'fields'   => $process_fields,
			'location' => nutritionist_theme_acf_page_locations( 'process', 'page-process.php' ),
			'active'   => true,
		)
	);

	// —— Pricing ——
	$pricing_fields = array(
		nutritionist_theme_acf_tab( 'pricing_tab_hero', 'Hero' ),
		nutritionist_theme_acf_text( 'pricing_hero_title', 'Title' ),
		nutritionist_theme_acf_textarea( 'pricing_hero_text', 'Text' ),
		nutritionist_theme_acf_tab( 'pricing_tab_plans', 'Plans' ),
	);
	for ( $i = 1; $i <= 3; $i++ ) {
		$pricing_fields[] = nutritionist_theme_acf_group(
			'pricing_plan_' . $i,
			'Plan ' . $i,
			array(
				array( 'name' => 'name', 'label' => 'Name', 'type' => 'text' ),
				array( 'name' => 'price', 'label' => 'Monthly price', 'type' => 'text' ),
				array( 'name' => 'yearly_price', 'label' => 'Yearly price (optional)', 'type' => 'text' ),
				array( 'name' => 'features', 'label' => 'Features (one per line)', 'type' => 'textarea', 'rows' => 6 ),
				array( 'name' => 'note', 'label' => 'Note (e.g. Ultimate)', 'type' => 'textarea' ),
			)
		);
	}
	$pricing_fields[] = nutritionist_theme_acf_tab( 'pricing_tab_compare', 'Comparison' );
	$pricing_fields[] = nutritionist_theme_acf_text( 'pricing_compare_title', 'Section title' );
	$pricing_fields[] = nutritionist_theme_acf_textarea( 'pricing_compare_intro', 'Section intro' );
	$pricing_fields[] = nutritionist_theme_acf_text( 'pricing_compare_headers', 'Headers (pipe-separated)', array( 'instructions' => 'e.g. Features|Basic Plan|Premium Plan|Ultimate Plan' ) );
	$pricing_fields[] = nutritionist_theme_acf_textarea(
		'pricing_compare_rows',
		'Rows (one per line)',
		array(
			'rows'         => 8,
			'instructions' => 'Format: Feature|✓|✓|—',
		)
	);
	$pricing_fields[] = nutritionist_theme_acf_tab( 'pricing_tab_faq', 'FAQ' );
	$pricing_fields[] = nutritionist_theme_acf_text( 'pricing_faq_title', 'Section title' );
	$pricing_fields[] = nutritionist_theme_acf_textarea( 'pricing_faq_intro', 'Section intro' );
	for ( $i = 1; $i <= 6; $i++ ) {
		$pricing_fields[] = nutritionist_theme_acf_group(
			'pricing_faq_' . $i,
			'FAQ ' . $i,
			array(
				array( 'name' => 'question', 'label' => 'Question', 'type' => 'text' ),
				array( 'name' => 'answer', 'label' => 'Answer', 'type' => 'textarea' ),
			)
		);
	}
	$pricing_fields[] = nutritionist_theme_acf_text( 'pricing_ask_title', 'Ask card title' );
	$pricing_fields[] = nutritionist_theme_acf_textarea( 'pricing_ask_text', 'Ask card text' );
	$pricing_fields[] = nutritionist_theme_acf_text( 'pricing_ask_label', 'Ask button label' );
	$pricing_fields[] = nutritionist_theme_acf_url( 'pricing_ask_url', 'Ask button URL' );

	acf_add_local_field_group(
		array(
			'key'      => 'group_nt_pricing',
			'title'    => 'Pricing Page',
			'fields'   => $pricing_fields,
			'location' => nutritionist_theme_acf_page_locations( 'pricing', 'page-pricing.php' ),
			'active'   => true,
		)
	);

	// —— Blog ——
	$blog_fields = array(
		nutritionist_theme_acf_tab( 'blog_tab_hero', 'Hero' ),
		nutritionist_theme_acf_text( 'blog_hero_title', 'Title' ),
		nutritionist_theme_acf_textarea( 'blog_hero_text', 'Text' ),
		nutritionist_theme_acf_tab( 'blog_tab_filter', 'Filters' ),
		nutritionist_theme_acf_text( 'blog_filter_all', 'All label' ),
		nutritionist_theme_acf_textarea(
			'blog_filter_categories',
			'Categories (one per line: Label|slug)',
			array(
				'rows'         => 6,
				'instructions' => 'Example: Weight Loss|weight-loss',
			)
		),
		nutritionist_theme_acf_tab( 'blog_tab_posts', 'Post cards' ),
	);
	for ( $i = 1; $i <= 12; $i++ ) {
		$blog_fields[] = nutritionist_theme_acf_group(
			'blog_post_' . $i,
			'Post ' . $i,
			array(
				array( 'name' => 'image', 'label' => 'Image', 'type' => 'image' ),
				array( 'name' => 'category', 'label' => 'Category slug', 'type' => 'text' ),
				array( 'name' => 'category_label', 'label' => 'Category label', 'type' => 'text' ),
				array( 'name' => 'title', 'label' => 'Title', 'type' => 'text' ),
				array( 'name' => 'excerpt', 'label' => 'Excerpt', 'type' => 'textarea' ),
			)
		);
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_nt_blog',
			'title'    => 'Blog Page',
			'fields'   => $blog_fields,
			'location' => nutritionist_theme_acf_page_locations( 'blog', 'page-blog.php' ),
			'active'   => true,
		)
	);

	// —— Contact ——
	acf_add_local_field_group(
		array(
			'key'      => 'group_nt_contact',
			'title'    => 'Contact Page',
			'fields'   => array(
				nutritionist_theme_acf_tab( 'contact_tab_hero', 'Hero' ),
				nutritionist_theme_acf_text( 'contact_hero_title', 'Title' ),
				nutritionist_theme_acf_textarea( 'contact_hero_text', 'Text' ),
				nutritionist_theme_acf_tab( 'contact_tab_info', 'Info bar' ),
				nutritionist_theme_acf_text( 'contact_email', 'Email' ),
				nutritionist_theme_acf_text( 'contact_phone', 'Phone' ),
				nutritionist_theme_acf_text( 'contact_location', 'Location' ),
				nutritionist_theme_acf_tab( 'contact_tab_form', 'Form & map' ),
				nutritionist_theme_acf_text( 'contact_form_title', 'Form title' ),
				nutritionist_theme_acf_textarea( 'contact_form_intro', 'Form intro' ),
				nutritionist_theme_acf_textarea( 'contact_map_embed', 'Map embed URL', array( 'rows' => 2 ) ),
				nutritionist_theme_acf_tab( 'contact_tab_social', 'Social & CTA' ),
				nutritionist_theme_acf_url( 'contact_social_facebook', 'Facebook URL' ),
				nutritionist_theme_acf_url( 'contact_social_twitter', 'Twitter / X URL' ),
				nutritionist_theme_acf_url( 'contact_social_linkedin', 'LinkedIn URL' ),
				nutritionist_theme_acf_text( 'contact_cta_title', 'CTA title' ),
				nutritionist_theme_acf_textarea( 'contact_cta_text', 'CTA text' ),
				nutritionist_theme_acf_text( 'contact_cta_label', 'Button label' ),
				nutritionist_theme_acf_url( 'contact_cta_url', 'Button URL' ),
			),
			'location' => nutritionist_theme_acf_page_locations( 'contact', 'page-contact.php' ),
			'active'   => true,
		)
	);
}
add_action( 'acf/init', 'nutritionist_theme_register_acf_fields' );
