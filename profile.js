        // JavaScript to handle modals
        const editProfileButton = document.getElementById('editProfileButton');
        const changePasswordButton = document.getElementById('changePasswordButton');
        const editNotificationsButton = document.getElementById('editNotificationsButton');
        const editProfileModal = document.getElementById('editProfileModal');
        const changePasswordModal = document.getElementById('changePasswordModal');
        const editNotificationsModal = document.getElementById('editNotificationsModal');
        const closeButtons = document.querySelectorAll('.close');

        editProfileButton.onclick = () => editProfileModal.style.display = 'block';
        changePasswordButton.onclick = () => changePasswordModal.style.display = 'block';
        editNotificationsButton.onclick = () => editNotificationsModal.style.display = 'block';

        closeButtons.forEach(btn => {
            btn.onclick = () => {
                editProfileModal.style.display = 'none';
                changePasswordModal.style.display = 'none';
                editNotificationsModal.style.display = 'none';
            }
        });

        window.onclick = (event) => {
            if (event.target.classList.contains('modal')) {
                editProfileModal.style.display = 'none';
                changePasswordModal.style.display = 'none';
                editNotificationsModal.style.display = 'none';
            }
        }