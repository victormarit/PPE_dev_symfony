$("document").ready(function(){
    $(".add").on("click", function (e) {
        e.preventDefault();
        $("#modalAddAlert").modal('toggle');
        $("#modalAddAlertNon").off("click").on("click", function () {
            window.location = "/user/creationPatientEtSejour";
        });
        $("#modalAddAlertOui").off("click").on("click", function () {
            window.location = e.currentTarget.href;
        });
    });
});
