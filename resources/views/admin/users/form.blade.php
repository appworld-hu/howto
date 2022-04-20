<div>
@wire
    <x-form wire:submit.prevent="submit">

        <x-form-input name="model.name" label="{{ __('users.attributes.name') }}" />

        <x-form-input name="model.email" label="{{ __('users.attributes.email') }}" />

        <x-form-input name="password" label="{{ $model->exists ? __('users.attributes.new_password') : __('users.attributes.password') }}" />

        <x-form-submit class="btn-sm mt-3">{{ __('tools.buttons.save') }}</x-form-submit>

    </x-form>
@endwire
</div>
