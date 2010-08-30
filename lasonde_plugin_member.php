<?php
/*******************************************************************************************
Plugin Name: Sondages-Lasonde
Version: 1.2
Plugin URI: http://www.lasonde.fr/plugin-sondages-lasonde-fr-pour-wordpress/
Description: Plugins Lasonde.fr pour ajouter des sondages facilement avec wordpress
Author: Lasonde.fr
Author URI: http://www.lasonde.fr/nous-contacter/
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

if ( !defined('LSD_PLUGIN_TITLE') )
    define( 'LSD_PLUGIN_TITLE', 'Sondages Lasonde.fr' );

class wp_LSD_sondages{

	function wp_LSD_sondages(){
		add_action('admin_menu', array(&$this,'LSD_plugin_member_init'));
		add_action('init', array(&$this,'LSD_add_buttons_editor'));
		add_shortcode('lasonde', array(&$this,'LSD_script_tag'));
		add_action('widgets_init', array(&$this,'LSD_register_widget'));
	}
	
	/**********************************************************/
	//function d'initialisation
	/**********************************************************/
	function LSD_plugin_member_init() {
		//on ajoute le lien vers la page admin avec la fonction admin
		$this->LSD_admin_hook = add_menu_page(LSD_PAGE_MEMBER_OPTIONS, LSD_PLUGIN_TITLE, 'administrator', LSD_PAGE_MEMBER_OPTIONS, array($this,Lasonde_plugin_options), LSD_MEMBER_PLUGIN_IMAGES.'lasonde_icone.gif');
		add_action('admin_print_scripts-'.$this->LSD_admin_hook, array(&$this,'LSD_admin_register_js'));
		add_action('wp_print_scripts', array(&$this,'LSD_register_js'));
	}
	//widget init
	function LSD_register_widget(){
		return register_widget("LSD_widget");
	}
	/**********************************************************/
	//function style et js
	/**********************************************************/
	function LSD_register_js(){
		//le script des sondages
		wp_enqueue_script('lasonde_sondage_JS',LSD_CORE.'js/lasonde_sondages.js');
	}
	function LSD_admin_register_js(){
		wp_enqueue_script('common');
		wp_enqueue_script('wp-lists');
		wp_enqueue_script('postbox');
	}
	function LSD_get_list_sondages($select_id){
		$form = file_get_contents(LSD_CORE.'bdd-sondages.php?step=5&select_id='.$select_id.'&secret_key='.get_option('lsd_user_api_secret'));
		return $form;
	}
	//creation page admin
	function Lasonde_plugin_options(){
		//on sauvegarde les options
		if($_POST['submit_lsd_option']){
			foreach($_POST as $post=>$value){
				update_option($post,$value);
			}
		print '<div id="message" class="updated"><p>Options mises à jour!</p></div>';
		}
		add_meta_box("LSD_options", 'Options', array(&$this,LSD_get_options_box), LSD_PAGE_MEMBER_OPTIONS, 'advanced',  'default');
		add_meta_box("LSD_Premium", 'Status Lasonde.fr', array(&$this,LSD_get_Premium_box), LSD_PAGE_MEMBER_OPTIONS, 'side',  'default');
		add_meta_box("LSD_info", 'Informations', array(&$this,LSD_get_info_box), LSD_PAGE_MEMBER_OPTIONS, 'side',  'default');
		add_meta_box("LSD_donation", 'FAITES UN DON', array(&$this,LSD_get_donation_box), LSD_PAGE_MEMBER_OPTIONS, 'side',  'default');
		?>
		<div class="wrap" id="LSD_wrap">
			<h2><img src="<?php print LSD_MEMBER_PLUGIN_IMAGES; ?>lasonde-logo.png" alt="Lasonde.fr" /> plugin</h2>
		<form action="#" method="post">
		<div id="poststuff" class="metabox-holder has-right-sidebar">
			<div id="side-info-column" class="inner-sidebar">
				<?php do_meta_boxes(LSD_PAGE_MEMBER_OPTIONS,'side',null); ?>
			</div>
			<div id="post-body" class="has-sidebar">
				<div id="post-body-content" class="has-sidebar-content">
					<?php do_meta_boxes(LSD_PAGE_MEMBER_OPTIONS,'advanced',null); ?>
			   </div>
			</div>
			<?php if(get_option('lsd_user_api_secret')=='')
				print '<div id="message" class="error fade"><p>Pour récupérer vos sondages, il faut renseigner votre clé secrète lasonde.fr (disponible dans votre compte sur <a href="http://www.lasonde.fr/les-sondages/tableau-de-bord/" title="lasonde.fr">Lasonde.fr</a>)</p></div>';
			?>
		</div>
		</form>
		</div>
	<?php } 
	
	//options
	function LSD_get_options_box(){ 
	   print'<h4>Vous pouvez ajouter des sondages de différentes manières:</h4>
		<p>- Dans vos articles et dans vos pages, soit via l\'outil présent dans l\'éditeur soit en ajoutant un code directement dans le texte.<br />
		exemple code manuel: <i><b>[lasonde sd_id="<span style="color:#FF0000">XXX</span>"]</b></i></p>
		<p>- Dans l\'editeur d\'apparence, en ajoutant des widgets Sondages-Lasonde à vos sidebars.</p>
		<p>- Directement dans vos templates en appellant la fonction "<i><b>LSD_print_script_tag(<span style="color:#FF0000">XXX</span>);</b></i>"
		 où <b>XXX</b> est l\'identifiant du sondage fourni dans votre tableau de bord lasonde.fr</p>
		</p>
			<table border="0">
			<tr>
				<th>Clé secrète Lasonde</th><td><input type="text" name="lsd_user_api_secret" value="'.get_option('lsd_user_api_secret').'" /> <i>Cette clé est privée, vous pouvez l\'obtenir sur <a href="http://www.lasonde.fr/les-sondages/tableau-de-bord/" title="lasonde.fr">Lasonde.fr / Tableau de bord</a></i></td>
			</tr>
			</table>
			<br />
			<p style="text-align:right;"><input type="submit" name="submit_lsd_option" value="Enregistrer" /></p>
		<br />';
		print '
		<script type="text/javascript">
			jQuery(document).ready( function($) {
			// close postboxes that should be closed
			jQuery(".if-js-closed").removeClass("if-js-closed").addClass("closed");
			postboxes.add_postbox_toggles("'.LSD_PAGE_MEMBER_OPTIONS.'"); //For WP2.7 and above
			});
		</script>';
	} 
	//dons
	function LSD_get_donation_box(){ 
		$html ='
			<div style="text-align:center;">
			<h4>Pour nous aider à supporter ce plugin :)</h4>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="QG7RJWETHLVZL">
				<input type="image" src="https://www.paypal.com/fr_FR/FR/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
				<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
			</form>
			</div>';
		print $html;
	} 
	//infos
	function LSD_get_info_box(){ 
		$html ='
			<div style="text-align:left;">
				<a style="text-decoration:none;" target="_blank" href="http://www.lasonde.fr/aide/" title="Aide"><img src="'.LSD_MEMBER_PLUGIN_IMAGES.'intero.png" alt="" /> Besoin d\'aide ?</a><br />
				<a style="text-decoration:none;" target="_blank" href="http://www.lasonde.fr/nous-contacter/" title="Nous contacter"><img src="'.LSD_MEMBER_PLUGIN_IMAGES.'mail.png" alt="" /> Nous contacter</a><br />
			</div>';
		print $html;
	} 
	function LSD_get_Premium_box(){
		$html = '
		<table border="0" width="100%">
			<tr><th valign="top" style="text-align:center;">Membre </th><td valign="top" style="text-align:center;">'.$this->LSD_member_is_premium().'</td></tr>';
			if($this->LSD_member_is_premium("bool")==0){
				$html .= '<tr><td colspan="2" style="text-align:center;"><h4><a style="color:#ff0000;" href="http://www.lasonde.fr/compte-premium/" title="Devenez Membre Premium" target="_blank">Devenez Membre premium pour profiter du service à 100%</a></h4></td></tr>
				<tr><td colspan="2">
					<b>Etre Membre Premium c\'est:</b><br /><br />
					- Nombre de sondages illimités<br />
					- Pas de publicité sur le site<br />
					- Pas de publicité sur les sondages<br /><br /><br />
					Pour <span style="color:#ff0000;">2,5€/an</span> ou <span style="color:#ff0000;">1 article</span> qui parle de nous 
					(<a href="http://www.lasonde.fr/compte-premium/" title="Devenez Membre Premium" target="_blank">en savoir plus</a>)
				</td></tr>
				';
			}
		$html .='</table>';
		print $html;
	}
	
	
	/**********************************************************/
	//function Bouton laonde edit
	/**********************************************************/
	//on créer le bouton
	function LSD_add_buttons_editor() {
	   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		 return;
	   if ( get_user_option('rich_editing') == 'true') {
		 add_filter("mce_external_plugins", array(&$this,"add_LSD_member_plugins_tinymce_plugin"));
		 add_filter('mce_buttons', array(&$this,'register_LSD_member_plugins_button'));
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
	
	function LSD_get_script_tag($sd_id){
		$tag = file_get_contents(LSD_CORE.'bdd-sondages.php?step=6&sd_id='.$sd_id.'&secret_key='.get_option('lsd_user_api_secret'));
		return $tag;
	}
	function LSD_member_is_premium($type="text"){
		$return = file_get_contents(LSD_CORE.'bdd-sondages.php?step=7&user_id='.$user_id.'&secret_key='.get_option('lsd_user_api_secret').'&type='.$type);
		if($return!='')
			return $return;
	}
	function LSD_print_script_tag($sd_id){
		print $this->LSD_get_script_tag($sd_id);
	}
	/**********************************************************/
	// Création du short code!
	/**********************************************************/
	function LSD_script_tag($atts,$sd_id="") {
		extract(shortcode_atts(array('sd_id' => ''), $atts));
		$tag = $this->LSD_get_script_tag($sd_id);
		return $tag;
	}


}




/**********************************************************/
// Création Widget
/**********************************************************/
class LSD_widget extends WP_Widget {
	function LSD_widget() {
		$LSD_widjet_info = array('description' => 'Ajouter des sondages' );
        parent::WP_Widget(false, LSD_PLUGIN_TITLE,$LSD_widjet_info);	
    }
	function form($instance) {
		$title = esc_attr($instance['title']);
		$list_sd_id = esc_attr($instance['list_sd_id']);
		$br = esc_attr($instance['br']);
		print '
		<p>
			<label for="'.$this->get_field_id('title').'">'._e('Title:').' 
			<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" />
			</label>
		</p>';
		
		print '
		<p>
			<label for="list_sd_id">'._e('Sondage à insérer:').LSD_get_list_sondages($this->get_field_name('list_sd_id')).'</label>
		</p>';
		print '
		<p>
			<label for="br">'._e('Saut de ligne avant le sondage ?').'<input type="radio" name="'.$this->get_field_name('br').'"  '.($br==1?'checked="checked"':'').' value="1"/> Oui <input type="radio" name="'.$this->get_field_name('br').'"  '.($br==0?'checked="checked"':'').' value="0"/> Non</label>
		</p>';
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['list_sd_id'] = $new_instance['list_sd_id'];
		$instance['br'] = $new_instance['br'];
        return $instance;
	}
	function widget($args, $instance) {
        extract( $args );
       	$title = apply_filters('widget_title', $instance['title']);
       	$br = $instance['br'];
       	print $before_widget;
       	if($title)
        	print $before_title . $title . $after_title; 
 		if($br==1)
 			print '<br />';
 		print  LSD_print_script_tag($instance['list_sd_id']);

        print $after_widget; 

    }

}

$wp_LSD_sondages = new wp_LSD_sondages();

//Permet de rendre compatible l'ancienne version de la fonction.
function LSD_print_script_tag($sd_id){
	global $wp_LSD_sondages;
	$wp_LSD_sondages->LSD_print_script_tag($sd_id);
}
function LSD_get_list_sondages($select_id){
	global $wp_LSD_sondages;
	return $wp_LSD_sondages->LSD_get_list_sondages($select_id);
}
?>