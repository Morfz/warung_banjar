<x-admin-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="flex m-2 p-2">
              <a href="{{ route('admin.reservations.index') }}" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg text-white">
                  Reservation Index
              </a>
          </div>
          <div class="m-2 p-2 bg-slate-100 rounded">
              <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                  <form method="POST" action="{{ route('admin.reservations.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="sm:col-span-6">
                      <label for="name" class="block text-sm font-medium text-gray-700"> Name </label>
                      <div class="mt-1">
                        <input type="text" id="name" name="name" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('name') border-red-400 @enderror" />
                      </div>
                      @error('name')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="sm:col-span-6">
                      <label for="email" class="block text-sm font-medium text-gray-700"> Email </label>
                      <div class="mt-1">
                        <input type="email" id="email" name="email" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('email') border-red-400 @enderror" />
                      </div>
                      @error('email')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="sm:col-span-6">
                      <label for="phone" class="block text-sm font-medium text-gray-700"> Phone </label>
                      <div class="mt-1">
                        <input type="text" id="phone" name="phone" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('phone') border-red-400 @enderror" />
                      </div>
                      @error('phone')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="sm:col-span-6">
                      <label for="date" class="block text-sm font-medium text-gray-700"> Date </label>
                      <div class="mt-1">
                        <input type="datetime-local" id="date" name="date" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('date') border-red-400 @enderror" />
                      </div>
                      @error('date')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="sm:col-span-6 pt-3">
                      <label for="guests" class="block text-sm font-medium text-gray-700"> Guest Number</label>
                      <div class="mt-1">
                        <input type="number" min="0" max="8" id="guests" name="guests" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('guests') border-red-400 @enderror" />
                      </div>
                      @error('guests')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="sm:col-span-6 pt-3">
                      <label for="table_id" class="block text-sm font-medium text-gray-700">Table</label>
                      <div class="mt-1">
                        <select id="table_id" name="table_id" class="shadow-sm focus:ring-indigo-500 appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('table_id') border-red-400 @enderror">
                          @foreach($tables as $table)
                            <option value="{{ $table->id }}">{{ $table->name }} ({{ $table->capacity }} Guests)</option>
                          @endforeach
                        </select>
                      </div>
                      @error('table_id')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <div class=" flex justify-end mt-2 p-2">
                        <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg text-white">Save</button>
                    </div>                      
                  </form>
                </div>
                
          </div>
      </div>
  </div>
</x-app-layout>
