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
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة فاتورة</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection


@section('content')
    <!-- row -->
    <div class="rounded mb-4" style="background-color: white !important; padding: 20px;">

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


        <form action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Invoice Number -->
                <div class="col-12 col-sm-6 col-lg-4 mb-3">
                    <label class="control-label" for="invoice_number">رقم الفاتورة</label>
                    <input class="form-control @error('invoice_number') is-invalid @enderror" type="text" name="invoice_number"  id="invoice_number" value="{{ old('invoice_number') }}">
                    @error('invoice_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Invoice Date -->
                <div class="col-12 col-sm-6 col-lg-4 mb-3">
                    <label class="control-label" for="invoice_Date">تاريخ الفاتورة</label>
                    <input class="form-control @error('invoice_date') is-invalid @enderror" type="date" name="invoice_date"  id="invoice_Date"  value="{{ date('Y-m-d') }}" >
                    @error('invoice_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-12 col-sm-6 col-lg-4 mb-3">
                    <label class="control-label" for="due_date">تاريخ الاستحقاق</label>
                    <input class="form-control @error('due_date') is-invalid @enderror" type="date" name="due_date" @error('due_date') is-invalid @enderror id="due_date" placeholder="YYYY-MM-DD" value="{{ old('due_date') }}">
                    @error('due_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-12 col-sm-6 col-lg-4 mb-3">
                    <label class="control-label" for="section"> القسم</label>
                    <select name="section" class="form-select @error('section') is-invalid @enderror" aria-label="Default select example" id="section" >
                        <option value="" selected  disabled>--حدد القسم--</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                        @endforeach
                    </select>
                    @error('section')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-12 col-sm-6 col-lg-4 mb-3">
                    <label class="control-label" for="product"> المنتج</label>
                    <select name="product" class="form-select @error('product') is-invalid @enderror" aria-label="Default select example" id="product">
                        <option value="" selected  disabled>--حدد المنتج--</option>
                    </select>
                    @error('product')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-12 col-sm-6 col-lg-4 mb-3">
                    <label for="amount_collection" class="control-label">مبلغ التحصيل</label>
                    <input type="number" class="form-control @error('amount_collection') is-invalid @enderror" id="amount_collection" name="amount_collection" value="{{ old('amount_collection') }}">
                    @error('amount_collection')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="col-12 col-sm-6 col-lg-4 mb-3">
                    <label class="control-label" for="amount_commission"> مبلغ العمولة</label>
                    <input class="form-control @error('amount_commission') is-invalid @enderror" type="number" name="amount_commission" id="amount_commission" value="{{ old('amount_commission') }}">
                    @error('amount_commission')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-12 col-sm-6 col-lg-4 mb-3">
                    <label for="discount" class="control-label">الخصم</label>
                    <input type="number" class="form-control" id="discount" name="discount"  value=0>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 mb-3">
                    <label class="control-label" for="rate_vat"> نسبة ضريبة القيمة المضافة</label>
                    <select name="rate_vat" class="form-select " aria-label="Default select example" id="rate_vat" onchange="myFunction()" >
                        <option value="" selected  disabled>--حدد نسبة الضريبة--</option>
                        <option value=" 5%">5%</option>
                        <option value="10%">10%</option>
                    </select>
                </div>
                
            </div>

             {{-- row --}}
             <div class="row">
                <div class="col-12 col-sm-6 mb-3">
                        <label for="value_vat" class="control-label">قيمة ضريبة القيمة المضافة</label>
                        <input type="text" class="form-control" id="value_vat" name="value_vat" readonly>
                </div>

                <div class="col-12 col-sm-6 mb-3">
                        <label for="total" class="control-label">الاجمالي شامل الضريبة</label>
                        <input type="text" class="form-control" id="total" name="total" readonly>
                </div>
            </div>

            <!-- Notes -->
            <div class="col-12 mb-4">
                <label for="exampleTextarea">ملاحظات</label>
                <textarea class="form-control" id="exampleTextarea" name="note" rows="3"></textarea>
            </div>

            <!-- Attachments -->
            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
            <div class="col-12 mb-4">
                <label for="formFile" class="control-label fw-bold">المرفقات</label>
                <input class="form-control @error('attachment') is-invalid @enderror" type="file" id="formFile" name="attachment" accept="image/*, .pdf"> 
                @error('attachment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-right">
                <button type="submit" class="btn btn-primary ps-5 pe-5">حفظ البيانات</button>
            </div>
        </form>
    </div>
@endsection


@section('js')
<script src="{{URL::asset('assets/me/bootstrap.min.js')}}"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('section').addEventListener('change', function() {

            let baseUrl = '';
            if(window.location.host.includes('localhost')) {
                baseUrl = 'http://localhost/projects/invoices/public';
            }

            var sectionId = this.value;

            fetch(`${baseUrl}/section/${sectionId}`)
                .then(response => response.json())
                .then(data => {
                    const productSelect = document.getElementById('product');
                    productSelect.innerHTML = ''; // Reset and add placeholder
                    Object.entries(data).forEach(([id, name]) => {
                        const option = new Option(name, name);
                        productSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
    </script>

<script>
    function myFunction() {

        var Amount_Commission = parseFloat(document.getElementById("amount_commission").value);
        var Discount = parseFloat(document.getElementById("discount").value);
        var Rate_VAT = parseFloat(document.getElementById("rate_vat").value);
        var Value_VAT = parseFloat(document.getElementById("value_vat").value);

        var Amount_Commission2 = Amount_Commission - Discount;


        if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {

            alert('يرجي ادخال مبلغ العمولة ');

        } else {
            var intResults = Amount_Commission2 * Rate_VAT / 100;

            var intResults2 = parseFloat(intResults + Amount_Commission2);

            sumq = parseFloat(intResults).toFixed(2);

            sumt = parseFloat(intResults2).toFixed(2);

            document.getElementById("value_vat").value = sumq;

            document.getElementById("total").value = sumt;

        }

    }

</script>
        
    
@endsection