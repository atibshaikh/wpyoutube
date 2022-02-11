<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>


<div class="container">
  <div class="row p-3">
    <h1>General API For Youtube API Importer</h1>
    <hr>
  </div>
  <div class="row">
    <div class="col">
      <div class="alert alert-warning">
          <div class="alert alert-warning">
              <div class="top-form-field">
                  <h2 class="display-6">YouTube API Importer</h2>
                    <p class="lead">Use this section to save your API key and channel ID for video imports.</p>
                    <hr class="my-4">
                     <p>Need a YouTube Key generated? They're free! Get one here.</p>
                      <form method="post" action="options.php">
                        <?php
                        settings_fields( 'youtubeapicustomsettings' );
                        do_settings_sections( 'youtubeapicustomsettings' )
                        ?>
                        <div class="form-group">
                          <label for="youtubeAPIKey">YouTube API Key</label>
                          <input name="youtubeAPIKey" value="<?php echo get_option( 'youtubeAPIKey' ); ?>" type="text" class="form-control" id="youtubeapikey" placeholder="Your YouTube API Key">
                        </div>
                        <div class="form-group">
                          <label for="youtubeChannelID">Your YouTube Channel ID:</label>
                          <input type="text" name="youtubeChannelID" value="<?php echo get_option( 'youtubeChannelID' ); ?>" class="form-control" id="youtubeChannelID" placeholder="YouTube Channel ID">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
              </div>
          </div>
      </div>
    </div>
    <div class="col">
        <div class="alert alert-primary">
          <h1 class="display-4">Advertiser Settings</h1>
          <h3>Setup your advertiser settings below.</h3>
          <hr>
          <form method="post" action="options.php">
            <?php
              settings_fields( 'youtubeadvertise' );
              do_settings_sections( 'youtubeadvertise' )
            ?>
            <div class="form-group">
              <label for="adskipseconds">Skip AD After How Many Seconds</label>
              <input class="form-control" type="number" value="<?php echo get_option( 'adskipseconds' ); ?>" id="adskipseconds" name="adskipseconds">
            </div>
            <div class="form-group">
            <label for="advideo">Advertiser YouTube Video ID:</label>
            <input type="text" name="advideo" value="<?php echo get_option( 'advideo' ); ?>" class="form-control" id="advideo" placeholder="example: yKeolQxpcgQ">
            </div>
            <div class="form-group">
            <label for="adtitle">AD Title:</label>
            <input type="text" name="adtitle" value="<?php echo get_option( 'adtitle' ); ?>" class="form-control" id="adtitle" placeholder="">
            </div>
            <div class="form-group">
            <label for="adbodycopy">AD Body Copy:</label>
            <input type="text" name="adbodycopy" value="<?php echo get_option( 'adbodycopy' ); ?>" class="form-control" id="adbodycopy" placeholder="">
            </div>
            <div class="form-group">
            <label for="adbuttoncopy">AD Button Copy:</label>
            <input type="text" name="adbuttoncopy" value="<?php echo get_option( 'adbuttoncopy' ); ?>" class="form-control" id="adbuttoncopy" placeholder="">
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Save Advertiser Changes</button>
          </form>
        </div>
    </div>
    <div class="col">
      <div class="alert alert-success">
        <div class="top-form-field">
            <h2 class="display-6">Shortcode Information</h2>
              <p class="lead">Use this section to generate short code to show youtube video frontend</p>
              
              <h5>To output video simple please use this shortcode * [showyoutubevideo]</h5>
              <hr class="my-4">

              
              <form method="post" action="options.php">
                <?php 
                settings_fields( 'youtubeapicodesettings' );
                do_settings_sections( 'youtubeapicodesettings' )
              ?>
                <div class="form-group">
                  <label for="videoCount">No of Video to Show</label>
                  <input type="number" class="form-control" id="videoCount" name="videoCount" value="<?php echo get_option( 'videoCount' ); ?>" placeholder="">
                </div>
                <div class="form-group">
                  <label for="videoStyleType">Display Type</label>
                  <select class="form-control" id="videoStyleType" name="videoStyleType">
                    <option <?php if(get_option('videoStyleType') == 'Image Left'){ echo(' selected');} ?>>Image Left</option>
                    <option <?php if(get_option('videoStyleType') == 'Image Center'){ echo(' selected');} ?>>Image Center</option>
                    <option <?php if(get_option('videoStyleType') == 'Image Right'){ echo(' selected');} ?>>Image Right</option>

                    
                  </select>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">Save Settings</button>

                
              </form>
              
        </div>
      </div>
    </div>
  </div>
</div>

