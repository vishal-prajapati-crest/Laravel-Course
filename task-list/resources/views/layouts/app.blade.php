<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- blade-formatter-disable --}}
    
    <style type="text/tailwindcss">
            .btn-red{
                @apply rounded-md px-3 py-1 text-center font-medium shadow-sm ring-1 ring-red-600/10 bg-red-500 text-neutral-50 hover:bg-red-400 hover:ring-red-500/10;
            }
            .btn-blue {
                @apply rounded-md px-3 py-1 text-center font-medium shadow-sm ring-1 ring-blue-600/10 bg-blue-500 text-neutral-50 hover:bg-blue-400 hover:ring-blue-500/10;
            }
            
            label{
                @apply mb-2 block uppercase text-slate-700
            }
            input, textarea{
                @apply shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none
                
            }
            .alert-success{
                @apply relative mb-10 rounded border border-green-400 bg-green-100 px-4 py-3 text-lg text-green-700
            }

            
            
     </style>

    {{-- blade-formatter-enable --}}

    <title>Task List</title>
    @yield('styles')
</head>

<body class="container mx-auto mt-10 mb-10 max-w-lg border-box">
    <h1 class="font-medium mb-4 text-2xl text-blue-600 text-center">
        @yield('title')
    </h1>
    <div x-data="{ flash: true }" >
        @if(session()->has('success'))
        <div x-show="flash" class="alert-success" role="alert">
            <strong>Success!</strong>
            <div>{{ session("success") }}</div>
            <span @click="flash=false" class="absolute top-0 right-3 hover:cursor-pointer px-4 py-2">×</span>
        </div>
        @endif
        @yield('content')
    </div>
</body>

</html>
