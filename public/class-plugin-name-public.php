<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );

	}


	// hello world shortcode
	public function public_hello(){

		$mydays = get_option('mydays');

		echo "hello world -' .$mydays.'";
	}

	//show youtube video shortcode

	public function show_youtube_video(){

		$videoCount = get_option('videoCount');
		$videoStyleType = get_option('videoStyleType');
		$allWPVidPosts = get_posts( array('post_type' => 'youtube_videos', 'numberposts' => 2500, 'order' => 'ASC') );

		//some variable for load more functionality
		$numVids = count($allWPVidPosts); //tells us how many videos we have
		$eachSix = 0; //start a new batch of 6 grid videos
		$newGrid = 1; //keeps track of grid outputted into our page
		$newFirst = true; //tells us if this is the FIRST item in a grid

		if($numVids <= 6){
			echo '<div class="video-container container">';
				echo '<div class="row">';
				
				  //loop through and show all youtube videos
				  foreach ($allWPVidPosts as $eachpost){

				  	 $videoID =  $eachpost->videoID->videoId;
				    
				  	?>
				  		<div class="youtube-video-wrap col-md-4">
				  				
				  				<div class="video-img">
				  					<h3><?php echo get_the_title($eachpost->ID); ?></h3>
				  					<a href="http://localhost/pd/watch/?youvideoid=<?php echo $videoID; ?>&pageID=<?php echo $eachpost->ID; ?>" target="_blank"><img src="<?php echo $eachpost->imageresmed; ?>"></a>
				  				</div>
				  		</div>
				  	<?php

				  }
				

				echo '</div></div>';
		}else{


			?>
			<script type="text/javascript">
				
				var vidCount = 2;

				function showMoreVideos(){
					try{
						jQuery('#gridvid'+vidCount).fadeIn();
					} catch {

					}
					//up the counter
					vidCount = vidCount + 1;
				}

			</script>
			<?php

			//loop through and show all youtube videos
				  foreach ($allWPVidPosts as $eachpost){

				  	 $videoID =  $eachpost->videoID->videoId;

				  	 //this is a new set of videos so create a new HIDDEN grid container
						if ($eachSix == 0){
							if($newFirst == true){
								//this is the FIRST GRID CONTAINER being outputted
								echo ('<div class="video-container container"><div class="row">');
								$newFirst = false;
							} else {
								echo ('<div class="video-container container" style="display:none;" id="gridvid' . $newGrid . '"><div class="row">');
							}
						}

						?>
						<div class="youtube-video-wrap col-md-4">
				  				
				  				<div class="video-img">
				  					<h3><?php echo get_the_title($eachpost->ID); ?></h3>
				  					<a href="http://localhost/pd/watch/?youvideoid=<?php echo $videoID; ?>&pageID=<?php echo $eachpost->ID; ?>" target="_blank"><img src="<?php echo $eachpost->imageresmed; ?>"></a>
				  				</div>
				  		</div>
						<?php

						//update the eachsix
						$eachSix += 1;

						//check for eachsix being equal to 6
						if ($eachSix == 6){
							//we need to create a new container
							echo('</div></div>');
							$eachSix = 0;
							$newGrid += 1;
						}


			}
			


		}
		echo '</div></div>';
		echo '<center><button type="button" onclick="showMoreVideos()" class="btn btn-primary">Load more Videos</button></center>';
	}


	//show youtube video page
	public function show_youtube_video_single(){
		$youvideoid = '';
		$pageID = '';
		if(isset($_GET['youvideoid'])){
			$youvideoid = $_GET['youvideoid'];
		}

		if(isset($_GET['pageID'])){

			$pageID = $_GET['pageID'];

		}


		//check if id is emtpy or not

		if($youvideoid == ''){
			echo '<h2>No video to show</h2>';
		}else{

			?>

			<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
			
			<hr>

			<!-- JS Swapper -->
			<script>
				function skipper(){
					jQuery('#thetopvid').show();
					jQuery('#adunit').hide();
					// jQuery('#advid').attr("src", "about:blank");
				}
				 jQuery(document).ready(function() {
				 		
			          	jQuery('#thetopvid').hide();

			          	// setTimeout(function() {
						// 	jQuery('#thetopvid').fadeIn();}, 5000);

						// setTimeout(function() {
						// 	jQuery('#adunit').fadeOut();
						// 	jQuery('#advid').attr("src", "about:blank");
						// 	}, 5000);

						setTimeout(function() {
							jQuery('#theskip').show();}, 5000);

						
			       });

				

				

			</script>

			<div class="video-container container">
				<div class="video-ifram-wrap text-center">
					<div class="subscribe-now ">
						<script src="https://apis.google.com/js/platform.js"></script>
						<div class="g-ytsubscribe" data-channelid="UCugFS09zZmVIDKq4NxHJT-w" data-layout="full" data-count="hidden"></div>
					</div>

					<div id="adunit">
						<div class="add-row row align-items-center">
							<div class="col-md-8">
								<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo get_option('advideo');?>?control=1&autoplay=0&rel=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>		
							</div>
							<div class="col-md-4">
								<p><?php echo get_option( 'adtitle' ); ?></p>
								<hr>
								<p><?php echo get_option( 'adbodycopy' ); ?></p>
								<br>
								<a target="_blank" href="#"><button type="button"><?php echo get_option( 'adbuttoncopy' ); ?></button></a>
								<br>
								<br>
								<button type="button" style="display:none;" id="theskip" onclick="skipper()">SKIP AD</button>
							</div>
						</div>
					</div>

					<div id="thetopvid">
						<h1><?php echo get_the_title( $pageID );?></h1>
					   <iframe width="560px" height="315px" src="https://www.youtube.com/embed/<?php echo $youvideoid; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width:560px; height:315px;"></iframe>



					</div>
					
				</div>

				<div class="row">
					<h2>Checkout some other video</h2>
				</div>

				<div class="row">
					<?php 

						$allWPVidPosts = get_posts( array('post_type' => 'youtube_videos', 'numberposts' => 4, 'order' => 'ASC') );

						 foreach ($allWPVidPosts as $eachpost){

						  	 $videoID =  $eachpost->videoID->videoId;
						   		if($eachpost->ID == $pageID){
						   			//dont show current video
						   		} else{
						   			?>
								  		<div class="youtube-video-wrap col-md-4">
								  				
								  				<div class="video-img">
								  					<h3><?php echo get_the_title($eachpost->ID); ?></h3>
								  					<a href="http://localhost/pd/watch/?youvideoid=<?php echo $videoID; ?>&pageID=<?php echo $eachpost->ID; ?>" ><img src="<?php echo $eachpost->imageresmed; ?>"></a>
								  				</div>
								  		</div>
								  	<?php	
						   		}	
						  	

						  }
						

					?>
				</div>	

			</div>
			
			<?php
		}
	}

}


