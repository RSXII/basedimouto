// menu open function
var menuOpen = false;
var theSelected;
var open = false;
$("#menuButton").click( function(){
    if(!menuOpen){
        $("#mobileMenu").addClass("mobileOpen");
        menuOpen = true;
    }else{
        console.log("hello");
        $("#mobileMenu").removeClass("mobileOpen");
        menuOpen = false;
    }
});
//sticky navigation to top of page on scroll
$(function(){
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 284) {
            $('#topNav').addClass('stickyTop');
            $('#navScrollSpace').css({'height': '90px', 'width': '100%'});
        }
        else {
            $('#topNav').removeClass('stickyTop');
            $('#navScrollSpace').css({'height': '0', 'width': '0'});
        }
    });
});
//highlights the post header when clicking the replying to link
function replyFunction(selector){
    theSelected = document.getElementById(selector);
    var deSelected = $("post");
    $(".post").removeClass("postSelected");
    setTimeout(function(){
        $(theSelected).addClass("postSelected");
    }, 100);

};
//fills the post box with the correct title and username of the post you are replying to when the reply button has been pressed

function reply_to_post(title, username, postid){
        document.getElementById('reply_to_title').innerHTML = title; //displays the title of the post being replied to
        document.getElementById('reply_to_user').innerHTML = username; //displays the username attached to the user being replied to
        // var the_text = document.getElementById(postid).querySelector(".postBody .message").innerText;  //pulls the body from the post that is replied to
        // document.getElementById('the_post_body').innerHTML = "<p class='replyPara'>" + username + ": " + the_text + "</p>"; //displays the body from the post that is replied to
        document.getElementById('reply_to_post').value = postid; //sets the secret reply field value to whatever the post id is of the post being replied to.  This is used when inserting to the database to add to the parent id
};
$('#changeProfilePictureButton').click(function(){
    if(open){
        $('#change_profile_picture').css({'display': 'none'});
        open = false;
    }else{
        $('#change_profile_picture').css({'display': 'block'});
        open = true;
    }

});
$('#changeGenderButton').click(function(){
    if(open){
        $('#change_gender').css({'display': 'none'});
        open = false;
    }else{
        $('#change_gender').css({'display': 'block'});
        open = true;
    }

});
$('#changeLocationButton').click(function(){
    if(open){
        $('#change_location').css({'display': 'none'});
        open = false;
    }else{
        $('#change_location').css({'display': 'block'});
        open = true;
    }

});
$('#changeBioButton').click(function(){
    if(open){
        $('#change_bio').css({'display': 'none'});
        open = false;
    }else{
        $('#change_bio').css({'display': 'block'});
        open = true;
    }

});

