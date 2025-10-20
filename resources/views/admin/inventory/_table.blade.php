@php
    if (!function_exists('rupiah')) {
        function rupiah($angka)
        {
            return 'Rp ' . number_format($angka ?? 0, 0, ',', '.');
        }
    }
@endphp
@foreach ($data as $item)
    @php
        $totalInQty = $item->stockIn->sum('qty');
        $totalInPrice = $item->stockIn->avg('price');
        $totalInTotal = $item->stockIn->sum('total');

        $totalOutQty = $item->stockOut->sum('qty');
        $totalOutPrice = $item->stockOut->avg('price');
        $totalOutTotal = $item->stockOut->sum('total');

        $saldoQty = $totalInQty - $totalOutQty;
        $saldoHarga = $saldoQty > 0 ? $totalInPrice : 0;
        $saldoTotal = $saldoQty * $saldoHarga;
    @endphp

    <tr class="text-center">
        <td>{{ Carbon\Carbon::parse($item->date)->format('d/m/y') }}</td>
        <td>{{ $item->code }}</td>
        <td>{{ $item->name }}</td>

        <td>{{ $totalInQty }}</td>
        <td>{{ rupiah($totalInPrice) }}</td>
        <td>{{ rupiah($totalInTotal) }}</td>

        <td>{{ $totalOutQty }}</td>
        <td>{{ rupiah($totalOutPrice) }}</td>
        <td>{{ rupiah($totalOutTotal) }}</td>

        <td>{{ $saldoQty }}</td>
        <td>{{ rupiah($saldoHarga) }}</td>
        <td>{{ rupiah($saldoTotal) }}</td>

        <td>
            <div class="btn-group btn-block">
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                    data-target="#inventory{{ $item->id }}">
                    <i class="fas fa-door-open"></i>
                </button>
                <a href="{{ route('inventory.update', $item->id) }}" type="button" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                </a>
                <button url="{{ route('inventory.delete', $item->id) }}" type="button"
                    class="btn btn-sm btn-danger delete" data-id="{{ $item->id }}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@endforeach
