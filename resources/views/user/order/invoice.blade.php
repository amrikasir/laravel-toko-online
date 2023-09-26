<!DOCTYPE html>
<html lang="en">

<head>
    <title>Invoice {{ $order->invoice }}</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <style>
        .max-lines {
            text-overflow: ellipsis;
            overflow: hidden;
            max-width: 100px;
        }
    </style>
    <!-- Include the above in your HEAD tag -->
</head>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <h2>Invoice</h2>
                <h3 class="pull-right">Order # {{ $order->invoice }}</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Alamat pembayar:</strong><br>
                        {{ $order->user->name }}<br>
                        {{ $order->user->alamat->detail }}<br>
                        {{ $order->user->alamat->city->title }}<br>
                        {{ $order->user->alamat->city->province->title }}
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Alamat kirim:</strong><br>
                        {{ $order->user->name }}<br>
                        {{ $order->user->alamat->detail }}<br>
                        {{ $order->user->alamat->city->title }}<br>
                        {{ $order->user->alamat->city->province->title }}
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Metode Pembayaran:</strong><br>
                        {{ $order->metode_pembayaran }}
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Tanggal pemesanan:</strong><br>
                        {{ $order->updated_at->format('d, M Y') }}<br><br>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Rincian Pesanan</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed" style="white-space: nowrap">
                            <thead>
                                <tr>
                                    <td><strong>Item</strong></td>
                                    <td class="text-center"><strong>Harga Satuan</strong></td>
                                    <td class="text-center"><strong>Qty</strong></td>
                                    <td class="text-right"><strong>Total Harga</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                @foreach($order->detail as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td class="text-center max-lines">{{ $item->product->price }}</td>
                                    <td class="text-center">{{ $item->qty }}</td>
                                    <td class="text-right">{{ $item->product->price * $item->qty }}</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                    <td class="thick-line text-right">{{ $order->subtotal - $order->ongkir }}</td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Ongkos Kirim</strong></td>
                                    <td class="no-line text-right">{{ $order->ongkir }}</td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Total</strong></td>
                                    <td class="no-line text-right">{{ $order->subtotal }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
