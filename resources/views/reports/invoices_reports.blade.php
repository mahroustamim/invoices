@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/me/bootstrap.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقارير العملاء</span>
						</div>
					</div>
				
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
<div class="row">

    <div class="col-xl-12">
        <div class="card mg-b-20">


            <div class="card-header pb-0">

                <form action="{{ route('invoices_search') }}" method="POST" role="search" autocomplete="off">
                    @csrf

                    <div class="col-lg-3">
                        <label class="rdiobox">
                            <input checked name="radio" type="radio" value="1" id="radio_one"> <span>بحث بنوع
                                الفاتورة</span></label>
                    </div>


                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                        <label class="rdiobox"><input name="radio" value="2" type="radio" id="radio_two"><span>بحث برقم الفاتورة
                            </span></label>
                    </div><br><br>

                    <div class="row">

                        <div class="col-lg-3 mg-t-20 mg-lg-t-0" id="type">
                            <p class="mg-b-10">تحديد نوع الفواتير</p>
							<select class="form-control" name="type">
                                <option value="" selected disabled> -- حدد نوع الفاتورة -- </option>

                                <option value="1">الفواتير المدفوعة</option>
                                <option value="2">الفواتير الغير مدفوعة</option>
                                <option value="3">الفواتير المدفوعة جزئيا</option>

                            </select>
                        </div><!-- col-4 -->


                        <div class="col-lg-3 mg-t-20 mg-lg-t-0" id="invoice_number">
                            <p class="mg-b-10">البحث برقم الفاتورة</p>
                            <input type="text" class="form-control" id="invoice_number" name="invoice_number">

                        </div><!-- col-4 -->

                        <div class="col-lg-3" id="start_at">
                            <label for="from_date">من تاريخ</label>
                            <input id="from_date" class="form-control" type="date" name="start_at">
                        </div>

                        <div class="col-lg-3" id="end_at">
							<label for="to_date">الي تاريخ</label>
							<input id="to_date" class="form-control" type="date"  name="end_at">
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-2 col-md-2">
                            <button class="btn btn-primary btn-block mb-3">بحث</button>
                        </div>
                    </div>
                </form>

            </div>

		@if (isset($invoices))

			@if($invoices->isEmpty())
			
				<p class="mt-3 me-3">لا يوجد نتائج</p>

			@else
				<div class="table-responsive">
					<table class="table table-hover mt-3" >
						<thead class="table-dark">
							<tr>
								<th class="pt-3 pb-3 text-light align-middle">#</th>
								<th class="pt-3 pb-3 text-light align-middle">تاريخ الاصدار</th>
								<th class="pt-3 pb-3 text-light align-middle">تاريخ الاستحقاق</th>
								<th class="pt-3 pb-3 text-light align-middle">المنتج</th>
								<th class="pt-3 pb-3 text-light align-middle">القسم</th>
								<th class="pt-3 pb-3 text-light align-middle">الخصم</th>
								<th class="pt-3 pb-3 text-light align-middle">قيمة الضريبة</th>
								<th class="pt-3 pb-3 text-light align-middle">الاجمالي</th>
								<th class="pt-3 pb-3 text-light align-middle">الحالة</th>
								<th class="pt-3 pb-3 text-light align-middle">العمليات</th>
							</tr>
							</thead>
							<tbody>
								@php
									$i = 0;
								@endphp
								@foreach ($invoices as $invoice)
								@php
									$i++
								@endphp
								<tr>
									<th class="align-middle" scope="row">{{ $i }}</th>
									<td class="align-middle">{{ $invoice->invoice_date }}</td>
									<td class="align-middle">{{ $invoice->due_date }}</td>
									<td class="align-middle">{{ $invoice->product }}</td>
									<td class="align-middle"> {{ $invoice->section->section_name }}</td>
									<td class="align-middle">{{ $invoice->discount }}</td>
									<td class="align-middle">{{ $invoice->value_vat }}</td>
									<td class="align-middle">{{ $invoice->total }}</td>
									<td class="align-middle">
										@if ($invoice->value_status == 1)
											<span class="text-success">مدفوعة</span>
										@elseif($invoice->value_status == 2)
											<span class="text-danger">غير مدفوعة</span>
										@else
											<span class="text-warning ">مدفوعة جزئيا</span>
										@endif

									</td>
									<!-- Example single danger button -->
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
											العمليات
											</button>
											<ul class="dropdown-menu">
												<li><a class="dropdown-item" href="{{ route('InvoicesDetails', $invoice->id) }}">تفاصيل</a></li>

												@can('تعديل الفاتورة')
													<li><a class="dropdown-item" href="{{ route('invoices.edit', $invoice->id) }}">تعديل</a></li>
												@endcan

												@can('حذف الفاتورة')
													<li> <a class="dropdown-item" data-bs-toggle="modal" href="#exampleModal" data-id="{{ $invoice->id }}">حذف</a> </li>
												@endcan

												@can('تغير حالة الدفع')
													<li><a class="dropdown-item" href="{{ route('invoices.show', $invoice->id) }}">تغير الدفع</a></li>
												@endcan

												<li><a class="dropdown-item" href="{{ route('invoices.print', $invoice->id) }}">طباعة الفاتورة</a></li>
											</ul>
										</div>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div> 
			@endif  <!-- end if -->
			@endif  <!-- end if isset-->
        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
{{-- bootsrap --}}
<script src="{{URL::asset('assets/me/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/me/bootstrap.bundle.min.js')}}"></script>


<script>


	document.addEventListener('DOMContentLoaded', function() {

		let radioOne = document.getElementById('radio_one');
		let radioTwo = document.getElementById('radio_two');
		let type = document.getElementById('type')
		let invoiceNumber = document.getElementById('invoice_number');
		let start_at = document.getElementById('start_at');
		let end_at = document.getElementById('end_at');

		invoiceNumber.style.display = 'none';

		radioOne.onclick= function() {
			invoiceNumber.style.display = 'none';
			type.style.display = 'block';
			start_at.style.display = 'block';
			end_at.style.display = 'block';
		}

		radioTwo.onclick= function() {
			invoiceNumber.style.display = 'block';
			type.style.display = 'none';
			start_at.style.display = 'none';
			end_at.style.display = 'none';
		}

	});

</script>

@endsection