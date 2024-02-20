<div class="relative">

    @if('textarea' !== $type)
        @if($formId)
            <button class="absolute top-0 right-0 flex h-full items-center mr-1 text-slate-500 text-sm" type="button"
                onclick="clearAndSubmit('{{ $formId }}','{{ $name }}' ,'{{ $submitAfterClear }}')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        @endif

        <input type="{{ $type }}" placeholder="{{ $placeholder }}" name="{{ $name }}" value="{{ $value }}"
            id="{{ $name }}"
            @class([ 'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-400 focus:ring-2'
            , 'pr-5'=> $formId,
        'ring-slate-300' => !$errors->has($name),
        'ring-red-300' => $errors->has($name)
        ]) />
    @else
        <textarea name="{{ $name }}" value="{{ $value }}" id="{{ $name }}"
            @class([ 'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-400 focus:ring-2'
            , 'pr-5'=> $formId,
        'ring-slate-300' => !$errors->has($name),
        'ring-red-300' => $errors->has($name)
        ])  rows={{ $rows }}>
        {{ old($name, $value) }}
    </textarea>
    @endif



</div>


<script>
    function clearAndSubmit(formId, name, submitAfterClear) {
        document.getElementById(name).value = '';
        if (submitAfterClear) {
            document.getElementById(formId).submit();
        }
    }

</script>
