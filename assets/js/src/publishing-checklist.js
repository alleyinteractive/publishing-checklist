(function($){

	var showButton = $('.misc-pub-section.publishing-checklist .publishing-checklist-show-list');
	var hideButton = $('.misc-pub-section.publishing-checklist .publishing-checklist-hide-list');
	var checklistItems = $('.misc-pub-section.publishing-checklist .publishing-checklist-items');

	showButton.on('click', function(){
		showButton.hide();
		checklistItems.show();
	});

	hideButton.on('click', function(){
		checklistItems.hide();
		showButton.show();
	});

}(jQuery));
