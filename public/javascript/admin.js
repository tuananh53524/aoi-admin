tinymce.init({
    selector: 'textarea#content',
    license_key: 'gpl', // change this value according to the HTML
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons',
    plugins: [
        'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
        'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
        'media', 'table', 'emoticons', 'help'
    ],

});
function previewImage(event, previewId) {
    const preview = document.getElementById(previewId);
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden'); // Hiện ảnh preview
        };

        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.classList.add('hidden'); // Ẩn ảnh preview nếu không có file
    }
}