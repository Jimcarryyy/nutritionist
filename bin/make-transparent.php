<?php
/**
 * Convert near-black PNG backgrounds to transparency.
 *
 * @package nutritionist_theme
 */

$base = dirname( __DIR__ ) . '/assets/images/';

/**
 * Make near-black pixels transparent.
 *
 * @param string $src  Source path.
 * @param string $dest Destination path.
 */
function nutritionist_theme_make_transparent( $src, $dest ) {
	$im = imagecreatefrompng( $src );
	if ( ! $im ) {
		echo "fail read $src\n";
		return;
	}
	imagesavealpha( $im, true );
	$w   = imagesx( $im );
	$h   = imagesy( $im );
	$out = imagecreatetruecolor( $w, $h );
	imagesavealpha( $out, true );
	$transparent = imagecolorallocatealpha( $out, 0, 0, 0, 127 );
	imagefill( $out, 0, 0, $transparent );

	for ( $y = 0; $y < $h; $y++ ) {
		for ( $x = 0; $x < $w; $x++ ) {
			$rgb = imagecolorat( $im, $x, $y );
			$a   = ( $rgb & 0x7F000000 ) >> 24;
			$r   = ( $rgb >> 16 ) & 0xFF;
			$g   = ( $rgb >> 8 ) & 0xFF;
			$b   = $rgb & 0xFF;

			if ( $r < 30 && $g < 30 && $b < 30 ) {
				imagesetpixel( $out, $x, $y, $transparent );
			} else {
				$col = imagecolorallocatealpha( $out, $r, $g, $b, 0 );
				imagesetpixel( $out, $x, $y, $col );
			}
		}
	}

	imagepng( $out, $dest );
	imagedestroy( $im );
	imagedestroy( $out );
	echo "ok $dest\n";
}

$files = array(
	'logo-mark.png',
	'logo-mark-sm.png',
	'abstract-scribble.png',
	'abstract-scribble-alt.png',
);

foreach ( $files as $file ) {
	nutritionist_theme_make_transparent( $base . $file, $base . $file );
}
