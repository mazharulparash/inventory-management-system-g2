<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Users') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Create') }}</li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <!-- Form to Create a New User -->
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        
                        <!-- Name Field -->
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="form-group mt-4">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Field with Show/Hide Toggle -->
                        <div class="form-group mt-4">
                            <label for="password">{{ __('Password') }}</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" class="form-control" required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePasswordVisibility('password')">
                                    <svg id="password-toggle-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <!-- Eye icon -->
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password Field with Show/Hide Toggle -->
                        <div class="form-group mt-4">
                            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePasswordVisibility('password_confirmation')">
                                    <svg id="password-confirmation-toggle-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <!-- Eye icon -->
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- User Type Field (Role) -->
                        <div class="form-group mt-4">
                            <label for="role_id">{{ __('User Type') }}</label>
                            <select id="role_id" name="role_id" class="form-control" required>
                                <option value="" disabled selected>{{ __('Select Role') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.querySelector(`#${inputId}-toggle-icon`);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('stroke', '#1D4ED8'); // Change icon color to indicate visibility
            } else {
                input.type = 'password';
                icon.setAttribute('stroke', '#6B7280'); // Revert icon color to indicate hidden
            }
        }
    </script>
</x-app-layout>
