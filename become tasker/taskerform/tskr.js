// script.js
document.addEventListener("DOMContentLoaded", function() {
    const taskerForm = document.getElementById("taskerForm");
    const progressBar = document.querySelector(".progress");
    const inputs = taskerForm.querySelectorAll("input, textarea, select");
  
    // Update progress bar based on completion of form fields
    function updateProgressBar() {
      const completedFields = Array.from(inputs).filter(input => input.validity.valid).length;
      const totalFields = inputs.length;
      const progress = (completedFields / totalFields) * 100;
      progressBar.style.width = `${progress}%`;
    }
  
    // Listen for input changes and update progress bar
    inputs.forEach(input => {
      input.addEventListener("input", updateProgressBar);
    });
  
    // Image preview functionality
    const profileImageInput = document.getElementById("profileImage");
    const profileImagePreview = document.createElement("img");
    profileImagePreview.style.maxWidth = "100%";
    profileImageInput.addEventListener("change", function(event) {
      const file = event.target.files[0];
      const reader = new FileReader();
      reader.onload = function(e) {
        profileImagePreview.src = e.target.result;
      }
      reader.readAsDataURL(file);
    });
    taskerForm.insertBefore(profileImagePreview, taskerForm.querySelector("button"));
  
    /*
    // Submit form
    taskerForm.addEventListener("submit", function(event) {
      event.preventDefault();
      if (!taskerForm.checkValidity()) {
        alert("Please fill out all required fields.");
        return;
      }
      // Here you would send form data to the backend for processing
      // For simplicity, we'll just log the form data to the console
      const formData = new FormData(taskerForm);
      for (const [name, value] of formData.entries()) {
        console.log(`${name}: ${value}`);
      }
      // After processing the form data, you can redirect the user or show a success message
    });*/
  });
  