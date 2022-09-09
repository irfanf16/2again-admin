var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var currentuser = 0;
var usersInCurrentPage;
var usersArray;
var giftUrl;
var mediaUrl;
var allGifts;
var currentpage;
var allInvitations;
var currentuserid;
var RewindUser;
var UserMedia;
var currentPhoto = 0;
var UserMediaLength;
var messages;
var messageContent;
var messageType = 'Text';
var fcm_Token;
var UserProfile;
let chunks = [];
let recorder;
var timeout;
$(document).ready(function () {
    $('#loader-show').show();
    GetData(1);
});


function GetData(page) {
    $('#loader-show').show();
    $.ajax({
        url: "{{route('home')}}?page=" + page,
        method: "GET",
        dataType: 'json',
        success: function (data) {
            // console.log(data);
            $('#loader-show').hide();
            usersInCurrentPage = data.data.users.length;
            usersArray = data.data.users;
            giftUrl = data.data.gift_url;
            currentpage = data.data.currentPage;
            allGifts = data.data.all_gifts;
            allInvitations = data.data.all_invitations;
            mediaUrl = data.data.media_url;
            if (usersArray.length > 0) {

                $('#userProfileAppend').empty();
                $('#userProfileAppend').append(
                    $('<div/>', {'class': 'signal-card'}).append(
                        $('<div/>', {'class': 'card pt-5'}).append(
                            $('<div/>', {'class': 'card-body'}).append(
                                $('<a/>', {'class': ''}),
                                $('<div/>', {'class': 'img-box'}).append(
                                    $('<img/>', {id: 'user_profile_pic', src: ''})
                                ),
                                $('<div/>', {'class': 'layout'}).append(
                                    $('<div/>', {'class': 'card-header'}).append(
                                        $('<div/>', {'class': 'user-title'}).append(
                                            $('<div/>', {'class': 'icon-box  text-red', id: 'user_icon'}),
                                            $('<div/>', {id: 'user_name'}),
                                            $('<div/>', {'class': 'verified'}).append(
                                                $('<i/>', {'class': 'fal ico-badge-check text-blue'})
                                            )
                                        ),
                                        $('<div/>', {'class': 'title-footer'}).append(
                                            $('<div/>', {'class': 'content-center'}).append(
                                                $('<div/>', {'class': 'icon-box'}).append(
                                                    $('<i/>', {'class': 'fal ico-round-share-location'})
                                                ),
                                                $('<div/>', {id: 'user_country'})
                                            ),
                                        )
                                    )
                                ),

                                $('<button/>', {
                                    id: 'previous',
                                    'class': 'btn left-swape',
                                    onclick: 'changePhoto(this.id)',
                                    'disabled': 'disabled',
                                }).append(
                                    $('<i/>', {'class': 'ico-left'}),
                                    'Previous'
                                ),
                                $('<button/>', {
                                    id: 'next',
                                    'class': 'btn right-swape',
                                    onclick: 'changePhoto(this.id)'
                                }).append(
                                    $('<i/>', {'class': 'ico-right'}),
                                    'Next'
                                )
                            ),
                            $('<div/>', {'class': 'card-footer'}).append(
                                $('<div/>', {'class': 'space-between'}).append(
                                    $('<div/>', {'class': 'col'}).append(
                                        $('<div/>', {'class': 'space-between'}).append(
                                            $('<div/>', {'class': 'icon-box'}).append(
                                                $('<i/>', {'class': 'fal ico-avatar-image'})
                                            ),
                                            'Photos:',
                                            $('<span>', {'class': 'text-yellow', id: 'totalPrivatePhotos'})
                                        ),
                                        $('<div/>', {'class': 'text-left', id: 'private_photo_cost'}).append(
                                            'Visit cost:'
                                        )
                                    ),
                                    $('<div/>', {'class': 'col'}).append(
                                        $('<div/>', {'class': 'space-between'}).append(
                                            $('<div/>', {'class': 'icon-box'}).append(
                                                $('<i/>', {'class': 'fal ico-avatar-image'})
                                            ),
                                            'Videos:',
                                            $('<span>', {'class': 'text-yellow', id: 'totalPrivateVideos'})
                                        ),
                                        $('<div/>', {'class': 'text-left', id: 'private_video_cost'}).append(
                                            'Visit cost:'
                                        )
                                    )
                                )
                            ),
                            $('<div/>', {'class': 'btn-row mb-'}).append(
                                $('<a/>', {
                                    id: 'Nope',
                                    'class': 'btn btn-yellow',
                                    onclick: 'like(this.id)'
                                }).append(
                                    $('<i/>', {'class': 'fal ico-cross'}),
                                    'Nope'
                                ),
                                $('<a/>', {
                                    id: 'Like',
                                    'class': 'btn btn-red',
                                    onclick: 'like(this.id)'
                                }).append(
                                    $('<i/>', {'class': 'fal ico-heart'}),
                                    'Like'
                                )
                            ),
                        ),
                        $('<ul/>', {'class': 'btn-list mb-3'}).append(
                            $('<li/>').append(
                                $('<button/>', {'class': 'btn btn-light', id: 'rewind', onclick: 'rewind()'}).append(
                                    $('<i/>', {'class': 'fal ico-refresh'}),
                                    $('<span/>', {'class': 'btn-text'}).append('Rewind')
                                )
                            ),
                            $('<li/>').append(
                                $('<a/>', {
                                    'class': 'btn btn-light message',
                                    id: 'message',
                                    onclick: 'message()'
                                }).append(
                                    $('<i/>', {'class': 'fal ico-messages-alt'}),
                                    $('<span/>', {'class': 'btn-text'}).append('Message')
                                )
                            ),
                            $('<li/>').append(
                                $('<a/>', {
                                    'class': 'btn btn-light',
                                    id: 'SuperLike',
                                    onclick: 'like(this.id)'
                                }).append(
                                    $('<i/>', {'class': 'fal ico-hearts'}),
                                    $('<span/>', {'class': 'btn-text'}).append('Super like')
                                )
                            ),
                            $('<li/>').append(
                                $('<a/>', {'class': 'btn btn-light favourite', onclick: 'favorite()'}).append(
                                    $('<i/>', {'class': 'fal ico-star'}),
                                    $('<span/>', {'class': 'btn-text'}).append('Favorite')
                                )
                            ),
                            $('<li/>').append(
                                $('<form/>', {method: 'POST', action: '{{route("visitProfile")}}'}).append(
                                    $('<input/>', {
                                        type: 'hidden',
                                        name: '_token',
                                        value: '{{ csrf_token() }}'
                                    }),
                                    $('<input/>', {type: 'hidden', name: 'id', value: '', id: 'profileDetail'}),
                                    $('<button/>', {
                                        'class': 'btn btn-light view-detail',
                                        type: 'submit'
                                    }).append(
                                        $('<i/>', {'class': 'fal ico-id-card'}),
                                        $('<span/>', {'class': 'btn-text'}).append('View Detail')
                                    ),
                                ),
                            )
                        )
                    )
                )
                showUser();
                GetGiftsInvitations();
            } else {

                $('#userNotFound').empty();
                $('#userNotFound').append(
                    $('<div/>', {'class': 'signal-card'}).append(
                        $('<div/>', {'class': 'card pt-5'}).append(
                            $('<div/>', {'class': 'img-box'}).append(
                                $('<img/>', {'src': '{{env("MEDIA_URL")}}{{env("USER_NOT_FOUND")}}'})
                            )
                        ),
                    )
                )
            }


        },
        error: function (e) {
            console.log(e.responseJSON.error['0']);
            $('#loader-show').hide();
            $('#userNotFound').empty();
            $('#userNotFound').append(
                $('<div/>', {'class': 'signal-card'}).append(
                    $('<div/>', {'class': 'card pt-5'}).append(
                        $('<div/>', {'class': 'img-box'}).append(
                            $('<img/>', {'src': '{{env("MEDIA_URL")}}{{env("USER_NOT_FOUND")}}'})
                        )
                    ),
                )
            )
            // toastr.error(e.responseJSON.error['0']);

        }
    });
}

