@if ($componentGroups->isNotEmpty() || $ungroupedComponents->isNotEmpty())
    <div class="group relative overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-zinc-900/10 dark:bg-zinc-900 dark:ring-white/15">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent/40 to-transparent" aria-hidden="true"></div>

        <ul class="divide-y divide-zinc-900/10 dark:divide-white/15">
            @foreach ($componentGroups as $componentGroup)
                <x-cachet::component-group :component-group="$componentGroup" />
            @endforeach

            @foreach ($ungroupedComponents as $component)
                <x-cachet::component :component="$component" />
            @endforeach
        </ul>
    </div>
@endif
