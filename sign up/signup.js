// document.getElementById('signupForm').addEventListener('submit', function(event) {
//     event.preventDefault(); // Prevent form submission
    
//     // Fetch form data
//     var formData = new FormData(this);
    
//     // You can handle form submission here, for example:
//     // 1. Send form data to server using AJAX
//     // 2. Validate form fields
//     // 3. Redirect to another page
    
//     // For this example, let's log the form data to the console
//     for (var pair of formData.entries()) {
//       console.log(pair[0] + ': ' + pair[1]);
//     }
//   });
  
//   // Function to check if at least one date input is filled
//   function isAnyDateFilled() {
//     var dateInputs = document.querySelectorAll('#dateFieldset input[type="date"]');
    
//     for (var i = 0; i < dateInputs.length; i++) {
//       if (dateInputs[i].value.trim() !== '') {
//         return true;
//       }
//     }
    
//     return false;
//   }
  
//   // Function to handle form submission
//   function handleSubmit(event) {
//     if (!isAnyDateFilled()) {
//       event.preventDefault(); // Prevent form submission if no date is filled
//       document.getElementById('errorMessages').textContent = 'Please fill in at least one date.';
//     }
//   }
  
//   // Add event listener to the form for validation
//   document.getElementById('myForm').addEventListener('submit', handleSubmit);
  
//   // Add event
  









// Code below is not required. Do not uncomment anything below. it will genrate unexpected behaviour. 

/*


document.getElementById('signupForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the form from submitting normally

  const urlParams = new URLSearchParams(window.location.search);
  // Check if the "type" parameter exists and equals "tasker"
  if (urlParams.has('type') && urlParams.get('type') === 'tasker') {
      // Custom logic for taskers
      window.location.href = '/Projects/new/become tasker/taskerform/tskrform.html';
  } else {
      // Redirect to the main page if the user is not a tasker
      window.location.href = '/Projects/new/index.html';
  }
});

*/