function uuid() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

function message() {

    if (usersArray[currentuser].profile_pic != null) {
        document.getElementById('userPicModel').src = mediaUrl + usersArray[currentuser].profile_pic;
    }
    document.getElementById('userNameModel').innerHTML = usersArray[currentuser].name;
    $('#sendMessages').modal('show');

    // $('#withdrwawithpaypal').modal('show');

}

function SendMessage() {
    uniqId = uuid();
    messageContent = $('#messageContent').val();
    console.log(messageContent);
    if (typeof messageContent !== 'undefined' && messageContent.trim() !== "") {

        $('#messageContent').val(null);
        $('#sendMessagesBox').append(
            $('<li/>', {'class': 'sender'}).append(
                $('<div/>', {'class': 'message'}).append(
                    messageContent,
                    $('<div/>', {id: uniqId}).append(
                        $('<i/>', {'class': 'fal fa-clock'}),
                    )
                ),
            )
        )
        $.ajax({
            url: '{{route("sendMessage")}}',
            method: 'POST',
            data: {
                _token: CSRF_TOKEN,
                send_to: currentuserid,
                type: messageType,
                text: messageContent,
                message_id: uniqId
            },
            success: function (response) {

                messageContent = null;
                $('#' + uniqId).empty();
                $('#' + uniqId).append(
                    $('<i/>', {'class': 'fal fal fa-check'}),
                )
                // toastr.success(response.ResponseMessage);
            },
            error: function (e) {

                if (e.responseJSON.ResponseMessage === 'show popup') {

                    $('#sendMessages').modal('hide');
                    $('#vipmembership').modal('show');

                }
                toastr.error(e.responseJSON.error['0']);

            }
        })
    }
}

