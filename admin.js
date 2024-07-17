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
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('uploaded-image');
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
});
