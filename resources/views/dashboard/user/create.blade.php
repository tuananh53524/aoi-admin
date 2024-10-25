<x-app-layout>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Họ và Tên" required />
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="text" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Flowbite" required />
            </div>
            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone number</label>
                <input type="tel" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="+84" required />
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                               focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach (config('app.roles') as $roleKey => $roleValue)
                        <option value="{{ $roleValue }}">{{ ucfirst($roleKey) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="+84" required />
            </div>
            <div class="flex items-center">
                <input checked id="status" type="checkbox" name="status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="status" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Status</label>
            </div>
            <div class="mb-4">
                <div class="mb-4">
                    <label for="avatar" class="block text-sm font-medium text-gray-700">Avatar</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" class="mt-1 block w-full">
                </div>

                <div id="crop-popup" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
                    <div class="bg-white p-4 rounded-lg">
                        <div id="croppie-container" class="w-72 h-auto"></div>
                        <div>
                            <button type="button" id="crop-button" class="bg-blue-500 text-white px-4 py-2 rounded">Crop</button>
                            <button type="button" id="close-popup" class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Close</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="cropped_avatar" id="cropped_avatar">
                <div class="mt-4">
                    <div id="preview-cropped" class="mt-2">
                        <img id="cropped-preview" src="" alt="Cropped Image" class="hidden max-w-full h-auto rounded" />
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center mx-auto dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </div>
    </form>
</x-app-layout>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let croppieInstance;

        document.getElementById('avatar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                // Mở popup để crop
                document.getElementById('crop-popup').classList.remove('hidden');

                // Khởi tạo Croppie
                if (croppieInstance) croppieInstance.destroy();
                croppieInstance = new Croppie(document.getElementById('croppie-container'), {
                    viewport: {
                        width: 200,
                        height: 200,
                        type: 'circle'
                    },
                    boundary: {
                        width: 300,
                        height: 300
                    },
                    enableOrientation: true
                });

                // Bind ảnh vào Croppie
                croppieInstance.bind({
                    url: e.target.result
                });
            };
            reader.readAsDataURL(file);
        });

        document.getElementById('crop-button').addEventListener('click', function() {
            croppieInstance.result({
                type: 'base64',
                size: 'viewport'
            }).then(function(croppedImage) {
                // Cập nhật giá trị cho input ẩn
                document.getElementById('cropped_avatar').value = croppedImage;

                // Hiển thị preview của ảnh đã cắt
                const croppedPreview = document.getElementById('cropped-preview');
                croppedPreview.src = croppedImage;
                croppedPreview.classList.remove('hidden'); // Hiện ảnh đã cắt

                // Đóng popup
                document.getElementById('crop-popup').classList.add('hidden');
            });
        });

        document.getElementById('close-popup').addEventListener('click', function() {
            // Đóng popup
            document.getElementById('crop-popup').classList.add('hidden');
        });
    });
</script>
