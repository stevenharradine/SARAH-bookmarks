require (['../../js/jquery-1.6.2.min'], function ($) {
	require({
		baseUrl: '../../js/'
	}, [
		"navigation",
		"add",
		"edit",
		"search"
	], function(
		nav,
		add,
		edit,
		search
	) {
		// do something page specific here
	});
});