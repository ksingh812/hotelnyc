$(document).ready(function () {


    var tn_array = $(".slides img").map(function () {
        return $(this).attr("src");
    }).get();

    $('#MainImage').attr('src', tn_array[0]);
    $('#Previous').css("visibility", "hidden");

    var lengthImages = tn_array.length;
    var CurrImage = 0;
    var widthImg = 200;
    var BottomLength = 4;
    var IndexDiff;

    $('.slides li img').click(function () {
        var Imagesrc = $(this).attr('src');
        var ImageIndex = $(this).parent('.slide').index();
           
        $('#MainImage').fadeOut('slow', function () {
            if (ImageIndex <= lengthImages - BottomLength) {
                IndexDiff = CurrImage;
                CurrImage = ImageIndex;
                IndexDiff = Math.abs(IndexDiff - CurrImage);
                $('#slider .slides').animate({ 'margin-left': '-=' + widthImg * IndexDiff }, 1000);
                $('#MainImage').attr('src', Imagesrc);

                if (ImageIndex != 0) {
                    if ($('#Previous').css("visibility") == "hidden") {
                        $('#Previous').css("visibility", "visible");
                    }
                }
                if (ImageIndex == lengthImages - BottomLength) {
                    if ($('#Next').css("visibility") == "visible") {
                        $('#Next').css("visibility", "hidden");
                    }
                }
            }
            else {
                $('#MainImage').attr('src', Imagesrc);
            }
            }).fadeIn(1000);
    });
    $('#Next').click(function () {
        
            $('#MainImage').fadeOut('slow', function () {
                CurrImage = CurrImage + 1; // Update current image index
                if (CurrImage <= lengthImages - BottomLength) {
                    $('#slider .slides').animate({ 'margin-left': '-=' + widthImg }, 1000); //animate left margin of the slides list with the value of -widthImg (-200px). So the bottom slider will animate to left side
                }
                $('#MainImage').attr('src', tn_array[CurrImage]); // set image to Main image
                if (CurrImage == lengthImages - BottomLength) {
                    $('#Next').css("visibility", "hidden");
                }
                if ($('#Previous').css("visibility") == "hidden") { // 
                    $('#Previous').css("visibility", "visible");
                }
            }).fadeIn(1000);
        
    });
    $('#Previous').click(function () {
        $('#MainImage').fadeOut('slow', function () {
            CurrImage = CurrImage - 1;
            $('#slider .slides').animate({ 'margin-left': '+=' + widthImg }, 1000);
            $('#MainImage').attr('src', tn_array[CurrImage]);
            if (CurrImage == 0) {
                $('#Previous').css("visibility", "hidden");
            }
            if ($('#Next').css("visibility") == "hidden") {
                $('#Next').css("visibility", "visible");
            }

        }).fadeIn(1000);
    });


    $('.slides li img').hover(function () {
        $(this).css('cursor', 'pointer');
        $(this).css({ 'filter': 'alpha(opacity=50)', 'opacity': '0.5' });
    }, function () {
        $(this).css('cursor', 'none');
        $(this).css({ 'filter': 'alpha(opacity=100)', 'opacity': '1' });
    });

    //var CurrSlides = 0;

    //setInterval(function () {
    //    $('#slider .slides').animate({ 'margin-left': '-=200' }, 1000,
    //        function () {
    //            CurrSlides = CurrSlides + 1;
    //            if (CurrSlides === tn_array.length-3) {
    //                //CurrSlides = 0;
    //                $('#slider .slides').css('margin-left', '600');
    //            }
    //        });
    //}, 3000);
});

