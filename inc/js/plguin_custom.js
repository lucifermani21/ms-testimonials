jQuery.validator.setDefaults({
	debug: false,
	errorele: 'span',
	errorClass: "error is-invalid",
	validClass: "valid is-valid",
	focusInvalid: true,
	errorPlacement: function (error, ele) {
		error.addClass('invalid-feedback');
		if (ele.parent().hasClass("input-group") || ele.parent().hasClass("form-check"))
			ele.parent().parent().append(error);
		else
			ele.parent().append(error);
	},
	highlight: function (ele, errorClass, validClass) {
		jQuery(ele).addClass(errorClass).removeClass(validClass);
		jQuery(ele).closest('.form-group').addClass('has-error');		
	},
	unhighlight: function (ele, errorClass, validClass) {
		jQuery(ele).addClass(validClass).removeClass(errorClass);
		jQuery(ele).closest('.form-group').removeClass('has-error');
	},
	ignore: jQuery.validator.defaults.ignore + ",:disabled,.note-editor *"
});
jQuery('.form-control').filter('[data-val-required]').closest(".form-group").find(".col-form-label").addClass("required");
jQuery("textarea.form-control").each(function () { jQuery(this).css("resize","none").val(jQuery(this).val().trim()); });