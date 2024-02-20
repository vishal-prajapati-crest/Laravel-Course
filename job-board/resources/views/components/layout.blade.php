<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Board</title>
    @vite('resources/css/app.css')
        @vite('resources/js/app.js')
</head>

<body
    class="mx-auto mt-10 max-w-2xl bg-gradient-to-r from-indigo-100 from-10% via-sky-100 via-30% to-emerald-100 to-90% text-slate-700">
    <nav class="mb-8 text-lg font-medium flex justify-between">
        <ul class="flex gap-2">
            <li>
                <a href="{{ route('jobs.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>

                </a>
            </li>
        </ul>
        <ul class="flex items-center justify-center  gap-2">
            @auth
                <li>
                    <div class="flex items-center">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                <li>
                    {{ auth()->user()->name ?? 'Anynomus' }}
                </li>
                <li>
                    @if(!auth()->user()->employer)
                        <a href="{{ route('my-job-applications.index') }}">

                            Applications
                        </a>
                    @else
                        <a href="{{ route('my-jobs.index') }}">My Jobs</a>
                    @endif

                </li>


                </div>
                </li>

                <li>
                    <form class="flex justify-center" action="{{ route('auth.destroy') }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>

                        </button>
                    </form>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}">Sign in</a>
                </li>
            @endauth

        </ul>
    </nav>

    @if(session('success'))
        <div id="alert-box" role="alert"
            class="my-8 rounded-md border-l-4 border-green-400 bg-green-200 p-4 text-green-700 opacity-75 relative">
            <button type="button" onclick="document.getElementById('alert-box').style.display='none';"
                class="absolute top-2 right-2 text-slate-600 font-medium text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>

            </button>
            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div id="alert-box" role="alert"
            class="my-8 rounded-md border-l-4 border-red-400 bg-red-200 p-4 text-red-700 opacity-75 relative">
            <button type="button" onclick="document.getElementById('alert-box').style.display='none';"
                class="absolute top-2 right-2 text-slate-600 font-medium text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>

            </button>
            <p class="font-bold">Error!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{ $slot }}
</body>

</html>
