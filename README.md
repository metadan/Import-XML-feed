# Moove Activity Plugin

This plugin adds the ability to track the content visits / updates for any kind of custom post type or page.

You can enable or disable the tracking for each post type registered on your site.

### The following data will be logged:

1.  Date/time
2.  User name
3.  Activity (visited/updated)
4.  Client IP
5.  Client Location (by IP Address)
6.  Referrer url

### Global Settings

Under the Global settings page found under Settings -> Moove Activity Log you can set up activity logging globally per all the defined post types in your WordPress installation. Also, you can define the time frame/period to keep the logs in the database. This feature is really handy when you want to log activity for smaller or larger periods of time, but be careful when you set a large period it can affect your server performance and database size.

When you DISABLE logging for a custom post type, all your logs will be deleted from the database. You have to confirm this before it deletes everything, but be sure you want to do this before disabling logging, or export your data in CSV beforehand.

### Overriding the global settings

You can override the global post type tracking settings for each post by using the Moove Activity meta box when editing a post.

### Activity log

On the left admin menu, below the Dashboard menu item there is an "Activity log" page, this is where you can see the log entries.

**Features of the Activity log page include the following:**

1.  PAGINATION - load more pagination for loading log entries via Ajax.
2.  CLEARING LOGS - You have the possibility to clear log entries per post type or you can clear all log entries at once.
3.  EXPORT - You have the possibility to export your log as a .csv file
4.  GROUPING - Activity log entries are grouped by post type and subsequently the logs are grouped by post.