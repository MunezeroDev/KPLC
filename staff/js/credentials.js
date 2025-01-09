document.addEventListener('DOMContentLoaded', () => {
    // function to toggle password visibility
    function passwordToggle() {
        // SVG paths for visibility states
        const pathInitial = 'M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Z';
        const pathToggled = 'm644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z';

        document.querySelectorAll('.password-wrapper').forEach((wrapper, index) => {
            const icon = wrapper.querySelector('.icon');
            const iconPath = icon.querySelector('path');
            iconPath.id = `icon-path-${index}`;

            const passwordInput = wrapper.querySelector('input[type="password"]');

            let toggled = false;

            icon.addEventListener('click', () => {
                toggled = !toggled;
                iconPath.setAttribute('d', toggled ? pathToggled : pathInitial);
                passwordInput.type = toggled ? 'text' : 'password';
            });
        });
    }

    //staff 
    const staffLoginForm = document.getElementById('staff-form');
    function staffLogin() {
        staffLoginForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const form = staffLoginForm;
            const formData = new FormData(form);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "staff-login.php", true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    loginMessage(xhr.responseText);
                    form.reset();
                } else {
                    loginMessage(xhr.responseText);
                }
            };

            xhr.onerror = function () {
                loginMessage("Network error occurred Try Again Later.");
            };

            xhr.send(formData);
        });
    }
    // show login message 
    function loginMessage(message) {
        const parsedMessage = JSON.parse(message);
        let messagelogin = parsedMessage.message;
        let loginstatus = parsedMessage.status;
        const loginMessage = document.querySelector('.alert-message');
        loginMessage.style.display = 'flex';

        const messageHeader = loginMessage.querySelector('h1');
        messageHeader.textContent = messagelogin;

        loginMessage.classList.remove('success', 'error');

        if (loginstatus === 'success') {
            loginMessage.classList.add('success');
            setTimeout(() => {
                window.location.href = 'staff_dashboard.php';
            }, 500); // 3000 milliseconds = 3 seconds

        } else {
            loginMessage.classList.add('error');
        }
    }
    if (staffLoginForm) {
        staffLogin();
        passwordToggle();
    }

});