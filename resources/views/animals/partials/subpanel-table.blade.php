@if ($data->count())
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    @foreach (array_keys($data->first()->getAttributes()) as $field)
                        <th>{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $row)
                    <tr>
                        @foreach ($row->getAttributes() as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-2">
        @if ($data->count())
            <nav>
                <ul class="pagination">
                    @foreach ($records->links()->elements as $element)
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <li class="page-item {{ $page == $records->currentPage() ? 'active' : '' }}">
                                    <a href="#" class="page-link"
                                        data-page="{{ $page }}">{{ $page }}</a>
                                </li>
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            </nav>
        @endif
    </div>
@else
    <p>No records found.</p>
@endif
