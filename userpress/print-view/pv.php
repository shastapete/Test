<?php

class up546E_PrintView
{
	const VERSION = '0.1';
	private $plugin_name = 'Print View';
	private $plugin_slug = 'print-view';
	private $options;

	public function __construct()
	{
		add_action( 'template_redirect', array( $this, 'getTemplate' ), 5 );
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
	}




	public function getTemplate()
	{
		if ( $this->checkPrintTemplate() ) {
			include( plugin_dir_path( __FILE__ ) . 'print.php' );
			exit();
		}
		
		if ( $this->checkModalTemplate() ) {
			include( plugin_dir_path( __FILE__ ) . 'modal.php' );
			exit();
		}
	}

	private function checkPrintTemplate()
	{
		return isset( $_GET['view'] ) && $_GET['view'] == "print";
	}

	private function checkModalTemplate()
	{
		return isset( $_GET['view'] ) && $_GET['view'] == "modal";
	}

	public function activate( $network_wide )
	{
		$data = array(
			'plugin_name' => $this->plugin_name,
			'version' => self::VERSION,
			'url' => get_home_url(),
			'sitename' => get_option( 'blogname' )
		);

	}
}

new up546E_PrintView;

function up546E_PrintView_link()
{
	$print_view = new up546E_PrintView;
}