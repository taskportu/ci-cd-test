@extends('layout')
@section('home')
    <div class="container" style="margin-top: 8rem;">
        <h5 class="text-center pb-1">SEND SMS FOR FARGERIKE</h5>
        <div class="col-6 pt-5  mx-auto">
            <div id="jsMess"></div>
            <form method="POST">
                @csrf
                <div class="mb-3">
                    <label for="phone_no" class="form-label">Mobile No</label>
                    <input type="text" class="form-control" id="phone_no" placeholder="Mobile">
                    <small id="errorPhone"></small>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" class="form-control" id="message" cols="50" rows="3" placeholder="Message">

Spørsmål: ring 46965054. SMS kan ikke besvares.

                    </textarea>
                    <small id="errorMessage" class="d-none"></small>
                </div>
                <button class="btn btn-success pl-2 pr-2" type="button" id="send-sms_frm" disabled>SEND</button>
            </form>
        </div>


        @endsection
        @push('script2')
            <script>
                let error = true;

                $('#phone_no').on('change keyup', function() {
                    let phone = $(this).val();
                    let status = isNumber(phone);
                    if(status === true) {
                        $('#errorPhone').empty().text('Not Valid Format!').removeClass('d-none');
                        error = true;
                    }
                    else {
                        $('#errorPhone').empty().addClass('d-none');
                        error = false;
                    }
                    checkErr();
                    // console.log(status, phone);

                });

                $('#message').on('change click keyup', function() {
                    messageReq();
                    let phone = $(this).val();
                    isNumber(phone);
                    checkErr();
                });

                $('#send-sms_frm').on('click', function(e) {
                    $.confirm({
                        title: 'Confirm?',
                        content: 'Ready to send message?',
                        icon: 'fa fa-question-circle',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        opacity: 0.5,
                        type: 'red',
                        buttons: {
                            'confirm': {
                                text: 'Proceed',
                                btnClass: 'btn-success',
                                action: function(){
                                    let phone = $('#phone_no').val();
                                    let message = $('#message').val();
                                    isNumber(phone);
                                    messageReq();
                                    if(error === true) e.preventDefault();
                                    else {
                                        $.ajax({
                                            type: 'POST',
                                            url:'{{route('send.sms')}}',
                                            data: {'phone_no': phone, 'message' : message, '_token': '{{csrf_token()}}'},
                                            success: function (response) {
                                                if(response.type =='success'){
                                                    $('form').trigger("reset");
                                                    $('#jsMess').append('<div class="alert alert-success">'+response.message+'</div>');
                                                    setTimeout(function () {
                                                        $('#jsMess').empty();
                                                    }, 5000);
                                                }
                                                else if(response.type =='error'){
                                                    $('#jsMess').append('<div class="alert alert-danger">'+response.message+'</div>');
                                                    setTimeout(function () {
                                                        $('#jsMess').empty();
                                                    }, 5000);
                                                }
                                                console.log(response);
                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                console.log(textStatus, errorThrown);
                                            }
                                        })
                                    }
                                }
                            },
                            cancel: {
                                btnClass: 'btn-danger',
                            },
                        }
                    });
                });

                function isNumber(number) {
                    var regex = /^(0|[0-9]{8})$/;
                    // var regex = /^([0-9]{1,8}\d*)$/;
                    // var regex = /^[0-9]{8,8}$;
                    let state = regex.test(number);
                    if(state === true) error = false;
                    else error = true;

                    // console.log(error);
                    return error;
                }

                function checkErr() {
                    let phone = $("#phone_no").val();
                    isNumber(phone);
                    messageReq();
                    if(messageReq() || isNumber(phone)) {
                        $('#send-sms_frm').attr('disabled', true);
                    }
                    else {
                        $('#send-sms_frm').removeAttr('disabled');
                    }
                    console.log(messageReq() , isNumber(phone));
                    // if(error === false) $('#send-sms_frm').removeAttr('disabled');
                    // else $('#send-sms_frm').attr('disabled', true);
                }

                function messageReq() {
                    let mess = $('#message').val();
                    if(mess === null || mess === '' || mess === undefined) {
                        $('#errorMessage').empty().text('Message is Required!').removeClass('d-none');
                        error = true;
                    }
                    else {
                        $('#errorMessage').empty().addClass('d-none');
                        error = false;
                    }
                    return error;
                }
            </script>
    @endpush
