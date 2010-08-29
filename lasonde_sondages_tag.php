<?php
/*************************************************************************/
//	Plugin Lasonde.fr 29/08/2010
//	Fichier POP UP Choix de sondage.
//	@-> contact@lasonde.fr
/*************************************************************************/
if (!defined('ABSPATH')) include_once('./../../../wp-blog-header.php');
require_once(ABSPATH . '/wp-admin/admin.php');
$form_list_sondage = LSD_get_list_sondages('list_sd_id');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="embedded-video.js"></script>
	<title>Lasonde.fr Plugin</title>

<script type="text/javascript">
function LSD_insert_code(formObj){
	var sd_id = formObj.list_sd_id.value;
	var text = '[lasonde sd_id="'+ sd_id + '"]';
	if(window.tinyMCE) {
		var ed = tinyMCE.activeEditor;
		ed.execCommand('mceInsertContent', false,text);
		ed.execCommand('mceCleanup');
		tinyMCEPopup.close();
	}
	return true;
}
</script>
</head>

<body id="Lasonde">
	<center><img src="<?php print LSD_MEMBER_PLUGIN_IMAGES; ?>lasonde-logo.png" alt="Lasonde.fr" /><center><br />
	<form name="form_choix_lsd">
		<table><tr><th>Choix du sondage à insérer</th><td><?php print $form_list_sondage; ?></td></tr></table>
		<div class="mceActionPanel">
			<div style="margin: 8px auto; text-align: center; padding-bottom: 10px;">
				<?php if(!ereg('avez pas de sondages',$form_list_sondage)){ ?>
					<input type="button" id="cancel" name="insert" value="Insérer" onclick="LSD_insert_code(this.form)" />
				<?php } ?>
				<input id="cancel" name="cancel" value="Fermer" title="Fermer" onclick="tinyMCEPopup.close();" type="button" />
			</div>
		</div>
	</form>
</body>
</html>
