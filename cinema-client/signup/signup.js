document.addEventListener('DOMContentLoaded', () => {
    const signupForm = document.querySelector('form');
    const fullnameInput = document.getElementById('fullname'); 
    const emailInput = document.getElementById('email');
    const mobileNumberInput = document.getElementById('mobile'); 
    const passwordInput = document.getElementById('password');
    const dobInput = document.getElementById('dob'); 
    const termsCheckbox = document.getElementById('terms'); 

    const messageDisplay = document.getElementById('signupMessage'); 

    signupForm.addEventListener('submit', async (event) => {
        event.preventDefault(); 

  
        const fullname = fullnameInput.value;
        const email = emailInput.value;
        const mobile_number = mobileNumberInput.value; 
        const password = passwordInput.value;
        const dateOfBirth = dobInput.value;

      
        if (!termsCheckbox.checked) {
            messageDisplay.textContent = 'You must agree to the Terms of Service and Privacy Policy.';
            messageDisplay.className = 'response-message error-message'; 
            return; 
        }

       
        messageDisplay.textContent = '';
        messageDisplay.className = ''; 

        try {
            const response = await axios.post('../../cinema-server/controllers/signup_controller.php', {
                fullname: fullname,
                email: email,
                mobile_number: mobile_number, 
                password: password,
                date_of_birth: dateOfBirth
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' 
                }
            });

            const responseData = response.data;

            if (responseData.success) {
                messageDisplay.textContent = responseData.message + " Redirecting to login...";
                messageDisplay.classList.add('success-message'); 

    
                setTimeout(() => {
                    window.location.href = '../login/login.html';
                }, 2000);

            } else {
                messageDisplay.textContent = responseData.message;
                messageDisplay.classList.add('error-message'); 
            }

        } catch (error) {
            messageDisplay.textContent = "An error occurred during registration. Please try again.";
            messageDisplay.classList.add('error-message'); 
            console.error("Signup Error:", error); 
        }
    });
});
