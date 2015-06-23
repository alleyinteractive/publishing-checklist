<?php

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

require_once $_tests_dir . '/includes/functions.php';

function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/publishing-checklist.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require $_tests_dir . '/includes/bootstrap.php';

function ensure_minimum_200_words( $post_id, $id ) {
	$obj = get_post( $post_id );
	if ( ! $obj ) {
		return false;
	}
	$word_count = str_word_count( strip_tags( $obj->post_content ) );

	return ( $word_count > 200 );
}
