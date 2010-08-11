(function() {
	// Load plugin specific language pack	
	tinymce.create('tinymce.plugins.LSD_member_plugin', {
		init : function(ed, url) {
			var t = this;
			t.editor = ed;
			ed.addCommand('mce_LSD_plugin', t._mce_LSD_plugin, t);
			ed.addButton('LSD_plugin_tags',{
				title : 'Lasonde.fr - Ajouter un sondage', 
				cmd : 'mce_LSD_plugin',
				image : url + '/images/lasonde_icone.gif'
			});
		},
		getInfo : function() {
			return {
				longname : 'Lasonde.fr sondages création de tags',
				author : 'Lasonde.fr',
				authorurl : 'http://www.lasonde.fr',
				infourl : 'http://www.lasonde.fr/',
				version : '1.0'
			};
		},
		// Private methods
		_mce_LSD_plugin : function() { //va ouvrir une pop up avec le choix du sondage
			var postnumber = document.getElementById('post_ID').value;		
			tinyMCE.activeEditor.windowManager.open( {
				url : tinyMCE.activeEditor.documentBaseURI + '../../../wp-content/plugins/lasonde-sondages/lasonde_sondages_tag.php?post='+postnumber,
				width : 440,
				height : 220,
				resizable : 'no',
				scrollbars : 'no',
				inline : 'yes'
			}, { /* custom parameter space */ });
			return true;
		}
		
	});
	// Register plugin
	tinymce.PluginManager.add('LSD_plugin_tags', tinymce.plugins.LSD_member_plugin);
})();