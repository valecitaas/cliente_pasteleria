{{-- @extends('/layouts/layout')

@section('contenido') --}}
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>  
                <th scope="col" class="px-6 py-3">
                    name
                </th>
                <th scope="col" class="px-6 py-3">
                   description
                </th>
                <th scope="col" class="px-6 py-3">
                    image 1
                </th>
                <th scope="col" class="px-6 py-3">
                    image 2
                </th>
                <th scope="col" class="px-6 py-3">
                    image 3
                </th>
                <th scope="col" class="px-6 py-3">
                    price
                </th>
                <th scope="col" class="px-6 py-3">
                    stock
                </th>
                <th scope="col" class="px-6 py-3">
                    discount
                </th>
                <th scope="col" class="px-6 py-3">
                    status
                </th>
                <td class="px-6 py-4">
                    <span class="sr-only">Edit</span>
                </td>
                <td class="px-6 py-4">
                    <span class="sr-only">Delete</span>
                </td>
            </tr>
            </tr>
        </thead>
            <tbody>
                @foreach ($products as $item)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{$item ['name']}} 
                    </td>
                    <td class="px-6 py-4">
                        {{$item ['description']}}
                    </td>
                    <td class="px-6 py-4">
                        <img src="{{$item['image1']}}" alt="{{$item ['image1']}}" width="50px">
                    </td>
                    <td class="px-6 py-4">
                        <img src="{{$item ['image2']}}" alt="{{$item['image2']}}" width="50px">
                    </td>
                    <td class="px-6 py-4">
                        <img src="{{$item ['image3']}}" alt="{{$item['image3']}}" width="50px">
                    </td>
                    <td class="px-6 py-4">
                        {{$item ['price']}}
                    </td> 
                    <td class="px-6 py-4">
                        {{$item ['stock']}}
                    </td> 
                    <td class="px-6 py-4">
                        {{$item ['discount']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$item ['status']}}
                    </td>
                    <td class="px-6 py-4">
                        <a href="/products/editar/{{ $item['id'] }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td>
                    <td class="px-6 py-4">
                        <a href="/products/mostrar/{{ $item['id'] }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>
  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script> 
