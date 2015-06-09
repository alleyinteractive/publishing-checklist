<div class="misc-pub-section publishing-checklist">
	<h4><?php esc_html_e( 'Publishing Checklist', 'publishing-checklist' ); ?></h4>

	<div class="publishing-checklist-items-complete">
		<?php echo esc_html( sprintf( __( '%d of %d tasks complete', 'publishing-checklist' ), count( $completed_tasks ), count( $tasks ) ) ); ?>
		<progress value="<?php echo (int) count( $completed_tasks ); ?>" max="<?php echo (int) count( $tasks ); ?>"></progress>
		<a href="javascript:void(0);" class="publishing-checklist-show-list"><?php esc_html_e( 'Show List', 'publishing-checklist' ); ?></a>
	</div>

	<div class="publishing-checklist-items" style="display:none;">
		<ul>
			<?php foreach( $tasks as $task ) : ?>
				<li><?php echo esc_html( $task['label'] ); ?></li>
			<?php endforeach; ?>
		</ul>
		<a href="javascript:void(0);" class="publishing-checklist-hide-list"><?php esc_html_e( 'Hide List', 'publishing-checklist' ); ?></a>
	</div>
</div>
