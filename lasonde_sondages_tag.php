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
		window.parent.tb_remove();
	}
	return true;
}
</script>
</head>

<body id="Lasonde" style="margin-top:100px;">
	<div align="center" style="text-align:center;">
	    <img src="<?php print LSD_MEMBER_PLUGIN_IMAGES; ?>lasonde-logo.png" alt="Lasonde.fr" /><br />
        <form name="form_choix_lsd">
            <center><table style="text-align:center"><tr><th style="text-align:center"><?php _e('Choix du sondage à insérer','sondages-lasonde'); ?></th><td style="text-align:center"><?php print $form_list_sondage; ?></td></tr></table></center>
            <div class="mceActionPanel">
                <div style="margin: 8px auto; text-align: center; padding-bottom: 10px;">
                    <?php if(!ereg('avez pas de sondages',$form_list_sondage) && !ereg('You have no surveys',$form_list_sondage)){ ?>
                        <center><input type="button" id="insert" name="insert" value="<?php _e('Insérer','sondages-lasonde'); ?>" onclick="LSD_insert_code(this.form)" />
                    <?php } ?>
                    <input id="cancel" name="cancel" value="<?php _e('Fermer','sondages-lasonde'); ?>" title="Fermer" onclick="window.parent.tb_remove();" type="button" />
                </div>
            </div>
        </form>
	</div>
</body>
</html>
