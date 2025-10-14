@include('admin.layouts.header')
@include('admin.layouts.navbar')
@include('admin.layouts.sidebar')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable {{ $title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Number</th>
                                        <th>Ket</th>
                                        <th>Tanggal</th>
                                        <th>Akun</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $entries = $journal->entries;
                                        $totalDebit = $entries->where('type', 'debit')->sum('total');
                                        $totalKredit = $entries->where('type', 'credit')->sum('total');
                                    @endphp

                                    @foreach ($entries as $index => $entry)
                                        <tr>
                                            @if ($index === 0)
                                                <td>1</td>
                                                <td>{{ $journal->invoice_number }}</td>
                                                <td>{{ $journal->description }}</td>
                                                <td>{{ \Carbon\Carbon::parse($journal->date)->format('d/m/Y') }}
                                                </td>
                                            @else
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
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

                                    {{-- Total hanya sekali per jurnal --}}
                                    <tr class="bg-light font-weight-bold">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Total</strong></td>
                                        <td><strong>Rp. {{ number_format($totalDebit, 0, ',', '.') }}</strong></td>
                                        <td><strong>Rp. {{ number_format($totalKredit, 0, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.layouts.footer')
