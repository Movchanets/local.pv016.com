
document.getElementById('delete').confirm
function Delete(id) {

    if (window.confirm("Do you really want to delete this?"))
        console.log(id);
        var bodyFormData = new FormData();
        bodyFormData.append('id', id);
        axios({
            method: "post",
            url: "/delete.php",
            data: bodyFormData,
            headers: { "Content-Type": "multipart/form-data" },
        }).then(res => {
            console.log("respServer",res);
        });
        }



