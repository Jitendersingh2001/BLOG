$(document).ready(function () {
    let admindata;
    // FUNCTION TO DISPLAY ADMIN DEATILS
    function DisplayAdmin(data) {
        $(".admin-name").val(data.AdminUser.name);
        $(".admin-email").val(data.AdminUser.email);
        $(".admin-email").val(data.AdminUser.email);
        $(".admin-phoneno").val(data.AdminUser.phone_no);
    }
    // FUNCTION TO LOAD USERS AND ADMIN DETAIL
    function LoadUsers() {
        $.ajax({
            url: "/GetUsers",
            type: "GET",
            success: function (data) {
                admindata = data;
                console.log(data);
                $(".admin-name").text(data.AdminUser.name);
                if (data.AdminUser.Image !== null) {
                    $(".admin-profile-pic").attr("src", data.AdminUser.Image);
                }
                DisplayAdmin(data);
            },
            error: function (err) {
                console.log(err);
            },
        });
    }
    LoadUsers();
    // EDIT ADMIN DETAILS
    $(".Admin-profile-edit-btn").click(function (event) {
        event.preventDefault();
        $(".Admin-profile-edit-btn").addClass("hide");
        $(".Admin-profile-action").addClass("justify-end");
        $(".Admin-profile-action-2").removeClass("hide");
        $("input").prop("disabled", false);
        $("input").removeClass("cursor-not-allowed");
    });
});
