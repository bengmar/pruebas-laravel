<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function index($categoria = null)
    {
        // Usamos 'with' para cargar la categoría y evitar el problema de consultas N+1
        $query = Product::with('category');

        if ($categoria) {
            // Filtramos en la tabla 'categories' buscando por la columna 'name'
            $query->whereHas('category', function ($q) use ($categoria) {
                $q->where('name', $categoria);
            });
        }

        $products = $query->get();

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
