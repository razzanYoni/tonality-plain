document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById('input-file');

    const fileLabel = document.querySelector('label[for="input-file"]');

    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            const fileName = fileInput.files[0].name;

            fileLabel.innerHTML = `${fileName}`;
        } else {
            fileLabel.innerHTML = 'Select a File';
        }
    });


    const cancelButton = document.querySelector('.cancel-btn');

    cancelButton.addEventListener('click', function() {
        const formInputs = document.querySelectorAll('input[type="text"], input[type="file"], input[type="date"]');

        formInputs.forEach(function(input) {
            input.value = '';
        });
    });
});
