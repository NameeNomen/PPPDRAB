document.addEventListener("DOMContentLoaded", function () {

    // ==================================================
    // HANYA IZINKAN SCRIPT BERJALAN DI DOMAIN INI
    // ==================================================
    const ALLOWED_ORIGIN = "https://web-porto-nameenomen.vercel.app";

    if (window.location.origin !== ALLOWED_ORIGIN) {
        console.warn("Bot Mode: Unauthorized domain. Script dinonaktifkan.");
        return;
    }

    // ==================================================
    // URUTAN ROLE
    // ==================================================
    const roleSequence = [
        "marketing",
        "engineering",
        "direktur",
        "purchasing"
    ];

    // Role saat ini
    let currentRoleIndex = parseInt(
        sessionStorage.getItem("bot_role_index") || "0"
    );

    // Semua role sudah selesai
    if (currentRoleIndex >= roleSequence.length) {
        console.log("Bot Mode: Semua tour selesai.");
        sessionStorage.clear();
        return;
    }

    const currentRole = roleSequence[currentRoleIndex];

    // ==================================================
    // DATA LOGIN & TOUR
    // ==================================================
    const credentials = {

        marketing: {
            user: "marketing",
            pass: "marketing123",
            tour: [
                "/marketing/dashboard",
                "/marketing/proyek/detail/1",
                "/marketing/proyek",
                "/marketing/bidding",
                "/marketing/bidding/workspace/1",
                "/marketing/bidding/log/1",
                "/marketing/bidding/histori"
            ]
        },

        engineering: {
            user: "engineering",
            pass: "marketing123",
            tour: [
                "/engineering/dashboard",
                "/engineering/kelola-rab",
                "/engineering/kelola-rab/1/detail",
                "/engineering/kelola-rab/1/workspace",
                "/engineering/rab/histori"
            ]
        },

        direktur: {
            user: "direktur",
            pass: "marketing123",
            tour: [
                "/direktur/dashboard",
                "/direktur/persetujuan",
                "/direktur/persetujuan/proyek/1"
            ]
        },

        purchasing: {
            user: "purchasing",
            pass: "marketing123",
            tour: [
                "/purchasing/dashboard",
                "/purchasing/material-index",
                "/purchasing/material-create",
                "/purchasing/material/1/edit",
                "/purchasing/material/review-request"
            ]
        }

    };

    const activeAccount = credentials[currentRole];

    if (!activeAccount) return;

    // ==================================================
    // CEK HALAMAN LOGIN
    // ==================================================
    const isLoginPage = window.location.pathname.includes("/login");

    if (isLoginPage) {

        console.log("Bot Login:", currentRole);

        sessionStorage.setItem("bot_tour_step", "0");

        const waitForm = setInterval(() => {

            const userInput = document.querySelector(
                'input[name*="user"], input[name*="email"], input[type="text"], input[type="email"]'
            );

            const passInput = document.querySelector(
                'input[name*="pass"], input[type="password"]'
            );

            const submitButton = document.querySelector(
                'button[type="submit"], input[type="submit"]'
            );

            if (userInput && passInput && submitButton) {

                clearInterval(waitForm);

                userInput.value = activeAccount.user;
                passInput.value = activeAccount.pass;

                userInput.dispatchEvent(new Event("input", {
                    bubbles: true
                }));

                passInput.dispatchEvent(new Event("input", {
                    bubbles: true
                }));

                setTimeout(() => {
                    submitButton.click();
                }, 1000);
            }

        }, 300);

    }

    // ==================================================
    // HALAMAN DASHBOARD / MENU
    // ==================================================
    else {

        let currentStep = parseInt(
            sessionStorage.getItem("bot_tour_step") || "0"
        );

        const tourPaths = activeAccount.tour;

        if (currentStep < tourPaths.length) {

            const destination = tourPaths[currentStep];

            console.log("Bot Tour:", destination);

            setTimeout(() => {

                sessionStorage.setItem(
                    "bot_tour_step",
                    currentStep + 1
                );

                window.location.href = destination;

            }, 4500);

        }

        // ==================================================
        // TOUR ROLE SELESAI
        // ==================================================
        else {

            console.log(currentRole + " selesai.");

            sessionStorage.setItem(
                "bot_role_index",
                currentRoleIndex + 1
            );

            sessionStorage.removeItem("bot_tour_step");

            setTimeout(() => {

                // Ganti sesuai route logout Laravel kamu
                window.location.href = "/logout";

            }, 2000);

        }

    }

});