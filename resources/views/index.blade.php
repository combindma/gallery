@extends('dashui::layouts.app')
@section('title', 'Gallerie')
@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div x-data="{ open: false }" @keydown.window.escape="open = false" class="mb-4 border-b border-gray-200">
            <div class="pb-8 sm:flex sm:items-center sm:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                        Gallerie
                    </h1>
                </div>
                <div class="mt-4 flex sm:mt-0 sm:ml-4">
                    <button @click="open=true" type="button" class="btn">
                        Ajouter une image
                    </button>
                </div>
            </div>
            <div x-show="open" class="z-10 fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div x-show="open" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <section @click.away="open = false" class="absolute inset-y-0 right-0 pl-10 max-w-full flex sm:pl-16" aria-labelledby="slide-over-heading">
                        <div x-show="open" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                            class="bg-gray-500 bg-opacity-75 transition-opacity w-screen max-w-xl">
                            <div class="h-full divide-y divide-gray-200 flex flex-col bg-white shadow-xl overflow-y-scroll">
                                <div class="min-h-0 flex-1 flex flex-col overflow-y-scroll">
                                    <div class="py-6 px-4 bg-primary-700 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <h2 id="slide-over-heading" class="text-lg font-medium text-white">
                                                Ajouter une nouvelle image
                                            </h2>
                                            <div class="ml-3 h-7 flex items-center">
                                                <button @click="open=false" class="bg-primary-700 rounded-md text-primary-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                                    <span class="sr-only">Close panel</span>
                                                    <!-- Heroicon name: outline/x -->
                                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 relative flex-1 px-4 py-6 sm:px-6">
                                        <form id="form-action" action="{{ route('gallery::gallery.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                                <div class="px-4 py-5 sm:p-6">
                                                    <p class="form-legend mb-4">Media</p>
                                                    <div class="p-4 border-4 border-dashed border-gray-200 rounded-lg">
                                                        <input type="file" class="form-control" name="image" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 px-4 py-4 flex justify-end">
                                    <button @click="open=false" type="button" class="btn-subtle">
                                        Annuler
                                    </button>
                                    <button onclick="document.getElementById('form-action').submit();" type="submit" class="btn ml-3">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        @include('dashui::components.alert')
        @if ($gallery->isEmpty())
            @component('dashui::components.blank-state')
                @slot('icon')
                    <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                @endslot
                @slot('heading')
                    Liste vide
                @endslot
                    Aucune image trouvée
            @endcomponent
        @else
            <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                @foreach($gallery as $media)
                    <li class="relative mb-4">
                        <div class="block w-full aspect-w-10 aspect-h-7 rounded-lg overflow-hidden">
                            <img src="{{ $media->image_url() }}" alt="image">
                        </div>
                        <div class="mt-2 flex justify-between items-start" x-data="{ link: '{{ $media->image_url() }}' }">
                            <div>
                                <p class="block text-sm font-medium text-gray-900 truncate pointer-events-none">{{ $media->file_name }}</p>
                                <p class="block text-sm font-medium text-gray-500 pointer-events-none">{{ $media->file_size }}</p>
                            </div>
                            <button type="button" @click="$clipboard(link)" class="text-gray-400 hover:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"/>
                                    <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"/>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('gallery::gallery.destroy', $media) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-md text-sm font-medium text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">Supprimer</button>
                        </form>
                    </li>
                @endforeach
            </ul>

            @if($gallery->hasPages())
                <div class="mt-8 border-t border-gray-200 px-4 py-4 sm:px-6">
                    {{ $gallery->appends(request()->except('page'))->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
