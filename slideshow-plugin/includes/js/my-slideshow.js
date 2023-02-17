jQuery(document).ready(function($) {
    $('.my-slideshow').slideshow({
        delay: 3000,
        speed: 1000,
        effect: 'fade',
        autoplay: true,
        pauseOnHover: true,
    });
});

export function executeScript(){
    $('.my-slideshow').slideshow({
        delay: 3000,
        speed: 1000,
        effect: 'fade',
        autoplay: true,
        pauseOnHover: true,
    }); 
}
