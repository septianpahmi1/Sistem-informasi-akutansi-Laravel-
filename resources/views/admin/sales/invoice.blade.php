<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Sales #{{ $data->invoice_number }}</title>
    <link href="/dist/img/logo.png" rel="icon">
    <link href="/dist/img/logo.png" rel="apple-touch-icon">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <img src="/dist/img/logo.png" width="100" alt="Logo">
                        <small class="float-right">
                            #{{ $data->invoice_number }}
                        </small>
                    </h2>
                </div>
            </div>
            <br>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                    From
                    <address>
                        <strong>KOPERASI CIPTA USAHA SENTOSA</strong><br>
                        Jl. Pd. Bambu Kuning No.8, RT.3/RW.4, Bojong Baru, <br>
                        Kecamatan Bojonggede, Kabupaten Bogor, Jawa Barat 16920 <br>
                        Phone: (0251) 362360
                    </address>
                </div>
                <div class="col-sm-3 invoice-col">
                    To
                    <address>
                        <strong>{{ $data->customer->name }}</strong><br>
                        Phone: {{ $data->customer->phone }}<br>
                        Email: {{ optional($data->customer)->email ?? '-' }}
                    </address>
                </div>


                <div class="col-sm-3 invoice-col">
                    Detail
                    <address>
                        <strong>Tanggal : {{ \Carbon\Carbon::parse($data->date)->format('d/m/Y') }}</strong> <br>
                        <strong>Status &nbsp;&nbsp; : {{ $data->status }}</strong>
                    </address>
                </div>
            </div>

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Keterangan</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Diskon</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>{{ $data->ket }}</td>
                                <td>Rp {{ number_format($data->price, 0, '.', '.') }}</td>
                                <td>{{ $data->qty }}</td>
                                <td>Rp {{ number_format($data->discount, 0, '.', '.') ?? '-' }}</td>
                                <td>Rp {{ number_format($data->total, 0, '.', '.') }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4"></th>
                                <th>Total</th>
                                <th>Rp {{ number_format($data->total, 0, '.', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>

                        </thead>
                        <tbody>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Auto print -->
    <script>
        window.addEventListener("load", function() {
            window.print();
        });
    </script>
</body>

</html>
