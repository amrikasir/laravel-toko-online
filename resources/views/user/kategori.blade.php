@extends('user.app')
@section('content')
<div class="bg-light py-3">
	<div class="container">
		<div class="row">
			<div class="col-md-12 mb-0"><a href="{{ route('home') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong
					class="text-black">Shop</strong></div>
		</div>
	</div>
</div>

<div class="site-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3 class="display-5" style="text-transform:uppercase">Kategori {{ $category->name }}</h3>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md-9 order-2">
				<div class="row mb-5">
					@foreach($produks as $produk)
						<x-product :produk="$produk" />
					@endforeach
				</div>
				<div class="row" data-aos="fade-up">
					<div class="col-md-12 text-right">
						<div class="site-block-27">
							{{ $produks->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection