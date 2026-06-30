
   document.addEventListener("DOMContentLoaded", function () {
    const ALLOWED_REFERRER = "https://web-porto-nameenomen.vercel.app";

    if (window.self === window.top) return; // Tetap kunci di iframe

    // Ambil parameter role langsung dari URL iframe yang dikirim Next.js
    const urlParams = new URLSearchParams(window.location.search);
    const targetRole = urlParams.get('current_role'); 

    let botState = { roleIndex: 0, stepIndex: 0, active: true, isVercel: false };
    
    try {
        if (window.name && window.name.includes('roleIndex')) {
            botState = JSON.parse(window.name);
        }
    } catch (e) {}
    const navEntries = performance.getEntriesByType("navigation");
    const isRefreshed = navEntries.length > 0 && navEntries[0].type === "reload";

    if (isRefreshed || (targetRole && window.name && !window.name.includes(targetRole))) {
        console.warn("Role berubah atau halaman di-refresh! Format memori.");
        window.name = ""; // Hapus memori lama
        botState = { roleIndex: 0, stepIndex: 0, active: true, isVercel: false };
    }

    // 4. GEMBOK DOMAIN VERCEL
    if (!botState.isVercel) {
        if (document.referrer.includes(ALLOWED_REFERRER)) {
            botState.isVercel = true;
            window.name = JSON.stringify(botState);
        } else {
            console.error("Bot Mode diblokir. Lu nyoba manggil dari:", document.referrer || "Unknown/Direct");
            return;
        } 
    } 

    // 5. DATA LOGIN & TOUR
    const roleSequence = ["marketing", "engineering", "direktur", "purchasing"];

    // 6. LOGIKA NGULANG DARI AWAL (INFINITY LOOP)
    if (botState.roleIndex >= roleSequence.length) {
        console.log("Bot Mode: Semua tour selesai. Balik lagi jadi kuli dari awal.");
        botState.roleIndex = 0;
        botState.stepIndex = 0;
        window.name = JSON.stringify(botState);
        
        if (!window.location.pathname.includes("login")) {
            window.location.href = "/login";
        }
        return; 
    }

    if (!botState.active) {
        console.log("Bot Mode: Mati.");
        return;
    }

    console.log("Bot Mode: Aktif. Stempel Vercel valid.");

    const credentials = {
        marketing: {
            username: "marketing", password: "marketing123",
            tour: ["/marketing/dashboard", "/marketing/proyek", "/marketing/bidding", "/marketing/bidding/workspace/1", "/marketing/bidding/log/1", "/marketing/bidding/histori"]
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

    // 5. LOGIKA LOGIN (SUDAH DISESUAIKAN DENGAN login.blade.php LU)
   if (window.location.pathname.includes("login")) {
    console.log("Bot Login sebagai:", currentRole);

    botState.stepIndex = 0;
    window.name = JSON.stringify(botState);

    const wait = setInterval(async () => {

        const userInput = document.querySelector('input[wire\\:model="username"]');
        const passInput = document.querySelector('input[wire\\:model="password"]');
        const submitButton = document.querySelector('button[type="submit"]');

        if (!userInput || !passInput || !submitButton) {
            return;
        }

        clearInterval(wait);

        async function typeLikeHuman(input, text) {
    input.focus();
    
    // Pakai native setter buat bypass kalau framework nge-hijack property setter dasar
    const nativeInputValueSetter = Object.getOwnPropertyDescriptor(window.HTMLInputElement.prototype, "value").set;
    let currentValue = "";

    // 1. Ketik visualnya aja dulu, JANGAN dispatch event apa-apa. Biar Livewire tidur.
    for (const char of text) {
        currentValue += char;
        nativeInputValueSetter.call(input, currentValue);
        await new Promise(r => setTimeout(r, 80));
    }

    // 2. Pas teks udah komplit, baru lempar bom (event) biar Livewire sinkronisasi sekali aja
    input.dispatchEvent(new Event("input", { bubbles: true }));
    input.dispatchEvent(new Event("change", { bubbles: true }));

    input.blur();
}

        await typeLikeHuman(userInput, activeAccount.username);

        await typeLikeHuman(passInput, activeAccount.password);

        console.log("Username:", userInput.value);
        console.log("Password:", passInput.value);

        setTimeout(() => {
            submitButton.click();
        }, 700);

    }, 200);
}

    // 6. LOGIKA TOUR
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
        }  else {
    console.log(currentRole + " selesai. Tour berhenti.");
    setTimeout(() => {
        console.log("Bot: Otomatis logout biar session bersih...");
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/logout';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken.content;

        form.appendChild(tokenInput);
        document.body.appendChild(form);
        
        window.name = ""; // Bersihin memory sebelum logout
        form.submit();
    }, 3000);
}
    }
});