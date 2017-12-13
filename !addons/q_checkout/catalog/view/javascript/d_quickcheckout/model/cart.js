qc.Cart = qc.Model.extend({
	defaults: '',

	initialize: function(){
  console.log(this);
  console.log(config.account);
		this.set('config', config.account[this.get('account')].cart);
	},

	changeAccount: function(account){
		this.set('account', account);
		this.set('config', config.account[this.get('account')].cart);
	},

	updateQuantity: function(name, value){
		this.set(name, value);
		var that = this;
		$.post('index.php?route=d_quickcheckout/cart/update', this.toJSON(), function(data) {

			that.updateForm(data);
			 $('#cart-total').html(data['total']);
		}, 'json').error(
		);
	},

	updateVoucher: function(voucher){
		this.set('voucher', voucher);
		var that = this;
		$.post('index.php?route=d_quickcheckout/cart/updateVoucher', this.toJSON(), function(data) {

			that.updateForm(data);
			
		}, 'json').error(
		);
	},

	updateCoupon: function(coupon){
		this.set('coupon', coupon);
		var that = this;
		$.post('index.php?route=d_quickcheckout/cart/updateCoupon', this.toJSON(), function(data) {

			that.updateForm(data);
			
		}, 'json').error(
		);
	},

	updateReward: function(reward){
		this.set('reward', reward);
		var that = this;
		$.post('index.php?route=d_quickcheckout/cart/updateReward', this.toJSON(), function(data) {

			that.updateForm(data);
			
		}, 'json').error(
		);
	},

});
