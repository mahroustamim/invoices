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
            <span class="text-muted mt-1 tx-13 ml-2 mb-0">/ إضافة صلاحية جديدة</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
<div class="container mt-5">

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <strong>الاسم:</strong>
            <input type="text" name="name" class="form-control" placeholder="الاسم">
        </div>

        <div class="form-group">
            <strong>الصلاحيات:</strong>
            <div class="d-flex flex-wrap">
                @foreach ($permission as $value)
                <div class="custom-control custom-checkbox mx-2">
                    <input type="checkbox" class="custom-control-input" id="permission{{ $value->id }}" name="permission[]" value="{{ $value->id }}">
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
{{-- <script src="{{ asset('path/to/your/js/custom.js') }}"></script> --}}
@endsection
