// Handle Star Rating
const stars = document.querySelectorAll('.rating-stars i');
let selectedRating = 0;

stars.forEach(star => {
    star.addEventListener('click', function() {
        selectedRating = this.getAttribute('data-value');
        stars.forEach(s => s.classList.remove('active'));
        for (let i = 0; i < selectedRating; i++) {
            stars[i].classList.add('active');
        }
    });
});

// Handle Review Submission
const submitReviewBtn = document.getElementById('submitReviewBtn');
submitReviewBtn.addEventListener('click', () => {
    const reviewText = document.getElementById('reviewText').value.trim();
    if (selectedRating === 0 || reviewText === "") {
        alert("Please provide a rating and review.");
    } else {
        alert(`Review submitted!\nRating: ${selectedRating} stars\nReview: ${reviewText}`);
    }
});
