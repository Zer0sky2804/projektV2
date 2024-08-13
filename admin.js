document.addEventListener("DOMContentLoaded", function() {
    fetch('load_title.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('page-title').textContent = data;
        })
        .catch(error => console.error('Error fetching title:', error));

    document.getElementById('change-title-button').addEventListener('click', function() {
        const newTitle = prompt('Zadejte nový nadpis:');
        if (newTitle) {
            fetch('update_title.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'title=' + encodeURIComponent(newTitle)
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                document.getElementById('page-title').textContent = newTitle;
            })
            .catch(error => console.error('Error updating title:', error));
        }
    });

    document.getElementById('change-image-button').addEventListener('click', function() {
        document.getElementById('file-input').click();
    });

    document.getElementById('file-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('image', file);
            
            fetch('update_image.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                
                window.location.href = 'admin.php';
            })
            .catch(error => console.error('Error updating image:', error));
        }
    });
});
