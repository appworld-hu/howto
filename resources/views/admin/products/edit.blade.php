@section('tools')
    {{ $title }}
@endsection

<x-admin-layout>
    <livewire:product-form :modelId="$model->id"></livewire:product-form>
</x-admin-layout>
