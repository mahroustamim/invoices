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
							<h4 class="content-title mb-0 my-auto">الاعدادت</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الاقسام</span>
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
									{{-- <ul> --}}
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									{{-- </ul> --}}
								</div>
							@endif
								{{-- success message --}}
							@if (session('success'))
								<div class="alert alert-success">
									{{-- <ul> --}}
											{{ session('success') }}
									{{-- </ul> --}}
								</div>
							@endif

	{{-- ================================================================ --}}
	
	<div >
		
			@can('إضافة قسم')
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
					إضافة قسم
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
										<form action="{{ route('sections.store') }}" method="POST">
											@csrf
												<div class="mb-3">
													<label for="exampleFormControlInput1" class="form-label">إسم القسم</label>
													<input type="text" name="section_name" class="form-control" id="exampleFormControlInput1">
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
								<thead  class="table-dark">
									<tr>
									  <th class="pt-3 pb-3 text-light" scope="col">#</th>
									  <th class="pt-3 pb-3 text-light" scope="col">إسم القسم</th>
									  <th class="pt-3 pb-3 text-light" scope="col">الوصف</th>
									  <th class="pt-3 pb-3 text-light" scope="col">العمليات</th>
									</tr>
								  </thead>
								  <tbody>
									<?php $i = 0; ?>

									
										@foreach ($sections as $section)
										<?php $i++; ?>
										<tr class="centered-content">
											<th class="centered-content" scope="row">{{ $i }}</th>
											<td class="centered-content" >{{ $section->section_name }}</td>
											<td class="centered-content" >{{ $section->description }}</td>
											<td class="centered-content">
												<div  style="display: flex; justify-content-center; gap:20px;">

												@can('تعديل قسم')
													<a 
														class="btn btn-success" 
														data-bs-toggle="modal" 
														data-bs-target="#exampleModal2"
														data-id="{{ $section->id }}"
														data-section_name="{{ $section->section_name }}"
														data-description="{{ $section->description }}"
														>تعديل</a>
												@endcan
												@can('حذف قسم')
													<a 
														class="btn btn-danger" 
														data-bs-toggle="modal" 
														data-bs-target="#exampleModal3"
														data-id="{{ $section->id }}"
														data-section_name="{{ $section->section_name }}"
														>حذف</a>
												@endcan
												</div>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
								 {{-- Pagination --}}
								 <div class="d-flex justify-content-center">
									{!! $sections->links() !!}
			  					</div>

										
									
		{{-- ================================================================ --}}
		{{--============================== edit section modale ============================= --}}

								<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h1 class="modal-title fs-5" id="exampleModalLabel">تعديل القسم</h1>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>

										
										{{-- route(sections.update)   id متنفعش علشان --}}
										<form action="sections/update" method="POST">
											
											@csrf
											@method('PUT')
											
											<div class="modal-body">
												<input type="hidden" name="id" id="id" value="">
												<div class="mb-3">
													<label for="section_name" class="form-label">إسم القسم</label>
													<input type="text" name="section_name"  class="form-control" id="section_name">
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
						{{-- ================================ delete section modale ================================ --}}

<div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h1 class="modal-title fs-5" id="exampleModalLabel">حذف القسم</h1>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<form action="sections/destroy" method="POST">
			
			@csrf
			@method('DELETE')
			<div class="modal-body">

				<p>هل انت متاكد من عملية الحذف ؟</p><br>
				<input type="hidden" name="id" id="id" value="">
				<input class="form-control" name="section_name" id="section_name" type="text" readonly>

			</div>

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
			var section_name = button.getAttribute('data-section_name');
			var description = button.getAttribute('data-description');
	
			// Update the modal's content.
			var modalIdInput = exampleModal.querySelector('.modal-body #id');
			var modalSectionNameInput = exampleModal.querySelector('.modal-body #section_name');
			var modalDescriptionTextarea = exampleModal.querySelector('.modal-body #description');
	
			modalIdInput.value = id;
			modalSectionNameInput.value = section_name;
			modalDescriptionTextarea.value = description;
		});
	});
</script>
{{-- delete --}}
<script>
		document.addEventListener('DOMContentLoaded', function () {
		var exampleModal = document.getElementById('exampleModal3');
		
		exampleModal.addEventListener('show.bs.modal', function (event) {
			// Button that triggered the modal
			var button = event.relatedTarget;
			
			// Extract info from data-* attributes
			var id = button.getAttribute('data-id');
			var section_name = button.getAttribute('data-section_name');
	
			// Update the modal's content.
			var modalIdInput = exampleModal.querySelector('.modal-body #id');
			var modalSectionNameInput = exampleModal.querySelector('.modal-body #section_name');
	
			modalIdInput.value = id;
			modalSectionNameInput.value = section_name;
		});
	});
</script>

@endsection


