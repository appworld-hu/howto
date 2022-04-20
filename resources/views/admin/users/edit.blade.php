@section('tools')
    {{ $title }}
@endsection

<x-admin-layout>
    <livewire:user-form :modelId="$model->id"></livewire:user-form>
</x-admin-layout>
