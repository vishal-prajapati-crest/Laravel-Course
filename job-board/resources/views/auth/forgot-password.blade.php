<x-layout>
    <x-card class="py-8 px-16 max-w-lg mx-auto">
        <h1 class="my-16 mt-2 text-center text-3xl font-medium text-slate-600">
            Forgot password
        </h1>
        <form action="{{ route('password.email') }}" method="post">
            @csrf
            <div class="mb-8">
                <label for="email" class="mb-2 block text-sm font-medium text-slate-900">Enter Your registered
                    E-mail<span class="text-red-500">*</span></label>
                <x-text-input name='email' type='email' value='{{ old("email") }}'
                    placeholder="name@example.com">
                </x-text-input>
                @error('email')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <x-button class="w-full bg-indigo-500 hover:bg-indigo-300">Get Reset Link</x-button>

        </form>
    </x-card>
</x-layout>
