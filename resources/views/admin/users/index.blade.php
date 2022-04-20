@section('title')
    {{ $title }}
@endsection

@section('tools')
    <div class="btn-group me-2">
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success">Create</a>
    </div>
@endsection

<x-admin-layout>
    <livewire:users-table />
</x-admin-layout>
