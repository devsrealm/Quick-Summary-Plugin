# Quick Summary Plugin
A ClassicPress plugin that adds a meta box functionality to the post editor for a quick summary of a post.
## Installation
1. Go to your Dashboard
2. Hover over the *Plugin* section at the left hand side and select *Add New*
3. Click *Upload Plugin*
4. Choose Quick Summary Zip File and Select Install
5. When you are done uploading, Activate Plugin and Follow The Next Step Below

### Requirements
Requires at least Classicpress V1

### Usage
Goto any template part you would like to display the value of the quick summary field, be it a content, below your post title, under featured image, and if you prefer, above the sky ;)

Then, add this:

<div class="video-duration">
        <?php
        $video_duration   = get_post_meta( $post->ID, 'videolength_duration', true );
        if ( is_singular( get_post_type() ) && '' !== $video_duration) {
           ?> <span> <?php echo esc_html( $video_duration ); ?> </span> <?php
          } 
        else {
          echo '';}
        ?>
</div>

### Screenshots

Post Editor:

![Quick Summary Image](https://raw.githubusercontent.com/Horlaes/Quick-Summary-Plugin/master/screenshot/Quick-Summary-2.png)

Result:

![Quick Summary Image](https://raw.githubusercontent.com/Horlaes/Quick-Summary-Plugin/master/screenshot/Quick-Summary.png)

== Changelog ==
V1.0 - Inital Release
