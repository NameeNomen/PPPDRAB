document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentRole = urlParams.get('role'); // Contoh: 'marketing', 'direktur', dst

    if (!currentRole) return; 

    console.log("Sistem Autoplay Aktif untuk Role: " + currentRole);

    // Akun demo (WAJIB SESUAIKAN DENGAN DB LU!)
    const credentials = {
        'marketing':   { username: 'marketing_mancap', pass: 'marketing123' },
        'engineering': { username: 'eng_team01',       pass: 'engineering123' },
        'direktur':    { username: 'pak_bos_direktur', pass: 'direktursuper123' },
        'purchasing':  { username: 'purchasing_div',   pass: 'purchasing123' }
    };

    const activeAccount = credentials[currentRole.toLowerCase()];
    if (!activeAccount) {
        console.error("Role " + currentRole + " tidak ditemukan!");
        return;
    }

    // Interval pencarian form login
    const interval = setInterval(() => {
        const userInput = document.querySelector('input[type="email"], input[name*="user"], input[type="text"]');
        const passInput = document.querySelector('input[type="password"], input[name*="pass"]');
        const btn = document.querySelector('button[type="submit"], input[type="submit"]');

        if (userInput && passInput && btn) {
            clearInterval(interval);
            
            // Isi Form
            userInput.value = activeAccount.username;
            passInput.value = activeAccount.pass;
            userInput.dispatchEvent(new Event('input', { bubbles: true }));
            passInput.dispatchEvent(new Event('input', { bubbles: true }));

            // Klik Login
            setTimeout(() => {
                btn.click();
                
                // --- LOGIKA OTOMATISASI NAVIGASI SETELAH LOGIN ---
                // Laravel lu udah ada redirect di root ('/'), 
                // tapi kalau mau bot-nya masuk ke menu spesifik, pake ini:
                setTimeout(() => {
                    const dashboardLink = `/ ${currentRole} /dashboard`.replace(/\s/g, ''); 
                    const menu = document.querySelector(`a[href*="${dashboardLink}"]`);
                    
                    if (menu) {
                        console.log("Bot mengklik menu dashboard: " + currentRole);
                        menu.click();
                    }
                }, 2500); // Tunggu 2.5 detik buat Laravel proses redirect login
                
            }, 1000);
        }
    }, 500);
});