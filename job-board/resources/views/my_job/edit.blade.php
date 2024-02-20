<x-layout>
    <x-breadcrumbs class="mb-4"
        :links="['My Jobs' => route('my-jobs.index'), $job->title => route('jobs.show', $job), 'Update' => '#']" />

    <x-card>
        <!-- {{ $job }} -->
        <h1 class="mb-6 mt-2 text-center text-2xl font-medium text-slate-600">
            Update
        </h1>
        <form action="{{ route('my-jobs.update', $job) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-8">
                <label for="title" class="mb-2 block text-sm font-medium text-slate-900">Title<span
                        class="text-red-500">*</span></label>
                <x-text-input name='title' type='text' value='{{ old("title", $job->title) }}'
                    placeholder="Sales">
                </x-text-input>
                @error('title')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-8">
                <label for="description" class="mb-2 block text-sm font-medium text-slate-900">Description<span
                        class="text-red-500">*</span></label>
                <x-text-input name='description' type='textarea'
                    value='{{ old("description", $job->description) }}' rows=10>
                </x-text-input>
                @error('description')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-between">


                <div class="mb-8">
                    <label for="location" class="mb-2 block text-sm font-medium text-slate-900">Location<span
                            class="text-red-500">*</span></label>
                    <x-text-input name='location' type='text'
                        value='{{ old("location", $job->location) }}'>
                    </x-text-input>
                    @error('location')
                        <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-8">
                    <label for="salary" class="mb-2 block text-sm font-medium text-slate-900">Salary<span
                            class="text-red-500">*</span></label>
                    <x-text-input name='salary' type='number'
                        value='{{ old("salary", $job->salary) }}'>
                    </x-text-input>
                    @error('salary')
                        <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-8">
                    <label for="category" class="mb-2 block text-sm font-medium text-slate-900">Category<span
                            class="text-red-500">*</span></label>
                    <select name="category" id="category"
                        class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-400 focus:ring-2 ring-slate-300 pr-8">
                        @foreach(\App\Models\Job::$category as $category)
                            <option value="{{ $category }}"
                                {{ $category === $job->category ? 'selected' : '' }}>
                                {{ Str::ucFirst($category) }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-8">
                    <label for="experience" class="mb-2 block text-sm font-medium text-slate-900">Experience<span
                            class="text-red-500">*</span></label>
                    <select name="experience" id="experience"
                        class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-400 focus:ring-2 ring-slate-300 pr-8">
                        @foreach(\App\Models\Job::$experience as $experience)
                            <option value="{{ $experience }}"
                                {{ $experience === $job->experience ? 'selected' : '' }}>
                                {{ Str::ucFirst($experience) }}
                            </option>
                        @endforeach
                    </select>
                    @error('experience')
                        <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <x-button class="w-full">Update</x-button>

        </form>
    </x-card>
</x-layout>
