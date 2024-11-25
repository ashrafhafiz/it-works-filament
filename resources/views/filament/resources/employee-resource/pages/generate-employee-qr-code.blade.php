<x-filament-panels::page>
    {!! QrCode::size(400)->color(0, 0, 255)->margin(1)->generate($record) !!}
</x-filament-panels::page>
