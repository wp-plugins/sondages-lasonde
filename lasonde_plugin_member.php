<?php
/*******************************************************************************************
Plugin Name: Sondages-Lasonde
Version: 1.3
Plugin URI: http://www.lasonde.fr/plugin-sondages-lasonde-fr-pour-wordpress/
Description: Plugins Lasonde.fr pour ajouter des sondages facilement avec wordpress
Author: Lasonde.fr
Author URI: http://www.lasonde.fr/nous-contacter/
Text Domain: sondages-lasonde
Domain Path: /langs
*******************************************************************************************/


/*******************************************************************************************
	
	Lasonde.fr is a service to put survey on your website.
    Copyright (C) 2011  Hermann Alexandre

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
*******************************************************************************************/


/*
 * Definition langues 
 */
$domain_core = "en";
if (defined('WPLANG'))
	if(WPLANG == "fr_FR")
		$domain_core = "www";
	elseif(WPLANG== "en_US" OR WPLANG== "en_GB")
		$domain_core = "en";
	

if ( !defined('WP_CONTENT_DIR') )
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
    
if ( !defined('LSD_PAGE_MEMBER_OPTIONS') )
    define( 'LSD_PAGE_MEMBER_OPTIONS', 'lasonde_plugin_options');
    
if ( !defined('LSD_MEMBER_PLUGIN_IMAGES') )
    define( 'LSD_MEMBER_PLUGIN_IMAGES',  get_bloginfo('siteurl').'/wp-content/plugins/'.basename(dirname(__FILE__)).'/images/');

if ( !defined('LSD_MEMBER_PLUGIN_URL') )
    define( 'LSD_MEMBER_PLUGIN_URL',  get_bloginfo('siteurl').'/wp-content/plugins/'.basename(dirname(__FILE__)).'/');

if ( !defined('LSD_CORE') )
    define( 'LSD_CORE',  'http://'.$domain_core.'.lasonde.fr/wp-content/plugins/lasonde/LSD_core/');

if ( !defined('LSD_DEFAULT_TIMEOUT_CURL_FILE_GC') )
    define( 'LSD_DEFAULT_TIMEOUT_CURL_FILE_GC',  2);


class wp_LSD_sondages{
	/*
	 * Global
	 */
	function wp_LSD_sondages(){
		add_action('admin_menu', array(&$this,'LSD_plugin_member_init'));
		add_action('init', array(&$this,'LSD_add_buttons_editor'));
		add_shortcode('lasonde', array(&$this,'LSD_script_tag'));
		add_action('widgets_init', array(&$this,'LSD_register_widget'));
		add_action('wp_print_scripts', array(&$this,'LSD_register_js'));
		load_plugin_textdomain( 'sondages-lasonde', false, dirname(plugin_basename(__FILE__ )) . '/langs' );
		if ( !defined('LSD_PLUGIN_TITLE') )
    		define( 'LSD_PLUGIN_TITLE', __('Sondages Lasonde.fr','sondages-lasonde') );
    	
    	//options
    	$lsd_request_timeout = get_option('lsd_request_timeout');
		$this->lsd_request_timeout = empty($lsd_request_timeout) ? LSD_DEFAULT_TIMEOUT_CURL_FILE_GC : $lsd_request_timeout;
	}
	
