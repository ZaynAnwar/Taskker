document.addEventListener("DOMContentLoaded", function() {
    // Get social login buttons
    var googleBtn = document.querySelector(".google");
    var facebookBtn = document.querySelector(".facebook");
    var appleBtn = document.querySelector(".apple");
  
    // Add event listeners to handle button clicks
    googleBtn.addEventListener("click", function(event) {
      event.preventDefault();
      // Handle Google sign up (you can implement your logic here)
      console.log("Signing up with Google...");
    });
  
    facebookBtn.addEventListener("click", function(event) {
      event.preventDefault();
      // Handle Facebook sign up (you can implement your logic here)
      console.log("Signing up with Facebook...");
    });
  
    appleBtn.addEventListener("click", function(event) {
      event.preventDefault();
      // Handle Apple sign up (you can implement your logic here)
      console.log("Signing up with Apple...");
    });
  });
  