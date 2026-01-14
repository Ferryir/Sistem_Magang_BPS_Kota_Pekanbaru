{{-- Success Toast --}}
@if (!empty(session('success')))
    <div id="toast-success"
        class="toast-hidden z-[1000] fixed top-3 right-3 flex items-center w-full max-w-xs md:max-w-sm p-4 mb-4 text-white bg-green-500 rounded-lg shadow-2xl
                translate-x-full opacity-0 transition-all duration-300"
        role="alert">
        <div
            class="inline-flex items-center justify-center flex-shrink-0 rounded-lg bg-green-500 text-green-800">
            <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">{{ Session::get('success.title') }}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 " data-dismiss-target="#toast-success" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
@endif

{{-- Error Toast --}}
@if (!empty(session('error')))
    <div id="toast-danger"
        class="toast-hidden z-[1000] fixed top-3 right-3 flex items-center w-full max-w-xs md:max-w-sm p-4 mb-4 text-white bg-red-600 rounded-lg shadow-2xl
                translate-x-full opacity-0 transition-all duration-300"
        role="alert">
        <div
            class="inline-flex items-center justify-center flex-shrink-0 rounded-lg bg-red-600 text-red-800">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
            </svg>
            <span class="sr-only">Error icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">{{ Session::get('error.title') }}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 " data-dismiss-target="#toast-danger" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
@endif

{{-- Warning Toast --}}
@if (!empty(session('warning')))
    <div id="toast-danger"
        class="toast-hidden z-[1000] fixed top-3 right-3 flex items-center w-full max-w-xs md:max-w-sm p-4 mb-4 text-white bg-amber-600 rounded-lg shadow-2xl
                translate-x-full opacity-0 transition-all duration-300"
        role="alert">
        <div
            class="inline-flex items-center justify-center flex-shrink-0 rounded-lg bg-amber-600 text-amber-800">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
            </svg>
            <span class="sr-only">Error icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">{{ Session::get('warning.title') }}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 " data-dismiss-target="#toast-danger" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const toasts = document.querySelectorAll('.toast-hidden');

    toasts.forEach(toast => {
        // Make the toast visible
        setTimeout(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
        }, 100); // Delay to start the animation

        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                toast.remove();
            }, 300); // Match this duration with CSS transition duration
        }, 5000);

        // Remove on close button click
        const closeButton = toast.querySelector('[data-dismiss-target]');
        if (closeButton) {
            closeButton.addEventListener('click', function () {
                toast.classList.remove('translate-x-0', 'opacity-100');
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 300); // Match this duration with CSS transition duration
            });
        }
    });
});

</script>
