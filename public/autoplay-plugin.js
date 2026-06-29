document.addEventListener("DOMContentLoaded", function() {
    // 1. Cek parameter URL atau ingatan bot sebelumnya
    const urlParams = new URLSearchParams(window.location.search);
    let currentRole = urlParams.get('role');

    if (!currentRole) {
        currentRole = sessionStorage.getItem('bot_active_role');
    }

    // Kalau bener-bener gak ada role, skrip mati (mode user biasa)
    if (!currentRole) return;

    // 2. Brankas Akun & Rute Tour (Sesuai Route Laravel lu)
    const credentials = {
        'marketing': { 
            user: 'marketing', pass: 'marketing123', 
            tour: ['/marketing/dashboard', '/marketing/proyek', '/marketing/bidding'] 
        },
        'engineering': { 
            user: 'engineering', pass: 'marketing123', 
            tour: ['/engineering/dashboard', '/engineering/kelola-rab', '/engineering/rab/histori'] 
        },
        'direktur': { 
            user: 'direktur', pass: 'marketing123', 
            tour: ['/direktur/dashboard', '/direktur/persetujuan'] 
        },
        'purchasing': { 
            user: 'purchasing', pass: 'marketing123', 
            tour: ['/purchasing/dashboard', '/purchasing/material-index', '/purchasing/material-review'] 
        }
    };

    const activeAccount = credentials[currentRole.toLowerCase()];
    if (!activeAccount) return;

    // 3. DETEKSI LOKASI HALAMAN
    const userInput = document.querySelector('input[name*="user"], input[type="text"]');
    const passInput = document.querySelector('input[type="password"], input[name*="pass"]');
    const btn = document.querySelector('button[type="submit"], input[type="submit"]');

    if (userInput && passInput && btn) {
        // --- KONDISI A: SEDANG DI HALAMAN LOGIN ---
        console.log("Bot Mode: Mulai Login sebagai " + currentRole);

        // Tanam ingatan ke otak browser
        sessionStorage.setItem('bot_active_role', currentRole.toLowerCase());
        sessionStorage.setItem('bot_tour_step', '0');

        userInput.value = activeAccount.user;
        passInput.value = activeAccount.pass;
        userInput.dispatchEvent(new Event('input', { bubbles: true }));
        passInput.dispatchEvent(new Event('input', { bubbles: true }));

        setTimeout(() => {
            btn.click();
        }, 1000);

    } else {
        // --- KONDISI B: SUDAH LOGIN & DI DALAM APLIKASI ---
        let currentStep = parseInt(sessionStorage.getItem('bot_tour_step') || '0');
        let tourPaths = activeAccount.tour;

        if (currentStep < tourPaths.length) {
            let nextDestination = tourPaths[currentStep];
            console.log(`Bot Mode: Pindah ke ${nextDestination}`);

            // Jeda 4 detik di tiap halaman biar HRD/Klien bisa lihat desain lu
            setTimeout(() => {
                sessionStorage.setItem('bot_tour_step', currentStep + 1);
                window.location.href = nextDestination; // Teleportasi URL yang aman
            }, 4000); 

        } else {
            console.log("Bot Mode: Tour Selesai. Silakan coba fitur secara manual.");
            // Hapus ingatan biar interaksi klik manual gak diganggu
            sessionStorage.removeItem('bot_active_role');
            sessionStorage.removeItem('bot_tour_step');
        }
    }
});