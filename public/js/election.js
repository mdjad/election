$(document).ready(function () {
    $.datetimepicker.setLocale('fr');

    $('.datepicker').datetimepicker({
        timepicker:false,
        mask:true,
        formatDate:'d/m/Y',
    });

    $('.datetimepicker').datetimepicker({
        format:'d/m/Y H:i'
    });
});