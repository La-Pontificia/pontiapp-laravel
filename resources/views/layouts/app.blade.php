@extends('layouts.headers')

@section('app')
    <div style="" id="app" class="h-screen">
        @guest
            @if (Route::has('login'))
            @endif
        @else
            {{-- <nav class="fixed pl-[250px] border-b dark:border-gray-700 w-full border-gray-200 bg-white backdrop-blur-sm z-30">
                <div class=" flex w-full gap-3 px-4 items-center h-16">
                    <button data-drawer-target="cta-button-sidebar" data-drawer-toggle="cta-button-sidebar"
                        aria-controls="cta-button-sidebar" type="button"
                        class="inline-flex items-center p-2 mt-2  text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-100 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>

                    <div class="flex ml-auto items-center md:order-2">
                        <button type="button"
                            class="flex  text-sm bg-gray-100 w-full p-2 items-center gap-2 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                            data-dropdown-placement="bottom">
                            <img class="w-9 h-8 rounded-full" src="https://cataas.com/cat" alt="user photo">
                            <span class="font-medium">{{ Auth::user()->name }}</span>
                        </button>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="user-dropdown">
                            <div class="px-4 py-3">
                                <span class="block text-sm text-gray-900 dark:text-white">Bonnie Green</span>
                                <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">name@flowbite.com</span>
                            </div>
                            <ul class="py-2" aria-labelledby="user-menu-button">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Cerrar
                                        sesión</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav> --}}
            <aside id="cta-button-sidebar"
                class="fixed top-0 left-0 z-40 w-[250px] h-screen transition-transform -translate-x-full sm:translate-x-0"
                aria-label="Sidebar">
                <div class="h-full px-3 py-5 pt-2 flex flex-col overflow-y-auto bg-sky-950 shadow-lg">
                    <a href="/" class="flex justify-center items-center">
                        <img src="/elp.gif" class="w-32" alt="Flowbite Logo" />
                    </a>
                    <ul class="h-full flex mt-2 flex-col font-medium text-neutral-500">
                        <li class="">
                            <button type="button" aria-expanded="{{ request()->is('me*') ? 'true' : 'false' }}"
                                class="flex items-center aria-[expanded=true]:bg-gray-200 aria-[expanded=true]:rounded-b-none rounded-xl w-full p-2 text-base text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                                <div class="w-[35px] h-[35px] rounded-full overflow-hidden">
                                    <img class="object-cover w-full h-full" src="https://cataas.com/cat" alt="user photo">
                                </div>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">Personal</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <ul id="dropdown-example" class=" bg-gray-200 rounded-xl rounded-t-none p-2 pl-5">
                                @if (
                                    $a_objetivo &&
                                        ($a_objetivo->crear == 1 ||
                                            $a_objetivo->leer == 1 ||
                                            $a_objetivo->eliminar == 1 ||
                                            $a_objetivo->actualizar == 1))
                                    <li>
                                        <a href="/me/eda"
                                            class="flex gap-2 text-gray-900 {{ request()->is('me/eda') ? 'bg-gray-800 text-white' : 'hover:bg-gray-100' }} items-center w-full p-2  transition duration-75 rounded-lg group">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.5 2C8.67157 2 8 2.67157 8 3.5V4.5C8 5.32843 8.67157 6 9.5 6H14.5C15.3284 6 16 5.32843 16 4.5V3.5C16 2.67157 15.3284 2 14.5 2H9.5Z"
                                                    fill="currentColor"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M6.5 4.03662C5.24209 4.10719 4.44798 4.30764 3.87868 4.87694C3 5.75562 3 7.16983 3 9.99826V15.9983C3 18.8267 3 20.2409 3.87868 21.1196C4.75736 21.9983 6.17157 21.9983 9 21.9983H15C17.8284 21.9983 19.2426 21.9983 20.1213 21.1196C21 20.2409 21 18.8267 21 15.9983V9.99826C21 7.16983 21 5.75562 20.1213 4.87694C19.552 4.30764 18.7579 4.10719 17.5 4.03662V4.5C17.5 6.15685 16.1569 7.5 14.5 7.5H9.5C7.84315 7.5 6.5 6.15685 6.5 4.5V4.03662ZM7 9.75C6.58579 9.75 6.25 10.0858 6.25 10.5C6.25 10.9142 6.58579 11.25 7 11.25H7.5C7.91421 11.25 8.25 10.9142 8.25 10.5C8.25 10.0858 7.91421 9.75 7.5 9.75H7ZM10.5 9.75C10.0858 9.75 9.75 10.0858 9.75 10.5C9.75 10.9142 10.0858 11.25 10.5 11.25H17C17.4142 11.25 17.75 10.9142 17.75 10.5C17.75 10.0858 17.4142 9.75 17 9.75H10.5ZM7 13.25C6.58579 13.25 6.25 13.5858 6.25 14C6.25 14.4142 6.58579 14.75 7 14.75H7.5C7.91421 14.75 8.25 14.4142 8.25 14C8.25 13.5858 7.91421 13.25 7.5 13.25H7ZM10.5 13.25C10.0858 13.25 9.75 13.5858 9.75 14C9.75 14.4142 10.0858 14.75 10.5 14.75H17C17.4142 14.75 17.75 14.4142 17.75 14C17.75 13.5858 17.4142 13.25 17 13.25H10.5ZM7 16.75C6.58579 16.75 6.25 17.0858 6.25 17.5C6.25 17.9142 6.58579 18.25 7 18.25H7.5C7.91421 18.25 8.25 17.9142 8.25 17.5C8.25 17.0858 7.91421 16.75 7.5 16.75H7ZM10.5 16.75C10.0858 16.75 9.75 17.0858 9.75 17.5C9.75 17.9142 10.0858 18.25 10.5 18.25H17C17.4142 18.25 17.75 17.9142 17.75 17.5C17.75 17.0858 17.4142 16.75 17 16.75H10.5Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <span>
                                                Edas
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/me/eda"
                                            class="flex gap-2 text-gray-900 {{ request()->is('me/eda') ? 'bg-gray-800 text-white' : 'hover:bg-gray-100' }} items-center w-full p-2  transition duration-75 rounded-lg group">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.5 2C8.67157 2 8 2.67157 8 3.5V4.5C8 5.32843 8.67157 6 9.5 6H14.5C15.3284 6 16 5.32843 16 4.5V3.5C16 2.67157 15.3284 2 14.5 2H9.5Z"
                                                    fill="currentColor"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M6.5 4.03662C5.24209 4.10719 4.44798 4.30764 3.87868 4.87694C3 5.75562 3 7.16983 3 9.99826V15.9983C3 18.8267 3 20.2409 3.87868 21.1196C4.75736 21.9983 6.17157 21.9983 9 21.9983H15C17.8284 21.9983 19.2426 21.9983 20.1213 21.1196C21 20.2409 21 18.8267 21 15.9983V9.99826C21 7.16983 21 5.75562 20.1213 4.87694C19.552 4.30764 18.7579 4.10719 17.5 4.03662V4.5C17.5 6.15685 16.1569 7.5 14.5 7.5H9.5C7.84315 7.5 6.5 6.15685 6.5 4.5V4.03662ZM7 9.75C6.58579 9.75 6.25 10.0858 6.25 10.5C6.25 10.9142 6.58579 11.25 7 11.25H7.5C7.91421 11.25 8.25 10.9142 8.25 10.5C8.25 10.0858 7.91421 9.75 7.5 9.75H7ZM10.5 9.75C10.0858 9.75 9.75 10.0858 9.75 10.5C9.75 10.9142 10.0858 11.25 10.5 11.25H17C17.4142 11.25 17.75 10.9142 17.75 10.5C17.75 10.0858 17.4142 9.75 17 9.75H10.5ZM7 13.25C6.58579 13.25 6.25 13.5858 6.25 14C6.25 14.4142 6.58579 14.75 7 14.75H7.5C7.91421 14.75 8.25 14.4142 8.25 14C8.25 13.5858 7.91421 13.25 7.5 13.25H7ZM10.5 13.25C10.0858 13.25 9.75 13.5858 9.75 14C9.75 14.4142 10.0858 14.75 10.5 14.75H17C17.4142 14.75 17.75 14.4142 17.75 14C17.75 13.5858 17.4142 13.25 17 13.25H10.5ZM7 16.75C6.58579 16.75 6.25 17.0858 6.25 17.5C6.25 17.9142 6.58579 18.25 7 18.25H7.5C7.91421 18.25 8.25 17.9142 8.25 17.5C8.25 17.0858 7.91421 16.75 7.5 16.75H7ZM10.5 16.75C10.0858 16.75 9.75 17.0858 9.75 17.5C9.75 17.9142 10.0858 18.25 10.5 18.25H17C17.4142 18.25 17.75 17.9142 17.75 17.5C17.75 17.0858 17.4142 16.75 17 16.75H10.5Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <span>
                                                Feedbacks
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        @if (
                            $a_colaborador &&
                                ($a_colaborador->crear == 1 ||
                                    $a_colaborador->leer == 1 ||
                                    $a_colaborador->eliminar == 1 ||
                                    $a_colaborador->actualizar == 1))
                            <li>
                                <a href="{{ route('colaboradores.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('colaboradores*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg height="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 503.5 503.5"
                                        xml:space="preserve" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g transform="translate(1 1)">
                                                <path style="fill:#AE938D;"
                                                    d="M404.671,421c25.6,0,38.1-18.9,38.1-18.9c13-6,13.2-14.1,20.8-20l0.9-0.9l-17.1-105.8 c-1.7-17.1-17.1-34.1-42.7-34.1c-7.7,0-14.5,1.7-20.5,4.3l0,0l-0.9-1.7l-12.8-87.9c-1.7-17.1-17.1-34.1-42.7-34.1 c-7.7,0-13.7,1.7-19.6,4.3c-4.3,1.7-7.7,4.3-10.2,6.8c-6.8,6.8-11.1,15.4-12.8,23.9l-2.3,3.5l1.4-3.5c1.7-8.5,6-17.1,12.8-23.9 c3.4-2.6,6.8-5.1,10.2-6.8v-0.9l-13.5-88.8c-1.7-17.1-17.1-34.1-42.7-34.1c-12.8,0-23,4.3-29.9,11.1c-6.8,6.8-11.1,15.4-12.8,23.9 l-13.5,94l-0.1-0.1c-6.8-6-17.1-9.4-29-9.4c-12.8,0-23,4.3-29.9,11.1c-6.8,6.8-11.1,15.4-12.8,23.9l-13.6,86.8 c-3.4-0.8-8-1.6-11.1-3.2c-12.8,0-23,4.3-29.9,11.1c-6.8,6.8-11.1,15.4-12.8,23.9l-16.2,106.6v0.9c0,0,32.3,35.1,58.9,38.9 c37.8,5.4,152.7-0.9,152.7-0.9H404.671z">
                                                </path>
                                                <path style="fill:#AAB1BA;"
                                                    d="M463.571,383c-7.7-2.6-15.4-4.3-24.7-4.3c0,0-8.5,34.1-34.1,34.1s-34.1-34.1-34.1-34.1 c-9.4,0-17.9,1.7-24.7,4.3c-6.8,3.4-12.8,6.8-17.9,11.9c-4.3-5.1-10.2-9.4-17.9-11.9c-6.8-2.6-15.4-4.3-24.7-4.3 c0,0-8.5,34.1-34.1,34.1s-34.1-34.1-34.1-34.1c-9.4,0-17.9,1.7-24.7,4.3c-6.8,3.4-12.8,7.7-17.9,11.9l0,0 c-5.1-4.3-11.1-8.5-17.9-11.9c-6.8-2.6-15.4-4.3-24.7-4.3c0,0-8.5,34.1-34.1,34.1s-34.1-34.1-34.1-34.1c-9.4,0-17.9,1.7-24.7,4.3 c-24.7,10.2-35,34.1-35,46.9v51.2h153.6v17.1h187.7l0,0v-17.1h153.6v-51.2C498.571,417.1,488.271,393.2,463.571,383z M165.671,404.4c-0.2,0.4-0.4,0.7-0.6,1.1C165.271,405.2,165.471,404.8,165.671,404.4z M165.071,405.6c-0.4,0.6-0.8,1.1-1.1,1.7 C164.271,406.7,164.671,406.2,165.071,405.6z M162.071,410.6c-0.2,0.3-0.4,0.6-0.6,0.9C161.671,411.1,161.871,410.9,162.071,410.6z M158.071,422.3c0-1.7,0-2.6,0.9-4.3C158.971,419.7,158.071,421.4,158.071,422.3z M343.271,417.1c-0.9-0.9-0.9-2.6-1.7-3.4 C342.371,414.6,343.271,416.3,343.271,417.1z M336.371,404.3c-1.7-1.7-2.6-3.4-4.3-5.1C333.871,400.9,335.571,402.6,336.371,404.3z M344.071,423.1c0.9,0.9,0.9,2.6,0.9,3.4C344.971,425.7,344.071,424,344.071,423.1z">
                                                </path>
                                                <path style="fill:#FFD0A1;"
                                                    d="M199.871,173.9V208c0,0,0,34.1-34.1,34.1s-34.1-34.1-34.1-34.1v-34.1L199.871,173.9L199.871,173.9z M131.571,293.4v34.1c0,0,0,34.1-34.1,34.1s-34.1-34.1-34.1-34.1v-34.1H131.571z M285.171,293.4v34.1c0,0,0,34.1-34.1,34.1 s-34.1-34.1-34.1-34.1v-34.1H285.171z M361.971,173.9V208c0,0,0,34.1-34.1,34.1s-34.1-34-34.1-34V174h68.2V173.9z M285.171,54.5 v34.1c0,0,0,34.1-34.1,34.1s-34.1-34.1-34.1-34.1V54.5H285.171z M438.771,293.4v34.1c0,0,0,34.1-34.1,34.1s-34.1-34.1-34.1-34.1 v-34.1H438.771z">
                                                </path>
                                            </g>
                                            <path style="fill:#51565F;"
                                                d="M499.571,503.5c-2.6,0-4.3-1.7-4.3-4.3v-68.3c0-7.7-4.3-21.3-14.5-30.7c-6.8-6.8-18.8-14.5-37.5-15.4 c-2.6,8.5-11.9,30.7-33.3,33.3V448c0,2.6-1.7,4.3-4.3,4.3s-4.3-1.7-4.3-4.3v-29.9c-20.5-2.6-29.9-24.7-33.3-33.3 c-4.3,0-8.5,0.9-12.8,1.7c-2.6,0.9-4.3-0.9-5.1-3.4s0.9-4.3,3.4-5.1c6-1.7,11.9-2.6,17.9-2.6c2.6,0,4.3,0.9,4.3,3.4 c0,0,7.7,30.7,29.9,30.7c22.2,0,29.9-30.7,29.9-30.7c0.9-1.7,2.6-3.4,4.3-3.4c23,0,38.4,10.2,46.1,17.9 c11.9,11.9,17.1,27.3,17.1,37.5v68.3C503.771,501.8,502.071,503.5,499.571,503.5z M345.971,503.5c-2.6,0-4.3-1.7-4.3-4.3v-68.3 c0-7.7-4.3-21.3-14.5-30.7c-6.8-6.8-18.8-14.5-37.5-15.4c-2.6,8.5-11.9,30.7-33.3,33.3V448c0,2.6-1.7,4.3-4.3,4.3 c-2.6,0-4.3-1.7-4.3-4.3v-29.9c-20.5-2.6-29.9-24.7-33.3-33.3c-18.8,0.9-30.7,8.5-37.5,15.4c-10.2,10.2-14.5,23-14.5,30.7v68.3 c0,2.6-1.7,4.3-4.3,4.3s-4.3-1.7-4.3-4.3v-68.3c0-10.2,5.1-25.6,17.1-37.5c8.5-8.5,23-17.9,46.9-17.9c1.7,0,3.4,1.7,4.3,3.4 c0,0,7.7,30.7,29.9,30.7s29.9-30.7,29.9-30.7c0.9-1.7,2.6-3.4,4.3-3.4c23,0,38.4,10.2,46.1,17.9c11.9,11.9,17.1,27.3,17.1,37.5v68.3 C350.171,501.8,348.471,503.5,345.971,503.5z M4.571,503.5c-2.6,0-4.3-1.7-4.3-4.3v-68.3c0-10.2,5.1-25.6,17.1-37.5 c8.5-8.5,23.9-17.9,46.9-17.9c1.7,0,3.4,1.7,4.3,3.4c0,0,7.7,30.7,29.9,30.7s29.9-30.7,29.9-30.7c0.9-1.7,2.6-3.4,4.3-3.4 c6,0,11.9,0.9,17.9,1.7c2.6,0.9,3.4,2.6,3.4,5.1c-0.9,2.6-2.6,3.4-5.1,3.4c-4.3-0.9-8.5-1.7-12.8-1.7c-2.6,8.5-11.9,30.7-33.3,33.3 v29.9c0,2.6-1.7,4.3-4.3,4.3c-2.6,0-4.3-1.7-4.3-4.3v-29.9c-20.5-2.6-29.9-24.7-33.3-33.3c-18.8,0.9-30.7,8.5-37.5,15.4 c-10.2,10.2-14.5,23-14.5,30.7v68.3C8.871,501.8,7.171,503.5,4.571,503.5z M456.871,349.9c-1.7,0-4.3-1.7-4.3-3.4l-8.5-68.3 c-1.7-14.5-14.5-30.7-38.4-30.7c-23,0-35.8,15.4-38.4,30.7l-8.5,68.3c0,2.6-2.6,4.3-5.1,3.4c-2.6,0-4.3-2.6-3.4-5.1l8.5-68.3 c3.4-18.8,18.8-37.5,46.9-37.5c29,0,44.4,19.6,46.9,37.5l8.5,68.3C461.171,347.3,459.471,349.9,456.871,349.9L456.871,349.9z M303.271,349.9c-1.7,0-4.3-1.7-4.3-3.4l-8.5-68.3c-1.7-14.5-14.5-30.7-38.4-30.7c-23,0-35.8,15.4-38.4,30.7l-8.5,68.3 c0,2.6-2.6,4.3-5.1,3.4c-2.6,0-4.3-2.6-3.4-5.1l8.5-68.3c3.4-18.8,18.8-37.5,46.9-37.5c29,0,44.4,19.6,46.9,37.5l8.5,68.3 C307.571,347.3,305.871,349.9,303.271,349.9L303.271,349.9z M149.671,349.9c-1.7,0-4.3-1.7-4.3-3.4l-8.5-68.3 c-1.7-14.5-14.5-30.7-38.4-30.7c-23,0-35.8,15.4-38.4,30.7l-8.5,68.3c0,2.6-2.6,4.3-5.1,3.4c-2.6,0-4.3-2.6-3.4-5.1l8.5-68.3 c3.4-18.8,18.8-37.5,46.9-37.5c29,0,44.4,19.6,46.9,37.5l8.5,68.3C153.971,347.3,152.271,349.9,149.671,349.9L149.671,349.9z M380.071,221.9c-1.7,0-4.3-1.7-4.3-3.4l-8.5-59.7c-1.7-14.5-14.5-30.7-38.4-30.7c-23,0-35.8,15.4-38.4,30.7l-8.5,59.7 c0,2.6-2.6,4.3-5.1,3.4c-2.6,0-4.3-2.6-3.4-5.1l8.5-59.7c3.4-18.8,18.8-37.5,46.9-37.5c29,0,44.4,19.6,46.9,37.5l8.5,59.7 C384.371,219.3,382.671,221.9,380.071,221.9L380.071,221.9z M217.971,221.9c-1.7,0-4.3-1.7-4.3-3.4l-8.5-59.7 c-1.7-14.5-14.5-30.7-38.4-30.7c-23,0-35.8,15.4-38.4,30.7l-8.5,59.7c0,2.6-2.6,4.3-5.1,3.4c-2.6,0-4.3-2.6-3.4-5.1l8.5-59.7 c3.4-18.8,18.8-37.5,46.9-37.5c29,0,44.4,19.6,46.9,37.5l8.5,59.7C222.171,219.3,220.471,221.9,217.971,221.9L217.971,221.9z M303.271,102.4c-1.7,0-4.3-1.7-4.3-3.4l-8.5-59.7c-1.7-14.6-14.5-30.8-38.4-30.8c-23,0-35.8,15.4-38.4,30.7l-8.5,59.7 c0,2.6-2.6,4.3-5.1,3.4c-2.6,0-4.3-2.6-3.4-5.1l8.5-59.7c3.4-18.8,18.8-37.5,46.9-37.5c29,0,44.4,19.6,46.9,37.5l8.5,59.7 C307.571,99.8,305.871,102.4,303.271,102.4L303.271,102.4z">
                                            </path>
                                        </g>
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Colaboradores</span>
                                </a>
                            </li>
                        @endif
                        {{-- @if ($a_acceso && ($a_acceso->crear == 1 || $a_acceso->leer == 1 || $a_acceso->eliminar == 1 || $a_acceso->actualizar == 1))
                            <li>
                                <a href="{{ route('accesos.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('accesos*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg height="33"viewBox="0 0 64 64" id="Layer_1" version="1.1"
                                        xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <style type="text/css">
                                                .st0 {
                                                    fill: #B4E6DD;
                                                }

                                                .st1 {
                                                    fill: #80D4C4;
                                                }

                                                .st2 {
                                                    fill: #D2F0EA;
                                                }

                                                .st3 {
                                                    fill: #FFFFFF;
                                                }

                                                .st4 {
                                                    fill: #FBD872;
                                                }

                                                .st5 {
                                                    fill: #ea5039;
                                                }

                                                .st6 {
                                                    fill: #bd4a32;
                                                }

                                                .st7 {
                                                    fill: #F6AF62;
                                                }

                                                .st8 {
                                                    fill: #32A48E;
                                                }

                                                .st9 {
                                                    fill: #A38FD8;
                                                }

                                                .st10 {
                                                    fill: #7C64BD;
                                                }

                                                .st11 {
                                                    fill: #EAA157;
                                                }

                                                .st12 {
                                                    fill: #9681CF;
                                                }

                                                .st13 {
                                                    fill: #F9C46A;
                                                }

                                                .st14 {
                                                    fill: #CE6B61;
                                                }
                                            </style>
                                            <g>
                                                <path class="st1"
                                                    d="M44,16H12c-2.21,0-4,1.79-4,4v32c0,2.21,1.79,4,4,4h32c2.21,0,4-1.79,4-4V20C48,17.79,46.21,16,44,16z">
                                                </path>
                                                <rect class="st3" height="32"
                                                    transform="matrix(-1.836970e-16 1 -1 -1.836970e-16 66.9968 11.0031)"
                                                    width="26" x="15" y="23"></rect>
                                                <g>
                                                    <circle class="st3" cx="14" cy="21" r="2">
                                                    </circle>
                                                    <circle class="st3" cx="20" cy="21" r="2">
                                                    </circle>
                                                </g>
                                                <path class="st6"
                                                    d="M55.66,13.82l-0.4-2.42L49.66,8c-5.1,3.09-11.49,3.09-16.59,0l-5.59,3.39l-0.39,2.38 c-1.86,11.24,3.97,22.34,14.28,27.19l0.01,0C51.68,36.14,57.52,25.05,55.66,13.82z">
                                                </path>
                                                <path class="st5"
                                                    d="M49.37,23h-16v12.05c2.2,2.43,4.89,4.46,7.99,5.92l0.01,0c3.11-1.45,5.8-3.49,8-5.91V23z">
                                                </path>
                                                <circle class="st4" cx="41.37" cy="23" r="8">
                                                </circle>
                                            </g>
                                        </g>
                                    </svg>
                                       <span class="flex-1 ml-3 whitespace-nowrap">Accesos</span>
                                </a>
                            </li>
                        @endif --}}
                        @if ($a_eda && ($a_eda->crear == 1 || $a_eda->leer == 1 || $a_eda->eliminar == 1 || $a_eda->actualizar == 1))
                            <li class="border-t border-neutral-600 pt-2 mt-2">
                                <a href="{{ route('edas.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('edas*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg height="28px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve"
                                        fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g>
                                                <path style="fill:#424A60;"
                                                    d="M24,35v-0.375V34.25v-8.625V25.25h0.034C24.013,25.374,24,25.499,24,25.625 c0-2.437,3.862-4.552,9.534-5.625H3.608C1.616,20,0,21.615,0,23.608v11.783C0,37.385,1.616,39,3.608,39H24V35z">
                                                </path>
                                            </g>
                                            <g>
                                                <path style="fill:#556080;"
                                                    d="M24.034,53H24v-9v-0.375V43.25V39H3.608C1.616,39,0,40.615,0,42.608v11.783 C0,56.385,1.616,58,3.608,58h28.718C27.601,56.931,24.378,55.103,24.034,53z">
                                                </path>
                                            </g>
                                            <path style="fill:#556080;"
                                                d="M54.392,20H3.608C1.616,20,0,18.384,0,16.392V4.608C0,2.616,1.616,1,3.608,1h50.783 C56.384,1,58,2.616,58,4.608v11.783C58,18.384,56.384,20,54.392,20z">
                                            </path>
                                            <circle style="fill:#7383BF;" cx="9.5" cy="10.5" r="3.5">
                                            </circle>
                                            <circle style="fill:#7383BF;" cx="49" cy="9" r="1">
                                            </circle>
                                            <circle style="fill:#7383BF;" cx="45" cy="9" r="1">
                                            </circle>
                                            <circle style="fill:#7383BF;" cx="51" cy="12" r="1">
                                            </circle>
                                            <circle style="fill:#7383BF;" cx="47" cy="12" r="1">
                                            </circle>
                                            <circle style="fill:#7383BF;" cx="41" cy="9" r="1">
                                            </circle>
                                            <circle style="fill:#7383BF;" cx="43" cy="12" r="1">
                                            </circle>
                                            <circle style="fill:#7383BF;" cx="37" cy="9" r="1">
                                            </circle>
                                            <circle style="fill:#7383BF;" cx="39" cy="12" r="1">
                                            </circle>
                                            <circle style="fill:#7383BF;" cx="33" cy="9" r="1">
                                            </circle>
                                            <circle style="fill:#7383BF;" cx="35" cy="12" r="1">
                                            </circle>
                                            <circle style="fill:#7383BF;" cx="9.5" cy="29.5" r="3.5">
                                            </circle>
                                            <circle style="fill:#7383BF;" cx="9.5" cy="48.5" r="3.5">
                                            </circle>
                                            <g>
                                                <path style="fill:#1A9172;"
                                                    d="M42,48.75c-9.941,0-18-2.854-18-6.375V53h0.034c0.548,3.346,8.381,6,17.966,6s17.418-2.654,17.966-6 H60V42.375C60,45.896,51.941,48.75,42,48.75z">
                                                </path>
                                                <path style="fill:#1A9172;"
                                                    d="M24,42v0.375c0-0.126,0.013-0.251,0.034-0.375H24z">
                                                </path>
                                                <path style="fill:#1A9172;"
                                                    d="M59.966,42C59.987,42.124,60,42.249,60,42.375V42H59.966z"></path>
                                            </g>
                                            <g>
                                                <path style="fill:#25AE88;"
                                                    d="M42,38c-9.941,0-18-2.854-18-6.375V42.75h0.034c0.548,3.346,8.381,6,17.966,6s17.418-2.654,17.966-6 H60V31.625C60,35.146,51.941,38,42,38z">
                                                </path>
                                                <path style="fill:#25AE88;"
                                                    d="M24,31.25v0.375c0-0.126,0.013-0.251,0.034-0.375H24z"></path>
                                                <path style="fill:#25AE88;"
                                                    d="M59.966,31.25C59.987,31.374,60,31.499,60,31.625V31.25H59.966z"></path>
                                            </g>
                                            <ellipse style="fill:#88C057;" cx="42" cy="21.375" rx="18"
                                                ry="6.375"></ellipse>
                                            <g>
                                                <path style="fill:#61B872;"
                                                    d="M42,27.75c-9.941,0-18-2.854-18-6.375V32h0.034c0.548,3.346,8.381,6,17.966,6s17.418-2.654,17.966-6 H60V21.375C60,24.896,51.941,27.75,42,27.75z">
                                                </path>
                                                <path style="fill:#61B872;"
                                                    d="M24,21v0.375c0-0.126,0.013-0.251,0.034-0.375H24z">
                                                </path>
                                                <path style="fill:#61B872;"
                                                    d="M59.966,21C59.987,21.124,60,21.249,60,21.375V21H59.966z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">EDAS</span>
                                </a>
                            </li>
                        @endif

                        @if ($a_area && ($a_area->crear == 1 || $a_area->leer == 1 || $a_area->eliminar == 1 || $a_area->actualizar == 1))
                            <li class="border-t border-neutral-600 pt-2 mt-2">
                                <a href="{{ route('areas.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('areas*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg height="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                                        fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path style="fill:#FBC176;"
                                                d="M0,167.724v264.828c0,15.007,11.476,26.483,26.483,26.483h459.034 c15.007,0,26.483-11.476,26.483-26.483V167.724c0-15.007-11.476-26.483-26.483-26.483H26.483C11.476,141.241,0,153.6,0,167.724">
                                            </path>
                                            <path style="fill:#C39A6E;"
                                                d="M476.69,141.241c0-19.421-15.89-35.31-35.31-35.31H300.138L256,52.966H61.793 c-15.007,0-26.483,12.359-26.483,26.483v61.793H476.69z">
                                            </path>
                                            <path style="fill:#F38774;"
                                                d="M386.648,271.89l-33.545-33.545l-33.545,33.545c-3.531,3.531-10.593,0.883-10.593-4.414V141.241 h88.276v126.234C397.241,272.772,391.062,275.421,386.648,271.89">
                                            </path>
                                            <g>
                                                <path style="fill:#FFFFFF;"
                                                    d="M158.897,203.034H52.966c-5.297,0-8.828-3.531-8.828-8.828s3.531-8.828,8.828-8.828h105.931 c5.297,0,8.828,3.531,8.828,8.828S164.193,203.034,158.897,203.034">
                                                </path>
                                                <path style="fill:#FFFFFF;"
                                                    d="M158.897,238.345H52.966c-5.297,0-8.828-3.531-8.828-8.828s3.531-8.828,8.828-8.828h105.931 c5.297,0,8.828,3.531,8.828,8.828S164.193,238.345,158.897,238.345">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Areas</span>
                                </a>
                            </li>
                        @endif


                        @if (
                            $a_departamento &&
                                ($a_departamento->crear == 1 ||
                                    $a_departamento->leer == 1 ||
                                    $a_departamento->eliminar == 1 ||
                                    $a_departamento->actualizar == 1))
                            <li>
                                <a href="{{ route('departamentos.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('departamentos*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg height="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                                        fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path style="fill:#FBC176;"
                                                d="M0,167.724v264.828c0,15.007,11.476,26.483,26.483,26.483h459.034 c15.007,0,26.483-11.476,26.483-26.483V167.724c0-15.007-11.476-26.483-26.483-26.483H26.483C11.476,141.241,0,153.6,0,167.724">
                                            </path>
                                            <path style="fill:#C39A6E;"
                                                d="M476.69,141.241c0-19.421-15.89-35.31-35.31-35.31H300.138L256,52.966H61.793 c-15.007,0-26.483,12.359-26.483,26.483v61.793H476.69z">
                                            </path>
                                            <path style="fill:#F38774;"
                                                d="M386.648,271.89l-33.545-33.545l-33.545,33.545c-3.531,3.531-10.593,0.883-10.593-4.414V141.241 h88.276v126.234C397.241,272.772,391.062,275.421,386.648,271.89">
                                            </path>
                                            <g>
                                                <path style="fill:#FFFFFF;"
                                                    d="M158.897,203.034H52.966c-5.297,0-8.828-3.531-8.828-8.828s3.531-8.828,8.828-8.828h105.931 c5.297,0,8.828,3.531,8.828,8.828S164.193,203.034,158.897,203.034">
                                                </path>
                                                <path style="fill:#FFFFFF;"
                                                    d="M158.897,238.345H52.966c-5.297,0-8.828-3.531-8.828-8.828s3.531-8.828,8.828-8.828h105.931 c5.297,0,8.828,3.531,8.828,8.828S164.193,238.345,158.897,238.345">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Departamentos</span>
                                </a>
                            </li>
                        @endif

                        @if ($a_cargo && ($a_cargo->crear == 1 || $a_cargo->leer == 1 || $a_cargo->eliminar == 1 || $a_cargo->actualizar == 1))
                            <li>
                                <a href="{{ route('cargos.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('cargos*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg height="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                                        fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path style="fill:#FBC176;"
                                                d="M0,167.724v264.828c0,15.007,11.476,26.483,26.483,26.483h459.034 c15.007,0,26.483-11.476,26.483-26.483V167.724c0-15.007-11.476-26.483-26.483-26.483H26.483C11.476,141.241,0,153.6,0,167.724">
                                            </path>
                                            <path style="fill:#C39A6E;"
                                                d="M476.69,141.241c0-19.421-15.89-35.31-35.31-35.31H300.138L256,52.966H61.793 c-15.007,0-26.483,12.359-26.483,26.483v61.793H476.69z">
                                            </path>
                                            <path style="fill:#F38774;"
                                                d="M386.648,271.89l-33.545-33.545l-33.545,33.545c-3.531,3.531-10.593,0.883-10.593-4.414V141.241 h88.276v126.234C397.241,272.772,391.062,275.421,386.648,271.89">
                                            </path>
                                            <g>
                                                <path style="fill:#FFFFFF;"
                                                    d="M158.897,203.034H52.966c-5.297,0-8.828-3.531-8.828-8.828s3.531-8.828,8.828-8.828h105.931 c5.297,0,8.828,3.531,8.828,8.828S164.193,203.034,158.897,203.034">
                                                </path>
                                                <path style="fill:#FFFFFF;"
                                                    d="M158.897,238.345H52.966c-5.297,0-8.828-3.531-8.828-8.828s3.531-8.828,8.828-8.828h105.931 c5.297,0,8.828,3.531,8.828,8.828S164.193,238.345,158.897,238.345">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Cargos</span>
                                </a>
                            </li>
                        @endif
                        @if (
                            $a_puesto &&
                                ($a_puesto->crear == 1 || $a_puesto->leer == 1 || $a_puesto->eliminar == 1 || $a_puesto->actualizar == 1))
                            <li>
                                <a href="{{ route('puestos.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('puestos*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg height="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                                        fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path style="fill:#FBC176;"
                                                d="M0,167.724v264.828c0,15.007,11.476,26.483,26.483,26.483h459.034 c15.007,0,26.483-11.476,26.483-26.483V167.724c0-15.007-11.476-26.483-26.483-26.483H26.483C11.476,141.241,0,153.6,0,167.724">
                                            </path>
                                            <path style="fill:#C39A6E;"
                                                d="M476.69,141.241c0-19.421-15.89-35.31-35.31-35.31H300.138L256,52.966H61.793 c-15.007,0-26.483,12.359-26.483,26.483v61.793H476.69z">
                                            </path>
                                            <path style="fill:#F38774;"
                                                d="M386.648,271.89l-33.545-33.545l-33.545,33.545c-3.531,3.531-10.593,0.883-10.593-4.414V141.241 h88.276v126.234C397.241,272.772,391.062,275.421,386.648,271.89">
                                            </path>
                                            <g>
                                                <path style="fill:#FFFFFF;"
                                                    d="M158.897,203.034H52.966c-5.297,0-8.828-3.531-8.828-8.828s3.531-8.828,8.828-8.828h105.931 c5.297,0,8.828,3.531,8.828,8.828S164.193,203.034,158.897,203.034">
                                                </path>
                                                <path style="fill:#FFFFFF;"
                                                    d="M158.897,238.345H52.966c-5.297,0-8.828-3.531-8.828-8.828s3.531-8.828,8.828-8.828h105.931 c5.297,0,8.828,3.531,8.828,8.828S164.193,238.345,158.897,238.345">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Puestos</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </aside>
        @endguest
        <main class="min-h-screen">
            @yield('content')
        </main>
    </div>
@endsection
