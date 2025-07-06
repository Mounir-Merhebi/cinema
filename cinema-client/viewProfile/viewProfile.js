document.addEventListener('DOMContentLoaded', async () => {
    const userId = localStorage.getItem('userId');

    if (!userId) {
        console.error("No user ID found in Local Storage. Redirecting to login.");
        alert("You are not logged in. Please log in to view your profile.");
        window.location.href = '../login/login.html';
        return;
    }
    try {
        const response = await axios.get(`http://localhost/cinema/User?id=${userId}`);
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
                commPrefsSelect.value = user.communication_prefs.toLowerCase();
            }

            const membershipLevelInput = document.getElementById('membershipLevel');
            const membershipBadge = document.getElementById('membershipBadge');
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
            const ageVerifiedBadge = document.getElementById('ageVerifiedBadge'); 
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

    const saveChangesBtn = document.getElementById('saveChangesBtn');
    if (saveChangesBtn) {
        saveChangesBtn.addEventListener('click', async (event) => {
            event.preventDefault();

            const userId = localStorage.getItem('userId');
            if (!userId) {
                alert("User ID not found. Cannot update profile.");
                return;
            }

            const fullname = document.getElementById('fullname').value;
            const email = document.getElementById('email').value;
            const mobile_number = document.getElementById('mobile').value;
            const date_of_birth = document.getElementById('dob').value;
            const communication_prefs = document.getElementById('communicationPrefs').value;
            const password = document.getElementById('password').value;

            const updateData = {
                id: userId,
                fullname: fullname,
                email: email,
                mobile_number: mobile_number,
                date_of_birth: date_of_birth,
                communication_prefs: communication_prefs
            };

            if (password) {
                updateData.password = password;
            }

            try {
                const response = await axios.post('http://localhost/cinema/update_user',
                    new URLSearchParams(updateData).toString(), 
                    {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    }
                );

                const responseData = response.data;
                if (responseData.success) {
                    alert(responseData.message);

                    document.getElementById('password').value = '';
                } else {
                    alert("Error updating profile: " + responseData.message);
                    console.error("Update profile error:", responseData.message);
                }

            } catch (error) {
                alert("An error occurred while trying to update your profile. Please try again.");
                console.error("Network or API error during update:", error);
            }
        });
    }

    const deleteAccountBtn = document.getElementById('deleteAccountBtn');

    if (deleteAccountBtn) {
        deleteAccountBtn.addEventListener('click', async () => {
            const confirmDelete = confirm("Are you sure you want to delete your account? This action cannot be undone.");

            if (confirmDelete) {
                try {
                    const userId = localStorage.getItem('userId');

                    const response = await axios.post('http://localhost/cinema/delete_user',
                        new URLSearchParams({
                            id: userId
                        }).toString(),
                        {
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            }
                        }
                    );

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