document.addEventListener('DOMContentLoaded', () => {
    //adminlogin
    const adminLoginForm = document.getElementById("admin-login-form");
    function adminLogin() {
        adminLoginForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const form = adminLoginForm;
            const formData = new FormData(form);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "admin_login.php", true);

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
                window.location.href = 'admin_dashboard.php';
            }, 500); // 3000 milliseconds = 3 seconds

        } else {
            loginMessage.classList.add('error');
        }
    }
    if (adminLoginForm) {
        adminLogin();
        passwordToggle();
    }

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

    // function to dynamically display county & town 
    const countySelect = document.querySelector('#countySelect');
    const townSelect = document.querySelector('#townSelect');
    function countyTownSelect() {
        const countyTowns = {
            Baringo: ['Kabarnet', 'Eldama Ravine', 'Marigat'],
            Bomet: ['Bomet Town', 'Sotik', 'Chepalungu'],
            Bungoma: ['Bungoma Town', 'Webuye', 'Kimilili'],
            Busia: ['Busia Town', 'Nambale', 'Malaba'],
            'Elgeyo-Marakwet': ['Iten', 'Kapsowar', 'Chepkorio'],
            Embu: ['Embu Town', 'Runyenjes', 'Siakago'],
            Garissa: ['Garissa Town', 'Dadaab', 'Masalani'],
            'Homa Bay': ['Homa Bay Town', 'Mbita', 'Oyugis'],
            Isiolo: ['Isiolo Town', 'Garbatulla', 'Merti'],
            Kajiado: ['Kajiado Town', 'Kitengela', 'Ngong'],
            Kakamega: ['Kakamega Town', 'Mumias', 'Lugari'],
            Kericho: ['Kericho Town', 'Litein', 'Kipkelion'],
            Kiambu: ['Thika', 'Ruiru', 'Gatundu'],
            Kilifi: ['Kilifi Town', 'Malindi', 'Watamu'],
            Kirinyaga: ['Kerugoya', 'Kutus', 'Kagio'],
            Kisii: ['Kisii Town', 'Ogembo', 'Suneka'],
            Kisumu: ['Kisumu City', 'Ahero', 'Maseno'],
            Kitui: ['Kitui Town', 'Mwingi', 'Kyuso'],
            Kwale: ['Kwale Town', 'Ukunda', 'Msambweni'],
            Laikipia: ['Nanyuki', 'Nyahururu', 'Rumuruti'],
            Lamu: ['Lamu Town', 'Mokowe', 'Shela'],
            Machakos: ['Machakos Town', 'Mlolongo', 'Kangundo'],
            Makueni: ['Wote', 'Makueni Town', 'Mtito Andei'],
            Mandera: ['Mandera Town', 'Elwak', 'Takaba'],
            Marsabit: ['Marsabit Town', 'Moyale', 'Loiyangalani'],
            Meru: ['Meru Town', 'Timau', 'Nkubu'],
            Migori: ['Migori Town', 'Awendo', 'Isebania'],
            Mombasa: ['Mombasa City', 'Likoni', 'Nyali'],
            "Murang'a": ['Muranga Town', 'Kangema', 'Kiria-ini'],
            Nairobi: ['Westlands', 'Karen', 'Eastleigh'],
            Nakuru: ['Nakuru Town', 'Naivasha', 'Gilgil'],
            Nandi: ['Kapsabet', 'Nandi Hills', 'Mosoriot'],
            Narok: ['Narok Town', 'Kilgoris', 'Ololulung’a'],
            Nyamira: ['Nyamira Town', 'Keroka', 'Ekerenyo'],
            Nyandarua: ['Ol Kalou', 'Engineer', 'Njabini'],
            Nyeri: ['Nyeri Town', 'Othaya', 'Karatina'],
            Samburu: ['Maralal', 'Baragoi', 'Wamba'],
            Siaya: ['Siaya Town', 'Bondo', 'Usenge'],
            'Taita-Taveta': ['Voi', 'Taveta', 'Wundanyi'],
            'Tana River': ['Hola', 'Garsen', 'Bura'],
            'Tharaka-Nithi': ['Chuka', 'Marimanti', 'Mitunguu'],
            'Trans Nzoia': ['Kitale', 'Kiminini', 'Endebess'],
            Turkana: ['Lodwar', 'Lokichoggio', 'Kakuma'],
            'Uasin Gishu': ['Eldoret', 'Turbo', 'Ziwa'],
            Vihiga: ['Mbale', 'Luanda', 'Chavakali'],
            Wajir: ['Wajir Town', 'Habaswein', 'Griftu'],
            'West Pokot': ['Kapenguria', 'Chepareria', 'Sigor'],
        };

        function createOptionElement(value, text) {
            const option = document.createElement('option');
            option.value = value;
            option.textContent = text;
            return option;
        }

        function populateDropdown(dropdown, options) {
            dropdown.innerHTML = dropdown.options[0].outerHTML;

            const fragment = document.createDocumentFragment();
            options.forEach((option) => {
                fragment.appendChild(createOptionElement(option, option));
            });
            dropdown.appendChild(fragment);
        }

        function populateCountyDropdown() {
            const counties = Object.keys(countyTowns).sort();
            populateDropdown(countySelect, counties);
        }

        function updateTownDropdown() {
            const selectedCounty = countySelect.value;
            const towns = countyTowns[selectedCounty] || [];
            populateDropdown(townSelect, towns);
        }

        populateCountyDropdown();
        countySelect.addEventListener('change', updateTownDropdown);
    }

    //function to set max date to avoid unrealistic dates 
    function setMaxDate() {
        const today = new Date();
        const eighteenYearsAgo = new Date(today.setFullYear(today.getFullYear() - 18));
        const maxDate = eighteenYearsAgo.toISOString().split('T')[0];
        document.getElementById('dob').setAttribute('max', maxDate);
    }

    // Staff Register Form Validator
    const staffRegisterForm = document.getElementById("staff-register-form");
    function staffFormValidator() {
        const createPassword = staffRegisterForm.querySelector("#create-pass");
        const confirmPassword = staffRegisterForm.querySelector("#confirm-pass");
        const confirmPassError = staffRegisterForm.querySelector("#confirm-pass-error");

        staffRegisterForm.addEventListener("submit", function (event) {
            let isValid = true;

            // Validate password match
            if (createPassword.value !== confirmPassword.value) {
                isValid = false;
                confirmPassError.textContent = 'Passwords do not match';
                confirmPassError.style.color = 'red';
            } else {
                confirmPassError.textContent = '';
            }

            if (!isValid) {
                event.preventDefault();
                return; // Stop execution
            }

            event.preventDefault();
            submitFormData();
        });
    }
    // submit staff registration data 
    function submitFormData() {
        const formData = new FormData(staffRegisterForm);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "admin_add_staff.php", true);

        // Set up a handler for the response
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log("Form submitted successfully:", xhr.responseText);
                displayModal(xhr.responseText);
                form.reset();
            } else {
                console.error("Error submitting form:", xhr.status, xhr.statusText);
                displayModal(xhr.responseText);
            }
        };

        // Handle network errors
        xhr.onerror = function () {
            console.error("Network error occurred");
            // alert("Network error occurred while submitting the form.");
            displayModal("Network error occurred Try Again Later.");
        };

        // Send the request
        xhr.send(formData);
    }
    // display pop-message after sign-up
    function displayModal(message) {
        const parsedMessage = JSON.parse(message);
        console.log(parsedMessage.type);
        console.log(parsedMessage.message);

        const modalOverlay = document.getElementById('modal-overlay');
        modalOverlay.style.display = 'flex';

        const titleElement = modalOverlay.querySelector('.title');
        const messageElement = modalOverlay.querySelector('.message');
        titleElement.textContent = parsedMessage.type.charAt(0).toUpperCase() + parsedMessage.type.slice(1);
        messageElement.textContent = parsedMessage.message;

        const checkCircle = modalOverlay.querySelector('.check-circle');
        const svg = checkCircle.querySelector('svg');

        if (parsedMessage.type === 'error') {
            svg.innerHTML = `
                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    `;
            checkCircle.style.backgroundColor = '#ff3333';
        } else {
            svg.innerHTML = `
                        <polyline points="20 6 9 17 4 12" stroke="#ffffff"></polyline>
                    `;
            checkCircle.style.backgroundColor = '#4BB543';
        }
        const okButton = modalOverlay.querySelector('.ok-button');
        okButton.onclick = function () {
            if (parsedMessage.type === 'success') {
                window.location.href = 'admin_staff_manager.php';
            } else {
                modalOverlay.style.display = 'none';
            }
        };
    }

    // staff register 
    if (staffRegisterForm) {
        console.log("Hello");
        passwordToggle();
        countyTownSelect();
        setMaxDate();
        staffFormValidator();
    }
});