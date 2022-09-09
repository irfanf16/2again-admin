var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var currentuser = 0;
var usersInCurrentPage;
var usersArray;
var giftUrl;
var allGifts;
var currentpage;
var allInvitations;
var currentuserid;


$(document).ready(function () {
    GetData(1);
});

function like(id) {
    console.log(id);
    console.log(currentuserid);
    $.ajax({
        url: "{{route('like_to')}}",
        method: 'POST',
        data: {_token: CSRF_TOKEN, like_to: currentuserid, like: id},
        success: function (response) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true
                }
            if (id == 'Like') {

                toastr.success(response.ResponseMessage);
            }
            if(id == 'Nope')
            {
                toastr.warning(response.ResponseMessage);
            }
            if(id=='SuperLike'){
                toastr.info(response.ResponseMessage);
            }
            currentuser++;
            // console.log(currentuser);
            showUser();
        },
        error:function (e){
            // console.log(e.responseJSON.error['0']);
            toastr.error(e.responseJSON.error['0']);

            // console.log(JSON.parse(jqXHR))
            //  console.log(jqXHR + textStatus + errorThrown);
        }


    });



}
function favorite(){

    console.log(currentuserid);
    $.ajax({
        url: "{{route('favorite_to')}}",
        method: 'POST',
        data: {_token: CSRF_TOKEN, favorite_to: currentuserid},
        success: function (response) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true
                }
            toastr.success(response.ResponseMessage);
            currentuser++;
            console.log(currentuser);
            showUser();
        },
        error:function (e){
            console.log(e.responseJSON.error['0']);
            toastr.error(e.responseJSON.error['0']);

        }


    });

}

function rewind() {

    $.ajax({
        url:"{{route('rewind')}}",
        method:'GET',
        success:function (response){
            console.log(response.ResponseCode);
            rewindUser(response);
        }
    });

}
function rewindUser(response) {
    if (response.ResponseCode == 1) {
        $('#wishlist_invitations').empty();
        $('#wishlist_gifts').empty();
        if (response.data.profile.wishlist_gifts > 0) {
            $.each(response.data.profile.wishlist_gifts, function (index, value) {
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
                                    value.silver_coin + 'Gold coins'
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
                            response.data.profile.name + ' Wishlist Is Empty'
                        )
                    )
                )
            )
        }
        if (response.data.profile.wishlist_invitations > 0) {
            $.each(response.data.profile.wishlist_gifts, function (index, value) {
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
                                    value.silver_coin + 'Gold coins'
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
                            response.data.profile.name + ' Invitations Is Empty'
                        )
                    )
                )
            )
        }
        document.getElementById('user_name').innerHTML = response.data.profile.name;
        if (response.data.profile.profile_pic !=null){
            document.getElementById('user_profile_pic').src = response.data.profile.profile_pic;

        }

        currentuserid = response.data.profile.id;
        document.getElementById('totalPrivatePhotos').innerHTML = '( ' + response.data.profile.totalPrivatePhotos + ' )';
        document.getElementById('private_photo_cost').innerHTML = 'Visit cost: ' + response.data.profile.private_photo_cost + ' coins';
        document.getElementById('totalPrivateVideos').innerHTML = '( ' + response.data.profile.totalPrivateVideos + ' )';
        document.getElementById('private_video_cost').innerHTML = 'Visit cost: ' + response.data.profile.private_video_cost + ' coins';

    } else {
        alert('No Rewind found');
    }


}

function GetData(page) {
    $.ajax({
        url: '{{route("home")}}?page='+page,
        method: "GET",
        dataType: 'json',
        success: function (data) {
            // console.log(data);

            usersInCurrentPage = data.data.users.length;
            usersArray = data.data.users;
            giftUrl = data.data.gift_url;
            currentpage = data.data.currentPage;
            allGifts = data.data.all_gifts;
            allInvitations = data.data.all_invitations;
            showUser();
            GetGiftsInvitations();

        }
    });
}

function showUser() {
    if (usersInCurrentPage > 0) {
        if (usersInCurrentPage > currentuser) {
            $('#wishlist_invitations').empty();
            $('#wishlist_gifts').empty();
            if (usersArray[currentuser].wishlist_gifts > 0) {
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
                                        value.silver_coin + 'Gold coins'
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
                                usersArray[currentuser].name + ' Wishlist Is Empty'
                            )
                        )
                    )
                )
            }
            if (usersArray[currentuser].wishlist_invitations > 0) {
                $.each(usersArray[currentuser].wishlist_gifts, function (index, value) {
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
                                        value.silver_coin + 'Gold coins'
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
                                usersArray[currentuser].name + ' Invitations Is Empty'
                            )
                        )
                    )
                )
            }
            document.getElementById('user_name').innerHTML = usersArray[currentuser].name;
            if (usersArray[currentuser].profile_pic !=null){
                document.getElementById('user_profile_pic').src = usersArray[currentuser].profile_pic;

            }

            currentuserid = usersArray[currentuser].id;
            document.getElementById('totalPrivatePhotos').innerHTML = '( ' + usersArray[currentuser].totalPrivatePhotos + ' )';
            document.getElementById('private_photo_cost').innerHTML = 'Visit cost: ' + usersArray[currentuser].private_photo_cost + ' coins';
            document.getElementById('totalPrivateVideos').innerHTML = '( ' + usersArray[currentuser].totalPrivateVideos + ' )';
            document.getElementById('private_video_cost').innerHTML = 'Visit cost: ' + usersArray[currentuser].private_video_cost + ' coins';
        } else {
            currentpage++;
            currentuser = 0;
            GetData(currentpage);
        }
    } else {
        alert('user empty');
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
