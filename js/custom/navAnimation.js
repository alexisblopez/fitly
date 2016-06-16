/* navAnimation.js
// Last Revised By - Juan Sierra
// Last Revised Date - 6.13.16
// Animation for navigation bar
*/

$(document).ready(function(){
  $(document).on('scroll', function (e) {
    var scroll_pos = 0;
    var animation_begin = 10;
    var animation_end = 350;
    var alpha_begin = 0;
    var alpha_end = 1;
    var begin_color = new $.Color( 'rgba(255,255,255, 0)' );
    var end_color = new $.Color( 'rgba(255,255,255, 1)' ); ;
    $(window).scroll(function() {
        scroll_pos = $(this).scrollTop();
        console.log(scroll_pos);
        if(scroll_pos >= animation_begin && scroll_pos <= animation_end) {
            var percentScrolled = scroll_pos / (animation_end - animation_begin);
            var alpha = alpha_begin + ((alpha_end - alpha_begin) * percentScrolled);
            var newColor = new $.Color( 255, 255, 255, alpha);

            $('img').animate({'left':'50px'}, 1000);
            $('.navbar').css({'border-bottom': '3px solid #8becff'});
            $('.navbar').animate({'backgroundColor': newColor}, 0);
            $('.explore').animate({'opacity':'1'}, 'slow');
            $('.explore').css({'color':'black'}, 'slow');
            $('.get').animate({'opacity':'1'}, 'slow');
            $('.get').css({'border':'1px solid black'});
            $('.get').css({'color':'black'});

        }
        else if ( scroll_pos > animation_end ) {
             $('.navbar').animate({'backgroundColor': end_color }, 0);
        }
        else if ( scroll_pos < animation_begin) {
             $('.navbar').animate({'backgroundColor': begin_color }, 0);
             $('.navbar').css({'border-bottom': 'none'});
             $('.explore').css({'color':'white'});
             $('.get').css({'border':'1px solid white'});
             $('.get').css({'background-color':'white'});
        }
        else { }
      });
    });
  });
