@extends('backend.layout')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Edit Service</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('services.index') }}">Service</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Edit</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Service</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label for="category_id">Category</label>
                                            <select id="category_id" name="category_id"
                                                class="form-control @error('category_id') is-invalid @enderror" required>
                                                <option value="">Select Category</option>
                                                @foreach ($categoryservice as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $service->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->category }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label for="title">Title</label>
                                            <input id="title" type="text"
                                                class="form-control @error('title') is-invalid @enderror" name="title"
                                                value="{{ old('title', $service->title) }}" required>
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label for="overview">Overview</label>
                                            <input id="overview" type="text"
                                                class="form-control @error('overview') is-invalid @enderror" name="overview"
                                                value="{{ old('overview', $service->overview) }}" required>
                                            @error('overview')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-group-default">
                                            <label for="description">Description</label>
                                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"
                                                rows="4">{{ old('description', $service->description) }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-group-default">
                                            <label for="paths">Paths</label>
                                            <div id="paths-container" class="d-flex align-items-center flex-wrap">
                                                @foreach ($service->paths as $path)
                                                    <div class="input-group mb-3">
                                                        <input type="file" name="paths[]" class="form-control">
                                                        <span class="text-muted ms-2">Current: {{ basename($path) }}</span>
                                                        <button type="button" class="btn btn-danger remove-path ms-2">-</button>
                                                    </div>
                                                @endforeach
                                                <div class="input-group mb-3">
                                                    <input type="file" name="paths[]" class="form-control">
                                                    <button type="button" class="btn btn-success add-path ms-2">+</button>
                                                </div>
                                            </div>
                                            @error('paths')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('services.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pathsContainer = document.getElementById('paths-container');

            // Menambah field path baru
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-path')) {
                    e.preventDefault();

                    const newInputGroup = document.createElement('div');
                    newInputGroup.className = 'input-group mb-3';

                    newInputGroup.innerHTML = `
                        <input type="file" name="paths[]" class="form-control">
                        <button type="button" class="btn btn-danger remove-path">-</button>
                    `;

                    pathsContainer.appendChild(newInputGroup);
                }

                // Menghapus field path
                if (e.target.classList.contains('remove-path')) {
                    e.target.closest('.input-group').remove();
                }
            });
        });
    </script>
@endsection
