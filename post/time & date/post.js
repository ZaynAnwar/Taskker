// const text=document.getElementById("text")
// const date=document.getElementById("date")
// const error=document.getElementById("error")

// text.addEventListener('submit',e =>{

//     validateinputs();
// });

// const setError = (element,message) =>{
//     const inputcontrol = element.parentElement;
//     const errordisplay = inputcontrol.querySelector('.error')

//     errordisplay.innertext = message;
//     inputcontrol.classList.add('error');
//     inputcontrol.classList.remove('success');
// }
// const setSuccess = (element,message) =>{
//     const inputcontrol = element.parentElement;
//     const errordisplay = inputcontrol.querySelector('.error')

//     errordisplay.innertext = '';
//     inputcontrol.classList.add('success');
//     inputcontrol.classList.remove('error');
// }

// const validateinputs=()=>{
//     const title= text.value.trim();
//     const data= date.value.trim();

//     if(title === ''){
//         setError(title, 'Field is required')
//     }else{
//         setSuccess(title)
//     }
// }

var btn1 = document.getElementById("btn1");
var btn2 = document.getElementById("btn2");
var btn3 = document.getElementById("btn3");

function clicked() {
  btn1.addEventListener("click", function () {
    document.querySelector("#ckb").style.display = "block";
  });
  btn2.addEventListener("click", function () {
    document.querySelector("#ckb").style.display = "block";
  });
  btn3.addEventListener("click", function () {
    document.querySelector("#ckb").style.display = "block";
  });
}
clicked();

function checked() {
  chb.addEventListener("change", function () {
    if (this.checked) {
      document.querySelector("#extraa").style.display = "block";
    } else {
      document.querySelector("#extraa").style.display = "none";
    }
  });
}
checked();

function togglePressed() {
  document.querySelector("#demo").classList.toggle("pressed");
}
function togglePressed1() {
  document.querySelector("#demo1").classList.toggle("pressed");
}
function togglePressed2() {
  document.querySelector("#demo2").classList.toggle("pressed");
}
function togglePressed3() {
  document.querySelector("#demo3").classList.toggle("pressed");
}

// function myFunction() {
//     document.querySelector("#demo").style.backgroundColor = "#e4ebe4";
//     document.querySelector("#demo").style.border = "2px solid #14a800";
// }
// function myFunction1() {
//     document.querySelector("#demo1").style.backgroundColor = "#e4ebe4";
//     document.querySelector("#demo1").style.border = "2px solid #14a800";
// }
// function myFunction2() {
//     document.querySelector("#demo2").style.backgroundColor = "#e4ebe4";
//     document.querySelector("#demo2").style.border = "2px solid #14a800";
// }
// function myFunction3() {
//     document.querySelector("#demo3").style.backgroundColor = "#e4ebe4";
//     document.querySelector("#demo3").style.border = "2px solid #14a800";
// }

// Function to update the error message
 function updateErrorMessage() {
  var dateInputs = document.querySelectorAll(
    '#dateFieldset input[type="date"]'
  );
  var errorMessagesDiv = document.getElementById("errorMessages");
  var filled = false;

  // Check if at least one date input is filled
  for (var i = 0; i < dateInputs.length; i++) {
    if (dateInputs[i].value.trim() !== "") {
      filled = true;
      break;
    }
  }

  // Update the error message based on whether at least one date is filled
  if (!filled) {
    errorMessagesDiv.textContent = "*Field is required";
  } else {
    errorMessagesDiv.textContent = ""; // Clear the error message
  }
}

// Add event listeners to date inputs to update the error message when filled or changed
var dateInputs = document.querySelectorAll('#dateFieldset input[type="date"]');
dateInputs.forEach(function (input) {
  input.addEventListener("change", updateErrorMessage); // Listen for changes in the date inputs
});

// Add event listener to the form for final validation before submission
document.getElementById("myForm").addEventListener("submit", function (event) {
  updateErrorMessage(); // Update the error message before form submission
  var errorMessagesDiv = document.getElementById("errorMessages");

  // Prevent form submission if error message is not cleared
  if (errorMessagesDiv.textContent !== "") {
    event.preventDefault();
  }
});
