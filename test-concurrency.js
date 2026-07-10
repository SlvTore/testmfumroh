let dbBuggy = { terisi: 9, kuota: 10 };
let dbFixed = { terisi: 9, kuota: 10 };

const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

async function bookingBuggy(user) {
    await delay(50); 
    let terisi = dbBuggy.terisi;
    let kuota = dbBuggy.kuota;

    if (terisi < kuota) {
        await delay(50);
        dbBuggy.terisi = terisi + 1;
        return `${user}: Berhasil booking (Kuota terisi sekarang: ${dbBuggy.terisi})`;
    }
    return `${user}: Gagal booking (Kuota habis)`;
}

let isLocked = false;

async function bookingFixed(user) {
    while (isLocked) {
        await delay(5); 
    }
    
    isLocked = true;
    
    try {
        await delay(50);
        let terisi = dbFixed.terisi;
        let kuota = dbFixed.kuota;

        if (terisi < kuota) {
            await delay(50);
            dbFixed.terisi = terisi + 1;
            return `${user}: Berhasil booking (Kuota terisi sekarang: ${dbFixed.terisi})`;
        }
        return `${user}: Gagal booking (Kuota habis)`;
    } finally {
        isLocked = false;
    }
}

async function runSimulation() {
    console.log("====================================================");
    console.log("CONCURRENCY SIMULATION: BUG vs FIX");
    console.log("====================================================\n");

    console.log("=== SCENARIO ===");
    console.log("Current filled quota: 9");
    console.log("Max quota: 10");
    console.log("Scenario: 3 users request booking concurrently\n");

    console.log("--- SIMULATION 1: WITH BUG ---");
    const buggyPromises = [
        bookingBuggy("User A"),
        bookingBuggy("User B"),
        bookingBuggy("User C")
    ];
    
    const buggyResults = await Promise.all(buggyPromises);
    buggyResults.forEach(res => console.log("  ->", res));
    console.log(`[!] DB Final Filled: ${dbBuggy.terisi} (Overbooking occurred!)\n`);

    await delay(1000);

    console.log("--- SIMULATION 2: AFTER FIX ---");
    const fixedPromises = [
        bookingFixed("User A"),
        bookingFixed("User B"),
        bookingFixed("User C")
    ];
    
    const fixedResults = await Promise.all(fixedPromises);
    fixedResults.forEach(res => console.log("  ->", res));
    console.log(`[OK] DB Final Filled: ${dbFixed.terisi} (Correct!)\n`);
}

runSimulation();
