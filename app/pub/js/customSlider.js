/*Slider*/
$(document).ready(function () {
    $('.slideItem').slick({
        arrows: false,
        dots: false,
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
    });
});


/*Authentication*/

$(function () {
    $('.SignUpOption').hide();
    $('.log').hide();

    $(document).on('click', '#enterLogin', function () {
        $('.sign').hide().css({"display": "0"});
        $('.rightOption').hide().css({"display": "none"});

        $('.d1').css({
            "left": "50%"
        });
        $('.d2').css({
            "right": "50%"
        });
        $('.log').css({"opacity": "100%"}).show();
        $('.SignUpOption').show().css({"opacity": "1"});

    });
    $(document).on('click', '#enterSignUp', function () {
        $('.sign').show().css({"opacity": "1"});
        $('.rightOption').show().css({"opacity": "1"});

        $('.d1').css({
            "left": "17%"
        });
        $('.d2').css({
            "right": "17%"
        });
        $('.log').css({"opacity": "1"}).hide();
        $('.SignUpOption').hide().css({"opacity": "1"});

    });
});

/*Update user data*/
$(function () {
    $('.changePassword').hide();
    $('.changeEmail').hide();
    $('.beAdmin').hide();
    $('.user_Attributes').hide();
    //  $('#changeEmail').hide();   // popup.classList.toggle("show");

    $(document).on('click', '.newPassword', function () {
        $('.changePassword').show();
        $('.changeEmail').hide();
        $('.beAdmin').hide();
        $('.user_Attributes').hide();
    });
    $(document).on('click', '.newEmail', function () {

        $('.changeEmail').show();
        $('.changePassword').hide();
        $('.beAdmin').hide();
        $('.user_Attributes').hide();

    });
    $(document).on('click', '.becomeAdmin', function () {
        $('.changePassword').hide();
        $('.changeEmail').hide();
        $('.user_Attributes').hide();
        $('.beAdmin').show();
    });
    $(document).on('click', '.newUserAttr', function () {
        $('.changePassword').hide();
        $('.changeEmail').hide();
        $('.user_Attributes').show();
        $('.beAdmin').hide();
    });
    $(document).on('click', '.close', function () {
        $('.changePassword').hide();
        $('.changeEmail').hide();
        $('.beAdmin').hide();
        $('.user_Attributes').hide();
    });
});

/*Add product type*/
$(function () {
    $("#itemType").on("change", function () {
        $(".itemType").hide();
        switch ($(this).val()) {
            case "DVD":
                $("#typeDVD").show();
                break;
            case "Book":
                $("#typeBook").show();
                break;
            case "Furniture":
                $("#typeFurniture").show();
                break;
        }
    })
});

