<x-layout>
    <x-slot name="title">Catálogo</x-slot>
    <div class="container pt-2 pb-4">
        <h2 class="text-center bg-white rounded-border m-3 border rounded"> Catálogo De Productos </h2>
        <div class="row justify-content-center g-2 px-2">
            @foreach ($products as $card)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex justify-content-center">
                    <x-card :card="$card" />
                </div>
            @endforeach
        </div>
    </div>
</x-layout>
