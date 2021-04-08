$(document).ready(function(){

    $("#errorHandler").on("click", function () {
        Swal.fire({
            icon: 'error',
            title: 'Ha ocurrido un problema',
            text: 'Vuelva al index e intentelo de nuevo',
        })


    });
    $("#errorHandler").trigger("click");

    $(".btn-edit").on("click", function () {
        Swal.fire({
            icon: 'success',
            title: 'Hecho',
            text: 'Se redireccionara automaticamente',
            showConfirmButton: false
        })

        setTimeout(() => $("#target").trigger("click"), 2000);
        

    });


    $("#content-container").on("click", "#btn-delete", function () {

        Swal.fire({

            title: 'Desea eliminar el elemento?',
            showDenyButton: true,
            confirmButtonText: `Si`,
            denyButtonText: `No`,

        }).then((result) => {
            if (result.isConfirmed) {
                let id = $(this).data("id");
                let handler = $(this).data("handler");
                if (id !== null && id !== undefined && id !== "") {
                    window.location.href = "actions/delete.php?transactionId=" + id + "&handlerType=" + handler;
                }
            } 
        })

    });

    
});