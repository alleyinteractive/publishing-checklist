<?php
/*
Plugin Name: Publishing Checklist
Version: 0.1-alpha
Description: PLUGIN DESCRIPTION HERE
Author: Fusion Engineering
Author URI: http://fusion.net/
Plugin URI: PLUGIN SITE HERE
Text Domain: publishing-checklist
Domain Path: /languages
*/

class Publishing_Checklist {

	private static $instance;
	private $tasks = array();

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Publishing_Checklist;
			self::$instance->setup_actions();
			do_action( 'publishing_checklist_init' );
		}
		return self::$instance;
	}

	/**
	 * Set up actions for the plugin
	 */
	private function setup_actions() {
		add_action( 'post_submitbox_misc_actions', array( $this, 'action_post_submitbox_misc_actions_render_checklist' ) );
	}

	/**
	 * Register a validation task for our publishing checklist
	 *
	 * @param string $id Unique identifier for the task (can be arbitrary, as long as it doesn't conflict with others)
	 * @param string $label Human-friendly label for the task
	 * @param mixed $callback Callable function or method to indicate whether or not the task has been complete
	 * @param string $explanation A longer description as to what needs to be accomplished for the task
	 */
	public function register_task( $id, $args = array() ) {

		$defaults = array(
			'label'          => $id,
			'callback'       => '__return_false',
			'explanation'    => '',
			);
		$args = array_merge( $defaults, $args );

		$this->tasks[ $id ] = $args;
	}

	/**
	 * Render the checklist in the publish submit box
	 */
	public function action_post_submitbox_misc_actions_render_checklist() {
		if ( empty( $this->tasks ) ) {
			return;
		}

		$completed_tasks = array();
		foreach( $this->tasks as $id => $task ) {
			if ( ! is_callable( $task['callback'] ) ) {
				unset( $this->tasks[ $id ] );
			}
			if ( call_user_func_array( $task['callback'], array( get_the_ID(), $id ) ) ) {
				$completed_tasks[] = $id;
			}
		}

		echo $this->get_template_part( 'post-submitbox-misc-actions', array( 'tasks' => $this->tasks, 'completed_tasks' => $completed_tasks ) );
	}

	/**
	 * Get a rendered template part
	 *
	 * @param string $template
	 * @param array $vars
	 * @return string
	 */
	private function get_template_part( $template, $vars = array() ) {
		$full_path = dirname( __FILE__ ) . '/templates/' . $template . '.php';

		if ( ! file_exists( $full_path ) ) {
			return '';
		}

		ob_start();
		// @codingStandardsIgnoreStart
		if ( ! empty( $vars ) ) {
			extract( $vars );
		}
		// @codingStandardsIgnoreEnd
		include $full_path;
		return ob_get_clean();
	}

}

/**
 * Load the plugin
 */
function Publishing_Checklist() {
	return Publishing_Checklist::get_instance();
}
add_action( 'init', 'Publishing_Checklist' );
