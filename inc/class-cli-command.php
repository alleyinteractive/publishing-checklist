<?php
use \WP_CLI\Utils;

/**
 * Based on: 
 */
class CLI_Command extends WP_CLI_Command {

	/**
	 * Returns editorial checklist for a given post.
	 *
	 * ## OPTIONS
	 *
	 * <id>...
	 * : The ID of one or more posts
	 *
	 * [--format=<format>]
	 * : Accepted values: table, json, csv. Default: table
	 * ## EXAMPLES
	 *
	 *     wp checklist evaluate 1
	 *
	 */
	public function evaluate( $args = array(), $assoc_args = array() ) {
		$defaults = array(
			'format' => 'table',
		);
		$values = wp_parse_args( $assoc_args, $defaults );

        $fields = array(
        	'status',
        	'label',
        	'explanation',
        );
		foreach( $args as $id ) {
			$checklist_data = Publishing_Checklist()->evaluate_checklist( $id );

			if ( empty( $checklist_data ) ) {
				WP_CLI::error( sprintf( __( 'No checklist found for %d.', 'publishing-checklist' ), $id ) );;
			}

			WP_CLI::success( sprintf( __( '%d of %d tasks complete for %d', 'publishing-checklist' ), count( $checklist_data['completed'] ), count( $checklist_data['tasks'] ), $id ) );

			$key = $id;
			$cli_evaluation = array();
			foreach ( $checklist_data['tasks'] as $id => $task ) :
				if ( in_array( $id, $checklist_data['completed'] ) ) :
					$cli_evaluation[ $key ][ 'status' ] = '+';
					$cli_evaluation[ $key ][ 'label' ] =  $task['label'];
					$cli_evaluation[ $key ][ 'explanation' ] =  $task['explanation'];
				else :
					$cli_evaluation[ $key ][ 'status' ] = '-';
					$cli_evaluation[ $key ][ 'label' ] =  $task['label'];
					$cli_evaluation[ $key ][ 'explanation' ] =  $task['explanation'];
				endif;
				$key++;
			endforeach;
    		\WP_CLI\Utils\format_items( $values['format'], $cli_evaluation, $fields );
		}

	}
}

WP_CLI::add_command( 'checklist', 'CLI_Command' );
