var countries = [
  "Islamabad",
  "Ahmed Nager",
  "Ahmadpur East",
  "Ali Khan",
  "Alipur",
  "Arifwala",
  "Attock",
  "Bhera",
  "Bhalwal",
  "Bahawalnagar",
  "Bahawalpur",
  "Bhakkar",
  "Burewala",
  "Chillianwala",
  "Chakwal",
  "Chichawatni",
  "Chiniot",
  "Chishtian",
  "Daska",
  "Darya Khan",
  "Dera Ghazi",
  "Dhaular",
  "Dina",
  "Dinga",
  "Dipalpur",
  "Faisalabad",
  "Fateh Jhang",
  "Ghakhar Mandi",
  "Gojra",
  "Gujranwala",
  "Gujrat",
  "Gujar Khan",
  "Hafizabad",
  "Haroonabad",
  "Hasilpur",
  "Haveli",
  "Lakha",
  "Jalalpur",
  "Jattan",
  "Jampur",
  "Jaranwala",
  "Jhang",
  "Jhelum",
  "Kalabagh",
  "Karor Lal",
  "Kasur",
  "Kamalia",
  "Kamoke",
  "Khanewal",
  "Khanpur",
  "Kharian",
  "Khushab",
  "Kot Adu",
  "Jauharabad",
  "Lahore",
  "Lalamusa",
  "Layyah",
  "Liaquat Pur",
  "Lodhran",
  "Malakwal",
  "Mamoori",
  "Mailsi",
  "Mandi Bahauddin",
  "mian Channu",
  "Mianwali",
  "Multan",
  "Murree",
  "Muridke",
  "Mianwali Bangla",
  "Muzaffargarh",
  "Narowal",
  "Okara",
  "Renala Khurd",
  "Pakpattan",
  "Pattoki",
  "Pir Mahal",
  "Qaimpur",
  "Qila Didar",
  "Rabwah",
  "Raiwind",
  "Rajanpur",
  "Rahim Yar",
  "Rawalpindi",
  "Sadiqabad",
  "Safdarabad",
  "Sahiwal",
  "Sangla Hill",
  "Sarai Alamgir",
  "Sargodha",
  "Shakargarh",
  "Sheikhupura",
  "Sialkot",
  "Sohawa",
  "Soianwala",
  "Siranwali",
  "Talagang",
  "Taxila",
  "Toba Tek",
  "Vehari",
  "Wah Cantonment",
  "Wazirabad",
  "Badin",
  "Bhirkan",
  "Rajo Khanani",
  "Chak",
  "Dadu",
  "Digri",
  "Diplo",
  "Dokri",
  "Ghotki",
  "Haala",
  "Hyderabad",
  "Islamkot",
  "Jacobabad",
  "Jamshoro",
  "Jungshahi",
  "Kandhkot",
  "Kandiaro",
  "Karachi",
  "Kashmore",
  "Keti Bandar",
  "Khairpur",
  "Kotri",
  "Larkana",
  "Matiari",
  "Mehar",
  "Mirpur Khas",
  "Mithani",
  "Mithi",
  "Mehrabpur",
  "Moro",
  "Nagarparkar",
  "Naudero",
  "Naushahro Feroze",
  "Naushara",
  "Nawabshah",
  "Nazimabad",
  "Qambar",
  "Qasimabad",
  "Ranipur",
  "Ratodero",
  "Rohri",
  "Sakrand",
  "Sanghar",
  "Shahbandar",
  "Shahdadkot",
  "Shahdadpur",
  "Shahpur Chakar",
  "Shikarpaur",
  "Sukkur",
  "Tangwani",
  "Tando Adam",
  "Tando Allahyar",
  "Tando Muhammad",
  "Thatta",
  "Umerkot",
  "Warah",
  "Abbottabad",
  "Adezai",
  "Alpuri",
  "Akora Khattak",
  "Ayubia",
  "Banda Daud",
  "Bannu",
  "Batkhela",
  "Battagram",
  "Birote",
  "Chakdara",
  "Charsadda",
  "Chitral",
  "Daggar",
  "Dargai",
  "Darya Khan",
  "dera Ismail",
  "Doaba",
  "Dir",
  "Drosh",
  "Hangu",
  "Haripur",
  "Karak",
  "Kohat",
  "Kulachi",
  "Lakki Marwat",
  "Latamber",
  "Madyan",
  "Mansehra",
  "Mardan",
  "Mastuj",
  "Mingora",
  "Nowshera",
  "Paharpur",
  "Pabbi",
  "Peshawar",
  "Saidu Sharif",
  "Shorkot",
  "Shewa Adda",
  "Swabi",
  "Swat",
  "Tangi",
  "Tank",
  "Thall",
  "Timergara",
  "Tordher",
  "Awaran",
  "Barkhan",
  "Chagai",
  "Dera Bugti",
  "Gwadar",
  "Harnai",
  "Jafarabad",
  "Jhal Magsi",
  "Kacchi",
  "Kalat",
  "Kech",
  "Kharan",
  "Khuzdar",
  "Killa Abdullah",
  "Killa Saifullah",
  "Kohlu",
  "Lasbela",
  "Lehri",
  "Loralai",
  "Mastung",
  "Musakhel",
  "Nasirabad",
  "Nushki",
  "Panjgur",
  "Pishin valley",
  "Quetta",
  "Sherani",
  "Sibi",
  "Sohbatpur",
  "Washuk",
  "Zhob",
  "Ziarat",
];

