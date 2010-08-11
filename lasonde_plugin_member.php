<?php
/*******************************************************************************************
Plugin Name: Sondages-Lasonde
Version: 1.0.0.3
Plugin URI: http://www.lasonde.fr/plugin-sondages-lasonde-fr-pour-wordpress/
Description: Plugins Lasonde.fr pour ajouter des sondages facilement avec wordpress
Author: Hermann Alexandre
Author URI: http://www.lasonde.fr
*******************************************************************************************/

/*******************************************************************************************
Copyright 2010  Hermann Alexandre  (email : alexandre@lasonde.fr)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*******************************************************************************************/


if ( !defined('WP_CONTENT_DIR') )
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
    
if ( !defined('LSD_PAGE_MEMBER_OPTIONS') )
    define( 'LSD_PAGE_MEMBER_OPTIONS', 'lasonde-plugin-options');
    
if ( !defined('LSD_MEMBER_PLUGIN_IMAGES') )
    define( 'LSD_MEMBER_PLUGIN_IMAGES',  get_bloginfo('siteurl').'/wp-content/plugins/'.basename(dirname(__FILE__)).'/images/');

if ( !defined('LSD_MEMBER_PLUGIN_URL') )
    define( 'LSD_MEMBER_PLUGIN_URL',  get_bloginfo('siteurl').'/wp-content/plugins/'.basename(dirname(__FILE__)).'/');

if ( !defined('LSD_CORE') )
    define( 'LSD_CORE',  'http://www.lasonde.fr/wp-content/plugins/lasonde/LSD_core/');


/**********************************************************/
//function d'initialisation
/**********************************************************/
function LSD_plugin_member_init() {
  	//on ajoute le lien vers la page admin avec la fonction admin
  	$admin_page = add_menu_page(LSD_PAGE_MEMBER_OPTIONS, 'Sondages Lasonde.fr', 'administrator', LSD_PAGE_MEMBER_OPTIONS, 'Lasonde_plugin_options', LSD_MEMBER_PLUGIN_IMAGES.'lasonde_icone.gif');
}
add_action('admin_menu', 'LSD_plugin_member_init');
add_action('wp_print_scripts', 'LSD_register_js');

/**********************************************************/
//function style et js
/**********************************************************/
function LSD_register_js(){
	//le script des sondages
	wp_enqueue_script('lasonde_sondage_JS',LSD_CORE.'js/lasonde_sondages.js');
}

/**********************************************************/
//function Page d'admin options
/**********************************************************/
function Lasonde_plugin_options(){
//on sauvegarde les options
if($_POST['submit_lsd_option']){
	foreach($_POST as $post=>$value){
		update_option($post,$value);
	}
print '<div id="message" class="updated"><p>Options mises à jour!</p></div>';
}
?>
<div class="wrap">
<div style="float:right">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="QG7RJWETHLVZL">
			<input type="image" src="https://www.paypal.com/fr_FR/FR/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
			<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
		</form>
		</div>
	<h2><img src="<?php print LSD_MEMBER_PLUGIN_IMAGES; ?>lasonde-logo.png" alt="Lasonde.fr" /> plugin</h2>
	<?php
	if(get_option('lsd_user_api_secret')=='')
		print '<div id="message" class="error fade"><p>Pour récupérer vos sondages, il faut renseigner votre clé secrète lasonde.fr (disponible dans votre compte sur <a href="http://www.lasonde.fr/les-sondages/tableau-de-bord/" title="lasonde.fr">Lasonde.fr</a>)</p></div>';
	?>
	</p>
	<p>Vous pouvez ajouter des sondages de différentes manières:<br />
	- Dans vos articles et dans vos pages, soit via l'outil présent dans l'éditeur soit en ajoutant un code directement dans le texte.<br />
	exemple code manuel: <i><b>[lasonde sd_id="<span style="color:#FF0000">XXX</span>"]</b></i><br />

	- Directement dans vos templates en appellant la fonction "<i><b>LSD_print_script_tag(<span style='color:#FF0000'>XXX</span>);</b></i>"<br />
	 où <b>XXX</b> est l'identifiant du sondage fourni dans votre tableau de bord lasonde.fr
	</p>
	<form action="#" method="post">
		<table border="0">
		<tr>
			<th>Clé secrète Lasonde</th><td><input type="text" name="lsd_user_api_secret" value="<?php print get_option('lsd_user_api_secret'); ?>" /> <i>Cette clé est privée, vous pouvez l'obtenir sur <a href="http://www.lasonde.fr/les-sondages/tableau-de-bord/" title="lasonde.fr">Lasonde.fr</a></i></td>
		</tr>
		<tr>
			<th>Membre Premium</th><td><?php print LSD_member_is_premium($current_user->ID); ?></td>
		</tr>
		</table>
		<br />
		<input type="submit" name="submit_lsd_option" value="Enregistrer" />
	</form>
</div>



<?php } 




/**********************************************************/
//function Bouton laonde edit
/**********************************************************/
//on créer le bouton
function LSD_add_buttons_editor() {
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "add_LSD_member_plugins_tinymce_plugin");
     add_filter('mce_buttons', 'register_LSD_member_plugins_button');
   }
}
//on en registre le bouton
function register_LSD_member_plugins_button($buttons) {
   array_push($buttons, "separator", "LSD_plugin_tags");
   return $buttons;
}
 
//on charge la fonction du plugin en js
function add_LSD_member_plugins_tinymce_plugin($plugin_array) {
   $plugin_array['LSD_plugin_tags'] = LSD_MEMBER_PLUGIN_URL.'LSD_editor_plugin.js';
   return $plugin_array;
}
//on charge les boutons
add_action('init', 'LSD_add_buttons_editor');

function LSD_get_script_tag($sd_id){
	$tag = file_get_contents(LSD_CORE.'bdd-sondages.php?step=6&sd_id='.$sd_id.'&secret_key='.get_option('lsd_user_api_secret'));
	return $tag;
}
function LSD_member_is_premium($user_id){
	$tag = file_get_contents(LSD_CORE.'bdd-sondages.php?step=7&user_id='.$user_id.'&secret_key='.get_option('lsd_user_api_secret'));
	if($tag!='')
		return $tag;
}
function LSD_print_script_tag($sd_id){
	print LSD_get_script_tag($sd_id);
}
/**********************************************************/
// Création du short code!
/**********************************************************/
function LSD_script_tag($atts,$sd_id="") {
	extract(shortcode_atts(array('sd_id' => ''), $atts));
	$tag = LSD_get_script_tag($sd_id);
	return $tag;
}
add_shortcode('lasonde', 'LSD_script_tag');

?>