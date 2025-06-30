document.addEventListener('DOMContentLoaded', async () => {
    const userId = localStorage.getItem('userId'); // Retrieve userId from Local Storage

    if (!userId) {
        // If no user ID found, the user is not "logged in" on the client side
        console.error("No user ID found in Local Storage. Redirecting to login.");
        alert("You are not logged in. Please log in to view your profile.");
        // Redirect to your login page. Adjust path as needed.
        window.location.href = '../login/login.html'; 
        return;
    }

    try {
        // Make an API call to your profile_controller.php
        // Adjust the path to profile_controller.php based on your project structure
        const response = await axios.get(`../../cinema-server/controllers/profile_controller.php?id=${userId}`);
        const responseData = response.data;

        if (responseData.success) {
            const user = responseData.user;
            // Populate the form fields in viewProfile.html with the received data
            document.getElementById('fullname').value = user.fullname;
            document.getElementById('email').value = user.email;
            document.getElementById('mobile').value = user.mobile_number;
            document.getElementById('dob').value = user.date_of_birth; 
            document.getElementById('createdAt').value = new Date(user.created_at).toLocaleDateString(); 

            const commPrefsSelect = document.getElementById('communicationPrefs');
            if (commPrefsSelect) {
                commPrefsSelect.value = user.communication_prefs;
            }

            // Update membership level display
            const membershipLevelInput = document.getElementById('membershipLevel');
            const membershipBadge = document.querySelector('.profile-card .form-group:nth-child(5) .info-badge'); // Select the badge by class/structure
            if (membershipLevelInput) {
                membershipLevelInput.value = user.membership_level;
            }
            if (membershipBadge) {
                membershipBadge.textContent = user.membership_level;
                membershipBadge.classList.remove('badge-standard', 'badge-silver', 'badge-gold', 'badge-premium'); 
                if (user.membership_level === 'Gold' || user.membership_level === 'Premium') {
                    membershipBadge.classList.add('badge-premium'); 
                } else if (user.membership_level === 'Silver') {
                     membershipBadge.classList.add('badge-standard'); // Assuming silver uses standard styling or you add .badge-silver to viewProfile.css
                } else {
                    membershipBadge.classList.add('badge-standard');
                }
            }

            // Update age verification status
            const ageVerifiedInput = document.getElementById('ageVerified');
            const ageVerifiedBadge = document.querySelector('.profile-card .form-group:nth-child(6) .info-badge'); // Select the badge by class/structure
            if (ageVerifiedInput) {
                ageVerifiedInput.value = user.age_verified ? 'Verified' : 'Not Verified';
            }
            if (ageVerifiedBadge) {
                ageVerifiedBadge.textContent = user.age_verified ? 'Verified' : 'Not Verified';
                ageVerifiedBadge.classList.remove('badge-verified', 'badge-unverified'); 
                ageVerifiedBadge.classList.add(user.age_verified ? 'badge-verified' : 'badge-unverified');
            }

        } else {
            console.error("Failed to fetch user profile:", responseData.message);
            alert("Error fetching profile: " + responseData.message);
            if (responseData.message === "User not found.") {
                window.location.href = '../login/login.html'; 
            }
        }

    } catch (error) {
        console.error("Network or API error:", error);
        alert("An error occurred while loading your profile. Please try again.");
    }
});




document.addEventListener('DOMContentLoaded', async () => {
    // ... (Your existing code for fetching and displaying profile data) ...

    const userId = localStorage.getItem('userId'); 

    if (!userId) {
        console.error("No user ID found in Local Storage. Redirecting to login.");
        alert("You are not logged in. Please log in to view your profile.");
        window.location.href = '../login/login.html'; 
        return;
    }

    // --- NEW CODE FOR DELETE ACCOUNT ---
    const deleteAccountBtn = document.getElementById('deleteAccountBtn');

    if (deleteAccountBtn) {
        deleteAccountBtn.addEventListener('click', async () => {
            // Confirmation dialog before proceeding
            const confirmDelete = confirm("Are you sure you want to delete your account? This action cannot be undone.");

            if (confirmDelete) {
                try {
                    // Send a POST request to the new delete controller
                    const response = await axios.post('../../cinema-server/controllers/delete_user_controller.php', {
                        userId: userId // Send the user ID for deletion
                    }, {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    });

                    const responseData = response.data;

                    if (responseData.success) {
                        alert(responseData.message);
                        // Account deleted successfully, clear local storage and redirect
                        localStorage.removeItem('userId'); // Remove the user ID from local storage
                        window.location.href = '../login/login.html'; // Redirect to login or home page
                    } else {
                        alert("Error: " + responseData.message);
                        console.error("Delete account error:", responseData.message);
                    }

                } catch (error) {
                    alert("An error occurred while trying to delete your account. Please try again.");
                    console.error("Network or API error during deletion:", error);
                }
            }
        });
    }
    // --- END NEW CODE FOR DELETE ACCOUNT ---

    // ... (Rest of your existing code for fetching and displaying profile data) ...

    try {
        // ... (Your existing axios.get call for fetching profile data) ...
        // Ensure this part is still outside the delete button event listener
        // and runs when the DOM loads to populate the profile initially.
    } catch (error) {
        // ... (Your existing error handling for profile data fetch) ...
    }
});