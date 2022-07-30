<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-success-message />
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="flex items-center justify-end mt-4 mb-4">
                                    <a href="{{ route('categories.create') }}">
                                        <x-button class="ml-3">
                                            {{ __('Add Category') }}
                                        </x-button>
                                    </a>
                                </div>
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="order_list">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-base font-bold text-gray-500 uppercase tracking-wider">
                                                    Name
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-right text-base font-bold text-gray-500 uppercase tracking-wider">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                                        {{ $category->name }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
                                                        <div class="flex items-center justify-end gap-4">
                                                            <a href="{{ route('categories.edit', $category) }}"
                                                                class="text-green-600 hover:text-indigo-900"
                                                                style="margin-right: 16px">
                                                                <x-button class="ml-3">
                                                                    {{ __('Edit') }}
                                                                </x-button>
                                                            </a>
                                                            {{-- <a href="{{ route('categories.destroy', $category) }}"
                                                            class="text-red-600 hover:text-indigo-900">Delete</a> --}}
                                                            <form class="" method="POST"
                                                                action="{{ route('categories.destroy', $category) }}"
                                                                onsubmit="return confirm('Are you sure?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <x-button type="submit">Delete</x-button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                <div class="mt-4">
                                    {{ $categories->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
