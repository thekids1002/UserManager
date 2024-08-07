$(function(){$("#login-form").validate({onfocusin:function(e){$(".alert-danger").hide()},rules:{email:{required:!0,checkValidEmailRFC:!0},password:{required:!0}}})});
