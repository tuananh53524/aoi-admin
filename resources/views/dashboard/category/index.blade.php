<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="text-end">
            <a href="{{ route('category.create') }}">
                <button class="rounded-xl p-2 bg-blue-500 font-medium text-white">Thêm Danh mục</button>
            </a>
        </div>
        <div class="overflow-x-auto max-h-fit overflow-y-auto mt-4">
            <table class="min-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 sticky top-0 bg-gray-50 dark:bg-gray-700">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3 sticky top-0 bg-gray-50 dark:bg-gray-700">
                            Tên Danh Mục
                        </th>
                        <th scope="col" class="px-6 py-3 sticky top-0 bg-gray-50 dark:bg-gray-700">
                            Mô tả
                        </th>
                        <th scope="col" class="px-6 py-3 sticky top-0 bg-gray-50 dark:bg-gray-700">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($categories) > 0)
                        @foreach ($categories as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">
                                    {{ $item->id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->description }}
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('category.edit', $item->id) }}"><i class="fa-solid fa-pen-to-square font-medium text-blue-600"></i></a>
                                    <i class="fa-solid fa-trash font-medium text-red-600 cursor-pointer" onclick="confirmDelete({{ $item->id }})"></i>
                                    <!-- Hidden form for deletion -->
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('users.destroy', $item->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>