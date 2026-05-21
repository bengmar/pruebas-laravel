<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Brand;
use App\Http\Requests\ProductRequest; // <--- Importamos tu Request
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductForm
{
    public static function updatePrices(Get $get, Set $set): void
    {
        $basePrice = (float) $get('price');
        $onSale = (bool) $get('on_sale');
        $discount = (float) $get('discount');
        $installments = (int) $get('installments') ?: 1;

        $finalPrice = $basePrice;

        if ($onSale && $discount > 0) {
            $finalPrice = $basePrice * (1 - ($discount / 100));
        }

        $set('sale_price', round($finalPrice, 2));

        $installmentValue = $finalPrice / $installments;
        $set('installment_price', round($installmentValue, 2));
    }

    public static function configure(Schema $schema): Schema
    {
        // Instanciamos el request para extraer las reglas y mensajes
        $request = new ProductRequest();
        $rules = $request->rules();
        $messages = $request->messages();

        return $schema
            ->schema([
                Section::make('Información del Instrumento')
                    ->description('Detalles principales del producto')
                    ->schema([
                        Select::make('brand_id')
                            ->label('Marca')
                            ->required()
                            ->relationship(
                                'brand',
                                'name',
                                modifyQueryUsing: function (Builder $query, ?Model $record) {
                                    if ($record && $record->brand_id) {
                                        return $query->where(function ($q) use ($record) {
                                            $q->where('active', 1)
                                                ->orWhere('id', $record->brand_id);
                                        });
                                    }
                                    return $query->where('active', 1);
                                }
                            )
                            ->options(
                                Brand::query()
                                    ->where('active', 1)
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->required() // Mantenemos el asterisco visual
                            ->rules($rules['brand_id'])
                            ->validationMessages($messages),

                        TextInput::make('title')
                            ->label('Título')
                            ->required() // Mantenemos el asterisco visual
                            ->rules($rules['title'])
                            ->validationMessages($messages),

                        TextInput::make('subtitle')
                            ->label('Subtítulo')
                            ->rules($rules['subtitle']),

                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required() // Mantenemos el asterisco visual
                            ->label('Categoría')
                            ->rules($rules['category_id']),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(5)
                            ->rules($rules['description']),
                    ])->columns(2),

                Section::make('Precios,Financiación Y Disponibilidad')
                    ->schema([
                        TextInput::make('stock')
                            ->label('Stock Del Producto')
                            ->numeric()
                            ->rules($rules['stock']),

                        TextInput::make('price')
                            ->label('Precio Base')
                            ->numeric()
                            ->prefix('$')
                            ->required() // asterisco visual
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Get $get, Set $set) => self::updatePrices($get, $set))
                            ->rules($rules['price'])
                            ->validationMessages($messages),

                        Toggle::make('on_sale')
                            ->label('¿En oferta?')
                            ->live()
                            ->afterStateUpdated(fn(Get $get, Set $set) => self::updatePrices($get, $set))
                            ->rules($rules['on_sale']),

                        TextInput::make('discount')
                            ->label('% Descuento')
                            ->numeric()
                            ->suffix('%')
                            ->visible(fn(Get $get) => $get('on_sale'))
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Get $get, Set $set) => self::updatePrices($get, $set))
                            ->rules($rules['discount'])
                            ->validationMessages($messages),

                        TextInput::make('sale_price')
                            ->placeholder(function (Get $get) {
                                $price = (float) $get('price');
                                $discount = (float) $get('discount');
                                if ($get('on_sale') && $discount > 0) {
                                    return '$' . number_format($price * (1 - ($discount / 100)), 2);
                                }
                                return 'N/A';
                            })
                            ->rules($rules['sale_price']),

                        TextInput::make('installments')
                            ->label('Cantidad de Cuotas')
                            ->numeric()
                            ->default(1)
                            ->live()
                            ->afterStateUpdated(fn(Get $get, Set $set) => self::updatePrices($get, $set))
                            ->rules($rules['installments']),

                        TextInput::make('installment_price')
                            ->label('Valor de cada Cuota')
                            ->numeric()
                            ->prefix('$')
                            ->readOnly()
                            ->extraAttributes(['class' => 'bg-gray-50'])
                            ->rules($rules['installment_price']),
                    ])->columns(3),

                // SECCIÓN 3: MULTIMEDIA (Ajustado a tu carpeta /public/images)
                Section::make('Imágenes del Producto')
                    ->schema([
                        FileUpload::make('image_1')
                            ->label('Imagen Principal')
                            ->image()
                            // Si estás creando (no hay registro), la hacemos obligatoria nativamente en Filament
                            ->required(fn($record) => $record === null)
                            ->maxSize(2048) // Reemplaza el max:2048 del request
                            ->disk('public')
                            ->directory('products/images') // Se guardará en storage/app/producs/images/
                            ->visibility('public')
                            ->preserveFilenames()
                            ->imageEditor(),

                        FileUpload::make('image_2')
                            ->label('Imagen Extra')
                            ->image()
                            ->maxSize(2048)
                            ->disk('public')
                            ->directory('products/images') //  Se guardará en storage/app/producs/images/
                            ->visibility('public')
                            ->preserveFilenames() // Opcional: mantiene el nombre original del archivo
                            ->imageEditor(),
                        FileUpload::make('image_3')
                            ->label('Imagen Extra 2')
                            ->image()
                            ->maxSize(2048)
                            ->disk('public') // Usamos el disco que creamos arriba
                            ->directory('products/images') // Se guardará en storage/app/producs/images/
                            ->visibility('public')
                            ->preserveFilenames() // Opcional: mantiene el nombre original del archivo
                            ->imageEditor(),
                    ])->columns(3),

                Section::make('Especificaciones')
                    ->schema([
                        KeyValue::make('specs')
                            ->label('Características Técnicas')
                            ->keyLabel('Propiedad (ej: Trastes)')
                            ->valueLabel('Valor (ej: 22)')
                            ->columnSpanFull()
                            ->rules($rules['specs']),
                    ]),
            ]);
    }
}
