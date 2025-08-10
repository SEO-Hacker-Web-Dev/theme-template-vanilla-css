function setEqualHeightForSection(sectionSelector, secondSelector, groupSizeBreakpoints) {
    var elementsToResize = $(sectionSelector).find(secondSelector);
    elementsToResize.css('height', 'auto'); // Reset height to auto first

    var windowWidth = $(window).width();
    var groupSize = 1; // default

    // Use provided breakpoints or fallback to defaults
    var breakpoints = groupSizeBreakpoints || [
        { min: 1200, size: 5 },
        { min: 992, size: 4 },
        { min: 768, size: 3 },
        { min: 480, size: 2 },
        { min: 0, size: 1 }
    ];

    for (var b = 0; b < breakpoints.length; b++) {
        if (windowWidth >= breakpoints[b].min) {
            groupSize = breakpoints[b].size;
            break;
        }
    }

    for (var i = 0; i < elementsToResize.length; i += groupSize) {
        var tallestHeight = 0;
        var group = elementsToResize.slice(i, i + groupSize);

        group.each(function () {
            var height = $(this).outerHeight();
            if (height > tallestHeight) {
                tallestHeight = height;
            }
        });

        group.height(tallestHeight);
    }
}

$(document).ready(function () {
    $(window).on('load', function () {

    });

    $('img[loading="lazy"]').each(function () {
        var $img = $(this);
        var originalSrc = $img.attr('data-src') || $img.attr('src');
        if (originalSrc) {
            function setImageSource(imgElem, src) {
                $(imgElem).attr('src', src);
            }

            if ('IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function (entries, observer) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            var img = entry.target;
                            setImageSource(img, originalSrc);
                            observer.unobserve(img);
                        }
                    });
                });
                observer.observe(this);
            } else {
                setImageSource($img, originalSrc);
            }
            $img.on('load', function () {
                var width = $img.width();
                var height = $img.height();
                $img.attr({
                    'width': width,
                    'height': height
                });
            }).attr({
                'data-src': originalSrc,
                'decoding': 'async'
            });
        }
    });

    setEqualHeightForSection('section.blogs,section.core_programs', 'h3', [
        { min: 1200, size: 4 },
        { min: 992, size: 3 },
        { min: 768, size: 2 },
        { min: 0, size: 1 }
    ]);


    // // Alert if page has missing H1
    // if ($('h1').length === 0) {
    //     alert('Warning: This page is missing an <h1> tag.');
    // }

    // // Alert if page has duplicated H1
    // if ($('h1').length > 1) {
    //     alert('Warning: This page has duplicated <h1> tags.');
    // }

    // // Alert if page has duplicated H2
    // if ($('h2').length > 1) {
    //     alert('Warning: This page has duplicated <h2> tags.');
    // }

    // // Alert if there are broken images
    // $('img').each(function () {
    //     var img = this;
    //     // Only check if not already errored
    //     $(img).one('error', function () {
    //         alert('Warning: Broken image detected: ' + $(img).attr('src'));
    //     });
    //     // For cached images, trigger error if already broken
    //     if (img.complete && typeof img.naturalWidth !== "undefined" && img.naturalWidth === 0) {
    //         $(img).trigger('error');
    //     }
    // });

    // $(window).on('scroll', function () {
    //     if ($(window).scrollTop() > 0) {
    //         $('#mainNavbar').removeClass('fixed-top');
    //     } else {
    //         $('#mainNavbar').addClass('fixed-top');
    //     }
    // });

    var $header = $("header#mainHeader");
    var $toggle = $("button#navbarToggle");

    // Handle toggle click
    $toggle.click(function (e) {
        e.preventDefault();
        $header.toggleClass("menu-open"); // Add a state-tracking class

        updateHeaderBackground();
    });

    // Handle scroll
    window.addEventListener('scroll', updateHeaderBackground);

    // Central function for managing background state
    function updateHeaderBackground() {
        var scrolled = window.scrollY > 0;
        var isMenuOpen = $header.hasClass("menu-open");

        if (scrolled || isMenuOpen) {
            $header.addClass("bg-black");
        } else {
            $header.removeClass("bg-black");
        }
    }



    var interactiveSelectors = 'a, button, input, textarea, select, [tabindex]';
    var tabIndexCounter = 0;
    $(interactiveSelectors).each(function () {
        // Only add tabindex if element is visible and not disabled
        var $el = $(this);
        if ($el.is(':visible') && !$el.is(':disabled')) {
            $el.attr('tabindex', tabIndexCounter++);
        }
    });

    $("#closeButton").click(function (e) {
        var $video = $("#dialog video, #dialog iframe");
        $video.each(function () {
            // For <video> tags
            if (this.tagName.toLowerCase() === "video") {
                this.pause();
                this.currentTime = 0;
            }
            // For <iframe> (e.g., YouTube/Vimeo embeds)
            if (this.tagName.toLowerCase() === "iframe") {
                var src = $(this).attr("src");
                $(this).attr("src", src); // Reloads the iframe to stop playback
            }
        });
    });


});