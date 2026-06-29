document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    let currentRole = urlParams.get('role');

    // Cek ingatan bot di otak browser
    if (!currentRole) {
        currentRole = sessionStorage.getItem('bot_active_role');
    }

    if (!currentRole) return; // Kalau bukan bot, diam saja

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

    const activeAccount = credentials[currentRole.toLowerCase()];
    if (!activeAccount) return;

    let checkCount = 0;
    
    // Looping agresif untuk mencari state saat ini (Login Page vs Dashboard)
    const stateDetector = setInterval(() => {
        const userInput = document.querySelector('input[name*="user"], input[type="text"]');
        const passInput = document.querySelector('input[type="password"], input[name*="pass"]');
        const btn = document.querySelector('button[type="submit"], input[type="submit"]');

        // --- KONDISI A: KITA ADA DI HALAMAN LOGIN ---
        if (userInput && passInput && btn) {
            clearInterval(stateDetector); 
            console.log("Bot Mode: Form Login Ditemukan. Menjalankan otentikasi...");

            // Tanam ingatan
            sessionStorage.setItem('bot_active_role', currentRole.toLowerCase());
            sessionStorage.setItem('bot_tour_step', '0');

            // Eksekusi Login
            userInput.value = activeAccount.user;
            passInput.value = activeAccount.pass;
            userInput.dispatchEvent(new Event('input', { bubbles: true }));
            passInput.dispatchEvent(new Event('input', { bubbles: true }));

            setTimeout(() => btn.click(), 1000);
        }

        checkCount++;

        // --- KONDISI B: KITA ADA DI DALAM MENU (DASHBOARD) ---
        // Jika sudah mengecek 5 kali (2.5 detik) tapi form login tidak ada,
        // berarti kita sedang berada di dalam aplikasi.
        if (checkCount > 5 && (!userInput || !passInput)) {
            clearInterval(stateDetector);
            
            // Cegah tour berjalan jika user login manual (bukan bot)
            if (!sessionStorage.getItem('bot_active_role')) return;

            let currentStep = parseInt(sessionStorage.getItem('bot_tour_step') || '0');
            let tourPaths = activeAccount.tour;

            if (currentStep < tourPaths.length) {
                let nextDestination = tourPaths[currentStep];
                console.log(`Bot Mode: Mengamati data... lalu teleportasi ke ${nextDestination}`);

                // Jeda 4.5 detik agar HRD/Klien bisa mengamati UI lu
                setTimeout(() => {
                    sessionStorage.setItem('bot_tour_step', currentStep + 1);
                    window.location.href = nextDestination; 
                }, 4500); 

            } else {
                console.log("Bot Mode: Selesai. Silakan interaksi manual.");
                sessionStorage.removeItem('bot_active_role');
                sessionStorage.removeItem('bot_tour_step');
            }
        }
    }, 500);
});