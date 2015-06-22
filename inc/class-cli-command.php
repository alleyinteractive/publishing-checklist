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
		$checklist_data = Publishing_Checklist()->evaluate_checklist( $id );
		if ( empty( $checklist_data ) ) {
			WP_CLI::error( 'No checklist found.' );
		}
		WP_CLI::success( sprintf( __( '%d of %d tasks complete', 'publishing-checklist' ), count( $checklist_data['tasks'] ), count( $checklist_data['completed'] ) ) );
		foreach ( $checklist_data['tasks'] as $id => $task ) :
			if ( in_array( $id, $checklist_data['completed'] ) ) :
				WP_CLI::line( '+ ' .  $task['explanation'] );
			else :
				WP_CLI::line( '- ' .  $task['explanation'] );
			endif;
		endforeach;
	}
}

WP_CLI::add_command( 'checklist', 'CLI_Command' );
