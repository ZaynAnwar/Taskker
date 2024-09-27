/*
// Sample task data (could be dynamically loaded from backend)
const taskDetails = {
    title: "Electrical Repair",
    category: "Electrician",
    location: "Satellite Town, Bahawalpur",
    date: "2024-09-10",
    price: "5,000 PKR",
    description: "Need an electrician to fix wiring issues in the living room and replace a faulty socket. Must be available by 10th September and bring all required tools.",
    provider: {
        name: "John Doe",
        rating: "4.8/5",
        experience: "5 years",
        availability: "Mon-Fri, 9 AM - 6 PM"
    }
};

// Function to populate task details on page load
function loadTaskDetails() {
    document.getElementById('taskTitle').innerText = taskDetails.title;
    document.getElementById('taskCategory').innerHTML = `Category: <strong>${taskDetails.category}</strong>`;
    document.getElementById('taskLocation').innerHTML = `Location: <strong>${taskDetails.location}</strong>`;
    document.getElementById('taskDate').innerHTML = `Date: <strong>${taskDetails.date}</strong>`;
    document.getElementById('taskPrice').innerHTML = `Price: <strong>${taskDetails.price}</strong>`;
    document.getElementById('taskDescription').innerText = taskDetails.description;

    // Provider details
    document.querySelector('.provider-info-text p strong').innerText = taskDetails.provider.name;
    document.querySelector('.provider-info-text .rating').innerText = taskDetails.provider.rating;
    document.querySelector('.provider-info-text p:nth-child(3)').innerText = `Experience: ${taskDetails.provider.experience}`;
    document.querySelector('.provider-info-text p:nth-child(4)').innerText = `Availability: ${taskDetails.provider.availability}`;
}

// Load task details when page loads
window.onload = loadTaskDetails;
*/