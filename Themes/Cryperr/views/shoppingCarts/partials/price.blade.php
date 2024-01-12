<div class="price-block">
    @if(isset($price_sale) &&$price_sale > 0)
    <span class="old-price">{{ number_format($price_sale) }}đ</span>
    @endif
    <span class="price"> {{ number_format($price) }}đ</span>
</div>