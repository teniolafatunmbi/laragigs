<x-layout>
    <div class="mx-4">
       <x-card class="p-10">
            <header>
                <h1 class="hover:cursor-pointer text-3xl text-center font-bold my-6 uppercase">
                    Manage Gigs
                </h1>
            </header>
        </x-card>
        <x-card class="my-4">
            <table class="w-full table-auto rounded-sm">
                <tbody>
                    @unless ($gigs->isEmpty())
                    @foreach ($gigs as $gig)                    
                        <tr class="border-gray-300">
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="/gigs/{{$gig->id}}/show">
                                    {{$gig->title}}
                                </a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="/gigs/{{$gig->id}}/edit" class="text-blue-400 px-6 py-2 rounded-xl">
                                    <i
                                        class="fa-solid fa-pen-to-square"
                                    ></i>
                                    Edit
                                </a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <form method="POST" action="/gigs/{{$gig->id}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">
                                        <i
                                            class="fa-solid fa-trash-can"
                                        ></i>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr> 
                    @endforeach
                    @else
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <p class="text-center">No Gig found</p>
                        </td>
                    </tr>
                    @endunless
                </tbody>
            </table>
        </x-card>
    </div>
</x-layout>