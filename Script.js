var typed = new Typed(".typ", {
  strings: [
    "Electrician",
    "Plumber",
    "Mechanic",
    "Painter",
    "Gardner",
    "Cleaner",
    "Locksmith",
    "Welder",
    "Much more",
  ],
  typeSpeed: 40,
  backSpeed: 40,
  loop: true,
});






// sidebar
const menuIcon = document.querySelector(".menu-icon");
const sidebar = document.querySelector(".sidebar");
const closeBtn = document.querySelector(".sidebar .close-btn");
const overlay = document.querySelector(".overlay");

menuIcon.addEventListener("click", () => {
  sidebar.classList.add("show");
  overlay.classList.add("show");
  document.body.style.overflow = "hidden"; // Prevent scrolling when sidebar is open
});

closeBtn.addEventListener("click", () => {
  sidebar.classList.remove("show");
  overlay.classList.remove("show");
  document.body.style.overflow = "auto"; // Re-enable scrolling when sidebar is closed
});

// Close the sidebar and overlay when clicking outside
document.addEventListener("click", (e) => {
  if (
    !sidebar.contains(e.target) &&
    !menuIcon.contains(e.target) &&
    !overlay.contains(e.target)
  ) {
    sidebar.classList.remove("show");
    overlay.classList.remove("show");
    document.body.style.overflow = "auto";
  }
});
