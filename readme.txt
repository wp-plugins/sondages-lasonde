=== Plugin Name ===
Contributors: Lasonde.fr
Donate link: http://www.lasonde.fr/plugin-sondages-lasonde-fr-pour-wordpress/
Tags: lasonde, lasonde.fr sondages, faire un sondage, créer un sondages, sondages blog, polls, survey
Requires at least: 2.8
Tested up to: 2.8
Stable tag: 1.2.1

Lasonde.fr permet d'ajouter des sondages sur son blog, ses sites...
Gratuits et Simples à intégrer.

== Description ==

Lasonde permet de créer des sondages.

= Fonctionnalités: = 

- Réponses (radio ou checkbox pour multi votes) (illimitées)
- Date de début du sondage
- Date de fin du sondage
- Blocage par IP/cookie des votes avec choix de la durée de restriction (évite qu'une personne vote 2 fois de suite.)
- CSS => Choix du style du sondage, créez votre style entièrement paramétrable en CSS ou utilisez les styles proposés par Lasonde.fr
- Privés ou publics (pubic = visible par les visiteurs Lasonde.fr)
- Effets des barres de résultats (slide, élastiques, etc...)
- Graphiques paramétrables avec API Google Chart
- Export des résultats : XML et CSV
- Suivi des résultats en temps réel via l'administration.
- Export et partage des sondages via un code javascript à coller sur votre site. (Ou automatiquement via le plugin)
- Montrer ou cacher les résultats.

= Vous pouvez ajouter des sondages avec le plugin: = 

- En utilisant le bouton Sondages Lasonde dans l'éditeur d'articles ou de pages (WYSIWYG),
- En utilisant les widgets Sondages-Lasonde dans vos sidebars,
- En ajoutant un tag `[lasonde sd_id="XXX"]`* dans les articles et pages,
- En en appellant la fonction `<?php LSD_print_script_tag("XXX"); ?>`* dans les templates et plugins
*où XXX est l'id du sondage (L'id se récupere sur le site lasonde.)


== Installation ==

1. Dézippez et Uploadez `sondages-lasonde` dans le repertoire `/wp-content/plugins/`
2. Activez le plugin via le menu plugins de WordPress
3. Le Tag, la fonction php `LSD_print_script_tag` et `le bouton(WYSIWYG)` sont activés.
Si vous rencontrez des problèmes avec l'installation merci de contacter L'administrateur.


== Frequently Asked Questions ==
= Comment créer un sondage ? =
Pour créer un sondage il faut avoir un compte lasonde.fr 
et se rendre sur http://www.lasonde.fr/gestion/creer-un-sondage/

= Que fait le plugin lasonde ? =
Le plugin lasonde.fr permet d'ajouter sur vos blogs wordpress
les sondages de votre compte lasonde.fr

= Comment obtenir une clé Lasonde.fr =
1. Vous avez besoin d'une clé lasonde.fr pour accéder à vos sondages depuis le plugin,
Il faut vous rendre sur votre  sur [votre Tableau de bord Lasonde.fr](http://www.lasonde.fr/gestion/tableau-de-bord/ "Tableau de bord Lasonde.fr"),
la clé API apparaît en bas de la page, copiez la.
2. Allez dans les options Sondages Lasonde.fr de votre blog wordpress puis collez la clé
dans le champ prévu. Puis Enregistrez.
3. Le plugin trouve vos sondages automatiquement.

= Le plugin ne fonctionne pas sur mon serveur =
Si votre serveur web ne permet pas l’exécution de la fonction php `file_get_contents();` alors le plugin ne peut pas fonctionner.
Pour activer cette fonction sur votre serveur, vous devez avoir une version de php >4.3 et vérifier que la variable
`allow_url_fopen=On` est bien dans votre php.ini
Il semble que les serveurs OVH ou 1and1 mutualisés n’autorisent pas cette utilisation.

== Screenshots ==
1. Exemple de popup d'ajout de sondages dans un article/page
2. Screeshot de la page de configuration
3. Screeshot de la création d'un widget


== Changelog ==
= 1.0 =
Base
= 1.0.0.2 = 
- Correction fichiers php
= 1.0.0.3 = 
- Correction fichiers php
= 1.0.0.4 = 
- Correction fichiers php
= 1.0.0.5 = 
- Correction fichiers Javascript: une erreur 404 dans l'appel de la pop up qui permet d'ajouter des sondages dans les pages et articles.
= 1.1 = 
- Ajout du Widget Sondages-Lasonde qui permet d'ajouter des sondages dans les sidebars de vos blogs.
- Modification de la fonction qui obtient la liste de vos sondages
= 1.2 = 
- Refonte de l'adminisration du plugin, récriture du plugin avec class php
- Obligatoire pour fonctionner correctement
= 1.2.1 = 
- Modification de fonction php qui vérifie la clé secrète Lasonde.fr
- Obligatoire pour fonctionner correctement



== Upgrade Notice ==
= 1.0 =
- Version de base
= 1.0.0.2 = 
- Bugs
= 1.0.0.3 = 
- Bugs
= 1.0.0.4 = 
- Bugs 
= 1.0.0.5 =
- Obligatoire pour fonctionnement Javascript et Fix de l'erreur 404 dans l'editeur. Obligatoire pour fonctionner correctement
= 1.1 = 
- Ajout du Widget Sondages-Lasonde qui permet d'ajouter des sondages dans les sidebars de vos blogs.
- Modification de la fonction qui obtient la liste de vos sondages
- Obligatoire pour fonctionner correctement
= 1.2 = 
- Refonte de l'adminisration du plugin, réécriture du plugin avec class php
- Obligatoire pour fonctionner correctement
= 1.2.1 = 
- Modification de fonction php qui vérifie la clé secrète Lasonde.fr
- Obligatoire pour fonctionner correctement

== Un petit Exemple ==
Allez sur [Lasonde.fr/plugin wordpress](http://www.lasonde.fr/plugin-sondages-lasonde-fr-pour-wordpress/ "Installer Sondages Lasonde sur wordpress") 

== !!! ==
Si votre serveur web ne permet pas l’exécution de la fonction php `file_get_contents();` alors le plugin ne peut pas fonctionner.
Pour activer cette fonction sur votre serveur, vous devez avoir une version de php >4.3 et vérifier que la variable
`allow_url_fopen = On` est bien dans votre php.ini
Il semble que les serveurs OVH ou 1and1 mutualisés n’autorisent pas cette utilisation.
