let form = document.getElementById('imageForm');
let file = document.getElementById('fileName');
let error = document.getElementById('error');

form.onsubmit = function(e) {
    e.preventDefault();

    let files = file.files;
    let formData = new FormData();
    let file = files[0];
    console.log("dadaism");
    // return false;
    // if (file == null) {
    //     error.innerHTML = 'Select image.';
    //     return false;
    // }
    // if (!file.type.match(/.(jpg|jpeg|png|gif)$/i)) {
    //     error.innerHTML = 'The file selected is not an image.';
    //     return;
    // }
    // formData.append('fileName', file, file.name);
    // let request = new XMLHttpRequest();
    // request.open('POST', '/addImage', true);
    // request.send(formData);
}