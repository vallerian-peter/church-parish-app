
@if (session()->has('success') || session()->has('error'))
    <div id="sessionMessage" class="alert-container d-flex align-items-center justify-content-end"
        style="position: absolute; top: 25px; right: 20px; z-index: 5000;">
        @if (session()->has('success'))
            <div class="alert alert-success d-flex align-items-center w-100" role="alert">
                <i class="bi bi-check2-circle text-success fw-bold"></i>
                <div class="mx-3" style="font-size: 15px;">
                    <b>Hongera! </b> {{ session('success') }}
                </div>
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger d-flex align-items-center w-100" role="alert">
                <i class="bi bi-x-circle text-danger fw-bold"></i>
                <div class="mx-3" style="font-size: 15px;">
                    <b>Tatizo! </b> {{ session('error') }}
                </div>
            </div>
        @endif
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's a session message
        const messageElement = document.getElementById('sessionMessage');
        if (messageElement) {
            // Set timeout for the slide-up and fade effect (3 seconds in this example)
            setTimeout(function() {
                messageElement.style.transition = "all 1s ease-out";
                messageElement.style.transform = "translateY(-50px)"; // Slide up effect
                messageElement.style.opacity = 0; // Fade out effect

                // Remove the element after the slide-up and fade-out
                setTimeout(function() {
                    messageElement.remove();
                }, 1000); // match this duration with the transition time
            }, 5000); // Time before it starts sliding and fading out (3 seconds)
        }
    });
</script>
