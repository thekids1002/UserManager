$(document).ready(function () {


    $('#formImportCSV input[type="file"]').on('change', function () {
        $(this).valid();
    })

    $('#formImportCSV').validate({
        rules: {
            'csvFile': {
                // required: {
                //     depends: function(element) {
                //         return $(element).val() !== "";
                //     }
                // },
                extension: 'csv',
                fileSize: 2 * 1024 * 1024,
            }
        },
        messages: {
            'csvFile': {
                required: "File は必須です。",
                extension: function (extension) {
                    return jQuery.validator.messages.extension('CSV');
                },
                fileSize: function (param, element) {
                    var sizeLimit = param / 1024 / 1024;
                    return 'ファイルのサイズ制限' + sizeLimit + 'MBを超えています。';
                },

            }
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            var $csv = $('#csvFile').val();
            if ($csv == "") {
                    $('#csvFile').addClass('error-message');
                    $('#csvFile-error').remove();
                    $('#csvFile').after('<div id="csvFile-error" class="error-message">Fileは必須です。</div>');
            } else {
                 _common.showLoading();
                 form.submit();
            }
        }
    });


    var errorList = $('#errorList');
    var errorsExist = errorList.find('li').length > 0;
    if (errorsExist) {
        $('#errorModal').modal('show');
    }

    $('#importCSVModal').on('hidden.bs.modal', function () {
        $('#csvFile').val('');
        $('#csvFile').removeClass('error-message');
        $('#csvFile-error').remove();
    });
});