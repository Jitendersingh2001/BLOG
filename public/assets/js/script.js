$(document).ready(function () {
    let admindata;
    let BlogId,
        currentpage = 0,
        nextpage = 1,
        UserId;
    console.log($("#user-password").val());
    const emailRegex =
        /^[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*@[a-zA-Z]+(?:\.[a-zA-Z]+)*$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    // Call OF FUNCTIONS
    LoadUsers();
    DisplayCategory();
    DisplayBlog();
    total();
    // FUNCTION TO DISPLAY TOTAL
    function total() {
        $.ajax({
            type: "GET",
            url: "/admin/total",
            dataType: "json",
            success: function (data) {
                $(".total-views-count").text(data.totalViews);
                $(".total-blog-count").text(data.totalBlogs);
                $(".total-user-count").text(data.totalUsers);
                $(".total-comments-count").text(data.totalComments);
            },
            error: function (err) {
                console.log(err);
            },
        });
    }
    // FUNCTION TO DISPLAY ADMIN DEATILS
    function DisplayAdmin(data) {
        $(".admin-name").val(data.AdminUser.name);
        $(".admin-email").val(data.AdminUser.email);
        $(".admin-email").val(data.AdminUser.email);
        $(".admin-phoneno").val(data.AdminUser.phone_no);
    }
    // Function to Display Users Detail on DashBoard page
    function DisplayUsers(data) {
        let container = $(".user-table-content");
        Showpagination(data);
        container.empty();
        $.each(data, function (index, User) {
            const formattedDate = new Date(User.created_at).toLocaleDateString(
                "en-GB"
            );
            container.append(`<tr class="text-gray-700 dark:text-gray-400">
            <td class="px-4 py-3">
              <div class="flex items-center text-sm">
                <!-- Avatar with inset shadow -->
                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                  <img class="object-cover w-full h-full rounded-full" src="${User.Image}" alt="" loading="lazy" />
                  <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                </div>
                <div>
                  <p class="font-semibold"> ${User.name}</p>
                </div>
              </div>
            </td>
            <td class="px-4 py-3 text-sm">
              ${User.email}
            </td>
            <td class="px-4 py-3 text-xs">
              <span class="px-2 py-1 text-sm">
              ${User.phone_no}
              </span>
            </td>
            <td class="px-4 py-3 text-sm">
            ${formattedDate}
            </td>
          </tr>`);
        });
    }
    // Function to show display aside users
    function DisplayAsideUsers(data) {
        Showpagination(data);
        let container = $(".user-aside-table-content");
        container.empty();
        if (data && data.length > 0) {
            $.each(data, function (index, User) {
                const statusHTML =
                    User.status === "active"
                        ? `<td class="px-4 py-3 text-xs">
                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                      Active
                    </span>
                  </td>`
                        : `<td class="px-4 py-3 text-xs">
                    <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700">
                      Block
                    </span>
                  </td>`;

                container.append(`<tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <!-- Avatar with inset shadow -->
                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                      <img class="object-cover w-full h-full rounded-full" src="${User.Image}" alt="" loading="lazy" />
                      <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                    </div>
                    <div>
                      <p class="font-semibold"> ${User.name}</p>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-3 text-sm">
                  ${User.email}
                </td>
                <td class="px-4 py-3 text-xs">
                  <span class="px-2 py-1 text-sm">
                    ${User.phone_no}
                  </span>
                </td>
               
                ${statusHTML}
             
                <td class="px-4 flex justify-center py-3 text-sm blog-action">
                            <div class="flex gap-2">
                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 user-edit-btn" data-id="${User.id}">Edit</button>
                            <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 user-dlt-btn" data-id="${User.id}">Delete</button>
                        </div>

                            </td>
                </tr>

              `);
            });
        } else {
            container.append(`<td class="px-4 py-3 blog-title-container">
                    <div class="flex items-center text-sm">
                        <p class="font-semibold blog-title">No User Found </p>
                    </div>
                </td>`);
        }
    }

    // Function To Show error toast
    function ShowError(data) {
        $.toast({
            heading: "Error",
            text: data,
            showHideTransition: "slide",
            icon: "error",
        });
    }
    // Function to Show pagination
    function Showpagination(data) {
        if (data.length > 10) {
            $(".pagination").removeClass("hide");
        } else {
            $(".pagination").addClass("hide");
        }
        totalPages = Math.ceil(data.length / 10);
        if (totalPages > 1) {
            let pagination = $(".inner-pagenation");
            pagination.empty();
            for (let i = 0; i < totalPages; i++) {
                pagination.append(
                    `<li>
                        <button class="page-btn-${i} px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                            ${i + 1}
                        </button>
                    </li>`
                );
            }
        }
    }

    // Function To Show Success toast
    function ShowToast(data) {
        $.toast({
            heading: "Success",
            text: data,
            showHideTransition: "slide",
            icon: "success",
        });
    }
    // FUNCTION TO LOAD USERS AND ADMIN DETAIL
    function LoadUsers() {
        $.ajax({
            url: "/GetUsers",
            type: "GET",
            success: function (data) {
                admindata = data;
                $(".admin-name").text(data.AdminUser.name);
                if (data.AdminUser.Image !== null) {
                    $(".admin-profile-pic").attr("src", data.AdminUser.Image);
                }
                DisplayAdmin(data);
                DisplayUsers(data.users);
                DisplayAsideUsers(data.users);
            },
            error: function (err) {
                console.log(err);
            },
        });
    }
    // FUNCTION TO CLOSE MODAL
    function close_modal() {
        $(".modal-title").text("Create Blog");
        $(".create_blog_btn").text("Create");
        $(".image-lable").text("Upload Image For Blog");
        $("#postTitle").val("");
        $("#PostContent").val("");
        $("#BlogImage").val("");
        $("#Blogcategory").val("Choose a category");
        $(".Image-container").empty();
    }

    // EDIT ADMIN DETAILS
    $(".Admin-profile-edit-btn").click(function (event) {
        event.preventDefault();
        $(".Admin-profile-edit-btn").addClass("hide");
        $(".Admin-profile-action").addClass("justify-end");
        $(".Admin-profile-action-2").removeClass("hide");
        $("input").prop("disabled", false);
        $("input").removeClass("cursor-not-allowed");
    });
    // Display Categories in modal
    function DisplayCategory() {
        $.ajax({
            url: "/getCategories",
            method: "GET",
            success: function (data) {
                // console.log(data);
                let selectElement = $("#Blogcategory");
                selectElement.empty();
                selectElement.append(
                    `<option selected>Choose a category</option>`
                );
                if (data && data.length > 0) {
                    $.each(data, function (index, category) {
                        selectElement.append(
                            `<option value=${category.category}>${category.category}</option>`
                        );
                    });
                } else {
                    selectElement.append(
                        `<option value="Other">Other</option>`
                    );
                }
                selectElement.append(`<option value="Other">Other</option>`);
            },
            error: function (err) {
                console.log(err);
            },
        });
    }
    // Other category filed Hide and Show
    $("#Blogcategory").change(function () {
        if ($(this).val() === "Other") {
            $(".otherCategory").removeClass("hide");
        } else {
            $(".otherCategory").addClass("hide");
        }
    });
    // CREATE BLOG
    $(".create_blog_btn").click(function (e) {
        e.preventDefault();
        const session = sessionStorage.getItem("token");
        const formData = new FormData($("#CreatePostForm")[0]);
        const title = $("#postTitle").val();
        const description = $("#PostContent").val();
        const category = $("#Blogcategory").val();
        const image = $("#BlogImage").val();

        if (category === "Other") {
            const otherCategory = $("#OtherCategory").val();

            if (!otherCategory) {
                ShowError("Other category field is mandatory to fill");
                return;
            }

            formData.append("OtherCategory", otherCategory);
        }

        if (session === "update") {
            formData.append("blogId", BlogId);
            console.log("update");
            $.ajax({
                type: "POST",
                url: "/updateBlog",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $(".close_modal-btn").click();
                    close_modal();
                    DisplayBlog();
                    DisplayCategory();
                    ShowToast(data.message);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        } else {
            if (!title || !description || !category || !image) {
                ShowError("All fields are mandatory to fill");
            } else if (description.length < 250) {
                ShowError("Content should have a minimum of 250 words");
            } else {
                $.ajax({
                    url: "/CreateBlog",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (data) {
                        $(".close_modal-btn").click();
                        DisplayBlog();
                        DisplayCategory();
                        ShowToast(data.message);
                        Title = $("#postTitle").val("");
                        Description = $("#PostContent").val("");
                        category = $("#Blogcategory").val("");
                        Image = $("#BlogImage").val("");
                    },
                    error: function (err) {
                        console.log(err);
                    },
                });
            }
        }
    });

    // Display Blog
    function DisplayBlog() {
        $.ajax({
            type: "GET",
            url: "/GetBlogs",
            success: function (data) {
                // console.log(data);
                Showpagination(data);
                let BlogContainer = $(".Blog-table-content");
                BlogContainer.empty();

                if (data && data.length > 0) {
                    $.each(
                        data.slice(currentpage * 10, nextpage * 10),
                        function (index, Blog) {
                            BlogContainer.append(
                                `  <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 blog-title-container">
                                <div class="flex items-center text-sm">
                                    <p class="font-semibold blog-title">${Blog.title}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm blog-description">
                                ${Blog.description}
                            </td>
                            <td class="px-4 py-3 text-sm blog-category">
                                ${Blog.category}
                            </td>
                            <td class="px-4 py-3 text-sm blog-action">
                            <div class="flex gap-2">
                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 blog-edit-btn" data-id="${Blog.id}">Edit</button>
                            <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 blog-dlt-btn" data-id="${Blog.id}">Delete</button>
                        </div>

                            </td>
                        </tr>
                        `
                            );
                        }
                    );
                } else {
                    BlogContainer.append(`<td class="px-4 py-3 blog-title-container">
                    <div class="flex items-center text-sm">
                        <p class="font-semibold blog-title">No Blog Found </p>
                    </div>
                </td>`);
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
    }
    // Blog Delete Btn
    $(document).on("click", ".blog-dlt-btn", function () {
        let BlogId = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/blog/${BlogId}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                DisplayBlog();
                ShowToast(data.message);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
    //Blog Edit Btn
    $(document).on("click", ".blog-edit-btn", function () {
        BlogId = $(this).data("id");

        $.ajax({
            type: "GET",
            url: `/editBlog/${BlogId}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                // console.log(data);
                $(".otherCategory").addClass("hide");
                $(".create-blog-btn").click();
                sessionStorage.setItem("token", "update");
                $(".modal-title").text("Edit Blog");
                $("#create_blog_btn").text("Update");
                $("#postTitle").val(data.blogs.title);
                $("#PostContent").val(data.blogs.description);
                $("#Blogcategory").val(data.blogs.category);

                $(".image-lable").text("Upload New Image For Blog");
                $(".Image-container").append(`
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white image-label" for="BlogImage">Current Blog Image</label>
                <img class="h-auto max-w-lg mx-auto" src="${data.blogs.BlogImage}" alt="image" style="max-width: 100%; height: auto;">
            `);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
    // Create Modal Close Btn Function
    $(".close_modal-btn").click(close_modal);
    // TO CLEAR SESSION
    $(".create-blog-btn").click(function () {
        sessionStorage.clear();
    });
    // DISPLAY BLOS ACCORDING TO SEARCH
    $(".serach-btn").click(function (e) {
        e.preventDefault();
        let SearchValue = $("#Blog-search-bar").val();

        $.ajax({
            type: "GET",
            url: `/GetSarchedBlogs/${SearchValue}`,
            success: function (data) {
                Showpagination(data);
                $("#Blog-search-bar").val("");
                let BlogContainer = $(".Blog-table-content");
                BlogContainer.empty();
                if (data && data.length > 0) {
                    $.each(
                        data.slice(currentpage * 10, nextpage * 10),
                        function (index, Blog) {
                            BlogContainer.append(
                                `  <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 blog-title-container">
                                <div class="flex items-center text-sm">
                                    <p class="font-semibold blog-title">${Blog.title}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm blog-description">
                                ${Blog.description}
                            </td>
                            <td class="px-4 py-3 text-sm blog-category">
                                ${Blog.category}
                            </td>
                            <td class="px-4 py-3 text-sm blog-action">
                            <div class="flex gap-2">
                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 blog-edit-btn" data-id="${Blog.id}">Edit</button>
                            <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 blog-dlt-btn" data-id="${Blog.id}">Delete</button>
                        </div>

                            </td>
                        </tr>
                        `
                            );
                        }
                    );
                } else {
                    BlogContainer.append(`<td class="px-4 py-3 blog-title-container">
                    <div class="flex items-center text-sm">
                        <p class="font-semibold blog-title">No Blog Found </p>
                    </div>
                </td>`);
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
    });
    // Pagination next btn
    $(".nxt-btn").click(function () {
        currentpage++, nextpage++;
        DisplayBlog();
    });
    // pagination prev btn
    $(".prv-btn").click(function () {
        currentpage--, nextpage--;
        DisplayBlog();
    });
    // Aside user btn functionilty
    $(".user-aside-btn").click(LoadUsers());
    // User edit btn
    $(document).on("click", ".user-edit-btn", function () {
        UserId = $(this).data("id");
        $(".Edit-user-btn").click();
        $.ajax({
            type: "GET",
            url: `/GetUser/${UserId}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                console.log(data.Image);
                $("#UserName").val(data.name);
                $(".User-profile-pic").attr("src", data.Image);
                $("#UserEmail").val(data.email);
                $("#UserphoneNo").val(data.phone_no);
                $("#UserStatus").val(data.status);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });
    // Update btn Function
    $(".Update_user_btn").click(function (e) {
        e.preventDefault();
        let formData = new FormData($("#EditUserForm")[0]);
        let name = $("#UserName").val();
        let email = $("#UserEmail").val();
        let PhoneNo = $("#UserphoneNo").val();
        if (!name || !email || !PhoneNo) {
            ShowError(
                "Name,Email and Phone Number are required feilds to fill "
            );
        } else if (!emailRegex.test(email)) {
            ShowError("Please enter a valid email address");
        } else if (PhoneNo.length !== 10) {
            ShowError("Please enter a valid Phone no");
        } else {
            $.ajax({
                type: "POST",
                url: `/updateUser/${UserId}`,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $(".close_usermodal-btn").click();
                    LoadUsers();
                    ShowToast(data.message);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }
    });
    // DLT BTN FUNCTION
    $(document).on("click", ".user-dlt-btn", function () {
        let UserId = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/deleteUser/${UserId}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                LoadUsers();
                ShowToast(data.message);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
    // To Get Users by search bar
    $(".user-serach-btn").click(function (e) {
        e.preventDefault();
        let searchValue = $(".user-search-bar").val();

        $.ajax({
            type: "GET",
            url: `/GetSearchedUsers/${searchValue}`,
            success: function (data) {
                console.log(data);
                Showpagination(data);
                $("#user-search-bar").val("");
                let container = $(".user-aside-table-content");
                container.empty();
                if (data && data.length > 0) {
                    $.each(data.users, function (index, User) {
                        const statusHTML =
                            User.status === "active"
                                ? `<td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                              Active
                            </span>
                          </td>`
                                : `<td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700">
                              Block
                            </span>
                          </td>`;

                        container.append(`<tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <!-- Avatar with inset shadow -->
                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                              <img class="object-cover w-full h-full rounded-full" src="${User.Image}" alt="" loading="lazy" />
                              <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                            </div>
                            <div>
                              <p class="font-semibold"> ${User.name}</p>
                            </div>
                          </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                          ${User.email}
                        </td>
                        <td class="px-4 py-3 text-xs">
                          <span class="px-2 py-1 text-sm">
                            ${User.phone_no}
                          </span>
                        </td>
                       
                        ${statusHTML}
                     
                        <td class="px-4 flex justify-center py-3 text-sm blog-action">
                                    <div class="flex gap-2">
                                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 user-edit-btn" data-id="${User.id}">Edit</button>
                                    <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 user-dlt-btn" data-id="${User.id}">Delete</button>
                                </div>
        
                                    </td>
                        </tr>
        
                      `);
                    });
                } else {
                    container.append(`<td class="px-4 py-3 blog-title-container">
                        <div class="flex items-center text-sm">
                            <p class="font-semibold blog-title">No User Found </p>
                        </div>
                    </td>`);
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
    });
});
