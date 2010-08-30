=== Plugin Name ===
Contributors: Lasonde.fr
Donate link: http://www.lasonde.fr/
Tags: sondages, faire un sondage, créer un sondages, sondages blog, polls, survey
Requires at least: 2.8
Tested up to: 2.8
Stable tag: 1.1

Lasonde.fr permet d'ajouter des sondages sur son blog, ses sites...
Gratuits, Faciles à intégrer, les sondages lasonde.fr s'adapteront parfaitement à votre design

== Description ==

Lasonde.fr est un site de création de sondage.

= Vous pouvez ajouter des sondages avec le plugin: = 
- En utilisant le bouton Sondages Lasonde dans l'éditeur d'articles ou de pages (WYSIWYG),
- En utilisant les widgets Sondages-Lasonde dans vos sidebars,
- En ajoutant un tag `[lasonde sd_id="XXX"]`* dans les articles et pages,
- En en appellant la fonction `<?php LSD_print_script_tag("XXX"); ?>`* dans les templates et plugins
*o√π XXX est l'id du sondage (L'id se récupere sur le site lasonde.)


== Installation ==

1. Dézippez et Uploadez `sondages-lasonde` dans le repertoire `/wp-content/plugins/`
2. Activez le plugin via le menu plugins de WordPress
3. Le Tag, la fonction php `LSD_print_script_tag` et `le bouton(WYSIWYG)` sont activés.
Si vous rencontrez des problèmes avec l'installation merci de contacter L'administrateur.


== Frequently Asked Questions ==

= Comment créer un sondage ? =

Pour créer un sondage il faut avoir un compte lasonde.fr 
et se rendre sur http://www.lasonde.fr/les-sondages/creer-un-sondage/

= Que fait le plugin lasonde ? =

Le plugin lasonde.fr permet d'ajouter sur vos blogs wordpress
les sondages de votre compte lasonde.fr

== Screenshots ==

1. Exemple de popup d'ajout de sondages dans un article/page
2. Screeshot de la page de configuration
3. Screeshot de la création d'un widget


== Changelog ==

= 1.0 =
Base
= 1.0.0.2 = 
Correction fichiers php
= 1.0.0.3 = 
Correction fichiers php
= 1.0.0.4 = 
Correction fichiers php
= 1.0.0.5 = 
Correction fichiers Javascript: une erreur 404 dans l'appel de la pop up qui permet d'ajouter des sondages dans les pages et articles.
= 1.1 = 
Ajout du Widget Sondages-Lasonde qui permet d'ajouter des sondages dans les sidebars de vos blogs.
Modification de la fonction qui obtient la liste de vos sondages



== Upgrade Notice ==

= 1.0 =
Version de base
= 1.0.0.2 = 
Bugs
= 1.0.0.3 = 
Bugs
= 1.0.0.4 = 
Bugs 
= 1.0.0.5 =
- Obligatoire pour fonctionnement Javascript et Fix de l'erreur 404 dans l'editeur. Obligatoire pour fonctionner correctement
= 1.1 = 
- Ajout du Widget Sondages-Lasonde qui permet d'ajouter des sondages dans les sidebars de vos blogs.
- Modification de la fonction qui obtient la liste de vos sondages
- Obligatoire pour fonctionner correctement



== Obtenir une clée Lasonde.fr ==

1. Vous avez besoin d'une clé lasonde.fr pour accéder à vos sondages depuis le plugin,
Il faut vous rendre sur votre tableau de bord lasonde.fr,
la clé API apparaît en bas de la page, copiez la.
2. Allez dans les options Sondages Lasonde.fr de votre blog wordpress puis collez la clé
dans le champ prévu. Puis Enregistrez.
3. Le plugin trouve vos sondages automatiquement.


== Un petit Exemple ==
Allez sur [Lasonde.fr/plugin wordpress](http://www.lasonde.fr/plugin-sondages-lasonde-fr-pour-wordpress/ "Installer Sondages Lasonde sur wordpress") 

