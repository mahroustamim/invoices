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
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
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
	<div>

            @can('إضافة منتج')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    إضافة منتج
                </button>
            @endcan

	</div>

    
	
	{{-- =============================== create section modale ================================= --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">إضافة قسم</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                    <div class="mb-3">
                        <label for="Product_name" class="form-label">إسم المنتج</label>
                        <input type="text" name="product_name" class="form-control" id="Product_name">
                    </div>

                    <div class="mb-3">
                        <label class="my-1 mr-2" for="section_id">القسم</label>
                        <select name="section_id" id="section_id" class="form-control">
                            <option value="" selected disabled>--حدد القسم--</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">الوصف</label>
                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">حفظ</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
        </div>
    </div>
{{-- ================================================================ --}}
{{--========================== table =================================--}}

                <table class="table table-hover mt-3">
                        <thead class="table-dark">
                          <tr>
                            <th class="pt-3 pb-3 text-light" scope="col">#</th>
                            <th class="pt-3 pb-3 text-light" scope="col">إسم المنتج</th>
                            <th class="pt-3 pb-3 text-light" scope="col">إسم القسم</th>
                            <th class="pt-3 pb-3 text-light" scope="col">الوصف</th>
                            <th class="pt-3 pb-3 text-light" scope="col">العمليات</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0 ?>
                            @foreach ($products as $product)
                                <?php $i++ ?>

                                <tr>
                                <th class="centered-content" scope="row">{{ $i }}</th>
                                <td class="centered-content">{{ $product->product_name }}</td>
                                <td class="centered-content">{{ $product->section->section_name }}</td>
                                <td class="centered-content">{{ $product->description }}</td>
                                <td class="centered-content">
                                    <div  style="display: flex; justify-content-center; gap:20px;">

                                    @can('تعديل منتج')
                                        
                                        <a 
                                            class="btn btn-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#exampleModal2"
                                            data-id="{{ $product->id }}"
                                            data-product_name= "{{ $product->product_name }}"
                                            data-section_id="{{ $product->section_id }}"
                                            data-description="{{ $product->description }}"
                                            >تعديل</a>
                                    @endcan
                                    @can('حذف منتج')
                                        <a 
                                            class="btn btn-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#exampleModal3"
                                            data-id="{{ $product->id }}"
                                            data-product_name="{{ $product->product_name }}"
                                            >حذف</a>
                                    @endcan
                                    </div>
                                </td>
                                </td>
                                </tr>

                            @endforeach
                         
                      </table>
                    </table>
                    {{-- Pagination --}}
                                    <div class="d-flex justify-content-center">
                                       {!! $products->links() !!}
                                      </div>
        {{-- ================================================================ --}}
		{{--============================== edit section modale ============================= --}}

        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabe">تعديل القسم</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <div class="modal-body">
                <form action="products/update" method="POST">

                    @csrf
                    @method('PUT')

                        <input type="hidden" name="id" id="id" value="">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">إسم المنتج</label>
                            <input type="text" name="product_name" class="form-control" id="product_name">
                        </div>
    
                        <div class="mb-3">
                            <label class="my-1 mr-2" for="section_id">القسم</label>
                            <select name="section_id" id="section_id" class="form-control">
                                <option value="" selected disabled>--حدد القسم--</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                        </div>
                    </div>
    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">حفظ</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
            </div>
        </div>

        {{-- ================================================================ --}}
		{{--============================== delete section modale ============================= --}}

        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabe">تعديل القسم</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <div class="modal-body">
                <form action="products/destroy" method="POST">

                    @csrf
                    @method('DELETE')

                    <p>هل انت متاكد من عملية الحذف ؟</p><br>
                    <input type="hidden" name="id" id="id" value="">
                    <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                    
                </div> <!-- end modal body -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">تأكيد</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
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
<script src="{{URL::asset('assets/me/bootstrap.min.js')}}"></script>

{{-- edit --}}
<script>
	document.addEventListener('DOMContentLoaded', function () {
		var exampleModal = document.getElementById('exampleModal2');
		
		exampleModal.addEventListener('show.bs.modal', function (event) {
			// Button that triggered the modal
			var button = event.relatedTarget;
			
			// Extract info from data-* attributes
			var id = button.getAttribute('data-id');
			var product_name = button.getAttribute('data-product_name');
			var section_id = button.getAttribute('data-section_id');
			var description = button.getAttribute('data-description');
	
			// Update the modal's content.
			var modalIdInput = exampleModal.querySelector('.modal-body #id');
			var modalProductNameInput = exampleModal.querySelector('.modal-body #product_name');
			var modalSectionIdInput = exampleModal.querySelector('.modal-body #section_id');
			var modalDescriptionTextarea = exampleModal.querySelector('.modal-body #description');
	
			modalIdInput.value = id;
			modalProductNameInput.value = product_name;
			modalSectionIdInput.value = section_id;
			modalDescriptionTextarea.value = description;
		});
	});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    var exampleModal = document.getElementById('exampleModal3');
    
    exampleModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget;
        
        // Extract info from data-* attributes
        var id = button.getAttribute('data-id');
        var product_name = button.getAttribute('data-product_name');

        // Update the modal's content.
        var modalIdInput = exampleModal.querySelector('.modal-body #id');
        var modalProductNameInput = exampleModal.querySelector('.modal-body #product_name');

        modalIdInput.value = id;
        modalProductNameInput.value = product_name;
    });
});
</script>


@endsection