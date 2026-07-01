document.addEventListener("DOMContentLoaded", function () {
    const ALLOWED_REFERRER = "https://web-porto-nameenomen.vercel.app";

    if (window.self === window.top) return;

    let botState = { currentRole: null, stepIndex: 0, active: true, isVercel: false };
    try {
        if (window.name && window.name.includes('currentRole')) {
            botState = JSON.parse(window.name);
        }
    } catch (e) {}

    const urlParams = new URLSearchParams(window.location.search);
    const urlRole = urlParams.get('current_role');
    const activeRole = urlRole || botState.currentRole;

    if (!activeRole) return;

    if (urlRole && botState.currentRole !== urlRole) {
        botState = { currentRole: urlRole, stepIndex: 0, active: true, isVercel: botState.isVercel };
        window.name = JSON.stringify(botState);

        if (!window.location.pathname.includes("login")) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            
            if (csrfToken) {
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
            return; 
        }
    }

    botState.currentRole = activeRole;
    window.name = JSON.stringify(botState);

    if (!botState.isVercel) {
        if (document.referrer.includes(ALLOWED_REFERRER)) {
            botState.isVercel = true;
            window.name = JSON.stringify(botState);
        } else {
            return;
        } 
    } 

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
    if (!activeAccount) return;

    if (window.location.pathname.includes("login")) {
        botState.stepIndex = 0;
        window.name = JSON.stringify(botState);

        const wait = setInterval(() => {
            const userInput = document.querySelector('input[wire\\:model*="username"]');
            const passInput = document.querySelector('input[wire\\:model*="password"]');
            const submitButton = document.querySelector('button[type="submit"]');

            if (!userInput || !passInput || !submitButton) return;

            clearInterval(wait);

            userInput.value = activeAccount.username;
            passInput.value = activeAccount.password;

            userInput.dispatchEvent(new Event('input', { bubbles: true }));
            passInput.dispatchEvent(new Event('input', { bubbles: true }));
            userInput.dispatchEvent(new Event('change', { bubbles: true }));
            passInput.dispatchEvent(new Event('change', { bubbles: true }));

            setTimeout(() => {
                submitButton.click();
            }, 2500); 

        }, 200);
    } 
    else {
        let currentStep = botState.stepIndex;
        const tourPaths = activeAccount.tour;

        if (currentStep < tourPaths.length) {
            setTimeout(() => {
                botState.stepIndex = currentStep + 1;
                window.name = JSON.stringify(botState);
                window.location.replace(tourPaths[currentStep]);
            }, 4500);
        } else {
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
                
                window.name = ""; 
                form.submit();
            }, 3000);
        }
    }
});