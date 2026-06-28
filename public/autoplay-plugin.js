document.addEventListener("DOMContentLoaded", function() {
    // 1. Web porto lu bakal nembak URL pake parameter, misal: ?role=marketing
    const urlParams = new URLSearchParams(window.location.search);
    const currentRole = urlParams.get('role');

    // Pengaman: Kalau user biasa yang buka (tanpa parameter ?role), script ini langsung mati (tidur)
    if (!currentRole) return; 

    console.log("Sistem Autoplay Mendeteksi Akses untuk Role: " + currentRole);

    // 2. KONEKSI KE DATABASE LU (Secara Logis)
    // Lu wajib ganti isi 'username' dan 'pass' di bawah ini dengan akun ASLI 
    // yang beneran terdaftar di tabel users database aplikasi lu!
    const credentials = {
        'marketing':   { username: 'marketing_mancap', pass: 'marketing123' },
        'engineering': { username: 'eng_team01',       pass: 'engineering123' },
        'direktur':    { username: 'pak_bos_direktur', pass: 'direktursuper123' },
        'purchasing':  { username: 'purchasing_div',   pass: 'purchasing123' }
    };

    // Script mencocokkan: parameter URL lu apa? misal 'marketing', 
    // maka dia ngambil data akun marketing dari brankas di atas.
    const activeAccount = credentials[currentRole.toLowerCase()];
    
    // Kalau lu nembak role yang kagak ada di brankas (misal ?role=admin), script berhenti biar gak error
    if (!activeAccount) {
        console.error("Role " + currentRole + " tidak terdaftar di konfigurasi script!");
        return;
    }

    // 3. PROSES EKSEKUSI FORM LOGIN (GAIB)
    setTimeout(() => {
        // Cari kolom input username & password di halaman login web lu
        const userInput = document.querySelector('input[type="email"]') || 
                          document.querySelector('input[name*="user"]') || 
                          document.querySelector('input[name*="email"]') ||
                          document.querySelector('input[type="text"]');
                           
        const passwordInput = document.querySelector('input[type="password"]') || 
                              document.querySelector('input[name*="pass"]');
                              
        const loginForm = document.querySelector('form');
        const submitButton = document.querySelector('button[type="submit"]') || 
                             document.querySelector('input[type="submit"]');

        // Kalau form-nya ketemu di layar, bot mulai beraksi
        if (userInput && passwordInput) {
            
            // Bot ngetikin data akun yang sinkron sama database tadi
            userInput.value = activeAccount.username;
            passwordInput.value = activeAccount.pass;

            // Trigger event biar framework gak bingung pas form-nya keisi otomatis
            userInput.dispatchEvent(new Event('input', { bubbles: true }));
            passwordInput.dispatchEvent(new Event('input', { bubbles: true }));

            // Delay 1.5 detik biar HRD sempet ngeliat proses ngetik gaib ini, baru klik login
            setTimeout(() => {
                localStorage.setItem('autoplay_role', currentRole); // Simpan status buat di dashboard nanti
                
                if (submitButton) {
                    submitButton.click(); // Klik tombol login
                } else if (loginForm) {
                    loginForm.submit(); // Submit form paksa kalau tombolnya ga ada id
                }
            }, 1500);
        }
    }, 1000); // Tunggu 1 detik setelah halaman kebuka sempurna
});