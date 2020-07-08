
$(document).ready(function () {





    //Position Category

    $('.position_location').blur(function () {
        var id = $(this).data('id');
        var position =$(this).val();
        if(isNaN(position)){
            $('.message-error'+id).html('The position must be a number.').css('color','red')
        }else{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: changePositionLocation,
                type: "POST",
                data: {
                    id:id,
                    position:position
                },
                success: function (data) {
                    $('.message-error'+id).html('Saved').attr('style','color:green')
                }
            });
        }



    })

    //Reply Contact
    $('#replyContact').click(function () {

        var content=$('#content').val();
        var user_id=$('#user_id').val();
        var reply_id=$('#reply_id').val();
        var product_id=$('#product_id').val();
        if(content.trim()==''){
            alert('Please enter your content!!!');
        }else{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: replyContact,
                type: "POST",
                data: {
                    content:content,
                    user_id:user_id,
                    reply_id:reply_id,
                    product_id:product_id,
                },
                success: function (data) {
                    $('#message-box').append('<p style="text-align: right">'+content+'</p>');
                    $('#content').val('');
                    var objDiv = document.getElementById("message-box");
                    objDiv.scrollTop = objDiv.scrollHeight;
                }
            });
        }
    })


    //send message
    $('#sent').click(function () {
        var content=$('#content').val();
        var user_id=$('#user_id').val();
        var reply_id=$('#reply_id').val();
        if(content.trim()==''){
            alert('Please enter your content!!!');
        }else{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: sentMessageAdmin,
                type: "POST",
                data: {
                    content:content,
                    user_id:user_id,
                    reply_id:reply_id,
                },
                success: function (data) {
                    $('#message-box').append('<p style="text-align: right">'+content+'</p>');
                    $('#content').val('');
                    var objDiv = document.getElementById("message-box");
                    objDiv.scrollTop = objDiv.scrollHeight;
                }
            });
        }
    })


    //send new message from admin
    $('#sentNew').click(function () {
        var content=$('#contentNew').val();
        var user_id=$('#user_idNew').val();
        if(content.trim()==''){
            alert('Please enter your content!!!');
        }else{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: sentMessageAdminNew,
                type: "POST",
                data: {
                    content:content,
                    user_id:user_id,
                },
                success: function (data) {
                    window.location = "/admin/yourMessageDetail/"+user_id;
                }
            });
        }
    })


    // Slide

    $('.img').click(function () {
        var src=$(this).attr('src');
        $('.imgProd').attr('src',src);
    })

    //Set default language

    $(".setDefaultLang").click(function () {
        var id=$(this).data('id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: SetDefaultLang,
            type: "POST",
            data: {
                id: id
            },
            success: function (data) {
                // alert(id)
                $('#MessageUpdate').show()
                setInterval(function(){
                    $("#MessageUpdate").hide();
                },2000);
            }
        });


    });

    //Change message status
    $('.UpdateApprove').click(function () {
        var messId=$(this).data('id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: updateApproveMessage,
            type: "POST",
            data: {
                messId: messId
            },
            success: function (data) {
                $('#MessageUpdate').show()
                $('#'+messId).remove();
                $('.'+messId).append('<label disabled class="btn btn-disabled btn-sm btn-approve"></label>');
                $("#MessageUpdate").html('Update Successfully!!!');
                $('.status'+messId).html('Enabled');
                setInterval(function(){
                    $("#MessageUpdate").hide();
                },2000);
            }
        });

    });

    //Delete image
    $('.deleteImg').click(function (){
        if (confirm("Are you sure delete?")) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id=$(this).data("id");
            $.ajax({
                url: deleteImageProduct,
                type: "DELETE",
                data:  {id:id},
                success: function (data) {
                    $('#'+id+'').remove();
                }
            });
        }
        return false;
    })

    //Add images
    // $("#picture").change(function (event) {
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     var picture=$("#picture");
    //     var id=$(this).data("id");
    //
    //     $.ajax({
    //         url : addImage,
    //         type : "POST",
    //         data : {
    //             picture : picture,
    //             id : id,
    //         },
    //         success : function (data){
    //             event.preventDefault();
    //             var i = 1;
    //             if($("#placehere div").length){
    //                 i = $("#placehere div").length + 1;
    //             }
    //             let url = URL.createObjectURL(event.target.files[0]);
    //
    //             $('.product-img').append('' +
    //                 '<div class="img_area" id="new'+i+'">' +
    //                 '<img src="'+url+'" alt="Lights" class="img-product">' +
    //                 '<span data-id="new'+i+'" class="deleteImg">Delete</span>' +
    //                 '</div>'
    //             );
    //             deleteImg();
    //             return;
    //         }
    //     });
    //
    //
    // })
    //
    // function deleteImg () {
    //     $('.deleteImg').click(function () {
    //         var id = $(this).data("id");
    //         $('#' + id + '').remove();
    //     })
    //
    // }

    // change status product
    $("#approve").change(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var approve =$(this).val();
        var productId=$('#productId').val();
        $.ajax({
            url : updateApprove,
            type : "POST",
            data : {
                approve : approve,
                productId : productId,
            },
            success : function (data){
                $("#DefaulAr").hide();
                if(approve==1){
                    var lbAr='Enabled'
                }else{
                    var lbAr='Disabled';
                }
                $("#Ar_fields").html('<i  class="fa fa-check-square-o"></i> '+lbAr);
                $("#MessageUpdate").show();
                $("#MessageUpdate").html('Update Successfully!!!');
                setInterval(function(){
                    $("#MessageUpdate").hide();
                },1000);


            }
        });
    });


    // change status hot product
    $("#hot").change(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var hot =$(this).val();
        var productId=$('#productId').val();
        $.ajax({
            url : updateHot,
            type : "POST",
            data : {
                hot : hot,
                productId : productId,
            },
            success : function (data){
                $("#MessageUpdate").show();
                $("#MessageUpdate").html('Update Successfully!!!');
                setInterval(function(){
                    $("#MessageUpdate").hide();
                },2000);


            }
        });
    });



    // Quản lý translations

    // Cập nhật bản dịch

    $(".translations").change(function () {

        var id = $(this).data("id");
        var value = $(this).val();
        var locale = $(".locale" + id).val()
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/admin/updateTranslation',
            type: "POST",
            data: {id: id, value: value, locale: locale},
            success: function (data) {
                $('.save' + id).show();
                setInterval(function () {
                    $('.save' + id).hide();
                }, 2000);
            }
        });
    });


    //Danh sách keywords gợi ý (autocomplete)

    $('#search_keyword').keyup(function () {
        var query = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/admin/translations/autocomplete/fetch',
                method: "POST",
                data: {query: query},
                success: function (data) {
                    $('#keywordsList').fadeIn();
                    $('#keywordsList').html(data);
                }
            });

    });
    $(document).on('click', '.getKey', function () {
        $('#search_keyword').val($(this).text());
        $('#keywordsList').fadeOut();
        $("#submitSearch").trigger("click");
    });



    // Delete key

    $('.deleteKey').click(function () {

        if (confirm("Are you sure delete this item?")) {
            var id = $(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/admin/translations/deleteKey',
                type: "POST",
                data: {id: id},
                success: function (data) {
                    $('.tr_key' + id).hide();

                }
            });
        }
        return false;
    })


    //Update keyword

    $(".keyword").change(function (){
        var id = $(this).data('id');
        var value = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/admin/translations/updateKey',
            type: "POST",
            data: {id: id, value: value},
            success: function (data) {
                $('.save' + id).show();
                setInterval(function () {
                    $('.save' + id).hide();
                }, 2000);
            }
        });

    })

});
