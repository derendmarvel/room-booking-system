<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 text-gray-800 dark:text-gray-200">

        <h1 class="text-2xl font-bold mb-6">
            Edit Equipment
        </h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('equipments.update', $equipment->id) }}"
              method="POST"
              class="space-y-5">

            @csrf
            @method('PUT')

            {{-- Equipment Code --}}
            <div>
                <x-input-label for="code" :value="__('Equipment Code')" />

                <x-text-input id="code"
                              class="block mt-1 w-full"
                              type="text"
                              name="code"
                              :value="old('code', $equipment->code)"
                              required />

                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            {{-- Equipment Name --}}
            <div>
                <x-input-label for="name" :value="__('Equipment Name')" />

                <x-text-input id="name"
                              class="block mt-1 w-full"
                              type="text"
                              name="name"
                              :value="old('name', $equipment->name)"
                              required />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Stock --}}
            <div>
                <x-input-label for="stock" :value="__('Stock')" />

                <x-text-input id="stock"
                              class="block mt-1 w-full"
                              type="number"
                              name="stock"
                              :value="old('stock', $equipment->stock)"
                              required />

                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
            </div>

            {{-- Category --}}
            <div>
                <x-input-label for="category" :value="__('Category')" />

                <select id="category"
                        name="category"
                        class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        required>

                    <option value="audio"
                        {{ old('category', $equipment->category) == 'audio' ? 'selected' : '' }}>
                        Audio
                    </option>

                    <option value="video"
                        {{ old('category', $equipment->category) == 'video' ? 'selected' : '' }}>
                        Video
                    </option>

                    <option value="accessory"
                        {{ old('category', $equipment->category) == 'accessory' ? 'selected' : '' }}>
                        Accessory
                    </option>

                    <option value="computer"
                        {{ old('category', $equipment->category) == 'computer' ? 'selected' : '' }}>
                        Computer
                    </option>

                    <option value="networking"
                        {{ old('category', $equipment->category) == 'networking' ? 'selected' : '' }}>
                        Networking
                    </option>

                </select>

                <x-input-error :messages="$errors->get('category')" class="mt-2" />
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end">
                <x-primary-button>
                    {{ __('Update Equipment') }}
                </x-primary-button>
            </div>

        </form>
    </div>
</x-app-layout>