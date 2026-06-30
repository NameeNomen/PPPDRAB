document.addEventListener("DOMContentLoaded", function () {
    const ALLOWED_REFERRER = "https://web-porto-nameenomen.vercel.app";

    // 1. VALIDASI IFRAME
    if (window.self === window.top) {
        console.warn("Bot Mode: Mati. Lu buka web ini langsung, bukan di dalam iframe.");
        return;
    }

    // 2. BACA MEMORI LAMA DULU
    let botState = { currentRole: null, stepIndex: 0, active: true, isVercel: false };
    try {
        if (window.name && window.name.includes('currentRole')) {
            botState = JSON.parse(window.name);
        }
    } catch (e) {
        console.error("Gagal baca ingatan bot.");
    }

    // 3. AMBIL INSTRUKSI DARI URL (Kalau ada)
    const urlParams = new URLSearchParams(window.location.search);
    const urlRole = urlParams.get('current_role');

    // Tentukan siapa bosnya sekarang. Kalau di URL ada, pake itu. Kalau gak ada, pake ingatan lama.
    const activeRole = urlRole || botState.currentRole;

    // Kalau dua-duanya kosong, baru botnya boleh tidur.
    if (!activeRole) {
        console.warn("Bot Mode: Tidur. Gak ada instruksi role.");
        return; 
    }

    // 4. DETEKSI GANTI ROLE DARI NEXT.JS (Trigger Logout)
    // Kita cuma nge-reset memori & maksa logout KALAU parameter URL ada DAN beda sama ingatan.
    if (urlRole && botState.currentRole !== urlRole) {
        console.warn(`Perintah eksternal: Ganti role ke ${urlRole}. Reset memori & Logout paksa!`);
        
        botState = { currentRole: urlRole, stepIndex: 0, active: true, isVercel: botState.isVercel };
        window.name = JSON.stringify(botState);

        if (!window.location.pathname.includes("login")) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            
            if (csrfToken) {
                console.log("Eksekusi bom logout gaib...");
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/logout';
                
                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = '_token';
                tokenInput.value = csrfToken.content;
                
                form.appendChild(tokenInput);
                document.body.appendChild(form);
                form.submit(); 
            } else {
                window.location.href = '/login';
            }
            return; // Cegah script lanjut sebelum logout kelar
        }
    }

    botState.currentRole = activeRole;
    window.name = JSON.stringify(botState);

    // 5. GEMBOK DOMAIN VERCEL
    if (!botState.isVercel) {
        if (document.referrer.includes(ALLOWED_REFERRER)) {
            botState.isVercel = true;
            window.name = JSON.stringify(botState);
        } else {
            console.error("Bot Mode diblokir. Lu nyoba manggil dari:", document.referrer || "Unknown/Direct");
            return;
        } 
    } 

    // 6. DATA KREDENSIAL & RUTE TOUR
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

    const activeAccount = credentials[botState.currentRole];
    
    if (!activeAccount) {
        console.error("Bot bingung: Role tidak terdaftar.");
        return;
    }

    // 7. LOGIKA LOGIN (Jalan kalau ada di halaman /login)
    if (window.location.pathname.includes("login")) {
        console.log("Bot Login sebagai:", botState.currentRole);

        // Pastikan step index reset pas di login
        botState.stepIndex = 0;
        window.name = JSON.stringify(botState);

        const wait = setInterval(async () => {
            const userInput = document.querySelector('input[wire\\:model="username"]');
            const passInput = document.querySelector('input[wire\\:model="password"]');
            const submitButton = document.querySelector('button[type="submit"]');

            if (!userInput || !passInput || !submitButton) return;
            clearInterval(wait); // Berhenti nyari elemen kalau udah ketemu

            // Fungsi ngetik ala manusia buat bypass Livewire
            async function typeLikeHuman(input, text) {
                input.focus();
                const nativeInputValueSetter = Object.getOwnPropertyDescriptor(window.HTMLInputElement.prototype, "value").set;
                let currentValue = "";
                
                for (const char of text) {
                    currentValue += char;
                    nativeInputValueSetter.call(input, currentValue);
                    await new Promise(r => setTimeout(r, 80));
                }
                
                input.dispatchEvent(new Event("input", { bubbles: true }));
                input.dispatchEvent(new Event("change", { bubbles: true }));
                input.blur();
            }

            await typeLikeHuman(userInput, activeAccount.username);
            await typeLikeHuman(passInput, activeAccount.password);

            setTimeout(() => {
                submitButton.click();
            }, 700);

        }, 200);
    } 
    
    // 8. LOGIKA TOUR (Jalan setelah berhasil login)
    else {
        let currentStep = botState.stepIndex;
        const tourPaths = activeAccount.tour;

        if (currentStep < tourPaths.length) {
            const destination = tourPaths[currentStep];
            console.log("Bot Tour OTW ke:", destination);

            setTimeout(() => {
                botState.stepIndex = currentStep + 1;
                window.name = JSON.stringify(botState);
                
                // Pake replace biar history browser gak numpuk
                window.location.replace(destination);
            }, 4500);
        } else {
            console.log(botState.currentRole + " selesai. Tour berhenti. Siap-siap bersihin session.");
            
            setTimeout(() => {
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
                
                // Bersihin memory bot lu sebelum dia beneran mati
                window.name = ""; 
                form.submit();
            }, 3000);
        }
    }
});