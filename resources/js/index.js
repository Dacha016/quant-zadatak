let form = document.getElementById('imageForm');
let file = document.getElementById('fileName');

form.onsubmit = function(e) {
    e.preventDefault();

    let files = file.files;
    let formData = new FormData();
    let file = files[0];
    formData.append('fileName', file, file.name);
    let request = new XMLHttpRequest();
    request.open('POST', '/addImage', true);
    request.send(formData);
}