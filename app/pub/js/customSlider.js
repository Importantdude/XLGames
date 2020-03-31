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
/*$(function () {
    $(document).on('click', '#deleteButton', function () {
        $('form').attr('action', 'test');
    });
});*/
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
