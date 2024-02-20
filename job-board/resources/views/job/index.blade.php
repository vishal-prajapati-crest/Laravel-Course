<x-layout>
    <x-breadcrumbs class="mb-4" :links="['Jobs' => route('jobs.index')]" />

    <x-card class="mb-4 text-sm">
        <form id="filtering-form" action="{{ route('jobs.index') }}" method="get">
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <div class="mb-1 font-semibold">Search</div>
                    <x-text-input name="search" value="{{ request('search') }}"
                        placeholder="Search for any text" formId="filtering-form" />
                </div>
                <div>
                    <div class="mb-1 font-semibold">Salary</div>
                    <div class="flex gap-2">
                        <x-text-input name="min_salary" value="{{ request('min_salary') }}"
                            placeholder="From" formId="filtering-form" />
                        <x-text-input name="max_salary" value="{{ request('max_salary') }}"
                            placeholder="To" formId="filtering-form" />
                    </div>
                </div>
                <div>
                    <div class="mb-1 font-semibold">Experience</div>
                    <x-radio-group name="experience"
                        :options="array_combine(array_map('ucfirst',\App\Models\Job::$experience),\App\Models\Job::$experience)">
                    </x-radio-group>
                </div>
                <div>
                    <div class="mb-1 font-semibold">Category</div>
                    <x-radio-group name="category" :options="\App\Models\Job::$category"></x-radio-group>
                </div>
            </div>
            <x-button class="w-full" type="submit">Filter</x-button>
        </form>
    </x-card>

    @foreach($jobs as $job)
        <x-job-card class="mb-4" :job="$job">

            <p class="text-sm text-slate-500 mb-4">
                <!-- nl2br() will display the html tag in the data.  !! will display in result -->

                {!! substr(nl2br(e($job->description)),0,110).'...' !!}
            </p>


            <x-link-button :href="route('jobs.show', $job)">
                Show
            </x-link-button>
        </x-job-card>
    @endforeach
</x-layout>
