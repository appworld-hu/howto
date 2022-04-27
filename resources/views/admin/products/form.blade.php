<div>
@wire
    <x-form wire:submit.prevent="submit">

        <x-form-input name="model.name" label="{{ __('products.attributes.name') }}" />

        <x-form-input name="model.description" label="{{ __('products.attributes.description') }}" />

        <x-form-submit class="btn-sm mt-3">{{ __('tools.buttons.save') }}</x-form-submit>

    </x-form>
@endwire
</div>
