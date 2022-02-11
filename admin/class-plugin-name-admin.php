<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Admin {

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

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );
		
		if(isset($_REQUEST['page'])){
			if($_REQUEST['page'] == 'youtube-api-setting' || $_REQUEST['page'] == 'sub-importer'){
				wp_enqueue_style( 'bootstrapcss', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
			}
		}
		
		


	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'bootstrapjs', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );


	}

	/**
	 * Add our Custom menu
	 *
	 * @since    1.0.0
	 */

	public function my_admin_menu(){

		add_menu_page( 'New Plugin Settings', 'Youtube API Setting', 'manage_options', 'youtube-api-setting', array($this,'my_plugin_admin_page'), 'dashicons-tickets', 250 );
		add_submenu_page( 'youtube-api-setting', 'Youtube API Importer', 'Youtube API Importer', 'manage_options', 'sub-importer', array($this,'my_plugin_admin_subpage') );

	}

	public function my_plugin_admin_page(){
		require_once 'partials/plugin-name-admin-display.php';
	}

	public function my_plugin_admin_subpage(){
		
		require_once 'partials/sub-menu-page.php';

	}


	/**
	 * Register Custom field for plugin setting
	 *
	 * @since    1.0.0
	 */

	public function register_my_plugin_general_setting(){
		//register all setting for general setting

		register_setting( 'youtubeapicustomsettings', 'youtubeAPIKey' );
		register_setting( 'youtubeapicustomsettings', 'youtubeChannelID' );
		
	}

	

	/**
	 * Register Custom field for plugin setting
	 *
	 * @since    1.0.0
	 */

	public function register_my_plugin_code_setting(){
		//register all setting for general setting

		register_setting( 'youtubeapicodesettings', 'videoCount' );
		register_setting( 'youtubeapicodesettings', 'videoStyleType' );
		
	}

	public function register_my_plugin_advertiser_setting(){
		//register all setting advertiser setting

		register_setting( 'youtubeadvertise', 'advideo' );
		register_setting( 'youtubeadvertise', 'adtitle' );
		register_setting( 'youtubeadvertise', 'adbodycopy' );
		register_setting( 'youtubeadvertise', 'adbuttoncopy' );
		register_setting( 'youtubeadvertise', 'adskipseconds' );
		
		
	}



	//create custom post type for videos
	public function custom_youtube_videos(){

		/**
	 * Post Type: Products.
	 */

	$labels = [
		"name" => __( "Youtube Videos", "twentytwentyone" ),
		"singular_name" => __( "Youtube Video", "twentytwentyone" ),
	];

	$args = [
		"label" => __( "Youtube Videos", "twentytwentyone" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "slug" => "youtube_videos", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "comments", "revision" ],
		"show_in_graphql" => false,
	];

	register_post_type( "youtube_videos", $args );

	}



	//admin function for cron job
	public function update_youtube_video(){

		//first get all the posts
	  $allWPVidPosts = get_posts( array('post_type' => 'youtube_videos', 'numberposts' => 2500, 'order' => 'ASC') );
	  $compvids = '';

	  //first check if there are any videos to update
	  if (count($allWPVidPosts) == 0){
	    //echo('<h2>There are no videos so click IMPORT first.</h2>');
	  } else{

	    //we know we have videos so CYCLE THEM
	    foreach ($allWPVidPosts as $eachpost){

		      if($eachpost->videoID->videoId == ''){
		        //do nothing
		      } else {
		        //this is a video
		        $compvids = ',' . $compvids . $eachpost->videoID->videoId . ',';
		        
		      }
	    }

	    //echo ($compvids . '<br><br>');

	    //NOW call in the new videos and compare
	    $theyoutubekey = get_option( 'youtubeAPIKey' );
	    $thechannelid = get_option( 'youtubeChannelID' );

	    $videoList = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$thechannelid.'&maxResults='.'6'.'&key='.$theyoutubekey.''));
	    
	    
	    //sort through the items and add anything thats new
	    foreach($videoList->items as $item){
	      //determine if we already have this video
	      $videxists = strpos($compvids , $item->id->videoId);

	      //check to see if this video exists
	      if ($videxists > 0) {

	        //echo ('found' . $videxists . '<br>');

	      } else {

	        	//add the video because IT WAS NOT FOUND IN OUR DATABASE STRING
	          //INSERT A NEW POST VIDEO
		      $data = array(
		        'post_title' => $item->snippet->title,
		        'post_content' => $item->snippet->description,
		        'post_status' => 'publish',
		        'post_type' => 'youtube_videos'
		      );

		      //insert this post into the DB and RETRIEVE the ID
		      $result = wp_insert_post( $data );
		      //echo ($results);

				      //capture the ID of the post
				      if ( $result && ! is_wp_error( $result ) ) {
				        $thenewpostID = $result;
				        //add the youtube meta data
				        add_post_meta( $thenewpostID, 'videoID', $item->id);
				        add_post_meta( $thenewpostID, 'publishedAt', $item->snippet->publishedAt);
				        add_post_meta( $thenewpostID, 'channelId', $item->snippet->channelId);
				        add_post_meta( $thenewpostID, 'ytitle', $item->snippet->title);
				        add_post_meta( $thenewpostID, 'ydescription', $item->snippet->description);
				        add_post_meta( $thenewpostID, 'imageresmed', $item->snippet->thumbnails->medium->url);
				        add_post_meta( $thenewpostID, 'imagereshigh', $item->snippet->thumbnails->high->url);

				       

				      }

		      }
	    }


	  }
	}
}


