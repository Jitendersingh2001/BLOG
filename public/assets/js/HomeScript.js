$(document).ready(function () {
    let userId = $(".id").data("user-id");
    let currentpage = 0,
        nextpage = 1,
        totalPages;

    // Function to display user information
    function LoadUserData() {
        $.ajax({
            type: "GET",
            url: `GetUser/${userId}`,
            success: function (data) {
                // console.log(data);
                $(".User-name").text(`Welcome, ${data.name}`);
                $(".user-profile-pic").attr("src", data.Image);
            },
            error: function (err) {
                console.log(err);
            },
        });
    }
    // Function call
    ShowBlogs();
    ShowCategories();
    LoadUserData();
    // Function to show categories
    function ShowCategories() {
        $.ajax({
            type: "GET",
            url: "getCategories",
            success: function (data) {
                // console.log(data);
                CategoryContainer = $(".category-dropdown");
                CategoryContainer.empty();

                if (data && data.length > 0) {
                    $.each(data, function (index, category) {
                        CategoryContainer.append(
                            `
                            <li>
                            <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300">${category.category}</a>
                        </li>`
                        );
                    });
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
    }
    // Function to Show Blogs
    function ShowBlogs() {
        $.ajax({
            type: "GET",
            url: "GetBlogs",
            success: function (data) {
                // console.log(data);
                Showpagination(data);
                DisplayCards(data);
            },
            error: function (err) {
                console.log(err);
            },
        });
    }
    // funciton to display blogs in a card
    function DisplayCards(data) {
        console.log(data);
        let BlogContainer = $(".cards-container");
        BlogContainer.empty();

        if (data && data.length > 0) {
            $.each(
                data.slice(currentpage * 16, nextpage * 16),
                function (index, Blog) {
                    // Truncate description to three lines
                    let truncatedDescription = Blog.description
                        .split("\n")
                        .slice(0, 3)
                        .join(" ");
                    truncatedDescription =
                        truncatedDescription.length > 150
                            ? truncatedDescription.substring(0, 150) + "..."
                            : truncatedDescription;

                    BlogContainer.append(` 
                    <div class="transition-all duration-150 flex w-full blog-card px-4 py-6 md:w-1/2 lg:w-1/3">
                        <div class="flex flex-col items-stretch min-h-full pb-4 mb-6 transition-all duration-150 bg-white rounded-lg shadow-lg hover:shadow-2xl">
                            <div class="md:flex-shrink-0">
                                <img src="${Blog.BlogImage}" alt="Blog Cover" class="object-fill w-full h-56 rounded-lg rounded-b-none md:h-56" />
                            </div>
                            <div class="flex items-center justify-between px-4 py-2 overflow-hidden">
                                <span class="text-xs font-medium text-blue-600 uppercase">
                                    ${Blog.category}
                                </span>
                            </div>
                            <hr class="border-gray-300" />
                            <div class="flex flex-wrap items-center flex-1 px-4 py-1 text-center mx-auto">
                                <h2 class="text-base font-bold tracking-normal text-gray-800">
                                    ${Blog.title}
                                </h2>
                            </div>
                            <hr class="border-gray-300" />
                            <div class="w-full">
                                <p class="flex flex-row flex-wrap w-full px-4 py-2 overflow-hidden text-sm text-justify text-gray-700">
                                    ${truncatedDescription}
                                </p>
                            </div>
                            <hr class="border-gray-300" />
                            <section class="px-4 py-2 mt-2">
                                <div class="flex items-center justify-end">
                                    <a href="/GetSpecificBlog/${Blog.id}" class="mt-1 text-base text-gray-600 hover:text-blue-700">Read More</a>
                                </div>
                            </section>
                        </div>
                    </div>
                `);
                }
            );
        } else {
            BlogContainer.append(`

            <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow ">
               
                <p class="mb-3 font-normal text-gray-700 ">No Blog Found</p>
               
            </div>
            `);
        }
    }
    // Function to show blogs acc to category
    $(".category-dropdown").on("click", "li", function (event) {
        event.preventDefault();
        let Category = $(this).text().trim();
        // console.log(Category);
        $.ajax({
            type: "GET",
            url: `/GetCategoryBlogs/${Category}`,
            success: function (data) {
                console.log(data);
                $(".sidebar-close-btn").click();
                Showpagination(data);
                DisplayCards(data);
            },
            error: function (error) {
                console.error("AJAX request failed:", error);
            },
        });
    });

    // Function to Show pagination
    function Showpagination(data) {
        let pageSize = 16;
        if (data.length > pageSize) {
            $(".pagination").removeClass("hide");
        } else {
            $(".pagination").addClass("hide");
        }

        totalPages = Math.ceil(data.length / pageSize);
        if (totalPages > 1) {
            let pagination = $(".inner-pagenation");
            pagination.empty();
            for (let i = 0; i < totalPages; i++) {
                let buttonClass = i === currentpage ? "active" : "";
                pagination.append(
                    `<li>
                    <button class="page-btn-${i} ${buttonClass} px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                        ${i + 1}
                    </button>
                </li>`
                );
            }
        }

        // Add event listener for pagination buttons
        $(".inner-pagenation button").click(function () {
            currentpage = $(this).text() - 1;
            nextpage = currentpage + 1;
            ShowBlogs();
            updatePaginationButtons();
        });
        updatePaginationButtons();
    }

    // Function to Update Pagination btn
    function updatePaginationButtons() {
        $(".nxt-btn")
            .prop("disabled", nextpage >= totalPages)
            .toggleClass("disable", nextpage >= totalPages);
        $(".prv-btn")
            .prop("disabled", currentpage <= 0)
            .toggleClass("disable", currentpage <= 0);
    }
    // Pagination next btn
    $(".nxt-btn").click(function () {
        currentpage++;
        nextpage++;
        ShowBlogs();
        updatePaginationButtons();
    });
    // pagination prev btn
    $(".prv-btn").click(function () {
        if (currentpage > 0) {
            currentpage--;
            nextpage--;
            ShowBlogs();
            updatePaginationButtons();
        }
    });
});
