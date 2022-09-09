$(document).ready(function () {

    var formData = new FormData()

    $(document).on('click', '#getMoreTransactions', function (event) {
        var offset = $(this).attr('data-offset');
        var user = $(this).attr('data-user');
        var image = $('.transactions-image').attr('src');
        var buttonClicked = this;
        console.log(offset);
        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/getTransactions?page=' + offset,
            data: {user_id: user, offset: offset, _token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
            if (response.data.length > 0) {
                response.data.forEach(function (e) {
                    $('#coin-transaction-list').append(
                        $('<li/>').append(
                            // $('<div/>', {'class': 'user-img'}).append(
                            //     $('<img/>', {'class': 'transactions-image', 'src': image})
                            // ),
                            $('<div/>', {'class': 'description'}).append(
                                $('<div/>', {'class': 'text'}).append(
                                    $('<div/>', {'class': e.type == 'CREDIT' ? 'text-green' : 'text-red'}, {'class': 'title'}).append(
                                        e.type == 'CREDIT' ? 'Received ' + e.amount + ' ' + e.coin + ' coins' : 'Spent ' + e.amount + ' ' + e.coin + ' coins'
                                    ),
                                    $('<p/>', {'class': 'text-gray font-12'}).append(
                                        e.source
                                    )
                                ),
                                $('<div/>', {'class': 'info text-gray w-auto'}).append(
                                    e.created_at.split('T')[0] + ' ' + e.created_at.split('T')[1].split('.')[0],
                                )
                            )
                        )
                    );
                });

                $(buttonClicked).attr('data-offset', parseInt(offset) + 1);
            } else {
                $(buttonClicked).val('No More Data');
            }
        });
    });
    // $(document).on('click', '#getMoreActivities', function(event){
    //     var offset = $(this).attr('data-offset');
    //     var user = $(this).attr('data-user');
    //     var image = $('.transactions-image').attr('src');
    //     var buttonClicked = this;
    //     console.log(offset);
    //     $.ajax({
    //         method: "POST",
    //         url: window.location.origin+'/admin/manage/users/getActivities?page='+offset,
    //         data: {user_id: user, offset: offset, _token: $('meta[name="csrf_token"]').attr('content')}
    //     }).done(function(response){
    //         if(response.data.length > 0){
    //             response.data.forEach(function(e){
    //                 $('#user-activities-list').append(
    //                     $('<li/>').append(
    //                         $('<div/>', {'class' : 'user-img'}).append(
    //                             $('<img/>', {'class' : 'transactions-image', 'src' : image})
    //                         ),
    //                         $('<div/>', {'class' : 'description'}).append(
    //                             $('<div/>', {'class' : 'text'}).append(
    //                                 $('<div/>', {'class' : e.type == 'CREDIT' ? 'text-green' : 'text-red'}, {'class' : 'title'}).append(
    //                                     e.type == 'CREDIT' ? 'Received ' + e.amount + ' ' + e.coin + ' coins' : 'Spent ' + e.amount + ' ' + e.coin + ' coins'
    //                                 ),
    //                                 $('<p/>', {'class' : 'text-gray font-12'}).append(
    //                                     e.source
    //                                 )
    //                             ),
    //                             $('<div/>', {'class' : 'info text-gray'}).append(
    //                                 e.created_at.split('T')[0] + ' ' +  e.created_at.split('T')[1].split('.')[0]
    //                             )
    //
    //                         )
    //                     )
    //                 );
    //             });
    //
    //             $(buttonClicked).attr('data-offset', parseInt(offset)+1);
    //         }else{
    //             $(buttonClicked).val('No More Data');
    //         }
    //     });
    // });
    $(document).on('click', '#getMoreGoldCoinTransactions', function (event) {
        var offset = $(this).attr('data-offset');
        var user = $(this).attr('data-user');
        var image = $('.transactions-image').attr('src');
        var buttonClicked = this;
        var flag = false;
        console.log(offset);
        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/get/gold/transactions?page=' + offset,
            data: {user_id: user, offset: offset, _token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
            if (response.data.length > 0) {
                response.data.forEach(function (e) {

                    $('#gold-coin-transaction-list').append(
                        $('<li/>').append(
                            // $('<div/>', {'class': 'user-img'}).append(
                            //     $('<img/>', {'class': 'transactions-image', 'src': image})
                            // ),
                            $('<div/>', {'class': 'description'}).append(
                                $('<div/>', {'class': 'text'}).append(
                                    $('<div/>', {'class': e.type == 'CREDIT' ? 'text-green' : 'text-red'}, {'class': 'title'}).append(
                                        e.type == 'CREDIT' ? 'Received ' + e.amount + ' ' + e.coin + ' coins' : 'Spent ' + e.amount + ' ' + e.coin + ' coins'
                                    ),
                                    $('<p/>', {'class': 'text-gray font-12'}).append(
                                        e.source
                                    )
                                ),
                                $('<div/>', {'class': 'info text-gray w-auto'}).append(
                                    e.created_at.split('T')[0] + ' ' + e.created_at.split('T')[1].split('.')[0]
                                )
                            )
                        )
                    );
                });
                $(buttonClicked).attr('data-offset', parseInt(offset) + 1);
            } else {
                $(buttonClicked).val('No More Data');
            }
        });
    });
    $(document).on('click', '#getMoreSilverCoinTransactions', function (event) {
        var offset = $(this).attr('data-offset');
        var user = $(this).attr('data-user');
        var image = $('.transactions-image').attr('src');
        var buttonClicked = this;
        var flag = false;
        console.log(offset);
        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/get/silver/transactions?page=' + offset,
            data: {user_id: user, offset: offset, _token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
            if (response.data.length > 0) {
                response.data.forEach(function (e) {
                    $('#silver-coin-transaction-list').append(
                        $('<li/>').append(
                            // $('<div/>', {'class': 'user-img'}).append(
                            //     $('<img/>', {'class': 'transactions-image', 'src': image})
                            // ),
                            $('<div/>', {'class': 'description'}).append(
                                $('<div/>', {'class': 'text'}).append(
                                    $('<div/>', {'class': e.type == 'CREDIT' ? 'text-green' : 'text-red'}, {'class': 'title'}).append(
                                        e.type == 'CREDIT' ? 'Received ' + e.amount + ' ' + e.coin + ' coins' : 'Spent ' + e.amount + ' ' + e.coin + ' coins'
                                    ),
                                    $('<p/>', {'class': 'text-gray font-12'}).append(
                                        e.source
                                    )
                                ),
                                $('<div/>', {'class': 'info text-gray w-auto'}).append(
                                    e.created_at.split('T')[0] + ' ' + e.created_at.split('T')[1].split('.')[0]
                                )
                            )
                        )
                    );
                });
                $(buttonClicked).attr('data-offset', parseInt(offset) + 1);
            } else {
                $(buttonClicked).val('No More Data');
            }
        });
    });
    $(document).on('click', '#getMoreReferGoldCoinTransactions', function (event) {
        var offset = $(this).attr('data-offset');
        var user = $(this).attr('data-user');
        var image = $('.transactions-image').attr('src');
        var buttonClicked = this;
        var flag = false;
        console.log(offset);
        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/get/referral/gold/transactions?page=' + offset,
            data: {user_id: user, offset: offset, _token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
            if (response.data.length > 0) {
                response.data.forEach(function (e) {
                    $('#refer-gold-coin-transaction-list').append(
                        $('<li/>').append(
                            // $('<div/>', {'class': 'user-img'}).append(
                            //     $('<img/>', {'class': 'transactions-image', 'src': image})
                            // ),
                            $('<div/>', {'class': 'description'}).append(
                                $('<div/>', {'class': 'text'}).append(
                                    $('<div/>', {'class': e.type == 'CREDIT' ? 'text-green' : 'text-red'}, {'class': 'title'}).append(
                                        e.type == 'CREDIT' ? 'Received ' + e.amount + ' ' + e.coin + ' coins' : 'Spent ' + e.amount + ' ' + e.coin + ' coins'
                                    ),
                                    $('<p/>', {'class': 'text-gray font-12'}).append(
                                        e.source
                                    )
                                ),
                                $('<div/>', {'class': 'info text-gray w-auto'}).append(
                                    e.created_at.split('T')[0] + ' ' + e.created_at.split('T')[1].split('.')[0]
                                )
                            )
                        )
                    );
                });

                $(buttonClicked).attr('data-offset', parseInt(offset) + 1);
            } else {
                $(buttonClicked).val('No More Data');
            }
        });
    });
    // $(document).on('click', '#getMoreSilverCoinTransactions', function(event){
    //     var offset = $(this).attr('data-offset');
    //     var user = $(this).attr('data-user');
    //     var image = $('.transactions-image').attr('src');
    //     var buttonClicked = this;
    //     var flag=false;
    //     console.log(offset);
    //     $.ajax({
    //         method: "POST",
    //         url: window.location.origin+'/admin/manage/users/getTransactions?page='+offset,
    //         data: {user_id: user, offset: offset, _token: $('meta[name="csrf_token"]').attr('content')}
    //     }).done(function(response){
    //         if(response.data.length > 0){
    //             response.data.forEach(function(e){
    //
    //                 if(e.coin=='Silver' ){
    //                     flag=true;
    //                     $('#silver-coin-transaction-list').append(
    //                         $('<li/>').append(
    //                             $('<div/>', {'class' : 'user-img'}).append(
    //                                 $('<img/>', {'class' : 'transactions-image', 'src' : image})
    //                             ),
    //                             $('<div/>', {'class' : 'description'}).append(
    //                                 $('<div/>', {'class' : 'text'}).append(
    //                                     $('<div/>', {'class' : e.type == 'CREDIT' ? 'text-green' : 'text-red'}, {'class' : 'title'}).append(
    //                                         e.type == 'CREDIT' ? 'Received ' + e.amount + ' ' + e.coin + ' coins' : 'Spent ' + e.amount + ' ' + e.coin + ' coins'
    //                                     ),
    //                                     $('<p/>', {'class' : 'text-gray font-12'}).append(
    //                                         e.source
    //                                     )
    //                                 ),
    //                                 $('<div/>', {'class' : 'info text-gray'}).append(
    //                                     e.created_at.split('T')[0] + ' ' +  e.created_at.split('T')[1].split('.')[0]
    //                                 )
    //
    //                             )
    //                         )
    //                     );
    //                 }
    //
    //             });
    //
    //             if(flag==true){
    //                 $(buttonClicked).attr('data-offset', parseInt(offset)+1);
    //             }else{
    //                 $(buttonClicked).val('No More Data');
    //             }
    //         }else{
    //             $(buttonClicked).val('No More Data');
    //         }
    //     });
    // });
    $(document).on('click', '#getMoreReferSilverCoinTransactions', function (event) {
        var offset = $(this).attr('data-offset');
        var user = $(this).attr('data-user');
        var image = $('.transactions-image').attr('src');
        var buttonClicked = this;
        var flag = false;
        console.log(offset);
        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/get/referral/silver/transactions?page=' + offset,
            data: {user_id: user, offset: offset, _token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
            if (response.data.length > 0) {
                response.data.forEach(function (e) {
                    $('#refer-silver-coin-transaction-list').append(
                        $('<li/>').append(
                            // $('<div/>', {'class': 'user-img'}).append(
                            //     $('<img/>', {'class': 'transactions-image', 'src': image})
                            // ),
                            $('<div/>', {'class': 'description'}).append(
                                $('<div/>', {'class': 'text'}).append(
                                    $('<div/>', {'class': e.type == 'CREDIT' ? 'text-green' : 'text-red'}, {'class': 'title'}).append(
                                        e.type == 'CREDIT' ? 'Received ' + e.amount + ' ' + e.coin + ' coins' : 'Spent ' + e.amount + ' ' + e.coin + ' coins'
                                    ),
                                    $('<p/>', {'class': 'text-gray font-12'}).append(
                                        e.source
                                    )
                                ),
                                $('<div/>', {'class': 'info text-gray w-auto'}).append(
                                    e.created_at.split('T')[0] + ' ' + e.created_at.split('T')[1].split('.')[0]
                                )
                            )
                        )
                    );
                });
                $(buttonClicked).attr('data-offset', parseInt(offset) + 1);
            } else {
                $(buttonClicked).val('No More Data');
            }
        });
    });
    $(document).on('change', '.media_search', function (event) {
        var user_id = $(this).parent().parent().attr('data-user');
        var media_type = $('#media_type').val();
        // var is_private = $('#is_private').val();
        var media_status = $('#media_status').val();

        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/getMedia',
            data: {
                user_id: user_id,
                media_type: media_type,
                media_status: media_status,
                _token: $('meta[name="csrf_token"]').attr('content')
            }

        }).done(function (response) {

            $('#user_media').empty();
            if (response.data.length > 0) {
                response.data.forEach(function (e) {
                    var media_type;
                    var deleted_at;
                    if (e.media_type == 'Photo') {
                        media_type =
                            $('<div/>', {'class': 'img-box radius-10'}).append(
                                $('<img>', {src: response.media_url + e.name})
                            )
                    } else {
                        media_type =
                            $('<div/>', {
                                'class': 'img-box radius-10',
                                onclick: 'lightbox_open("' + response.media_url + e.name + '")'
                            }).append(
                                $('<div/>', {'class': 'icon-box'}).append(
                                    $('<i/>', {'class': 'fas fa-play-circle'})
                                ),
                                $('<video/>', {
                                    // onclick: 'lightbox_open("' + response.media_url + e.name + '")',
                                    preload: 'metadata'
                                }).append(
                                    $('<source>', {src: response.media_url + e.name, type: 'video/mp4'}),
                                    $('<source>', {src: response.media_url + e.name, type: 'video/ogg'}),
                                    'Your browser does not support the video tag.',
                                )
                            )
                    }
                    if (e.deleted_at == null) {
                        deleted_at = $('<a/>', {href: '', 'class': 'delete_media', 'data-media': e.id}).append(
                            'Delete media'
                        )
                    } else {
                        deleted_at = $('<a/>', {href: '', 'class': 'restore_media', 'data-media': e.id}).append(
                            'Restore media'
                        )
                    }

                    $('#user_media').append(
                        $('<tr/>').append(
                            $('<td/>').append(
                                media_type,
                            ),
                            $('<td/>').append(
                                $('<span/>', {'class': 'badge bg-info'}).append(
                                    e.media_type,
                                )
                            ),
                            $('<td/>').append(
                                e.created_at,
                            ),
                            $('<td/>').append(
                                e.is_private == 1 ? 'Private' : 'Public',
                            ),
                            $('<td/>', {'class': 'media_status'}).append(
                                e.deleted_at == null ? 'Live' : 'Deleted'
                            ),
                            $('<td/>').append(
                                $('<div/>', {'class': 'dropdown'}).append(
                                    $('<button>', {
                                        'class': 'btn dropdown-toggle',
                                        type: 'button',
                                        'data-bs-toggle': 'dropdown'
                                    }).append(
                                        $('<i/>', {'class': 'fas fa-ellipsis-v'})
                                    ),
                                    $('<ul/>', {'class': 'dropdown-menu'}).append(
                                        $('<li/>').append(
                                            deleted_at,
                                        )
                                    )
                                )
                            ),
                        )
                    );
                });
            } else {
                $('#user_media').append(
                    ' No Media Found'
                )

            }
        });
    });


    $('.deleteOfferItem').on('click', function (event) {
        event.preventDefault();
        var item = $(this).attr('data-item');
        $('#deleteOfferItem').modal('show');
        $('#offerItem').val(item);
    });

    $(document).on('click', '.edit-offer-item', function (event) {
        event.preventDefault();
        var offer_id = $(this).attr('data-offer_id');
        var consumable_id = $(this).attr('data-consumable_id');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/offers/edit/item/' + consumable_id + '/' + offer_id,

        }).done(function (response) {
            $('#editOfferItem').empty();
            $('#editOfferItem').append(
                response
            )
            $('#editOfferItemModal').modal('show')
        })
    });


    //media
    $(document).on('click', '.delete_media', function (event) {
        event.preventDefault();

        var media = $(this).attr('data-media');
        var element = event.target;
        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/media/delete',
            data: {media_id: media, _token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
            if (response == 1) {
                $(element).parent().parent().parent().parent().prev().html('Deleted');
                $(element).html('Restore media');
                $(element).removeClass('delete_media');
                $(element).addClass('restore_media');
                toastr["success"]("Media Deleted successfully");
            } else {
                toastr["error"]("Unable to find Media");
            }
        })

    });

    $(document).on('click', '.restore_media', function (event) {
        event.preventDefault();

        var media = $(this).attr('data-media');
        var element = this;
        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/media/restore',
            data: {media_id: media, _token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {

            if (response == 1) {
                $(element).parent().parent().parent().parent().prev().html('Live');
                $(element).html('Delete media');
                $(element).removeClass('restore_media');
                $(element).addClass('delete_media');
                toastr["success"]("Media Restored successfully");
            } else {
                toastr["error"]("Unable to find Media");
            }
        })

    });

    $(document).on('click', '.delete-user-account', function (event) {
        event.preventDefault();

        var user = $(this).attr('data-user');
        var element = this;
        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/delete',
            data: {user_id: user, _token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {

            if (response == 1) {
                $(element).parent().parent().parent().parent().prev().html('Live');
                $(element).html('Delete media');
                $(element).removeClass('restore_media');
                $(element).addClass('delete_media');
                toastr["success"]("Media Restored successfully");
            } else {
                toastr["error"]("Unable to find Media");
            }
        })

    });


    $('#passwordChangeBtn').on('click', function (event) {
        event.preventDefault();
        var user = $(this).attr('data-user');
        var password = $('#password').val();
        var confirm_password = $('#password_confirmation').val();

        if (password == '' || password == undefined) {
            toastr["error"]("Please enter password");
            return;
        } else if (password.length < 8) {
            toastr["error"]("Password should be of minimum 8 characters");
            return;
        } else if (confirm_password == '' || confirm_password == undefined) {
            toastr["error"]("Password confirmation is required");
            return;
        } else if (password != confirm_password) {
            toastr["error"]("Your password does not match with your confirmation password");
            return;
        }

        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/profile/changePassword',
            data: {
                user_id: user,
                password: password,
                password_confirmation: confirm_password,
                _token: $('meta[name="csrf_token"]').attr('content')
            }
        }).done(function (response) {

            if (response.ResponseCode == 1) {
                toastr["success"]("Password Changed successfully");
                $('#changePassword').modal('hide');
            }
        })
    });

    $('#deleteUserAccountBtn').on('click', function (event) {
        event.preventDefault();
        var user = $(this).attr('data-user');

        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/delete',
            data: {user_id: user, _token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
                toastr["success"]("Account deleted successfully");
                $('#deleteAccount').modal('hide');
                var table = $('.yajra-datatable').DataTable();
                table.ajax.reload();
        })

    });

    $('#recoverUserAccountBtn').on('click', function (event) {
        event.preventDefault();
        var user = $(this).attr('data-user');

        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/recover',
            data: {user_id: user, _token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {

            if (response == 1) {
                toastr["success"]("Account Recover successfully");
                $('#recoverUser').modal('hide');
                var table = $('.yajra-datatable').DataTable();
                table.ajax.reload();
            }
        })

    });

    $('#banUserBtn').on('click', function (event) {
        event.preventDefault();
        var userBannedData = new FormData()
        var user = $(this).attr('data-user');
        var time = $('#ban_for_time').val();
        if (time) {
            userBannedData.append('time', time)
        } else {
            userBannedData.append('banned_forever', 0)
        }
        userBannedData.append('action', 1)
        userBannedData.append('user_id', user)

        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/ban',
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            data: userBannedData
        }).done(function (response) {

            if (response == 1) {
                toastr["success"]("Account Banned successfully");
                // $('#banUserModalBtn').parent().html('<a id="banUserModalBtn"  href="#" data-bs-toggle="modal" data-bs-target="#UnbannUser">UnBan user</a>');
                $('#bannUser').modal('hide');
                var table = $('.yajra-datatable').DataTable();
                table.ajax.reload();
            }
        })

    });


    $('#unBanUserBtn').on('click', function (event) {
        event.preventDefault();
        var user = $(this).attr('data-user');
        var action = 0;
        var time = '000000';
        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/ban',
            data: {user_id: user, time: time, action: action, _token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {

            if (response == 1) {
                toastr["success"]("Account UnBanned successfully");
                $('#banUserModalBtn').parent().html('<a id="banUserModalBtn"  href="#" data-bs-toggle="modal" data-bs-target="#bannUser">Ban user</a>');
                $('#UnbannUser').modal('hide');
                var table = $('.yajra-datatable').DataTable();
                table.ajax.reload();
            }
        })

    });

    $('#addUserImage').change(function () {
        var fileData = $('#addUserImage').prop('files')[0];
        if (fileData.type.includes('image')) {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#userUpdateProfilePic').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            toastr.error('file Must be Image')
            document.getElementById('addUserImage').value = '';
        }
    });


    $('#updateUserProfile').on('submit', function (event) {
        event.preventDefault()

        const form = document.querySelector('#updateUserProfile');
        const data = Object.fromEntries(new FormData(form).entries());
        formData.append('id', data.id)
        formData.append('name', data.name)
        formData.append('email', data.email)
        formData.append('phone', data.phone)
        formData.append('gender_id', data.gender_id)
        formData.append('religion_id', data.religion_id)
        formData.append('country_id', data.country_id)
        formData.append('language_id', data.language_id)
        formData.append('university', data.university)
        formData.append('passion', data.passion)
        formData.append('bio', data.bio)
        formData.append('interested_in', data.interested_in)
        formData.append('file', data.file)
        formData.append('filter_radius', data.filter_radius)
        formData.append('filter_gender', data.filter_gender)
        formData.append('data1', data.data1)
        formData.append('data2', data.data2)
        formData.append('filter_all_world', data.filter_all_world ?? 0)
        formData.append('filter_purpose', data.filter_purpose)
        formData.append('filter_religion', data.filter_religion)
        formData.append('filter_my_country', data.filter_my_country ?? 0)
        formData.append('filter_same_languge', data.filter_same_languge ?? 0)
        formData.append('setting_sound', data.setting_sound ?? 0)
        formData.append('setting_vibration', data.setting_vibration ?? 0)
        formData.append('setting_light_mode', data.setting_light_mode ?? 0)
        formData.append('setting_is_paused', data.setting_is_paused ?? 0)
        formData.append('setting_sound_on_notification', data.setting_sound_on_notification ?? 0)
        formData.append('discovery_be_invisible', data.discovery_be_invisible ?? 0)
        formData.append('discovery_my_language', data.discovery_my_language ?? 0)
        formData.append('discovery_world_wide_boost', data.discovery_world_wide_boost ?? 0)
        formData.append('discover_boost_radius', data.discover_boost_radius ?? 0)

        $('#editUserAccount').modal('show')
    });

    $(document).on('click', '#updateUserProfileBtn', function (event) {
        event.preventDefault();

        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/manage/users/updateProfile',
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            data: formData
        }).done(function (response) {

            if (response.ResponseCode == 1) {
                toastr["success"]("User Profile Updated Successfully");
                $('#editUserAccount').modal('hide')
            }
        })

    });
    // $('#addcredits').on('submit', function(event){
    //     event.preventDefault()
    //
    //     const form = document.querySelector('#addCreditToUser');
    //     const data = Object.fromEntries(new FormData(form).entries());
    //     console.log(data)
    //     console.log(data.userId)
    //     console.log(data.coins)
    //     $.ajax({
    //         method: "POST",
    //         url: window.location.origin+'/admin/manage/users/add/credit',
    //         data:{userId:data.userId,coinsType:data.coinsType,coins:data.coins,_token: $('meta[name="csrf_token"]').attr('content')}
    //     }).done(function(response){
    //         toastr["success"]("Credit added Successfully");
    //         $('#addcredits').modal('hide')
    //     })
    // });


    $(document).on('click', '.live_profile', function (event) {
        event.preventDefault();
        var user = $(this).attr('data-user');

        $('#user').val(user);

        $('#user_live_profile').submit();

    });


    $('.save').on('click', function (event) {
        var url = "updateSubscriptionsSettings";
        saveSettings(url, this);
    });

    $('.save-coin-settings').on('click', function (event) {
        var url = "updateCoinSettings";
        saveSettings(url, this);
    });
    $('.search_distance').on('click', function (event) {
        var url = "updateSubscriptionsSettings";
        saveSearchDistanceSettings(url, this);
    });

    function saveSearchDistanceSettings(url, element) {
        inputs = $(element).parent().prev().find('select');
        jsonObj = [];
        console.log(inputs)
        for (var i = 0; i < inputs.length; i++) {
            var item = {};
            item['name'] = $(inputs[i]).attr('name');
            item['value'] = $(inputs[i]).val();

            jsonObj.push(item);
        }
        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/app/settings/' + url,
            data: {_token: $('meta[name="csrf_token"]').attr('content'), items: jsonObj}

        }).done(function (response) {
            console.log(response);
            if (response == 1) {
                toastr["success"]("Settings Updated Successfully");
            }
        })
    }

    function saveSettings(url, element) {
        inputs = $(element).parent().prev().find('input');
        jsonObj = [];
        console.log(inputs)
        for (var i = 0; i < inputs.length; i++) {
            var item = {};
            item['name'] = $(inputs[i]).attr('name');
            item['value'] = $(inputs[i]).val();

            jsonObj.push(item);
        }

        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/app/settings/' + url,
            data: {_token: $('meta[name="csrf_token"]').attr('content'), items: jsonObj}

        }).done(function (response) {
            console.log(response);
            if (response == 1) {
                toastr["success"]("Settings Updated Successfully");
            }
        })
    }

    $('.AVA_IOS').on('click', function (event) {
        versionControl('AVA_IOS', $('#AVA_IOS_value1').val(),$('#AVA_IOS_value2').val());
    });
    $('.AVA_ANDROID').on('click', function (event) {
        versionControl('AVA_ANDROID', $('#AVA_ANDROID_value1').val(),$('#AVA_ANDROID_value2').val());
    });

    function versionControl(shortcode,value1,value2) {

        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/version/control/save',
            data: {_token: $('meta[name="csrf_token"]').attr('content'), shortcode: shortcode,value1:value1,value2:value2}

        }).done(function (response) {
            console.log(response);
            if (response == 1) {
                toastr["success"]("App Version Updated Successfully");
            }
        })
    }


    $('.save-shop-settings').on('click', function (event) {

        inputs = $(this).parent().parent().prev().find('input');
        console.log(inputs)
        jsonObj = [];

        for (var i = 0; i < inputs.length; i += 2) {
            var item = {};
            item['quantity'] = $(inputs[i]).val();
            item['price'] = $(inputs[i + 1]).val();
            item['id'] = $(inputs[i]).attr('data-item');

            jsonObj.push(item);
        }

        $.ajax({
            method: "POST",
            url: window.location.origin + '/admin/shop/update',
            data: {items: jsonObj, _token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
            if (response == 1) {
                toastr["success"]("Settings Updated Successfully");
            }
        })

    });

    $(document).on('click', '.edit-giftInvitation', function (event) {
        event.preventDefault();
        var giftInvitation = $(this).attr('data-giftInvitation');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/giftInvitation/edit/' + giftInvitation,

        }).done(function (response) {
            $('#editGiftInvitation').empty();
            $('#editGiftInvitation').append(
                response
            )
            $('#editGiftInvitationModal').modal('show')
        })
    });

    $(document).on('click', '.delete-gift', function (event) {
        event.preventDefault();
        var gift = $(this).attr('data-gift');

        $('#gift').val(gift);

        $('#deleteGift').modal('show');
    });
    $(document).on('click', '.edit-word', function (event) {
        event.preventDefault();
        var dictionary = $(this).attr('data-dictionary');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/dictionary/edit/' + dictionary,

        }).done(function (response) {
            $('#editWord').empty();
            $('#editWord').append(
                response
            )
            $('#editWordModal').modal('show')
        })
    });
    $(document).on('click', '.deleteWord', function (event) {
        event.preventDefault();
        var word = $(this).attr('data-word');

        $('#word').val(word);

        $('#deleteWord').modal('show');
    });
    $(document).on('click', '.edit-status', function (event) {
        event.preventDefault();
        var status = $(this).attr('data-status');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/status/edit/' + status,

        }).done(function (response) {
            $('#editStatus').empty();
            $('#editStatus').append(
                response
            )
            $('#editStatusModal').modal('show')
        })
    });
    $(document).on('click', '.edit-looking', function (event) {
        event.preventDefault();
        var looking = $(this).attr('data-looking');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/looking/for/edit/' + looking,

        }).done(function (response) {
            $('#editLooking').empty();
            $('#editLooking').append(
                response
            )
            $('#editLookingModal').modal('show')
        })
    });
    $(document).on('click', '.delete-looking', function (event) {
        event.preventDefault();
        var looking = $(this).attr('data-looking');

        $('#lookingFor').val(looking);

        $('#deleteLookingFor').modal('show');
    });

    $(document).on('click', '.edit-emoji', function (event) {
        event.preventDefault();
        var emoji = $(this).attr('data-emoji');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/emoji/edit/' + emoji,
            data: {_token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
            console.log(response);
            $('#emojiId').val(emoji);
            $('#emojiName').val(response.data.name);
            document.getElementById('emojiIcon').src = response.icon_url + response.data.icon
            // $('#emojiIcon').img(response.data.icon);
            $('#editEmoji').modal('show');
        })
    });


    $(document).on('click', '.delete-emoji', function (event) {
        event.preventDefault();
        var emoji = $(this).attr('data-emoji');

        $('#emoji').val(emoji);

        $('#deleteEmoji').modal('show');
    });

    $(document).on('click', '.edit-country', function (event) {
        event.preventDefault();
        var country = $(this).attr('data-country');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/countries/edit/' + country,

        }).done(function (response) {
            $('#editCountry').empty();
            $('#editCountry').append(
                response
            )
            $('#editCountryModal').modal('show')
        })
    });
    $(document).on('click', '.delete-country', function (event) {
        event.preventDefault();
        var country = $(this).attr('data-country');
        $('#country').val(country);
        $('#deleteCountry').modal('show');
    });
    $(document).on('click', '.edit-religion', function (event) {
        event.preventDefault();
        var religion = $(this).attr('data-religion');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/religions/edit/' + religion,

        }).done(function (response) {
            $('#editReligion').empty();
            $('#editReligion').append(
                response
            )
            $('#editReligionModal').modal('show')
        })
    });
    $(document).on('click', '.delete-religion', function (event) {
        event.preventDefault();
        var religion = $(this).attr('data-religion');
        $('#religion').val(religion);
        $('#deleteReligion').modal('show');
    });
    $(document).on('click', '.edit-language', function (event) {
        event.preventDefault();
        var language = $(this).attr('data-language');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/languages/edit/' + language,

        }).done(function (response) {
            $('#editLanguage').empty();
            $('#editLanguage').append(
                response
            )
            $('#editLanguageModal').modal('show')
        })
    });
    $(document).on('click', '.edit-response-messages', function (event) {
        event.preventDefault();
        var responseMessages = $(this).attr('data-response-messages');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/response/messages/edit/' + responseMessages,

        }).done(function (response) {
            $('#editLanguage').empty();
            $('#editLanguage').append(
                response
            )
            $('#editLanguageModal').modal('show')
        })
    });
    $(document).on('click', '.delete-language', function (event) {
        event.preventDefault();
        var language = $(this).attr('data-language');
        $('#language').val(language);
        $('#deleteLanguage').modal('show');
    });
    $(document).on('click', '.edit-lang', function (event) {
        event.preventDefault();
        var lang = $(this).attr('data-lang');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/app/translated/languages/edit/' + lang,
        }).done(function (response) {
            $('#editLanguage').empty();
            $('#editLanguage').append(
                response
            )
            $('#addLang').modal('show')
            // $('#editLanguageModal').modal('show')
        })
    });
    $(document).on('click', '.delete-lang', function (event) {
        event.preventDefault();
        var language = $(this).attr('data-lang');
        $('#language').val(language);
        $('#deleteLanguage').modal('show');
    });
    $(document).on('click', '.enable-lang', function (event) {
        event.preventDefault();
        var lang = $(this).attr('data-lang');
        $('#enableLang').val(lang);
        $('#enableLangModal').modal('show');
    });
    $(document).on('click', '.disable-lang', function (event) {
        event.preventDefault();
        var lang = $(this).attr('data-lang');
        $('#disableLang').val(lang);
        $('#disableLangModal').modal('show');
    });
    $(document).on('click', '.Edit-tip', function (event) {
        event.preventDefault();
        var tip = $(this).attr('data-tip');
        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/safety/edit/' + tip,
            data: {_token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
            $('#EditTipModal').empty();
            $('#EditTipModal').append(
                response
            )
            $('#EditTip').modal('show')
        })
    });

    $(document).on('click', '.delete-tip', function (event) {
        event.preventDefault();
        var tip = $(this).attr('data-tip');
        $('#tip').val(tip);

        $('#deleteTip').modal('show');
    });

    $(document).on('click', '.change_password', function (event) {
        event.preventDefault();
        var user = $(this).attr('data-user');
        $('#passwordChangeBtn').attr("data-user", user); //setter
        $('#changePassword').modal('show')

    });
    $(document).on('click', '.delete_user', function (event) {
        event.preventDefault();
        var user = $(this).attr('data-user');
        $('#deleteUserAccountBtn').attr("data-user", user); //setter
        $('#deleteAccount').modal('show')
    });
    $(document).on('click', '.ban_user', function (event) {
        event.preventDefault();
        var user = $(this).attr('data-user');
        $("#ban_for_time").prop('disabled', false); //disable
        $('#banned_forever').value = 1;
        $('#banned_forever').not(this).prop('checked', this.checked);
        $('#banUserBtn').attr("data-user", user); //setter
        $('#bannUser').modal('show')
    });
    $(document).on('click', '.unBan_user', function (event) {
        event.preventDefault();
        var user = $(this).attr('data-user');
        $('#unBanUserBtn').attr("data-user", user); //setter
        $('#UnbannUser').modal('show')
    });
    $(document).on('click', '.recover_user', function (event) {
        event.preventDefault();
        var user = $(this).attr('data-user');
        $('#recoverUserAccountBtn').attr("data-user", user); //setter
        $('#recoverUser').modal('show')
    });
    $(document).on('click', '.delete-faqType', function (event) {
        event.preventDefault();
        var faqType = $(this).attr('data-faqType');
        $('#faqType').attr('value', faqType);

        $('#deleteFaqtype').modal('show')
    });
    $(document).on('click', '.delete-faq', function (event) {
        event.preventDefault();
        var faq = $(this).attr('data-faq');
        $('#faq').attr('value', faq);
        $('#deleteFaq').modal('show')
    });
    $(document).on('click', '.edit-faq', function (event) {
        event.preventDefault();
        var faq = $(this).attr('data-faq');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/faqs/edit/' + faq,
            data: {_token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
            $('#FaqModelEdit').empty();
            $('#FaqModelEdit').append(
                response
            )
            $('#EditFaq').modal('show')
        })
    });
    $(document).on('click', '.edit-faqType', function (event) {
        event.preventDefault();
        var faq = $(this).attr('data-faqType');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/faqs/type/edit/' + faq,
            data: {_token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
            $('#FaqModelEdit').empty();
            $('#FaqModelEdit').append(
                response
            )
            $('#EditFaq').modal('show')
        })
    });
    $(document).on('click', '.delete-otherApp-company', function (event) {
        event.preventDefault();
        var company = $(this).attr('data-company');
        $('#company_id').attr('value', company);
        $('#deleteCompany').modal('show')
    });
    $(document).on('click', '.edit-otherApp-company', function (event) {
        event.preventDefault();
        var company = $(this).attr('data-company');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/other/apps/companies/edit/' + company,
        }).done(function (response) {
            $('#editCompanyModal').empty();
            $('#editCompanyModal').append(
                response
            )
            $('#editCompany').modal('show')
        })
    });
    $(document).on('click', '.delete-OtherApp', function (event) {
        event.preventDefault();
        var OtherApp = $(this).attr('data-OtherApp');
        $('#OtherApp').attr('value', OtherApp);
        $('#deleteOtherApp').modal('show')
    });
    $(document).on('click', '.edit-OtherApp', function (event) {
        event.preventDefault();
        var OtherApp = $(this).attr('data-OtherApp');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/otherApps/edit/' + OtherApp,
            // data: {_token: $('meta[name="csrf_token"]').attr('content')}
        }).done(function (response) {
            $('#OtherAppModelEdit').empty();
            $('#OtherAppModelEdit').append(
                response
            )
            $('#EditOtherApp').modal('show')
        })
    });

    $(document).on('click', '.approvedWithdrawal', function (event) {
        event.preventDefault();
        var withdrawal = $(this).attr('data-withdrawal');
        $('#withdrawalApprovedBtn').attr("value", withdrawal); //setter
        $('#withdrawalApproved').modal('show')
    });
    $(document).on('click', '.decclinedWithdrawal', function (event) {
        event.preventDefault();
        var withdrawal = $(this).attr('data-withdrawal');
        $('#withdrawalDeclinedBtn').attr("value", withdrawal); //setter
        $('#withdrawalDeclined').modal('show')
    });
    $(document).on('click', '.pendingWithdrawal', function (event) {
        event.preventDefault();
        var withdrawal = $(this).attr('data-withdrawal');
        $('#withdrawalPendingBtm').attr("value", withdrawal); //setter
        $('#withdrawalPending').modal('show')
    });
    $(document).on('click', '.delete-badge', function (event) {
        event.preventDefault();
        var badge = $(this).attr('data-badge');
        $('#badge').attr('value', badge);
        $('#deleteBadge').modal('show')
    });
    $(document).on('click', '.edit-badge', function (event) {
        event.preventDefault();
        var badge = $(this).attr('data-badge');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/badges/edit/' + badge,
        }).done(function (response) {
            $('#BadgeModelEdit').empty();
            $('#BadgeModelEdit').append(
                response
            )
            $('#EditBadge').modal('show')
        })
    });
    $(document).on('click', '.edit-permissions-display-name', function (event) {
        event.preventDefault();
        var permission = $(this).attr('data-permission');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/permissions/edit/' + permission,
        }).done(function (response) {
            $('#editPermission').empty();
            $('#editPermission').append(
                response
            )
            $('#editPermissionmodal').modal('show')
        })
    });
    $(document).on('click', '.delete-company', function (event) {
        event.preventDefault();
        var company = $(this).attr('data-company');
        $('#company_id').attr('value', company);
        $('#deleteCompany').modal('show')
    });
    $(document).on('click', '.edit-company', function (event) {
        event.preventDefault();
        var company = $(this).attr('data-company');

        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/crowdfunding/edit/' + company,
        }).done(function (response) {
            $('#editCompanyModal').empty();
            $('#editCompanyModal').append(
                response
            )
            $('#editCompany').modal('show')
        })
    });
    $(document).on('click', '.delete-companyVoucher', function (event) {
        event.preventDefault();
        var voucher = $(this).attr('data-companyVoucher');
        $('#voucher_id').attr('value', voucher);
        $('#deleteCompanyVoucher').modal('show')
    });
    $(document).on('click', '.delete-Roles', function (event) {
        event.preventDefault();
        var role = $(this).attr('data-roles');
        $('#roles').attr('value', role);
        $('#deleteRoles').modal('show')
    });
    $(document).on('click', '.shop-add', function (event) {
        event.preventDefault();
        var shop_type = $(this).attr('data-shop');
        $('#shop_type').attr('value', shop_type);
        $('#shopAdd').modal('show')
    });

    $(document).on('click', '.shopRemove', function (event) {
        event.preventDefault();
        var shop = $(this).attr('data-shop');
        $(this).parent().closest(".row").remove();
        $.ajax({
            method: "GET",
            url: window.location.origin + '/admin/shop/remove/' + shop,
        }).done(function (response) {
            toastr.success('Deleted successfully')
        })
    });

    $('input[type=number]').on('keypress', function (event) {

        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });


    $('input[type=file]').on('change', function (event) {
        const file = this.files[0];
        const fileType = file['type'];
        const validImageTypes = ['image/png', 'image/jpeg',];
        if (!validImageTypes.includes(fileType)) {
            this.value = ''
            toastr.error('Only png/jpeg images are acceptable')
        }
    });
    // $('#file').on('change', function (event) {
    //
    //     console.log('file upload');
    //     const file = this.files[0];
    //     const  fileType = file['type'];
    //     const validImageTypes = ['image/png', 'image/jpeg',];
    //     if (!validImageTypes.includes(fileType)) {
    //         this.value=''
    //         toastr.error('Only png/jpeg images are acceptable')
    //     }
    // });

});

