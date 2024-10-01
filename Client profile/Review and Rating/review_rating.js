// Handle Star Rating
const stars = document.querySelectorAll('.rating-stars i');
let selectedRating = 0;

stars.forEach(star => {
    star.addEventListener('click', function() {
        selectedRating = this.getAttribute('data-value');
        stars.forEach(s => {s.classList.remove('active'); });
        for (let i = 0; i < selectedRating; i++) {
            stars[i].classList.add('active');
        }
        
        handleRating(selectedRating);  // Call the function to handle rating submission
        
    });
});

function handleRating(rating) {
    $.ajax({
        url: 'handleRating.php',
        type: 'POST',
        data: {
            rating: rating,
            client: clientId,
            provider: providerID,
            task: taskId
        },
        success: function(response) {
            console.log(response);
            // Update UI with new rating
        },
        error: function(xhr, status, error) {
            console.error('Error submitting rating:', error);
        }
    });
}

$('#submitReviewBtn').on('click', function () {
    const reviewText = document.getElementById('reviewText').value.trim();
    if (reviewText === "") {
        alert("Please provide a review.");
    } else {
        console.log(`Review submitted:  ${reviewText}`);
        handleReview(reviewText);  // Call the function to handle review submission
    }
})

function handleReview(review) {
    $.ajax({
        url: 'handleReview.php',
        type: 'POST',
        data: {
            review: review,
            client: clientId,
            provider: providerID,
            task: taskId
        },
        success: function(response) {
            console.log(response);
            // Update UI with new review
        },
        error: function(xhr, status, error) {
            console.error('Error submitting review:', error);
        }
    });
}


// Handle Review Submission
/*
const submitReviewBtn = document.getElementById('submitReviewBtn');
submitReviewBtn.addEventListener('click', () => {
    const reviewText = document.getElementById('reviewText').value.trim();
    if (reviewText === "") {
        alert("Please provide a rating and review.");
    } else {
        alert(`Review submitted!\nRating: ${selectedRating} stars\nReview: ${reviewText}`);
    }
});
*/ 
// @Atif - I commented this because i think we should not force Client to give both review and stars
