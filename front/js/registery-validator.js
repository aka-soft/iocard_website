$(document).ready(() => {
    var username = document.getElementById("username");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var passwordConfirm = document.getElementById("passwordConfirm");
    var submitReg = document.getElementById("submitReg");

    const usernameRegex = /^[a-zA-Z0-9@]+$/;
    const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{1,3})$/;

    function validateUsername() {
        var usernameValue = username.value.match(usernameRegex);

        if (username.value.length <= 0) {
            username.setCustomValidity("نام کاربری خالی میباشد !");
            return false;
        } else {
            username.setCustomValidity('');
        }

        if (username.value.length < 4) {
            username.setCustomValidity("تعداد کاراکتر های وارد شده زیر 4 کاراکتر میباشد !");
            return false;
        } else {
            username.setCustomValidity('');
        }

        if (usernameValue === null) {
            username.setCustomValidity("کاراکتر های مجاز بکار رفته باید شامل حروف الفبا یا اعداد یا @ باشد");
            return false;
        } else {
            username.setCustomValidity('');
        }

        return true;
    }

    function validateEmail() {
        var emailValue = email.value.match(emailRegex);

        if (email.value.length <= 0) {
            email.setCustomValidity("ایمیل خالی میباشد !");
            return false;
        } else {
            email.setCustomValidity('');
        }

        if (emailValue === null) {
            email.setCustomValidity("ایمیل وارد شده صحیح نمیباشد !");
            return false;
        } else {
            email.setCustomValidity('');
        }

        return true;
    }

    function validatePassword() {
        if (password.value.length <= 0) {
            password.setCustomValidity("رمز عبور خالی میباشد !");
            return false;
        } else {
            password.setCustomValidity('');
        }

        if (password.value.length < 8) {
            password.setCustomValidity("تعداد کاراکتر های وارد شده زیر 8 کاراکتر میباشد !");
            return false;
        } else {
            password.setCustomValidity('');
        }

        if (password.value != passwordConfirm.value) {
            passwordConfirm.setCustomValidity("پسورد های وارد شده مطابقت ندارند !");
            return false;
        } else {
            passwordConfirm.setCustomValidity('');
        }

        return true;
    }

    username.addEventListener("focusout", validateUsername);
    email.addEventListener("focusout", validateEmail);
    password.addEventListener("focusout", validatePassword);

    submitReg.addEventListener("click", () => {
        validateUsername();
        validateEmail();
        validatePassword();
    });
});