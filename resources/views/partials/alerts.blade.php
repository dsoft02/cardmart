@php
    /**
     * Normalize all alert sources into a single array
     * Each alert = [type, message, title]
     */

    $alerts = [];

    // 1️⃣ Multiple flashes
    foreach ((array) session('flashes', []) as $flash) {
        if (!empty($flash['message'])) {
            $alerts[] = [
                'type' => $flash['type'] ?? 'info',
                'title' => $flash['title'] ?? null,
                'message' => $flash['message'],
            ];
        }
    }

    // 2️⃣ Single flash
    if (session('flash')) {
        $flash = session('flash');
        $alerts[] = [
            'type' => $flash['type'] ?? 'info',
            'title' => $flash['title'] ?? null,
            'message' => $flash['message'] ?? '',
        ];
    }

    // 3️⃣ Shorthand session keys
    foreach (['success', 'error', 'info', 'warning', 'danger'] as $type) {
        if (session()->has($type)) {
            $alerts[] = [
                'type' => $type === 'error' ? 'danger' : $type,
                'title' => ucfirst($type),
                'message' => session($type),
            ];
        }
    }

    // 4️⃣ Validation errors (single alert with list)
    if ($errors->any()) {
        $alerts[] = [
            'type' => 'danger',
            'title' => 'Validation Error',
            'message' => $errors->all(),
        ];
    }
@endphp

@foreach ($alerts as $alert)
    <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show" role="alert">
        @if (!empty($alert['title']))
            <div class="fw-semibold mb-1">{{ $alert['title'] }}</div>
        @endif

        @if (is_array($alert['message']))
            <ul class="mb-0 ps-3">
                @foreach ($alert['message'] as $msg)
                    <li>{{ $msg }}</li>
                @endforeach
            </ul>
        @else
            {{ $alert['message'] }}
        @endif

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endforeach
