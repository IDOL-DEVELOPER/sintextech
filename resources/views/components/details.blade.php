<div>
    <ul class="p-0 d-flex flex-wrap font-bold">
        <li class="mx-4"><strong>Manufacturer:</strong> {{ $row->varient->model->manufacturer->name ?? 'N/A' }}</li>
        <li class="mx-4"><strong>Model:</strong> {{ $row->varient->model->model ?? 'N/A' }}</li>
        <li class="mx-4"><strong>Varient:</strong> {{ $row->varient->varient ?? 'N/A' }}</li>
        <li class="mx-4"><strong>Product Type:</strong> {{ $row->product->type ?? 'N/A' }}</li>
        <li class="mx-4"><strong>Product Name:</strong> {{ $row->product->name ?? 'N/A' }}</li>
        <li class="mx-4"><strong>Price:</strong> {{ $row->mrp ?? 'N/A' }}</li>
       
    </ul>
</div>
