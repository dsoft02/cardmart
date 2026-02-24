@extends('admin.layouts.app')

@section('title', 'Edit Exam Type')

@section('content')

    @include('partials.page-header', [
        'title' => 'Edit Exam Type',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Exam Types', 'url' => route('admin.exam-types.index')],
            ['label' => 'Edit']
        ]
    ])

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST"
                  action="{{ route('admin.exam-types.update', $examType) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @include('admin.exam-types._form')
            </form>
        </div>
    </div>

@endsection
