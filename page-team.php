<?php
/**
 * Template Name: Team
 *
 * @package nutritionist_theme
 */

get_header();

$team_defaults = array(
	'management'    => array(
		'label'   => __( 'Management Team', 'nutritionist_theme' ),
		'members' => array(
			array( 'img' => 'team/member-1.png', 'name' => 'Sarah Mitchell', 'role' => __( 'Founder and CEO', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-2.png', 'name' => 'Emily Thompson', 'role' => __( 'Chief Operating Officer', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-3.png', 'name' => 'John Davis', 'role' => __( 'Chief Financial Officer', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-4.png', 'name' => 'Rachel Adams', 'role' => __( 'Chief Marketing Officer', 'nutritionist_theme' ) ),
		),
	),
	'nutritionists' => array(
		'label'   => __( 'Nutritionists and Dietitians', 'nutritionist_theme' ),
		'members' => array(
			array( 'img' => 'team/member-4.png', 'name' => 'Emily Walker', 'role' => __( 'Registered Dietitian', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-1.png', 'name' => 'Jessica Lee', 'role' => __( 'Clinical Nutritionist', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-2.png', 'name' => 'Michael Brown', 'role' => __( 'Sports Nutritionist', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-3.png', 'name' => 'Laura Brooks', 'role' => __( 'Wellness Dietitian', 'nutritionist_theme' ) ),
		),
	),
	'support'       => array(
		'label'   => __( 'Customer Support', 'nutritionist_theme' ),
		'members' => array(
			array( 'img' => 'team/member-2.png', 'name' => 'Olivia Green', 'role' => __( 'Support Lead', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-3.png', 'name' => 'Daniel Scott', 'role' => __( 'Client Success Manager', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-4.png', 'name' => 'Hannah White', 'role' => __( 'Support Specialist', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-1.png', 'name' => 'Ryan Cooper', 'role' => __( 'Community Manager', 'nutritionist_theme' ) ),
		),
	),
	'marketing'     => array(
		'label'   => __( 'Marketing and Communications', 'nutritionist_theme' ),
		'members' => array(
			array( 'img' => 'team/member-3.png', 'name' => 'Amanda Foster', 'role' => __( 'Brand Strategist', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-4.png', 'name' => 'Chris Bennett', 'role' => __( 'Content Lead', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-1.png', 'name' => 'Sophie Carter', 'role' => __( 'Social Media Manager', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-2.png', 'name' => 'Mark Allen', 'role' => __( 'Communications Manager', 'nutritionist_theme' ) ),
		),
	),
	'technology'    => array(
		'label'   => __( 'Technology and Development', 'nutritionist_theme' ),
		'members' => array(
			array( 'img' => 'team/member-1.png', 'name' => 'David Martinez', 'role' => __( 'Head of Product', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-2.png', 'name' => 'Natalie Kim', 'role' => __( 'Lead Engineer', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-3.png', 'name' => 'Alex Rivera', 'role' => __( 'UX Designer', 'nutritionist_theme' ) ),
			array( 'img' => 'team/member-4.png', 'name' => 'Priya Shah', 'role' => __( 'Mobile Developer', 'nutritionist_theme' ) ),
		),
	),
);

$teams = array();
foreach ( $team_defaults as $key => $dept ) {
	$label = nutritionist_theme_get_field( 'team_' . $key . '_label', $dept['label'] );
	$members = nutritionist_theme_collect_groups(
		'team_' . $key,
		4,
		static function ( $group, $i ) use ( $dept ) {
			$name = isset( $group['name'] ) ? trim( (string) $group['name'] ) : '';
			if ( '' === $name ) {
				return null;
			}
			$fallback = isset( $dept['members'][ $i - 1 ] ) ? $dept['members'][ $i - 1 ] : $dept['members'][0];
			return array(
				'img'  => ! empty( $group['image'] ) ? $group['image'] : $fallback['img'],
				'name' => $name,
				'role' => ! empty( $group['role'] ) ? $group['role'] : $fallback['role'],
			);
		},
		$dept['members']
	);
	$teams[ $key ] = array(
		'label'   => $label,
		'members' => $members,
	);
}

$hero_title = nutritionist_theme_get_field( 'team_hero_title', __( 'Meet Our Team of Experts', 'nutritionist_theme' ) );
$hero_text  = nutritionist_theme_get_field(
	'team_hero_text',
	__( 'Our team at Nutritionist is composed of highly skilled professionals who are passionate about helping you achieve your health and wellness goals. With a diverse range of backgrounds and expertise, our team members bring a wealth of knowledge and experience to every coaching relationship.', 'nutritionist_theme' )
);
$cta_title  = nutritionist_theme_get_field( 'team_cta_title', __( 'Join Our Team', 'nutritionist_theme' ) );
$cta_text   = nutritionist_theme_get_field(
	'team_cta_text',
	__( 'We are always on the lookout for talented individuals who are enthusiastic about making a difference. Explore our career opportunities and join us in our mission to help people achieve their health and wellness goals.', 'nutritionist_theme' )
);
$cta_label  = nutritionist_theme_get_field( 'team_cta_label', __( 'Apply Now', 'nutritionist_theme' ) );
$cta_url    = nutritionist_theme_get_field( 'team_cta_url', home_url( '/contact/' ) );
?>

	<main id="primary" class="site-main site-main--team">

		<section class="team-hero" id="team-hero" data-hero-enter>
			<div class="container">
				<div class="team-hero__panel" data-reveal>
					<img
						class="team-hero__badge"
						src="<?php echo esc_url( nutritionist_theme_image_url( 'team/team-badge.png' ) ); ?>"
						alt=""
						width="80"
						height="80"
					>
					<h1 class="team-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
					<p class="team-hero__text"><?php echo esc_html( $hero_text ); ?></p>
				</div>
			</div>
		</section>

		<section class="section section--team" id="our-team" data-team-page>
			<div class="container">
				<div class="team-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Team departments', 'nutritionist_theme' ); ?>">
					<?php
					$i = 0;
					foreach ( $teams as $key => $team ) :
						?>
						<button
							type="button"
							class="team-tabs__btn<?php echo 0 === $i ? ' is-active' : ''; ?>"
							role="tab"
							id="team-tab-<?php echo esc_attr( $key ); ?>"
							aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
							aria-controls="team-panel-<?php echo esc_attr( $key ); ?>"
							data-team-tab="<?php echo esc_attr( $key ); ?>"
						>
							<?php echo esc_html( $team['label'] ); ?>
						</button>
						<?php
						$i++;
					endforeach;
					?>
				</div>

				<?php
				$i = 0;
				foreach ( $teams as $key => $team ) :
					?>
					<div
						class="team-grid<?php echo 0 === $i ? ' is-active' : ''; ?>"
						role="tabpanel"
						id="team-panel-<?php echo esc_attr( $key ); ?>"
						aria-labelledby="team-tab-<?php echo esc_attr( $key ); ?>"
						data-team-panel="<?php echo esc_attr( $key ); ?>"
						data-reveal-stagger
						<?php echo 0 === $i ? '' : ' hidden'; ?>
					>
						<?php foreach ( $team['members'] as $member ) : ?>
							<article class="team-card" data-reveal>
								<div class="team-card__media">
									<img
										src="<?php echo esc_url( nutritionist_theme_media_src( $member['img'], is_string( $member['img'] ) ? $member['img'] : 'team/member-1.png' ) ); ?>"
										alt="<?php echo esc_attr( $member['name'] ); ?>"
										width="400"
										height="480"
										loading="lazy"
									>
								</div>
								<div class="team-card__meta">
									<h3 class="team-card__name"><?php echo esc_html( $member['name'] ); ?></h3>
									<p class="team-card__role"><?php echo esc_html( $member['role'] ); ?></p>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
					<?php
					$i++;
				endforeach;
				?>
			</div>
		</section>

		<section class="section section--team-cta" id="join-team">
			<div class="container">
				<div class="team-cta is-reveal--scale" data-reveal>
					<img class="team-cta__decor team-cta__decor--left" src="<?php echo esc_url( nutritionist_theme_image_url( 'team/cta-abstract-1.png' ) ); ?>" alt="" width="180" height="120" aria-hidden="true">
					<img class="team-cta__decor team-cta__decor--right" src="<?php echo esc_url( nutritionist_theme_image_url( 'team/cta-abstract-2.png' ) ); ?>" alt="" width="120" height="120" aria-hidden="true">
					<div class="team-cta__copy">
						<h2 class="team-cta__title"><?php echo esc_html( $cta_title ); ?></h2>
						<p class="team-cta__text"><?php echo esc_html( $cta_text ); ?></p>
					</div>
					<a class="btn btn--primary team-cta__btn" href="<?php echo esc_url( $cta_url ); ?>">
						<?php echo esc_html( $cta_label ); ?>
					</a>
				</div>
			</div>
		</section>

	</main>

<?php
get_footer();
