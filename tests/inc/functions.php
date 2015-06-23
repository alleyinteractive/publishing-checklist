<?php

function ensure_minimum_200_words( $post_id, $id ) {

	$obj = get_post( $post_id );

	if ( ! $obj ) {
		return false;
	}
	$word_count = str_word_count( strip_tags( $obj->post_content ) );

	return ( $word_count > 200 );
}
