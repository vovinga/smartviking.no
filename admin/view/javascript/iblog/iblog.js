// CKEditor input focus fix
(function($) {
	$(document).ready(function($) {
		$(document).on('focusin', '.cke_dialog_ui_input_text', function(event) {
			event.stopImmediatePropagation();
			event.stopPropagation();
			
			if (!$(event.target).is(':focus')) {
				$(event.target).focus();
			}
		});		
	});
})(jQuery);

(function($) {
	$(document).ready(function($) {
		var ShowHideElements = [
			{'#DisqusChecker': ['#DisqusOptions']},
			{'#MainImageChecker': ['#MainImageOptions']},
			{'#LinkChecker': ['#MainLinkOptions']}
		];

		for (var i = ShowHideElements.length - 1; i >= 0; i -= 1) {
			if (typeof ShowHideElements[i] === "object") {
				var relative = ShowHideElements[i];

				for (var related in relative) {
					if (relative.hasOwnProperty(related)) {
						// Document Ready
						var show = ($(related).val() === 'yes') ? true : false;
						var toggle_els = relative[related].join(', ');
						if (show) { $(toggle_els).fadeIn(400); } else { $(toggle_els).hide(); }

						// Document Change
						$(document).on('change', related, function(event) {
							event.preventDefault();
							var show = ($(this).val() == 'yes') ? true : false;
							var selector = event.handleObj.selector;

							for (var j = ShowHideElements.length - 1; j >= 0; j -= 1) {
								if (typeof ShowHideElements[j][selector] !== "undefined") {
									var toggle_els = ShowHideElements[j][selector].join(', ');

									if (show) { $(toggle_els).fadeIn(400); } else { $(toggle_els).fadeOut(400); }
								}
							}
						});
					}
				}
			}
		};

		$('#mainTabs a:first').tab('show');

		$('#langtabs').children().last().children('a').click();

		if (window.localStorage && window.localStorage['currentTab']) {
			$('.mainMenuTabs a[href="' + window.localStorage['currentTab'] + '"]').tab('show');
		}
		
		if (window.localStorage && window.localStorage['currentSubTab']) {
			$('a[href="' + window.localStorage['currentSubTab'] + '"]').tab('show');
		}

		$('.fadeInOnLoad').css('visibility','visible');
		
		$(document).on('click', '.mainMenuTabs a[data-toggle="tab"]', function() {
			if (window.localStorage) {
				window.localStorage['currentTab'] = $(this).attr('href');
			}
		});

		$(document).on('click', 'a[data-toggle="tab"]:not(.mainMenuTabs a[data-toggle="tab"], .followup_tabs a[data-toggle="tab"])', function() {
			if (window.localStorage) {
				window.localStorage['currentSubTab'] = $(this).attr('href');
			}
		});

		$(document).on('click', '[data-toggle="tab"]', function (e) {
			e.preventDefault()
			$(this).tab('show')
		});

		$(document).on('click', '#addNewPost, .editPost', function(e){
			e.preventDefault();

			$('#addPostModalBody').load(encodeURI($(this).attr('href')));
			$('#addPostModal').modal();
		});

		$(document).on('click', '#addNewCategory, .editCategory', function(e){
			e.preventDefault();

			$('#addCategoryModalBody').load(encodeURI($(this).attr('href')));
			$('#addCategoryModal').modal();
		});

		$(document).on('click', '.remove_item', function(e){
			e.preventDefault();
			var r = confirm("Are you sure you want to remove this entry?");
			var id = $(this).attr('data-item-id');
			var url = $(this).attr('data-url');

			if (r == true && typeof id !== "undefined") {
				$.ajax({
					url: url,
					type: 'post',
					data: {
						'id': id
					},
					success: function(response) {
						location.reload();
					}
				});
			}
		});
	});
})(jQuery);