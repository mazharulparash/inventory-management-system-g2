<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Delete User') }}
        </h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Users') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Delete') }}</li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">{{ __('Are you sure you want to delete this user?') }}</h3>

                    <!-- User Details -->
                    <div class="mb-4">
                        <p><strong>{{ __('Name:') }}</strong> {{ $user->name }}</p>
                        <p><strong>{{ __('Email:') }}</strong> {{ $user->email }}</p>
                        <p><strong>{{ __('Role:') }}</strong> {{ $user->role->name }}</p>
                    </div>

                    <!-- Delete Confirmation Form -->
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="mt-4">
                            <button type="submit" class="btn btn-danger">
                                {{ __('Delete') }}
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
