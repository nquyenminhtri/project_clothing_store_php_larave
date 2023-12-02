@php
    $adminAccount = session('adminAccount');
@endphp
@extends('layout')
@section('content')
    <div class="container">
        <h3 class="mt-4 mb-4">Create import invoice</h3>
        <form method="post" action="{{ route('import-invoice.handle-create') }}" class="mb-4">
            @csrf

            @isset($adminAccount)
                <div class="form-group row">
                    <div class="col-sm-10">
                        <label for="supplier_id">Importer : <h2>{{ $adminAccount->name }}</h2></label>
                        <input type="text" name="admin_id" id="admin_id" value="{{ $adminAccount->id }}"
                            class="form-control-sm" hidden>
                    </div>
                </div>
            @endisset
            <div class="form-group">
                <label for="supplier_id">Select Supplier:</label>
                <select name="supplier_id" id="supplier_id" class="form-control-sm" required>
                    @foreach ($supplierList as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="import_date">Import date:</label>
                <input type="date" name="import_date" id="import_date" class="form-control-sm">
            </div>

            <h4 class="mt-4 mb-3">Product</h4>
            <div class="form-group">
                <label for="product">Select product:</label>
                <select id="product_id" class="form-control-sm">
                    @foreach ($productList as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Size</label>
                <div class="col-sm-10">
                    <select name="size_id" id="size_id" class="form-control">
                        @foreach ($sizeList as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Color</label>
                <div class="col-sm-10">
                    <select name="color_id" id="color_id" class="form-control">
                        @foreach ($colorList as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Material</label>
                <div class="col-sm-10">
                    <select name="material_id" id="material_id" class="form-control">
                        @foreach ($materialList as $material)
                            <option value="{{ $material->id }}">{{ $material->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="quantity">Import Quantity</label>
                <input type="number" id="quantity" name="quantity" value="0" class="form-control-sm">
            </div>
            <div class="form-group">
                <label for="import_price">Import price</label>
                <input type="number" id="import_price" name="import_price" value="0" class="form-control-sm">
            </div>
            <div class="form-group">
                <label for="sale_price">Sale price</label>
                <input type="number" id="sale_price" name="sale_price" value="0" class="form-control-md">
            </div>
            <button type="button" id="btn-add" class="btn btn-primary">Add</button>

            <table id="tb-list-product" class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Product name</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Material</th>
                        <th>Quantity</th>
                        <th>Import price</th>
                        <th>Sale price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <div class="form-group">
                <label for="total_amount">Total:</label>
                <input type="number" name="total_amount" id="total_amount" readonly class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>

@section('page-js')
    @parent {{-- Giữ lại nội dung JS từ layout --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#btn-add").click(function() {
                var number = $('#tb-list-product tbody tr').length + 1;
                var productName = $("#product_id").find(":selected").text();
                var productId = $("#product_id").find(":selected").val();
                var sizeName = $('#size_id').find(':selected').text();
                var sizeId = $('#size_id').find(':selected').val();
                var colorName = $('#color_id').find(':selected').text();
                var colorId = $('#color_id').find(':selected').val();
                var materialName = $('#material_id').find(':selected').text();
                var materialId = $('#material_id').find(':selected').val();
                var quantity = $("#quantity").val();
                var importPrice = $("#import_price").val();
                var salePrice = $("#sale_price").val();
                var total = quantity * importPrice;
                var row = `<tr>
        <td>${number}</td>
        <td>${productName}<input type="hidden" name="productID[]" value="${productId}"/></td>
        <td>${sizeName}<input type="hidden" name="sizeID[]" value="${sizeId}"/></td>
        <td>${colorName}<input type="hidden" name="colorID[]" value="${colorId}"/></td>
        <td>${materialName}<input type="hidden" name="materialID[]" value="${materialId}"/></td>
        <td>${quantity}<input type="hidden" name="quantity[]" value="${quantity}"/></td>
        <td>${importPrice}<input type="hidden" name="importPrice[]" value="${importPrice}"/></td>
        <td>${salePrice}<input type="hidden" name="salePrice[]" value="${salePrice}"/></td>
        <td>${total}<input type="hidden" name="total[]" value="${total}"/></td>
    </tr>`;
                $("#tb-list-product").find('tbody').append(row);
                // Cập nhật ngày nhập và tổng tiền
                var importDate = $("#import_date").val();
                var totalAmount = calculateTotalAmount();
                $("#import_date").val(importDate); // Cập nhật ngày nhập
                $("#total_amount").val(totalAmount); // Cập nhật tổng tiền
            });

            // Hàm tính tổng tiền
            function calculateTotalAmount() {
                var totalAmount = 0;
                $('#tb-list-product tbody tr').each(function() {
                    var total = $(this).find('input[name="total[]"]').val();
                    totalAmount += parseInt(total);
                });
                console.log("Total Amount:", totalAmount);
                return totalAmount;
            }
        });
    </script>
@endsection
@endsection
