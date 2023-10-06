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
            // Jika tidak ada file yang dipilih, kembalikan teks label ke "Choose A File"
            fileLabel.innerHTML = 'Choose A File';
        }
    });


    const cancelButton = document.querySelector('.cancel-btn');

    // Menambahkan event listener untuk menghapus semua input saat tombol "Cancel" diklik
    cancelButton.addEventListener('click', function() {
        // Mendapatkan semua elemen input dalam form
        const formInputs = document.querySelectorAll('input[type="text"], input[type="file"], input[type="date"]');

        // Menghapus nilai dari semua elemen input
        formInputs.forEach(function(input) {
            input.value = '';
        });
    });
});
