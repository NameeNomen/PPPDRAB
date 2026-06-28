document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentRole = urlParams.get('role');

    if (!currentRole) return; 

    console.log("Sistem Autoplay: Simulasi Workflow untuk " + currentRole);

    // KREDENSIAL FINAL (Sesuai permintaan lu)
    const credentials = {
        'marketing':   { username: 'marketing',   pass: 'marketing123', path: '/marketing/proyek' },
        'engineering': { username: 'engineering', pass: 'marketing123', path: '/engineering/kelola-rab' },
        'direktur':    { username: 'direktur',    pass: 'marketing123', path: '/direktur/persetujuan' },
        'purchasing':  { username: 'purchasing',  pass: 'marketing123', path: '/purchasing/material-index' }
    };

    const activeAccount = credentials[currentRole.toLowerCase()];
    if (!activeAccount) {
        console.error("Role " + currentRole + " tidak terdaftar di brankas!");
        return;
    }

    // --- PROSES LOGIN & WORKFLOW ---
    const loginLoop = setInterval(() => {
        const userInput = document.querySelector('input[name*="user"], input[type="text"]');
        const passInput = document.querySelector('input[type="password"], input[name*="pass"]');
        const btn = document.querySelector('button[type="submit"], input[type="submit"]');

        if (userInput && passInput && btn) {
            clearInterval(loginLoop);
            
            // Isi data
            userInput.value = activeAccount.username;
            passInput.value = activeAccount.pass;
            
            userInput.dispatchEvent(new Event('input', { bubbles: true }));
            passInput.dispatchEvent(new Event('input', { bubbles: true }));

            setTimeout(() => {
                btn.click();
                
                // --- NAVIGASI WORKFLOW ---
                setTimeout(() => {
                    // Cari menu berdasarkan path yang sudah ditentukan
                    const menu = document.querySelector(`a[href*="${activeAccount.path}"]`);
                    if (menu) {
                        console.log("Bot masuk ke workflow: " + activeAccount.path);
                        menu.click();
                    } else {
                        console.warn("Menu target tidak ditemukan: " + activeAccount.path);
                    }
                }, 3000); // Waktu tunggu setelah login (tambah jika web lemot)

            }, 1000);
        }
    }, 500);
});