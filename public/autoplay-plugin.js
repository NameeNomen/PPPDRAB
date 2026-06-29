document.addEventListener("DOMContentLoaded", function () {
    const ALLOWED_REFERRER = "https://web-porto-nameenomen.vercel.app";

    // 1. VALIDASI IFRAME
    if (window.self === window.top) {
        console.warn("Bot Mode: Nonaktif. Halaman dibuka langsung, bukan di iframe.");
        return;
    }

    // 2. BACA STATE
    let botState = { roleIndex: 0, stepIndex: 0, active: true, isVercel: false };
    try {
        if (window.name && window.name.includes('roleIndex')) {
            botState = JSON.parse(window.name);
        }
    } catch (e) {
        console.error("Gagal membaca state bot.");
    }

    // 3. VALIDASI DOMAIN
    if (!botState.isVercel) {
        if (document.referrer.includes(ALLOWED_REFERRER)) {
            botState.isVercel = true;
            window.name = JSON.stringify(botState);
        } else {
            console.error("Bot Mode diblokir. Referrer tidak valid:", document.referrer || "Direct");
            return;
        }
    }

    // 4. DATA AKUN & TOUR
    const roleSequence = ["marketing", "engineering", "direktur", "purchasing"];

    if (!botState.active || botState.roleIndex >= roleSequence.length) {
        console.log("Bot Mode: Semua tour selesai.");
        window.name = ""; 
        return;
    }

    const credentials = {
        marketing: {
            username: "marketing", password: "marketing123",
            tour: ["/marketing/dashboard", "/marketing/proyek/detail/1", "/marketing/proyek", "/marketing/bidding", "/marketing/bidding/workspace/1", "/marketing/bidding/log/1", "/marketing/bidding/histori"]
        },
        engineering: {
            username: "engineering", password: "marketing123",
            tour: ["/engineering/dashboard", "/engineering/kelola-rab", "/engineering/kelola-rab/1/detail", "/engineering/kelola-rab/1/workspace", "/engineering/rab/histori"]
        },
        direktur: {
            username: "direktur", password: "marketing123",
            tour: ["/direktur/dashboard", "/direktur/persetujuan", "/direktur/persetujuan/proyek/1"]
        },
        purchasing: {
            username: "purchasing", password: "marketing123",
            tour: ["/purchasing/dashboard", "/purchasing/material-index", "/purchasing/material-create", "/purchasing/material/1/edit", "/purchasing/material/review-request"]
        }
    };

    const currentRole = roleSequence[botState.roleIndex];
    const activeAccount = credentials[currentRole];

    // 5. LOGIKA LOGIN
    if (window.location.pathname.includes("login")) {
        console.log("Bot Login sebagai:", currentRole);
        botState.stepIndex = 0;
        window.name = JSON.stringify(botState);

        // 🔥 PERBAIKAN DI SINI: Sesuaikan dengan login.blade.php lu yang pakai wire:model
        const userInput = document.querySelector('input[wire\\:model="username"]') || document.querySelector('input[type="text"]');
        const passInput = document.querySelector('input[wire\\:model="password"]') || document.querySelector('input[type="password"]');
        const submitButton = document.querySelector('button[type="submit"]');

        if (userInput && passInput && submitButton) {
            // 🔥 PENTING: Pakai Native Setter biar Livewire ngerasa ada yang ngetik
            const nativeSetter = Object.getOwnPropertyDescriptor(window.HTMLInputElement.prototype, 'value').set;

            nativeSetter.call(userInput, activeAccount.username);
            userInput.dispatchEvent(new Event('input', { bubbles: true }));
            userInput.dispatchEvent(new Event('change', { bubbles: true }));

            nativeSetter.call(passInput, activeAccount.password);
            passInput.dispatchEvent(new Event('input', { bubbles: true }));
            passInput.dispatchEvent(new Event('change', { bubbles: true }));

            setTimeout(() => {
                submitButton.click();
            }, 1000);
        } else {
            console.error("Bot Mode: Elemen form login tidak ditemukan. Cek selector inputnya.");
        }
    } 

    // 6. LOGIKA TOUR
    else {
        let currentStep = botState.stepIndex;
        const tourPaths = activeAccount.tour;

        if (currentStep < tourPaths.length) {
            const destination = tourPaths[currentStep];
            console.log("Bot Tour ke:", destination);

            setTimeout(() => {
                botState.stepIndex = currentStep + 1;
                window.name = JSON.stringify(botState);
                window.location.href = destination;
            }, 4500);
        } else {
            console.log(currentRole + " selesai. Ganti role...");
            botState.roleIndex += 1;
            botState.stepIndex = 0;
            window.name = JSON.stringify(botState);

            setTimeout(() => {
                window.location.href = "/logout";
            }, 2000);
        }
    }
});