(function ($) {
	$('[data-href]').click(function(e) {
		window.location.href = $(this).data('href');
	});
})(jQuery);
