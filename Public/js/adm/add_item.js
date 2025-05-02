const dataTransfer = new DataTransfer();

document.getElementById('item_image').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('image_preview');
    previewContainer.innerHTML = ''; // Clear previous previews
    const files = event.target.files;

    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.src = e.target.result;
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const size = Math.min(img.width, img.height);

                // Set canvas size to the cropped square size
                canvas.width = 1200; // Desired width
                canvas.height = 1200; // Desired height

                // Draw the cropped image onto the canvas
                ctx.drawImage(img, (img.width - size) / 2, (img.height - size) / 2, size, size, 0, 0, canvas.width, canvas.height);

                // Convert the canvas to a data URL
                canvas.toBlob(function(blob) {
                    const croppedFile = new File([blob], file.name, { type: file.type });
                    dataTransfer.items.add(croppedFile); // Add the cropped file to the DataTransfer object
                    document.getElementById('item_image').files = dataTransfer.files;

                    // Create a preview image
                    const previewImg = document.createElement('img');
                    previewImg.src = URL.createObjectURL(blob);
                    previewImg.style.width = '100px';
                    previewImg.style.height = '100px';
                    previewImg.style.objectFit = 'cover';
                    previewImg.style.border = '1px solid #ccc';
                    previewImg.style.borderRadius = '5px';
                    previewContainer.appendChild(previewImg);
                }, file.type);
            };
        };
        reader.readAsDataURL(file);
    });
});
