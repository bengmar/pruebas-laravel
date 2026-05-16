<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function index($categoria = null)
    {
        // El Scope ya aplicó el 'where is_active = true' para todos los controladores
        $query = Product::with('category');

        if ($categoria) {
            $query->whereHas('category', function ($q) use ($categoria) {
                $q->where('slug', $categoria); // Mejor filtrar por slug que por nombre
            });
        }

        $products = $query->get(); //$query->paginate(12); // Es mejor usar paginate que get() si tienes muchos productos

        // El resto de tu lógica de títulos...
        $nombresCategorias = [
            'Audio'        => 'Equipos de Audio y Sonido',
            'Instrumentos' => 'Instrumentos Musicales',
            'Soportes'     => 'Trípodes y Soportes',
            'Outlet'       => 'Outlet 🔥',
            'Fotografia'   => 'Fotografía',
            'Iluminacion'  => 'Iluminación y Estudio',
            'Bolsos'       => 'Bolsos y Mochilas'
        ];
        $tituloCategoria = $nombresCategorias[$categoria] ?? 'Nuestro Catálogo';

        return view('pages.catalog', compact('products', 'tituloCategoria', 'categoria'));
    }

    public function details(int $id)
    {
        // Buscamos el producto por su ID.
        // findOrFail lanza automáticamente un error 404 si no existe.
        $product = Product::findOrFail($id);

        // No hace falta calcular el final_price aquí,
        // lo invocas directamente en la vista con $product->final_price

        return view('pages.product-details', compact('product'));
    }
}
