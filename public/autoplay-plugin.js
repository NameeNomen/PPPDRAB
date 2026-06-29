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
    
    // Kalau otaknya udah dimatikan atau tour udah beres semua
    if (!botState.active || botState.roleIndex >= roleSequence.length) { 
        console.log("Bot Mode: Semua tour selesai. Selamat istirahat.");
        window.name = ""; // Bersihkan ingatan biar besok bisa jalan lagi
        return;
    }

    console.log("Bot Mode: Aktif. Stempel Vercel valid.");

    const credentials = {
        marketing: {
            user: "marketing", pass: "marketing123",
            tour: ["/marketing/dashboard", "/marketing/proyek/detail/1", "/marketing/proyek", "/marketing/bidding", "/marketing/bidding/workspace/1", "/marketing/bidding/log/1", "/marketing/bidding/histori"]
        },
        engineering: {
            user: "engineering", pass: "marketing123",
            tour: ["/engineering/dashboard", "/engineering/kelola-rab", "/engineering/kelola-rab/1/detail", "/engineering/kelola-rab/1/workspace", "/engineering/rab/histori"]
        },
        direktur: {
            user: "direktur", pass: "marketing123",
            tour: ["/direktur/dashboard", "/direktur/persetujuan", "/direktur/persetujuan/proyek/1"]
        },
        purchasing: {
            user: "purchasing", pass: "marketing123",
            tour: ["/purchasing/dashboard", "/purchasing/material-index", "/purchasing/material-create", "/purchasing/material/1/edit", "/purchasing/material/review-request"]
        }
    };

    // Dideklarasikan dengan benar di sini biar nggak error 'not defined'
    const currentRole = roleSequence[botState.roleIndex];
    const activeAccount = credentials[currentRole];

    // ==================================================
    // 5. LOGIKA LOGIN
    // ==================================================
    if (window.location.pathname.includes("login")) {
        console.log("Bot Login sebagai:", currentRole);
        
        botState.stepIndex = 0;
        window.name = JSON.stringify(botState);

        const userInput = document.querySelector('input[name*="user"], input[name*="email"], input[type="text"], input[type="email"]');
        const passInput = document.querySelector('input[name*="pass"], input[type="password"]');
        const submitButton = document.querySelector('button[type="submit"], input[type="submit"]');

        if (userInput && passInput && submitButton) {
            userInput.value = activeAccount.user;
            passInput.value = activeAccount.pass;
            
            userInput.dispatchEvent(new Event("input", { bubbles: true }));
            passInput.dispatchEvent(new Event("input", { bubbles: true }));

            setTimeout(() => {
                submitButton.click();
            }, 1000);
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
        } 
        else {
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