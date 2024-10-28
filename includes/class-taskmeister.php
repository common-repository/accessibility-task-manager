<?php
class class_taskmeister
{

    var $path = null;
    var $url = null;

    /**
     * Performs object initializations
     *
     * @param string $path to accept the filesystem path
     *                     of the directory that contains the plugin
     * @param string $url  to accept the plguin's URL path

     * Initializations:
     * admin_menu - Calling the action hook admin menu for custom wordpress menu
     * add_meta_boxes - Calling the action hook for generating custom fields in all post types and custom admin page
     * wp_ajax_taskmeister_request_api - An ajax callback action
     **/
    function __construct($path,$url)
    {
        $this->path = $path;
        $this->url = $url;
        if (is_admin()) {

            //create custom page in the admin
            add_action('admin_menu', array( $this, 'taskmeister_admin_menu'));

            add_action('add_meta_boxes', array($this,'taskmeister_manage_metabox'));
            add_action(
                'wp_ajax_taskmeister_request_api',
                array($this,'taskmeister_request_api')
            );
            add_shortcode('taskmeister', array($this,'taskmeister_shotcode_form'));

            //add inline javascript
            add_action('wp_print_scripts',array($this,'taskmeister_ajax_admin_url'));

            //add the scripts and styles
            add_action('admin_enqueue_scripts', array($this,'taskmeister_add_scripts' ));
        }
    }

    /**
     * Register custom admin style and javascript
     *
     * @return void
     **/
    function taskmeister_add_scripts(){
        wp_register_style('taskmeister_style_scripts',$this->url.'assets/taskmeister.css');
        wp_register_script('taskmeister_js_scripts',$this->url.'assets/taskmeister.js');
        wp_enqueue_style('taskmeister_style_scripts');
        wp_enqueue_script('taskmeister_js_scripts');
    }

    /**
     * Register custom admin ajax url variable through inline js
     *
     * @return void
     **/
    function taskmeister_ajax_admin_url(){
        ?>
        <script type="text/javascript">
            var admin_ajax_url = '<?php bloginfo('url'); ?>';
        </script>
        <?php
    }

    /**
     * Register custom admin menu for taskmeiste plugin
     *
     * @return void
     **/
    function taskmeister_admin_menu()
    {
        add_menu_page(
            __('taskmeister', ' general_menu'),
            __('Accessibility Task Manager', 'general_menu'),
            '',
            'taskmeister-settings',
            'taskmeister_settings',
            'dashicons-welcome-write-blog'
        );
        add_submenu_page(
            'taskmeister-settings',
            __('Pretask', 'general_menu'),
            __('Pretask', 'taskmeister-settings'),
            3,
            'general',
            array($this, 'taskmeister_menu_func')
        );
    }

    /**
     * Callback function to display the associate page for the custom admin menu.
     *
     * @return null
     **/
    function taskmeister_menu_func()
    {
        include_once $this->path.'view/taskmeister-pretasks.php';
    }

    /**
     * Callback function to display the form through shortcode
     *
     * DEPRECATED
     *
     * @return string
     **/
    function taskmeister_shotcode_form()
    {
        ob_start();
        include_once $this->path.'view/taskmeister-form.php';
        return ob_get_clean();
    }

    /**
     * Callback function to register the custom meta_boxes for taskmeister plugin
     *
     * @return void
     **/
    function taskmeister_manage_metabox()
    {
        $get_available_post_type = $this->taskmeister_get_target_post_types();
        add_meta_box(
            'taskmeister_meta_box',
            'Accessibility Task Manager',
            array($this,'taskmeister_meta_html_render'),
            $get_available_post_type
        );
    }

    /**
     * A regular method to return the current URL of the user
     *
     * @return string
     **/
    function taskmeister_current_location()
    {
        $url = (isset($_SERVER['HTTPS']) &&
            $_SERVER['HTTPS'] === 'on' ? "https" : "http") .
            "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        return $url;
    }


    /**
     * An Ajax callback method, this is the http request of the wordpress ajax.
     * Responsible to sends data to taskmeister server through API.
     * Requested through Ajax
     * parameters: None
     *
     * Data Posted to API:
     * task_name - (String) name of the task
     * task_desc - (String) description of the task
     * username  - (String) username of the wordpress user
     * plugin_id - (String) ID of plugin
     * post_type - (String) task URL or location
     *
     * @return void
     **/
    function taskmeister_request_api()
    {

        $tm_title = sanitize_text_field($_POST['tmtaskname']);
        $tm_description = sanitize_text_field($_POST['tmdescription']);

        $get_username = wp_get_current_user();

        $username = $get_username->user_login;
        $plugin_id = 'wptaskmeister';

        $actual_link = sanitize_text_field($_POST['tm_cur_url']);
        $actual_post_type = sanitize_text_field($_POST['tm_cur_post_type']);

        // Production URL
        $base_api = 'https://etaskboard.bizware.com/api/pretask.php';

        $param_api = array(
            'task_name' => $tm_title,
            'task_desc' => $tm_description,
            'username' => $username,
            'plugin_id' => $plugin_id,
            'location' => $actual_link
        );

        $param_api = http_build_query($param_api, '', '&');

        $response = wp_remote_post( $base_api, array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => $param_api,
            'cookies' => array()
            )
        );

        if ( is_wp_error( $response ) ) {
           $error_message = $response->get_error_message();
           echo "Something went wrong: $error_message";
           die();
        } else {
           $server_output = wp_remote_retrieve_body( $response );
           echo $server_output;
           die();
        }

    }
    /**
     * A regular method to render the form in admin custom page
     *
     * @return void
     **/
    function taskmeister_meta_html_render()
    {
        include_once $this->path.'view/taskmeister-form.php';
    }

    /**
     * A regular method that will return all available post types
     *
     * @return array()
     **/
    function taskmeister_get_target_post_types()
    {
        $types = get_post_types([], 'objects');
        $exclude_types = array('attachment','revision','nav_menu_item');
        $post_types = array();
        foreach ( $types as $type ) {
            if (isset($type->name) && !in_array($type->name, $exclude_types)) {
                $post_types[] = $type->name;
            }
        }
        return $post_types;
    }

}
?>