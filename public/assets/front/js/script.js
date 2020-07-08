$(function () {
    $('#bx-slider').bxSlider({
        mode: 'fade',
        captions: true,
        slideWidth: 600
    });
});

$(document).ready(function () {


    //Menu mobile
    $('.nav_profile').on('click', function (e) {
        e.preventDefault();
        $(".side-categories").slideToggle();
    });
    $('.list_lang').on('click', function (e) {
        e.preventDefault();
        $(".lang_area").slideToggle();
    });




    // Slide

    $('.img').click(function () {
        var src=$(this).attr('src');
        $('.imgProd').attr('src',src);
    })

    //Change status product

    $('.status').click(function () {
        var id = $(this).data('id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: updateStatusProduct,
            type: "POST",
            data: {
                id: id,
            },
            success: function (data) {
            }
        });

    })



    //reply message from admin
    var i = 1;
    $('#send_admin').click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var content = $('#content_mess_admin').val();
        var id_admin = $('#id_admin').val();
        var reply_id = $('#reply_id').val();
        $.ajax({
            url: replyMessageAdmin,
            type: "POST",
            data: {
                content: content,
                id_admin: id_admin,
                reply_id: reply_id,
            },
            success: function (data) {
                i++;
                $('#dynamic_field').append('<p colspan="2" align="right" id="row' + i + '">' + content + '</p>');
                $('#content_mess_admin').val('');
                var objDiv = document.getElementById("dynamic_field");
                objDiv.scrollTop = objDiv.scrollHeight;
            }
        });

        return false;
    });

    //tap imgae
    // $(".image_area").click(function() {
    //
    //     $('#title_placehere').remove();
    //     $("#img_source").trigger('click');
    // });

    //add image

    //     $('#add_img').click(function (ev){
    //         ev.preventDefault();
    //         $("#img_source").trigger('click');
    //
    //         return false;
    //     });
    //
    //     $("#img_source").change(function (event) {
    //
    //         event.preventDefault();
    //         var i = 1;
    //         if($("#placehere div").length){
    //             i = $("#placehere div").length + 1;
    //         }
    //
    //         let url = URL.createObjectURL(event.target.files[0]);
    //         $('.product-img').append('' +
    //             '<div class="img_area" id="new'+i+'">' +
    //             '<img src="'+url+'" alt="Lights" class="img-product">' +
    //             '<span data-id="new'+i+'" class="deleteImg">Delete</span>' +
    //             '</div>'
    //         );
    //         deleteImg();
    //         return;
    //
    //     });
    //
    // function deleteImg () {
    //     $('.deleteImg').click(function () {
    //         var id = $(this).data("id");
    //         $('#' + id + '').remove();
    //     })
    //
    // }

    $('.deleteImg').click(function () {
        if (confirm("Are you sure delete?")) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = $(this).data("id");
            $.ajax({
                url: deleteImageProduct,
                type: "DELETE",
                data: {id: id},
                success: function (data) {
                    $('#' + id + '').remove();
                }
            });
        }
    })






});
