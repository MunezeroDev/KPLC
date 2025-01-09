document.addEventListener('DOMContentLoaded', () => {
    // droo sidebar-submenu
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

    // alert after update
    function displayAlert(message, type = 'success', duration = 5000) {

        const parsedMessage = JSON.parse(message);

        const alertElement = document.querySelector('.full-width-alert');
        const messageElement = alertElement.querySelector('.message');

        messageElement.textContent = parsedMessage.message;

        alertElement.classList.remove('success', 'error', 'warning', 'info');
        alertElement.classList.add(type);

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

    // connection submission
    const connectionform = document.getElementById('conn_form');
    if (connectionform) {
        function submitReport() {
            connectionform.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(connectionform);
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "connection_handler.php", true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        displayAlert(xhr.responseText);
                        console.log("Sucess");
                        connectionform.reset();
                    } else {
                        displayAlert(xhr.responseText);
                        console.log("Error");
                    }
                };

                // Handle network errors
                xhr.onerror = function () {
                    displayAlert(xhr.responseText);
                    console.log("Network Error");
                };

                // Send the request
                xhr.send(formData);
            });
        }
        submitReport();
    }

    // fault submission
    const faultform = document.getElementById('report_fault');
    if (faultform) {
        function submitReport() {
            faultform.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(faultform);
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "repault_fault_handler.php", true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        displayAlert(xhr.responseText);
                        faultform.reset();
                    } else {
                        displayAlert(xhr.responseText);
                    }
                };

                xhr.onerror = function () {
                    displayAlert(xhr.responseText);
                };

                xhr.send(formData);
            });
        }
        submitReport();
    }

    // outage submission 
    const outageform = document.getElementById('report_outage');
    if (outageform) {
        outageform.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(outageform);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "report_outage_handler.php", true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    displayAlert(xhr.responseText);
                    // console.log("Sucess");
                    outageform.reset();
                } else {
                    // displayAlert('An error occurred', 'error');
                    displayAlert(xhr.responseText);
                    // console.log("Error");
                }
            };

            // Handle network errors
            xhr.onerror = function () {
                // displayAlert("Network error occurred. Try Again Later.", 'error');
                // console.log("Network Error");
                displayAlert(xhr.responseText);
            };

            // Send the request
            xhr.send(formData);
        });
    }

    // fraud-submission 
    const reportFraud = document.getElementById('report-fraud');
    if (reportFraud) {
        function submitReport() {
            reportFraud.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(reportFraud);
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "report_fraud_handler.php", true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        displayAlert(xhr.responseText);
                        reportFraud.reset();
                    } else {
                        displayAlert(xhr.responseText);
                    }
                };

                xhr.onerror = function () {
                    displayAlert(xhr.responseText);
                };

                // Send the request
                xhr.send(formData);
            });
        }
        submitReport();
    }

    //Display alert function
    function displayAlert(message, duration = 10000) {
        const alertElement = document.querySelector('.full-width-alert');
        const messageElement = alertElement.querySelector('.message');

        const parsedMessage = JSON.parse(message);
        messageElement.textContent = parsedMessage.message;

        alertElement.classList.remove('success', 'error', 'warning', 'info');
        alertElement.classList.add(parsedMessage.status);

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

    //toggle staff container 
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

    function getConnection() {
        document.querySelectorAll('.assign-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                changeAvailability(id);
            });
        });

    }
    getConnection();


    function changeAvailability(connectionId) {
        // Remove existing event listeners by cloning and replacing elements
        document.querySelectorAll('.assign-staff-link').forEach(link => {
            const newLink = link.cloneNode(true);
            link.parentNode.replaceChild(newLink, link);

            newLink.addEventListener('click', function () {
                const staffId = this.dataset.staffId;
                console.log('Assigned staff ID:', staffId);
                console.log('Connection ID:', connectionId);

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
                                location.reload();
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
    // ..............
}); 