<?php

//Adding menu setting page
function my_settings_page_callback()
{
    ?>
    <div class="wrap">
        <h1>
            <?php echo esc_html(get_admin_page_title()); ?>
        </h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('my-settings-group');
            do_settings_sections('my-settings-page');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
<?php
}


function my_add_settings_page()
{
    add_options_page(
        'My Settings Page',
        'Slide Show Settings',
        'manage_options',
        'my-settings-page',
        'my_settings_page_callback'
    );
}
add_action('admin_menu', 'my_add_settings_page');



function my_add_settings_fields()
{

    register_setting(
        'my-settings-group',
        'my_text_field'
    );

    add_settings_section(
        'my-settings-section',
        'My Settings Section',
        '__return_false',
        'my-settings-page'
    );

    add_settings_field(
        'my_image_field',
        'My Image Field',
        'my_image_field_callback',
        'my-settings-page',
        'my-settings-section'
    );
}
add_action('admin_init', 'my_add_settings_fields');

function my_image_field_callback()
{
    $value = get_option('my_image_field');
    ?>
    <div class="my-image-field-wrapper">
    
        <div class="my-image-preview" style="display:flex;flex-wrap:wrap; justify-content:space-around; margin-bottom: 2rem;"onload="myFunction()">
            <?php  if ($value) {

            $images = explode(',', $value);

            foreach ($images as $image) { ?>
                <img src="<?php echo esc_url($image);?>" style=" width:400px; height:350px;  padding:1rem; "/>
            <?php } } ?>
        </div>

        <div class="my-image-inputs">
            <input type="text" id="my-image-url" name="my_image_field" value="<?php echo esc_attr($value); ?>"
                placeholder="Image URL" />
            <button class="button my-upload-button" type="button">Upload Image</button>
            <button class="button my-remove-button" type="button">Remove Image</button>
        </div>
   
    </div>
    <script defer>

        jQuery(function ($) {
            jQuery( ".my-image-preview" ).sortable({
                stop: function( event, ui ) 
                {
                    var imagesInOrder = $(".my-image-preview").sortable('toArray', { attribute: 'src' });
                    var allImagesSorted = imagesInOrder.join();
                    $('#my-image-url').val(allImagesSorted);
                }
            });
            jQuery(document).ready(function ($) {

                var mediaUploader;
                $('.my-upload-button').click(function (e) {
                    e.preventDefault();
                    if (mediaUploader) {
                        mediaUploader.open();
                        return;
                    }
                   // mediaUploader = wp.media.frames.file_frame = wp.media();
                    mediaUploader = wp.media({
                        title: 'Select an image',
                        button: {
                            text: 'Use this image'
                        },
                        multiple: true,
                        library: {
                            type: 'image'
                        }
                    });

                    mediaUploader.on('open', function() {
                        var selection = mediaUploader.state().get('selection');
                        var ids = $('#my-image-field').val();
                        if (ids) {
                            idsArray = ids.split(',');
                            idsArray.forEach(function(id) {
                            var attachment = wp.media.attachment(id);
                            selection.add(attachment ? [attachment] : []);
                            });
                        }
                        else {
                            selection.add(wp.media.attachment(wp.media.view.settings.post.id));
                        }
                    });
                    
                    mediaUploader.on('select', function () {
                        var allImagePaths="";
                        var allImagePreview = '';

                        var allAttachments = mediaUploader.state().get('selection').toJSON();
                        allAttachments.forEach( attachment =>{
                            
                            console.log(attachment.url);
                            allImagePaths += attachment.url + ",";
                            allImagePreview += '<img src="' + attachment.url + '"height="400px" width="350px" />';
                        });
                        allImagePaths = allImagePaths.slice(0,-1);


                        $('#my-image-url').val(allImagePaths);
                        $('.my-image-preview').html(allImagePreview);
                    });

                    mediaUploader.on('close', function(id){
                        var attachments = wp.media.query({
                        'post_type': 'attachment',
                        'post_status': 'inherit',
                        'posts_per_page': -1
                        }).more();

                    attachments.done(function() {
                        if (typeof attachments !== 'undefined' && Array.isArray(attachments)) {
                            var images = attachments.map(function(attachment) {
                            return attachment.toJSON();
                            });
                            console.log(images);
                        } else {
                            console.log('No attachments found');
                        }
                        });

                    })

                    mediaUploader.open();

                });

                $('.my-remove-button').click(function () {
                    $('#my-image-url').val('');
                    $('.my-image-preview').html('');
                });
            });

        });
    </script>
<?php
}



// Save the uploaded images to the database
function my_save_images() {

    if (isset($_POST['my_image_field'])) {
      $images = sanitize_text_field($_POST['my_image_field']);
      echo "<script> console.log($images);</script>";
      update_option('my_image_field', $images);
    }
    echo "<script> console.log('Outside the if');</script>";
  }
  add_action('add_option', 'my_save_images', 10, 3);
  




function my_enqueue_scripts()
{
    wp_enqueue_media();
    //wp_enqueue_script( 'my-script', plugins_url( 'my-script.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_enqueue_script('jquery');
}
add_action('admin_enqueue_scripts', 'my_enqueue_scripts');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////