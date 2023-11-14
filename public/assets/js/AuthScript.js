$(document).ready(function () {
    const emailRegex =
        /^[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*@[a-zA-Z]+(?:\.[a-zA-Z]+)*$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

    // FUNCTION TO SHOW ERROR TOAST
    function showErrorToast(errorMessage) {
        $.toast({
            heading: "Error",
            text: errorMessage,
            showHideTransition: "slide",
            icon: "error",
        });
    }

    // Function To Show Success toast
    // function ShowToast(data) {
    //     $.toast({
    //         heading: "Success",
    //         text: data,
    //         showHideTransition: "slide",
    //         icon: "success",
    //     });
    // }
    // LOGIN FUNCTION
    $(".login-btn").click(function (e) {
        e.preventDefault();
        let email = $("#login-email").val();
        let password = $("#login-password").val();
        // let formData = new FormData($("#LoginFom")[0]);

        // console.log(email, password);
        if (email == "" || password == "") {
            showErrorToast("All fields are mandatory to fill");
        } else if (!emailRegex.test(email)) {
            showErrorToast("Please enter a valid email address");
        } else {
            $.ajax({
                type: "POST",
                url: "/login",

                data: { email, password },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (data) {
                    $.toast({
                        heading: "Success",
                        text: "Login successfully!!",
                        showHideTransition: "slide",
                        icon: "success",
                        hideAfter: 1000,
                        afterHidden: function () {
                            console.log("hlo");
                            window.location.href = data.url;
                        },
                    });
                },
                error: function (err) {
                    console.log(err.responseText);
                },
            });
        }
    });
    // Register Functionilty
    $(".register-btn").click(function (e) {
        e.preventDefault();
        let formData = new FormData($("#registerForm")[0]);
        let name = $("#UserName").val();
        let email = $("#UserEmail").val();
        let phone_no = $("#UserPhoneNo").val();
        let password = $("#UserPassword").val();
        let confirmPassword = $("#ConfirmPassword").val();
        let Image = $("#UserImage").val();

        if (
            name === "" ||
            email === "" ||
            phone_no === "" ||
            password === "" ||
            confirmPassword === "" ||
            Image === ""
        ) {
            showErrorToast("All fields are mandatory to fill");
        } else if (!emailRegex.test(email)) {
            showErrorToast("Please enter a valid email address");
        } else if (phone_no.length !== 10) {
            showErrorToast("Please enter a valid Phone no");
        } else if (!passwordRegex.test(password)) {
            showErrorToast(
                "Passwords should have one capital letter, one small, and be 8 characters long"
            );
        } else if (password !== confirmPassword) {
            showErrorToast("Passwords do not match");
        } else {
            $.ajax({
                type: "POSt",
                url: "/register",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $.toast({
                        heading: "Success",
                        text: "Registration successfully",
                        showHideTransition: "slide",
                        icon: "success",
                        hideAfter: 1000,
                        afterHidden: function () {
                            window.location.href = data.url;
                        },
                    });
                },
                error: function (err) {
                    console.log(err.responseText);
                },
            });
        }
    });
});
