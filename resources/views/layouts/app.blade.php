@extends('layouts.headers')

@section('app')
    <div style="" id="app" class="h-screen">
        @guest
            @if (Route::has('login'))
            @endif
        @else
            <nav class="fixed pl-[250px] border-b dark:border-gray-700 w-full border-gray-200 bg-white backdrop-blur-sm z-30">
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
                    <a href="/" class="flex items-center">
                        <img src="/elp.gif" class="w-32" alt="Flowbite Logo" />
                    </a>
                    <span
                        class="bg-purple-200 mx-auto text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300">
                        <div class="flex items-center gap-2 divide-x divide-purple-500 p-2 rounded-xl">
                            <h4 class="min-w-max text-xl tracking-tight font-semibold leading-4">
                                EDA: {{ $currentEda->year }}-{{ $currentEda->n_evaluacion }}</h4>
                            {{-- <div class="text-purple-700 pl-2 text-xs flex flex-col">
                                <span>
                                    <span class="text-neutral-700">Hasta:</span>
                                    {{ \Carbon\Carbon::parse($currentEda->f_fin)->format('d F Y') }}</span>
                            </div> --}}
                        </div>
                    </span>
                    {{-- <div class="relative w-full">
                    <span
                        class="absolute top-[50%] left-4 text-xl text-gray-500 font-medium translate-y-[-50%]">EDA:</span>
                    <select name=""
                        class="w-full pl-16 text-gray-800 font-medium text-lg border border-gray-300 cursor-pointer rounded-full p-2 px-3 bg-transparent"
                        id="">
                        @foreach ($edas as $eda)
                            <option value="{{ $eda->id }}">{{ $eda->year }}-{{ $eda->n_evaluacion }}</option>
                        @endforeach
                    </select>
                </div> --}}
                    {{-- <div class="border-l ml-auto pl-2 ">
                    <div class="relative w-full">
                        <span
                            class="absolute top-[50%] left-4 text-xl text-gray-500 font-medium translate-y-[-50%]">Eva:</span>
                        <select name=""
                            class="w-[160px] pl-14 text-gray-800 font-medium text-lg border border-gray-300 cursor-pointer rounded-full p-2 px-3 bg-transparent"
                            id="">
                            <option value="2023">2023-1</option>
                            <option value="2024">2023-2</option>
                        </select>
                    </div>
                </div> --}}
                    <div class="flex ml-auto items-center md:order-2">
                        <button type="button"
                            class="flex  text-sm bg-gray-100 w-full p-2 items-center gap-2 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                            data-dropdown-placement="bottom">
                            <img class="w-9 h-8 rounded-full" src="https://cataas.com/cat?type=sq" alt="user photo">
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
            </nav>
            <aside id="cta-button-sidebar"
                class="fixed top-0 left-0 z-40 w-[250px] h-screen transition-transform -translate-x-full sm:translate-x-0"
                aria-label="Sidebar">
                <div class="h-full px-3 py-4 pt-2 flex flex-col overflow-y-auto bg-gray-900 shadow-lg">
                    <ul class="h-full flex mt-2 flex-col font-medium text-neutral-500">
                        <li>
                            <a href="/me"
                                class="flex items-center p-2 rounded-lg hover:bg-gray-100 group transition-colors {{ request()->is('objetivos*') || request()->is('me') ? 'text-gray-700 bg-gray-100' : '' }}">
                                <svg height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2Z"
                                            fill="#4296FF"></path>
                                        <path
                                            d="M12.0001 6C10.3433 6 9.00012 7.34315 9.00012 9C9.00012 10.6569 10.3433 12 12.0001 12C13.657 12 15.0001 10.6569 15.0001 9C15.0001 7.34315 13.657 6 12.0001 6Z"
                                            fill="#152C70"></path>
                                        <path
                                            d="M17.8948 16.5528C18.0356 16.8343 18.0356 17.1657 17.8948 17.4473C17.9033 17.4297 17.8941 17.4487 17.8941 17.4487L17.8933 17.4502L17.8918 17.4532L17.8883 17.46L17.8801 17.4756C17.874 17.4871 17.8667 17.5004 17.8582 17.5155C17.841 17.5458 17.8187 17.5832 17.7907 17.6267C17.7348 17.7138 17.6559 17.8254 17.5498 17.9527C17.337 18.208 17.0164 18.5245 16.555 18.8321C15.623 19.4534 14.1752 20 12.0002 20C8.31507 20 6.76562 18.4304 6.26665 17.7115C5.96476 17.2765 5.99819 16.7683 6.18079 16.4031C6.91718 14.9303 8.42247 14 10.0691 14H13.7643C15.5135 14 17.1125 14.9883 17.8948 16.5528Z"
                                            fill="#152C70"></path>
                                    </g>
                                </svg>
                                <span class="ml-3">Yo y mis objetivos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('colaboradores.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('colaboradores*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                <svg height="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 503.5 503.5" xml:space="preserve"
                                    fill="#000000">
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
                        {{-- <li>
                            <a href="{{ route('supervisores.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('supervisores*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                <svg height="32" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.001 512.001"
                                    xml:space="preserve" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path style="fill:#E4EAF6;"
                                            d="M397.242,370.759H264.975v-70.336c0-4.875-3.948-8.828-8.828-8.828c-4.879,0-8.828,3.953-8.828,8.828 v70.336H114.759c-24.337,0-44.138,19.801-44.138,44.138v52.966c0,4.875,3.948,8.828,8.828,8.828s8.828-3.953,8.828-8.828v-52.966 c0-14.603,11.88-26.483,26.483-26.483h132.561v79.448c0,4.875,3.948,8.828,8.828,8.828c4.879,0,8.828-3.953,8.828-8.828v-79.448 h132.267c14.603,0,26.483,11.88,26.483,26.483v52.966c0,4.875,3.948,8.828,8.828,8.828c4.879,0,8.828-3.953,8.828-8.828v-52.966 C441.38,390.561,421.578,370.759,397.242,370.759z">
                                        </path>
                                        <polygon style="fill:#fdc48b;"
                                            points="302.933,213.822 302.933,177.319 209.067,177.319 209.067,213.822 256,255.54 ">
                                        </polygon>
                                        <path style="fill:#707487;"
                                            d="M375.503,230.897l-64.529-15.183c-0.974-0.23-1.87-0.618-2.71-1.09L256,245.111l-50.227-31.962 c-1.3,1.224-2.914,2.134-4.747,2.566l-64.529,15.183c-9.422,2.217-16.082,10.625-16.082,20.305v40.842 c0,5.76,4.67,10.43,10.43,10.43h250.31c5.76,0,10.43-4.67,10.43-10.43v-40.842C391.584,241.522,384.925,233.114,375.503,230.897z">

                                        </path>
                                        <path style="fill:#fbbf8e;"
                                            d="M209.067,177.319v38.514c59.123,21.301,93.866-32.011,93.866-32.011v-6.504h-93.866V177.319z">
                                        </path>
                                        <path style="fill:#f9c390;"
                                            d="M188.208,57.379l4.544,99.975c0.425,9.34,5.004,18.001,12.483,23.61l21.561,16.171 c5.416,4.062,12.003,6.258,18.773,6.258h20.86c6.77,0,13.357-2.196,18.773-6.258l21.561-16.171 c7.479-5.61,12.058-14.27,12.483-23.61l4.544-99.975H188.208z">
                                        </path>
                                        <path style="fill:#fdc48b;"
                                            d="M240.356,78.238c20.86,0,52.148-5.215,59.569-20.86H188.208l4.544,99.975 c0.425,9.34,5.004,18.001,12.483,23.61l21.561,16.171c5.416,4.062,12.003,6.258,18.773,6.258H256 c-10.43,0-31.288-20.86-31.288-46.933c0-12.753,0-46.933,0-62.578C224.712,88.668,229.927,78.238,240.356,78.238z">
                                        </path>
                                        <g>
                                            <path style="fill:#5B5D6E;"
                                                d="M353.301,268.629l33.791-30.355c2.831,3.585,4.492,8.097,4.492,12.927v40.842 c0,5.76-4.67,10.43-10.43,10.43h-36.503v-14.446C344.651,280.626,347.796,273.575,353.301,268.629z">
                                            </path>
                                            <path style="fill:#5B5D6E;"
                                                d="M158.699,268.629l-33.791-30.355c-2.831,3.585-4.492,8.097-4.492,12.927v40.842 c0,5.76,4.67,10.43,10.43,10.43h36.503v-14.446C167.349,280.626,164.204,273.575,158.699,268.629z">
                                            </path>
                                            <polygon style="fill:#5B5D6E;"
                                                points="269.038,302.473 242.963,302.473 246.223,255.54 265.778,255.54 ">
                                            </polygon>
                                        </g>
                                        <path style="fill:#515262;"
                                            d="M269.038,245.111h-26.073v5.774c0,5.451,4.418,9.869,9.869,9.869h6.335 c5.451,0,9.869-4.418,9.869-9.869V245.111z">
                                        </path>
                                        <g>
                                            <path style="fill:#5B5D6E;"
                                                d="M208.335,202.212L256,245.111c0,0-13.348,6.739-29.822,20.321 c-3.399,2.802-8.538,1.666-10.361-2.343l-22.394-49.267l7.084-10.626C202.271,200.55,205.971,200.084,208.335,202.212z">
                                            </path>
                                            <path style="fill:#5B5D6E;"
                                                d="M303.666,202.212L256,245.111c0,0,13.348,6.739,29.822,20.321c3.399,2.802,8.538,1.666,10.361-2.343 l22.395-49.267l-7.084-10.626C309.729,200.55,306.028,200.084,303.666,202.212z">
                                            </path>
                                        </g>
                                        <path style="fill:#785550;"
                                            d="M287.615,22.831l4.889,34.548c22.316,4.463,25.533,39.485,25.996,49.489 c0.084,1.815,0.664,3.569,1.649,5.096l8.514,13.208c0,0-2.914-21.837,10.43-36.503C339.092,88.668,343.674,1.972,287.615,22.831z">
                                        </path>
                                        <path style="fill:#f9c390;"
                                            d="M333.894,122.939l-5.889,23.556c-0.697,2.791-3.206,4.749-6.082,4.749l0,0 c-3.161,0-5.828-2.355-6.221-5.492l-3.011-24.093c-0.806-6.443,4.218-12.134,10.711-12.134h0.021 C330.444,109.527,335.598,116.126,333.894,122.939z">
                                        </path>
                                        <path style="fill:#694B4B;"
                                            d="M193.205,13.488l7.713,5.269c-34.873,25.748-28.355,69.91-28.355,69.91 c10.43,10.43,10.43,36.503,10.43,36.503l10.43-10.43c0,0-4.025-30.127,15.645-41.718c18.252-10.755,34.222-5.215,50.518-5.215 c43.673,0,55.896-16.459,53.778-36.503C312.266,20.933,296.41-0.67,256,0.016C239.692,0.294,209.067,5.231,193.205,13.488z">
                                        </path>
                                        <path style="fill:#5A4146;"
                                            d="M190.164,63.246c0,0-5.54-21.837,10.755-44.489c-34.873,25.748-28.355,69.91-28.355,69.91 c10.43,10.43,10.43,36.503,10.43,36.503l10.43-10.43c0,0-4.025-30.127,15.645-41.718c18.252-10.755,34.222-5.215,50.518-5.215 c7.103,0,13.292-0.476,18.805-1.291C244.756,67.645,224.929,42.169,190.164,63.246z">
                                        </path>
                                        <path style="fill:#fdc48b;"
                                            d="M178.107,122.939l5.889,23.556c0.697,2.791,3.206,4.749,6.082,4.749l0,0 c3.161,0,5.828-2.355,6.221-5.492l3.011-24.093c0.806-6.443-4.218-12.134-10.711-12.134h-0.021 C181.556,109.527,176.403,116.126,178.107,122.939z">
                                        </path>
                                        <path style="fill:#5B5D6E;"
                                            d="M320.859,292.044h-30.636c-4.5,0-8.149,3.648-8.149,8.149v2.281h46.933v-2.281 C329.007,295.692,325.359,292.044,320.859,292.044z">
                                        </path>
                                        <path style="fill:#FFD782;"
                                            d="M291.311,512.001H220.69c-4.875,0-8.828-3.953-8.828-8.828v-35.31c0-4.875,3.953-8.828,8.828-8.828 h70.621c4.875,0,8.828,3.953,8.828,8.828v35.31C300.138,508.048,296.186,512.001,291.311,512.001z">
                                        </path>
                                        <path style="fill:#FFC36E;"
                                            d="M273.655,494.345h-35.31c-4.875,0-8.828-3.953-8.828-8.828l0,0c0-4.875,3.953-8.828,8.828-8.828 h35.31c4.875,0,8.828,3.953,8.828,8.828l0,0C282.483,490.393,278.53,494.345,273.655,494.345z">
                                        </path>
                                        <path style="fill:#C3E678;"
                                            d="M467.862,512.001h-70.621c-4.875,0-8.828-3.953-8.828-8.828v-35.31c0-4.875,3.953-8.828,8.828-8.828 h70.621c4.875,0,8.828,3.953,8.828,8.828v35.31C476.69,508.048,472.737,512.001,467.862,512.001z">
                                        </path>
                                        <path style="fill:#A5D76E;"
                                            d="M450.207,494.345h-35.31c-4.875,0-8.828-3.953-8.828-8.828l0,0c0-4.875,3.953-8.828,8.828-8.828 h35.31c4.875,0,8.828,3.953,8.828,8.828l0,0C459.035,490.393,455.082,494.345,450.207,494.345z">
                                        </path>
                                        <path style="fill:#FF6464;"
                                            d="M114.759,512.001H44.138c-4.875,0-8.828-3.953-8.828-8.828v-35.31c0-4.875,3.953-8.828,8.828-8.828 h70.621c4.875,0,8.828,3.953,8.828,8.828v35.31C123.586,508.048,119.634,512.001,114.759,512.001z">
                                        </path>
                                        <path style="fill:#D2555A;"
                                            d="M97.104,494.345h-35.31c-4.875,0-8.828-3.953-8.828-8.828l0,0c0-4.875,3.953-8.828,8.828-8.828h35.31 c4.875,0,8.828,3.953,8.828,8.828l0,0C105.931,490.393,101.979,494.345,97.104,494.345z">
                                        </path>
                                    </g>
                                </svg>

                                <span class="flex-1 ml-3 whitespace-nowrap">Supervisores</span>
                            </a>
                        </li> --}}
                        <li>
                            <a href="{{ route('accesos.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('accesos*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                <svg height="33"viewBox="0 0 64 64" id="Layer_1" version="1.1" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    fill="#000000">
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
                                            <path style="fill:#1A9172;" d="M24,42v0.375c0-0.126,0.013-0.251,0.034-0.375H24z">
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
                                            <path style="fill:#61B872;" d="M24,21v0.375c0-0.126,0.013-0.251,0.034-0.375H24z">
                                            </path>
                                            <path style="fill:#61B872;"
                                                d="M59.966,21C59.987,21.124,60,21.249,60,21.375V21H59.966z"></path>
                                        </g>
                                    </g>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">EDAS</span>
                            </a>
                        </li>
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
                        <div class="flex flex-col gap-2">
                            {{-- @foreach ($objetivosDesaprobados as $objetivoDesaprobado)
                            @php
                                $fechaFeedback = \Carbon\Carbon::parse($objetivoDesaprobado->feedback_fecha);
                                $diferencia = $fechaFeedback->diffForHumans();
                            @endphp
                            <a href="">
                                <div id="toast-notification"
                                    class="w-full max-w-xs p-2 text-gray-100 bg-neutral-700 rounded-lg shadow dark:bg-gray-800 dark:text-gray-300"
                                    role="alert">

                                    <div class="flex items-center">
                                        <div class="relative inline-block shrink-0">
                                            <img class="w-12 h-12 rounded-full" src="/default-user.webp"
                                                alt="Jese Leos image" />
                                            <span
                                                class="absolute bottom-0 right-0 inline-flex items-center justify-center w-6 h-6 bg-blue-600 rounded-full">
                                                <svg class="w-3 h-3 text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 18"
                                                    fill="currentColor">
                                                    <path
                                                        d="M18 4H16V9C16 10.0609 15.5786 11.0783 14.8284 11.8284C14.0783 12.5786 13.0609 13 12 13H9L6.846 14.615C7.17993 14.8628 7.58418 14.9977 8 15H11.667L15.4 17.8C15.5731 17.9298 15.7836 18 16 18C16.2652 18 16.5196 17.8946 16.7071 17.7071C16.8946 17.5196 17 17.2652 17 17V15H18C18.5304 15 19.0391 14.7893 19.4142 14.4142C19.7893 14.0391 20 13.5304 20 13V6C20 5.46957 19.7893 4.96086 19.4142 4.58579C19.0391 4.21071 18.5304 4 18 4Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M12 0H2C1.46957 0 0.960859 0.210714 0.585786 0.585786C0.210714 0.960859 0 1.46957 0 2V9C0 9.53043 0.210714 10.0391 0.585786 10.4142C0.960859 10.7893 1.46957 11 2 11H3V13C3 13.1857 3.05171 13.3678 3.14935 13.5257C3.24698 13.6837 3.38668 13.8114 3.55279 13.8944C3.71889 13.9775 3.90484 14.0126 4.08981 13.996C4.27477 13.9793 4.45143 13.9114 4.6 13.8L8.333 11H12C12.5304 11 13.0391 10.7893 13.4142 10.4142C13.7893 10.0391 14 9.53043 14 9V2C14 1.46957 13.7893 0.960859 13.4142 0.585786C13.0391 0.210714 12.5304 0 12 0Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="ml-3 text-sm font-normal">
                                            <div class="text-sm font-semibold text-gray-100">
                                                {{ $objetivoDesaprobado->supervisor->nombres }}
                                                {{ $objetivoDesaprobado->supervisor->apellidos }}
                                            </div>
                                            <div class="text-sm font-normal">Tienes un nuevo feedback</div>
                                            <span
                                                class="text-xs font-medium text-blue-600 dark:text-blue-500">{{ $diferencia }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach --}}
                        </div>
                        <li class="nav-item dropdown mt-auto">

                        </li>
                    </ul>
                </div>
            </aside>
        @endguest
        <main class="min-h-screen">
            @yield('content')
        </main>
    </div>
@endsection
