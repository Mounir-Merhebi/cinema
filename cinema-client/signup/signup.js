document.addEventListener('DOMContentLoaded', () => {
    // Get references to the HTML elements for the signup form
    const signupForm = document.querySelector('form');
    const fullnameInput = document.getElementById('fullname'); // Targets id="fullname" now
    const emailInput = document.getElementById('email');
    const mobileNumberInput = document.getElementById('mobile'); // Reference for mobile number input
    const passwordInput = document.getElementById('password');
    const dobInput = document.getElementById('dob'); // Assuming 'dob' is for date of birth
    const termsCheckbox = document.getElementById('terms'); // Checkbox for terms agreement

    // Assume a message display area already exists in HTML with this ID
    const messageDisplay = document.getElementById('signupMessage'); // Target the new message div

    // Add an event listener to the form for its 'submit' event
    signupForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Prevents the browser's default form submission (page reload)

        // Get the current values from the input fields
        const fullname = fullnameInput.value;
        const email = emailInput.value;
        const mobile_number = mobileNumberInput.value; // Get value for mobile number
        const password = passwordInput.value;
        const dateOfBirth = dobInput.value;

        // Basic client-side validation for terms agreement
        if (!termsCheckbox.checked) {
            messageDisplay.textContent = 'You must agree to the Terms of Service and Privacy Policy.';
            messageDisplay.className = 'response-message error-message'; // Apply error styling
            return; // Stop the function if terms are not accepted
        }

        // Clear any previous messages and styling
        messageDisplay.textContent = '';
        messageDisplay.className = ''; // Clear existing styling classes

        try {
            // Send a POST request to your signup controller
            // PATH: '../../cinema-server/controllers/signup_controller.php'
            // This path is relative from C:\xampp\htdocs\Cinema\cinema-client\signup\
            // to C:\xampp\htdocs\Cinema\cinema-server\controllers\
            const response = await axios.post('../../cinema-server/controllers/signup_controller.php', {
                fullname: fullname,
                email: email,
                mobile_number: mobile_number, // Sending mobile_number to the backend
                password: password,
                date_of_birth: dateOfBirth
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' // Tells PHP to use $_POST
                }
            });

            // Axios automatically parses JSON responses. response.data will be a JavaScript object.
            const responseData = response.data;

            if (responseData.success) {
                // If signup was successful
                messageDisplay.textContent = responseData.message + " Redirecting to login...";
                messageDisplay.classList.add('success-message'); // Apply success styling

                // Redirect to the login page after a short delay
                // PATH: '../login/login.html' (relative from signup/ to login/)
                setTimeout(() => {
                    window.location.href = '../login/login.html';
                }, 2000); // Redirect after 2 seconds

            } else {
                // If signup failed, display the specific error message from the backend
                messageDisplay.textContent = responseData.message;
                messageDisplay.classList.add('error-message'); // Apply error styling
            }

        } catch (error) {
            // This block handles network errors or other unexpected issues with the request
            messageDisplay.textContent = "An error occurred during registration. Please try again.";
            messageDisplay.classList.add('error-message'); // Apply error styling for general errors
            console.error("Signup Error:", error); // Log full error to console for debugging
        }
    });
});
