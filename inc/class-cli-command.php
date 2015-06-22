<?php

/**
 * Helper methods for both migration components
 */
class CLI_Command extends WP_CLI_Command {

	/**
	 * Returns editorial checklist for a given post.
	 *
	 * ## OPTIONS
	 *
	 * <id>
	 * : The id of the post
	 *
	 * ## EXAMPLES
	 *
	 *     wp checklist evaluate 1
	 *
	 * @synopsis <id>
	 */
	function evaluate( $args = array(), $assoc_args = array() ) {
		list( $id ) = $args;

		// Print a success message
		WP_CLI::success( "Evaluated $id" );
	}
}

WP_CLI::add_command( 'checklist', 'CLI_Command' );
