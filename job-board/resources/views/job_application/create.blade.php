<x-layout>
    <x-breadcrumbs class="mb-4"
        :links="['Jobs' => route('jobs.index'), $job->title => route('jobs.show', $job), 'Apply' => '#']" />

    <x-job-card :$job />

    <x-card>
        <h2 class="text-lg text-center font-medium mb-4">Your Job Application</h2>
        <form id="jobApplictaionForm" action="{{ route('job.application.store', $job) }}"
            method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-8">
                <label for="expected_salary" class="mb-2 block text-sm font-medium text-slate-900">Expected
                    Salary <span class="text-red-500">*</span></label>
                <x-text-input name='expected_salary' type='number' formId='jobApplictaionForm' submitAfterClear=0
                    value='{{ old("expected_salary") }}' placeholder="xxxxxx">
                </x-text-input>
                @error('expected_salary')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-8">
                <label for="cv" class="mb-2 block text-sm font-medium text-slate-900">
                    <div>
                        Upload CV <span class="text-red-500">*</span>
                    </div>
                    <div class="flex items-center gap-4 overflow-hidden">
                        <div @class([ 'mt-2 px-8 py-2 inline-flex items-center text-base rounded-md w-auto border border-slate-300 hover:cursor-pointer'
                            , 'border-red-300'=> $errors->has('cv')
                            ])
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                            </svg>
                            &nbsp;| Upload CV
                        </div>
                        <span id="fileName" class=""></span>
                        <input class="hidden" type="file" name="cv" id="cv" accept=".pdf"
                            onchange="displayFileName(this)" size="2048" />
                    </div>
                </label>
                <div class="text-xs ml-2">* File must be pdf only and size is less than 2 MB or 2048 KB</div>
                @error('cv')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <x-button class="w-full bg-indigo-500 hover:bg-indigo-300">Apply</x-button>

        </form>
    </x-card>
</x-layout>

<script>
    function displayFileName(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileSize = (file.size / 1024).toFixed(2); // in KB
            document.getElementById('fileName').innerText = `${file.name} (${fileSize} KB)`;
        } else {
            document.getElementById('fileName').innerText = '';
        }
    }

</script>
