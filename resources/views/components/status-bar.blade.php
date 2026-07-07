<div {{ $attributes->class(['rounded-lg bg-custom-200 p-4 ring-1 ring-custom-400/60 dark:bg-custom-400/30 dark:ring-custom-400/40'])->style([
    Illuminate\Support\Arr::toCssStyles([
        \Filament\Support\get_color_css_variables(
            $status->getColor(),
            shades: [200, 400, 800],
        ),
    ]),
]) }}>
    <div class="flex items-center gap-3">
        @svg($status->getIcon(), 'size-6 shrink-0 text-custom-800 dark:text-custom-200')
        <p class="text-base font-semibold tracking-tight text-custom-800 dark:text-custom-200 sm:text-lg">{{ $status->getLabel() }}</p>
    </div>
</div>
