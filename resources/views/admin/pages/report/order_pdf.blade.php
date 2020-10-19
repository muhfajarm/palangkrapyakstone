<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order PDF</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0,0,0,.1);
        }

        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            margin-bottom: .5rem;
            font-weight: 500;
            line-height: 1.2;
        }
        h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
            margin-bottom: .5rem;
        }
        .h5, h5 {
            font-size: 1.25rem;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
    </style>
</head>
<body>
    <h5>Laporan Order Periode ({{ $date[0] }} - {{ $date[1] }})</h5>
    <hr>
    <table width="100%" class="table-bordered">
        <thead>
            <tr>
                <th>InvoiceID</th>
                <th>Pelanggan</th>
                <th>Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse ($orders as $row)
                <tr>
                    <td><strong>{{ $row->invoice }}</strong></td>
                    <td>
                        <strong>{{ $row->pelanggan_nama }}</strong><br>
                        <label><strong>Telp:</strong> {{ $row->pelanggan_no_hp }}</label><br>
                        <label><strong>Alamat:</strong> {{ $row->pelanggan_alamat }}, {{  $row->pelanggan->city->title }}, {{ $row->pelanggan->city->province->title }}</label>
                    </td>
                    <td>{{ formatRupiah($row->subtotal) }}</td>
                    <td>{{ $row->created_at->format('d-m-Y') }}</td>
                </tr>

                @php $total += $row->subtotal @endphp
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td>{{ formatRupiah($total) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>