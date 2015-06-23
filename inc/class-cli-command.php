<?php

/**
* CLI interface to the Publishing Checklist.
 */
class Evaluate_Checklist_CLI_Command extends WP_CLI_Command {

	/**
	 * Evaluates publishing checklist for one or more posts.
	 *
	 * ## OPTIONS
	 *
	 * <id>...
	 * : The ID of one or more posts
	 *
	 * [--format=<format>]
	 * : Accepted values: table, json, csv. Default: table
	 *
	 * ## EXAMPLES
	 *
	 * 	wp checklist evaluate 1
	 *
	 */
	public function evaluate( $args = array(), $assoc_args = array() ) {
		$defaults = array(
			'format' => 'table',
		);
		$values = wp_parse_args( $assoc_args, $defaults );

		$fields = array(
			'task_id',
			'id',
			'status',
			'label',
			'explanation',
		);
		$cli_evaluation = array();
		$key = 0;
		foreach ( $args as $post_id ) {

			$checklist_data = Publishing_Checklist()->evaluate_checklist( $post_id );

			if ( empty( $checklist_data ) ) {
				WP_CLI::error( sprintf( __( 'No checklist found for %d.', 'publishing-checklist' ), $post_id ) );;
				break;
			}

			WP_CLI::success( sprintf( __( '%d of %d tasks complete for %d', 'publishing-checklist' ), count( $checklist_data['completed'] ), count( $checklist_data['tasks'] ), $post_id ) );

			foreach ( $checklist_data['tasks'] as $id => $task ) {
				if ( in_array( $id, $checklist_data['completed'] ) ) :
					$cli_evaluation[ $key ]['id'] = $post_id;
					$cli_evaluation[ $key ]['task_id'] = $id;
					$cli_evaluation[ $key ]['status'] = '+';
					$cli_evaluation[ $key ]['label'] = $task['label'];
					$cli_evaluation[ $key ]['explanation'] = $task['explanation'];
				else :
					$cli_evaluation[ $key ]['id'] = $post_id;
					$cli_evaluation[ $key ]['task_id'] = $id;
					$cli_evaluation[ $key ]['status'] = '-';
					$cli_evaluation[ $key ]['label'] = $task['label'];
					$cli_evaluation[ $key ]['explanation'] = $task['explanation'];
				endif;
				$key++;
			}
		}

		\WP_CLI\Utils\format_items( $values['format'], $cli_evaluation, $fields );

	}
}

WP_CLI::add_command( 'checklist', 'Evaluate_Checklist_CLI_Command' );
