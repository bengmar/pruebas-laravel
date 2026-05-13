<x-layout>
    <x-slot name="title">Búsqueda</x-slot>
    <div class="container my-5">
        <h2 class="mb-4 color-adaptativo">Resultados para: "{{ $query }}"</h2>

        @if ($results->isEmpty())
            <div class="text-center py-5 shadow-sm rounded bg-light">
                <p class="text-muted">No encontramos instrumentos que coincidan con tu búsqueda.</p>
                <a href="{{ url('/') }}" class="btn btn-primary">Volver a la tienda</a>
            </div>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-3">
                @foreach ($results as $product)
                    <div class="col">
                        {{--
                        Llamamos al componente.
                        Pasamos la variable $product a la prop 'card'.
                    --}}
                        <x-card :card="$product" />
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper d-flex justify-content-center mt-5">
                {{ $results->appends(['query' => $query])->links() }}
            </div>
        @endif
    </div>
    {{-- Paginación {{ $results->links() }} --}}
</x-layout>
