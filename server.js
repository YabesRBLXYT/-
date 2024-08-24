const express = require('express');
const app = express();
const port = 3000;

// Simpan link tujuan di sini atau dapat diambil dari database
const destinationLink = 'https://roblox.com';

app.use(express.static('public')); // Menyajikan file HTML dari folder 'public'

// Endpoint untuk mengambil link tujuan
app.get('/get-link', (req, res) => {
    // Anda bisa menambahkan validasi atau syarat tambahan di sini
    res.json({ success: true, url: destinationLink });
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
