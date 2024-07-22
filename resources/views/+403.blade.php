<div class="flex flex-col flex-grow h-full w-full text-black">
    <div class="w-full grid h-full place-content-center">
        <div class="text-center space-y-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" class="mx-auto" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-unplug">
                <path d="m19 5 3-3" />
                <path d="m2 22 3-3" />
                <path d="M6.3 20.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6-2.3 2.3a2.4 2.4 0 0 0 0 3.4Z" />
                <path d="M7.5 13.5 10 11" />
                <path d="M10.5 16.5 13 14" />
                <path d="m12 6 6 6 2.3-2.3a2.4 2.4 0 0 0 0-3.4l-2.6-2.6a2.4 2.4 0 0 0-3.4 0Z" />
            </svg>
            <p class="text-sm max-w-[35ch] text-stone-600">
                {{ $message ?? 'No tienes permisos para acceder a esta página.' }}
            </p>
        </div>
    </div>
    <footer class="p-4 text-center text-xs text-stone-600">
        Developed by <a href="https://daustinn.com" target="_blank" rel="noopener noreferrer"
            class=" font-semibold hover:underline">Daustinn</a> &copy; 2024
    </footer>
</div>
