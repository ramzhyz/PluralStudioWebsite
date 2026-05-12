@extends('layouts.app')

@section('title', 'Booking — Plural Studio')

@section('content')

    {{-- FULL PAGE BOOKING --}}
    <section style="position:relative; width:100%; min-height:100vh; overflow:hidden; background:#0d0a08; display:flex; align-items:center; justify-content:center;">

        {{-- Background image --}}
        <img src="{{ asset('images/booking-bg.jpg') }}" alt="Booking"
            style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0.55;">
        <div style="position:absolute; inset:0; background:rgba(0,0,0,0.25);"></div>

        {{-- Form container --}}
        <div style="position:relative; z-index:10; width:100%; max-width:1280px; padding:8rem 2rem 4rem; text-align:center;">

            {{-- Success message --}}
            @if(session('success'))
            <div style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); padding:0.85rem 1.5rem; margin-bottom:2rem; color:#fff; font-size:0.72rem; letter-spacing:0.05em; backdrop-filter:blur(8px);">
                {{ session('success') }}
            </div>
            @endif

            {{-- Title --}}
            <h1 style="font-family: 'DM Sans', sans-serif !important; font-size: 1.5rem !important; font-weight: 300; Color:#ffff; margin-bottom: 1rem;">
                Booking
            </h1>
            <p style="font-size:0.72rem; line-height:1.85; color:rgba(255,255,255,0.75); margin-bottom:2.5rem; max-width:720px; margin-left:auto; margin-right:auto;">
                A private, controlled space for up to 3 people, featuring an infrared sauna and ice bath. Designed for reset, contrast, and focused 
                wellness content in a minimal, distraction-free environment.
            </p>

            {{-- Form --}}
            <form action="{{ route('booking.store') }}" method="POST">
                @csrf

                {{-- Row 1: Name, Email, Space --}}
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:0.6rem; margin-bottom:0.6rem;">
                    <div>
                        <input type="text" name="name" placeholder="Name" value="{{ old('name') }}"
                            style="width:100%; padding:0.9rem 1.1rem; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); color:#fff; font-size:0.72rem; font-family:'DM Sans',sans-serif; letter-spacing:0.04em; outline:none; backdrop-filter:blur(6px); border-radius:6px; transition:border 0.2s;"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.6)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.2)'">
                        @error('name')<p style="font-size:0.6rem; color:#ffaaaa; text-align:left; margin-top:0.25rem;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                            style="width:100%; padding:0.9rem 1.1rem; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); color:#fff; font-size:0.72rem; font-family:'DM Sans',sans-serif; letter-spacing:0.04em; outline:none; backdrop-filter:blur(6px); border-radius:6px; transition:border 0.2s;"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.6)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.2)'">
                        @error('email')<p style="font-size:0.6rem; color:#ffaaaa; text-align:left; margin-top:0.25rem;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <select name="space"
                            style="width:100%; padding:0.9rem 1.1rem; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); color:#fff; font-size:0.72rem; font-family:'DM Sans',sans-serif; letter-spacing:0.04em; outline:none; backdrop-filter:blur(6px); border-radius:6px; transition:border 0.2s; appearance:none; cursor:pointer;"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.6)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.2)'">
                            @foreach($spaces as $space)
                            <option value="{{ $space->name }}" {{ old('space') == $space->name ? 'selected' : '' }} 
                                style="background:#333; color:#fff;">
                                {{ $space->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('space')<p style="font-size:0.6rem; color:#ffaaaa; text-align:left; margin-top:0.25rem;">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Row 2: Date, Whatsapp, Duration --}}
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:0.6rem; margin-bottom:0.6rem;">
                    <div>
                        <input type="datetime-local" name="booking_date" 
                            id="booking_date"
                            placeholder="Booking Date & Time"
                            value="{{ old('booking_date') }}"
                            min="{{ now()->format('Y-m-d') }}T08:00"
                            max="{{ now()->addYear()->format('Y-m-d') }}T16:00"
                            style="width:100%; padding:0.9rem 1.1rem; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); color:#fff; font-size:0.72rem; font-family:'DM Sans',sans-serif; letter-spacing:0.04em; outline:none; backdrop-filter:blur(6px); border-radius:6px; transition:border 0.2s; color-scheme:dark;"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.6)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.2)'"
                            onchange="updateDuration()">
                        @error('booking_date')<p style="font-size:0.6rem; color:#ffaaaa; text-align:left; margin-top:0.25rem;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <input type="text" name="whatsapp" placeholder="Whatsapp Number" value="{{ old('whatsapp') }}"
                            style="width:100%; padding:0.9rem 1.1rem; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); color:#fff; font-size:0.72rem; font-family:'DM Sans',sans-serif; letter-spacing:0.04em; outline:none; backdrop-filter:blur(6px); border-radius:6px; transition:border 0.2s;"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.6)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.2)'">
                        @error('whatsapp')<p style="font-size:0.6rem; color:#ffaaaa; text-align:left; margin-top:0.25rem;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <select name="duration" id="duration"
                            style="width:100%; padding:0.9rem 1.1rem; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); color:#fff; font-size:0.72rem; font-family:'DM Sans',sans-serif; letter-spacing:0.04em; outline:none; backdrop-filter:blur(6px); border-radius:6px; transition:border 0.2s; appearance:none; cursor:pointer;"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.6)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.2)'">
                            <option value="" disabled selected style="background:#333;">Duration</option>
                            <option value="1 Hour"    style="background:#333;">1 Hour</option>
                            <option value="2 Hours"   style="background:#333;">2 Hours</option>
                            <option value="3 Hours"   style="background:#333;">3 Hours</option>
                            <option value="4 Hours"   style="background:#333;">4 Hours</option>
                            <option value="5 Hours"   style="background:#333;">5 Hours</option>
                            <option value="6 Hours"   style="background:#333;">6 Hours</option>
                            <option value="7 Hours"   style="background:#333;">7 Hours</option>
                            <option value="Half Day (4 Hours)" style="background:#333;">Half Day (4 Hours)</option>
                            <option value="Full Day (8 Hours)" style="background:#333;">Full Day (8 Hours)</option>
                        </select>
                        @error('duration')<p style="font-size:0.6rem; color:#ffaaaa; text-align:left; margin-top:0.25rem;">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Add-On --}}
                <div style="margin-bottom:0.6rem;">
                    <textarea name="addon" placeholder="Add-On" rows="4"
                        style="width:100%; padding:0.9rem 1.1rem; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); color:#fff; font-size:0.72rem; font-family:'DM Sans',sans-serif; letter-spacing:0.04em; outline:none; backdrop-filter:blur(6px); border-radius:6px; transition:border 0.2s; resize:none;"
                        onfocus="this.style.borderColor='rgba(255,255,255,0.6)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.2)'">{{ old('addon') }}</textarea>
                </div>

                {{-- Notes --}}
                <div style="margin-bottom:1.25rem;">
                    <textarea name="notes" placeholder="Notes" rows="4"
                        style="width:100%; padding:0.9rem 1.1rem; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); color:#fff; font-size:0.72rem; font-family:'DM Sans',sans-serif; letter-spacing:0.04em; outline:none; backdrop-filter:blur(6px); border-radius:6px; transition:border 0.2s; resize:none;"
                        onfocus="this.style.borderColor='rgba(255,255,255,0.6)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.2)'">{{ old('notes') }}</textarea>
                </div>

                {{-- Submit --}}
                <button type="submit" style="
                    width:100%; padding:1rem;
                    background:rgba(255,255,255,0.2);
                    border:1px solid rgba(255,255,255,0.35);
                    color:#fff; font-size:0.72rem; font-family:'DM Sans',sans-serif;
                    letter-spacing:0.18em; text-transform:uppercase;
                    cursor:pointer; backdrop-filter:blur(6px); border-radius:6px;
                    transition:background 0.25s;
                " onmouseover="this.style.background='rgba(255,255,255,0.35)'"
                   onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                    Submit Booking
                </button>

                {{-- Have a question --}}
                <p style="margin-top:1rem; font-size:0.68rem; color:rgba(255,255,255,0.6);">
                    <a href="https://wa.me/628123456789" target="_blank"
                        style="color:rgba(255,255,255,0.6); text-decoration:underline; transition:color 0.2s;"
                        onmouseover="this.style.color='#fff'"
                        onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                        Have a Question ? Click Here
                    </a>
                </p>
            </form>
        </div>
    </section>

    @push('styles')
        <style>
            ::placeholder { color: rgba(255,255,255,0.45) !important; }
            input[type="datetime-local"]::-webkit-calendar-picker-indicator { filter: invert(1); opacity: 0.6; cursor: pointer; }
        </style>
    @endpush

    @push('scripts')
        <script>
        function updateDuration() {
            const dateInput = document.getElementById('booking_date');
            const durationSelect = document.getElementById('duration');
            
            if (!dateInput.value) return;
            
            const date = new Date(dateInput.value);
            const hour = date.getHours();
            const minute = date.getMinutes();
            
            // Validasi jam 08:00 - 16:00
            if (hour < 8) {
                Swal.fire({
                    title: 'Booking Time Invalid',
                    text: 'Booking time must be between 08:00 and 16:00',
                    icon: 'warning',
                    background: '#1a1a1a', // Warna dark sesuai web kamu
                    color: '#ffffff',
                    confirmButtonColor: '#4f46e5', // Warna indigo/primary Tailwind
                    confirmButtonText: 'Understood'
                });
                dateInput.value = '';
                return;
            }

            if (hour > 16 || (hour === 16 && minute > 0)) {
                Swal.fire({
                    title: 'Too Late',
                    text: 'Latest booking start time is 16:00',
                    icon: 'error',
                    background: '#1a1a1a',
                    color: '#ffffff',
                    confirmButtonColor: '#4f46e5',
                    confirmButtonText: 'Okay'
                });
                dateInput.value = '';
                return;
            }

            // Hitung max jam yang tersisa sebelum jam 17:00
            const maxHours = 17 - hour - (minute > 0 ? 1 : 0);

            // Reset dan rebuild options
            durationSelect.innerHTML = '<option value="" disabled selected style="background:#333;">Duration</option>';

            const durations = [
                { value: '1 Hour',             hours: 1,  label: '1 Hour' },
                { value: '2 Hours',            hours: 2,  label: '2 Hours' },
                { value: '3 Hours',            hours: 3,  label: '3 Hours' },
                { value: '4 Hours',            hours: 4,  label: '4 Hours' },
                { value: '5 Hours',            hours: 5,  label: '5 Hours' },
                { value: '6 Hours',            hours: 6,  label: '6 Hours' },
                { value: '7 Hours',            hours: 7,  label: '7 Hours' },
                { value: 'Half Day (4 Hours)', hours: 4,  label: 'Half Day (4 Hours)' },
                { value: 'Full Day (8 Hours)', hours: 8,  label: 'Full Day (8 Hours)' },
            ];

            // Filter duplikat hours dan yang melebihi maxHours
            const seen = new Set();
            durations.forEach(d => {
                if (d.hours <= maxHours && !seen.has(d.value)) {
                    seen.add(d.value);
                    const opt = document.createElement('option');
                    opt.value = d.value;
                    opt.text = d.label;
                    opt.style.background = '#333';
                    durationSelect.appendChild(opt);
                }
            });
        }
        </script>
    @endpush
@endsection

