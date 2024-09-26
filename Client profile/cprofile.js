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


  
  // Upload and Preview Profile Picture
  function previewPicture(event) {
    var output = document.getElementById('picture-preview');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src); // free memory
    }
  }
  
