<div class="misc-pub-section publishing-checklist">
	<h4><?php esc_html_e( 'Publishing Checklist', 'publishing-checklist' ); ?></h4>

	<div class="publishing-checklist-items-complete">
		<?php echo esc_html( sprintf( __( '%d of %d tasks complete', 'publishing-checklist' ), count( $completed_tasks ), count( $tasks ) ) ); ?>
	</div>

	<ul>
		<?php foreach( $tasks as $task ) : ?>
			<li><?php echo esc_html( $task['label'] ); ?></li>
		<?php endforeach; ?>
	</ul>
</div>