// Audio record
function record(control) {
    let device = navigator.mediaDevices.getUserMedia({audio: true});
    device.then(stream => {
        if (recorder === undefined) {
            recorder = new MediaRecorder(stream);
            recorder.ondataavailable = e => {
                chunks.push(e.data);

                if (recorder.state === 'inactive') {
                    let blob = new Blob(chunks, {type: 'audio/webm'});
                    var reader = new FileReader();

                    reader.addEventListener("load", function () {


                        var file = dataURLtoFile(reader.result, 'file.mp3');
                        console.log(file);
                        console.log(reader.result);
                        uniqId = uuid();
                        var formData = new FormData();
                        formData.append('send_to', currentuserid);
                        formData.append('type', 'Audio');
                        formData.append('file', file);
                        formData.append('text', null);
                        formData.append('message_id', uniqId);


                        $('#sendMessagesBox').append(
                            $('<li/>', {'class': 'sender'}).append(
                                $('<div/>', {'class': 'message'}).append(
                                    $('<audio/>', {'controls': 'controls'}).append(
                                        $('<source/>', {src: reader.result, type: 'audio/mpeg'})
                                    ),
                                    $('<div/>', {id: uniqId}).append(
                                        $('<i/>', {'class': 'fal fa-clock'}),
                                    )
                                ),
                            )
                        )
                        $.ajax({
                            url: '{{route("sendMessage")}}',
                            method: 'post',
                            data: formData,
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            success: function (response) {


                                $('#' + uniqId).empty();
                                $('#' + uniqId).append(
                                    $('<i/>', {'class': 'fal fal fa-check'}),
                                )
                                // toastr.success(response.ResponseMessage);
                            },
                            error: function (e) {

                                if (e.responseJSON.ResponseMessage === 'show popup') {

                                    $('#sendMessages').modal('hide');
                                    $('#vipmembership').modal('show');

                                }
                                toastr.error(e.responseJSON.error['0']);

                            }
                        });

                    }, false);
                    reader.readAsDataURL(blob);
                }
            }

            recorder.start();
            control.setAttribute('class', 'fas fa-stop-circle');
        }
    });

    if (recorder !== undefined) {
        if (control.getAttribute('class').indexOf('stop') !== -1) {
            recorder.stop();
            control.setAttribute('class', 'fal ico-microphone');

        } else {
            chunks = [];
            recorder.start();
            control.setAttribute('class', 'fas fa-stop-circle');
        }
    }
}

