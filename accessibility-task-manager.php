<?php
/**
 * Plugin Name: Accessibility Task Manager
 * Description: This plugin automates the process of getting task-based help to make content accessible to the disabled, that is, compliant to Title II and III of the ADA.
 * Author:      TaskMeister
 * Plugin Type: Functionality
 * Version: 1.2.1
 **/


/*
Log changes:

v 1.0: Initial Release
v 1.1: Fix bugs on CURL
v 1.2: Implement WP functions on API request
       Implement WP hooks on loading scripts
       Add response message for server error
v 1.2.1: Minor UI improvement

*/

defined('ABSPATH') or die('No script kiddies please!');

add_action('plugins_loaded', 'init_taskmeister_plugin');

function init_taskmeister_plugin()
{
    include_once "includes/class-taskmeister.php";
    $taskm = new class_taskmeister(
        plugin_dir_path(__FILE__),
        plugin_dir_url(__FILE__)
    );
}

?>
