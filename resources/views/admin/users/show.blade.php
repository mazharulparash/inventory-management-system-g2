<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show User') }}
        </h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Users') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Show User') }}</li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <!-- User Details -->
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="form-group mt-4">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="form-group mt-4">
                        <label for="role_id">{{ __('User Type') }}</label>
                        <input type="text" name="role_id" class="form-control" value="{{ $user->role->name }}" readonly>
                    </div>
                    <div class="form-group mt-4">
                        <label for="created_at">{{ __('Created At') }}</label>
                        <input type="text" name="created_at" class="form-control" value="{{ $user->created_at->format('Y-m-d H:i:s') }}" readonly>
                    </div>
                    <div class="form-group mt-4">
                        <label for="updated_at">{{ __('Updated At') }}</label>
                        <input type="text" name="updated_at" class="form-control" value="{{ $user->updated_at->format('Y-m-d H:i:s') }}" readonly>
                    </div>
                    <a href="{{ route('users.index') }}" class="btn btn-primary mt-4">{{ __('Back to List') }}</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
