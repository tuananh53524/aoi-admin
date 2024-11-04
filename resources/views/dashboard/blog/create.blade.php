<x-app-layout>
    <div class="mx-auto mt-5">
        <h1 class="text-2xl font-bold mb-4">Tạo bài viết mới</h1>
        <form action="{{ route('category.store') }}" method="POST">
            @csrf
            <div class="flex gap-6">
                <div class="basis-3/4">
                    <div class="mb-5">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên bài viết</label>
                        <input type="text" id="title" name="title" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="mb-5">
                        <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Url</label>
                        <input type="text" id="slug" name="slug" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="mb-5 flex justify-start items-center gap-10 w-full">
                        <!-- Danh Mục (Category) -->
                        <div class="basis-1/4">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Danh Mục</label>
                            <select id="category" name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Chọn danh mục</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tác Giả (Author) -->
                        <div class="basis-1/4">
                            <label for="author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tác Giả</label>
                            <select id="author" name="author_id" class="bg-gray-50 border overflow-auto border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option class="overflow-y-scroll" value="">Chọn tác giả</option>
                                @foreach ($authors as $author)
                                    <option class="overflow-y-scroll" value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Trạng Thái (Active) -->
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="status" name="status" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="status" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Status</label>
                        </div>

                        <!-- Đặc Biệt (Featured) -->
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="feature" name="feature" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="feature" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Featured</label>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea id="description" name="description" rows="3" class="block w-full p-2.5 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                    </div>
                    <div class="mb-5">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tags</label>
                        <input type="text" id="tags" name="tags" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="mb-5">
                        <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content</label>
                        <textarea id="content" name="content" rows="30" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..."></textarea>
                    </div>
                    <div class="mb-5">
                        <label for="meta title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Meta Title</label>
                        <input type="text" id="meta-title" name="meta_title" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="mb-5">
                        <label for="meta description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Meta Description</label>
                        <textarea id="meta-description" name="meta_description" rows="3" class="block w-full p-2.5 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                    </div>
                </div>

                <div class="basis-1/4 text-center">
                    <div class="mt-2 mb-4">
                        <img id="thumbnail-preview" src="{{ asset('/images/common/user-avatar.webp') }}" alt="Thumbnail Preview" class=" mx-auto w-64 h-64 object-cover rounded-lg mt-2" />
                    </div>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="hidden" onchange="previewImage(event,'thumbnail-preview')">
                    <label for="thumbnail" class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                        thumbnail upload
                    </label>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="w-fit px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
<script>
    document.getElementById('title').addEventListener('input', function() {
        const title = this.value;
        const slug = title
            .toLowerCase()
            .normalize('NFD') // Loại bỏ dấu tiếng Việt
            .replace(/[\u0300-\u036f]/g, '') // Loại bỏ ký tự đặc biệt
            .replace(/[^a-z0-9 -]/g, '') // Chỉ giữ lại ký tự a-z, 0-9, dấu cách
            .replace(/\s+/g, '-') // Thay dấu cách bằng dấu gạch ngang
            .replace(/-+/g, '-') // Loại bỏ các dấu gạch ngang liên tiếp
            .replace(/^-|-$/g, ''); // Loại bỏ dấu gạch ngang ở đầu và cuối
        document.getElementById('slug').value = slug;
    });
</script>
