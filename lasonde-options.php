<?php 
/************************************************************************/
//	Lasonde admin plugin 
//	admin/options.php
//
/************************************************************************/

print '
<script type="text/javascript">
jQuery(document).ready(function($){
	$(function() {
	
		$("#content_option").tabs({fx: { opacity: "toggle" }});
		jQuery("#form_options").validate({
			rules: {
    			input_demo_sondage_id : {required: true,number:true}
    		},
    		messages: {
    		    input_demo_sondage_id : "Ce Champs est obligatoire, 0 pour aucun affichage",

    		},
			submitHandler : function(form){
				submit_form("form_options","options","ajax_options_js",callback_maj_options); 
			}
		});
	});
});

//function qui fait le nécéssaire suite a l"ajax de creation de sondage
function callback_maj_options(data,text){
	jQuery("#message_ok").html(data);
	jQuery("#message_ok").dialog({
		show: "slide",
		close: function(event, ui){ 
			jQuery(this).dialog("destroy");
		},
		closeText: "Fermer",
		title: "Message",
		modal: true,
		buttons: {
			Ok: function() {
				jQuery(this).dialog("destroy");
			}
		},

	});
}
</script>';

/************************************************************************/
//	AFFICHAGE
/************************************************************************/
//header
print '<div class="wrap">';
print '
<br />
<table border=0>
<tr>
<td><img src="'.LASONDE_ADMIN_PLUGIN_IMAGES.'lasonde-logo.png" alt="icon" /> </td>
<td><h1>Options</h1></td></tr>
<tr><td colspan=2> '.get_loading_admin().'</td></tr>
</tr></table><br />';


print '<div id="message_ok"></div>';
print '<div id="message_error"></div>';


print '<form action="'.$_SERVER["PHP_SELF"].'" id="form_options" >';
print '<div id="content_option">

	<ul>
		<li><a href="#config_page_global">Configuration des pages</a></li>
		<li><a href="#config_page_paypal">Paiement Paypal</a></li>
	</ul>

';

/************************************************/
//	1ER BLOC
/************************************************/
print'<div id="config_page_global">';
	//on commence le form
	print '<table border="0" class="lsd_option_table">';
	
	//nom de la page de creation du sondage /id
	print '<tr><th>Page de création de sondages</th><td><select name="input_page_creation_sondage_id">';
		$pages = get_pages();
		foreach($pages as $page){
			print '<option value="'.$page->ID.'" '.((get_option('page_creation_sondage_id')==$page->ID?'selected="selected"':'')).'>'.$page->post_title.'</option>';
		}
	print '</select></td></tr>';
	
	//nom de la page de listing sondages / id
	print '<tr><th>Page de listing des sondages TABLEAU DE BORD</th><td><select name="input_page_list_sondage_id">';
		foreach($pages as $page){
			print '<option value="'.$page->ID.'" '.((get_option('page_list_sondage_id')==$page->ID?'selected="selected"':'')).'>'.$page->post_title.'</option>';
		}
	print '</select></td></tr>';
	
	//nom de la page de listing sondages
	print '<tr><th>Page de listing des Styles de sondages</th><td><select name="input_page_list_style_sondage">';
		foreach($pages as $page){
			print '<option value="'.$page->ID.'" '.((get_option('page_list_style_sondage')==$page->ID?'selected="selected"':'')).'>'.$page->post_title.'</option>';
		}
	print '</select></td></tr>';
	
	//nom de la page de creation des styles
	print '<tr><th>Page de création des Styles css</th><td><select name="input_page_crea_css">';
		foreach($pages as $page){
			print '<option value="'.$page->ID.'" '.((get_option('page_crea_css')==$page->ID?'selected="selected"':'')).'>'.$page->post_title.'</option>';
		}
	print '</select></td></tr>';
	
	
	//id du sondage de présentation
	print '<tr><th>ID du sondage de démonstration</th><td><input name="input_demo_sondage_id" size="4" type="text" value="'.get_option('demo_sondage_id').'" /></td></tr>';
	//Select de l'option de publication
	print '<tr><th>Autoriser la publication de sondages</th><td><input name="input_lsd_publication_sondages" type="radio" value="1" '.((get_option('lsd_publication_sondages')==1)?'checked="checked"':'').' /> Oui  <input name="input_lsd_publication_sondages" type="radio" value="0" '.((get_option('lsd_publication_sondages')!=1)?'checked="checked"':'').'/> Non</td></tr>';
	
	//Maintenance
	//permet de cacher ou pas le select de la page
	$txt_js_maintenance = 'onclick="if($(\'#input_lsd_maintenance\').attr(\'checked\')==true){$(\'#tr_page_maintenance\').show();}else{$(\'#tr_page_maintenance\').hide();}"';
	print '<tr><th>Site en maintenance</th><td '.$txt_js_maintenance.'><input name="input_lsd_maintenance" id="input_lsd_maintenance" type="radio" value="1" '.((get_option('lsd_maintenance')==1)?'checked="checked"':'').' /> Oui  <input name="input_lsd_maintenance" type="radio" value="0" '.((get_option('lsd_maintenance')!=1)?'checked="checked"':'').'/> Non</td></tr>';
	//nom de la page de maintenance
	print '<tr '.((get_option('lsd_maintenance')==1)?'':'style="display:none;"').' id="tr_page_maintenance"><th>Page de Maintenance</th><td><select name="input_lsd_page_maintenance">';
		foreach($pages as $page){
			print '<option value="'.$page->ID.'" '.((get_option('lsd_page_maintenance')==$page->ID?'selected="selected"':'')).'>'.$page->post_title.'</option>';
		}
	print '</select></td></tr>';
	
	
	
	//affichage du style du sondage par default
	print '<tr><th>Style du sondage par défaut</th><td><input name="input_lsd_defaut_style" size="4" type="text" value="'.get_option('lsd_defaut_style').'" /></td></tr>';
	
	
	print '</table>';
