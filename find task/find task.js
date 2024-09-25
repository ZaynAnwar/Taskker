// Initial task data (could be fetched from backend)
const tasks = [
    {
        id: 1,
        title: "Electrical Repair",
        category: "electrician",
        location: "Satellite Town, Bahawalpur",
        date: "2024-09-10",
        price: "5,000 PKR"
    },
    {
        id: 2,
        title: "Plumbing Service",
        category: "plumber",
        location: "Model Town, Lahore",
        date: "2024-09-12",
        price: "4,500 PKR"
    },
    {
        id: 3,
        title: "Gardening Work",
        category: "gardener",
        location: "Green Villas, Islamabad",
        date: "2024-09-15",
        price: "3,000 PKR"
    },
    {
        id: 4,
        title: "Car Mechanic",
        category: "mechanic",
        location: "F-10, Islamabad",
        date: "2024-09-20",
        price: "6,000 PKR"
    }
];

// Function to render task listings
function renderTasks(filteredTasks) {
    const taskListings = document.getElementById('taskListings');
    taskListings.innerHTML = ''; // Clear previous listings

    if (filteredTasks.length === 0) {
        taskListings.innerHTML = '<p>No tasks found.</p>';
        return;
    }

    filteredTasks.forEach(task => {
        const taskItem = document.createElement('div');
        taskItem.classList.add('task-item');

        taskItem.innerHTML = `
            <div class="task-info">
                <h3>${task.title}</h3>
                <p><strong>Location:</strong> ${task.location}</p>
                <p><strong>Date:</strong> ${task.date}</p>
                <p><strong>Price:</strong> ${task.price}</p>
            </div>
            <div class="task-actions">
                <button class="details-btn"><a href="/find task/details/details.html">View Details</a></button>
                <button class="apply-btn">Apply Now</button>
            </div>
        `;

        taskListings.appendChild(taskItem);
    });
}

// Filter tasks based on search and form inputs
function filterTasks(event) {
    event.preventDefault(); // Prevent form submission

    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const selectedCategory = document.getElementById('category').value;
    const locationInput = document.getElementById('location').value.toLowerCase();
    const selectedDate = document.getElementById('date').value;

    const filteredTasks = tasks.filter(task => {
        const matchesSearch = task.title.toLowerCase().includes(searchInput);
        const matchesCategory = selectedCategory === 'all' || task.category === selectedCategory;
        const matchesLocation = locationInput === '' || task.location.toLowerCase().includes(locationInput);
        const matchesDate = selectedDate === '' || task.date === selectedDate;

        return matchesSearch && matchesCategory && matchesLocation && matchesDate;
    });

    renderTasks(filteredTasks);
}

// Initial render of all tasks
renderTasks(tasks);

// Attach filter functionality
document.getElementById('filterForm').addEventListener('submit', filterTasks);
document.getElementById('searchInput').addEventListener('input', filterTasks);
