<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
      <form class="mt-3" id="guest-edit-form" action="{{ route('guest.play.update') }}" method="post">
        @csrf
        <div class="row mb-4">
            <div class="col-12 col-sm-6 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Guest of</span>
                    </div>
                    <input type="text" class="form-control" value="{{ $member->Member_Fistname }} {{ $member->Member_Lastname ?? ''}}" readonly disabled>
                    <input type="hidden" class="form-control" name="member" value="{{ $member->MemberID }}">
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Mobile</span>
                    </div>
                    <input type="text" class="form-control" name="mobile" value="{{ $registration->reg_phone }}" readonly>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">First Name</span>
                    </div>
                    <input type="text" class="form-control" name="guestFName" @if(isset($registration->reg_fistname)) value="{{ $registration->reg_fistname }}" @endif>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Last Name</span>
                    </div>
                    <input type="text" class="form-control" name="guestLName" @if(isset($registration->reg_fistname)) value="{{ $registration->reg_lastname }}" @endif>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Club</span>
                    </div>
                    <select name="club" id="club" class="form-control">
                        <option value="">Select</option>
                        @if($clubs->isNotEmpty())
                            @foreach($clubs as $club)
                                <option value="{{$club->value}}" @if(isset($registration->reg_club) && $registration->reg_club == $club->text) selected @endif>{{$club->text}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">HCP</span>
                    </div>
                    <input type="text" class="form-control" name="hcp" autocomplete="off" @if(isset($registration->reg_hcp)) value="{{ $registration->reg_hcp }}" @endif>
                </div>
            </div>
            @if($registration->reg_payment_type === 'Cash' || $registration->reg_payment_type === 'Not Paid')
                <div class="col-12 col-sm-6 mb-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Payment</span>
                        </div>
                        <select name="payment" id="payment" class="form-control">
                            <option value="Cash" @if($registration->reg_payment_type === 'Cash') selected @endif>Cash</option>
                            <option value="Voucher" @if($registration->reg_payment_type === 'Voucher') selected @endif>Voucher</option>
                            @if($registration->status == 0)
                            <option value="Not Paid" @if($registration->reg_payment_type === 'Not Paid') selected @endif>Not Paid</option>
                            @endif
                        </select>
                    </div>
                </div>
            @endif
            <div class="col-12 col-sm-6 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Date Of Play</span>
                    </div>
                    <input type="text" class="form-control" id="date_of_play" name="date_of_play" autocomplete="off" @isset($registration->date_of_play) value="{{ $registration->date_of_play }}" @endif>
                </div>
            </div>
            <input type="hidden" name="reg" @isset($registration)value="{{ $registration->reg_auto }}"@endisset>
        </div>
      <button type="submit" class="btn btn-success">Update</button>
      <label type="button" class="btn btn-danger" id="close_model" onclick="closeModal();" data-dismiss="modal">Cancel</label>
    </form>
    </div>
  </div>
</div>
<script>
    $("#date_of_play").datepicker({
        dateFormat: "yy-mm-dd",
        maxDate: new Date()
    });

    $("#date_of_play").on('change', function () {
        var selectedDate = $(this).val();
        var todaysDate = "{{ Carbon\Carbon::now()->format('Y-m-d') }}";
        if (selectedDate > todaysDate) {
            alert('Selected date must be less than or equal to today date');
            $(this).val('');
        }
    });
</script>
