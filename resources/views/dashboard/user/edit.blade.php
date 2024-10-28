<x-app-layout>
    @if(session('Error'))
    <div class="alert alert-danger">{{ session('Error') }}</div>
    @endif
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Thêm phương thức PUT -->
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Họ và Tên" required />
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="text" id="email" name="email" value="{{ old('email', $user->email) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Flowbite" required />
            </div>
            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone number</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="+84" required />
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                               focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach (config('app.roles') as $roleKey => $roleValue)
                        <option value="{{ $roleValue }}" {{ $roleValue == $user->role ? 'selected' : '' }}>{{ ucfirst($roleKey) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nhập mật khẩu mới (nếu muốn)" />
            </div>
            <div class="flex items-center">
                <input id="status" type="checkbox" name="status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $user->status ? 'checked' : '' }}>
                <label for="status" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Status</label>
            </div>
            <div>
                <div class="mb-4">
                    <label for="avatar" class="block text-sm font-medium text-gray-700">Avatar</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" class="mt-1 block w-full">
                </div>
                @if ($user->avatar)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="h-32 w-32 object-cover rounded">
                    </div>
                @endif
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
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center mx-auto dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
        </div>
    </form>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let croppieInstance;

        document.getElementById('avatar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                if (croppieInstance) {
                    croppieInstance.destroy();
                }

                document.getElementById('crop-popup').classList.remove('hidden');

                croppieInstance = new Croppie(document.getElementById('croppie-container'), {
                    viewport: {
                        width: 200,
                        height: 200,
                        type: 'circle',
                    },
                    boundary: {
                        width: 300,
                        height: 300
                    },
                    showZoomer: true
                });
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
                document.getElementById('cropped_avatar').value = croppedImage;
                document.getElementById('cropped-preview').src = croppedImage;
                document.getElementById('cropped-preview').classList.remove('hidden');
                document.getElementById('crop-popup').classList.add('hidden');
                croppieInstance.destroy();
            });
        });

        document.getElementById('close-popup').addEventListener('click', function() {
            document.getElementById('crop-popup').classList.add('hidden');
            if (croppieInstance) {
                croppieInstance.destroy();
            }
        });
    });
</script>