	/*
	 * plugin init
	 */
	function LSD_plugin_member_init() {
		//on ajoute le lien vers la page admin avec la fonction admin
		$this->LSD_admin_hook = add_menu_page(LSD_PAGE_MEMBER_OPTIONS, LSD_PLUGIN_TITLE, 'administrator', LSD_PAGE_MEMBER_OPTIONS, array($this,Lasonde_plugin_options), LSD_MEMBER_PLUGIN_IMAGES.'lasonde_icone.gif');
		add_action('load-'.$this->LSD_admin_hook, array(&$this,'LSD_admin_register_js'));
	}
	/*
	 * widget init
	 */
	function LSD_register_widget(){
		return register_widget("LSD_widget");
	}
 	/*
	 * otions des metabox colonnes etc...
	 */
	function LSD_screen_layout($columns, $screen) {
		if ($screen == LSD_PAGE_MEMBER_OPTIONS) {
			$columns[LSD_PAGE_MEMBER_OPTIONS] = 2;
		}
		return $columns;
	}
	/*
	 * on enregistre les js
	 */
	function LSD_register_js(){
		//le script des sondages chez google code.
		wp_enqueue_script('lasonde_sondage_JS','http://lasonde-javascript-hosting.googlecode.com/svn/trunk/lasonde_sondages_min.js');
	}
	/*
	 * on charge les JS et metabox
	 */
	function LSD_admin_register_js(){
		wp_enqueue_script('common');
		wp_enqueue_script('wp-list');
		wp_enqueue_script('postbox');
	    wp_enqueue_script('lasonde_sondage_JS',LSD_CORE.'js/lasonde_sondages_min.js');
		add_meta_box("LSD_options", 'Options', array(&$this,LSD_get_options_box),  $this->LSD_admin_hook , 'normal', 'core');
		add_meta_box("LSD_Premium", __('Statut','sondages-lasonde').' Lasonde.fr', array(&$this,LSD_get_Premium_box),  $this->LSD_admin_hook , 'side', 'core');
		add_meta_box("LSD_info", 'Informations', array(&$this,LSD_get_info_box),  $this->LSD_admin_hook , 'side', 'core');
		add_meta_box("LSD_donation", __('FAITES UN DON','sondages-lasonde'), array(&$this,LSD_get_donation_box),  $this->LSD_admin_hook , 'side', 'core');
		add_meta_box("LSD_rate", __('Notez ce plugin!','sondages-lasonde'), array(&$this,LSD_get_rate_box),  $this->LSD_admin_hook , 'normal', 'core');
	}
	/*
	 * on liste les sondages
	 */
	function LSD_get_list_sondages($select_id){
		$form = $this->LSD_curl_get_file_contents(LSD_CORE.'bdd-sondages.php?step=5&select_id='.$select_id.'&secret_key='.get_option('lsd_user_api_secret'));
		return $form;
	}
	/*
	 * admin page hook
	 */	
	function Lasonde_plugin_options(){
		 add_filter('screen_layout_columns', array(&$this, 'LSD_screen_layout'), 10, 2);

		//on sauvegarde les options
		if($_POST['submit_lsd_option']){
			$this->lsd_request_timeout =  $_POST['lsd_request_timeout'];
			foreach($_POST as $post=>$value){
				update_option($post,$value);
			}
		print '<div id="message" class="updated"><p>'.__('Options mises à jour!','sondages-lasonde').'</p></div>';
		}
		?>
		<div class="wrap" id="LSD_wrap">
			<h2><img src="<?php print LSD_MEMBER_PLUGIN_IMAGES; ?>lasonde-logo.png" alt="Lasonde.fr" /></h2>
		<form action="#" method="post">
		<div id="poststuff" class="metabox-holder has-right-sidebar">
			<div id="side-info-column" class="inner-sidebar">
				<?php do_meta_boxes($this->LSD_admin_hook,'side',null); ?>
			</div>
			<div id="post-body" class="has-sidebar">
				<div id="post-body-content" class="has-sidebar-content">
					<?php do_meta_boxes($this->LSD_admin_hook,'normal',null); ?>
			   </div>
			</div>
			<?php if(get_option('lsd_user_api_secret')=='')
				print '<div id="message" class="error fade"><p>'.sprintf(__('Pour récupérer vos sondages, il faut renseigner votre clé secrète lasonde.fr (disponible dans votre compte sur %1$s)','sondages-lasonde'),'<a href="http://www.lasonde.fr/les-sondages/tableau-de-bord/" title="lasonde.fr">Lasonde.fr</a>').'</p></div>';
			?>
		</div>
		</form>
		<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// close postboxes that should be closed
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			// postboxes setup
			postboxes.add_postbox_toggles('<?php echo $this->LSD_admin_hook; ?>');
		});
		//]]>
	</script>
		</div>
	<?php } 
	
	/*
	 * box options 
	 */
	function LSD_get_options_box(){ 
		
	   print '<h4>'.__('Vous pouvez ajouter des sondages de différentes manières:','sondages-lasonde').'</h4>
		<p>'.__('- Dans vos articles et dans vos pages, soit via l\'outil présent dans l\'éditeur soit en ajoutant un code directement dans le texte.','sondages-lasonde').'<br />
		'.__('exemple code manuel:','sondages-lasonde').'<i><b>[lasonde sd_id="<span style="color:#FF0000">XXX</span>"]</b></i></p>
		<p>'.__('- Dans l\'editeur d\'apparence, en ajoutant des widgets Sondages-Lasonde à vos sidebars.','sondages-lasonde').'</p>
		<p>'.sprintf(__('- Directement dans vos templates en appellant la fonction %s','sondages-lasonde'),'"<i><b>LSD_print_script_tag(<span style="color:#FF0000">XXX</span>);</b></i>"').' '.sprintf(__('où %s est l\'identifiant du sondage fourni dans votre tableau de bord lasonde.fr','sondages-lasonde'),'<b>XXX</b>').'</p>
		
		<p>
			<label style="display:block;font-weight:bold;" for="lsd_request_timeout">'.__('Time Out','sondages-lasonde').'</label>
			<input type="text" name="lsd_request_timeout" value="'.$this->lsd_request_timeout.'" />
			<br /><i style="font-size:0.8em;">'.__("Durée maximale de la tentative d'établissement de la connexion vers l'hôte distant (en secondes). Une valeur nulle aura pour effet de laisser cette tâche au système.",'sondages-lasonde').'</i>
		</p>
		<p>
			<label style="display:block;font-weight:bold;" for="lsd_user_api_secret">'.__('Clé secrète Lasonde','sondages-lasonde').'</label>
			<input type="text" name="lsd_user_api_secret" value="'.get_option('lsd_user_api_secret').'" />
			<br /><i style="font-size:0.8em;">'.sprintf(__('Cette clé est privée, vous pouvez l\'obtenir sur %1$s Lasonde.fr / Tableau de bord %2$s','sondages-lasonde'),'<a href="'.__('http://www.lasonde.fr/les-sondages/tableau-de-bord/','sondages-lasonde').'" title="lasonde.fr">','</a>').'</a></i>
		</p>
		<p style="text-align:right;"><input type="submit" name="submit_lsd_option" value="'.__('Enregistrer','sondages-lasonde').'" /></p>
		<br />';
		
	} 
	/*
	 * box dons
	 */
	function LSD_get_donation_box(){ 
		$html ='
			<div style="text-align:center;">
			<h4>'.__('Pour nous aider à supporter ce plugin :)','sondages-lasonde').'</h4>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="QG7RJWETHLVZL">
				<input type="image" src="https://www.paypal.com/'.__('fr_FR/FR','sondages-lasonde').'/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="'.__('PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !','sondages-lasonde').'">
				<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
			</form>
			</div><br />';
		$sd_id_rate = 93;
		$html.= '<div align="center">'.$this->LSD_get_script_tag($sd_id_rate).'</div>';
		print $html;
	} 
	/*
	 * box votes
	 */
	function LSD_get_rate_box(){ 
		$html ='
			<div style="text-align:center;">
			<span style="font-size:20px;"><a href="http://wordpress.org/extend/plugins/sondages-lasonde/" title="'.__('Votez Sondages-Lasonde','sondages-lasonde').'" target="_blank">'.__('Si vous aimez ce plugin, dites le!','sondages-lasonde').'<br /><br />'.__('Noter ce plugin','sondages-lasonde').'</a></b></span>
			</div>';
		print $html;
	} 
	/*
	 * box info
	 */	function LSD_get_info_box(){ 
		$html ='
			<div style="text-align:left;">
				<a style="text-decoration:none;" target="_blank" href="http://www.lasonde.fr/aide/" title="Aide"><img src="'.LSD_MEMBER_PLUGIN_IMAGES.'intero.png" alt="" style="vertical-align:middle;"/> '.__('Besoin d\'aide ?','sondages-lasonde').'</a><br />
				<a style="text-decoration:none;" target="_blank" href="http://www.lasonde.fr/nous-contacter/" title="Nous contacter"><img src="'.LSD_MEMBER_PLUGIN_IMAGES.'mail.png" alt="" style="vertical-align:middle;"/> '.__('Nous contacter','sondages-lasonde').'</a><br />
			</div>';
		print $html;
	} 
	/*
	 * la box de l'admin
	 */
	function LSD_get_Premium_box(){
		$html ='
		<table border="0" width="100%">
			<tr><th valign="top" style="text-align:center;">'.__('Membre','sondages-lasonde').' </th><td valign="top" style="text-align:center;">'.$this->LSD_member_is_premium().'</td></tr>';
			if($this->LSD_member_is_premium("bool")==0){
				$html .= '<tr><td colspan="2" style="text-align:center;"><h4><a style="color:#ff0000;" href="http://www.lasonde.fr/compte-premium/" title="'.__('Devenez Membre Premium','sondages-lasonde').'" target="_blank">'.__('Devenez Membre premium pour profiter du service à 100%','sondages-lasonde').'</a></h4></td></tr>
				<tr><td colspan="2">
					<b>'.__('Etre Membre Premium c\'est:','sondages-lasonde').'</b><br /><br />
					'.__('- Nombre de sondages illimités','sondages-lasonde').'<br />
					'.__('- Pas de publicité sur le site','sondages-lasonde').'<br />
					'.__('- Pas de publicité sur les sondages','sondages-lasonde').'<br /><br /><br />
					'.sprintf(__('Pour %1$s ou %2$s qui parle de nous (%3$s en savoir plus %4$s)','sondages-lasonde'),
						'<span style="color:#ff0000;">5‚Ç¨/'.__('an','sondages-lasonde').'</span>',
						'<span style="color:#ff0000;">1 '.__('article','sondages-lasonde').'</span>',
						'<a href="'.__('http://www.lasonde.fr/compte-premium/','sondages-lasonde').'" target="_blank">',
						'</a>'
						);
			}
		$html .='</table>';
		print $html;
	}
	/*
	 * on créer le bouton tiny
	 */
	function LSD_add_buttons_editor() {
	   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		 return;
	   if ( get_user_option('rich_editing') == 'true') {
		 add_filter("mce_external_plugins", array(&$this,"add_LSD_member_plugins_tinymce_plugin"));
		 add_filter('mce_buttons', array(&$this,'register_LSD_member_plugins_button'));
	   }
	}
	/*
	 * on register le bouton
	 */
	function register_LSD_member_plugins_button($buttons) {
	   array_push($buttons, "separator", "LSD_plugin_tags");
	   return $buttons;
	}
	 
	/*
	 * on charge la fonction du plugin en js
	 */
	function add_LSD_member_plugins_tinymce_plugin($plugin_array) {
	   $plugin_array['LSD_plugin_tags'] = LSD_MEMBER_PLUGIN_URL.'button/LSD_editor_plugin.js';
	   return $plugin_array;
	}
	/*
	 * On recupere le script
	 */
	function LSD_get_script_tag($sd_id){
		$tag = $this->LSD_curl_get_file_contents(LSD_CORE.'bdd-sondages.php?step=6&sd_id='.$sd_id.'&secret_key='.get_option('lsd_user_api_secret'));
		return $tag;
	}
	/*
	 * Detection si le membre est premium
	 */
	function LSD_member_is_premium($type="text"){
		$return = $this->LSD_curl_get_file_contents(LSD_CORE.'bdd-sondages.php?step=7&user_id='.$user_id.'&secret_key='.get_option('lsd_user_api_secret').'&type='.$type);
		if($return!='')
			return $return;
			
	}
	/*
	 * ecriture du js
	 */
	function LSD_print_script_tag($sd_id){
		print $this->LSD_get_script_tag($sd_id);
	}
	/*
	 * Création du short code!
	 */
	function LSD_script_tag($atts,$sd_id="") {
		extract(shortcode_atts(array('sd_id' => ''), $atts));
		$tag = $this->LSD_get_script_tag($sd_id);
		return $tag;
	}
	/*
	 * Fontion curl
	 * Permet les appel vers lasonde.Fr
	 * Si curl n'est pas installé, on utilise file_get_contents
	 */
	function LSD_curl_get_file_contents($url){
		if(function_exists('curl_init')){
	        $c = curl_init();
	        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($c, CURLOPT_URL, $url);
	        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, '2');
	        $contents = curl_exec($c);
	        curl_close($c);
		}else{
			$ctx = stream_context_create(array('http' => array('timeout' => 5))); 
			$contents = file_get_contents($url,0,$ctx);
		}

        if ($contents) return $contents;
            else return FALSE;
    }

}




