<?php
/**
 * Quick and dirty way to mostly minify CSS.
 *
 * @since 1.0.0
 * @author Gary Jones
 *
 * @param string $css CSS to minify
 * @return string Minified CSS
 */
function minify( $css ) {

	// Normalize whitespace
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove comment blocks, everything between /* and */, unless
	// preserved with /*! ... */
	$css = preg_replace( '/\/\*[^\!]([^\*]|[\s]|(\*([^\/]|[\s])))*\*\//', '', $css );
	
	// Remove ; before }
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } */ >
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

	// Remove space before , ; { } ( ) >
	$css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px)
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0)
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Converts all zeros value into short-hand
	$css = preg_replace( '/0 0 0 0/', '0', $css );

	// Shortern 6-character hex color codes to 3-character where possible
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );

}
