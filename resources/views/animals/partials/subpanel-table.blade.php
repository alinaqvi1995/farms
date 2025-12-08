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
        {{ $data->links() }}
    </div>
@else
    <p>No records found.</p>
@endif
