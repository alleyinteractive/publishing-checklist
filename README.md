# Publishing Checklist #
**Contributors:** fusionengineering, danielbachhuber, davisshaver    
**Tags:** editorial, checklist, publishing, preflight  
**Requires at least:** 4.2    
**Tested up to:** 4.2    
**Stable tag:** 0.0.0  
**License:** GPLv2 or later    
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html    

Publishing Checklist is a developer tool for adding pre-flight editorial checklists to WordPress posts.

## Description##

Each time a user saves a post, Publishing Checklist validates that post type's list of tasks to make sure the content is ready for release. Tasks are validated with callbacks you supply when registering tasks.

## Installation  ##
It's a plugin! Install it like any other. 

Once you've done so, you'll need to register the checklist items and callbacks for your site. Here's a simple example that checks for a featured image.

### integrations/class-publishing-checklist.php ###
```php
class Publishing_Checklist {

	private static $instance;

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Publishing_Checklist;
			self::$instance->setup_actions();
		}
		return self::$instance;
	}

	private function setup_actions() {

		add_action( 'publishing_checklist_init', array( $this, 'action_publishing_checklist_init' ) );

	}

	/**
	 * Initialize our Publishing Checklist rules
	 */
	public function action_publishing_checklist_init() {
		$post_types = array( 'post' );
		$args = array(
			'label'           => esc_html__( 'Featured Image', 'demo_publishing_checklist' ),
			'callback'        => array( $this, 'validate_demo_checklist_task' ),
			'explanation'     => esc_html__( 'A featured image is required.', 'demo_publishing_checklist' ),
			'post_type'       => $post_types,
			);
		Publishing_Checklist()->register_task( 'demo-featured-image', $args );
	}

	/**
	 * Validate a given checklist task
	 */
	public function validate_demo_checklist_task( $post_id, $id ) {
		switch ( $id ) {
			case 'demo-featured-image':
				return has_post_thumbnail( $post_id );
		}
	}

}
```
### functions.php or similar ###
```php
require_once dirname( __FILE__ ) . '/integrations/class-publishing-checklist.php';
Publishing_Checklist::get_instance(); 

```
## Frequently Asked Questions ##
### Where will the checklist appear? ###

On Manage and Edit post screens.

### Does the plugin come with any default checklists? ###

Not yet.


## Screenshots ##

### 1. Checklist summaries will be displayed within a column on the Manage post screen. ###
![Checklist summaries will be displayed within a column on the Manage post screen.](http://s.wordpress.org/extend/plugins/publishing-checklist/screenshot-1.png)


### 2. Checklists will also be displayed within the Publish metabox on the Edit screen. ###
![Checklists will also be displayed within the Publish metabox on the Edit screen.](http://s.wordpress.org/extend/plugins/publishing-checklist/screenshot-2.png)


## Changelog ##

### 0.1.0 (????) ###

* Initial release.
