(function($){

	$(document).on('click', '.publishing-checklist-show-list', function() {
		$( '.publishing-checklist-items', $(this).parent() ).show();
		$(this).hide();
		$( '.publishing-checklist-hide-list', $(this).parent() ).show();
	});

	$(document).on('click', '.publishing-checklist-hide-list', function() {
		$( '.publishing-checklist-items', $(this).parent() ).hide();
		$(this).hide();
		$( '.publishing-checklist-show-list', $(this).parent() ).show();
	});

}(jQuery));
