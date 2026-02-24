@extends('admin.layouts.app')

@section('title', 'Create Exam Type')

@section('content')

    @include('partials.page-header', [
        'title' => 'Create Exam Type',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Exam Types', 'url' => route('admin.exam-types.index')],
            ['label' => 'Create']
        ]
    ])

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST"
                  action="{{ route('admin.exam-types.store') }}"
                  enctype="multipart/form-data">
                @include('admin.exam-types._form')
            </form>
        </div>
    </div>

@endsection
