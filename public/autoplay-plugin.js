document.addEventListener("DOMContentLoaded", function () {
    const ALLOWED_REFERRER = "https://web-porto-nameenomen.vercel.app";

    // ==================================================
    // 1. VALIDASI IFRAME DASAR
    // ==================================================
    if (window.self === window.top) {
        console.warn("Bot Mode: Mati. Lu buka web ini langsung, bukan di dalam iframe.");
        return;
    }

    // ==================================================
    // 2. BACA INGATAN DARI WINDOW.NAME
    // ==================================================
    let botState = { roleIndex: 0, stepIndex: 0, active: true, isVercel: false };
    try {
        if (window.name && window.name.includes('roleIndex')) {
            botState = JSON.parse(window.name);
        }
    } catch (e) {
        console.error("Gagal baca ingatan bot.");
    }

    // ==================================================
    // 3. GEMBOK DOMAIN VERCEL LU
    // ==================================================
    if (!botState.isVercel) {
        if (document.referrer.includes(ALLOWED_REFERRER)) {
            botState.isVercel = true;
            window.name = JSON.stringify(botState);
        } else {
            console.error("Bot Mode diblokir. Lu nyoba manggil dari:", document.referrer || "Unknown/Direct");
            return;
        }
    }

    // ==================================================
    // 4. DATA LOGIN & TOUR
    // ==================================================
    const roleSequence = ["marketing", "engineering", "direktur", "purchasing"];

    if (!botState.active || botState.roleIndex >= roleSequence.length) {
        console.log("Bot Mode: Semua tour selesai. Selamat istirahat.");
        window.name = ""; 
        return;
    }

    console.log("Bot Mode: Aktif. Stempel Vercel valid.");

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

    // ==================================================
    // 5. LOGIKA LOGIN (DISESUAIKAN TANPA UBAH BLADE)
    // ==================================================
    if (window.location.pathname.includes("login")) {
        console.log("Bot Login sebagai:", currentRole);
        botState.stepIndex = 0;
        window.name = JSON.stringify(botState);

        // 🔥 PERUBAHAN DI SINI BRO 🔥
        // Kita pakai selector alternatif: wire:model (dengan escape \:) ATAU placeholder-nya.
        // Jadi nggak perlu lagi maksa nyari name="username".
        const userInput = document.querySelector('input[wire\\:model="username"], input[placeholder="Masukkan username..."], input[name="username"]');
        
        // Untuk password, type="password" udah pasti ketemu, tapi gue tambahin wire:model buat jaga-jaga.
        const passInput = document.querySelector('input[type="password"], input[wire\\:model="password"], input[name="password"]');
        
        const submitButton = document.querySelector('button[type="submit"], input[type="submit"]');

        if (userInput && passInput && submitButton) {
            userInput.value = activeAccount.username;
            passInput.value = activeAccount.password;

            // Pancing Livewire/Alpine biar ngerasa ada inputan manusia
            userInput.dispatchEvent(new Event("input", { bubbles: true }));
            passInput.dispatchEvent(new Event("input", { bubbles: true }));
            
            // Opsional: dispatch change event juga buat amannya di beberapa versi Livewire
            userInput.dispatchEvent(new Event("change", { bubbles: true }));
            passInput.dispatchEvent(new Event("change", { bubbles: true }));

            setTimeout(() => {
                submitButton.click();
            }, 1000);
        } else {
            console.error("Bot Mode: Form login nggak ketemu! Cek lagi selector di autoplay-plugin.js.");
            console.log("Status elemen:", { userInput: !!userInput, passInput: !!passInput, submitButton: !!submitButton });
        }
    }

    // ==================================================
    // 6. LOGIKA TOUR
    // ==================================================
    else {
        let currentStep = botState.stepIndex;
        const tourPaths = activeAccount.tour;

        if (currentStep < tourPaths.length) {
            const destination = tourPaths[currentStep];
            console.log("Bot Tour OTW ke:", destination);

            setTimeout(() => {
                botState.stepIndex = currentStep + 1;
                window.name = JSON.stringify(botState);
                window.location.href = destination;
            }, 4500);
        } else {
            console.log(currentRole + " selesai. Siap-siap ganti role...");
            botState.roleIndex += 1;
            botState.stepIndex = 0;
            window.name = JSON.stringify(botState);

            setTimeout(() => {
                window.location.href = "/logout";
            }, 2000);
        }
    }
});