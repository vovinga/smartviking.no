 $(document).ready( function() {
qc.FieldView = qc.View.extend({
	initialize: function(e){
		this.template = e.template;
	},

	
	events: {
		'change input[type=text].not-required': 'updateField',
		'change input[type=text].required': 'validateField',
		'change input[type=email].not-required': 'updateField',
		'change input[type=email].required': 'validateField',
		'change input[type=password].not-required': 'updateField',
		'change input[type=password].required': 'validateField',
//		'change input[type=datetime].not-required': 'updateField',
//		'change input[type=datetime].required': 'validateField',
//		'change input[type=date].not-required': 'updateField',
//		'change input[type=date].required': 'validateField',
//		'change input[type=time].not-required': 'updateField',
//		'change input[type=time].required': 'validateField',
		'change input[type=radio].not-required': 'updateField',
		'change input[type=radio].required': 'validateField',
		'change input[type=checkbox].not-required': 'updateCheckbox',
		'change input[type=checkbox].required': 'validateCheckbox',
		'change textarea': 'validateField',
		'change select': 'validateField',

	},

	template: '',

	render: function(){
		this.setValidate();
		$(this.el).html(this.template({'model': this.model.toJSON() }));
		//this.setDateTime();
		$('.sort-item').tsort({attr:'data-sort'});
		$('.mask').each(function(){
			$(this).mask($(this).attr('data-mask'));
		})
		

	},

	
//	setDateTime: function(){
//		var that = this;
//		$('.date', this.el).datetimepicker({
//			pickTime: false
//		})
//
//		$('.time', this.el).datetimepicker({
//			pickDate: false
//		})
//
//		$('.datetime', this.el).datetimepicker({
//			pickDate: true,
//			pickTime: true
//		})
//	},

	setValidate: function(){
		$(this.el).validate({
			submitHandler: function(form) {
			},
			errorPlacement: function(error, element) {
				error.appendTo( element.parent());
			},
			highlight: function(element, errorClass, validClass) {
				$(element.form).find("#" + element.id + "_input")
					.addClass("has-error");
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element.form).find("#" + element.id + "_input")
					.removeClass("has-error");
			},

			errorClass: "text-danger",
			errorElement: "div"
		});
	},

	validateField: function(e){
		if($(e.currentTarget).valid()){
			this.updateField(e);
		}else{
			if(parseInt(config.general.analytics_event)){
				ga('send', 'event', config.name, 'error', e.currentTarget.name+'.'+e.currentTarget.value);
			}
			preloaderStop();
		}
		
	},

	updateField:function(e){
		this.model.updateField(e.currentTarget.name, e.currentTarget.value );
		if(parseInt(config.general.analytics_event)){
			ga('send', 'event', config.name, 'update', e.currentTarget.name);
		}
		preloaderStart();
	},

	validateCheckbox: function(e){
		if($(e.currentTarget).valid()){
			this.updateCheckbox(e);
		}else{
			if(parseInt(config.general.analytics_event)){
				ga('send', 'event', config.name, 'error', e.currentTarget.name+'.'+e.currentTarget.value);
			}
			preloaderStop();
		}

	},
	
	updateCheckbox: function(e){
		if($(e.currentTarget).is(":checked")){
			this.model.updateField(e.currentTarget.name, 1 );
		}else{
			this.model.updateField(e.currentTarget.name, 0 );
		}
		if(parseInt(config.general.analytics_event)){
			ga('send', 'event', config.name, 'update', e.currentTarget.name);
		}
		preloaderStart();
	},

});
 });