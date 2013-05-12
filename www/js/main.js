jQuery(function(){

	/*
	 * Confirm Question
	 */
	jQuery('[data-confirm-question]').click(function(){
		var $this = jQuery(this);
		var question = $this.data('confirm-question') || 'Really delete?';

		if (!confirm(question))
			return false;
	});

});