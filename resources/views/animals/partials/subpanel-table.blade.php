@if ($data->count())
    <div class="mb-2">
        <input type="text" class="form-control form-control-sm subpanel-search" placeholder="Search..."
            data-panel="{{ $panel }}">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Sr#</th>
                    @foreach (array_keys($data->first()->getAttributes()) as $field)
                        @if (!str_ends_with($field, '_id') && $field !== 'id')
                            <th>{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                        @endif
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $index => $row)
                    <tr>
                        {{-- Sr# continuous across pagination --}}
                        <td>{{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}</td>
                        @foreach ($row->getAttributes() as $field => $value)
                            @if (!str_ends_with($field, '_id') && $field !== 'id')
                                <td>{{ $value }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-2">
        <nav>
            <ul class="pagination">
                @foreach ($data->links()->elements as $element)
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li class="page-item {{ $page == $data->currentPage() ? 'active' : '' }}">
                                <a href="#" class="page-link"
                                    data-page="{{ $page }}">{{ $page }}</a>
                            </li>
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
@else
    <p>No records found.</p>
@endif
