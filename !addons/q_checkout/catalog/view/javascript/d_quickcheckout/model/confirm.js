qc.Confirm = qc.Model.extend({
	defaults: {
		'confirm': '',
		'config': '',
		'account': ''
	},


	initialize: function(){
		this.set('config', config.account[this.get('account')].confirm);
	},

	changeAccount: function(account){
		this.set('account', account);
		this.set('config', config.account[this.get('account')].confirm);
	},

	updateField: function(name, value){
		this.set(name, value);
		var json = this.toJSON();
		var that = this;
		$.post('index.php?route=d_quickcheckout/confirm/updateField', { 'confirm' : json.confirm }, function(data) {
			that.updateForm(data);

		}, 'json').error(
		);

	},

	update: function(){
		var that = this;
		$.post('index.php?route=d_quickcheckout/confirm/update', {}, function(data) {
			that.updateForm(data);
			qc.event.trigger('paymentConfirm');
		}, 'json').error(
		);
	}

});
