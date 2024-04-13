@extends('layouts.master')
@section('css')
{{-- bootstrap --}}
<link href="{{URL::asset('assets/me/bootstrap.min.css')}}" rel="stylesheet" />
{{-- notify --}}
<link href="{{URL::asset('assets/me/notify/css/notifIt.css')}}" rel="stylesheet" />
{{-- my style --}}
<link href="{{URL::asset('assets/me/style.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تغير حالة الدفع</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row light mb-4">
                    <div class="col-6">
                        <form action="{{ route('change_status', $invoice->id) }}" method="POST">
                        @csrf

                        <label for="status" class="label-control">تغير حالة الدفع</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="" selected disabled>--حددالحالة--</option>
                            <option value="1">مدفوعة</option>
                            <option value="3"> مدفوعة جزئيا</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="payment_date" class="label-control">تاريخ الدفع</label>
                        <input type="date" name="payment_date" id="payment_date" class="form-control @error('payment_date') is-invalid @enderror">
                        @error('payment_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <input type="submit" value="حفظ البيانات" class="col-3 btn btn-primary">
                </form>
                    

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<script src="{{URL::asset('assets/me/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/me/bootstrap.bundle.min.js')}}"></script>
{{-- notify --}}
<script src="{{ URL::asset('assets/me/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/me/notify/js/notifit-custom.js') }}"></script>
@endsection