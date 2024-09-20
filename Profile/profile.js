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
    var location = document.getElementById('edit-location').value;
    var gender = document.getElementById('edit-gender').value;
    var notifications = document.getElementById('notifications-toggle').checked;
  
    // Update the profile with new values (You can send this data to the server here)
    alert('Profile updated:\nName: ' + name + '\nLocation: ' + location + '\nGender: ' + gender + '\nNotifications: ' + (notifications ? 'Enabled' : 'Disabled'));
  
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
  


  const carousel = document.getElementById("reviewCarousel");
  let isPaused = false;

  function autoSlide() {
    if (!isPaused) {
      carousel.scrollLeft += 1; // Move carousel to the right
      if (carousel.scrollLeft >= carousel.scrollWidth - carousel.clientWidth) {
        carousel.scrollLeft = 0; // Reset to start if end reached
      }
    }
  }

  // Auto slide every 20ms
  let slideInterval = setInterval(autoSlide, 20);

  // Pause sliding on hover
  carousel.addEventListener("mouseenter", () => {
    isPaused = true;
  });

  // Resume sliding when hover ends
  carousel.addEventListener("mouseleave", () => {
    isPaused = false;
  });