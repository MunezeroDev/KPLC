document.addEventListener('DOMContentLoaded', () => {
  //START OF DOM LOADER


  function toggleAuthSections() {
    const article = document.querySelector('article');
    const registerLink = document.querySelector('#register-link');
    const loginLink = document.querySelector('#login-link');
    const loginWrapper = document.querySelector('#login-wrapper');
    const registerWrapper = document.querySelector('#registration-wrapper');
    registerWrapper.style.display = 'none';

    registerLink.addEventListener('click', () => {
      registerWrapper.style.display = 'block';
      loginWrapper.style.display = 'none';
      article.classList.replace('login', 'registration');
    });

    loginLink.addEventListener('click', () => {
      registerWrapper.style.display = 'none';
      loginWrapper.style.display = 'block';
      article.classList.replace('registration', 'login');
    });
  }
  toggleAuthSections();

 

  // Dynamically populate town/county dropdown
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


  //Dynamic password checking
  function PasswordStrengthChecker() {
    const passwordCriteria = {
      patterns: {
        lowercase: /[a-z]/,
        uppercase: /[A-Z]/,
        numbers: /\d/,
        specialChars: /[!@#$%^&*(),.?":{}|<>]/,
      },
      minLength: 8,
    };

    const inputProgressBar = {
      'create-pass': 'progress-bar-create',
      'confirm-pass': 'progress-bar-confirm',
      'change-pass': 'progress-bar-change',
      'confirm-change-pass': 'progress-bar-reset',
    };

    const passwordInputs = Object.keys(inputProgressBar)
      .map((id) => document.querySelector(`#${id}`))
      .filter(Boolean);

    if (passwordInputs.length > 0) {
      passwordInputs.forEach((input) => {
        input.addEventListener('keyup', (event) => {
          const progressBar = document.getElementById(
            inputProgressBar[event.target.id]
          );

          if (!progressBar) return;

          const password = event.target.value;

          const strengthScore = [
            // Each criteria contributes 1 point to the total score
            password.length >= passwordCriteria.minLength,
            passwordCriteria.patterns.lowercase.test(password),
            passwordCriteria.patterns.uppercase.test(password),
            passwordCriteria.patterns.numbers.test(password),
            passwordCriteria.patterns.specialChars.test(password),
          ].filter(Boolean).length;

          const progressSegments = Array.from(progressBar.children);

          progressSegments.forEach((segment) => {
            segment.style.opacity = '0';
          });

          progressSegments
            .slice(0, Math.min(strengthScore, progressSegments.length))
            .forEach((segment) => {
              segment.style.opacity = '1';
            });
        });
      });
    }
  }

  // Form Validator
  function FormValidator() {
    const form = document.getElementById('register-form');

    const firstName = document.getElementById('fname');
    const lastName = document.getElementById('lname');
    const dateOfBirth = document.getElementById('dob');
    const gender = document.getElementById('gender');
    const email = document.getElementById('email');
    const mobileNumber = document.getElementById('number');
    const IdNumber = document.getElementById('id');
    const connection = document.getElementById('connection');
    const createPassword = document.getElementById('create-pass');
    const confirmPassword = document.getElementById('confirm-pass');

    const firstNameError = document.getElementById('fname-error');
    const lastNameError = document.getElementById('lname-error');
    const dobError = document.getElementById('date-error');
    const genderError = document.getElementById('gender-error');
    const emailError = document.querySelector('.email-error');
    const numberError = document.getElementById('number-error');
    const IdError = document.getElementById('id-error');
    const connectionError = document.getElementById('connection-error');
    const countyError = document.getElementById('county-error');
    const townError = document.getElementById('town-error');
    const createPassError = document.getElementById('create-pass-error');
    const confirmPassError = document.getElementById('confirm-pass-error');

    const today = new Date();
    const maxDate = new Date(
      today.getFullYear() - 18,
      today.getMonth(),
      today.getDate()
    );
    const formattedDate = maxDate.toISOString().split('T')[0];
    dateOfBirth.setAttribute('max', formattedDate);

    function clearErrors() {
      firstNameError.textContent = '';
      lastNameError.textContent = '';
      dobError.textContent = '';
      genderError.textContent = '';
      emailError.textContent = '';
      numberError.textContent = '';
      IdError.textContent = '';
      connectionError.textContent = '';
      countyError.textContent = '';
      townError.textContent = '';
      createPassError.textContent = '';
      confirmPassError.textContent = '';

      // Remove any error styling classes
      [
        firstName,
        lastName,
        dateOfBirth,
        gender,
        email,
        mobileNumber,
        IdNumber,
        countySelect,
        townSelect,
        connection,
        createPassword,
        confirmPassword,
      ].forEach((input) => {
        input.classList.remove('error');
      });
    }

    function setError(element, errorElement, message) {
      errorElement.textContent = message;
      errorElement.classList.remove('password-text'); // Remove password-text class
      element.classList.add('error');
    }

    function validateEmail(email) {
      // Basic Gmail regex checker
      const gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
      return gmailRegex.test(email);
    }

    function validateMobileNumber(number) {
      // Check for either format: 0794949130 or +254794949130
      const localFormat = /^0[7][0-9]{8}$/;
      const internationalFormat = /^\+254[7][0-9]{8}$/;
      return localFormat.test(number) || internationalFormat.test(number);
    }

    function validateForm(e) {
      e.preventDefault();
      let isValid = true;
      clearErrors();

      // Validate First Name
      if (!firstName.value.trim()) {
        setError(firstName, firstNameError, 'Please enter your first name');
        isValid = false;
      }

      // Validate Last Name
      if (!lastName.value.trim()) {
        setError(lastName, lastNameError, 'Please enter your last name');
        isValid = false;
      }

      //   Gender validation
      if (!dateOfBirth.value) {
        setError(dateOfBirth, dobError, 'Please select your gender');
        isValid = false;
      }

      // Gender validation
      if (gender.value === 'Select gender' || !gender.value) {
        setError(gender, genderError, 'Please select your gender');
        isValid = false;
      }

      // Email validation
      if (!email.value.trim()) {
        setError(email, emailError, 'Please enter your email address');
        isValid = false;
      } else if (!validateEmail(email.value.trim())) {
        setError(email, emailError, 'Please enter a valid Gmail address');
        isValid = false;
      }

      // Mobile number validation
      if (!mobileNumber.value.trim()) {
        setError(mobileNumber, numberError, 'Please enter your mobile number');
        isValid = false;
      } else if (!validateMobileNumber(mobileNumber.value.trim())) {
        setError(
          mobileNumber,
          numberError,
          'Please enter a valid mobile number (0794949130 or +254794949130 format)'
        );
        isValid = false;
      }

      if (!IdNumber.value.trim()) {
        setError(IdNumber, IdError, 'Please enter your ID/Passport number');
        isValid = false;
      }

      // Connection type validation
      //   prettier-ignore
      if (connection.value === 'Select Home Connection Type' || !connection.value) {
        setError(
          connection,
          connectionError,
          'Please select your connection type'
        );
        isValid = false;
      }

      // County validation
      if (!countySelect.value) {
        setError(countySelect, countyError, 'Please select your county');
        isValid = false;
      }

      // Town validation
      if (!townSelect.value) {
        setError(townSelect, townError, 'Please select your town');
        isValid = false;
      }

      // Create password validation
      if (!createPassword.value.trim()) {
        setError(createPassword, createPassError, 'Please create a password');
        isValid = false;
      }

      // Confirm password validation
      if (!confirmPassword.value.trim()) {
        // prettier-ignore
        setError(confirmPassword, confirmPassError, 'Please confirm your password');
        isValid = false;
      } else if (confirmPassword.value !== createPassword.value) {
        setError(confirmPassword, confirmPassError, 'Passwords do not match');
        isValid = false;
      }

      if (isValid) {
        // If form is valid, you can submit it here
        console.log('Form is valid, submitting...');
        // form.submit();
        submitFormData();
      }
    }

    form.addEventListener('submit', validateForm);

    firstName.addEventListener('input', () => {
      firstNameError.textContent = '';
      firstName.classList.remove('error');
    });

    lastName.addEventListener('input', () => {
      lastNameError.textContent = '';
      lastName.classList.remove('error');
    });

    dateOfBirth.addEventListener('focus', () => {
      dateOfBirth.setAttribute('max', formattedDate);
    });

    dateOfBirth.addEventListener('input', () => {
      dobError.textContent = '';
      dateOfBirth.classList.remove('error');
    });

    gender.addEventListener('change', () => {
      genderError.textContent = '';
      gender.classList.remove('error');
    });

    email.addEventListener('input', () => {
      emailError.textContent = '';
      email.classList.remove('error');
    });

    mobileNumber.addEventListener('input', () => {
      numberError.textContent = '';
      mobileNumber.classList.remove('error');
    });

    connection.addEventListener('change', () => {
      connectionError.textContent = '';
      connection.classList.remove('error');
    });

    IdNumber.addEventListener('change', () => {
      IdError.textContent = '';
      IdNumber.classList.remove('error');
    });

    countySelect.addEventListener('change', () => {
      countyError.textContent = '';
      countySelect.classList.remove('error');
    });

    townSelect.addEventListener('change', () => {
      townError.textContent = '';
      townSelect.classList.remove('error');
    });

    createPassword.addEventListener('input', () => {
      createPassError.textContent = '';
      createPassError.classList.remove('password-text'); // Remove password-text class
      createPassword.classList.remove('error');
    });

    confirmPassword.addEventListener('input', () => {
      confirmPassError.textContent = '';
      confirmPassError.classList.remove('password-text'); // Remove password-text class
      confirmPassword.classList.remove('error');
      if (confirmPassword.value === createPassword.value) {
        confirmPassError.textContent = 'Passwords match';
        confirmPassError.style.color = 'green';
      }
    });
  }

  if (document.querySelector('#register-form')) {
    passwordToggle();
    countyTownSelect();
    PasswordStrengthChecker();
    FormValidator();
  }

  // Submit form data using ajax
  function submitFormData() {
    // Collect form data
    const formData = new FormData(document.getElementById('register-form'));

    fetch('register.php', {
      method: 'POST',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Alert user of success
          alert('Registration successful!');

          // Call the showFeedback function and pass the data
          showFeedback(data);

          // Delay redirect by 3 seconds
          setTimeout(function () {
            window.location.href = data.redirect;
          }, 3000); // 3000 milliseconds = 3 seconds
        } else {
          // Handle error message display
          alert('Registration failed: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during registration.');
      });
  }

  // Show feedback to user
  function showFeedback(data) {
    if (document.querySelector('#register-form')) {
      const messageBox = document.querySelector('.alert-message');
      messageBox.style.display = 'flex';
      const feedback = messageBox.querySelector('h1');
      if (data.message === 'User registered successfully.') {
        messageBox.classList.add('success');
        feedback.textContent = data.message;
      } else {
        messageBox.classList.add('error');
        feedback.textContent = data.message;
      }

    }
  }

  // handlelogin
  function handleLogin() {
    const loginForm = document.getElementById('login-form');
    if (!loginForm) return;

    // Get form elements
    const emailInput = loginForm.querySelector('input[name="login-email"]');
    const passwordInput = loginForm.querySelector('input[name="login-password"]');
    const loginButton = loginForm.querySelector('button[type="submit"]');
    const rememberMe = loginForm.querySelector('input[name="logCheck"]');

    // Simple validation function
    function validateForm() {
      // Clear previous errors
      clearErrors();

      let isValid = true;

      // Check email
      if (!emailInput.value.trim()) {
        showError(emailInput, 'Please enter your email');
        isValid = false;
      }

      // Check password
      if (!passwordInput.value.trim()) {
        showError(passwordInput, 'Please enter your password');
        isValid = false;
      }

      return isValid;
    }

    // Show error message
    function showError(element, message) {
      const errorElement = element.parentElement.parentElement.querySelector('small');
      errorElement.textContent = message;
      errorElement.classList.add('error-active');
      element.classList.add('error');
    }

    // Clear all errors
    function clearErrors() {
      loginForm.querySelectorAll('small').forEach(small => {
        small.textContent = '';
        small.classList.remove('error-active');
      });
      loginForm.querySelectorAll('.error').forEach(element => {
        element.classList.remove('error');
      });
    }

    // Show feedback message
    function showMessage(message, type = 'danger') {
      const alertDiv = document.createElement('div');
      alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
      alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
      loginForm.insertBefore(alertDiv, loginForm.firstChild);

      if (type === 'success') {
        setTimeout(() => alertDiv.remove(), 3000);
      }
    }

    // Handle form submission
    loginForm.addEventListener('submit', async function (e) {
      e.preventDefault();

      if (!validateForm()) return;

      // Prepare form data
      const formData = {
        email: emailInput.value.trim(),
        password: passwordInput.value.trim(),
        remember_me: rememberMe.checked
      };

      // Show loading state
      loginButton.disabled = true;
      loginButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Logging in...';

      try {
        const response = await fetch('login.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(formData)
        });

        // Add this check to handle non-200 responses
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (data.success) {
          showMessage(data.message, 'success');
          setTimeout(() => {
            window.location.href = data.redirect;
          }, 1000);
        } else {
          showMessage(data.message);
          passwordInput.value = '';
        }
      } catch (error) {
        console.error('Detailed error:', error);
        showMessage(`Connection error: ${error.message}`);
      } finally {
        loginButton.disabled = false;
        loginButton.textContent = 'Login';
      }
    });
  }
  handleLogin();

  //END OF DOCUMENT READY FUNCTION
});

// authentication.js:639 Detailed error: SyntaxError: Unexpected token '/', "// login.p"... is not valid JSON