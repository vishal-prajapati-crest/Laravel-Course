
<div>
    <form wire:submit.prevent="createPoll">
        <label>Poll Title:</label>
        <!-- Use wire:model directive for two-way data binding wire:model.live -->
        <input type="text" wire:model.live="title" />
        
        @error('title')
            <div class="text-red-500">{{$message}}</div>
        @enderror

        <div class="mb-4 mt-4">
            <button class="btn" wire:click.prevent="addOption" >Add Option</button>
        </div>

        <div class="mt-4">
            @foreach ($options as $index => $option)
                <div class="mb-4">
                    <label>Option {{$index + 1}}</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model.live="options.{{$index }}" />
                        
                        <button class="btn" wire:click.prevent="removeOption({{$index}})">Remove</button>
                    </div>
                    @error("options.{$index}")
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>

            @endforeach
        </div>

        <button class="btn" type="submit">Create Poll</button>
    </form>


</div>