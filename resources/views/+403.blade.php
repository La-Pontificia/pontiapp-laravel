<div class="flex flex-col flex-grow h-full w-full text-black">
    <div class="w-full grid h-full place-content-center">
        <div class="text-center space-y-1">
            <img src="/empty-meetingList.webp" class="w-20 mx-auto" alt="">
            <h2 class="text-lg font-semibold">
                403 | Acceso denegado
            </h2>
            <p class="text-sm max-w-[35ch] text-stone-600">
                {{ isset($message) ? $message : '' }}
            </p>
        </div>
    </div>
    <footer class="p-4 text-center text-xs text-stone-600">
        Developed by <a href="https://daustinn.com" target="_blank" rel="noopener noreferrer"
            class=" font-semibold hover:underline">Daustinn</a> &copy; 2024
    </footer>
</div>
