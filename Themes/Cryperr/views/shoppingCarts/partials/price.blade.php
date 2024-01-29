<div class="price-block">
    @if(isset($price_sale) &&$price_sale > 0)
    <span class="old-price">{{ number_format($price_sale) }}đ</span>
    @endif
    @if(isset($price_member) && $price_member > 0)
    <span class="price"> {{ number_format($price_member) }}đ</span>
    @else
    <span class="price"> {{ number_format($price) }}đ</span>
    @endif
</div>