document.addEventListener("DOMContentLoaded", function () {
    // Membaca elemen input file
    const fileInput = document.getElementById('input-file');

    // Membaca elemen label
    const fileLabel = document.querySelector('label[for="input-file"]');

    // Menambahkan event listener untuk mengupdate label saat ada perubahan pada input file
    fileInput.addEventListener('change', function() {
        // Memeriksa apakah pengguna telah memilih file
        if (fileInput.files.length > 0) {
            // Mengambil nama file dari input file
            const fileName = fileInput.files[0].name;

            // Mengganti teks pada label dengan nama file yang dipilih
            fileLabel.innerHTML = `${fileName}`;
        } else {
            // Jika tidak ada file yang dipilih, kembalikan teks label ke "Choose An Audio File"
            fileLabel.innerHTML = 'Choose An Audio File';
        }
    });
});
