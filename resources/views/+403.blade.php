<div class="flex flex-col flex-grow h-full w-full text-black">
    <div class="w-full grid h-full place-content-center">
        <div class="text-center space-y-3">
            <h1 class="text-3xl font-serif tracking-tight">Error 401</h1>
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
