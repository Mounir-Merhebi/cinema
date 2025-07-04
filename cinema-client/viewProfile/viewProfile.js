document.addEventListener('DOMContentLoaded', async () => {
    const userId = localStorage.getItem('userId'); 

    if (!userId) {

        console.error("No user ID found in Local Storage. Redirecting to login.");
        alert("You are not logged in. Please log in to view your profile.");

        window.location.href = '../login/login.html'; 
        return;
    }

    try {

        const response = await axios.get(`../../cinema-server/controllers/profile_controller.php?id=${userId}`);
        const responseData = response.data;

        if (responseData.success) {
            const user = responseData.user;
       
            document.getElementById('fullname').value = user.fullname;
            document.getElementById('email').value = user.email;
            document.getElementById('mobile').value = user.mobile_number;
            document.getElementById('dob').value = user.date_of_birth; 
            document.getElementById('createdAt').value = new Date(user.created_at).toLocaleDateString(); 

            const commPrefsSelect = document.getElementById('communicationPrefs');
            if (commPrefsSelect) {
                commPrefsSelect.value = user.communication_prefs;
            }

         
            const membershipLevelInput = document.getElementById('membershipLevel');
            const membershipBadge = document.querySelector('.profile-card .form-group:nth-child(5) .info-badge'); 
            if (membershipLevelInput) {
                membershipLevelInput.value = user.membership_level;
            }
            if (membershipBadge) {
                membershipBadge.textContent = user.membership_level;
                membershipBadge.classList.remove('badge-standard', 'badge-silver', 'badge-gold', 'badge-premium'); 
                if (user.membership_level === 'Gold' || user.membership_level === 'Premium') {
                    membershipBadge.classList.add('badge-premium'); 
                } else if (user.membership_level === 'Silver') {
                     membershipBadge.classList.add('badge-standard'); 
                } else {
                    membershipBadge.classList.add('badge-standard');
                }
            }

      
            const ageVerifiedInput = document.getElementById('ageVerified');
            const ageVerifiedBadge = document.querySelector('.profile-card .form-group:nth-child(6) .info-badge'); 
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
 

    const userId = localStorage.getItem('userId'); 

    if (!userId) {
        console.error("No user ID found in Local Storage. Redirecting to login.");
        alert("You are not logged in. Please log in to view your profile.");
        window.location.href = '../login/login.html'; 
        return;
    }

 
    const deleteAccountBtn = document.getElementById('deleteAccountBtn');

    if (deleteAccountBtn) {
        deleteAccountBtn.addEventListener('click', async () => {

            const confirmDelete = confirm("Are you sure you want to delete your account? This action cannot be undone.");

            if (confirmDelete) {
                try {
                   
                    const response = await axios.post('../../cinema-server/controllers/delete_user_controller.php', {
                        userId: userId 
                    }, {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    });

                    const responseData = response.data;

                    if (responseData.success) {
                        alert(responseData.message);
                       
                        localStorage.removeItem('userId'); 
                        window.location.href = '../login/login.html'; 
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
});