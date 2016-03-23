<?php
/*
 * Plugin Name: Big Emoji Comments
 * Plugin URI:  https://github.com/georgestephanis/big-emoji-comments
 * Description: If someone leaves a comment comprised entirely of emoji, make it bigger.
 * Version:     1.0.0
 * Author:      George Stephanis
 * Author URI:  https://stephanis.info
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

add_filter( 'comment_text', 'big_emoji_comments' );
function big_emoji_comments( $content ) {
	$no_markup = trim( wp_kses( $content, array() ) );

	$all_emoji_regex = '/^[ '
		. '\x{1F600}-\x{1F64F}' // emoticons
		. '\x{1F300}-\x{1F5FF}' // miscellaneous symbols and pictographs
		. '\x{1F680}-\x{1F6FF}' // transport and map symbols
		. '\x{2600}-\x{26FF}'   // miscellaneous symbols
		. '\x{2700}-\x{27BF}'   // dingbats
		. ']+$/u';

	$percent = 200;
	switch ( mb_strlen( $no_markup ) ) {
		case 1 :
			$percent = 500;
			break;
		case 2 :
		case 3 :
		case 4 :
			$percent = 300;
	}

	if ( preg_match( $all_emoji_regex, $no_markup ) ) {
		return sprintf( '<span class="big-emoji" style="font-size:%1$d%%;">%2$s</span>', $percent, $content );
	}

	return $content;
}
