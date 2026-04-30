@props(['card'])

<div class="card product-card h-100 m-1">
    {{-- Badge de descuento --}}
    @if ($card['on_sale'])
        <div class="badge-producto" style="z-index: 3;">
            {{ $card['discount'] }}% OFF
        </div>
    @endif

    {{-- Imagen --}}
    <img src="{{ asset($card['image']) }}" class="card-img-top" alt="Imagen de {{ $card['title'] }}" loading="lazy">

    <div class="card-body">
        <h5 class="card-title">{{ $card['title'] }}</h5>
        {{-- Cambié card-subtitle para que use la variable de texto muted del CSS --}}
        <p class="card-subtitle">{{ $card['subtitle'] }}</p>

        <div class="mt-auto">
            <div class="price-container">
                @if ($card['on_sale'])
                    <div class="d-flex align-items-baseline gap-2">
                        <p class="precio-descuento">
                            ${{ number_format($card['final_price'], 2, ',', '.') }}
                        </p>
                        {{-- Eliminé bg-success para usar un estilo que combine mejor con el dorado --}}
                        <span class="descuento-tag">{{ $card['discount'] }}% OFF</span>
                    </div>
                    <p class="precio-original">
                        ${{ number_format($card['price'], 2, ',', '.') }}
                    </p>
                @else
                    <p class="precio">
                        ${{ number_format($card['price'], 2, ',', '.') }}
                    </p>
                @endif
            </div>
            <p class="cuotas">
                {{ $card['installments'] }} x ${{ number_format($card['installment_price'], 2, ',', '.') }}
                <span>sin interés</span>
            </p>

            <p class="envio"><i class="bi bi-truck"></i> Envío gratis</p>

            {{-- Stretched link --}}
            <a href="{{ route('product-details', ['id' => $card['id']]) }}" class="stretched-link"></a>

            {{-- Botón: Ahora usa la clase btn-agregar que ya tiene el hover y colores en el CSS --}}
            <button type="button" class="btn-agregar position-relative" style="z-index: 2;">
                Añadir al carrito
            </button>
        </div>
    </div>
</div>
