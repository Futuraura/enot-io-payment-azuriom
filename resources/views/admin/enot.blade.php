<div class="row g-3">
    <div class="mb-3 col-md-6">
        <label class="form-label" for="keyInput">{{ trans('shop::admin.gateways.private-key') }}</label>
        <input type="text" class="form-control @error('private-key') is-invalid @enderror" id="keyInput" name="private-key" value="{{ old('private-key', $gateway->data['private-key'] ?? '') }}" required>

        @error('private-key')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="mb-3 col-md-6">
        <label class="form-label" for="keyInput">{{ trans('enot::messages.private-key-2') }}</label>
        <input type="text" class="form-control @error('private-key-2') is-invalid @enderror" id="keyInput" name="private-key-2" value="{{ old('private-key-2', $gateway->data['private-key-2'] ?? '') }}" required>

        @error('private-key-2')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label class="form-label" for="keyInput">{{ trans('shop::admin.gateways.project-id') }}</label>
        <input type="text" class="form-control @error('project-id') is-invalid @enderror" id="keyInput" name="project-id" value="{{ old('project-id', $gateway->data['project-id'] ?? '') }}" required>

        @error('project-id')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label class="form-label" for="keyInput">{{ trans('enot::messages.desc') }}</label>
        <input type="text" class="form-control @error('desc') is-invalid @enderror" id="keyInput" name="desc" value="{{ old('desc', $gateway->data['desc'] ?? '') }}" required>

        @error('desc')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label class="form-label" for="keyInput">{{ trans('enot::messages.color') }}</label>
        <select class="form-control @error('color') is-invalid @enderror" id="keyInput" name="color" value="{{ old('color', $gateway->data['color'] ?? '') }}" required> 
            <option value="1">Белый</option> 
            <option value="2">Чёрный</option> 
        </select>

        @error('color')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="alert alert-info">
    <p>
        <i class="bi bi-info-circle"></i>
        @lang('enot::messages.setup', [
            'success' => '<code>'.route('shop.payments.success', 'enot').'</code>',
            'notification' => '<code>'.route('shop.payments.notification', 'enot').'</code>',
            'failure' => '<code>'.route('shop.payments.failure', 'enot').'</code>',
        ])
    </p>

    <a class="btn btn-primary mb-3" target="_blank" href="https://cabinet.enot.io" role="button" >
        <i class="bi bi-box-arrow-in-right"></i> {{ trans('enot::messages.keys') }}
    </a>
</div>
