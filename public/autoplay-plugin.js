document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentRole = urlParams.get('role');

    if (!currentRole) return; 

    console.log("Autoplay Active for Role: " + currentRole);

    // Panduan: Silakan sesuaikan email & password di bawah ini dengan akun website Anda
    const credentials = {
        'admin': { email: 'admin.demo@gmail.com', pass: 'admin123' },
        'hrd':   { email: 'hrd.demo@gmail.com', pass: 'hrd123' },
        'manager': { email: 'manager.demo@gmail.com', pass: 'manager123' },
        'user':  { email: 'user.demo@gmail.com', pass: 'user123' }
    };

    const activeAccount = credentials[currentRole.toLowerCase()];
    if (!activeAccount) return;

    setTimeout(() => {
        const emailInput = document.querySelector('input[type="email"]') || 
                           document.querySelector('input[name*="user"]') || 
                           document.querySelector('input[name*="email"]');
                           
        const passwordInput = document.querySelector('input[type="password"]') || 
                              document.querySelector('input[name*="pass"]');
                              
        const loginForm = document.querySelector('form');
        const submitButton = document.querySelector('button[type="submit"]') || 
                             document.querySelector('input[type="submit"]');

        if (emailInput && passwordInput) {
            emailInput.value = activeAccount.email;
            passwordInput.value = activeAccount.pass;

            // Memicu event agar framework modern (React/Vue/Angular) mendeteksi input
            emailInput.dispatchEvent(new Event('input', { bubbles: true }));
            passwordInput.dispatchEvent(new Event('input', { bubbles: true }));

            setTimeout(() => {
                localStorage.setItem('autoplay_role', currentRole);
                if (submitButton) {
                    submitButton.click();
                } else if (loginForm) {
                    loginForm.submit();
                }
            }, 1500);
        }
    }, 1000);
});