//*************************************************************************
//	Plugin Lasonde.fr 29/08/2010
//	Fichier JS TINYMCE
//	@-> contact@lasonde.fr
//*************************************************************************

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('LSD_plugin_tags');

	tinymce.create('tinymce.plugins.LSD_member_plugin', {
		init : function(ed, url) {
			var t = this;
			t.editor = ed;
			ed.addCommand('mce_LSD_plugin', t._mce_LSD_plugin, t);
			ed.addButton('LSD_plugin_tags',{
				title : 'LSD_plugin_tags.title', 
				cmd : 'mce_LSD_plugin',
				image : url + '/lasonde_icone.gif'
			});
		},
		getInfo : function() {
			return {
				longname : 'LSD_plugin_tags.description',
				author : 'Lasonde.fr',
				authorurl : 'http://www.lasonde.fr',
				infourl : 'http://www.lasonde.fr/',
				version : '1.2.3'
			};
		},
		// Private methods
		_mce_LSD_plugin : function() { //va ouvrir une pop up avec le choix du sondage
			var postnumber = document.getElementById('post_ID').value;
			var url  = tinyMCE.activeEditor.documentBaseURI + '../../../wp-content/plugins/sondages-lasonde/lasonde_sondages_tag.php';
			tb_show('Lasonde.fr Generator', url+'?width=300&height=400&TB_iframe=true&post='+postnumber , false);
			return true;
		}
		
	});
	// Register plugin
	tinymce.PluginManager.add('LSD_plugin_tags', tinymce.plugins.LSD_member_plugin);
})();