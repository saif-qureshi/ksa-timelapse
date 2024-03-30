<x-admin.layout title="Dashboard">
    <div class="container mx-auto mt-10">
        <div class="grid grid-cols-2 gap-4 mt-5">
            <div class="stat-card col-span-1 shadow-md bg-white p-4 rounded-lg">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="stat-content">
                        <h2 class="font-bold text-lg">Projects</h2>
                        <p>{{$projects}}</p>
                    </div>
                    <div class="stat-icon">
                        <div class="p-2 rounded-full bg-blue-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="stat-card col-span-1 shadow-md bg-white p-4 rounded-lg">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="stat-content">
                        <h2 class="font-bold text-lg">Cameras</h2>
                        <p>{{$cameras}}</p>
                    </div>
                    <div class="stat-icon">
                        <div class="p-2 rounded-full bg-green-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin.layout>
