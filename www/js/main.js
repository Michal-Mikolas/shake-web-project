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


	/*
	 * CKEditor 
	 */
	if (jQuery.fn.ckeditor) {
		jQuery('textarea[name$=_html]').ckeditor({
			toolbarGroups: [
				{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
				{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
				{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
				//{ name: 'forms' },
				'/',
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
				{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
				{ name: 'links' },
				{ name: 'insert' },
				'/',
				{ name: 'styles' },  // style, format, font-family & font-size
				//{ name: 'colors' },
				{ name: 'tools' },
				{ name: 'others' },
				{ name: 'about' }
			],
			removeButtons: 'Font,FontSize,CreateDiv',
			allowedContent: true  // true - prevent CKEditor to clearing disallowed tags
		});		
	}


	/*
	 * TW Bootstrap Tabs
	 */
	$('a[data-toggle="tab"]').on('click', function (e) {
		//save the latest tab; use cookies if you like 'em better:
		localStorage.setItem('lastTab', $(e.target).attr('href'));
	});
	//go to the latest tab, if it exists:
	var lastTab = localStorage.getItem('lastTab');
	if (lastTab) {
		$('a[href="'+lastTab+'"]').click();
	}

	jQuery('html.js ul.nav-tabs, html.js .tab-content').show();
	/* --- End TW Bootstrap Tabs --- */

});