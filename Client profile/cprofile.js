document.getElementById('appointmentsTab').addEventListener('click', function() {
    document.getElementById('appointmentsContent').classList.remove('hidden');
    document.getElementById('invoicesContent').classList.add('hidden');
    this.classList.add('active');
    document.getElementById('invoicesTab').classList.remove('active');
});

document.getElementById('invoicesTab').addEventListener('click', function() {
    document.getElementById('invoicesContent').classList.remove('hidden');
    document.getElementById('appointmentsContent').classList.add('hidden');
    this.classList.add('active');
    document.getElementById('appointmentsTab').classList.remove('active');
});



// Toggle Profile Edit Popup visibility
function toggleProfileEditPopup() {
    var popup = document.getElementById('profile-edit-popup');
    if (popup.style.display === 'none' || popup.style.display === '') {
      popup.style.display = 'block';
    } else {
      popup.style.display = 'none';
    }
  }
  
  // Save Profile Changes
  function saveProfileChanges() {
    var name = document.getElementById('edit-name').value;
    var email = document.getElementById('edit-email').value;
    var gender = document.getElementById('edit-gender').value;
    var notifications = document.getElementById('notifications-toggle').checked;

    console.log("Sending data:", { name, email, gender, notifications }); // Log data being sent
  

    $.ajax({
      url: 'save-profile-changes.php',
      type: 'POST',
      data: {
        name: name,
        email: email,
        gender: gender,
        notifications: notifications
      },
      success: function(response) {
        console.log(response);
        $('#uname').text(name);
        $('#uemail').text(email);
        $('#ugender').text(gender);
      },
      error: function(error) {
        console.error("Error:", status, error);
      }
    })
  
    // Update the profile with new values (You can send this data to the server here)
    //alert('Profile updated:\nName: ' + name + '\nEmail: ' + email + '\nGender: ' + gender + '\nNotifications: ' + (notifications ? 'Enabled' : 'Disabled'));
  
    // Close the popup after saving changes
    toggleProfileEditPopup();
  }
  
  // Upload and Preview Profile Picture
  function previewPicture(event) {
    var output = document.getElementById('picture-preview');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src); // free memory
    }
  }
  
