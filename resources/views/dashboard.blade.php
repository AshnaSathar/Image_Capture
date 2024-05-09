<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>
    <div class="text-gray-900 dark:text-gray-800">

        Device ID: <span id="deviceIdSpan"></span>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="uploadForm" action="{{ route('upload.image') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <div class="mb-4">
                                <button id="captureBtn" class="mr-2">Capture Image</button>
                            </div>
                            <div class="mb-4">
                                <input type="file" name="image" id="uploadInput" accept="image/*" class="mr-2" capture="user">
                                <button type="button" id="uploadBtn" class="mr-2" capture="user">Upload</button>
                            </div>
                            <div class="mb-4">
                                <button id="alertBtn">Show Alert</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
         var deviceId = localStorage.getItem('deviceId');
        
        // Display device ID in the span element
        var deviceIdSpan = document.getElementById('deviceIdSpan');
        deviceIdSpan.textContent = deviceId;

        // --------------
        const alertBtn = document.getElementById('alertBtn');
        const captureBtn = document.getElementById('captureBtn');
        const uploadInput = document.getElementById('uploadInput');
        const uploadBtn = document.getElementById('uploadBtn');
        
        alertBtn.addEventListener('click', showAlert);
        captureBtn.addEventListener('click', captureImage);
        uploadBtn.addEventListener('click', uploadImage);

        function showAlert(event) {
            event.preventDefault(); // Prevent default form submission behavior
            alert('Button clicked!'); // Display an alert box
        }

        function captureImage(event) {
            // Your captureImage function
            event.preventDefault(); // Prevent default form submission behavior
            alert('inside capture image function!'); 
        }

        function uploadImage() {
            const formData = new FormData();
            const file = uploadInput.files[0];
            formData.append('image', file);
            
            fetch('{{ route("upload.image") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json(); // Parse response JSON
                } else {
                    throw new Error('Failed to upload image.');
                }
            })
            .then(data => {
                alert(data.message); // Display success message
            })
            .catch(error => {
                console.error('Error uploading image:', error);
                alert('Failed to upload image. Please try again.'); // Display error message
            });
        }
    </script>
</x-app-layout>
