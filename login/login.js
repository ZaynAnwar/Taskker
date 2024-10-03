document.addEventListener("DOMContentLoaded", function () {
  var googleBtn = document.querySelector(".google");
  var facebookBtn = document.querySelector(".facebook");
  var appleBtn = document.querySelector(".apple");

  googleBtn.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("Signing up with Google...");
  });

  facebookBtn.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("Signing up with Facebook...");
  });

  appleBtn.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("Signing up with Apple...");
  });
});

document
  .getElementById("loginForm")
  .addEventListener("submit", function (event) {
    const userType = document.querySelector(
      'input[name="userType"]:checked'
    ).value;
    console.log(`User Type: ${userType}`);

    if (userType === "serviceSeeker") {
    } else if (userType === "serviceProvider") {
    }
});
