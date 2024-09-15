

    // script.js
    document.addEventListener('DOMContentLoaded', function() {
        $('a.youtube-id').click(function(e) {
            e.preventDefault();
            let videoId  = $(this).attr('data-id');
            $('#youtube-video').attr('src', 'https://www.youtube.com/embed/'+videoId+'?autoplay=1');

            setTimeout(function () {
                $('#video-popup').fadeIn();
            }, 200);
        });

        $('.close-btn').on('click', function() {
            $('#video-popup').fadeOut();
            $('#youtube-video').attr('src', '');
        });

        $(window).on('click', function(e) {
            if ($(e.target).is('#videoPopup')) {
                $('#video-popup').fadeOut();
                $('#youtube-video').attr('src', '');
            }
        });

    });

    // Button go to top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 20) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });

    // Khi click vào sẽ cuộn lên đầu trang
    $('#back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 'slow');
        return false;
    });

    $(document).ready(function() {
        $('#jlcarousel-9721').carousel({
            //pause: true,
            interval: 2000,
        });
    });