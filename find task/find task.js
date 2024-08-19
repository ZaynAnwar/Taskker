document.addEventListener('DOMContentLoaded', function() {
    const menuIcon = document.querySelector('.menu-icon');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.overlay');
    const closeBtn = document.querySelector('.close-btn');

    menuIcon.addEventListener('click', function() {
        sidebar.style.right = '0';
        overlay.style.opacity = '1';
        overlay.style.visibility = 'visible';
    });

    closeBtn.addEventListener('click', function() {
        sidebar.style.right = '-250px';
        overlay.style.opacity = '0';
        overlay.style.visibility = 'hidden';
    });

    overlay.addEventListener('click', function() {
        sidebar.style.right = '-250px';
        overlay.style.opacity = '0';
        overlay.style.visibility = 'hidden';
    });
});
