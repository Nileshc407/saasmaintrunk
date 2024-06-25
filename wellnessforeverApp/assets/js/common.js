$(document).ready(function () {

      $("#sidebar").mCustomScrollbar({
        theme: "minimal"
      });

      $('#dismiss, .overlay').on('click', function () {
          $('#sidebar').removeClass('active');
          $('.overlay').hide(0);
      });

      $('#sidebarCollapse').on('click', function () {
          $('#sidebar').addClass('active');
          $('.overlay').show(0);
      });


      $('.homeSlide').slick({
        dots: true,
        infinite: true,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 3,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 1
            }
          },
          {
            breakpoint: 480,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 1
            }
          }
        ]
      });


      $('.brandHomeSlide').slick({
        autoplay: true,
        autoplaySpeed: 3000,
        speed: 3000,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        arrows: false
      });

      $('.howWorkSlide').slick({
        autoplay: true,
        autoplaySpeed: 3000,
        speed: 3000,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        arrows: false
      });

      $('#BirthDate input').datepicker({
      });



});










