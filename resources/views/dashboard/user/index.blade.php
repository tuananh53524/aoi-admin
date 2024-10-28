<x-app-layout>
    @if (session('Success'))
        <div id="toast-success" class="flex items-center w-full max-w-xs p-4 mb-4 mx-auto text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Check icon</span>
            </div>
            <div class=""ms-3 text-sm font-normal">{{ session('Success') }}</div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="text-end">
            <a href="{{ route('users.create') }}">
                <button class="rounded-xl p-2 bg-blue-500 font-medium text-white">Thêm user</button>
            </a>
        </div>
        <form action="{{ route('users.index') }}" method="GET" class="p-4">
            <div class="pb-4 dark:bg-gray-900">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <input type="text" name="name" id="table-search" class="block pt-2 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search By Name">
                </div>
            </div>
            <button type="submit">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </button>
        </form>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        phone
                    </th>
                    <th scope="col" class="px-6 py-3">
                        role
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (count($users) > 0)
                    @foreach ($users as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $item->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->phone ?? 'chưa có' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $roles[$item->role] ?? 'Unknown role' }}
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('users.edit', $item->id) }}"><i class="fa-solid fa-pen-to-square font-medium text-blue-600"></i></a>
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

        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this user?")) {
            // Submit the delete form if confirmed
            document.getElementById(`delete-form-${id}`).submit();
        }
    }
</script>
