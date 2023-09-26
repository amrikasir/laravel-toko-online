@extends('user.app')
@section('content')
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong
                        class="text-black">Cart</strong></div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-12 text-center">
                    <h2 class="display-5">Detail Pesanan Anda</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <table>
                                        <tr>
                                            <th>No Invoice</th>
                                            <td>:</td>
                                            <td>{{ $order->invoice }}</td>
                                        </tr>
                                        <tr>
                                            <th>No Resi</th>
                                            <td>:</td>
                                            <td>{{ $order->no_resi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Pesanan</th>
                                            <td>:</td>
                                            <td>{{ $order->status_order->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Metode Pembayaran</th>
                                            <td>:</td>
                                            <td>
                                                @if ($order->metode_pembayaran == 'trf')
                                                    Transfer Bank
                                                @else
                                                    COD
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total Pembayaran</th>
                                            <td>:</td>
                                            <td>Rp. {{ number_format($order->subtotal + $order->biaya_cod, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-4 text-right">
                                    @if ($order->status_order_id == 4)
                                        <a href="{{ route('user.order.pesananditerima', ['id' => $order->id]) }}"
                                            onclik="return confirm('Yakin ingin melanjutkan ?')"
                                            class="btn btn-primary">Pesanan Di Terima</a><br>
                                        <small>Jika pesanan belum datang harap jangan tekan tombol ini</small>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="product-thumbnail">Gambar</th>
                                                <th class="product-name">Nama Produk</th>
                                                <th class="product-testimoni">Testimoni</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->detail as $item)
                                                <tr>
                                                    <td><img src="{{ $item->product->image }}" alt="" srcset=""
                                                            width="50"></td>
                                                    <td>{{ $item->product->name }}</td>
                                                    <td>
                                                        @if($order->status_order_id == 5)
                                                        <div x-data="_ulasan" x-init="initd({{ $item->product->id }})">
                                                            <p x-show="show" x-text="ulasan"></p>
                                                            <div x-show="!show" class="input-group mb-3">
                                                                <input type="text" class="form-control" placeholder="Ulasan"
                                                                    aria-label="Berikan Ulasanmu terhadap produk ini"
                                                                    aria-describedby="button-addon2" x-model="ulasan">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-secondary" type="button"
                                                                        id="button-addon2" x-on:click="submit">
                                                                        Submit
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('_ulasan', () => ({
            ulasan: '',
            product_id: '',
            show: false,
            initd(product_id){
                this.product_id = product_id;

                fetch('{{ route("user.ulasan.get") }}/' + product_id, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                }).then(res => res.json())
                .then(res => {
                    if(res.status == 'success') {
                        this.ulasan = res.data.ulasan
                        this.show = true
                    }
                })
            },
            submit() {
                fetch('{{ route("user.ulasan.simpan") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        ulasan: this.ulasan,
                        product_id: this.product_id,
                    })
                }).then(res => res.json())
                .then(res => {
                    if(res.status == 'success') {
                        this.show = true
                    }
                })
            }
        }))
    })
</script>
@endsection