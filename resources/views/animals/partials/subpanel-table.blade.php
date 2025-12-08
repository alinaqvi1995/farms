@if ($data->count())
    <div class="mb-2">
        <input type="text" class="form-control form-control-sm subpanel-search" placeholder="Search..."
            data-panel="{{ $panel }}" value="{{ $search ?? '' }}">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Sr#</th>
                    @foreach (array_keys($data->first()->getAttributes()) as $field)
                        @php
                            // Skip system columns
                            $skipCols = ['updated_by', 'deleted_at', 'updated_at', 'created_at', 'id'];
                        @endphp
                        @if (!in_array($field, $skipCols))
                            <th>{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                        @endif
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $index => $row)
                    <tr>
                        <td>{{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}</td>
                        @foreach ($row->getAttributes() as $field => $value)
                            @if (!in_array($field, $skipCols))
                                @if (str_ends_with($field, '_by'))
                                    {{-- Show related user's name --}}
                                    <td>{{ $row->user?->name ?? 'N/A' }}</td>
                                    {{-- <td>{{ $row->{$field . '_rel'}?->name ?? 'N/A' }}</td> --}}
                                @else
                                    <td>{{ $value }}</td>
                                @endif
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
