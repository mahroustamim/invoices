@extends('layouts.master')

@section('css')
<link href="{{URL::asset('assets/me/style.css')}}" rel="stylesheet"/>
{{-- notify --}}
<link href="{{URL::asset('assets/me/notify/css/notifIt.css')}}" rel="stylesheet" />
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex align-items-center">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ صلاحيات المستخدمين</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="container mt-5">


                @if (session('updated'))
					<script>
						window.onload = function() {
							notif({
								msg: "تم التعديل بنجاح",
								type: "success"
								// type: "error"
							})
						}
					</script>
				@endif

                @if (session('deleted'))
                <script>
                    window.onload = function() {
                        notif({
                            msg: "تم الحذف بنجاح",
                            type: "success"
                            // type: "error"
                        })
                    }
                </script>
            @endif

            @if (session('created'))
                <script>
                    window.onload = function() {
                        notif({
                            msg: "تم الاضافة  بنجاح",
                            type: "success"
                            // type: "error"
                        })
                    }
                </script>
            @endif

    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @can('إضافة صلاحية')
                    <a class="btn btn-success" href="{{ route('roles.create') }}">إضافة صلاحية</a>
                    @endcan
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>الاسم</th>
                        <th width="280px">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                                <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}">عرض</a>
                                @can('تعديل صلاحية')
                                <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}">تعديل</a>
                                @endcan
                                @can('حذف صلاحية')
                                <button type="submit" class="btn btn-danger btn-sm" data-id="{{ $role->id }}"  data-bs-toggle="modal" href="#exampleModal">حذف</button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {!! $roles->render() !!}
    </div>


    {{-- modal --}}
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">حذف الفاتورة</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="roles/destroy" method="POST">
            
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


</div>
<!-- row closed -->

</div>
</div>
@endsection

@section('js')
<script src="{{URL::asset('assets/me/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/me/bootstrap.bundle.min.js')}}"></script>
{{-- notify --}}
<script src="{{ URL::asset('assets/me/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/me/notify/js/notifit-custom.js') }}"></script>


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