/**********************************************************/
// Création Widget
/**********************************************************/
class LSD_widget extends WP_Widget {
	/*
	 * Init widget
	 */
	function LSD_widget() {
		$LSD_widjet_info = array('description' => __('Ajouter des sondages','sondages-lasonde') );
        parent::WP_Widget(false, LSD_PLUGIN_TITLE,$LSD_widjet_info);	
    }
    /*
	 * form admin widget
	 */
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
			<label for="list_sd_id">'._e('Sondage à insérer:','sondages-lasonde').LSD_get_list_sondages($this->get_field_name('list_sd_id')).'</label>
		</p>';
		print '
		<p>
			<label for="br">'._e('Saut de ligne avant le sondage ?','sondages-lasonde').'<input type="radio" name="'.$this->get_field_name('br').'"  '.($br==1?'checked="checked"':'').' value="1"/> '.__('Oui','sondages-lasonde').' <input type="radio" name="'.$this->get_field_name('br').'"  '.($br==0?'checked="checked"':'').' value="0"/> '.__('Non','sondages-lasonde').'</label>
		</p>';
	}
	/*
	 * update
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['list_sd_id'] = $new_instance['list_sd_id'];
		$instance['br'] = $new_instance['br'];
        return $instance;
	}
	/*
	 * Global
	 */
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

/*
 * Permet de rendre compatible l'ancienne version de la fonction.
 */
function LSD_print_script_tag($sd_id){
	global $wp_LSD_sondages;
	$wp_LSD_sondages->LSD_print_script_tag($sd_id);
}
/*
 * Permet de rendre compatible l'ancienne version de la fonction.
 */
function LSD_get_script_tag($sd_id){
	global $wp_LSD_sondages;
	return $wp_LSD_sondages->LSD_get_script_tag($sd_id);
}
/*
 * list des sondages.
 */
function LSD_get_list_sondages($select_id){
	global $wp_LSD_sondages;
	return $wp_LSD_sondages->LSD_get_list_sondages($select_id);
}
?>