 $(document).ready( function() {
qc.PaymentMethodView = qc.View.extend({
	initialize: function(e){
		this.template = e.template;
		qc.event.bind("update", this.update, this);
		this.model.on("change", this.render, this);
		this.render();
	},

	events: {
		'change input[type=radio]': 'updatePaymentMethod',
		'change select': 'updatePaymentMethod',
	},

	template: '',

	updatePaymentMethod: function(e){

		this.model.update($('#payment_method_form').serializeArray());
		this.model.update($('#shipping_method_form').serializeArray());
		if(parseInt(config.general.analytics_event)){
			ga('send', 'event', config.name, 'update', 'payment_method.'+e.currentTarget.value);
		}
		preloaderStart();
	},

	update: function(data){
		if(data.payment_method){
			this.model.set('payment_method', data.payment_method);

		}

		if(data.payment_methods){
			this.model.set('payment_methods', data.payment_methods);
		}

		if(data.account && data.account !== this.model.get('account')){
			this.changeAccount(data.account);
		}
	},

	render: function(){
		$(this.el).html(this.template({'model': this.model.toJSON()}));
		$('img').error(function(){
			$(this).hide();
		});

	},

});
 });