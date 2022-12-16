
const image = document.getElementById('image');
let imgdata = null;
let cropper = null;

$('label[for="fileInput"]').click(function(e) {
    e.preventDefault();
});
$('label[for="fileInput"]').on("dblclick", (e) =>
{
    $("#fileInput").click();
})
$("#fileInput").on("change", (e)=>{
    let file = e.target.files[0];
    console.log(file);
    const url = URL.createObjectURL(file);
    console.log(url);
    image.src = url;
    $('#preview').src = url;
    cropper?.destroy();
cropper = new Cropper(image, {
    aspectRatio: 3 / 4,
    crop(event) {
        // console.log(event.detail.x);
        // console.log(event.detail.y);
        // console.log(event.detail.width);
        // console.log(event.detail.height);
        // console.log(event.detail.rotate);
        // console.log(event.detail.scaleX);
        // console.log(event.detail.scaleY);
    },});
    $('#btnCrop').click(function() {

        imgdata = cropper.getCroppedCanvas().toDataURL();
        document.getElementById('preview').src =imgdata;
    });
    $('#btnRestore').click(function() {
        cropper.reset();

        console.log("reset")
        imgdata = cropper.getCroppedCanvas().toDataURL();
        document.getElementById('preview').src = imgdata;
    });
    $('#btnRotate').click(function (){
        cropper.rotate(90);
        console.log();
        imgdata = cropper.getCroppedCanvas().toDataURL();
       document.getElementById('preview').src = imgdata;
    });
})
// <script>
// var ImgDiv = document.getElementById('images');
//
// var input = ImgDiv.children.item(1);
//
// function CreateNewInput() {
//     let newInput = document.createElement('input');
//     newInput.type = 'file';
//     newInput.name = 'pictures[]';
//     newInput.className = 'col-12'
//
//     let child = ImgDiv.appendChild(newInput);
//     child.onchange = CreateNewInput;
//
// }
//
// input.onchange = CreateNewInput;
// </script>