<button type="submit" class="btn btn-success submit-btn fw-bold btn-lg {{ $class ?? '' }}"
    @unless ($validNot)
onclick="this.disabled=true; this.form.submit();"
@endunless
    {{ $validNot }}>
    {{ !empty($btnName) ? $btnName : 'Submit' }}
</button>
