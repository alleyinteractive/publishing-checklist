<ul>
	<?php foreach( $tasks as $task ) : ?>
		<li><?php echo esc_html( $task['label'] ); ?></li>
	<?php endforeach; ?>
</ul>
