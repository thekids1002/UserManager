$(function () {
    // Force reload page when click back button in Safari, Chrome (IOS/MacOS)
    window.onpageshow = function (event) {
        if (event.persisted) {
            // If page load from cache
            window.location.reload();
        }
    };

    /**
     * main common object
     * include all common function and variables
     */
    var _common = {};
    var _messages = {};

    // bind to window variable, make it usable everywhere
    $.extend(window, {
        _common: _common,
        _messages: _messages,
    });

    // common Ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    });

    // hidden session error when change input
    $('input').keypress(function () {
        $('.alert-danger').hide();
    });

    /**
     * Show loading
     * @param {*} isShow
     */
    function showLoading(isShow = true) {
        $("button[type='submit']").prop("disabled", isShow);
        if (isShow) {
            $('#loading').show();
        } else {
            $('#loading').hide();
        }
    }
    _common.showLoading = showLoading;

    /**
     * Check value is empty or not
     * @param string val
     * @returns boolean
     */
    function isEmpty(val) {
        return (val === undefined || val == null || val.length <= 0) ? true : false;
    }
    _common.isEmpty = isEmpty;

    // add validate
    function addValidate(element, rules) {
        element.rules('add', rules);
    }
    _common.addValidate = addValidate;

    // remove validate
    function removeValidate(element, rules) {
        element.rules('remove', rules);
        removeErrorMessage(element);
    }
    _common.removeValidate = removeValidate;

    // remove error message
    function removeErrorMessage(element) {
        element.removeClass('error-message');
        $('#' + element.attr('id') + '-error').remove();
    }
    _common.removeErrorMessage = removeErrorMessage;

    /**
     * Clear form search
     */
    $('.btn-clear-search').click(function () {
        var closestForm = $(this).closest('form');
        var radioElement = closestForm.find('.i-radio');
        var dateElement = closestForm.find('.datepicker') ? closestForm.find('.date-month'): '';
        closestForm.trigger('reset');
        closestForm.find('input:text, input:password, input:file, textarea').val('');
        closestForm.find('.i-radio, .i-checkbox').closest('div').removeClass('checked');
        closestForm.find('.i-radio, .i-checkbox').removeAttr('checked');
        closestForm.find('select').each(function () {
            var optVal = $(this).find('option:first').val();
            $(this).val(optVal);
            $(this).trigger('change');
            $(this).trigger('chosen:updated');
        });
        closestForm.find('.select-with-search').val('');
        // default checked for radio input
        if (radioElement.closest('.check').data('default')) {
            radioElement.each(function () {
                if ($(this).val() == radioElement.closest('.check').data('default')) {
                    $(this).attr('checked', true);
                    $(this).closest('div').addClass('checked');
                    $(this).trigger('change');
                }
            });
        }
        // default data for date input
        dateElement.each(function () {
            if ($(this).data('default') && $(this).data('is-default')) {
                $(this).val($(this).data('default'));
            } else {
                $(this).val('');
            }
        });

        $('form').valid();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: $(this).data('url'),
            type: 'get',
            data: {
                screen: $(this).data('screen'),
            },
            dataType: 'json',
            success: function (response) {}
        });
    });

    $('#menu-userList').click(function(event) {
        event.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '/admin/user/clear',
            type: 'post',
            dataType: 'json',
            success: function (response) {
                window.location.href = $('#menu-userList').attr('href');
            }
        });
       
    });
});
