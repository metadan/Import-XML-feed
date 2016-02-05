=== Moove Activity Tracking ===
Tags: xml import, rss import, xml feed import, rss feed import, import
Requires at least: 3.0.1 or higher
Tested up to: 4.3
License: GPLv2

This plugin adds the ability to import content from an external XML/RSS file, or from an uploaded XML/RSS and add the content to any post type in your WordPress install. It also supports importing taxonomies alongside posts.

== Description ==

This plugin adds the ability to import content from an external XML/RSS file, or from an uploaded XML/RSS and add the content to any post type in your WordPress install. It also supports importing taxonomies alongside posts.

The process of import:
- Select the source ( URL or FILE UPLOAD )
- Select your repeated XML element you want to import - This should be the node in your XML file which will be considered a post upon import.
- Select the post type you want to import the content to.
- Match the fields from the XML node you've selected (step 2) to the corresponding fields you have available on the post type.

* XML files and URLs *
The XML source file should be a valid XML file. The plugin does check if the URL source or the Uploaded file is valid for import and processing. If you use the URL source for importing, please make sure the URL you are using is not password protected with HTTP Auth or any other form of authentification (it needs to be public).

Accepted formats: XML 1.0, XML 2.0, Atom 1, RSS

* XML Preview *
After sucessfully uploading an XML file or reading an external URL, the plugin will present you with an XML preview of the selected node, which can be used to check if you've selected the correct node or you have all the data read correctly by the plugin. This preview presents one item from the selected node and it is paginated so you can navigate back and forward between the elements.

* Linking Taxonomies to Posts *

This plugin allows you to import categories/taxonomies from the XML file and link the imported posts to these taxonomies.

First you need to have the taxonomies created in WordPress to allow the plugin to import into these taxonomies. By default WordPress has two taxonomies: categories and tags.

* Importing and linking multiple taxonomies to one post *

To import and link one post to multiple taxonomies, you need to have an XML element in your selected node with a list of categories separated by commas. These elements will be recognized and imported separately as taxonomy terms.

== Installation ==
1. Upload the plugin files to the plugins directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the \'Plugins\' screen in WordPress
3. Use the Settings->Moove feed importer screen to configure the plugin