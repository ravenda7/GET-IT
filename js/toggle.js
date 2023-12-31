
document.addEventListener("DOMContentLoaded", function () {
  const togglePassword = document.querySelector("#toggle-password");
  const passwordField = document.querySelector("#password-field");

  togglePassword.addEventListener("click", function () {
    const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
    passwordField.setAttribute("type", type);
    if (type === "password") {
      togglePassword.querySelector("i").classList.remove("fa-solid", "fa-eye");
      togglePassword.querySelector("i").classList.add("fa-solid", "fa-eye-slash");
    } else {
      togglePassword.querySelector("i").classList.remove("fa-solid", "fa-eye-slash");
      togglePassword.querySelector("i").classList.add("fa-solid", "fa-eye");
    }
  });
});