function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function (e) {
    var a,
      b,
      i,
      val = this.value;
    /*close any already open lists of autocompleted values*/
    closeAllLists();
    if (!val) {
      return false;
    }
    currentFocus = -1;
    /*create a DIV element that will contain the items (values):*/
    a = document.createElement("DIV");
    a.setAttribute("id", this.id + "autocomplete-list");
    a.setAttribute("class", "autocomplete-items");
    /*append the DIV element as a child of the autocomplete container:*/
    this.parentNode.appendChild(a);
    /*for each item in the array...*/
    for (i = 0; i < arr.length; i++) {
      /*check if the item starts with the same letters as the text field value:*/
      if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
        /*create a DIV element for each matching element:*/
        b = document.createElement("DIV");
        /*make the matching letters bold:*/
        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
        b.innerHTML += arr[i].substr(val.length);
        /*insert a input field that will hold the current array item's value:*/
        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
        /*execute a function when someone clicks on the item value (DIV element):*/
        b.addEventListener("click", function (e) {
          /*insert the value for the autocomplete text field:*/
          inp.value = this.getElementsByTagName("input")[0].value;
          /*close the list of autocompleted values,
                (or any other open lists of autocompleted values:*/
          closeAllLists();
        });
        a.appendChild(b);
      }
    }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function (e) {
    var x = document.getElementById(this.id + "autocomplete-list");
    if (x) x = x.getElementsByTagName("div");
    if (e.keyCode == 40) {
      /*If the arrow DOWN key is pressed,
          increase the currentFocus variable:*/
      currentFocus++;
      /*and and make the current item more visible:*/
      addActive(x);
    } else if (e.keyCode == 38) {
      //up
      /*If the arrow UP key is pressed,
          decrease the currentFocus variable:*/
      currentFocus--;
      /*and and make the current item more visible:*/
      addActive(x);
    } else if (e.keyCode == 13) {
      /*If the ENTER key is pressed, prevent the form from being submitted,*/
      e.preventDefault();
      if (currentFocus > -1) {
        /*and simulate a click on the "active" item:*/
        if (x) x[currentFocus].click();
      }
    }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = x.length - 1;
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
      except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
    closeAllLists(e.target);
  });
}
/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), countries);

function checked(){
    chb.addEventListener('change', function() {
        if (this.checked) {
            document.querySelector("#map").style.display = "block"    
        } else {
            document.querySelector("#map").style.display = "none"    
        }
      });
}
checked()


const map = L.map('map'); 
// Initializes map

map.setView([51.505, -0.09], 13); 
// Sets initial coordinates and zoom level

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map); 
// Sets map data source and associates with map

let marker, circle, zoomed;

navigator.geolocation.getCurrentPosition(success, error);

function success(pos) {

    const lat = pos.coords.latitude;
    const lng = pos.coords.longitude;
    const accuracy = pos.coords.accuracy;

    if (marker) {
        map.removeLayer(marker);
        map.removeLayer(circle);
    }
    // Removes any existing marker and circule (new ones about to be set)

    marker = L.marker([lat, lng]).addTo(map);
    circle = L.circle([lat, lng], { radius: accuracy }).addTo(map);
    // Adds marker to the map and a circle for accuracy

    if (!zoomed) {
        zoomed = map.fitBounds(circle.getBounds()); 
    }
    // Set zoom to boundaries of accuracy circle

    map.setView([lat, lng]);
    // Set map focus to current user position

}

function error(err) {

    if (err.code === 1) {
        alert("Please allow geolocation access");
    } else {
        alert("Cannot get current location");
    }

}