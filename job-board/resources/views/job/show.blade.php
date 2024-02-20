<x-layout>
    @if(auth()->user())
        @if(auth()->user()->employer->id ?? false === $job->employer->id)
            <x-breadcrumbs class="mb-4" :links="['My Jobs' => route('my-jobs.index'), $job->title => '#']" />
        @else
            <x-breadcrumbs class="mb-4" :links="['Jobs' => route('jobs.index'), $job->title => '#']" />
        @endif
    @else
        <x-breadcrumbs class="mb-4" :links="['Jobs' => route('jobs.index'), $job->title => '#']" />
    @endif

    <x-job-card :$job>
        <p class="text-sm text-slate-500 mb-4">
            <!-- nl2br() will display the html tag in the data.  !! will display in result -->
            {!! nl2br(e($job->description)) !!}
        </p>

        <!-- //check the ability or policy i.e. user is applied for job or not -->
        @can('apply', $job)
            <x-link-button :href="route('job.application.create',['job' => $job]) ">
                Apply
                Now
            </x-link-button>
        @else
            @if(auth()->user())


                @if(auth()->user()->employer)
                    @if($job->employer->id === auth()->user()->employer->id)
                        <div class="flex justify-center items-center gap-2">

                            <a id="edit" href="{{ route('my-jobs.edit', $job) }}">
                                <button class="text-green-500" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15m0-3-3-3m0 0-3 3m3-3V15" />
                                    </svg>
                                </button>
                            </a>

                            <form id="delete" action="{{ route('my-jobs.destroy', $job) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 mr-6" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="block  h-px my-6 bg-gray-400"></div>

                        @forelse($job->jobApplications as $application)


                            <div class="mb-4 flex justify-between ml-6">
                                <div>
                                    <div class="text-slate-700 font-medium text-base">
                                        <a href="{{ route('jobs.show',$job) }}">
                                            {{ $application->user->name }}
                                        </a>
                                    </div>
                                    <div class="text-xs">
                                        Applied {{ $application->created_at->diffForHumans () }}
                                    </div>
                                </div>
                                <div class="flex flex-col  justify-center items-end mx-6">
                                    <div class="text-sm font-medium text-slate-600">
                                        ₹{{ number_format($application->expected_salary) }}
                                    </div>
                                    <div class="text-sm"><a
                                            href="{{ route('cv.download',[$job, substr($application->cv_path,4)]) }}">
                                            Download CV
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-300 block  h-px my-6 mx-6 last:mx-0 last:bg-gray-400 "></div>

                        @empty
                            <div class="text-center">No Applications Yet</div>

                        @endforelse

                    @else
                        <div class="text-sm text-slate-400 font-medium">You are employer</div>
                    @endif
                @elseif(auth()->user())
                    <div class="text-sm text-slate-400 font-medium">You Already Applied!!</div>

                @else
                    <x-link-button :href="route('job.application.create',['job' => $job]) ">
                        Apply
                        Now
                    </x-link-button>
                @endif
            @else
                <x-link-button :href="route('job.application.create',['job' => $job]) ">
                    Apply
                    Now
                </x-link-button>
            @endif
        @endcan


    </x-job-card>

    <x-card class="mb-4">
        <h2 class="text-lg text-center font-medium mb-4">More Jobs for {{ $job->employer->company_name }}</h2>

        <div class="text-sm text-slate-500">



            @foreach($job->employer->jobs as $otherJob)
                @if($otherJob->id !== $job->id)


                    <div class="mb-4 flex justify-between">
                        <div>
                            <div class="text-slate-700 font-medium">
                                <a href="{{ route('jobs.show', $otherJob) }}">
                                    {{ $otherJob->title }}
                                </a>
                            </div>
                            <div class="text-xs">
                                {{ $otherJob->created_at->diffForHumans () }}
                            </div>
                        </div>
                        <div class="text-xs">
                            ₹{{ number_format($otherJob->salary) }}
                        </div>
                    </div>

                @endif

            @endforeach
        </div>


    </x-card>


</x-layout>
