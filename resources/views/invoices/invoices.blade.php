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
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
			<!-- row -->
			<div class="row">

				@if (session('success'))
					<script>
						window.onload = function() {
							notif({
								msg: "تم حذف الفاتورة بنجاح",
								type: "success"
								// type: "error"
							})
						}
					</script>
				@endif

				@if (session('Status_Update'))
					<script>
						window.onload = function() {
							notif({
								msg: "تم تغير حالة الدفع بنجاح",
								type: "success"
								// type: "error"
							})
						}
					</script>
				@endif

				{{-- ================================================================ --}}

				<div>

						@can('تصدير إكسيل')
							<a class="btn btn-primary" href="{{ url('export_invoice') }}"> تصدير إكسيل</a>
						@endcan
						
						@can('إضافة فاتورة')
							<a class="btn btn-primary" href="{{ route('invoices.create') }}">إضافة فاتورة</a>
						@endcan

				</div>

		{{-- ================================================================ --}}
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

				 {{-- modal --}}
				 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h1 class="modal-title fs-5" id="exampleModalLabel">حذف الفاتورة</h1>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="invoices/destroy" method="POST">
							
							@csrf
							@method('DELETE')
							<div class="modal-body">

								<h3>هل انت متاكد من عملية الحذف ؟</h3>
								<input type="hidden" name="id" id="id" value="">

							</div>

							<div class="modal-footer">
								<button type="submit" class="btn btn-danger">حذف</button>
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
							</div>
						</form>
					</div>
					</div>
				</div>


{{-- ============================================ --}}

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

{{-- ============================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
    var exampleModal = document.getElementById('exampleModal');
    
    exampleModal.addEventListener('show.bs.modal', function (event) {

        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var modalIdInput = exampleModal.querySelector('.modal-body #id');

        modalIdInput.value = id;
    });
});
</script>
@endsection