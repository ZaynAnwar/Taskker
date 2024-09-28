document.querySelector('.forgot-password-form').addEventListener('submit', function(event) {
    const emailField = document.getElementById('email').value;
    
    if (!emailField) {
        alert('Please enter your email');
        event.preventDefault();
    } else {
        alert('A password reset link has been sent to your email address.');
    }
});
