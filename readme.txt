=== isMobile() Shortcode for WordPress ===

Plugin Name: isMobile() Shortcode for WordPress
Description: Simple plugin that shows or hides the content depending on the device, its brand or OS through the use of a shortcode. <u>Works with <a title="Mobile Detect Library" target="_blank" href="http://mobiledetect.net" >Mobile Detect Library</a></u>.
Tags: desktop, mobile, tablet, iphone, ipad
Contributors: jairoochoa, dixitalmedia
Requires at least: 4.5
Tested up to: 6.5.5
Stable tag: trunk
Version: 1.1.1
Requires PHP: 7.4
Text Domain: ismobile
Domain Path: /languages/
License: GPL v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


This plugin works with the open source <a title="Mobile Detect Library" target="_blank" href="http://mobiledetect.net" >Mobile Detect Library</a>. You can get further information on its website.

== Description ==

This plugin works with the open source <a title="Mobile Detect Library" target="_blank" href="http://mobiledetect.net" >Mobile Detect Library</a>. You can get further information on its website.

`[ismobile device='iphone' debug=true ] Your content [/ismobile]`

= Parameters =

1. *device*: Filters the device where you want the content to be shown. It could be more than one device, simply separate them with comma.
2. *debug*: Shows Mobile Detect Library installed version. Also shows two arrays. The first one contains the devices which the library detects and the second one contains the devices where you want to show the content.

= Values =

- *android*: Shows content in Android devices.
- *chrome*: Shows content on Chrome browser (Only works on mobile devices).
- *desktop*: Shows content on a computer. Opposite to mobile option.
- *ios*: Shows content in iOS devices.
- *ipad*: Shows content on a iPad.
- *iphone*: Shows content on a iPhone.
- *mobile*: Shows content on a mobile device (includes tablets and cell phones). Opposite to desktop option.
- *phone*: Shows content on a cell phone.
- *safari*: Shows content on Safari browser (Only works on mobile devices).
- *samsung*: Shows content on Samsung devices.
- *tablet*: Shows content on a tablet.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the entire plugin folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the “Plugins” menu in WordPress.
3. Go to Plugins -> isMobile() to read plugin's help page.


= Minimum Requirements =

* PHP version 7.4 or greater


== Changelog ==

= 1.0 =
* Initial Release

= 1.0.1 =
* Mobile Detect Library updated to Version 2.8.34

= 1.0.2 =
* Mobile Detect Library updated to Version 2.8.39

= 1.0.3 =
* Updated last WordPress version tested

= 1.1 =
* Updated last WordPress version tested
* Mobile Detect Library updated to Version 3.74.0
* Minimum PHP version: 7.4

= 1.1.1 =
* Mobile Detect Library downgrade to Version 2.8.41





