=== Moove Activity Tracking ===
Tags: activity tracking, activity log, tracking
Requires at least: 3.0.1 or higher
Tested up to: 4.3
License: GPLv2

This plugin adds the ability to track the content visits / updates of any kind of custom post type or page.

== Description ==

This plugin adds the ability to track the content visits / updates for any kind of custom post type or page.
You can enable or disable the tracking for each post type registered on your site.

The following data will be logged:
- Date/time
- User name
- Activity (visited/updated)
- Client IP
- Client Location (by IP Address)
- Referrer url
- Global Settings

Under the Global settings page found under Settings -> Moove Activity Log you can set up activity logging globally per all the defined post types in your WordPress installation. Also, you can define the time frame/period to keep the logs in the database. This feature is really handy when you want to log activity for smaller or larger periods of time, but be careful when you set a large period it can affect your server performance and database size.

When you DISABLE logging for a custom post type, all your logs will be deleted from the database. You have to confirm this before it deletes everything, but be sure you want to do this before disabling logging, or export your data in CSV beforehand.

* Overriding the global settings *
You can override the global post type tracking settings for each post by using the Moove Activity meta box when editing a post.

* Activity log *

On the left admin menu, below the Dashboard menu item there is an "Activity log" page, this is where you can see the log entries.

Features of the Activity log page include the following:
- PAGINATION - load more pagination for loading log entries via Ajax.
- CLEARING LOGS - You have the possibility to clear log entries per post type or you can clear all log entries at once.
- EXPORT - You have the possibility to export your log as a .csv file
- GROUPING - Activity log entries are grouped by post type and subsequently the logs are grouped by post.

== Installation ==
1. Upload the plugin files to the plugins directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the \'Plugins\' screen in WordPress
3. Use the Settings->Moove activity log screen to configure the plugin