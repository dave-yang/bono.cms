
$(function() {
	
	$.wysiwyg.init(['faq[answer]']);
	$.setFormGroup('faq');
	
	
	function update(callback){
		$("form").send({
			url : "/admin/module/faq/edit.ajax",
			success : callback
		});
	}
	
	
	function add(callback){
		$("form").send({
			url : "/admin/module/faq/add.ajax",
			success : callback
		});
	}
	
	
	
	$("[data-button='save']").click(function(event) {
		update(function(response) {
			if (response == "1") {
				window.location.reload();
			} else {
				$.showErrors(response);
			}
		});
	});
	
	
	$("[data-button='save-create']").click(function(event) {
		update(function(response) {
			if (response == "1") {
				window.location = '/admin/module/faq/add';
			} else {
				$.showErrors(response);
			}
		});
	});
	
	
	$("[data-button='add']").click(function(event) {
		add(function(response) {
			if ($.isNumeric(response)) {
				window.location = '/admin/module/faq/edit/' + response;
			} else {
				$.showErrors(response);
			}
		});
	});
	
	
	$("[data-button='add-create']").click(function(event) {
		add(function(response) {
			if ($.isNumeric(response)) {
				window.location.reload();
			} else {
				$.showErrors(response);
			}
		});
	});
	
	$("[data-button='cancel']").click(function(event){
		event.preventDefault();
		window.location = '/admin/module/faq';
	});
	
});
