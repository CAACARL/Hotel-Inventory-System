<option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
    @if($category->level == 0)
        {{ $category->name }}
    @else
        {{ str_repeat('│  ', $category->level - 1) }}├─ {{ $category->name }}
    @endif
</option>