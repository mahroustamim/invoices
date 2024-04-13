@extends('layouts.master')

@section('css')
<link href="{{ asset('path/to/your/css/custom.css') }}" rel="stylesheet">
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex align-items-center">
            <h4 class="content-title mb-0 my-auto">الصلاحيات</h4>
            <span class="text-muted mt-1 tx-13 ml-2 mb-0">/ تعديل الصلاحية</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
<div class="container mt-5">
    

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <strong>الاسم:</strong>
            <input type="text" value="{{ $role->name }}" name="name" class="form-control" placeholder="الاسم">
        </div>

        <div class="form-group">
            <strong>الصلاحيات:</strong>
            <div class="d-flex flex-wrap">
                @foreach ($permission as $value)
                <div class="custom-control custom-checkbox mx-2">
                    <input type="checkbox" class="custom-control-input" id="permission{{ $value->id }}" name="permission[]" value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="permission{{ $value->id }}">{{ $value->name }}</label>
                </div>
                @endforeach
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary mt-4">إرسال</button>
        </div>
    </form>
</div>



</div>
</div>
@endsection

@section('js')
<script src="{{ asset('path/to/your/js/custom.js') }}"></script>
@endsection