//data to file convert
function dataURLtoFile(dataurl, filename) {

    var arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]),
        n = bstr.length,
        u8arr = new Uint8Array(n);

    while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
    }

    return new File([u8arr], filename, {type: mime});
}

function like(id) {
    // console.log(id);
    // console.log(currentuserid);
    $('#loader-show').show();

    $.ajax({
        url: '{{route("like_to")}}',
        method: 'POST',
        data: {_token: CSRF_TOKEN, like_to: currentuserid, like: id},
        success: function (response) {
            $('#loader-show').hide();
            document.getElementById('rewind').disabled = false;

            if (id === 'Like') {

                toastr.success(response.ResponseMessage);
            }
            if (id === 'Nope') {
                toastr.warning(response.ResponseMessage);
            }
            if (id === 'SuperLike') {
                toastr.info(response.ResponseMessage);
            }
            currentuser++;
            // console.log(currentuser);
            showUser();


        },
        error: function (e) {
            // console.log(e.responseJSON.error['0']);
            $('#loader-show').hide();
            toastr.error(e.responseJSON.error['0']);

            // console.log(JSON.parse(jqXHR))
            //  console.log(jqXHR + textStatus + errorThrown);
        }


    });


}

function favorite() {

    // console.log(currentuserid);
    $('#loader-show').show();
    $.ajax({
        url: '{{route("favorite_to")}}',
        method: 'POST',
        data: {_token: CSRF_TOKEN, favorite_to: currentuserid},
        success: function (response) {
            $('#loader-show').hide();
            toastr.success(response.ResponseMessage);
            currentuser++;
            document.getElementById('rewind').disabled = false;

            // console.log(currentuser);
            showUser();
        },
        error: function (e) {
            $('#loader-show').hide();

            // console.log(e.responseJSON.error['0']);
            toastr.error(e.responseJSON.error['0']);

        }


    });

}

function rewind() {

    $('#loader-show').show();
    $.ajax({
        url: '{{route("rewind")}}',
        method: 'GET',
        success: function (response) {
            $('#loader-show').hide();
            document.getElementById('rewind').disabled = true;
            RewindUser = response.data.profile;
            rewindUser();

        },
        error: function (e) {
            $('#loader-show').hide();
            if (e.responseJSON.ResponseMessage === 'show popup') {

                $('#sendMessages').modal('hide');
                $('#vipmembership').modal('show');

            }
            toastr.error(e.responseJSON.error['0']);

        }

    });

}

