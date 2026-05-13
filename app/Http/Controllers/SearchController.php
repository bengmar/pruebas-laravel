<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('query'));

        // 1. Validación de longitud (Mínimo 3 caracteres)
        if (empty($query) || strlen($query) < 3) {
            // Si es una petición normal, redirigimos con mensaje
            if (!$request->ajax()) {
                return redirect()->back()->with('error', 'Por favor, ingresa al menos 3 caracteres.');
            }
            // Si es AJAX, devolvemos un mensaje vacío para no mostrar nada
            return '';
        }

        // 2. Consulta unificada (mantenemos tus relaciones)
        $resultsQuery = Product::query()
            ->where('products.title', 'LIKE', "%{$query}%")
            ->orWhereHas('brand', function ($q) use ($query) {
                $q->where('brands.name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('categories.name', 'LIKE', "%{$query}%");
            });

        // 3. Lógica Diferenciada (AJAX vs Normal)
        if ($request->ajax()) {
            // Para sugerencias rápidas, limitamos a 5 resultados y solo traemos lo necesario
            $suggestions = $resultsQuery->limit(5)->get();

            if ($suggestions->isEmpty()) {
                return '<div class="list-group-item text-muted">Sin resultados</div>';
            }

            $html = '';
            foreach ($suggestions as $product) {
                // Ajusta la ruta a la que uses para ver el detalle del producto
                $url = route('product-details', ['id' => $product->id]);
                $html .= "
                <a href='{$url}' class='list-group-item list-group-item-action d-flex align-items-center'>
                    <img src='" . asset($product->image_1) . "' style='width: 40px; height: 40px; object-fit: cover;' class='me-2 rounded'>
                    <div>
                        <div class='fw-bold' style='font-size: 0.9rem;'>{$product->title}</div>
                        <small class='text-muted'>{$product->brand->name}</small>
                    </div>
                </a>";
            }
            return $html;
        }

        // 4. Paginación normal para la vista de resultados completa
        $results = $resultsQuery->paginate(12)->appends(['query' => $query]);

        return view('search.results', compact('results', 'query'));
    }
}
