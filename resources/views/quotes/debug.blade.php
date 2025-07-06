<h1>Debug Quote Create</h1>
<p>Product ID: {{ $product->id ?? 'NOT SET' }}</p>
<p>Product Name: {{ $product->name ?? 'NOT SET' }}</p>
<p>User Role: {{ Auth::user()->roles->pluck('name')->implode(', ') }}</p>