function rewindUser() {

    $('#wishlist_invitations').empty();
    $('#wishlist_gifts').empty();
    if (RewindUser.wishlist_gifts.length > 0) {
        $.each(RewindUser.wishlist_gifts, function (index, value) {
            $('#wishlist_gifts').append(
                $('<li/>').append(
                    $('<div/>', {'class': 'icon-box'}).append(
                        $('<img/>', {'src': giftUrl + value.icon})
                    ),
                    $('<div/>', {'class': 'description'}).append(
                        $('<div/>', {'class': 'text'}).append(
                            $('<div/>', {'class': 'title'}).append(
                                value.name
                            ),
                            $('<p/>', {'class': 'text-yellow font-12'}).append(
                                value.silver_coin + ' Gold coins'
                            )
                        ),
                        $('<a/>', {'class': 'btn small', 'href': '#'}).append(
                            'Send'
                        )
                    )
                )
            )
        });
    } else {
        $('#wishlist_gifts').append(
            $('<li/>').append(
                $('<div/>', {'class': 'text'}).append(
                    $('<div/>', {'class': 'title'}).append(
                        RewindUser.name + ' Wishlist Is Empty'
                    )
                )
            )
        )
    }
    if (RewindUser.wishlist_invitations.length > 0) {
        $.each(RewindUser.wishlist_invitations, function (index, value) {
            $('#wishlist_invitations').append(
                $('<li/>').append(
                    $('<div/>', {'class': 'icon-box'}).append(
                        $('<img/>', {'src': giftUrl + value.icon})
                    ),
                    $('<div/>', {'class': 'description'}).append(
                        $('<div/>', {'class': 'text'}).append(
                            $('<div/>', {'class': 'title'}).append(
                                value.name
                            ),
                            $('<p/>', {'class': 'text-yellow font-12'}).append(
                                value.silver_coin + ' Gold coins'
                            )
                        ),
                        $('<a/>', {'class': 'btn small', 'href': '#'}).append(
                            'Send'
                        )
                    )
                )
            )
        });
    } else {
        $('#wishlist_invitations').append(
            $('<li/>').append(
                $('<div/>', {'class': 'text'}).append(
                    $('<div/>', {'class': 'title'}).append(
                        RewindUser.name + ' Invitations Is Empty'
                    )
                )
            )
        )
    }
    document.getElementById('user_name').innerHTML = RewindUser.name;
    if (usersArray[currentuser].profile_pic != null) {
        document.getElementById('user_profile_pic').src = mediaUrl + RewindUser.profile_pic;
    } else {
        document.getElementById('user_profile_pic').src = mediaUrl + 'default.png';
    }

    if (RewindUser.gender == 2) {
        $('#user_icon').empty();
        $('#user_icon').append(
            $('<i/>', {'class': 'fal ico-man'}).append(
            )
        )
    } else {
        $('#user_icon').empty();
        $('#user_icon').append(
            $('<i/>', {'class': 'fal ico-woman'}).append(
            )
        )
    }

    if (RewindUser.media !== null) {
        UserMedia = RewindUser.media.split(',');
        UserMediaLength = RewindUser.media.length;
    } else {
        UserMedia = null;
        UserMediaLength = null;
    }


    UserProfile = RewindUser.profile_pic;
    document.getElementById('profileDetail').value = RewindUser.id;

    currentuserid = RewindUser.id;
    document.getElementById('user_country').innerHTML = '( ' + RewindUser.country + ' )';
    document.getElementById('totalPrivatePhotos').innerHTML = '( ' + RewindUser.totalPrivatePhotos + ' )';
    document.getElementById('private_photo_cost').innerHTML = 'Visit cost: ' + RewindUser.private_photo_cost + ' coins';
    document.getElementById('totalPrivateVideos').innerHTML = '( ' + RewindUser.totalPrivateVideos + ' )';
    document.getElementById('private_video_cost').innerHTML = 'Visit cost: ' + RewindUser.private_video_cost + ' coins';


}

function changePhoto(id) {


    if (id === 'next') {

        if (currentPhoto === UserMedia.length - 1) {
            document.getElementById('next').disabled = true;
            document.getElementById('previous').disabled = false;
        } else {
            currentPhoto++;
            document.getElementById('previous').disabled = false;

        }
        document.getElementById('user_profile_pic').src = mediaUrl + UserMedia[currentPhoto];
    } else {

        if (currentPhoto === 0) {
            document.getElementById('next').disabled = false;
            document.getElementById('previous').disabled = true;

        } else {
            currentPhoto--;
            document.getElementById('next').disabled = false;

        }
        document.getElementById('user_profile_pic').src = mediaUrl + UserMedia[currentPhoto];

    }


}