//on ferme le bloc
print '</div>';



	print'<div id="config_page_paypal">';
	print '<table border="0" class="lsd_option_table">';
	
	print '<tr><th>Activer Paypal Test</th><td><input name="input_lsd_sandbox_paypal_activ" type="radio" value="1" '.((get_option('lsd_sandbox_paypal_activ')==1)?'checked="checked"':'').' /> Oui  <input name="input_lsd_sandbox_paypal_activ" type="radio" value="0" '.((get_option('lsd_sandbox_paypal_activ')!=1)?'checked="checked"':'').'/> Non</td></tr>';
	
	//limit premium
	print '<tr><th>Limit du nombre de sondages</th><td><input name="input_lsd_premium_limit" size="4" type="text" value="'.get_option('lsd_premium_limit').'" /></td></tr>';
	
	
	//prix premium
	//print '<tr><th>Prix Premium</th><td><input name="input_lsd_premium_prix" size="10" type="text" value="'.get_option('lsd_premium_limit_prix').'" /> €</td></tr>';
	
	
	//page premium
	print '<tr><th>Page d’info PREMIUM</th><td><select name="input_lsd_premium_page">';
	foreach($pages as $page){
		print '<option value="'.$page->ID.'" '.((get_option('lsd_premium_page')==$page->ID?'selected="selected"':'')).'>'.$page->post_title.'</option>';
	}
	print '</select></td></tr>';
	
	
	//paiement
	print '<tr><th>Page d’acceptation du paiement / Refus </th><td><select name="input_lsd_paiement">';
	foreach($pages as $page){
		print '<option value="'.$page->ID.'" '.((get_option('lsd_paiement')==$page->ID?'selected="selected"':'')).'>'.$page->post_title.'</option>';
	}
	print '</select></td></tr>';
	
	//Adresse Email du paiement(PayPal)
	print '<tr><th>Adresse Email du paiement(PayPal)</th><td><input name="input_lsd_Email_paypal" type="text" value="'.get_option('lsd_Email_paypal').'" /></td></tr>';
	
	//option plugin shopping
	if(function_exists('show_wp_cart_options_page'))
		show_wp_cart_options_page();

print '</table>';

	
print '</div>';



//fin content
print '</div><br />';
print '<p align="right"><input id="submit_options" type="submit" type="text" value="Sauvegarder" class="ui-state-default" /></p>';

//on ferme le form
print '</form>';



//<div id="debug">AZDAZDAZ</div>


if(!function_exists('login_with_ajax'))
print '<span class="ui-state-error">Ce plugins est Compatible avec Ajax loading.</span><br />';


//footer
echo '</div>';


?>