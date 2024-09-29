document.getElementById("change-password-form").addEventListener("submit", function (event) {
    event.preventDefault();
    const newPassword = document.getElementById("new-password").value;
    const confirmPassword = document.getElementById("confirm-password").value;

    if (newPassword !== confirmPassword) {
      alert("Passwords do not match!");
      return;
    } else {
      alert("Password successfully updated!");
    }
  });
