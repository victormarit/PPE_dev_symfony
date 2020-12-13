$("document").ready(function(){
    $(".delete").on("click", function (e) {
        e.preventDefault();
        $("#modalDeleteAlert").modal('toggle');
        $("#modalAlertNon").off("click").on("click", function () {
           $("#modalDeleteAlert").modal('toggle');
        });
        $("#modalAlertOui").off("click").on("click", function () {
            window.location = e.currentTarget.href;
        });
    });
});
