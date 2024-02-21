<x-layout>
    <x-card class="py-8 px-16 max-w-lg mx-auto">
        <h1 class="my-16 mt-2 text-center text-3xl font-medium text-slate-600">
            Reset Password
        </h1>
        <form action="{{ route('password.update') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ request('email') }}">
            <div class="mb-8">
                <label for="email" class="mb-2 block text-sm font-medium text-slate-900">E-Mail:
                    {{ request('email') }}</label>

                @error('email')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-8">
                <label for="password" class="mb-2 block text-sm font-medium text-slate-900">Enter Your New Password<span
                        class="text-red-500">*</span></label>
                <x-text-input name='password' type='password' value='{{ old("password") }}'
                    placeholder="new password">
                </x-text-input>
                @error('password')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <x-button class="w-full bg-indigo-500 hover:bg-indigo-300">Reset</x-button>

        </form>
    </x-card>
</x-layout>
