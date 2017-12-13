<script type="text/javascript">
	var MOD_GIFTS_NUM = 0;
	
	function gifts_init() {
		var groups = {};
		var groups_curr = [];
		
		MOD_GIFTS_NUM = 0;

		$('input[type="checkbox"][name="gifts[]"]').each(function(){
			groups_curr.push( $(this).attr('data-gift-group-id') );
		});

		<?php if( ! empty( $mod_groups_info ) ) { ?>
			<?php foreach( $mod_groups_info as $group_id => $max ) { ?>
				groups[<?php echo $group_id; ?>] = <?php echo $max ? $max : '-1'; ?>;
			<?php } ?>
		<?php } ?>

		for( var i in groups ) {
			var has = false;

			for( var j = 0; j < groups_curr.length; j++ ) {
				if( groups_curr[j] == i ) {
					has = true;
					break;
				}
			}

			if( has )
				MOD_GIFTS_NUM += groups[i] == -1 ? -1 : ( groups[i] > 0 ? groups[i] : 0 );
		}

		$('#gifts-header').text('<?php echo $text_choose; ?> ' + ( MOD_GIFTS_NUM == -1 ? '' : MOD_GIFTS_NUM ) + ( MOD_GIFTS_NUM == -1 || MOD_GIFTS_NUM > 1 ? ' <?php echo $text_choose_gifts; ?>:' : ' <?php echo $text_choose_gift; ?>:' ) );
		
		if( MOD_GIFTS_NUM < 2 && MOD_GIFTS_NUM != -1 ) {
			$('input[type="checkbox"][name="gifts[]"]').each(function(){
				var _t = $(this),
					_r = $('<input>')
						.attr({
							'id'					: _t.attr('id'),
							'type'					: 'radio',
							'value'					: _t.val(),
							'name'					: _t.attr('name'),
							'data-gift-group-id'	: _t.attr('data-gift-group-id'),
							'style'					: _t.attr('style')
						});
						
				if( _t.is(':checked') )
					_r.attr('checked', true);
				
				_t.after( _r ).remove();
			});
		} else {		
			$('input[type="checkbox"][name="gifts[]"]').bind('change', function(){
				var g_id	= $(this).attr('data-gift-group-id');

				if( typeof groups[g_id] == 'undefined' || $(this).attr('type') != 'checkbox' ) return;

				var max		= parseInt( groups[g_id] );

				if( max < 1 ) return;

				var val		= $(this).val();
				var curr	= $('input[type="checkbox"][name="gifts[]"][value!="' + val + '"][data-gift-group-id="' + g_id + '"]:checked').length;

				if( $(this).is(':checked') )
					curr++;

				$('input[type="checkbox"][name="gifts[]"][data-gift-group-id="' + g_id + '"]').removeAttr('disabled');

				if( curr >= max ) {
					$('input[type="checkbox"][name="gifts[]"][data-gift-group-id="' + g_id + '"]:not(:checked)').attr('disabled','disabled').removeAttr('checked');
				}
			});

			$('input[type="checkbox"][name="gifts[]"]:checked:first').trigger('change');
		}
			
		<?php if( ! empty( $mod_gifts_settings['select_first_gift'] ) ) { ?>
			if( ! $('input[name="gifts[]"]:checked').length ) {
				$('input[name="gifts[]"]:first').attr('checked',true).trigger('change');
			}
		<?php } ?>
	}
	
	$().ready(function(){
		gifts_init();
	});
</script>