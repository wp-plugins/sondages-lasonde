=== Plugin Name ===
Contributors: Lasonde.fr
Donate link: http://www.lasonde.fr/
Tags: sondages, faire un sondage, créer un sondages, sondages blog, polls, survey
Requires at least: 2.8
Tested up to: 2.8
Stable tag: 1.0

Lasonde.fr permet d'ajouter des sondages sur son blog

== Description ==

Lasonde.fr est un site de création de sondage, une fois que vos sondages sont crées, vous pouvez à l'aide de ce plugin,
les ajouter directement depuis votre éditeur, en ajoutant un tag [lasonde sd_id="XXX"],
ou en appellant la fonction LSD_print_script_tag("XXX"); où XXX est l'id du sondage.


== Installation ==

1. Uploadez `lasonde-sondages` dans le repertoire `/wp-content/plugins/`
2. Activez le plugin via le menu plugins de WordPress
3. Vous pouvez ajouter les tags, et fonctions décrite plus haut 


== Frequently Asked Questions ==

= Comment créer un sondage ? =

Pour créer un sondage il faut avoir un compte lasonde.fr et se rendre sur http://www.lasonde.fr/les-sondages/creer-un-sondage/

= Que fais le plugin lasonde ? =

Le plugin lasonde.fr permet d'ajouter à vos blogs wordpress, les sondages de votre compte lasonde.fr

== Screenshots ==

1. Exemple de popup ajout de sondage dans un article
2. Exemple de la page de configuration




== Changelog ==

= 1.0 =



== Upgrade Notice ==

= 1.0 =



== Arbitrary section ==

1. Vous avez besoin d'une clé lasonde.fr pour pouvoir accéder à vos sondages,Il faut vous rendre sur votre tableau de bord, la clé API apraît en bas de la page.
2. Utiliser le plugin pour ajouter vos sondages créé sur lasonde.fr


== A brief Example ==
Allez sur [Lasonde.fr/plugin wordpress](http://www.lasonde.fr/plugin-sondages-lasonde-fr-pour-wordpress/ "Installer Lasonde sur wordpress") 
Pour ajouter un sondage dans un article ou une page:
Tag => [lasonde sd_id="X"]
bouton de l'éditeur de texte => cliquez sur le bouton lasonde dans l'éditeur de texte pour ajouter un sondage
Template => Pour ajouter un sondage dans les template, ajoutez cette fonction php :<?php LSD_print_script_tag(X); ?>
(X est l'identifiant du sondage)
