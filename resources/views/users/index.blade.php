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
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ قائمة المستخدمين</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')


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
                            msg: "تم حذف المستخدم بنجاح",
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


    @can('إضافة مستخدم')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('users.create') }}">إضافة مستخدم </a>
            </div>
        </div>
    </div>
    @endcan

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>الاسم</th>
                    <th>البريدالاكتروني</th>
                    <th>الاذونات</th>
                    <th width="280px">العمليات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if(!empty($user->getRoleNames()))
                          @foreach($user->getRoleNames() as $v)
                          <span class="badge badge-secondary">{{ $v }}</span>
                          @endforeach
                        @endif
                    </td>
                    <td>
                        @can('تعديل مستخدم')
                            <a class="btn btn-primary btn-sm" href="{{ route('users.edit', $user->id) }}">تعديل</a>
                        @endcan
                        @can('حذف مستخدم')
                            <button type="submit" class="btn btn-danger btn-sm" data-id="{{ $user->id }}"  data-bs-toggle="modal" href="#exampleModal">حذف</button>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $data->render() !!}
    </div>
</div>

 {{-- modal --}}
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">حذف الفاتورة</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="users/destroy" method="POST">
            
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
