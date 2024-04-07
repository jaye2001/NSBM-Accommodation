document.addEventListener("DOMContentLoaded", function() {
    const signUpForm = document.getElementById('signUpForm');
    
    signUpForm.addEventListener('submit', function(event) {
        // Prevent form submission until validation is complete
        event.preventDefault();
        
        // Basic validation examples
        const userType = document.getElementById('userType').value;
        const userName = document.getElementById('userName').value.trim();
        const userEmail = document.getElementById('userEmail').value.trim();
        const userPassword = document.getElementById('userPassword').value;
        
        let valid = true;
        let errorMessage = '';

        if (!userName) {
            valid = false;
            errorMessage += 'Name is required.\n';
        }

        if (!userEmail) {
            valid = false;
            errorMessage += 'Email is required.\n';
        } else if (!validateEmail(userEmail)) {
            valid = false;
            errorMessage += 'Please enter a valid email address.\n';
        }

        if (!userPassword || userPassword.length < 8) {
            valid = false;
            errorMessage += 'Password is required and must be at least 8 characters long.\n';
        }

        if (valid) {
            // If everything's valid, submit the form
            signUpForm.submit();
        } else {
            // If not valid, display an error message
            alert(errorMessage);
        }
    });
    
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});
