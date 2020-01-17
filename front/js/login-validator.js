$(document).ready(() => {
    var emailLogin = document.getElementById("emailLogin");
    var passwordLogin = document.getElementById("passwordLogin");
    var submitLogin = document.getElementById("submitLogin");

    const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{1,3})$/;

    function validateEmail() {
        var emailValue = emailLogin.value.match(emailRegex);

        if (emailLogin.value.length <= 0) {
            emailLogin.setCustomValidity("ایمیل خالی میباشد !");
            return false;
        } else {
            emailLogin.setCustomValidity('');
        }

        if (emailValue === null) {
            emailLogin.setCustomValidity("ایمیل وارد شده صحیح نمیباشد !");
            return false;
        } else {
            emailLogin.setCustomValidity('');
        }

        return true;
    }

    function validatePassword() {
        if (passwordLogin.value.length <= 0) {
            passwordLogin.setCustomValidity("رمز عبور خالی میباشد !");
            return false;
        } else {
            passwordLogin.setCustomValidity('');
        }

        if (passwordLogin.value.length < 8) {
            passwordLogin.setCustomValidity("تعداد کاراکتر های وارد شده زیر 8 کاراکتر میباشد !");
            return false;
        } else {
            passwordLogin.setCustomValidity('');
        }

        return true;
    }

    emailLogin.addEventListener("focusout", validateEmail);
    passwordLogin.addEventListener("focusout", validatePassword);

    submitLogin.addEventListener("click", () => {
        validateUsername();
        validateEmail();
        validatePassword();
    });
});