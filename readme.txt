=== Add Featured Image Column ===

Contributors: littler.chicken
Donate link: https://robincornett.com/donate/
Tags: featured image, admin columns
Requires at least: 4.1
Tested up to: 5.5
Stable tag: 1.1.5
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

This plugin adds a featured image column to any post type which supports featured images. See which posts have a featured image at a glance!

== Description ==

This is a little plugin which adds a featured image column to WordPress. It automatically adds a column to any post type which supports a featured image. The code is pulled almost directly from my plugin [Display Featured Image for Genesis](http://wordpress.org/plugins/display-featured-image-genesis/).

Banner/icon image credit: [Lauren Mancke on Minimography](http://minimography.com/).

== Installation ==

1. Upload the entire `add-featured-image-column` folder to your `/wp-content/plugins` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Optionally, visit the Settings > Media page to change the default behavior of the plugin.

== Frequently Asked Questions ==

No questions. Just activate and enjoy.

== Screenshots ==
1. Screenshot of posts with featured images.

== Upgrade Notice ==

Updated output if a post has no featured image

== Changelog ==

= 1.1.5 =
* improved: output for posts with no featured image

= 1.1.4 =
* fixed: featured image column display on mobile

= 1.1.3 =
* Improved: any post type which supports featured images (including private post types) will display a featured image column
* Added: the args to get the list of post types has been added to the post types filter
* Changed: admin column heading is just "Image" instead of "Featured Image"

= 1.1.2 =
* Added: text_domain, language files
* Fixed (really): featured image column on mobile

= 1.1.1 =
* Fixed: featured image column on mobile

= 1.1.0 =
* Added: the featured image column is now sortable.
* Due to redundancy, this plugin now deactivates if Display Featured Image for Genesis is active.

= 1.0.1 =
* Added filter to exclude post types

= 1.0.0 =
* Initial release on WordPress.org

= 0.9.0 =
* Initial release on Github
