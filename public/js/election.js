$(document).ready(function () {
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
    });

    $('.custom-file-input').on('change',function(){
        var fileName = $(this).val();
        $(this).next('.custom-file-label').html(fileName);
    });
});