$("#all-permissions").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
});
$("#dashboard").click(function () {
    $('.dashboard').not(this).prop('checked', this.checked);
});

$("#App-Users").click(function () {
    $('.app-users').not(this).prop('checked', this.checked);
});

$("#Shops").click(function () {
    $('.shops').not(this).prop('checked', this.checked);
});

$("#Badges").click(function () {
    $('.badges').not(this).prop('checked', this.checked);
});

$("#Offers").click(function () {
    $('.offers').not(this).prop('checked', this.checked);
});

$("#purchases").click(function () {
    $('.purchases').not(this).prop('checked', this.checked);
});

$("#setting").click(function () {
    $('.setting').not(this).prop('checked', this.checked);
});

$("#Subscriptions").click(function () {
    $('.Subscriptions').not(this).prop('checked', this.checked);
});

$("#AppSetting").click(function () {
    $('.AppSetting').not(this).prop('checked', this.checked);
});

$("#CoinsSetting").click(function () {
    $('.CoinsSetting').not(this).prop('checked', this.checked);
});
$("#Dictionary").click(function () {
    $('.Dictionary').not(this).prop('checked', this.checked);
});
$("#Emoji").click(function () {
    $('.Emoji').not(this).prop('checked', this.checked);
});
$("#SafetyTips").click(function () {
    $('.SafetyTips').not(this).prop('checked', this.checked);
});
$("#Countries").click(function () {
    $('.countries').not(this).prop('checked', this.checked);
});
$("#Religion").click(function () {
    $('.religion').not(this).prop('checked', this.checked);
});
$("#Language").click(function () {
    $('.language').not(this).prop('checked', this.checked);
});
$("#User-status").click(function () {
    $('.User-status').not(this).prop('checked', this.checked);
});
$("#Lookingfor").click(function () {
    $('.Lookingfor').not(this).prop('checked', this.checked);
});
$("#giftInvitations").click(function () {
    $('.giftInvitations').not(this).prop('checked', this.checked);
});
$("#Faqs").click(function () {
    $('.Faqs').not(this).prop('checked', this.checked);
});
$("#Crowdfunding").click(function () {
    $('.Crowdfunding').not(this).prop('checked', this.checked);
});
$("#OtherApp").click(function () {
    $('.OtherApp').not(this).prop('checked', this.checked);
});
$("#withdrawal").click(function () {
    $('.withdrawal').not(this).prop('checked', this.checked);
});
$("#SupportEmail").click(function () {
    $('.SupportEmail').not(this).prop('checked', this.checked);
});
$("#PreRegistration").click(function () {
    $('.PreRegistration').not(this).prop('checked', this.checked);
});
$("#ContactUs").click(function () {
    $('.ContactUs').not(this).prop('checked', this.checked);
});
$("#CustomNotifications").click(function () {
    $('.CustomNotifications').not(this).prop('checked', this.checked);
});
$("#Reporting").click(function () {
    $('.Reporting').not(this).prop('checked', this.checked);
});
$("#SystemUsers").click(function () {
    $('.SystemUsers').not(this).prop('checked', this.checked);
});
$("#rolePermissions").click(function () {
    $('.rolePermissions').not(this).prop('checked', this.checked);
});
$("#Legal").click(function () {
    $('.Legal').not(this).prop('checked', this.checked);
});
$("#AppVersion").click(function () {
    $('.AppVersion').not(this).prop('checked', this.checked);
});
$("#supportRequest").click(function () {
    $('.supportRequest').not(this).prop('checked', this.checked);
});

