<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg mt-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Upload Excel File</h1>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('errors'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <strong class="font-bold">Errors:</strong>
                <ul class="mt-2 px-4 list-disc list-inside">
                    @foreach ($errors->get('errors') as $errors)
                        @if (is_array($errors))
                            @foreach ($errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @else
                            <li>{{ $errors }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="excel_file" class="block text-sm font-medium text-gray-700">Excel File</label>
                <input type="file" name="excel_file" id="excel_file"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Upload
            </button>
        </form>
    </div>
</x-app-layout>
