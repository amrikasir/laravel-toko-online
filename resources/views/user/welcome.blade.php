@extends('user.app')
@section('content')
    <div class="site-blocks-cover" style="background-image: url({{ asset('shopper') }}/images/hero_1.jpg);" data-aos="fade">
        <div class="container">
            <div class="row align-items-start align-items-md-center justify-content-end">
                <div class="col-md-5 text-center text-md-left pt-5 pt-md-0">
                    <h1 class="mb-2">Cari Kebutuhan Olahraga Kamu Di Sini</h1>
                    <div class="intro-text text-center text-md-left">
                        <p class="mb-4">Alat olahraga disini terjamin kualitasnya dan tentunya barangnya juga original
                            bukan kw. </p>
                        <p>
                            <a href="{{ route('user.produk') }}" class="btn btn-sm btn-primary">Belanja Sekarang</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section block-3 site-blocks-2 bg-light" data-aos="fade-up">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Produk Terlaris</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="nonloop-block-3 owl-carousel">
                        @foreach ($produks as $produk)
                            <x-product :produk="$produk" :carousel="true" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
