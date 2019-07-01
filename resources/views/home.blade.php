@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-12">
                @if(!$paySlipUploaded)
                    <div class="alert alert-info shadow" role="alert">
                        Please enter your details first. Let us know if your're bringing a plus one. Finally upload the slip for the required amount.
                        (3000.00 LKR per person)
                    </div>
                @else
                    <div class="alert alert-success shadow" role="alert">
                        Your details were saved successfully! After (CS)² verifies your info, you will receive an email with ticket information. Thank you.
                        We hope to see you soon!
                    </div>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header {{isset($p) ? 'bg-success text-white' : 'bg-white'}}  font-weight-bold">Your Details</div>
                    <div class="card-body">
                        <form method="POST" action="{{route('handleYourDetailsSave')}}">
                            @csrf
                            <div class="form-group">
                                <label for="fullName">Full Name</label>
                                <input name="full_name" value="{{isset($p) ? $p->full_name : old('full_name')}}" {{isset($p) ? 'disabled' : ''}} type="text" class="form-control" id="fullName"
                                       placeholder="Your full name" required>
                            </div>

                            <div class="form-group">
                                <label for="itNumber">IT Number</label>
                                <input name="it_number" value="{{isset($p) ? $p->it_number : old('it_number')}}" {{isset($p) ? 'disabled' : ''}} type="text" class="form-control" id="itNumber"
                                       aria-describedby="itNumberHelp"
                                       placeholder="ITXXXXXXXX" required>
                                <small id="itNumberHelp" class="form-text text-muted">We'll never share your IT Number with anyone else.</small>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="grad_year">Graduated year</label>
                                    <input name="grad_year" value="{{isset($p) ? $p->grad_year : old('grad_year')}}" {{isset($p) ? 'disabled' : ''}} type="text" class="form-control" id="grad_year"
                                           aria-describedby="grad_yearHelp"
                                           placeholder="2016" pattern=".{4,4}"
                                           title="4 characters only" required>
                                    <small id="grad_yearHelp" class="form-text text-muted">The year you graduated: e.g: 2016</small>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="grad_month">Month</label>
                                    <select name="grad_month" id="grad_month" class="form-control" {{isset($p) ? 'disabled' : ''}} required>
                                        <option value="march" {{isset($p) ? ($p->grad_month === 'march' ? 'selected': '' ) : ''}}>March</option>
                                        <option value="august" {{isset($p) ? ($p->grad_month === 'august' ? 'selected': '' ) : ''}}>August</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="InputEmail1">Personal Email address</label>
                                <input name="personal_email" value="{{isset($p) ? $p->personal_email : old('personal_email')}}" {{isset($p) ? 'disabled' : ''}} type="email" class="form-control"
                                       id="InputEmail1"
                                       aria-describedby="emailHelp1"
                                       placeholder="Enter Personal email" required>
                                <small id="emailHelp1" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>

                            <div class="form-group">
                                <label for="InputEmail2">Work Email address</label>
                                <input name="work_email" value="{{isset($p) ? $p->work_email : old('work_email')}}" {{isset($p) ? 'disabled' : ''}} type="email" class="form-control" id="InputEmail2"
                                       aria-describedby="emailHelp2"
                                       placeholder="Enter Work email">
                                <small id="emailHelp2" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input name="phone" value="{{isset($p) ? $p->phone : old('phone')}}" {{isset($p) ? 'disabled' : ''}} type="text" class="form-control" id="phone"
                                       placeholder="Contact Number" required>
                                <small class="form-text text-muted">Use the following format: 0771234567</small>
                            </div>

                            <div class="form-group form-check {{$paySlipUploaded ? 'd-none':''}}">
                                <input name="is_plus_one" {{isset($p) ? ($p->is_plus_one ? 'checked disabled': '' ) : ''}}  type="checkbox" class="form-check-input"
                                       id="exampleCheck1"
                                       onclick="showPlusOneCard(this)">
                                <label class="form-check-label" for="exampleCheck1">I'm bringing a plus one!</label>
                            </div>

                            <input type="hidden" name="total_amount" value="{{isset($p) ? $p->total_amount : '3000.00'}}" id="total_amount">
                            <button type="submit" class="btn {{isset($p)? 'd-none':'btn-primary'}} btn-block">Save</button>
                        </form>
                    </div>
                </div>

                <div class="card mt-3 shadow" id="plusOneCard">
                    <div class="card-header {{isset($p1) ? 'bg-success text-white' : 'bg-white'}} font-weight-bold">Plus One's Details</div>
                    <div class="card-body">
                        @if(!isset($p))
                            <div class="alert alert-warning" role="alert">
                                Please enter and submit your details first. Then, let us know if your're bringing a plus one.
                            </div>
                        @else
                            <form method="POST" action="{{route('handlePlusOneSave')}}">
                                @csrf
                                <div class="form-group">
                                    <label for="plusOne_fullName">Full Name</label>
                                    <input type="text" name="full_name" value="{{isset($p1) ? $p1->full_name : old('full_name')}}" {{isset($p1) ? 'disabled' : ''}}  class="form-control"
                                           id="plusOne_fullName" placeholder="Enter Full Name"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label for="plusOne_idCardNumber">National ID Card Number</label>
                                    <input type="text" name="nic" value="{{isset($p1) ? $p1->nic : old('nic')}}" {{isset($p1) ? 'disabled' : ''}} class="form-control" id="plusOne_idCardNumber"
                                           placeholder="NIC" required>
                                </div>
                                <button type="submit" class="btn {{isset($p1) ? 'd-none':'btn-primary'}} btn-block" {{isset($p) ? '':'disabled'}}>Save</button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow ">
                    <div class="card-header text-center font-weight-bold {{$paySlipUploaded ? 'bg-success text-white':'bg-white'}}">Payment Summary</div>
                    <div class="card-body">
                        <h5>Ticket Count : <span id="ticketCount">1 Ticket</span></h5>
                        <h4 class="h4">Total Amount : <span id="totalAmount">3000.00 LKR</span></h4>

                        @if(!$paySlipUploaded)
                            @if(isset($p))
                                <hr>
                                <form method="POST" enctype="multipart/form-data" action="{{route('handleSlipUpload')}}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="slipUpload">Upload Payment Slip</label>
                                        <input type="file" class="form-control-file" id="slipUpload" name="slipUpload" {{isset($p) ? '': 'disabled'}} {{$paySlipUploaded ? 'disabled':''}} required>
                                        <small class="form-text text-muted">Upload image/jpeg, image/jpg, image/png, image/bmp files only.</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block" {{isset($p) ? '': 'disabled'}} {{$paySlipUploaded ? 'disabled':''}}>Upload</button>
                                </form>
                            @endif
                        @else
                            <img src="{{asset('storage/'.$p->pay_slip_filename)}}" class="img-thumbnail">
                        @endif


                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>

        showPlusOneCard(document.getElementById('exampleCheck1'));


        function showPlusOneCard(element) {
            let plusOneCard = document.getElementById('plusOneCard');
            console.log(element.checked);
            if (element.checked) {
                plusOneCard.classList.remove('d-none');
                document.getElementById('ticketCount').innerText = '2 Tickets';
                document.getElementById('totalAmount').innerText = '6000.00 LKR';
                document.getElementById('total_amount').value = '6000.00';
            } else {
                plusOneCard.classList.add('d-none');
                document.getElementById('ticketCount').innerText = '1 Ticket';
                document.getElementById('totalAmount').innerText = '3000.00 LKR';
                document.getElementById('total_amount').value = '3000.00';
            }
        }

    </script>
@endsection
