<x-layout>


    <x-card class="py-8 px-16 max-w-lg mx-auto">
        <h1 class="my-16 mt-2 text-center text-3xl font-medium text-slate-600">
            Sign-in to Your Account
        </h1>
        <form action="{{ route('auth.store') }}" method="post">
            @csrf
            <div class="mb-8">
                <label for="email" class="mb-2 block text-sm font-medium text-slate-900">E-mail<span
                        class="text-red-500">*</span></label>
                <x-text-input name='email' type='email' value='{{ old("email") }}'
                    placeholder="name@example.com">
                </x-text-input>
                @error('email')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-8">
                <label for="password" class="mb-2 block text-sm font-medium text-slate-900">Password<span
                        class="text-red-500">*</span></label>
                <x-text-input name='password' type='password'></x-text-input>
                @error('password')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror
                @error('error')
                    <div class="mt-4 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-8 flex justify-between text-sm font-medium">
                <div>
                    <div class="flex items-center gap-2">
                        <input class="rounded border border-slate-500" type="checkbox" name="remember" id="remember" />
                        <label for="remember">remember me</label>
                    </div>
                </div>
                <div>
                    <a href="{{ route('password.request') }}"
                        class="text-indigo-600 hover:underline">Forget password?</a>
                </div>
            </div>

            <x-button class="w-full bg-indigo-500 hover:bg-indigo-300">Sign-in</x-button>
        </form>

    </x-card>
</x-layout>
