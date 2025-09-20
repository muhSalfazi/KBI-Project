@extends('layouts.app')
@section('title', '404')

@section('content')
    <style>
        .animated-image {
            width: 300px;
            height: auto;
            animation: bounce 2s ease infinite, fadeInScale 2s ease forwards;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .error-404 {
            padding-top: 15vh;
        }

        h2 {
            margin-top: 20px;
            font-size: 1.5rem;
        }

        .btn {
            margin-top: 20px;
            padding: 10px 20px;
        }

        /* Countdown Timer Styles */
        #countdown {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ff0000;
            margin-top: 20px;
        }
    </style>

    <section
        class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center text-center fade-in">
        <img src="{{ asset('assets/img/404.svg') }}" class="animated-image img-fluid py-3" alt="Page Not Found">
        <h2>Halaman yang Anda cari tidak ada.</h2>
        <a class="btn btn-primary" href="javascript:history.back()">Kembali ke halaman sebelumnya</a>
        <p id="countdown-text" class="text-center">Logout otomatis dalam</p>
        <div id="countdown" class="countdown-circle d-flex justify-content-center align-items-center">
            <span id="countdown-number">10</span> <!-- Countdown Timer -->
        </div>
    </section>

   <style>
    /* Countdown Timer Styles */
    #countdown-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    #countdown-text {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .countdown-circle {
        width: 100px;
        height: 100px;
        border: 5px solid #ff0000;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 2rem;
        font-weight: bold;
        color: #ff0000;
        background: #f8f9fa;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    #countdown-number {
        animation: pulse 1s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
        }
    }
</style>

<script>
    // Timer logic
    const countdownElement = document.getElementById('countdown-number');
    const countdownText = document.getElementById('countdown-text');
    let timer = 10; // Initial countdown value in seconds

    const countdownInterval = setInterval(() => {
        timer--; // Decrement timer
        countdownElement.textContent = timer;

        if (timer <= 0) {
            clearInterval(countdownInterval); // Stop the countdown

            // Perform logout by sending a POST request to the logout route
            fetch("{{ route('logout') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url; // Redirect to the login page after logout
                    }
                });
        }
    }, 1000); // Update every 1 second
</script>
@endsection
