// show/hide password toggle button

(() => {
    const togglePasswordButtons = document.querySelectorAll('[name="toggle-password"]');
    const passwordInput = document.querySelector('[name="password"]');
    const passwordConfirmationInput = document.querySelector('[name="password-confirmation"]');

    togglePasswordButtons.forEach(togglePasswordButton => {
        togglePasswordButton.addEventListener('click', togglePassword);
    })

    function togglePassword() {
        if (passwordInput) {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                if (passwordConfirmationInput) {
                    passwordConfirmationInput.type = 'text';
                }
                togglePasswordButtons.forEach(togglePasswordButton => {
                    togglePasswordButton.textContent = togglePasswordButton.getAttribute('data-hide');
                });
            } else {
                passwordInput.type = 'password';
                if (passwordConfirmationInput) {
                    passwordConfirmationInput.type = 'password';
                }
                togglePasswordButtons.forEach(togglePasswordButton => {
                    togglePasswordButton.textContent = togglePasswordButton.getAttribute('data-show');
                });
            }
        }
    }
})();
