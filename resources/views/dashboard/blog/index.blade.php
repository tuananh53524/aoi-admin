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
        <div class="flex justify-end gap-4">
            <div class="text-end">
                <a href="{{ route('blogs.create') }}">
                    <button class="rounded-xl p-2 bg-blue-500 font-medium text-white">Thêm Bài viết</button>
                </a>
            </div>
        </div>
        <form action="{{ route('blogs.index') }}" method="GET" class="p-4">
            <div class="flex gap-4 items-center">
                <div class="w-72">
                    <input type="text" id="title" name="title" value="{{ request('title') }}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="Tìm kiếm theo tiêu đề...">
                </div>
                <div class="w-48">
                    <select id="author" name="author_id" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Tất cả tác giả</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('author_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-48">
                    <select id="status" name="status" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Tất cả</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                </div>
        
                <div class="col-span-1 flex justify-start items-center">
                    <button type="submit" class="text-white bg-blue-600 p-2 rounded-lg">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
        </form>    

        <div class="overflow-x-auto max-h-fit overflow-y-auto">
            <table class="min-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-3 py-3 sticky top-0 bg-gray-50 dark:bg-gray-700">
                            Thumnail
                        </th>
                        <th scope="col" class="px-3 py-3 sticky top-0 bg-gray-50 dark:bg-gray-700">
                            Blog title
                        </th>
                        <th scope="col" class="px-3 py-3 sticky top-0 bg-gray-50 dark:bg-gray-700">
                            Category
                        </th>
                        <th scope="col" class="px-3 py-3 sticky top-0 bg-gray-50 dark:bg-gray-700">
                            Updated & Status
                        </th>
                        <th scope="col" class="px-3 py-3 sticky top-0 bg-gray-50 dark:bg-gray-700">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $blog)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-4 py-2">
                                <img src="{{ Storage::url($blog->thumbnail_url) }}" alt="Blog thumbnail" class="w-20 h-20 object-cover rounded h-[200px] w-[200px]">
                            </td>
                            <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">
                                {{ $blog->title }}
                                {{-- {{ route('blog.detail', ['category' => $blog->category->slug, 'slug' => $blog->slug]) }} --}}
                                <a href="#" target="_blank" class="ml-2 text-blue-600 hover:underline">
                                    <i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                {{ $blog->category->name }}
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex gap-2 items-center">
                                    Updated: {{ $blog->updated_at->format('d/m/Y H:i') }}
                                    <span class="px-2 py-1 rounded-full text-xs {{ $blog->status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $blog->status == 1 ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('blogs.edit', $blog->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        <i class="fa-solid fa-pen-to-square font-medium"></i>
                                    </a>
                                    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this blog?')">
                                            <i class="fa-solid fa-trash font-medium"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $blogs->links() }}
        </div>
    </div>
</x-app-layout>
