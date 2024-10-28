=== Accessibility Task Manager ===
Contributors: pshikli
Tags: Productivity, Accessibility Content
Requires at least: 3.6
Tested up to: 5.5
Requires PHP: 5.2.4
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Short Description ==
This plugin automates the process of getting task-based help to make content accessible to the disabled, that is, compliant to Title II and III of the ADA.

== Description ==
This plugin automates the process of getting task-based help to make content accessible to the disabled, that is, compliant to Title II and III of the ADA.

If WordPress content editors, for example, California agency staff producing content via the CAWeb implementation of WordPress, encounter an accessibility question or support need, they can use this plugin to get help. The plugin displays a popup with a short form where users can describe their need, for example, a new table to be audited for accessibility, or the entire page to be remediated.

As soon as users hit submit, their request is passed to Access2online to automatically fill in the existing pretask form where new tasks begin. Following existing procedure, Access2online responds with a proposed task back to the user. If the user accepts, Access2online gets busy auditing the page or its content, or editing the user's content to remediate it before publication.

The net result is WordPress content made accessible by experienced Trusted Testers certified by the Office of Accessible Systems and Technology who are also Web Accessibility Professionals certified by the International Association of Accessibility Professionals.

Ordered list:

1. Custom form to send pretask to Access2online server
2. The custom form is available in all post type
3. Stand alone form is also available for general pretask request

Unordered list:

1. We don't take any sensitive information from the user such as password and email address.
2. We take only the following data to generate the pretask:
   1.1: Username - To determine if the request is sent by the registered client
   1.2: Task title - Title of the task
   1.3: Task description - Description of the task
   1.4: Plugin ID - To determine the request is came from the plugin
   1.5: Post URL - URL of the post


== Installation ==
1. Upload "accessibility-task-manager" folder to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. The plugin will automatically generate a custom form to send pretask in every post type. 

== Frequently Asked Questions ==
= How do I know if my request is successfully sent? =
Answer: Once your username is verified as our registered client you will recieve an email from us.


== Screenshots ==
1. assets/screenshot-1.png

== Changelog ==

= 1.0 =
* Initial release.

== Upgrade Notice ==
= 1.1 =
* change plugin name to Accessibility Task Manager
* Fix bugs on CURL

== 1.2 ==
* Implement WP functions on API request
* Implement WP hooks on loading scripts
* Add response message for server error

== 1.2.1 ==
* Minor UI improvements