function showUser() {


    $('#sendMessagesBox').empty();
    if (usersInCurrentPage > 0) {
        if (usersInCurrentPage > currentuser) {
            $('#wishlist_invitations').empty();
            $('#wishlist_gifts').empty();
            if (usersArray[currentuser].wishlist_gifts.length > 0) {
                $.each(usersArray[currentuser].wishlist_gifts, function (index, value) {
                    $('#wishlist_gifts').append(
                        $('<li/>').append(
                            $('<div/>', {'class': 'icon-box'}).append(
                                $('<img/>', {'src': giftUrl + value.icon})
                            ),
                            $('<div/>', {'class': 'description'}).append(
                                $('<div/>', {'class': 'text'}).append(
                                    $('<div/>', {'class': 'title'}).append(
                                        value.name
                                    ),
                                    $('<p/>', {'class': 'text-yellow font-12'}).append(
                                        value.silver_coin + ' Gold coins'
                                    )
                                ),
                                $('<a/>', {
                                    'class': 'btn small', id: value.id,
                                    onclick: 'sendGiftOrInvitation(this.id)'
                                }).append(
                                    'Send'
                                )
                            )
                        )
                    )
                });
            } else {
                $('#wishlist_gifts').append(
                    $('<li/>').append(
                        $('<div/>', {'class': 'text'}).append(
                            $('<div/>', {'class': 'title'}).append(
                                usersArray[currentuser].name + ' GIft Is Empty'
                            )
                        )
                    )
                )
            }
            if (usersArray[currentuser].wishlist_invitations.length > 0) {
                $.each(usersArray[currentuser].wishlist_invitations, function (index, value) {
                    $('#wishlist_invitations').append(
                        $('<li/>').append(
                            $('<div/>', {'class': 'icon-box'}).append(
                                $('<img/>', {'src': giftUrl + value.icon})
                            ),
                            $('<div/>', {'class': 'description'}).append(
                                $('<div/>', {'class': 'text'}).append(
                                    $('<div/>', {'class': 'title'}).append(
                                        value.name
                                    ),
                                    $('<p/>', {'class': 'text-yellow font-12'}).append(
                                        value.silver_coin + ' Gold coins'
                                    )
                                ),
                                $('<a/>', {
                                    'class': 'btn small',
                                    id: value.id,
                                    onclick: 'sendGiftOrInvitation(this.id)'
                                }).append(
                                    'Send'
                                )
                            )
                        )
                    )
                });
            } else {
                $('#wishlist_invitations').append(
                    $('<li/>').append(
                        $('<div/>', {'class': 'text'}).append(
                            $('<div/>', {'class': 'title'}).append(
                                usersArray[currentuser].name + ' Invitations Is Empty'
                            )
                        )
                    )
                )
            }

            document.getElementById('user_name').innerHTML = usersArray[currentuser].name;
            currentuserid = usersArray[currentuser].id;
            if (usersArray[currentuser].profile_pic != null) {
                document.getElementById('user_profile_pic').src = mediaUrl + usersArray[currentuser].profile_pic;
            }
            if (usersArray[currentuser].gender === 2) {
                $('#user_icon').empty();

                $('#user_icon').append(
                    $('<i/>', {'class': 'fal ico-man text-blue'}).append(
                    )
                )
            } else {
                $('#user_icon').empty();
                $('#user_icon').append(
                    $('<i/>', {'class': 'fal ico-woman'}).append(
                    )
                )
            }
            if (usersArray[currentuser].media !== null) {

                UserMedia = usersArray[currentuser].media.split(',');
                if (usersArray[currentuser].profile_pic != null) {
                    UserMedia.splice(0, 0, usersArray[currentuser].profile_pic)
                }
                UserMediaLength = usersArray[currentuser].media.length;

            } else {

                UserMedia = null;
                UserMediaLength = null;
                document.getElementById('next').disabled = true;
                document.getElementById('previous').disabled = true;
            }


            UserProfile = usersArray[currentuser].profile_pic;
            document.getElementById('profileDetail').value = usersArray[currentuser].id;
            document.getElementById('user_country').innerHTML = ' ' + usersArray[currentuser].country;
            document.getElementById('totalPrivatePhotos').innerHTML = ' (' + usersArray[currentuser].totalPrivatePhotos + ') ';
            document.getElementById('private_photo_cost').innerHTML = 'Visit cost: ' + usersArray[currentuser].private_photo_cost + ' coins';
            document.getElementById('totalPrivateVideos').innerHTML = ' (' + usersArray[currentuser].totalPrivateVideos + ') ';
            document.getElementById('private_video_cost').innerHTML = 'Visit cost: ' + usersArray[currentuser].private_video_cost + ' coins';
        } else {
            currentpage++;
            currentuser = 0;
            GetData(currentpage);
        }
    } else {
        $('#userNotFound').empty();
        $('#userNotFound').append(
            $('<div/>', {'class': 'signal-card'}).append(
                $('<div/>', {'class': 'card pt-5'}).append(
                    $('<div/>', {'class': 'img-box'}).append(
                        $('<img/>', {'src': '{{env("MEDIA_URL")}}{{env("USER_NOT_FOUND")}}'})
                    )
                )
            )
        )
        toastr.error('No User Found');
    }


}

