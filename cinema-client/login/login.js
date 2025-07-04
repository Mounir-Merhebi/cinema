document.addEventListener('DOMContentLoaded', () => {

    const loginForm = document.querySelector('form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const messageDisplay = document.getElementById('loginMessage');

    loginForm.addEventListener('submit', async (event) => {
        event.preventDefault(); 

        const email = emailInput.value;
        const password = passwordInput.value;

        messageDisplay.textContent = '';
        messageDisplay.className = ''; 

        try {
            const response = await axios.post('../../cinema-server/controllers/login_controller.php', {
                email: email,
                password: password
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });

            const responseData = response.data;
            if (responseData.success) {
                messageDisplay.textContent = responseData.message;
                messageDisplay.classList.add('success-message');
                
                if (responseData.userId) {
                    localStorage.setItem('userId', responseData.userId); 
                } else {
                    console.warn("Login successful, but userId not received in response. This might cause issues later.");
                }

               
                window.location.href = '../home/home.html'; 
               

            } else {
                messageDisplay.textContent = responseData.message;
                messageDisplay.classList.add('error-message');
            }

        } catch (error) {
            messageDisplay.textContent = "An error occurred. Please try again.";
            messageDisplay.classList.add('error-message');
            console.error("Login Error:", error); 
        }
    });
});