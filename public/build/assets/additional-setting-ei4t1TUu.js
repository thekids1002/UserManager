$.fn.extend({trackChanges:function(){$(this).data("serialize",$(this).serialize())},isChanged:function(){return $(this).serialize()!=$(this).data("serialize")},preventDoubleSubmission:function(){return $(this).on("submit",function(t){var e=$(this);e.data("submitted")===!0?t.preventDefault():e.valid()&&e.data("submitted",!0)}),this}});$.fn.timepicker&&$.extend($.fn.timepicker.defaults,{showMeridian:!1,defaultTime:!1});$.extend(jQuery.validator,{messages:{required:function(t,e){return $.validator.format("{0}は必須です。",[$(e).data("label")])},maxlength:function(t,e){return $.validator.format("{0}は「{1}」文字以下で入力してください。（現在{2}文字）",[$(e).data("label"),t,$(e).val().length])},minlength:function(t,e){return $.validator.format("{0}は「{1}」文字以上で入力してください。（現在{2}文字）",[$(e).data("label"),t,$(e).val().length])},checkNumeric:function(t,e){return $.validator.format("{0}は半角数字で入力してください。",[$(e).data("label")])},checkKatakana2ByteAndCharacter:function(t,e){return $.validator.format("{0}は全角カナで入力してください。",[$(e).data("label")])},checkCapital1Byte:function(t,e){return $.validator.format("{0}は半角英大文字で入力してください。",[$(e).data("label")])},date_month:function(t,e){return $.validator.format("{0}は年月を正しく入力してください。",[$(e).data("label")])},greaterThanDate:$.validator.format("{0}は{1}以降の日時を選択してください。"),lessThanDate:$.validator.format("{0}は{1}以降の日時を選択してください。"),checkExceedMonthByFromTo:$.validator.format("{0}と{1}は24ヶ月以内に設定してください。"),checkHiragana2Byte:function(t,e){return $.validator.format("{0}は全角ひらがなで入力してください。",[$(e).data("label")])},checkValidEmailRFC:function(t,e){return $.validator.format("メールアドレスを正しく入力してください。")},checkCharacterlatin:function(t,e){return $.validator.format("{0}は半角英数で入力してください。",[$(e).data("label")])},passwordEqualTo:$.validator.format("新しいパスワードと確認用パスワードが一致しません。"),checkKatakana2Byte:function(t,e){return $.validator.format("{0}は全角カナで入力してください。",[$(e).data("label")])},checkDateOfBirth:$.validator.format("未成年(18歳未満の方)は申込することができません。"),checkCustomerUnique:$.validator.format("入力された内容と一致するアカウントが既に存在します。同一人物で複数のアカウントの作成は出来かねます。"),checkCustomerUniqueByMail:$.validator.format("入力されたメールアドレスは既に使用されています。別のメールアドレスを入力してください。"),checkAllExplainConfirmImportant:$.validator.format("重要事項は必ず説明を行なってください。"),checkExplainConfirmImportant:$.validator.format("上記いずれかの確認を必ず行ってください。"),checkCustomerCanceledContract:$.validator.format("一度解約された場合、同じ物件での再申し込みはできかねます。"),checkBuildingUnique:$.validator.format("入力された内容に一致する建物が既に存在します。同じ建物は複数登録できません。"),checkPasswordIsNotSameCustomerId:$.validator.format("パスワードとお客様IDが同じです。違うパスワードを入力してください。"),startDateBeforeEndDate:$.validator.format("解約予定日は契約終了日前を指定してください。")}});$.validator.setDefaults({errorClass:"error-message",errorElement:"div",ignore:":hidden:not(.chosen-select)",onfocusout:function(t){this.element(t)},invalidHandler:function(t,e){var r=e.numberOfInvalids();if(r){var a=$(e.errorList[0].element);a.focus(),$("html, body").animate({scrollTop:a.offset().top},50)}},submitHandler:function(t){_common.showLoading(),t.submit()},errorPlacement:function(t,e){$(e).hasClass("chosen-select")?$(e).parent("div").append(t):t.insertAfter(e)}});$.validator.methods.minlength=function(t,e,r){var a=$.isArray(t)?t.length:s(t,e);return this.optional(e)||a>=r};$.validator.methods.maxlength=function(t,e,r){var a=$.isArray(t)?t.length:s(t,e);return this.optional(e)||a<=r};$.validator.methods.exactlength=function(t,e,r){var a=$.isArray(t)?t.length:s(t,e);return this.optional(e)||a===r};function s(t,e){if(e)switch(e.nodeName.toLowerCase()){case"select":return $("option:selected",e).length;case"input":if(m(e))return this.findByName(e.name).filter(":checked").length}var r=t.match(/\n/g),a=r?r.length:0;return t.length+a}function m(t){return/radio|checkbox/i.test(t.type)}var o=new Date("2200/12/31"),l=new Date("1700/01/01");$.validator.methods.date=function(t,e,r){var a=new Date(t);return t==""||moment(t,"YYYY/MM/DD",!0).isValid()&&l<=a&&a<=o};$.validator.addMethod("datetime",function(t,e,r){var a=new Date(t);return t==""||moment(t,"YYYY/MM/DD H:mm:ss",!0).isValid()&&l<=a&&a<=o||moment(t,"YYYY/MM/DD H:mm",!0).isValid()&&l<=a&&a<=o||moment(t,"YYYY/MM/DD",!0).isValid()&&l<=a&&a<=o});$.validator.addMethod("date_time",function(t,e,r){return t==""||moment(t,"YYYY/MM/DD H:mm:ss",!0).isValid()||moment(t,"YYYY/MM/DD H:mm",!0).isValid()});$.validator.addMethod("date_month",function(t,e,r){return t==""||moment(t,"YYYY/MM",!0).isValid()||moment(t,"YYYY/MM",!0).isValid()});$.validator.addMethod("futureDate",function(t,e,r){return t.length>0&&moment().startOf("date").isSameOrBefore(moment(t,"YYYY/MM/DD"))});$.validator.addMethod("latin",function(t,e){return this.optional(e)||/^[a-zA-Z0-9~`!@#$%^&*()-_=+<>?,./:;"'{}]*$/.test(t)});$.validator.addMethod("mail_valid",function(t,e,r){if($(r).val()!=""&&t==""||$(r).val()==""&&t!="")return!1;var a=$(r).val().concat("@");return a=a.concat(t),this.optional(e)||/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/i.test(a)});$.validator.addMethod("filesize",function(t,e,r){return this.optional(e)||e.files[0].size<=r*1024*1024});$.validator.addMethod("fixedFileSize",function(t,e,r){return t?this.optional(e)||e.files[0].size<=10*1024*1024:!0});$.validator.addMethod("check2Byte",function(t,e){return t.length>0?t.match(/^[^\x01-\x7E\xA1-\xDF]+$/)?!t.match(/^[ｱ-ﾝﾞﾟｧ-ｫｬ-ｮｰ｡｢｣､]+$/):!1:!0});$.validator.addMethod("check2ByteHfS",function(t,e){for(var r=0;r<t.length;r++){var a=t.charCodeAt(r);if(a>=65377&&a<=65439)return!1;if(!(a>=19968&&a<=40911||a>=13312&&a<=19903||a>=131072&&a<=173791||a>=63744&&a<=64223||a>=194560&&a<=195103||a>=12448&&a<=12543||a>=12352&&a<=12447||a==32||a==12288||a>=65280&&a<=65520))return!1}return!0});$.validator.addMethod("rangeEmail",function(t,e,r){//!#$%&'*+-/=?^_`{|}~.
return this.optional(e)||/^[0-9a-zA-Z\#\!\$\%\(\)\*\+\-\.\/\:\;\?\'\=\`\|\&\@\^\[\]\_\{\}\~]{6,75}$/i.test(t)});$.validator.addMethod("checkKanji",function(t,e){for(var r=0;r<t.length;r++){var a=t.charCodeAt(r);if(!(a>=19968&&a<=40911||a>=13312&&a<=19903||a>=131072&&a<=173791||a>=63744&&a<=64223||a>=194560&&a<=195103||a>=12448&&a<=12543||a>=12352&&a<=12447))return!1}return!0});$.validator.addMethod("checkKatakana",function(t,e){for(var r=0;r<t.length;r++){var a=t.charCodeAt(r);if(!(a>=12448&&a<=12543||a==32||a==12288))return!1}return!0});$.validator.addMethod("checkKatakanaV2",function(t,e){for(var r=0;r<t.length;r++){var a=t.charCodeAt(r);if(!(a>=12448&&a<=12543||a==32||a==12288||a==65288||a==65289))return!1}return!0});$.validator.addMethod("checkKatakana1Byte2Byte",function(t,e){var r=!0;return t.length>0&&(r=!!t.match(/^[\uFF65-\uFF9F\u30A0-\u30FF.\)\(\/\-\　]+$/)),r});$.validator.addMethod("checkKatakana2ByteAndCharacter",function(t,e){var r=!0;return t.length>0&&(r=!!t.match(/^[\u30A0-\u30FF]+$/)),r});$.validator.addMethod("checkCharacterlatin",function(t,e){return this.optional(e)||/^[a-zA-Z0-9]*$/.test(t)});$.validator.addMethod("checkAlphabet",function(t,e){return this.optional(e)||/^[a-zA-Z]*$/.test(t)});$.validator.addMethod("checkNumeric",function(t,e){return this.optional(e)||/^[0-9]*$/.test(t)});$.validator.addMethod("digitsCustom",function(t,e){return this.optional(e)||/^[0-9-]*$/.test(t)});$.validator.addMethod("checkValidEmailRFC",function(t,e){var r=new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/),a=/^[a-zA-Z0-9~`!@#$%^&*()-_=+<>?,./:;"'{}]*$/.test(t);return this.optional(e)||r.test(t)&&a});$.validator.addMethod("mail_valid_RFC",function(t,e,r){if($(r).val()!=""&&t==""||$(r).val()==""&&t!="")return!1;var a=$(r).val().concat("@");a=a.concat(t);var n=new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/),i=/^[a-zA-Z0-9~`!@#$%^&*()-_=+<>?,./:;"'{}]*$/.test(a);return this.optional(e)||n.test(a)&&i});$.validator.addMethod("greaterThanDate",function(t,e,r){return $(r).val().length>0&&t.length>0?/Invalid|NaN/.test(new Date(t))?isNaN(t)&&isNaN($(r).val())||Number(t)>Number($(r).val()):(new Date(t)<=new Date($(r).val())&&$(r).hasClass("error-message")&&($(r).removeClass("error-message"),$(r).next().remove()),new Date(t)<=new Date($(r).val())):!0});$.validator.addMethod("greaterThanDateUpgrade",function(t,e,r){return $(r).val().length>0&&t.length>0&&moment(t,"YYYY/MM/DD",!0).isValid()&&moment($(r).val(),"YYYY/MM/DD",!0).isValid()?(new Date(t)<=new Date($(r).val())&&$(r).hasClass("error-message")&&($(r).removeClass("error-message"),$(r).next().remove()),new Date(t)<=new Date($(r).val())):!0});$.validator.addMethod("lessThanDate",function(t,e,r){return $(r).val().length>0&&t.length>0&&moment(t,"YYYY/MM/DD",!0).isValid()&&moment($(r).val(),"YYYY/MM/DD",!0).isValid()?(new Date(t)>=new Date($(r).val())&&$(r).hasClass("error-message")&&($(r).removeClass("error-message"),$(r).next().remove()),new Date(t)>=new Date($(r).val())):!0});$.validator.addMethod("checkCapital1Byte",function(t,e){return this.optional(e)||/^[A-Z]*$/.test(t)});$.validator.addMethod("checkExceedMonthByFromTo",function(t,e,r){var a=25;typeof $(e).data("exceed-month")<"u"&&(a=$(e).data("exceed-month"));const n=$(r).val();if(n.length>0&&t.length>0&&moment(n,"YYYY/MM",!0).isValid()&&moment(t,"YYYY/MM",!0).isValid()){const i=moment(n,"YYYY/MM").diff(moment(t,"YYYY/MM"),"months",!0);return!(Math.abs(i)>=a)}return!0});$.validator.addMethod("checkHiragana2Byte",function(t,e){for(let r=0;r<t.length;r++){let a=t.charCodeAt(r);if(!(a>=12352&&a<=12447))return!1}return!0});$.validator.addMethod("checkKatakana2Byte",function(t,e){var r=!0;return t.length>0&&(r=!!t.match(/^[・\u30a0-\u30ff　]*$/)),r});$.validator.addMethod("checkDateOfBirth",function(t,e){var a=$(".datedd-year").val(),n=$(".datedd-month").val(),i=$(".datedd-day").val();if(moment(t,"YYYY/MM/DD",!0).isValid()){var d=t.split("/");a=d[0],n=d[1],i=d[2]}if(a!=""&&n!=""&&i!=""){var h=new Date;h.setFullYear(a,n-1,i);var f=new Date;return f.setFullYear(f.getFullYear()-18),f>=h}return!0});$.validator.addMethod("startDateBeforeEndDate",function(t,e){var r=moment($("#started-date-from").val(),"DD/MM/YYYY"),a=moment($("#started-date-to").val(),"DD/MM/YYYY");return r.isValid()&&a.isValid()?r.isSameOrBefore(a):!0},"解約予定日は契約終了日前を指定してください。");
