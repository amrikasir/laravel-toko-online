<div class="{{ $carouselClass() }}" data-aos="fade-up">
    <div class="block-4 border">
        <a href="{{ route('user.produk.detail',['id' =>  $produk->id]) }}">
            <img 
                src="{{ $produk->image }}" 
                alt="Image placeholder" 
                class="img-fluid"
                width="100%"
                style="height:200px"
            >
        </a>
        <div class="block-4-text p-4">
            <h3>
                <a href="{{ route('user.produk.detail',['id' =>  $produk->id]) }}">
                    {{ $produk->name }}
                </a>
            </h3>
            <p class="mb-0">Rp. {{ $produk->price }}</p>
            <a 
                href="{{ route('user.produk.detail',['id' =>  $produk->id]) }}"
                class="btn btn-primary mt-2"
            >
                Detail
            </a>
        </div>
    </div>
</div>