<!-- Quote Banner -->
<div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-blue-600 rounded-3xl shadow-soft-lg p-8 md:p-12 mb-8 relative overflow-hidden animate-fade-in"
     data-quote-banner>
    <div class="absolute inset-0 opacity-20">
        <svg class="absolute top-0 right-0 w-40 h-40" fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 21c3 0 7-1 7-8V5c0-1.25-4.5-5-7-5s-7 3.75-7 5c0 6 0 7 7 8s7.5 0 7.5 7.5"></path>
        </svg>
    </div>

    <div class="relative z-10">
        <h2 class="text-white text-lg md:text-2xl font-bold leading-relaxed mb-4"
            id="quote-text">
            "Kesuksesan adalah perjalanan, bukan tujuan. Nikmati setiap langkah perjalanan Anda."
        </h2>
        <p class="text-emerald-100 text-sm md:text-base font-semibold" id="quote-author">
            — Progress Tugas
        </p>
    </div>

    <div class="absolute top-6 right-6 opacity-30">
        <button onclick="rotateQuote()"
                class="text-white hover:opacity-100 transition-all transform hover:scale-110"
                title="Refresh quote">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
        </button>
    </div>
</div>

<script>
const quotes = [
    { text: "Kesuksesan adalah perjalanan, bukan tujuan. Nikmati setiap langkah perjalanan Anda.", author: "Progress Tugas" },
    { text: "Jangan menunda apa yang bisa Anda lakukan hari ini, karena masa depan dimulai sekarang.", author: "Motivasi Harian" },
    { text: "Setiap tugas yang Anda selesaikan adalah langkah menuju kesuksesan yang lebih besar.", author: "Inspirasi Belajar" },
    { text: "Fokus pada tujuan Anda, dan jangan biarkan tantangan mengalihkan perhatian Anda.", author: "Motivasi Akademik" },
    { text: "Kegigihan adalah kunci kesuksesan. Terus belajar, terus berkembang, terus maju.", author: "Semangat Belajar" },
    { text: "Setiap kesalahan adalah peluang untuk belajar dan menjadi lebih baik dari sebelumnya.", author: "Kebijaksanaan" },
    { text: "Tugas yang sulit adalah kesempatan untuk menunjukkan kemampuan dan dedikasi Anda.", author: "Tantangan Positif" },
    { text: "Jangan pernah menyerah. Orang-orang yang berhasil adalah mereka yang tidak pernah berhenti mencoba.", author: "Motivasi Pengorbanan" }
];

let currentQuoteIndex = 0;

function rotateQuote() {
    currentQuoteIndex = (currentQuoteIndex + 1) % quotes.length;
    const quote = quotes[currentQuoteIndex];

    const quoteText = document.getElementById('quote-text');
    const quoteAuthor = document.getElementById('quote-author');

    quoteText.classList.add('opacity-0');
    quoteAuthor.classList.add('opacity-0');

    setTimeout(() => {
        quoteText.innerText = `"${quote.text}"`;
        quoteAuthor.innerText = `— ${quote.author}`;
        quoteText.classList.remove('opacity-0');
        quoteAuthor.classList.remove('opacity-0');
    }, 300);
}

// Auto-rotate quotes every 8 seconds
setInterval(rotateQuote, 8000);
</script>

<style>
#quote-text, #quote-author {
    transition: opacity 0.3s ease-in-out;
}

@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-in-out;
}
</style>
