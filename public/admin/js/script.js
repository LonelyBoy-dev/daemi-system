$(function() {
    $(".knob").knob();
});

function numberToword(item) {
    var number=$(item).val();
    if (number.length>3){
        var CSRF_TOKEN = '{{ csrf_token() }}';
        var url = '{{route('Ajax.numberToword')}}';
        var data = {_token: CSRF_TOKEN, number: number};
        $.post(url, data, function (msg) {
            $(item).parent('.form-group').find('.numberToword').html(msg.word)
        })
    }else {
        $(item).parent('.form-group').find('.numberToword').html('')
    }

}
function number_3_3(num, sep) {
    var number = typeof num === "number" ? num.toString() : num,
        separator = typeof sep === "undefined" ? ',' : sep;
    return number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + separator);
}

function delete_all_items(table) {
    var ChkBox=document.getElementsByClassName("checkBox");
    if ($(ChkBox).is(':checked')){
        var id_row = new Array();
        $('input[name="delete"]:checked').each(function() {
            id_row.push(this.value);
        });
        Lobibox.alert('error', {
            title: 'پیغام',
            msg: 'آیا حذف شود',
            delayToRemove: 200,
            width : 311,
            top: 200,
            position: "bottom right",
            showClass:'Lobibox-custom-class-confirm',
            buttons: {
                cancel: {
                    'class': 'btn btn-danger',
                    closeOnClick: true,
                    text:'لغو'
                },
                yes: {
                    'class': 'btn btn-success',
                    closeOnClick: true,
                    text:'بله، حذف شود'
                },
            },
            callback: function(lobibox, type){
                var btnType;
                if (type === 'yes'){

                    var CSRF_TOKEN = '{{ csrf_token() }}';
                    var url = '{{route('Ajax.delete-all-items')}}';
                    var data = {_token: CSRF_TOKEN, id: id_row,table:table};
                    $.post(url, data, function (msg) {
                        if (msg == "deleted") {
                            id_row.forEach(function (element) {
                                $(ChkBox).parents('#item' + element).remove()
                            });
                            Lobibox.notify('success', {
                                size: 'mini',
                                showClass: 'Lobibox-custom-class hide-close-icon',
                                iconSource: "fontAwesome",
                                delay:3000,
                                soundPath: '{{asset('admin/sounds/sounds/')}}',
                                position: 'left top', //or 'center bottom'
                                msg: 'عملیات حذف با موفقیت انجام شد',
                        });
                        }

                    });
                }

            }
        });

    }else{
        Lobibox.notify('warning', {
            size: 'mini',
            rounded: true,
            soundPath: '{{asset('admin/sounds/sounds/')}}',
            sound: 'soundssound6',
            iconSource: "fontAwesome",
            delay:3000,
            showClass: 'Lobibox-custom-class hide-close-icon',
            position: 'left top', //or 'center bottom'
            msg: 'شما چیزی برای حذف انتخاب نکرده اید',

    });
    }

}

function delete_solo_item(tag,id,table) {

    Lobibox.alert('error', {
        title: 'پیغام',
        msg: 'آیا حذف شود',
        delayToRemove: 200,
        width : 311,
        top: 200,
        position: "bottom right",
        showClass:'Lobibox-custom-class-confirm',
        buttons: {
            cancel: {
                'class': 'btn btn-danger',
                closeOnClick: true,
                text:'لغو'
            },
            yes: {
                'class': 'btn btn-success',
                closeOnClick: true,
                text:'بله، حذف شود'
            },
        },
        callback: function(lobibox, type){
            var btnType;
            if (type === 'yes'){
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('Ajax.delete-solo-item')}}';
                var data = {_token: CSRF_TOKEN, id: id,table:table};
                $.post(url, data, function (msg) {
                    if (msg=="deleted"){

                        Lobibox.notify('success', {
                            size: 'mini',
                            showClass: 'Lobibox-custom-class hide-close-icon',
                            iconSource: "fontAwesome",
                            delay:3000,
                            soundPath: '{{asset('admin/sounds/sounds/')}}',
                            position: 'left top', //or 'center bottom'
                            msg: 'عملیات حذف با موفقیت انجام شد',
                    });
                        $(tag).parents('tr').remove();
                        get_price();


                    }

                });
            }

        }
    });


}
