<x-layout>
    <x-card>
        <h1 class="my-16 mt-2 text-center text-3xl font-medium text-slate-600">
            Employer Registration
        </h1>
        <form id="employerRegistrationForm" class="px-20" action="{{ route('employer.store') }}"
            method="post">
            @csrf
            <div class="mb-8">
                <label for="company_name" class="mb-2 block text-sm font-medium text-slate-900">Company Name<span
                        class="text-red-500">*</span></label>
                <x-text-input name='company_name' type='text' value='{{ old("company_name") }}'
                    placeholder="Jhon & Sons" submitAfterClear=0>
                </x-text-input>
                @error('company_name')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <x-button class="w-full">Create</x-button>
        </form>
    </x-card>
</x-layout>
