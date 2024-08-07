$.validator.addMethod(
    'dateDMY',
    function (value, element) {
        return this.optional(element) || /^\d{2}\/\d{2}\/\d{4}$/.test(value);
    },
);

$.validator.addMethod("azAZ09", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
  }, "パスワードには半角数字のみ、または半角英字のみの値は使用できません。");


$.validator.addMethod('onlyNumberAndAlphabetOneByte', function (value, element) {
    const regexEx = /^[ -~]+$/;
    return this.optional(element) || new Blob([value]).size == value.length && regexEx.test(value);
});


$.validator.addMethod('onlyNumberAndAlphabetForPassword', function (value, element) {
    const regexEx = /^(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-z]+$/g;
    return this.optional(element) || regexEx.test(value);
});

$.validator.addMethod('notNull', function (value, element) {
    return this.optional(element) || value != 'null';
});

$.validator.addMethod('stringValueRange', function (value, element, param) {
    return this.optional(element) || param[0] <= value.length &&  value.length <= param[1];
});

$.validator.addMethod('katakanaMaxLength', function (value, element, param) {
    return this.optional(element) || Array.from(value).length <= param;
});

jQuery.validator.addMethod("greaterStart", function (value, element, param) {
    let [dayFrom, monthFrom, yearFrom] = $(param).val().split('/');
    const dateFrom = new Date(+yearFrom, +monthFrom - 1, +dayFrom);

    let [dayTo, monthTo, yearTo] = value.split('/');
    const dateTo = new Date(+yearTo, +monthTo - 1, +dayTo);

    if (! /Invalid|NaN/.test(dateFrom) && !/Invalid|NaN/.test(dateTo)) {
        return this.optional(element) || dateTo >= dateFrom;
    }

    return true;
});

$.validator.addMethod('fileSize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param);
}, function (param, element) {
    var sizeLimit = param / 1024 / 1024; // Convert byte to megabyte
    return 'ファイルのサイズ制限'+sizeLimit+'を超えています。';
});