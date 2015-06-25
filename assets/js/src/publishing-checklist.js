(function($){

	$('.publishing-checklist-show-list').on('click', function() {
		$( '.publishing-checklist-items', $(this).parent() ).show();
		$(this).hide();
		$( '.publishing-checklist-hide-list', $(this).parent() ).show();
	});

	$('.publishing-checklist-hide-list').on('click', function() {
		$( '.publishing-checklist-items', $(this).parent() ).hide();
		$(this).hide();
		$( '.publishing-checklist-show-list', $(this).parent() ).show();
	});

}(jQuery));
