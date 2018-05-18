<div class="tr">
    <div class="th">
        Adres toevoegen
    </div>
</div>
<div class="tr">
    <div class="td label">
        Vestiging
    </div>
    <div class="td">
        <input type="text" name="address[establishment]" value="{{ old('address.establishment') }}">
    </div>
</div>
<div class="tr">
    <div class="td label">
        Straatnaam
    </div>
    <div class="td">
        <input type="text" name="address[street]" value="{{ old('address.street') }}">
    </div>
</div>
<div class="tr">
    <div class="td label">
        Vestigings nummer
    </div>
    <div class="td">
        <input type="number" name="address[number]" value="{{ old('address.name') }}">
    </div>
    <div class="td label">
        Toevoeging
    </div>
    <div class="td">
        <input type="text" name="address[affix]" value="{{ old('address.affix') }}">
    </div>
</div>
<div class="tr">
    <div class="td label">
        Postcode
    </div>
    <div class="td">
        <input type="text" name="address[zip]" value="{{ old('address.zip') }}">
    </div>
</div>