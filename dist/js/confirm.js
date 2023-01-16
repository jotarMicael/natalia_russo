
function confirm(url,bool) {
    Swal.fire({
        title: '¿Esta seguro/a?',
        text: "No podrá revertir los cambios",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si!',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            if(bool){
                window.location.href = url;
            }
         
            $(url).submit();


        }
        return false;
    })

}







