$(document).ready(function () {
    let userId = $(".id").data("user-id");
    let BlogId = $(".id").data("blog-id");
    // Function To Show Success toast
    function ShowToast(data) {
        $.toast({
            heading: "Success",
            text: data,
            showHideTransition: "slide",
            icon: "success",
        });
    }
    // Function to display user information
    function LoadUserData() {
        $.ajax({
            type: "GET",
            url: `/GetUser/${userId}`,
            success: function (data) {
                // console.log(data);
                $(".User-name").text(data.name);
                $(".user-profile-pic").attr("src", data.Image);
            },
            error: function (err) {
                console.log(err);
            },
        });
    }
    LoadUserData();
    ShowComment();
    // ADD COMMENT
    $(".Post-Comment-Btn").click(function (e) {
        e.preventDefault();
        let commentText = $("#comment").val();
        $.ajax({
            type: "POST",
            url: "/CommentOnBlog",
            data: {
                blog_id: BlogId,
                text: commentText,
                user_id: userId,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                $("#comment").val("");
                ShowComment();
                ShowToast(data.message);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });
    // SHOW COMMENTS
    function ShowComment() {
        $.ajax({
            type: "GET",
            url: `/ShowComments/${BlogId}`,
            success: function (data) {
                console.log(data);
                let CommentContainer = $(".Show-comments");
                CommentContainer.empty();
                $.each(data, function (index, Comment) {
                    let createdAtDate = new Date(
                        Comment.created_at
                    ).toLocaleDateString("en-GB");
                    CommentContainer.append(`<article class="p-6 text-base bg-white rounded-lg">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p class="inline-flex items-center mr-3 text-sm text-gray-900 font-semibold"><img class="mr-2 w-6 h-6 rounded-full" src="${Comment.user.Image}" alt="${Comment.user.name}">${Comment.user.name}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">${createdAtDate}</p>
                        </div>
                    </footer>
                    <p class="text-gray-500">${Comment.comment}</p>
                </article>`);
                });
            },
            error: function (err) {
                console.log(err);
            },
        });
    }
});
