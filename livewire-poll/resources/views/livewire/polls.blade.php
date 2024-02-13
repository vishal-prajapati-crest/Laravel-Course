   
<div class="mt-4">
        @forelse ($polls as $poll)
            <div class="mt-4">
                <h3 class="mb-4 text-xl">
                    {{$poll->title}}
                </h3>
        
                @foreach ($poll->options as $index => $option)
                    <div class="mb-2"> 
                        <button class="btn" wire:click.prevent="vote({{$option->id}})">Vote</button>
                        {{$option->name}} ({{$option->votes->count()}})
                </div>
                    
                @endforeach
            </div>
        @empty
            <div class="mb-4">No Poll exists</div>
        @endforelse
</div>


