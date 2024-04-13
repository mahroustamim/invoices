@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/me/bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/me/style.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتورة</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row light mb-4">

                    {{-- ================================================================ --}}
								{{-- form error --}}
							@if ($errors->any())
								<div class="alert alert-danger">
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
								</div>
							@endif
								{{-- success message --}}
							@if (session('success'))
								<div class="alert alert-success">
											{{ session('success') }}
								</div>
							@endif
	{{-- ================================================================ --}}
    
	{{-- =============================== button ================================= --}}
                    <ul class="nav nav-tabs mb-3 light" id="ex1" role="tablist">

                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link active"
                                id="ex1-tab-1"
                                data-bs-toggle="tab"
                                href="#ex1-tabs-1"
                                role="tab"
                                aria-controls="ex1-tabs-1"
                                aria-selected="true"
                                >معلومات الفاتورة</a
                            >
                        </li>

                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link"
                                id="ex1-tab-2"
                                data-bs-toggle="tab"
                                href="#ex1-tabs-2"
                                role="tab"
                                aria-controls="ex1-tabs-2"
                                aria-selected="false"
                                >حالات الدفع</a
                            >
                        </li>

                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link"
                                id="ex1-tab-3"
                                data-bs-toggle="tab"
                                href="#ex1-tabs-3"
                                role="tab"
                                aria-controls="ex1-tabs-3"
                                aria-selected="false"
                                > المرفقات</a
                            >
                        </li>

                    </ul>
                    {{-- ================================================================ --}}
                    
                    <div class="tab-content" id="ex1-content">
                        
                        {{-- =============================== معلومات الفاتورة ================================= --}}
                        <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1" >

                            {{-- table --}}
                            <table class="table table-striped ">

                                  <tbody>
                                    <tr>
                                      <th class="fw-bold" scope="row">رقم الفاتورة</th>
                                      <td class="fw-bold">تاريخ الاصدار</td>
                                      <td class="fw-bold">تاريخ الاستحقاق</td>
                                      <td class="fw-bold">القسم</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">{{ $invoice->invoice_number }}</th>
                                      <td >{{ $invoice->invoice_date }}</td>
                                      <td>{{ $invoice->due_date }}</td>
                                      <td>{{ $invoice->section->section_name }}</td>
                                    </tr>
                                    <tr>
                                      <th class="fw-bold" scope="row">المنتج</th>
                                      <td class="fw-bold">مبلغ التحصيل</td>
                                      <td class="fw-bold">مبلغ العمولة</td>
                                      <td class="fw-bold">الخصم</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">{{ $invoice->product }}</th>
                                      <td>{{ $invoice->amount_collection }}</td>
                                      <td>{{ $invoice->amount_commission }}</td>
                                      <td>{{ $invoice->discount }}</td>
                                    </tr>
                                    <tr>
                                      <th class="fw-bold" scope="row">نسبة الضريبة</th>
                                      <td class="fw-bold">قيمة الضريبة</td>
                                      <td class="fw-bold">الاجمالي مع الضريبة</td>
                                      <td class="fw-bold"> الحالة</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ $invoice->rate_vat }}</th>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @if ($invoice->value_status == 1)
                                                <span class="text-white bg-success ps-1 pe-1 rounded-pill">مدفوعة</span>
                                            @elseif($invoice->value_status == 2)
                                                <span class="text-white bg-danger ps-1 pe-1 rounded-pill">غير مدفوعة</span>
                                            @else
                                                <span class="text-white bg-warning ps-1 pe-1 rounded-pill">مدفوعة جزئيا</span>
                                            @endif
                                        </td>
                                      </tr>
                                    <tr>
                                      <th class="fw-bold" scope="row">المستخدم</th>
                                      <td class="fw-bold" colspan="3">ملاحظات</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ $user->created_by }}</th>
                                        <td colspan="3">{{ $invoice->note }}</td>
                                    </tr>
                                  </tbody>
                            </table>

                        </div>

                        {{-- ================================ حالات الدفع ================================ --}}

                        <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                            
                            {{-- table --}}
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                      <th class="pt-3 pb-3 text-light" scope="col">#</th>
                                      <th class="pt-3 pb-3 text-light" scope="col">رقم الفاتورة</th>
                                      <th class="pt-3 pb-3 text-light" scope="col">تاريخ الاضافة</th>
                                      <th class="pt-3 pb-3 text-light" scope="col">المنتج</th>
                                      <th class="pt-3 pb-3 text-light" scope="col">القسم</th>
                                      <th class="pt-3 pb-3 text-light" scope="col"> حالة الدفع &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
                                      <th class="pt-3 pb-3 text-light" scope="col">تارخ الدفع</th>
                                      <th class="pt-3 pb-3 text-light" scope="col">المستخدم</th>
                                    </tr>
                                  </thead>

                                  <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($details as $item)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $i }}</th>
                                        <td>{{ $item->invoice_number }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->product }}</td>
                                        <td>{{ $invoice->section->section_name }}</td>
                                        <td>
                                            @if ($item->value_status === 1)
                                                <span class="text-white bg-success ps-1 pe-1 rounded-pill">مدفوعة</span>
                                            @elseif($item->value_status === 2)
                                                <span class="text-white bg-danger ps-1 pe-1 rounded-pill">غير مدفوعة</span>
                                            @else
                                                <span class="text-white bg-war ps-1 pe-1 rounded-pill">مدفوعة جزئيا</span>
                                            @endif
                                        </td>

                                        <td>{{ $item->payment_date }}</td>
                                        <td>{{ $item->created_by }}</td>
                                      </tr>
                                    @endforeach
                                    
                                  </tbody>

                            </table>
                        </div>

                        </div>

                        {{-- ================================ المرفقات ================================ --}}

                        <div class="tab-pane fade" id="ex1-tabs-3" role="tabpanel" aria-labelledby="ex1-tab-3">
                            
                            {{-- table --}}
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                      <th class="pt-3 pb-3 text-light" scope="col">#</th>
                                      <th class="pt-3 pb-3 text-light" scope="col">رقم الفاتورة</th>
                                      <th class="pt-3 pb-3 text-light" scope="col">تاريخ الاضافة</th>
                                      <th class="pt-3 pb-3 text-light" scope="col">قام بالاضافة</th>
                                      <th class="pt-3 pb-3 text-light" scope="col">العمليات</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($attachments as $item)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $i }}</th>
                                        <td>{{ $item->invoice_number }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->created_by }}</td>
                                        <td>
                                            <a class="btn btn-outline-success btn-sm"
                                                href="{{ route('show', ['invoice_number' => $invoice->invoice_number, 'file_name' => $item->file_name]) }}"
                                                role="button"><i class="fas fa-eye"></i>&nbsp;
                                                عرض</a>

                                            <a class="btn btn-outline-info btn-sm"
                                            href="{{ route('download', ['invoice_number' => $invoice->invoice_number, 'file_name' => $item->file_name]) }}"
                                                role="button"><i
                                                    class="fas fa-download"></i>&nbsp;
                                                تحميل</a>
                                            @can('حذف مرفق')
                                                
                                                <button class="btn btn-outline-danger btn-sm"
                                                    data-bs-toggle="modal" 
                                                    data-id="{{ $item->id }}"
                                                    data-file_name="{{ $item->file_name }}"
                                                    data-invoice_number="{{ $item->invoice_number }}"
                                                    data-bs-target="#exampleModal">حذف</button>
                                            @endcan
                                        </td>
                                      </tr>
                                    @endforeach
                                    
                                  </tbody>
                            </table>

                         @can('إضافة مرفق')
                                
                            {{-- send attachment --}}
                            <p class="text-danger mt-5 mt-5">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                            <form id="attachmentForm" action="{{ route('attachment.store') }}" method="POST" enctype="multipart/form-data">
                                
                                @csrf
                                <input type="hidden" name="id" value="{{ $invoice->id }}">
                                <input type="hidden" name="invoice_number" value="{{ $invoice->invoice_number }}">
                                <input type="hidden" name="created_by" value="{{ auth()->user()->name }}">

                                <label for="formFile" class="control-label fw-bold">المرفقات</label>
                                <input class="form-control @error('attachment') is-invalid @enderror" type="file" id="formFile" name="attachment" accept="image/*, .pdf"> 
                                @error('attachment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                                <input type="submit" class="btn btn-primary mt-3 btn-submit">
                            </form>
                        @endcan
                        </div>

                    </div>

                    {{-- modal --}}
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">حذف المرفق</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form action="{{ route('delete_file') }}" method="POST">
                                
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">

                                    <h3>هل انت متاكد من عملية الحذف ؟</h3><br>
                                    <input type="hidden" name="id" id="id" value="">
                                    <input type="hidden" name="file_name" id="file_name" value="">
                                    <input type="hidden" name="invoice_number" id="invoice_number" value="">

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
    var exampleModal = document.getElementById('exampleModal');
    
    exampleModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget;
        
        // Extract info from data-* attributes
        var id = button.getAttribute('data-id');
        var file_name = button.getAttribute('data-file_name');
        var invoice_number = button.getAttribute('data-invoice_number');

        // Update the modal's content.
        var modalIdInput = exampleModal.querySelector('.modal-body #id');
        var namedInput = exampleModal.querySelector('.modal-body #file_name');
        var numberIdInput = exampleModal.querySelector('.modal-body #invoice_number');

        modalIdInput.value = id;
        namedInput.value = file_name;
        numberIdInput.value = invoice_number;
    });
});
</script>

{{-- loader --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('attachmentForm').addEventListener('submit', function(e) {
            // Prevent the form from submitting immediately
            e.preventDefault();
    
            const submitButton = this.querySelector('.btn-submit');
            // Disable the button to prevent multiple submissions
            submitButton.disabled = true;
            // Add spinner to button
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
    
            // Here you might want to actually submit the form, e.g., using FormData and fetch()
            // For demonstration, we'll simulate an async operation with setTimeout
            setTimeout(() => {
                this.submit(); // Remove this line if you're manually handling the form submission via JavaScript
            }, 2000); // Simulating a 2-second async operation
        });
    });
    </script>

@endsection