<th>
    <a href="{{ request()->fullUrlWithQuery(['sort' => $column, 'direction' => $sort === $column && $direction === 'asc' ? 'desc' : 'asc']) }}" class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
        {{ $label }}
        @if ($sort === $column)
            @if ($direction === 'asc')
                <i class="fa fa-sort-up"></i>
            @else
                <i class="fa fa-sort-down"></i>
            @endif
        @else
            <i class="fa fa-sort text-muted"></i>
        @endif
    </a>
</th>
