<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">{{ __('Users') }}</li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Button to Create a New User -->
            <div class="mb-4">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    {{ __('Create User') }}
                </a>
            </div>

            <!-- Success Message using Toastr.js -->
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        toastr.success('{{ session('success') }}');
                    });
                </script>
            @endif

            <!-- Users Table -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6 card-body">
                    <table id="usersTable" class="table table-bordered table-striped w-full">
                        <thead>
                            <tr>
                                <th>{{ __('Serial No') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td> <!-- Serial Number -->
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">{{ __('Show') }}</a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                                        <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $user->id }})">{{ __('Delete') }}</button>
                                        <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">{{ __('No users found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $users->links() }} <!-- Laravel pagination links -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(userId) {
            if (confirm('{{ __("Are you sure you want to delete this user?") }}')) {
                document.getElementById('delete-form-' + userId).submit();
            }
        }
    </script>
</x-app-layout>
