document.documentElement.classList.add('js');
                          /// ----------------------------
                          const $rootSingle = $('.cSlider--single');
                          const $rootNav = $('.cSlider--nav');

                           $rootSingle.slick({
                            slide: '.cSlider__item',
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            arrows: true,
                            fade: true,
                            lazyLoad: 'ondemand',
                            infinite: false,
                            cssEase: 'linear',
                           });

                           $rootNav.on('init', function(event, slick) {
                              $(this).find('.slick-slide.slick-current').addClass('is-active');
                            })
                            .slick({
                              slide: '.cSlider__item',
                              slidesToShow: 4,
                              slidesToScroll: 1,
                              dots: false,
                              focusOnSelect: false,
                              infinite: false,
                              responsive: [{
                                breakpoint: 1024,
                                settings: {
                                  slidesToShow: 4,
                                  slidesToScroll: 1,
                                }
                              }, {
                                breakpoint: 640,
                                settings: {
                                  slidesToShow: 2,
                                  slidesToScroll: 1,
                                }
                              }, {
                                breakpoint: 420,
                                settings: {
                                  slidesToShow: 2,
                                  slidesToScroll: 1,
                              }
                              }]
                            });

                           $rootSingle.on('afterChange', function(event, slick, currentSlide) {
                            $rootNav.slick('slickGoTo', currentSlide);
                            $rootNav.find('.slick-slide.is-active').removeClass('is-active');
                            $rootNav.find('.slick-slide[data-slick-index="' + currentSlide + '"]').addClass('is-active');
                           });

                           $rootNav.on('click', '.slick-slide', function(event) {
                            event.preventDefault();
                            var goToSingleSlide = $(this).data('slick-index');

                             $rootSingle.slick('slickGoTo', goToSingleSlide);
                           });