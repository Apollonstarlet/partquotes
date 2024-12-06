require('./bootstrap');

// create a new Choices object for each select element

$(() => {
	$('.choice-js').each(function () {
		new Choices(this, {
			searchEnabled: false
		});
	});

	$('.choice-js-search-disabled').each(function () {
		new Choices(this, {
			searchEnabled: false
		});
	});
});
