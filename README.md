# Add Featured Image Column

## Description

This is a little plugin which adds a featured image column to WordPress. It automatically adds a column to any post type which supports a featured image. The code is pulled almost directly from my plugin [Display Featured Image for Genesis](http://wordpress.org/plugins/display-featured-image-genesis/).

Banner/icon image credit: [Lauren Mancke on Minimography](http://minimography.com/).

## Requirements
* WordPress 4.1, tested up to 4.8

## Installation

### Upload

1. Download the latest tagged archive (choose the "zip" option).
2. Go to the __Plugins -> Add New__ screen and click the __Upload__ tab.
3. Upload the zipped archive directly.
4. Go to the Plugins screen and click __Activate__.

### Manual

1. Download the latest tagged archive (choose the "zip" option).
2. Unzip the archive.
3. Copy the folder to your `/wp-content/plugins/` directory.
4. Go to the Plugins screen and click __Activate__.

Check out the Codex for more information about [installing plugins manually](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

### Git

Using git, browse to your `/wp-content/plugins/` directory and clone this repository:

`git clone git@github.com:robincornett/add-featured-image-column.git`

Then go to your Plugins screen and click __Activate__.

## Screenshots

![Screenshot of posts in the admin](https://github.com/robincornett/add-featured-image-column/blob/master/assets/screenshot-1.png)  
_Screenshot of posts with featured images._

## Frequently Asked Questions

No questions. Just activate and enjoy.

## Credits

* Built by [Robin Cornett](http://robincornett.com/)

## Changelog

### 1.1.3
* Improved: any post type which supports featured images (including private post types) will display a featured image column
* Added: the args to get the list of post types has been added to the post types filter
* Changed: admin column heading is just "Image" instead of "Featured Image"

### 1.1.2
* Added: text_domain, language files
* Fixed (really): featured image column on mobile

### 1.1.1
* Fixed: featured image column on mobile

### 1.1.0
* Added: the featured image column is now sortable.
* Due to redundancy, this plugin now deactivates if Display Featured Image for Genesis is active.

### 1.0.1
* Added filter to exclude post types

### 1.0.0
* Initial release on WordPress.org

### 0.9.0
* Initial release on Github