function GetGiftsInvitations() {
    // alert(data.data.all_gifts);
    $('#all_gifts').empty();
    $('#all_invitations').empty();
    if (allGifts) {
        $.each(allGifts, function (index, value) {


            $('#all_gifts').append(
                $('<li/>').append(
                    $('<div/>', {'class': 'icon-box'}).append(
                        $('<img/>', {'src': giftUrl + value.icon})
                    ),
                    $('<div/>', {'class': 'description'}).append(
                        $('<div/>', {'class': 'text'}).append(
                            $('<div/>', {'class': 'title'}).append(
                                value.name
                            ),
                            $('<p/>', {'class': 'text-yellow font-12'}).append(
                                value.price + ' Gold coins'
                            )
                        ),
                        $('<a/>', {
                            'class': 'btn small',
                            id: value.id,
                            onclick: 'sendGiftOrInvitation(this.id)'
                        }).append(
                            'Send'
                        )
                    )
                )
            )
        });

    } else {
        $('#all_gifts').append(
            $('<li/>').append(
                $('<div/>', {'class': 'text'}).append(
                    $('<div/>', {'class': 'title'}).append(
                        'Gifts Not Available'
                    )
                )
            )
        )
    }
    if (allInvitations) {
        $.each(allInvitations, function (index, value) {
            $('#all_invitations').append(
                $('<li/>').append(
                    $('<div/>', {'class': 'icon-box'}).append(
                        $('<img/>', {'src': giftUrl + value.icon})
                    ),
                    $('<div/>', {'class': 'description'}).append(
                        $('<div/>', {'class': 'text'}).append(
                            $('<div/>', {'class': 'title'}).append(
                                value.name
                            ),
                            $('<p/>', {'class': 'text-yellow font-12'}).append(
                                value.price + ' Gold coins'
                            )
                        ),
                        $('<a/>', {
                            'class': 'btn small',
                            id: value.id,
                            onclick: 'sendGiftOrInvitation(this.id)'
                        }).append(
                            'Send'
                        )
                    )
                )
            )
        });

    } else {
        $('#all_invitations').append(
            $('<li/>').append(
                $('<div/>', {'class': 'text'}).append(
                    $('<div/>', {'class': 'title'}).append(
                        'Invitations Not Available'
                    )
                )
            )
        )
    }
}

function sendGiftOrInvitation(id) {

    // console.log(currentuserid);
    $('#loader-show').show();
    $.ajax({
        url: '{{route("sendGiftOrInvitation")}}',
        method: 'POST',
        data: {_token: CSRF_TOKEN, to_user: currentuserid, gifts_invitations_id: id},
        success: function (response) {
            $('#loader-show').hide();
            toastr.success(response.ResponseMessage);
        },
        error: function (e) {
            $('#loader-show').hide();
            // console.log(e.responseJSON.error['0']);
            toastr.error(e.responseJSON.error['0']);

        }


    });
}
