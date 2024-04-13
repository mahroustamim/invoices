@extends('layouts.master')

@section('css')
<!-- Include Select2 CSS (Optional for enhanced multi-select dropdown) -->
<link href="https://cdn.jsdelivr.net/npm/select2/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Additional custom styles */
    .breadcrumb-header {
        margin-bottom: 30px;
    }

    .form-control {
        border-radius: 0.375rem;
    }

    .btn-primary {
        background-color: #4a76a8;
        border: none;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #842029;
    }

    .form-group strong {
        display: block;
        margin-bottom: 5px;
    }

    /* Enhance Select2 dropdown */
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }
</style>
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة مستخدم</span>
        </div>
    </div>
</div>
<!-- /breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="row justify-content-center">
    
    @if (count($errors) > 0)
    <div class="col-lg-8">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="col-lg-8">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <strong>الاسم:</strong>
                <input type="text" name="name" class="form-control" >
            </div>
            <div class="form-group">
                <strong>البريد الاكتروني:</strong>
                <input type="email" name="email" class="form-control" >
            </div>
            <div class="form-group">
                <strong>كلمة السر:</strong>
                <input type="password" name="password" class="form-control" >
            </div>
            <div class="form-group">
                <strong>تأكيد كلمة السر:</strong>
                <input type="password" name="confirm-password" class="form-control">
            </div>
            <div class="form-group">
                <strong>الأدوار:</strong>
                <select class="form-control multiple select2-multiple" multiple="multiple" name="roles[]">
                    @foreach ($roles as $role)
                    <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">إرسال</button>
            </div>
        </form>
    </div>
</div>
<!-- /row -->
</div>
</div>
@endsection

@section('js')
<!-- Include Select2 JS (Optional for enhanced multi-select dropdown) -->
<script src="https://cdn.jsdelivr.net/npm/select2/dist/js/select2.full.min.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    // Use vanilla JS to find elements, but still use jQuery inside due to Select2's dependency
    document.querySelectorAll('.select2-multiple').forEach(function(el) {
        // Convert the DOM element back to a jQuery object to use Select2
        $(el).select2({
            placeholder: "Select Roles",
            allowClear: true
        });
    });
});
</script>
@endsection
