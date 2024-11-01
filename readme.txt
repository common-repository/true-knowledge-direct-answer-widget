=== True Knowledge Direct Answer Widget ===
Contributors: rpstac
Tags: question answering, questions, true knowledge, widget
Requires at least: 2.7.0
Tested up to: 2.7.1
Stable tag: 0.2

Enables users of your site to ask True Knowledge (http://www.trueknowledge.com) questions.

== Description ==

This widget enables users of your Wordpress blog to ask questions of True Knowledge using their direct answer API. True Knowledge support questions about anything - though they may not be able to answer everything at the moment as they are continuously adding new knowledge that lets them answer more and more everyday. 

To use the plugin you need to have a True Knowledge API account, you can get these from the [True Knowledge](http://www.trueknowledge.com/api/signup/) site.

Once you have an active account you can enter your details and users can start asking questions!

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the code to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Enable the Widget and place it on to a sidebar in your site.
4. Enter your True Knowledge API username and password into the widget options.

NB: Your theme must include JQuery for this plugin to work, you can add the line `<?php wp_enqueue_script('jquery'); ?>` before the call to `wp-head()` if it doesn't by default.