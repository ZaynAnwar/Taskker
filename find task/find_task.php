<?php 

    session_start();

    require('../connection.php');

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Task | Taskker</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="find_task.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="main-header">
            <h1>Find Task</h1>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search for tasks...">
                <button class="search-btn"><i class="ri-search-line"></i></button>
            </div>
        </header>

        <!-- Filter Section -->
        <section class="filters island">
            <h2>Filter Tasks</h2>
            <form id="filterForm">
                <div class="filter-group">
                    <label for="category">Category</label>
                    <select id="category">
                        <option value="All">All</option>
                        <option value="electrician">Electrician</option>
                        <option value="plumber">Plumber</option>
                        <option value="mechanic">Mechanic</option>
                        <option value="gardener">Gardener</option>
                        <option value="Painter">Painter</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" placeholder="Enter location">
                </div>

                <div class="filter-group">
                    <label for="date">Date</label>
                    <input type="date" id="date">
                </div>

                <button type="submit" class="filter-btn">Apply Filters</button>
            </form>
        </section>

        <!-- Task Listings Section -->
        <section class="task-listings island" id="taskListings">
            <h2>Available Tasks</h2>
            <!-- Add more tasks as needed -->
        </section>
    </div>

    <script src="find_task.js"></script>


    <script>
        var isSearching;
        $(document).ready(function() {
        isSearching = false;

        // Handle search input changes
        $("#searchInput").keyup(function() {
            if (!isSearching) {
                var searchTerm = $(this).val();
                searchTasks(searchTerm);
                isSearching = true; 
            }
        });

        $("#filterForm").submit(function(e) {
            e.preventDefault(); // Prevent default form submission
            var category = $("#category").val();
            var location = $("#location").val();
            var date = $("#date").val();
            console.log(date);
            searchTasks("", category, location, date); // Clear search term for filtering

            // Reset filter options
            $("#date").val("");
        });

        // Initial search for all tasks
        searchTasks();
        });

        function searchTasks(searchTerm, category, location, date) {
            if (isSearching) {
                return; 
            }

            isSearching = true;

            $.ajax({
                url: "getTasks.php",
                type: "POST",
                data: { search: searchTerm, category: category, location: location, date: date },
                success: function(data) {
                    $("#taskListings").html(data);
                    isSearching = false;
                }
            });
        }

        function apply(taskId) { 
            event.preventDefault();
            // Perform AJAX request to apply for the task
            $.ajax({
                url: "apply.php",
                type: "POST",
                data: { taskId: taskId },
                success: function(response) {
                    console.log(response);
                    response = JSON.parse(response);
                    let taskId = response.taskId;
                    console.log("taskId: " + taskId);
                    let element = document.getElementById("btn_" + taskId);

                    
                    if (element) {
                        element.outerHTML = "<p>Already Applied</p>";
                    } else {
                        console.error("Element not found for taskId:", taskId);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + error);
                }
            });
        }
    </script>
</body>
</html>
