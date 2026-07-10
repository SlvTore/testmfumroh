// Simulasi Database di Memory
let dbBuggy = { terisi: 9, kuota: 10 };
let dbFixed = { terisi: 9, kuota: 10 };

// Helper untuk mensimulasikan waktu jeda koneksi database
const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

// ==========================================
// 1. FUNGSI DENGAN BUG OVERBOOKING (TOCTOU)
// ==========================================
async function bookingBuggy(user) {
    // Fase Baca (mengambil data dari database dengan jeda)
    await delay(50); 
    let terisi = dbBuggy.terisi;
    let kuota = dbBuggy.kuota;

    // Fase Cek
    if (terisi < kuota) {
        // Fase Tulis (menyimpan ke database dengan jeda)
        await delay(50);
        dbBuggy.terisi = terisi + 1;
        return `${user}: Berhasil booking (Kuota terisi sekarang: ${dbBuggy.terisi})`;
    }
    return `${user}: Gagal booking (Kuota habis)`;
}

// ==========================================
// 2. FUNGSI DENGAN PERBAIKAN LOCKING (MUTEX)
// ==========================================
let isLocked = false; // Flag untuk mensimulasikan Pessimistic Lock

async function bookingFixed(user) {
    // Menunggu jika database sedang di-lock oleh request lain
    while (isLocked) {
        await delay(5); 
    }
    
    // Kunci database (Acquire Lock)
    isLocked = true;
    
    try {
        // Fase Baca
        await delay(50);
        let terisi = dbFixed.terisi;
        let kuota = dbFixed.kuota;

        if (terisi < kuota) {
            // Fase Tulis
            await delay(50);
            dbFixed.terisi = terisi + 1;
            return `${user}: Berhasil booking (Kuota terisi sekarang: ${dbFixed.terisi})`;
        }
        return `${user}: Gagal booking (Kuota habis)`;
    } finally {
        // Buka Kunci database (Release Lock)
        isLocked = false;
    }
}

// ==========================================
// RUN SIMULATION
// ==========================================
async function runSimulation() {
    console.log("====================================================");
    console.log("⚡ SIMULASI CONCURRENCY: BUG vs FIX ⚡");
    console.log("====================================================\n");

    console.log("=== SKENARIO ===");
    console.log("Kuota Terisi Saat Ini: 9");
    console.log("Maksimal Kuota: 10");
    console.log("Skenario: 3 User (A, B, C) melakukan booking di milidetik yang sama.\n");

    // --- JALANKAN SIMULASI 1 (BUGGY) ---
    console.log("--- MENJALANKAN SIMULASI 1: DENGAN BUG ---");
    const buggyPromises = [
        bookingBuggy("User A"),
        bookingBuggy("User B"),
        bookingBuggy("User C")
    ];
    
    const buggyResults = await Promise.all(buggyPromises);
    buggyResults.forEach(res => console.log("  ->", res));
    console.log(`[!] Hasil Akhir Kuota Terisi di DB: ${dbBuggy.terisi} (Terjadi Overbooking!)\n`);

    await delay(1000); // Jeda sebelum simulasi berikutnya

    // --- JALANKAN SIMULASI 2 (FIXED) ---
    console.log("--- MENJALANKAN SIMULASI 2: SETELAH PERBAIKAN ---");
    const fixedPromises = [
        bookingFixed("User A"),
        bookingFixed("User B"),
        bookingFixed("User C")
    ];
    
    const fixedResults = await Promise.all(fixedPromises);
    fixedResults.forEach(res => console.log("  ->", res));
    console.log(`[✓] Hasil Akhir Kuota Terisi di DB: ${dbFixed.terisi} (Aman & Akurat!)\n`);
}

runSimulation();
