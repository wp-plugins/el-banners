=== EL Banners ===
Contributors: english-learner
Donate link: http://english-learner.tk/
Tags: widgets, banners
Requires at least: 2.8
Tested up to: 3.3.1
Stable tag: 0.2

This plugin allow you to create widgets which will show banners, links or any other code from specified folder or file into sidebar automatically.

== Description ==

This plugin allow you to create widgets which will show banners, links or any other code from specified folder or file into a sidebar automatically.
A widget will show content from a specified path. If this path is a directory the plugin will show content from all text files in the directory. If this path is a file the plugin will read content of this file, split it by empty lines and then will show banners. You may use custom HTML code templates for widget body and banners.

== Installation ==

1. Download plugin, unpack it and upload into `YOUR-SITE/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Put text files with banner code into your banners directory. By default your banners directory is 'banners' directory inside the plugin directory. For example, YOUR-SITE/wp-content/plugins/elbanners/banners.
Also you may store banners in a single text file. In this case you need to insert empty line after each banner.
4. Go to `Appearance/Widgets` page in WordPress
5. Put "EL banners" widget into sidebar and edit its settings. You can edit widget title, banners path, template for banners container and template for banner.
6. You can create several instances of this widget

== Frequently Asked Questions ==
-

== Screenshots ==
No screenshots available

== Changelog ==
0.2 Now banners may be stored in a single text file

== Upgrade Notice ==
1. Delete all "EL banners" widgets
2. Deactivate "EL banners" plugin
3. Replace the plugin with a new version
4. Activate the new version
5. Create new widgets
