<h1>Đơn hàng của bạn đã được tạo thành công!</h1>
<p>Order Details:</p>
<ul>
    @foreach ($saleInvoiceDetails as $detail)
        Name<li>{{ $detail->saleInvoiceDetailProduct->name }} </li><br>
        Color<li>{{ $detail->saleInvoiceDetailColor->name }}</li><br>
        Size<li>{{ $detail->saleInvoiceDetailSize->name }}</li><br>
        Quantity<li>{{ $detail->quantity }}</li><br>
        Unit Price<li>{{ $detail->unit_price }}</li><br>
        Total <li>{{ $detail->price_total }}</li><br>
    @endforeach
</ul>
<h4>Thank you for your order!</h4>
