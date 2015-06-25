<?php

class Test_Publishing_Checklist extends WP_UnitTestCase {

	private static $instance;

	private $long_test = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.

Maecenas nunc nisi, pulvinar dapibus sagittis non, accumsan id turpis.

Nulla facilisi. Cras fringilla eu neque vitae sagittis. Aliquam vulputate, metus ut euismod ultricies, nunc neque convallis justo, eu blandit urna felis a nulla. Maecenas consectetur odio magna, eget eleifend ex accumsan non. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Cras eget neque neque. Morbi ut vehicula eros, eu feugiat orci. Suspendisse sodales nec nisl nec finibus. Nunc porta euismod justo et pellentesque. Mauris convallis elit eget ligula elementum aliquam. Duis consequat lacus nec nulla maximus, ac pharetra dui interdum. Mauris et est ut enim auctor euismod non in urna. Sed ut sollicitudin elit. Pellentesque maximus nisl vel nulla tempus, feugiat venenatis lorem convallis.

Fusce tincidunt finibus mi vel porta. 

Fusce tincidunt finibus mi vel porta. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent at leo eu quam ullamcorper fermentum vel nec lorem. Praesent maximus aliquam felis. Suspendisse ac nisl velit. Aliquam non mattis magna, quis elementum elit. Etiam nulla augue, suscipit malesuada sollicitudin vitae, malesuada vitae risus. Sed diam eros, bibendum in condimentum ac, porta ullamcorper lorem. Praesent in dignissim ante, non auctor est. Quisque placerat.';

	private $columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'Title',
		'coauthors' => 'Authors',
		'comments' => '<span class="vers comment-grey-bubble" title="Comments"><span class="screen-reader-text">Comments</span></span>',
		'date' => 'Date',
	);

	function setUp() {
		parent::setUp();

		self::$instance = new Publishing_Checklist;
		$args = array(
			'label'           => esc_html__( 'Word Count', 'test-publishing-checklist' ),
			'callback'        => 'ensure_minimum_200_words',
			'explanation'     => esc_html__( 'Posts should be at least 200 words.', 'fusion' ),
			'post_type'       => array( 'post' ),
		);
		Publishing_Checklist()->register_task( 'test-publishing-checklist-word-count', $args );
	}

	public function test_incomplete_evaluate_checklist() {
		$post_id = $this->factory->post->create( array( 'post_content' => 'Way fewer than 200 words.' ) );
		$evaluated = Publishing_Checklist()->evaluate_checklist( $post_id );
		$this->assertContains( 'Word Count', $evaluated['tasks']['test-publishing-checklist-word-count']['label'] );
		$this->assertContains( 'Posts should be at least 200 words.', $evaluated['tasks']['test-publishing-checklist-word-count']['explanation'] );
		$this->assertEmpty( $evaluated['completed'] );
	}

	public function test_complete_evaluate_checklist() {
		$post_id = $this->factory->post->create(
			array(
				'post_content' => $this->long_test,
			)
		);
		$evaluated = Publishing_Checklist()->evaluate_checklist( $post_id );
		$this->assertContains( 'Word Count', $evaluated['tasks']['test-publishing-checklist-word-count']['label'] );
		$this->assertContains( 'Posts should be at least 200 words.', $evaluated['tasks']['test-publishing-checklist-word-count']['explanation'] );
		$this->assertContains( 'test-publishing-checklist-word-count', $evaluated['completed'] );
	}

	public function test_checklist_column_output_action() {
		$post_id = $this->factory->post->create(
			array(
				'post_content' => $this->long_test,
			)
		);
		ob_start();
		Publishing_Checklist()->action_manage_posts_custom_column( 'publishing_checklist', $post_id );
		$output = ob_get_clean();
		$this->assertContains( '1 of 1 tasks complete', $output );
	}

	public function test_checklist_column_addition() {
		$post_id = $this->factory->post->create(
			array(
				'post_content' => $this->long_test,
			)
		);
		$columns = Publishing_Checklist()->filter_manage_posts_columns( $this->columns );
		$this->assertTrue( 'Publishing Checklist' === $columns['publishing_checklist'] );
	}

}
