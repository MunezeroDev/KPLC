document.addEventListener('DOMContentLoaded', () => {
    // drop  sidebar-submenu
    function toggleDropMenu() {
        const toggleButtons = document.querySelectorAll('.drop-submenu-button');

        toggleButtons.forEach(toggleButton => {
            toggleButton.addEventListener('click', () => {

                const activeSubMenu = document.querySelector('.sub-menu.active');
                const activeIcon = document.querySelector('.drop-submenu-icon.active');

                const toggleIcon = toggleButton.querySelector('.drop-submenu-icon');
                const subMenu = toggleButton.closest('.nav-item').querySelector('.sub-menu');

                if (activeSubMenu && activeSubMenu !== subMenu) {
                    activeSubMenu.classList.remove('active');
                    activeIcon.classList.remove('active');

                    activeSubMenu.addEventListener('transitionend', () => {
                        subMenu.classList.add('active');
                        toggleIcon.classList.add('active');
                    }, { once: true });
                } else {

                    subMenu.classList.toggle('active');
                    toggleIcon.classList.toggle('active');
                }
            });
        });

    }
    toggleDropMenu();

    // toggle sidebar 
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const toggleButton = document.querySelector('#toggle-sidebar');

        toggleButton.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });

        const navItems = document.querySelectorAll('.nav-item');

        navItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                // When an item is hovered, toggle the 'close' class on the sidebar
                if (sidebar.classList.contains('close')) {
                    sidebar.classList.remove('close');
                }
            });

        });
    }
    toggleSidebar();

    /// drop user menu
    function dropUserMenu() {
        const profileButton = document.querySelector('.user-profile-btn');
        const dropdown = document.querySelector('.user-profile-dropdown');

        if (profileButton && dropdown) {
            profileButton.addEventListener('click', () => {
                // Toggle the "hidden" attribute on the dropdown
                const isHidden = dropdown.hasAttribute('hidden');
                if (isHidden) {
                    dropdown.removeAttribute('hidden');
                } else {
                    dropdown.setAttribute('hidden', '');
                }
            });

            // Close the dropdown when clicking outside
            document.addEventListener('click', (event) => {
                if (!profileButton.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.setAttribute('hidden', '');
                }
            });
        }
    }
    dropUserMenu();

    //toggle staff container 
    function assignmentToggle() {
        const assignToggleBtn = document.querySelector('.assign-btn');
        const taskContainer = document.querySelector('.assign-task-container');
        if (taskContainer) {
            const assignContainerClose = document.querySelector('.assign-close-btn');
            assignToggleBtn.addEventListener('click', () => {
                taskContainer.classList.toggle('hidden');
            });
            assignContainerClose.addEventListener('click', () => {
                taskContainer.classList.toggle('hidden');
            });
        }
    }
    assignmentToggle();

    // get connection 
    function getConnection() {
        document.querySelectorAll('.assign-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                changeAvailability(id);
            });
        });

    }
    getConnection();

    // change changeAvailability
    function changeAvailability(connectionId) {
        // Remove existing event listeners by cloning and replacing elements
        document.querySelectorAll('.assign-staff-link').forEach(link => {
            const newLink = link.cloneNode(true);
            link.parentNode.replaceChild(newLink, link);

            newLink.addEventListener('click', function () {
                const staffId = this.dataset.staffId;
                // console.log('Assigned staff ID:', staffId);
                // console.log('Connection ID:', connectionId);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_staff_availability.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.status === 'success') {
                                alert(response.message);
                                // Update UI to reflect the change
                                // newLink.classList.add('disabled');
                                // newLink.textContent = 'Assigned';
                                // Optionally refresh the page or update other UI elements
                                // location.reload();
                                console.log('Assigned staff ID:', staffId);
                                console.log('Connection ID:', connectionId);
                                console.log(response.message);
                                displayAlert(response.message);
                                // sendNotification(staffId, connectionId, response.message);
                            } else {
                                alert('Error: ' + response.message);
                            }
                        } catch (e) {
                            console.error('JSON parsing error:', e);
                            alert('Error processing response');
                        }
                    } else {
                        alert('Server error: ' + xhr.status);
                    }
                };

                const data = 'staff_id=' + encodeURIComponent(staffId) +
                    '&connection_id=' + encodeURIComponent(connectionId);
                xhr.send(data);
            });
        });
    }

    function displayAlert(message, duration = 10000) {
        const alertElement = document.querySelector('.full-width-alert');
        const messageElement = alertElement.querySelector('.message');

        messageElement.textContent = message;

        alertElement.classList.remove('success', 'error', 'warning', 'info');
        alertElement.classList.add('success');

        alertElement.classList.add('display');

        const actionButton = alertElement.querySelector('.action-button');
        actionButton.addEventListener('click', () => {
            alertElement.classList.remove('display');
        });

        if (duration) {
            setTimeout(() => {
                alertElement.classList.remove('display');
            }, duration);
        }
    }



    // ..............
});




