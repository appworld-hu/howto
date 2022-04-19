<ul class="nav flex-column">
    @foreach($items as $itemKey => $item)
        <li class="nav-item">
            @if($item->accordion)
                <a href="{{ $item->link }}" class="{{ $item->active ? 'active' : '' }} nav-link active">
                    {!! $item->icon !!}
                    {{ $item->title }}
                </a>

                <ul>
                    @foreach($item->items as $item)
                        <li>
                            <a href="{{ $item->link }}" class="{{ $item->active ? 'active' : '' }} nav-link active">
                                {!! $item->icon !!}
                                {{ $item->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <a href="{{ $item->link }}" class="{{ $item->active ? 'active' : '' }} nav-link active">
                    {!! $item->icon !!}
                    {{ $item->title }}
                </a>
            @endif
        </li>
    @endforeach
</ul>
