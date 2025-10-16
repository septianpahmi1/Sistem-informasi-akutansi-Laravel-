@foreach ($data as $journal)
    @php
        $entries = $journal->entries;
        $totalDebit = $entries->where('type', 'debit')->sum('total');
        $totalKredit = $entries->where('type', 'credit')->sum('total');
    @endphp

    @foreach ($entries as $index => $entry)
        <tr>
            @if ($index === 0)
                <td>{{ $loop->parent->iteration }}</td>
                <td>{{ $journal->invoice_number }}</td>
                <td>{{ $journal->description }}</td>
                <td>{{ \Carbon\Carbon::parse($journal->date)->format('d/m/Y') }}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
                <td style="color: white">{{ \Carbon\Carbon::parse($entry->date)->format('d/m/Y') }}</td>
            @endif

            <td>{{ $entry->account->name ?? '-' }}</td>
            <td>
                {{ $entry->type === 'debit' ? 'Rp. ' . number_format($entry->total, 0, ',', '.') : 'Rp. 0' }}
            </td>
            <td>
                {{ $entry->type === 'credit' ? 'Rp. ' . number_format($entry->total, 0, ',', '.') : 'Rp. 0' }}
            </td>
        </tr>
    @endforeach

    <tr class="bg-light font-weight-bold">
        <td></td>
        <td></td>
        <td></td>
        <td style="color: rgb(255, 255, 255);">
            {{ \Carbon\Carbon::parse($journal->date)->format('d/m/Y') }}
        </td>
        <td><strong>Total</strong></td>
        <td><strong>Rp. {{ number_format($totalDebit, 0, ',', '.') }}</strong></td>
        <td><strong>Rp. {{ number_format($totalKredit, 0, ',', '.') }}</strong></td>
    </tr>
@endforeach
