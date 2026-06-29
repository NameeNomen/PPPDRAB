document.addEventListener("DOMContentLoaded", function() {
    // 1. MASTER DAFTAR ANTREAN (Estafet Role)
    const roleSequence = ['marketing', 'engineering', 'direktur', 'purchasing'];

    // 2. CEK INGATAN: Sekarang lagi giliran siapa? (Default: 0 / Marketing)
    let currentRoleIndex = parseInt(sessionStorage.getItem('bot_role_index') || '0');

    // Kalau indeksnya udah mentok, berarti tour semua divisi selesai. Pensiun!
    if (currentRoleIndex >= roleSequence.length) {
        console.log("Bot Mode: Semua divisi udah di-tour. Gue pamit pensiun.");
        sessionStorage.clear(); // Bersihin otak bot biar klien bisa interaksi manual
        return; 
    }

    let currentRole = roleSequence[currentRoleIndex];

    const credentials = {
        'marketing': { 
            user: 'marketing', pass: 'marketing123', 
            tour: ['/marketing/dashboard', '/marketing/proyek/detail/1','/marketing/proyek', '/marketing/bidding', '/marketing/bidding/workspace/1', '/marketing/bidding/log/1', '/marketing/bidding/histori'] 
        },
        'engineering': { 
            user: 'engineering', pass: 'marketing123', 
            tour: ['/engineering/dashboard', '/engineering/kelola-rab','/engineering/kelola-rab/1/detail', '/engineering/kelola-rab/1/workspace','/engineering/rab/histori'] 
        },
        'direktur': { 
            user: 'direktur', pass: 'marketing123', 
            tour: ['/direktur/dashboard', '/direktur/persetujuan', '/direktur/persetujuan/proyek/1'] 
        },
        'purchasing': { 
            user: 'purchasing', pass: 'marketing123', 
            tour: ['/purchasing/dashboard', '/purchasing/material-index', '/purchasing/material-create', '/purchasing/material/1/edit','/purchasing/material/review-request'] 
        }
    };

    const activeAccount = credentials[currentRole];
    if (!activeAccount) return;

    // VALIDASI MUTLAK: Cek pakai URL, bukan nebak-nebak form
    const isLoginPage = window.location.pathname.includes('/login');

    if (isLoginPage) {
        console.log(`Bot Mode: Waktunya login sebagai ${currentRole}...`);
        
        // Reset step tour jadi 0 khusus buat role yang mau login ini
        sessionStorage.setItem('bot_tour_step', '0');

        const waitForForm = setInterval(() => {
            const userInput = document.querySelector('input[name*="user"], input[type="text"], input[type="email"]');
            const passInput = document.querySelector('input[type="password"], input[name*="pass"]');
            const btn = document.querySelector('button[type="submit"], input[type="submit"]');

            if (userInput && passInput && btn) {
                clearInterval(waitForForm);
                userInput.value = activeAccount.user;
                passInput.value = activeAccount.pass;
                userInput.dispatchEvent(new Event('input', { bubbles: true }));
                passInput.dispatchEvent(new Event('input', { bubbles: true }));
                
                setTimeout(() => btn.click(), 1000);
            }
        }, 300);

    } else {
        // --- KONDISI B: KITA ADA DI DALAM MENU (DASHBOARD) ---
        let currentStep = parseInt(sessionStorage.getItem('bot_tour_step') || '0');
        let tourPaths = activeAccount.tour;

        if (currentStep < tourPaths.length) {
            let nextDestination = tourPaths[currentStep];
            console.log(`Bot Mode: Mengamati data... lalu teleportasi ke ${nextDestination}`);

            // Jeda 4.5 detik
            setTimeout(() => {
                sessionStorage.setItem('bot_tour_step', currentStep + 1);
                window.location.href = nextDestination; 
            }, 4500); 

        } else {
            // --- TOUR UNTUK ROLE INI SELESAI ---
            console.log(`Bot Mode: Tour ${currentRole} kelar. Ganti shift ke divisi selanjutnya...`);
            
            // Naikkan angka antrean ke divisi berikutnya
            sessionStorage.setItem('bot_role_index', currentRoleIndex + 1);
            
            setTimeout(() => {
                // PENTING: Bot lu harus LOGOUT biar bisa ngulang masuk sebagai divisi lain
                // Kalau framework lu pakai GET buat logout:
                window.location.href = '/logout'; 
                
                // ATAU: Kalau lu butuh bot buat ngeklik tombol logout di sidebar:
                // document.querySelector('a[href*="logout"], button:contains("Logout")')?.click();
            }, 2000);
        }
    }
});