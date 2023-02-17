<?php
function myslideshow_shortcode($atts) 
{ 
       

    // $output = '<div>';

    //     $value = get_option('my_image_field');
    //     ?>
        
    <!-- //       <div class="my-image-preview">
    //           <?php // if ($value) { 
  
    //             $images = explode(',', $value);
    
    //             foreach ($images as $image) { 
    
    //                 $output .= '<img src='.esc_url($image).' />';
    
    //             } 
    //         }
                
    //       $output .= "</div>";

    //       echo "<script></script>";



     $output = '<div class="slideshow-container">';

         $value = get_option('my_image_field');
         ?>
        
               <?php  if ($value) { 
  
                 $images = explode(',', $value);
                 
                 foreach ($images as $image) { 
                      if($image){
                        $output .= '<div class="mySlides fade"><img src='.esc_url($image).' width="650px" height="366px"/></div>';
                      }
    
                 } 
             }
                
           $output .= '<a class="prev" onclick="plusSlides(-1)">❮</a>
           <a class="next" onclick="plusSlides(1)">❯</a>
           
           </div>
           <br>
           
           <div style="text-align:center">
             <span class="dot" onclick="currentSlide(1)"></span> 
             <span class="dot" onclick="currentSlide(2)"></span> 
             <span class="dot" onclick="currentSlide(3)"></span> 
           </div>';
           


    // $output = '
    
    
    
    //   <div class="numbertext">1 / 3</div>
    //   <img src="img_nature_wide.jpg" style="width:100%">
    //   <div class="text">Caption Text</div>
    // </div>
    
    // <div class="mySlides fade">
    //   <div class="numbertext">2 / 3</div>
    //   <img src="img_snow_wide.jpg" style="width:100%">
    //   <div class="text">Caption Two</div>
    // </div>
    
    // <div class="mySlides fade">
    //   <div class="numbertext">3 / 3</div>
    //   <img src="img_mountains_wide.jpg" style="width:100%">
    //   <div class="text">Caption Three</div>
    // </div>
    
    // <a class="prev" onclick="plusSlides(-1)">❮</a>
    // <a class="next" onclick="plusSlides(1)">❯</a>
    
    // </div>
    // <br>
    
    // <div style="text-align:center">
    //   <span class="dot" onclick="currentSlide(1)"></span> 
    //   <span class="dot" onclick="currentSlide(2)"></span> 
    //   <span class="dot" onclick="currentSlide(3)"></span> 
    // </div>
    // ';

        return $output;

}
                


// Register shortcode
add_shortcode('myslideshow', 'myslideshow_shortcode'); 

function my_plugin_enqueue_styles1() {
  wp_enqueue_style( 'plugin-custom-style1', plugins_url( 'css/slideshow-custom-style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_styles1' );


function my_enqueue_scripts1() {
  wp_enqueue_script( 'my-slideshow1', plugin_dir_url( __FILE__ ) . 'js/slideshow-custom-script.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts1' );
