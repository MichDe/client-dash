<?php

/**
 * Class ClientDash_RequireFiles
 *
 * This class requires all of the various files needed to make Client
 * Dash core run.
 *
 * @package WordPress
 * @subpackage ClientDash
 *
 * @since Client Dash 1.5
 */
class ClientDash_RequireFiles extends ClientDash {

	/**
	 * Requires all necessary files for Client Dash.
	 *
	 * Also initiates all page and tab classes.
	 *
	 * @since Client Dash 1.5
	 */
	function __construct() {

		global $ClientDash;

		// Require our AJAX file
		include_once( $ClientDash->path . '/core/ajax.php' );

		// Require our deprecated file
		include_once( $ClientDash->path . '/core/deprecated.php' );

		// Core page and tab files
		foreach ( $this->core_files as $page => $tabs ) {
			// Include page file
			include_once( plugin_dir_path( __FILE__ ) . 'pages/' . $page . '.php' );

			// Initiate the new page class to launch it and save it into a global object
			$page_class = 'ClientDash_Page_' . ucfirst( $page );
			global ${$page_class};
			${$page_class} = new $page_class;

			foreach ( $tabs as $tab ) {
				// Include tabs
				include_once( plugin_dir_path( __FILE__ ) . 'tabs/' . $page . '/' . $tab . '.php' );

				// Initiate the new tab class to launch it and save it into a global object
				$tab_class = 'ClientDash_Core_Page_' . ucfirst( $page ) . '_Tab_' . ucfirst( $tab );
				global ${$tab_class};
				${$tab_class} = new $tab_class;
			}
		}

		// Core widget files
		foreach ( $this->core_widgets as $widget ) {
			include_once( plugin_dir_path( __FILE__ ) . 'widgets/' . $widget . '.php' );

			// Initiate the new widget class to launch it
			$widget_class = 'ClientDash_Widget_' . $widget;
			new $widget_class;
		}
	}
}

// Initialize the class into nothing in order to run it and require all of
// the needed files
new ClientDash_RequireFiles();