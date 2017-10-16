<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    IAM
 * @subpackage IAM/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    IAM
 * @subpackage IAM/admin
 * @author     Your Name <email@example.com>
 */
class IAM_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->load_dependencies();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - IAM_Loader. Orchestrates the hooks of the plugin.
	 * - IAM_i18n. Defines internationalization functionality.
	 * - IAM_Admin. Defines all hooks for the admin area.
	 * - IAM_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */

		require_once iam_dir() . 'includes/IAM-cal.php';

		require_once iam_dir() . 'admin/IAM-admin-forms.php';

		require_once iam_dir() . 'includes/IAM-funds-handler.php';

		require_once iam_dir() . 'includes/IAM-tags.php';

		require_once iam_dir() . 'includes/IAM-sec.php';

		require_once iam_dir() . 'admin/content.php';

        require_once iam_dir() . 'admin/debug.php';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style($this->plugin_name.'-bootstrap', iam_url().'static/' . 'css/bootstrap.min.css', $this->version, 'all' );
		wp_enqueue_style($this->plugin_name.'-bootstrap-theme', iam_url().'static/' . 'css/bootstrap-theme.min.css', $this->version, 'all' );
		wp_enqueue_style($this->plugin_name.'-jquery-ui-css', iam_url().'static/' . 'css/jquery-ui.min.css');
		wp_enqueue_style($this->plugin_name.'-jquery-ui-css-structure', iam_url().'static/' . 'css/jquery-ui.structure.min.css');
		wp_enqueue_style($this->plugin_name.'-jquery-ui-css-theme', iam_url().'static/' . 'css/jquery-ui.theme.min.css');
		wp_enqueue_style($this->plugin_name.'-fullcalendar-css', iam_url().'static/' . 'css/fullcalendar.min.css', $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'font-awesome', iam_url().'static/' . 'css/font-awesome.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'context-menu-css', iam_url().'static/' . 'css/contextMenu.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, iam_url().'src/css/admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script($this->plugin_name.'-bootstrap', iam_url().'static/' . 'js/bootstrap.min.js', array('jquery'),$this->version, false);
		wp_enqueue_script($this->plugin_name.'context-menu', iam_url().'static/' . 'js/contextMenu.min.js', array('jquery'),$this->version, false);
		wp_enqueue_script($this->plugin_name.'popper-js');
		wp_enqueue_script($this->plugin_name.'bootstrap-js');
		wp_enqueue_script($this->plugin_name.'-jquery-ui', iam_url().'static/'. 'js/jquery-ui.min.js', array('jquery'),$this->version, false);
		wp_enqueue_script($this->plugin_name.'-moment', iam_url().'static/'. 'js/moment.min.js', array(),$this->version, false);
		wp_enqueue_script($this->plugin_name.'pagination-js', iam_url().'static/' . 'js/pagination.min.js',array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name.'fullcalendar-js', iam_url().'static/' . 'js/fullcalendar.min.js',array('jquery'), $this->version, false);

		wp_enqueue_script( $this->plugin_name, iam_url() . 'build/js/admin.js', array( 'jquery' ), $this->version, false );

	}

    public function admin_setup_menu() {
			$facilities = ezget("SELECT * FROM ".IAM_FACILITY_TABLE);

			$facility_content_objs = [];

			foreach ($facilities as $f) {
				$facility_content_objs[$f->Name] = new Admin_Content($f);
			}

			add_menu_page ( 'IAM info', 'IAM info', 'manage_options', 'imrc-info', array('Admin_Content','info_content'), plugins_url( 'assets/eye.png', dirname(__FILE__) ));

      if (DEV_MODE === 1)
          add_menu_page ( 'Debug', 'Debug', 'manage_options', 'imrc-debug', array('Debug_Page','debug_content'), plugins_url( 'assets/bug.png', dirname(__FILE__) ));
    }

}
