<?php

namespace App\Filament\Resources\Brands\Pages;

use App\Filament\Resources\Brands\BrandResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    // En EditBrand.php
    protected function getHeaderActions(): array
    {
        return [
            Action::make('verWeb')
                ->label('Ver en tienda')
                ->color('gray')
                ->icon('heroicon-o-eye')
                //->url(fn() => route('brands.show', $this->record))
                ->openUrlInNewTab(),

            DeleteAction::make(), // El botón de borrar estándar
        ];
    }
}
